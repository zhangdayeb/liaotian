<?php
/**
 * Created by IntelliJ IDEA.
 * User: Administrator
 * Date: 2020-06-12
 * Time: 15:03
 */

namespace extend\service;


use app\im\model\mongo\Chat;
use app\im\model\mongo\ChatGroup;
use app\im\model\mongo\ChatList;
use app\im\model\mongo\ChatMember;
use app\im\model\mongo\HongBao;
use app\im\model\mongo\HongBaoDetails;
use app\im\model\mysql\CapitalLog;
use app\im\model\mysql\User;
use app\im\model\mysql\VendorSetting;
use app\im\model\mysql\VendorUser;
use extend\traits\EquipRedPacket;
use function GuzzleHttp\Psr7\str;
use think\Exception;
use think\facade\Log;
use think\route\Resource;

class HongBaoService
{
    use EquipRedPacket;

    const NORMAL_BIGRED = 1; //普通红包
    const BEST_BIGRED = 2;  //拼手气红包
    const MIN_AMOUNT = 0.01;  //红包的最小金额
    const MAX_AMOUNT = 9999;  //红包的最大金额

    /**
     * [type:类型,num:数量,amount:金额,user_id:用户ID,list_id:会话ID,'msg':红包封面文字]
     * type生成红包 1 = 普通红包 ,2= 拼手气
     * @param array $params
     * @return array
     */
    public static function createHongbao(array $params = [])
    {
        if (!in_array($params['type'], [self::NORMAL_BIGRED, self::BEST_BIGRED])) {
            return JsonDataService::fail('未知红包类型!');
        }
        $user_info = UserService::getUserInfo($params['user_id']);
//        if(!check_password($params['trade_password'],$user_info['trade_password'])) return JsonDataService::fail('交易密码不正确!');
        //判断输入的金额
        //防止同一时间内连续发红包
        $flat = RedisService::setnx(ConfigService::HONGBAO_FAST_SEND_KEY . $params['list_id'], 1, 5);
        if (!$flat) return JsonDataService::fail('您操作太快了,请稍后再试!');
        if ($params['type'] == self::NORMAL_BIGRED)
            return self::createNormalRed($params);
        return self::createBestRed($params);
    }

    //创建普通红包
    public static function createNormalRed(array $params = [])
    {
        if ($params['amount'] < self::MIN_AMOUNT) {
            return JsonDataService::fail('最少' . self::MIN_AMOUNT . '元!');
        }
        $total_amount = bcmul($params['amount'], $params['num'], 2);
        if ($total_amount > self::MAX_AMOUNT) {
            return JsonDataService::fail('总金额不能超高过' . self::MAX_AMOUNT . '元!');
        }
        //根据list_id查找会话
        $chat_list = ChatList::field('id,type,status,user_ids')->where('list_id', $params['list_id'])->find();
        if (empty($chat_list)) return JsonDataService::fail('会话不存在!');
        //校验用户金额是否足够
        $user_info = UserService::canPayAmount($params['user_id'], $total_amount);
        if (!JsonDataService::checkRes($user_info)) return $user_info;

        $hongbao_msg = $params['msg'] ?? '恭喜发财大吉大利';
        //减钱
        $can = UserService::setDecAmount($params['user_id'], $total_amount);
        if (!JsonDataService::checkRes($can)) return $can;
        $capital = CapitalLog::create([
            'user_id' => $params['user_id'],
            'money' => $params['amount'],
            'user_money' => bcsub($user_info['data']['money'], $params['amount'], 3),
            'explain' => '发送红包支出',
        ]);

        $chat_obj = Chat::createChatMsg([
            'list_id' => $params['list_id'],
            'user_id' => $params['user_id'],
            'content_type' => 5,    //红包消息
            'msg_type' => 0,      //用户红包
            'content' => json_encode(['text' => $hongbao_msg], 256),
            'time' => time(),
        ]);

        //step2 插入红包记录
        $hongbao = HongBao::create([
            'list_id' => $params['list_id'],
            'chat_id' => $chat_obj->id,
            'msg' => $params['msg'], //红包标题
            'user_id' => $params['user_id'],
            'single_money' => $total_amount, //单个红包金额0是随机, >0是固定金额的红包
            'money' => floatval($total_amount), //总金额
            'number' => intval($params['num']), //总数量
            'sy_money' => floatval($total_amount), //剩余金额
            'sy_number' => intval($params['num']), //剩余數量
            'time' => time(), //剩余金额
            'generate_desc' => json_encode(array_fill(0, $params['num'], $params['amount']), 256)
        ]);
        //更新聊天列表
        $content = [
            'rid' => $hongbao->id,
            'blessing' => $hongbao_msg,
            'money' => $total_amount,
            'isReceived' => 0,
            'face' => $user_info['data']['face'],
            'from' => $user_info['data']['nickname']
        ];
        Chat::where(['id' => $chat_obj->id])->update(['content' => $content]);
        //开始生成普通红包
        for ($len = 1; $len <= $params['num']; $len++) {
            //红包健放入redis 防止并发
            RedisService::lPush(ConfigService::HONGBAO_NORMAL . $hongbao->id, $len);
            //将红包值放入redis 领取红包
            RedisService::lPush(ConfigService::HONGBAO_NORMAL . $params['list_id'] . ":" . $hongbao->id, $params['amount']);
        }
        //发送消息
        $send_info = MsgService::sendMsg([
            'user_id' => $params['user_id'],
            'list_id' => $params['list_id'],
            'action' => 'chatData',
            'sendData' => [
                'list_id' => $params['list_id'],
                'data' => [
                    'type' => 0,
                    'msg' => [
                        'id' => $chat_obj->id,
                        'type' => 5, //红包消息
                        'time' => time(),
                        'user_info' => [
                            'uid' => $params['user_id'],
                            'name' => $user_info['data']['nickname'],
							'face' => $user_info['data']['face']
                        ],
                        'content' => $content,
                    ],
                ]
            ]
        ]);
        return $send_info;
    }

    //创建拼手气红包
    public static function createBestRed(array $params = [])
    {
        if ($params['amount'] < self::MIN_AMOUNT) {
            return JsonDataService::fail('最少' . self::MIN_AMOUNT . '元!');
        }
        if ($params['amount'] > self::MAX_AMOUNT) {
            return JsonDataService::fail('总金额不能超高过' . self::MAX_AMOUNT . '元!');
        }
        //根据list_id查找会话
        $chat_list = ChatList::field('id,type,status,user_ids')->where('list_id', $params['list_id'])->find();
        if (empty($chat_list)) return JsonDataService::fail('会话不存在!');
        //校验用户金额是否足够
        $user_info = UserService::canPayAmount($params['user_id'], $params['amount']);
        if (!JsonDataService::checkRes($user_info)) return $user_info;

        $hongbao_msg = $params['msg'] ?? '恭喜发财大吉大利';
        //减钱
        $can = UserService::setDecAmount($params['user_id'], $params['amount']);
        if (!JsonDataService::checkRes($can)) return $can;
        //插入资金流水
        $capital = CapitalLog::create([
            'user_id' => $params['user_id'],
            'money' => $params['amount'],
            'user_money' => bcsub($user_info['data']['money'], $params['amount'], 3),
            'explain' => '发送红包支出',
        ]);
        $chat_obj = Chat::createChatMsg([
            'list_id' => $params['list_id'],
            'user_id' => $params['user_id'],
            'content_type' => 5,    //红包消息
            'msg_type' => 0,      //用户红包
            'content' => json_encode(['text' => $hongbao_msg], 256),
            'time' => time(),
        ]);
        //step2 插入红包记录
        //生成红包
        $packets = (new self())->init($params['amount'], $params['num'])->handle();

        $hongbao = HongBao::create([
            'list_id' => $params['list_id'],
            'chat_id' => $chat_obj->id,
            'user_id' => $params['user_id'],
            'msg' => $params['msg'],        //红包标题
            'single_money' => 0,             //单个红包金额0是随机, >0是固定金额的红包
            'money' => floatval($params['amount']),    //总金额
            'number' => intval($params['num']),      //总数量
            'sy_money' => floatval($params['amount']), //剩余金额
            'sy_number' => intval($params['num']), //剩余數量
            'time' => time(), //剩余金额
            'lei_info' => $params['lei_info'] ?? '', //剩余金额
            'generate_desc' => json_encode($packets, 256)
        ]);
        //更新聊天列表
        $content = [
            'rid' => $hongbao->id,
            'blessing' => $hongbao_msg,
            'isReceived' => 0,
            'money' => floatval($params['amount']),
            'from' => $user_info['data']['nickname'],
            'face' => $user_info['data']['face']
        ];
        Chat::where(['id' => $chat_obj->id])->update(['content' => $content]);
        //红包让人redis
        for ($i = 0; $i < count($packets); $i++) {
//            if($max_packets == $packets[$i]){
//                //将红包放入redis
//            }
            RedisService::lPush(ConfigService::HONGBAO_BEST . $hongbao->id, $i + 1);
            RedisService::lPush(ConfigService::HONGBAO_BEST . $params['list_id'] . ":" . $hongbao->id, $packets[$i]);
        }
        //发送消息
        $send_info = MsgService::sendMsg([
            'user_id' => $params['user_id'],
            'list_id' => $params['list_id'],
            'action' => 'chatData',
            'sendData' => [
                'list_id' => $params['list_id'],
                'data' => [
                    'type' => 0,
                    'msg' => [
                        'id' => $chat_obj->id,
                        'type' => 5, //红包消息
                        'time' => time(),
                        'user_info' => [
                            'uid' => $params['user_id'],
                            'name' => $user_info['data']['nickname'],
							'face' => $user_info['data']['face']
                        ],
                        'content' => $content,
                    ],
                ]
            ]
        ]);
        return $send_info;
    }

    /**
     * 领取红包
     * [rid'红包ID','user_id':'用户ID']
     */
    public static function getHongBao(array $params)
    {
        //1.判断包存不存在
        //2.判断用户是否在会话之中
        //3.红包是否被抢完
        //4.拆包
        //5.发送抢包通知
        $hongbao = HongBao::get($params['rid']);
        $user_info = UserService::getUserInfo($params['user_id']);
        if (empty($user_info)) return JsonDataService::fail('用户信息不存在!');
        if (empty($hongbao)) return JsonDataService::fail('红包已过期或不存在!');
        $hongbao_end_time = strtotime("+1 days",strtotime(date('Y-m-d H:i:s',$hongbao['time'])));
        if(time() > $hongbao_end_time)  return JsonDataService::fail('该红包已过期!');
        $redis_key = $hongbao['single_money'] > 0 ? ConfigService::HONGBAO_NORMAL : ConfigService::HONGBAO_BEST;
        if ($hongbao['sy_money'] <= 0) JsonDataService::fail('该红包已被领取完!');
        if ($hongbao['sy_number'] <= 0 || $hongbao['sy_money'] <= 0) JsonDataService::fail('该红包已被领取完!');
        //根据list_id查找会话
        $chat_list = ChatList::field('id,type,status,user_ids')->where('list_id', $hongbao['list_id'])->find();
        if (empty($chat_list)) return JsonDataService::fail('会话不存在!');
        $user_ids = is_array($chat_list['user_ids']) ? $chat_list['user_ids'] : json_decode($chat_list['user_ids'], true);
        if (!in_array($params['user_id'], $user_ids))
            return JsonDataService::fail('您没有权限领取该红包');
        //判断用户有没有领取过改红包
        $res = HongBaoDetails::where(['hongbao_id' => $params['rid'], 'user_id' => $params['user_id']])->find();
        if ($res) return JsonDataService::fail('您已经领取了该红包!');
        //判断红包从队列判断
        if (RedisService::llen($redis_key . $hongbao['id']) <= 0) return JsonDataService::fail('该红包已被领取完!');
        $click_num = RedisService::rPop($redis_key . $hongbao['id']);
        if (empty($click_num)) return JsonDataService::fail('该红包已被领取完!');
        //取出一个红包开始消费
        $big_red_amount = RedisService::rPop($redis_key . $hongbao['list_id'] . ":" . $hongbao['id']);
        if ($big_red_amount <= 0) return JsonDataService::fail('红包异常,领取失败!');
        //更新红包表
//        Db::startTrans();
        try {
            //exp
            $res_0 = HongBao::where(['id' => $params['rid']])->setDec('sy_money', floatval($big_red_amount));
            $res_1 = HongBao::where(['id' => $params['rid']])->setDec('sy_number', 1);
            if ($res_0 === false) throw new Exception('领取红包失败!【0】');
            if ($res_1 === false) throw new Exception('领取红包失败!【1】');
            $generate_desc = json_decode($hongbao['generate_desc'], true);
            $is_best = 0;
            if ($big_red_amount == max($generate_desc)) $is_best = 1;
            $res_2 = HongBaoDetails::create([
                'hongbao_id' => $hongbao['id'],
                'chat_id' => $chat_list['id'],
                'user_id' => $params['user_id'],
                'money' => $big_red_amount,
                'time' => time(),
                'is_best' => $is_best
            ]);
            if ($res_2 === false) throw new Exception('领取红包失败【2】');
            //加钱
            $res_3 = User::where(['id' => $params['user_id']])->setInc('money', floatval($big_red_amount));
            if ($res_3 === false) throw new Exception('领取红包失败【3】');
            //插入资金流水
            $res_4 = CapitalLog::create([
                'user_id' => $params['user_id'],
                'money' => $big_red_amount,
                'record_type' => 1, //收入
                'user_money' => bcadd($user_info['money'], floatval($big_red_amount), 3),
                'explain' => '收到红包',
            ]);
            if ($res_4 === false) throw new Exception('领取红包失败【4】');
        } catch (Exception $e) {
            //向队列中补齐失败的红包
            RedisService::rPush($redis_key . $params['rid'], $click_num);
            RedisService::rPush($redis_key . $hongbao['list_id'] . ":" . $hongbao['id'], $big_red_amount);
//            Db::rollback();
            return JsonDataService::fail($e->getMessage() . "__LINE__:" . __LINE__);
        }
//        Db::commit();
        //发送系统通知
        $content = [
            'nickname' => $user_info['nickname'],
            'text' => $user_info['nickname'] . '领取了红包!',
            'rid' => $params['rid'],
            'user_id' => $params['user_id'],
            'rid_user_id' => $hongbao['user_id']
        ];
        $chat = Chat::createSysMsg([
            'list_id' => $hongbao['list_id'],
            'user_id' => $params['user_id'],
            'content_type' => 5,
            'content' => $content,
        ]);
        $user = UserService::getUserInfo($params['user_id']);
        //MQ发送通知
        MsgService::sendChatDataMsgToAll($hongbao['list_id'], $params['user_id'], $chat->id, 5, $content, 1);
        return JsonDataService::success('抢包成功', $user);
    }

    /**
     * 红包领取详情
     * @param array $params
     */
    public static function getHongBaoDetail(array $params)
    {
        $user_id = $params['user_id'];
        $rid = $params['rid'];
        $hongBao_info = HongBao::get($rid);
        if (empty($hongBao_info)) return JsonDataService::fail('红包信息不存在!');
        $list = HongBaoDetails::where(['hongbao_id' => $rid])->select()->toArray();
        $user_get = ['money' => 0];
        if ($list) {
            foreach ($list as &$v) {
                $v['user_info'] = UserService::getUserInfo($v['user_id']);
                if ($v['user_id'] == $user_id) $user_get = $v;
            }
        }
        return JsonDataService::success('success', ['user_get' => $user_get, 'list' => $list, 'hong_bao_detail' => $hongBao_info, 'own_user_info' => UserService::getUserInfo($hongBao_info['user_id'])]);
    }

    /**
     * 生成累红包 带控制
     * @param $params
     * @return array
     * @throws Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\db\exception\PDOException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public static function createLeiHongBao($params,$robot = 0)
    {
        $flat = RedisService::setnx(ConfigService::HONGBAO_FAST_SEND_KEY . $params['list_id'], 1, 5);
        if (!$flat) return JsonDataService::fail('您操作太快了,请稍后再试!');
        if ($params['amount'] < self::MIN_AMOUNT) {
            return JsonDataService::fail('最少' . self::MIN_AMOUNT . '元!');
        }
        if ($params['amount'] > self::MAX_AMOUNT) {
            return JsonDataService::fail('总金额不能超高过' . self::MAX_AMOUNT . '元!');
        }
        //根据list_id查找会话
        $chat_list = ChatList::field('id,type,status,user_ids')->where('list_id', $params['list_id'])->find();
        if (empty($chat_list)) return JsonDataService::fail('会话不存在!');
        //只有群才能玩红包雷
        $chat_group = ChatGroup::where(['list_id' => $params['list_id']])->find();
        if (!$chat_group) return JsonDataService::fail('群组信息不存在!');
        //校验用户金额是否足够
        $vendor_user_info = VendorUser::where(['list_id' => $params['list_id'], 'status' => 1])->find();
        if (!$vendor_user_info || $vendor_user_info['status'] != 1) return JsonDataService::fail('该插件未启用!');
        $ret = self::getWinBeiLv($vendor_user_info['id'], ['lei_info' => $params['lei_info'], 'number' => $params['num'], 'money' => $params['amount']]);
        if (!JsonDataService::checkRes($ret)) return $ret;
        $user_info = UserService::canPayAmount($params['user_id'], $params['amount']);
        if (!JsonDataService::checkRes($user_info)) return $user_info;

        $hongbao_msg = $params['msg'] ?? '恭喜发财大吉大利';
        //减钱
        $can = UserService::setDecAmount($params['user_id'], $params['amount']);
        if (!JsonDataService::checkRes($can)) return $can;

        $chat_obj = Chat::createChatMsg([
            'list_id' => $params['list_id'],
            'user_id' => $params['user_id'],
            'content_type' => 5,    //红包消息
            'msg_type' => 0,      //用户红包
            'content' => json_encode(['text' => $hongbao_msg], 256),
            'time' => time(),
        ]);
        //step2 插入红包记录
        //生成红包
        //判断是否是系统账户

        $vendor_info = $params['vendor_info'];
        $rebot_arr = explode(',', $vendor_info['fuli_account']);
        $is_robot = 0;
        if ($rebot_arr && in_array($user_info['data']['username'], $rebot_arr)) {
            $is_robot = 1;
        }
        Log::info('is_robot:'.$is_robot);
        //福利帐号赢钱概率 防止用户输错
        $full_account_rate = $vendor_info['fuli_account_rate'] > 1 ? bcdiv($vendor_info['fuli_account_rate'], 100, 2) : $vendor_info['fuli_account_rate'];
        //用户赢钱概率  防止用户输错
        $win_amount_rate = $vendor_info['win_amount_rate'] > 1 ? bcdiv($vendor_info['win_amount_rate'], 100, 2) : $vendor_info['win_amount_rate'];
        //计算用户每天赢的钱
        //没有设置则走默认
        $full_account_rate = $full_account_rate <= 0 ? 0.8 : $full_account_rate;
        $win_amount_rate = $win_amount_rate <= 0 ? 0.2 : $win_amount_rate;
        $amount = self::getUserDayWinByGroupId(['user_id' => $params['user_id'], 'order_id' => $chat_group['id']]);
        //如果大于流水则输钱
        $loss = ($amount >= $vendor_info['win_amount']);
        $packets = createCanRedPacket([
            'red_lei' => json_decode($params['lei_info'], true),
            'red_nums' => intval($params['num']),
            'full_account_rate' => floatval($full_account_rate),  //系统用户赢钱概率
            'win_amount_rate' => floatval($win_amount_rate),      //正常用户赢钱概率
            'red_amount' => floatval($params['amount']),
            'loss' => $loss
        ], 0, $is_robot);
        Log::info('packets:'.print_r($packets,true));
//        $packets = (new self())->init($params['amount'], $params['num'])->handle();

        $hongbao = HongBao::create([
            'list_id' => $params['list_id'],
            'chat_id' => $chat_obj->id,
            'user_id' => $params['user_id'],
            'is_robot' => $robot,
            'vendor_user_id' => $vendor_info['id'],
            'msg' => $params['msg'],        //红包标题
            'single_money' => 0,             //单个红包金额0是随机, >0是固定金额的红包
            'money' => floatval($params['amount']),    //总金额
            'number' => intval($params['num']),      //总数量
            'sy_money' => floatval($params['amount']), //剩余金额
            'sy_number' => intval($params['num']), //剩余數量
            'time' => time(), //剩余金额
            'lei_info' => $params['lei_info'] ?? '', //剩余金额
            'generate_desc' => json_encode($packets, 256),
        ]);
        //插入资金流水
        $capital = CapitalLog::create([
            'user_id' => $params['user_id'],
            'money' => $params['amount'],
            'order_id' => $chat_group['id'], //
            'relation_id' => $hongbao->id,
            'user_money' => bcsub($user_info['data']['money'], $params['amount'], 3),
            'explain' => '发送红包支出',
            'capital_type' => 10,  //红包雷支出
        ]);
        //更新聊天列表
        $content = [
            'rid' => $hongbao->id,
            'blessing' => $hongbao_msg,
            'isReceived' => 0,
            'money' => floatval($params['amount']),
            'from' => $user_info['data']['nickname'],
            'face' => $user_info['data']['face']
        ];
        Chat::where(['id' => $chat_obj->id])->update(['content' => $content]);
        //红包让人redis
        for ($i = 0; $i < count($packets); $i++) {
//            if($max_packets == $packets[$i]){
//                //将红包放入redis
//            }
            RedisService::lPush(ConfigService::HONGBAO_BEST . $hongbao->id, $i + 1);
            RedisService::lPush(ConfigService::HONGBAO_BEST . $params['list_id'] . ":" . $hongbao->id, $packets[$i]);
        }
        $lei['red_lei'] = json_decode($params['lei_info'], true);
        $lei['rid'] = $hongbao->id;
        self::setLossWin($lei, $packets);
        //发送消息
        $send_info = MsgService::sendMsg([
            'user_id' => $params['user_id'],
            'list_id' => $params['list_id'],
            'action' => 'chatData',
            'sendData' => [
                'list_id' => $params['list_id'],
                'data' => [
                    'type' => 0,
                    'msg' => [
                        'id' => $chat_obj->id,
                        'type' => 5, //红包消息
                        'time' => time(),
                        'user_info' => [
                            'uid' => $params['user_id'],
                            'name' => $user_info['data']['nickname'],
                        ],
                        'content' => $content,
                    ],
                ]
            ]
        ]);
        $key = ConfigService::HONGBAO_AUTO_GET.$hongbao->id;
        if(!RedisService::get($key)){
            QueueService::autoPackage(['rid'=>$hongbao->id,'list_id'=>$params['list_id']]);
        }
        return $send_info;
    }

    /**
     * 获取用户每天的群流水
     */
    public static function getUserDayWinByGroupId($params = [])
    {
        $start_time = strtotime(date('Y-m-d 00:00:00'));
        $end_time = time();
        return CapitalLog::where(['user_id' => $params['user_id'], 'record_type' => 1, 'order_id' => $params['order_id']])
            ->where(['capital_type' => [6, 7]])
            ->where('create_time', 'between', [$start_time, $end_time])
            ->sum('money');
    }

    /**
     * 设置输赢
     * @param $redpacket
     * @param $packet
     */
    public static function setLossWin($redpacket, $packet)
    {
        $red_packet = $win_packet = $loss_packet = [];
        $tmp_lei_arr = $redpacket['red_lei'];
        foreach ($packet as $lk => $lv) {
            $amountJF = getJF($lv);
            if (in_array($amountJF['f'], $redpacket['red_lei'])) {
                //将分位重新组成一个新的数组
                $loss_packet[$lk] = $lv;
                //如果中雷 则剔除 $tmp_lei_arr 里面对应的值
                $key = array_search((string)$amountJF['f'], $tmp_lei_arr);
                if ($key !== false) {
                    unset($tmp_lei_arr[$key]);
                }
            } else {
                $win_packet[$lk] = $lv;
            }
        }
        if (empty($tmp_lei_arr)) {
            $red_packet['loss'] = $loss_packet;
            $red_packet['win'] = $win_packet;
        } else {
            $red_packet['loss'] = [];
            $red_packet['win'] = $packet;
        }
        RedisService::set('REDPACKET_LOSS_WIN' . $redpacket['rid'], json_encode($red_packet));
        //将输赢存进队列队列名称 群号_红包ID_loss  群号_红包ID_win
        //输的队列
        if (!empty($red_packet['loss'])) {
            foreach ($red_packet['loss'] as $k => $v) {
                //将红包值写进输的队列
                RedisService::lpush(ConfigService::HONGBAO_LEI_LOSS . $redpacket['rid'], $v);
            }
        }
        //赢的队列
        if (!empty($red_packet['win'])) {
            foreach ($red_packet['win'] as $k => $v) {
                //将红包值写进赢的队列
                RedisService::lpush(ConfigService::HONGBAO_LEI_WIN . $redpacket['rid'], $v);
            }
        }
    }

    /**
     * 抢雷包
     */
    public static function getLeiHongBao($params,$is_robot = 0)
    {
        $hongbao = HongBao::get($params['rid']);
        $user_info = UserService::getUserInfo($params['user_id']);
        if (empty($user_info)) return JsonDataService::fail('用户信息不存在!');
        if (empty($hongbao)) return JsonDataService::fail('红包已过期或不存在!');
        $hongbao_end_time = strtotime("+1 days",strtotime(date('Y-m-d H:i:s',$hongbao['time'])));
        if(time() > $hongbao_end_time)  return JsonDataService::fail('该红包已过期!');
        $redis_key = ConfigService::HONGBAO_BEST;
        if ($hongbao['sy_money'] <= 0) JsonDataService::fail('该红包已被领取完1!');
        if ($hongbao['sy_number'] <= 0 || $hongbao['sy_money'] <= 0) JsonDataService::fail('该红包已被领取完2!');
        //根据list_id查找会话
        $chat_list = ChatList::field('id,type,status,user_ids')->where('list_id', $hongbao['list_id'])->find();
        if (empty($chat_list)) return JsonDataService::fail('会话不存在!');
        $user_ids = is_array($chat_list['user_ids']) ? $chat_list['user_ids'] : json_decode($chat_list['user_ids'], true);
        if (!in_array($params['user_id'], $user_ids) && !$is_robot) return JsonDataService::fail('您没有权限领取该红包');
        //判断用户有没有领取过改红包
        $res = HongBaoDetails::where(['hongbao_id' => $params['rid'], 'user_id' => $params['user_id']])->find();
        if ($res) return JsonDataService::fail('您已经领取了该红包!');

        //获取用户中雷的概率
        $vendor_user_info = VendorUser::where(['list_id' => $hongbao['list_id']])->find();
        if (empty($vendor_user_info)) return JsonDataService::fail('插件未启用');

        //判断用户钱是否足够支付中雷的钱
        $bei_lv = self::getWinBeiLv($vendor_user_info['id'], $hongbao);
        if (!JsonDataService::checkRes($bei_lv)) return $bei_lv;
        $amount = $bei_lv['data']['amount'];
        //校验用户金额是否足够
        $user_info = UserService::canPayAmount($params['user_id'], $amount);
        //机器人也要判断余额
        if (!JsonDataService::checkRes($user_info)) return JsonDataService::success('帐号余额不足，无法抢包');

        //判断红包从队列判断
        if (RedisService::llen($redis_key . $hongbao['id']) <= 0) return JsonDataService::fail('该红包已被领取完3!');
        $click_num = RedisService::rPop($redis_key . $hongbao['id']);
        if (empty($click_num)) return JsonDataService::fail('该红包已被领取完4!');


        $user_loss_rate = $vendor_user_info['loss_amount_rate'] > 1 ? bcdiv($vendor_user_info['loss_amount_rate'], 100, 2) : $vendor_user_info['loss_amount_rate'];
        $user_loss_rate = $user_loss_rate <= 0 ? 0.2 : $user_loss_rate;
        //判断用户是否是系统用户 则控杀
        $rebot_arr = explode(',', $vendor_user_info['fuli_account']);
        $is_robot = 0;
        //系统用户杀
        if ($rebot_arr && in_array($user_info['data']['username'], $rebot_arr)) {
            $is_robot = 1;
            $user_loss_rate = 0; //免杀
        }
        //机器人免杀
        if($user_info['data']['is_robot'] == 1){
            $is_robot = 1;
            $user_loss_rate = 0; //免杀
        }
        if($is_robot == 0 && $hongbao->is_robot == 1){  //机器人发的包用户禁止抢
            return JsonDataService::fail('秒包禁止抢!');
        }
        //默认控赢
        $rand = getGailv(['user' => $user_loss_rate, 'sys' => round(1 - $user_loss_rate, 2)]);
        $loss = 0;
        if ($is_robot == 0 && $rand == 'user') { //中雷
            //中雷
            $loss = 1;
            $big_red_amount = RedisService::rPop(ConfigService::HONGBAO_LEI_LOSS . $hongbao['id']);
            if (!$big_red_amount) {
                $big_red_amount = RedisService::rPop(ConfigService::HONGBAO_LEI_WIN . $hongbao['id']);
                if (!$big_red_amount) return JsonDataService::fail('红包已领完!');
            }
        } else {
            //赢钱
            $big_red_amount = RedisService::rPop(ConfigService::HONGBAO_LEI_WIN . $hongbao['id']);
            if (!$big_red_amount) {
                $big_red_amount = RedisService::rPop(ConfigService::HONGBAO_LEI_LOSS . $hongbao['id']);
                if (!$big_red_amount) return JsonDataService::fail('红包已领完!');
            }
        }
        //获取雷号
        $lei_hao = $aArr = getJF($big_red_amount)['f'];;
        //结算
        //取出一个红包开始消费
//        Db::startTrans();
        $user_info = $user_info['data'];
        try {
            //exp
            $res_0 = HongBao::where(['id' => $params['rid']])->setDec('sy_money', floatval($big_red_amount));
            $res_1 = HongBao::where(['id' => $params['rid']])->setDec('sy_number', 1);
            if ($res_0 === false) throw new Exception('领取红包失败!【0】');
            if ($res_1 === false) throw new Exception('领取红包失败!【1】');
            $generate_desc = json_decode($hongbao['generate_desc'], true);
            $is_best = 0;
            if ($big_red_amount == max($generate_desc)) $is_best = 1;
            //手气最佳免死

            $res_2 = HongBaoDetails::create([
                'hongbao_id' => $hongbao['id'],
                'chat_id' => $chat_list['id'],
                'user_id' => $params['user_id'],
                'money' => $big_red_amount,
                'time' => time(),
                'is_best' => $is_best,
                'lei_hao' => $lei_hao,
                'vendor_user_id' => $vendor_user_info['id']
            ]);
            if ($res_2 === false) throw new Exception('领取红包失败【2】');
            //加钱
            $res_3 = User::where(['id' => $params['user_id']])->setInc('money', floatval($big_red_amount));
            if ($res_3 === false) throw new Exception('领取红包失败【3】');
            //插入资金流水
            $user_money = $loss ? bcsub($user_info['money'], floatval($big_red_amount), 3) : bcadd($user_info['money'], floatval($big_red_amount), 3);
            $res_4 = CapitalLog::create([
                'user_id' => $params['user_id'],
                'money' => $big_red_amount,
                'record_type' => 1,   //收入
                'capital_type' => 9, //抢雷红包获得
                'user_money' => $user_money,
                'order_id' => $vendor_user_info['group_id'],
                'relation_id' => $hongbao->id,
                'explain' => '收到红包',
            ]);
            if ($res_4 === false) throw new Exception('领取红包失败【4】');
        } catch (Exception $e) {
            //向队列中补齐失败的红包
            RedisService::rPush($redis_key . $params['rid'], $click_num);
            RedisService::rPush($redis_key . $hongbao['list_id'] . ":" . $hongbao['id'], $big_red_amount);
//            Db::rollback();
            return JsonDataService::fail($e->getMessage() . "__LINE__:" . __LINE__);
        }
//        Db::commit();
        //发送系统通知
        $msg = $user_info['nickname'] . '领取了红包!';
        if ($loss) {
            $msg = $user_info['nickname'] . '不小心踩了雷,雷号:' . $lei_hao;
        }
        $content = [
            'nickname' => $user_info['nickname'],
            'text' => $msg,
            'rid' => $params['rid'],
            'user_id' => $params['user_id'],
            'rid_user_id' => $hongbao['user_id']
        ];
        $chat = Chat::createSysMsg([
            'list_id' => $hongbao['list_id'],
            'user_id' => $params['user_id'],
            'content_type' => 5,
            'content' => $content,
        ]);
        $user = UserService::getUserInfo($params['user_id']);
        //MQ发送通知
        MsgService::sendChatDataMsgToAll($hongbao['list_id'], $params['user_id'], $chat->id, 5, $content, 1);
        //redis queue  发送统计
        $hongbao = HongBao::where(['id' => $params['rid']])->find();
        if ($hongbao['sy_number'] <= 0) {
            //发送红包统计
            QueueService::afterLeiHongbao(['hongbao' => $hongbao, 'bei_lv_info' => $bei_lv]);
        }
        return JsonDataService::success('抢包成功', $user);
    }

    /**
     *  $config = ['bao9'=>[
     * 'lei6'=>2,
     * 'fuli6'=>2,
     * 'lei7'=>2,
     * 'fuli7'=>2,
     * 'lei8'=>2,
     * 'fuli8'=>2,
     * 'lei9'=>2,
     * 'fuli9'=>2,
     * ]]; //5玩法
     */
    public static function getWinBeiLv($vendor_id, $hongbao)
    {
        $lei_info = json_decode($hongbao['lei_info'], true);
        $num = $hongbao['number'];
        $lei_num = count($lei_info);
        if ($lei_num <= 0) return JsonDataService::fail('最少一个雷');
        if ($lei_num > 6) {
            return JsonDataService::fail('最多6个雷');
        }
        if ($num > 9 || $num < 5) return JsonDataService::fail('至少5包，至多9包');
        if (in_array($num, [5, 6]) && $lei_num != 1) {
            return JsonDataService::fail('5包/6包只能一个雷');
        }
        if ($num == 7 && ($lei_num < 1 || $lei_num > 4)) {
            return JsonDataService::fail('7包至少一个雷至多4个雷');
        }
        if ($num == 8 && ($lei_num < 1 || $lei_num > 5)) {
            return JsonDataService::fail('8包至少一个雷至多5个雷');
        }
        if ($num == 9 && ($lei_num < 2 || $lei_num > 6)) {
            return JsonDataService::fail('8包至少两个雷至多6个雷');
        }
        $setting_info = VendorSetting::where(['vendor_user_id' => $vendor_id])->find();
//        if(empty($setting_info) || !$setting_info['config']) return JsonDataService::fail('该游戏暂未开启玩法');
        $config = json_decode($setting_info['config'] ?? '', true);
        $key = 'bao' . $num;
        $fuli = 'fuli' . $lei_num;
        $lei = 'lei' . $lei_num;
        $leiLv = $config[$key][$lei] ?? 1; //默认一倍
        $fuli = $config[$key][$fuli] ?? 0; //默认没有福利
        //根据雷值算出赔率
        $amount = bcmul($leiLv, $hongbao['money'], 2);
        return JsonDataService::success('赔率', ['leiLv' => $leiLv, 'fuli' => $fuli, 'amount' => $amount]);
    }

    /**
     * 红包抢完之后
     * ['hongbao'=>$hongbao,'bei_lv_info'=>$bei_lv]
     * @param array $params
     */
    public static function afterHongbao($params = array())
    {
       try{
           $chat_user_id = 1; //机器人ID默认1
           $date = date('Y-m-d H:i:s');
           $hongbao = $params['hongbao'];
           $user_info = UserService::getUserInfo($hongbao['user_id']);
           $bei_lv_info = $params['bei_lv_info']['data'];
           print_r($bei_lv_info);
           $lei_info = json_decode($hongbao['lei_info'], true);
           $lei_info_msg = implode('-', $lei_info);
           //查询出红包金额 / 雷数 /用户ID
           $detail = HongBaoDetails::where(['hongbao_id' => $hongbao['id']])
               ->field('user_id,money,is_best,lei_hao')
               ->select()->toArray();
           if (empty($detail)) return false;
           $lei_user_info = array_values(array_column($detail, 'lei_hao'));
           $lei_user_info_msg = implode('-', $lei_user_info);
           //判断用户有无中奖
           $best_user_id = 0;
           $best_leihao = 0;
           $temp_lei = $lei_info;
           $lei_user_arr = [];
           foreach ($detail as $v) {
               if ($v['is_best'] == 1) {
                   $best_user_id = $v['user_id'];
                   $best_leihao = $v['lei_hao'];
               }
               if (in_array($v['lei_hao'], $temp_lei)) {
                   $key = array_search((string)$v['lei_hao'], $temp_lei);
                   if ($key !== false) {
                       unset($temp_lei[$key]);
                   }
                   array_push($lei_user_arr,$v['user_id']);
               }
           }
           //检查是否中间
           $template = <<<EOF
<p>@{$user_info['username']} 中5个<p>
  <p>琻额：{$hongbao['money']} 苞：{$hongbao['number']}</p>
  <p>识：中{$hongbao['number']}个-{$bei_lv_info['leiLv']}倍</p>
 <p>开：{$lei_user_info_msg}【王{$best_leihao}】</p>
 <p>压:【{$lei_info_msg}】</p>
<p> 供饭：{$bei_lv_info['amount']}元</p>
 <p>时间：{$date}</p>
 <br>
  <p>环艺@@定制：时尚余毒</p>
  <p>逍遥且呵呵：人生几何</p><br>
EOF;
           $content = ['text' => $template];
           $chat_obj = Chat::createChatMsg([
               'list_id' => $hongbao['list_id'],
               'user_id' => $chat_user_id,
               'content_type' => 0,
               'msg_type' => 0,
               'content' => $content,
               'time' => time(),
               'is_niming' => 0
           ]);
           MsgService::sendChatDataMsgToAll($hongbao['list_id'], $chat_user_id, $chat_obj->id, 0, $content);
           //查询出红包详情
           if(empty($temp_lei)){
               //扣钱
               $vendor_user_info  = VendorUser::where(['list_id'=>$hongbao['list_id']])->find();
               if(empty($vendor_user_info)) return JsonDataService::fail();
               foreach ($lei_user_arr as $v){
                   if($v == $hongbao['user_id']) continue;
                   if($v == $best_user_id) continue;
                   //扣钱
                   $user_info = UserService::getUserInfo($v);
                   $main_user_info = UserService::getUserInfo($hongbao['user_id']);
                   User::where(['id'=>$v])->setDec('money',$bei_lv_info['amount']);
                   $ret = CapitalLog::create([
                       'user_id'=>$v,
                       'money'=>$bei_lv_info['amount'],
                       'record_type'=>0,
                       'order_id'=>$vendor_user_info['group_id'],
                       'capital_type'=>8,
                       'explain'=>'红包费用',
                       'user_money'=>bcsub($user_info['money'],$bei_lv_info['amount'],2),
                   ]);
                   $ret = CapitalLog::create([
                       'user_id'=>$hongbao['user_id'],
                       'money'=>$bei_lv_info['amount'],
                       'record_type'=>1,
                       'order_id'=>$vendor_user_info['group_id'],
                       'capital_type'=>7,
                       'explain'=>'红包费用',
                       'user_money'=>bcadd($main_user_info['money'],$bei_lv_info['amount'],2),
                   ]);
               }
           }
       }catch (Exception $e){
           echo  $e->getMessage();
       }
    }


    /**
     * 机器人自动抢包
     */
    public static function robotAutoRedPackage($params){
            //查询出所有的机器人
//            try{
                $member_list = ChatMember::where(['list_id'=>$params['list_id'],'is_robot'=>1])->select()->toArray();
                if(!empty($member_list)){
                    foreach ($member_list as $v){
                        usleep(200);
                        $et =self::getLeiHongBao(['rid'=>$params['rid'],'user_id'=>$v['user_id']],1);
                       echo json_encode($et,256);
                    }
                }
//            }catch (Exception $e){
//                echo $e->getMessage();
//            }
           return true;
    }
}