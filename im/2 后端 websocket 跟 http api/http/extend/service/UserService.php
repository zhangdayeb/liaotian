<?php
/**
 * Created by IntelliJ IDEA.
 * User: Administrator
 * Date: 2020-06-12
 * Time: 16:02
 */

namespace extend\service;


use app\im\model\mongo\ChatGroup;
use app\im\model\mongo\ChatList;
use app\im\model\mongo\ChatMember;
use app\im\model\mongo\HongBaoDetails;
use app\im\model\mongo\UserState;
use app\im\model\mysql\CapitalLog;
use app\im\model\mysql\User;
use app\im\model\mysql\UserBank;
use app\im\model\mysql\Withdraw;
use app\super\model\BsysConfig;
use think\Controller;
use think\Db;
use think\Exception;
use think\Image;

class UserService
{
    public static function getUserInfo($user_id = 0)
    {
        $user = User::get($user_id);
        if (!$user) return null;
        $user_state = UserState::field('photo')->where('user_id', intval($user_id))->find();
        $face = getShowPhoto($user_state, $user['sex'], $user_id, 300);
        $user['face'] = $face;
        $user['photo'] = $face;
        return $user;
    }

    //校验是否够支付
    public static function canPayAmount($user_id, $amount)
    {
        $user = self::getUserInfo($user_id);
        if (empty($user)) return JsonDataService::fail('用户信息不存在!');
        $res = User::where("money - {$amount} >= 0")->where(['id' => $user_id])->find();
        if (empty($res)) return JsonDataService::fail('余额不足,请充值!', $user);
        $user_state = UserState::field('photo')->where('user_id', $user_id)->find();
        $face = getShowPhoto($user_state, $user['sex'], $user_id, 300);
        $res['face'] = $face;
        $res['photo'] = $face;
        return JsonDataService::success('用户余额可支付!', $res);
    }

    //扣钱
    public static function setDecAmount($user_id, $amount)
    {
        $user = self::getUserInfo($user_id);
        if (empty($user)) return JsonDataService::fail('用户信息不存在!');
        $res = User::where(['id' => $user_id])->setDec('money', $amount);
        if (empty($res)) return JsonDataService::fail('账号余额不足!');
        return JsonDataService::success('用户余额可支付!', $user);
    }

    //支付校验校验密码
    public static function checkBeforePay($params)
    {
        $ret = self::canPayAmount($params['user_id'], $params['amount']);
        if (!JsonDataService::checkRes($ret)) return $ret;
//        $user_info = $ret['data'];
//        if (!$user_info['trade_password']) return JsonDataService::fail('请先设置您的交易密码!');
        return JsonDataService::success();
    }

    //获取用户资金流水列表
    public static function getUserCapitalList($params)
    {
        $user_id = $params['user_id'];
        $user = self::getUserInfo($user_id);
        if (empty($user)) return JsonDataService::fail('用户信息不存在!');
        $query = CapitalLog::where(['user_id' => $user_id]);
        $type_ids = [0, 7, 8, 9, 10, 11];
        if ($params['type']) $query = $query->where(['capital_type' => $type_ids]);
        else $query = $query->where(['capital_type' => [1, 2, 3, 4, 5, 6]]);
        $ret = [];
        $params['get'] = $params['get'] ?? 1;   //默认收到
        $params['time'] = $params['time'] ?? 1;  //默认本月
        // time 1 本月 2上个月, 3上上个月, 4近三个月
        $begin_0 = strtotime(date('Y-m-01 00:00'));
        $end_0 = strtotime(date("Y-m-d 23:59:59"));
        //上个月
        $begin_1 = strtotime(date('Y-m-01 00:00:00', strtotime('-1 month')));
        $end_1 = strtotime(date("Y-m-d 23:59:59", strtotime(-date('d') . 'day')));
        //上上个月
        $begin_2 = strtotime(date("Y-m-d H:i:s", mktime(0, 0, 0, date("m") - 2, 1, date("Y"))));
        $end_2 = strtotime(date("Y-m-d H:i:s", mktime(23, 59, 59, date("m") - 1, 0, date("Y"))));

        $begin = $end_2;
        $end = $end_0;
        if ($params['time'] == 1) { //本月
            $begin = $begin_0;
            $end = $end_0;
        }
        if ($params['time'] == 2) { //上月
            $begin = $begin_1;
            $end = $end_1;
        }
        if ($params['time'] == 3) { //上上月
            $begin = $begin_2;
            $end = $end_2;
        }
        if ($params['time'] == 4) { //三个月
            $begin = $end_2;
            $end = $end_0;
        }

        if ($params['type']) { //红包统计
            $query2 = CapitalLog::where(['user_id' => $user_id]);
            //收到红包(个)
            //手气最佳(个)
            //共收到(元);
            if($params['get'] == 1){
                $type_ids = [9,0];
                $query2 = $query2->where(['capital_type'=>$type_ids,'record_type'=>1]);
                //收到多少个
                $count = $query2->where([
                    ['create_time', '>=', $begin],
                    ['create_time', '<=', $end],
                    ['user_id', '=', $user_id],
                ])->count();
                //收到多少元
                $amount = $query2->where([
                    ['create_time', '>=', $begin],
                    ['create_time', '<=', $end],
                    ['user_id', '=', $user_id],
                ])->sum('money');
                //最佳数量
                $best_count = HongBaoDetails::where([
                    ['create_time', '>=', $begin],
                    ['create_time', '<=', $end],
                    ['is_best', '=', 1],
                    ['user_id', '=', $user_id],
                ])->count();
                $ret = ['best_count'=>$best_count,'count'=>$count,'amount'=>$amount,'begin'=>$begin,'end'=>$end];
            }
            if($params['get'] == 2){
                $type_ids = [10,0];
                $count = $query2->where(['capital_type'=>$type_ids,'record_type'=>0])->count();
                $amount = $query2->where(['capital_type'=>$type_ids,'record_type'=>0])->sum('money');
                //发出多少个
                $ret = ['best_count'=>0,'send_count'=>$count,'amount'=>$amount];
            }
        }
        //默认是收到
       if($params['type']){
           if($params['get'] == 1){
               $query = $query->where(['record_type'=>1]);
           }else{
               $query = $query->where(['record_type'=>0]);
           }
       }
        $capitalList = $query->where([
            ['create_time','>=',$begin],
            ['create_time','<=',$end],
        ])->order('id', 'desc')->paginate(10)->toArray();
        $capitalList['info'] = $ret;
        $capitalList['sql'] = CapitalLog::getLastSql();
        return JsonDataService::success('账单', $capitalList);
    }

    //获取用户收款账户列表
    public static function getUserBankList($params)
    {
        $user_id = $params['user_id'];
        $user = self::getUserInfo($user_id);
        if (empty($user)) return JsonDataService::fail('用户信息不存在!');
        $bankList = UserBank::where(['user_id' => $user_id])->order('is_default', 'asc')->order('id', 'desc')->select();
        return JsonDataService::success('银行卡列表', $bankList->toArray());
    }

    public static function addUserBank($params)
    {
        $user_id = $params['user_id'];
        $user = self::getUserInfo($user_id);
        if (empty($user)) return JsonDataService::fail('用户信息不存在!');
        $info = UserBank::where(['account' => $params['account']])->find();
        if ($info) return JsonDataService::fail('账号已存在!');
        $data['fullname'] = $params['fullname'];
        $data['id_card'] = $params['id_card'];
        $data['account'] = $params['account'];
        $data['user_id'] = $user_id;
        $data['bank_type'] = $params['bank_type'];
        $data['bank_name'] = UserBank::getBankName($params['bank_type']);
        $ret = UserBank::create($data);
        $data['id'] = $ret->id;
        if (!$ret) return JsonDataService::fail('操作失败!');
        return JsonDataService::success('操作成功!', $data);
    }

    /**
     * 设置用户交易密码
     */
    public static function setUserTradePassword($params)
    {
        $user = self::getUserInfo($params['user_id']);
        if (empty($user)) return JsonDataService::fail('用户信息不存在!');
        if ($user['trade_password'] && !isset($params['is_edit'])) return JsonDataService::fail('您已设置交易密码!');
        $password = $params['password'];
        $trade_password = $params['confirm_password'];
        if ($password != $trade_password) return JsonDataService::fail('两次密码输入不一致!');
        $password = create_password($password);
        $ret = User::where(['id' => $user['id']])->update(['trade_password' => $password]);
        if ($ret === false) return JsonDataService::fail('设置失败!');
        $user['trade_password'] = $password;
        return JsonDataService::success('设置成功!', $user);
    }

    public static function updUserTradePassword(array $params)
    {
        $user = self::getUserInfo($params['user_id']);
        if (empty($user)) return JsonDataService::fail('用户信息不存在!');
        if ($user['trade_password']) return JsonDataService::fail('您已设置交易密码!');
        $password = $params['password'];
        $trade_password = $params['confirm_password'];
        if ($password != $trade_password) return JsonDataService::fail('两次密码输入不一致!');
        $password = create_password($password);
        $ret = User::where(['id' => $user['id']])->update(['trade_password' => $password]);
        if ($ret === false) return JsonDataService::fail('设置失败!');
        $user['trade_password'] = $password;
        return JsonDataService::success('设置成功!', $user);
    }

    /**
     *校验用户的交易密码
     */
    public static function checkUserTradePassword(array $params)
    {
        $user = self::getUserInfo($params['user_id']);
        if (empty($user)) return JsonDataService::fail('用户信息不存在!');
        $trade_password = $params['password'];
        if (!check_password($trade_password, $user['trade_password'])) return JsonDataService::fail('交易密码错误!');
        return JsonDataService::success();
    }

    /**
     *获取用户列表（带头像）
     */
    public static function getUserListWithPhoto(array $params)
    {
        $frientds_list = User::where(['id' => $params['user_ids']])->select()->toArray();
        if (empty($frientds_list)) return false;
        foreach ($frientds_list as &$v) {
            $user_state = UserState::field('photo')->where('user_id', $v['id'])->find();
            $v['face'] = getShowPhoto($user_state, $v['sex'], $v['id'], 300);

        }
        return $frientds_list;
    }

    /**
     * 向某人付款
     */
    public static function payAmount(array $params)
    {
        extract($params);
        $flat = RedisService::setnx(ConfigService::NALMAL_FAST_SEND_KEY . $user_id, 1, 5);
        if (!$flat) return JsonDataService::fail('您点击太快啦!');
        if ($user_id == $to_user_id) return JsonDataService::fail('不能转账给自己哦!');
        $amount = round($amount, 2);
        if (!$amount) return JsonDataService::fail('付款金额有误!');
        if ($amount >= 10000) return JsonDataService::fail('付款金额超出最大限制!');
        $ret1 = self::canPayAmount($user_id, $amount);
        if (!JsonDataService::checkRes($ret1)) return $ret1;
        $to_user_info = UserService::getUserInfo($to_user_id);
        if (!$to_user_info) return JsonDataService::fail('付款失败!');
        if (!isset($params['dbh'])) User::startTrans();
        try {
            $ret = self::setDecAmount($user_id, $amount);
            if (!JsonDataService::checkRes($ret)) throw new Exception($ret['msg']);
            //加钱
            $ret = User::where(['id' => $to_user_id])->setInc('money', $amount);
            if ($ret === false) throw new Exception('付款失败!');
            $final_amount = bcsub($ret1['data']['money'], $amount, 2);
            $ret = CapitalLog::create([
                'user_id' => $user_id,
                'money' => $amount,
                'record_type' => 0,
                'order_id' => $params['order_id'] ?? 1,
                'capital_type' => $params['capital_type'] ?? 1,
                'explain' => $params['explain1'] ?? '向' . $to_user_info['username'] . '付款',
                'user_money' => $final_amount,
            ]);
            if ($ret === false) throw new Exception('付款失败!');
            $to_user = self::getUserInfo($to_user_id);
            $ret = CapitalLog::create([
                'user_id' => $to_user_id,
                'money' => $amount,
                'record_type' => 1,
                'capital_type' => $params['capital_type'] ?? 1,
                'order_id' => $params['order_id'] ?? 1,
                'explain' => $params['explain2'] ?? $ret1['data']['username'] . '向你付款',
                'user_money' => $to_user['money'],
            ]);
            if ($ret === false) throw new Exception('付款失败!');
        } catch (Exception $e) {
            if (!isset($params['dbh'])) User::rollback();
            return JsonDataService::fail($e->getMessage());
        }
        if (!isset($params['dbh'])) User::commit();
        $ret1['data']['money'] = $final_amount;
        MsgService::senNormalMsgToUid($to_user_id, 'payAmount', $to_user);
        return JsonDataService::success('付款成功!', $ret1['data']);
    }

    public static function collectAmount(array $params)
    {
        extract($params);
        $user_info = self::getUserInfo($user_id);
        MsgService::senNormalMsgToUid($to_user_id, 'collectAmount', ['user_info' => $user_info, 'amount' => $amount]);
        return JsonDataService::success('发送请求成功!');
    }

    public static function updateUserSayType(array $params)
    {
        extract($params);
        $chat_group = ChatGroup::where('list_id', $list_id)->find();
        if (empty($chat_group)) return JsonDataService::fail('开启失败!');
        if ($chat_group['can_niming'] == 0 && $status == 1) return JsonDataService::fail('管理员暂未开启匿名聊天!');
        $where = ['list_id' => $list_id, 'user_id' => $user_id];
        $chat_member_data = ChatMember::field('is_admin,is_msg,is_niming')
            ->where($where)
            ->find();
        if (!$chat_member_data) return JsonDataService::fail('您不是该群组成员!');
        //开启禁言
        $ret = ChatMember::where($where)->update(['is_niming' => intval($params['status'])]);
        if ($ret === false) return JsonDataService::fail('操作失败');
        return JsonDataService::success('操作成功!');
    }

    /**
     * 消息免打扰
     * @param $params
     * @return mixed
     * @throws Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\db\exception\PDOException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public static function updateChatMemberDistrub($params)
    {
        extract($params);
        $where = ['list_id' => $list_id, 'user_id' => $user_id];
        $chat = ChatList::where($where)->find();
        if (!$chat) return JsonDataService::fail('会话不存在!');
        $ret = ChatList::where($where)->update(['is_disturb' => $params['value']]);
        if ($ret === false) return JsonDataService::fail('操作失败!');
        return JsonDataService::success('操作成功!');
    }

    /**
     * 提现
     */
    public static function withDrawMoney(array $params)
    {
        extract($params);
        $ret = self::canPayAmount($user_id, $amount);
        if (!JsonDataService::checkRes($ret)) return JsonDataService::fail('账户余额不足!');
        $bank_info = UserBank::get($bank_id);
        if (!$bank_info) return JsonDataService::fail('收款账号不存在!');
        //判断提现方式
        $config = BsysConfig::getAllVal('basic_config');
        $auto = 0;
        $debug = config('app_debug');
        if ($config['user_withdraw_status'] == 0) { //关闭提现审核
            //判断提现次数
            $auto = 1;
            $start_time = date("Y-m-d 00:00:00");
            $end_time = time();
            $sum_money = Withdraw::where(['user_id' => $params['user_id']])->where("create_time between '{$start_time}' and '$end_time'")->sum('draw_money');
            if ($sum_money > $config['user_max_withdraw']) return JsonDataService::fail('您今天提现太多了，请明天再来哦!');
            $times = Withdraw::where(['user_id' => $params['user_id']])->where("create_time between '{$start_time}' and '$end_time'")->count();
//            if($debug && ($times > 10 || $sum_money > 5)) return JsonDataService::fail('测试环境已禁止提现,如有疑问请联系:317149766');
            if ($times > $config['user_day_withdraw_times']) return JsonDataService::fail('您今天提现次数太多了，请明天再来哦!');
        } else { //否则走审核提现
            $flat = Withdraw::where(['user_id' => $user_id, 'status' => 0])->find();
            if ($flat) return JsonDataService::fail('您已有一笔提现正在审核，请耐心等待!');
        }
        $config = SystemService::getBaseConfig();
        $user_withdraw_fee = $config['data']['user_withdraw_fee'];
        if ($user_withdraw_fee >= 1) return JsonDataService::fail('系统异常请联系客服!');
        $fee = bcmul($user_withdraw_fee, $amount, 2);
        if ($auto) {
            $ret = PayMentService::transfer(
                ['account' => $bank_info['account'],
                    'amount' => bcsub($amount, $fee, 2),
                    'realname' => $bank_info['fullname'],
                    'app_name' => '新聊极速版'
                ]);
            //提现失败返回
            if (!JsonDataService::checkRes($ret)) return $ret;
        }
        try {
            Withdraw::startTrans();
            $edit = ['money' => Db::raw('money -' . $amount)];
            if (!$auto) {
                $edit['freeze_money'] = Db::raw('freeze_money+' . $amount);
            }
            $ret = User::where(['id' => $user_id])
                ->setField($edit);
            if ($ret === false) throw  new Exception('账户余额不足!');
            //添加审核记录
            $ret = Withdraw::create([
                'user_id' => $user_id,
                'bank_code' => $bank_info['account'],
                'bank_name' => $bank_info['bank_name'],
                'user_bank_id' => $bank_info['id'],
                'draw_money' => $amount,
                'fee' => $fee,
                'status' => $auto ? 2 : 0
            ]);
            if ($ret === false) throw  new Exception('提现失败');
            //增加流水
            $user_info = self::getUserInfo($user_id);
            $captal = CapitalLog::create([
                'user_id' => $user_id,
                'money' => $amount,
                'user_money' => $user_info['money'],
                'explain' => $auto ? '提现' : '提现冻结',
                'capital_type' => 5,
            ]);
            if ($captal === false) throw  new Exception('提现失败');
        } catch (Exception $e) {
            Withdraw::rollback();
            return JsonDataService::fail($e->getMessage());
        }
        Withdraw::commit();
        //发消息更新余额
        MsgService::senNormalMsgToUid($user_id, 'payAmount', $user_info);
        return JsonDataService::success('提现成功!');
    }

    /**
     * 添加客服为好友
     */
    public static function addCustomerServiceFriends($user_id, $friend_ids)
    {
//        $user_info = UserService::getUserInfo($user->id);
//        MsgService::senNormalMsgToUid($friend_id,'chatData',[
//            'list_id' => $list_id,
//            'data' => [
//                'type' => 0,
//                'msg' => [
//                    'id' => $chat->id,
//                    'type' => 0,
//                    'time' => time(),
//                    'user_info' => [
//                        'uid' => $user_info['id'],
//                        'name' => $user_info['nickname'],
//                        'face' => $user_info['face'],
//                    ],
//                    'content' => ['text'=>$text]
//                ],
//            ]
//        ]);
    }

}