<?php
/**
 * Created by IntelliJ IDEA.
 * User: Administrator
 * Date: 2020/8/30 0030
 * Time: 16:02
 */

namespace extend\service;


use app\common\controller\SendData;
use app\im\common\controller\NameFirstChar;
use app\im\model\mongo\Chat;
use app\im\model\mongo\ChatGroup;
use app\im\model\mongo\ChatGroupApply;
use app\im\model\mongo\ChatList;
use app\im\model\mongo\ChatMember;
use app\im\model\mongo\Friend;
use app\im\model\mongo\HongBao;
use app\im\model\mongo\HongBaoDetails;
use app\im\model\mongo\Store;
use app\im\model\mongo\UserState;
use app\im\model\mongo\VoiceRoom;
use app\im\model\mysql\CapitalLog;
use app\im\model\mysql\User;
use app\im\model\mysql\UserLog;
use app\im\model\mysql\Vendor;
use app\im\model\mysql\VendorSetting;
use app\im\model\mysql\VendorUser;
use app\im\model\mysql\Article;
use app\super\controller\Member;
use extend\sdk\tendence\im\VedioSdk;
use JmesPath\Tests\_TestJsonStringClass;
use think\Image;

class VendorService
{
    const MAX_COUNT = 20000;       //最多存储个数
    const MAX_STORGE = 32212254720; //最大存储

    /**
     * list_id
     * 更改秒抢 status = 1 开启 0 关闭
     */
    public static function updateMiaoQiang($params = [])
    {
        if (!in_array($params['status'], [0, 1])) return JsonDataService::fail('参数错误');
        $chat_member = ChatMember::where(['list_id' => $params['list_id'], 'user_id' => $params['user_id']])->find();
        if (!$chat_member) return JsonDataService::fail('无权限访问!');
        $ret = $chat_member->save(['miaoqiang' => $params['status'], 'qiang_time' => $params['qiang_time']]);
        if ($ret === false) return JsonDataService::fail('操作失败!');
        return JsonDataService::success('操作成功');
    }

    public static function getVendorInfo($params = [])
    {
        $chat_member = ChatMember::where(['list_id' => $params['list_id'], 'user_id' => $params['user_id']])->find();
        return JsonDataService::success('详情', $chat_member);
    }

    public static function createLeiHongBao($params, $is_robot = 0)
    {
        if (!is_numeric($params['hongbao_msg'])) {
            return JsonDataService::fail('必须是数字');
        }
        if (strHasRepeat($params['hongbao_msg'])) return JsonDataService::fail('备注有误请重新输入');
        $hongbao_msg = str_split($params['hongbao_msg']);
        $lei_info = "";
        $vendor_user_info = VendorUser::where(['list_id' => $params['list_id']])->find();
        if (empty($vendor_user_info) || $vendor_user_info['status'] == 0) return JsonDataService::fail('插件未启用');
        if ($vendor_user_info['status'] == 2) return JsonDataService::fail('该插件已被禁用，如有疑问请联系客服!');
        $vendor_info = Vendor::get($vendor_user_info['vendor_id']);
        if (!$vendor_info || $vendor_info['status'] == 0) return JsonDataService::fail('该插件已被禁用，如有疑问请联系客服!');
        if ($hongbao_msg) {
            sort($hongbao_msg);
            $msg = implode("", $hongbao_msg);
            $lei_info = json_encode($hongbao_msg, 256);
        }
        if ($params['amount'] % 10 != 0) {
            return JsonDataService::fail('金额必须是10的倍数');
        }
        //查询插件规则
        $setting = VendorSetting::where(['vendor_user_id' => $vendor_user_info['id']])->find();
        if ($setting['amount'] > 0 && $setting['amount'] != $params['amount']) return JsonDataService::fail('只能发' . $setting['amount'] . '元的包');
        $number_arr = json_decode($setting['lei_info'], true);
        if ($setting['num'] <= 0) return JsonDataService::fail('红包功能暂不能使用');
        if ($setting['num'] != $params['num']) return JsonDataService::fail('该房间只支持' . $setting['num'] . '包');
        $lei_count = count($hongbao_msg);
        if (!$number_arr) return JsonDataService::fail('红包功能暂不能使用');
        if (!in_array($lei_count, $number_arr)) {
            $str = implode('/', $number_arr);
            return JsonDataService::fail('备注有误,请重新输入,只支持' . $str . '个字符');
        }
        //插入雷
        return HongBaoService::createLeiHongbao([
            'type' => $params['type'],
            'num' => $params['num'],
            'user_id' => $params['user_id'],
            'list_id' => $params['list_id'],
            'msg' => $msg,
            'amount' => $params['amount'],
            'lei_info' => $lei_info,
            'vendor_user_id' => $vendor_info['id'],
            'trade_password' => "",
            'vendor_info' => $vendor_user_info,
        ], $is_robot);
    }


    /**
     * 设置红包参数
     * @param array $params
     */
    public static function setHongBaoConfig($params = [])
    {
        //首先
        $params['amount'] = $params['amount'] ?? 0;
        $vendor_id = $params['vendor_id'];
        $info = VendorUser::where(['id' => $vendor_id, 'user_id' => $params['user_id']])->find();
        if (empty($info)) return JsonDataService::fail('插件信息不存在!');
        if (!in_array($info['status'], [0, 1])) return JsonDataService::fail('该插已禁用!');
        $setting = VendorSetting::where(['vendor_user_id' => $info['id']])->find();
        $arr = [];
        $lei_info = [];
        $key = 'bao' . $params['selectNum'];
        for ($i = 1; $i <= 6; $i++) {
            $lei = 'lei' . $i;
            $fuli = 'fuli' . $i;
            $arr[$key][$lei] = $params[$lei];
            if (!empty($params[$lei])) array_push($lei_info, $i);
            $arr[$key][$fuli] = $params[$fuli];
        }
        $lei_info = json_encode($lei_info, 256);
        if ($setting) {
            //执行更新
            $ret = $setting->save(['config' => json_encode($arr, 256), 'num' => $params['selectNum'], 'lei_info' => $lei_info, 'amount' => $params['amount']]);
            $ret = VendorUser::where(['id' => $vendor_id])->update(['status' => $params['status']]);
        } else {
            //执行新增
            $ret = VendorSetting::create(
                [
                    'num' => $params['selectNum'],
                    'amount' => $params['amount'],
                    'lei_info' => $lei_info,
                    'vendor_user_id' => $info['id'],
                    'group_id' => $info['group_id'],
                    'user_id' => $info['user_id'],
                    'status' => $params['status'],
                    'config' => json_encode($arr, 256)
                ]);
        }
        if ($ret !== false) return JsonDataService::success('操作成功!');
        return JsonDataService::success('操作失败!');
    }

    /**
     *
     * @param array $params
     */
    public static function getUserVendor($params = [])
    {
        $vendor_user = new VendorUser();
        $vendor_user = $vendor_user->alias('vu');
        $vendor_list = $vendor_user->where(['vu.user_id' => $params['user_id']])
            ->where(['vu.status' => [0, 1]])
            ->Join('Vendor v', 'vu.vendor_id=v.id')
            ->leftJoin('VendorSetting s', 'vu.id=s.vendor_user_id')->field('vu.id,vu.vendor_id,vu.group_id,vu.list_id,vu.expire_time,vu.expire_day')
            ->select()
            ->toArray();
        if (empty($vendor_list)) return JsonDataService::success('无插件', ['sql' => $vendor_user->getLastSql()]);
        foreach ($vendor_list as &$v) {
            $group = ChatGroup::where(['list_id' => $v['list_id']])->find();
            $v['group_name'] = $group ? $group['name'] : '红包群';
            $v['expire_time'] = $v['expire_day'] == -1 ? '永久' : $v['expire_time'];
            //机器人数量
            $v['robot_count'] = ChatMember::where(['list_id' => $v['list_id'], 'is_robot' => 1])->count();
        }
        return JsonDataService::success('', $vendor_list);

    }

    /**
     * 获取红包插件详情
     */
    public static function getVendorHongBaoInfo($params = [])
    {
        $vendor_id = $params['vendor_id'];
        $info = VendorUser::where(['id' => $vendor_id, 'user_id' => $params['user_id']])->find();
        if (empty($info)) return JsonDataService::fail('插件信息不存在!');

        $info = VendorSetting::where(['vendor_user_id' => $info['id']])->find();
        $ret = [];
        if (!empty($info)) {
            $config = json_decode($info['config'], true);
            //几包
            $ret['status'] = VendorUser::where(['id' => $params['vendor_id']])->value('status');
            $ret['status'] = $ret['status'] ? $ret['status'] : 0;
            $ret['amount'] = $info['amount'];
            if ($config) {
                foreach ($config as $key => $value) {
                    preg_match('/\d+/', $key, $match);
                    $selectNum = $match[0];
                    $ret['selectNum'] = $selectNum;
                    foreach ($value as $key2 => $value2) {
                        $ret[$key2] = $value2;
                    }
                }
            }
        }
        return JsonDataService::success('', $ret);
    }

    /**
     * 机器人自动回复
     */
    public static function robotAutoReply($params = array())
    {
        if (!isset($params['list_id'])) return JsonDataService::fail('插件信息不存在！');
        $vendor_user_info = VendorUser::where(['list_id' => $params['list_id']])->find();
        if (empty($vendor_user_info)) return JsonDataService::fail('插件信息不存在！');
        $keywords = ['查我'];
        if (!in_array($params['keywords'], $keywords)) {
            //TODO sendToGroup
            return JsonDataService::fail('没有找到关键词');
        };
        //输赢
        $group_id = $vendor_user_info['group_id'];
        //根据group_id查询用户输赢
        //中奖的钱 + 抢红包的钱
        $award_money = CapitalLog::where(['user_id' => $params['user_id'], 'order_id' => $group_id])
            ->where(['capital_type' => [7, 9]])
            ->sum('money');
        //发出红包的钱+中雷的钱
        $loss_money = CapitalLog::where(['user_id' => $params['user_id'], 'order_id' => $group_id])
            ->where(['capital_type' => [10, 8]])
            ->sum('money');
        $loss = bcsub($award_money, $loss_money, 2);
        $liushui = bcadd($award_money, $loss_money, 2);
        //对局 = 插件ID
        $dui_ju = CapitalLog::where(['user_id' => $params['user_id'], 'order_id' => $group_id])
            ->where(['capital_type' => [10, 7, 8, 9]])
            ->group('relation_id')
            ->select()
            ->toArray();
        $dui_ju = count($dui_ju);
        //查询出插件ID
        $user_info = UserService::getUserInfo($params['user_id']);
        $date = date('Y-m-d H:i:s');
        //对局流水
        //输赢
        //检查是否中间
        $template = <<<EOF
<p>@{$user_info['username']} <p>
  <p>淑瑛：{$loss} </p>
  <p>溜水：{$liushui}</p>
 <p>对局：{$dui_ju}</p>
 <p>时间：{$date}</p>
 <br>
  <p>环艺@@定制：时尚余毒</p>
  <p>逍遥且呵呵：人生几何</p><br>
EOF;
        $content = ['text' => $template];
        $chat_obj = Chat::createChatMsg([
            'list_id' => $params['list_id'],
            'user_id' => 1,
            'content_type' => 0,
            'msg_type' => 0,
            'content' => $content,
            'time' => time(),
            'is_niming' => 0
        ]);
        MsgService::sendChatDataMsgToAll($params['list_id'], 1, $chat_obj->id, 0, $content);
    }

    public static function getRobotList($params)
    {
        $vendor_user_info = VendorUser::find($params['id']);
        if (empty($vendor_user_info)) return JsonDataService::fail('插件不存在!');
        $model = (new ChatMember());
        $model = $model->where(['is_robot' => 1, 'list_id' => $vendor_user_info['list_id']]);
        $list = $model->select()->toArray();
        if (!empty($list)) {
            foreach ($list as &$v) {
                $user_info = UserService::getUserInfo($v['user_id']);
                $v['username'] = $user_info['username'];
                $v['money'] = $user_info['money'];
                $v['loss'] = self::getVendorLostMoney($v['user_id'], $vendor_user_info['group_id']);
            }
        }
        return JsonDataService::success('', $list);
    }

    /**
     * @param $user_id
     * @param $group_id
     * @return string
     */
    public static function getVendorLostMoney($user_id, $group_id)
    {
        //奖励的钱
        $award_money = CapitalLog::where(['user_id' => $user_id, 'order_id' => $group_id])
            ->where(['capital_type' => [7, 9]])
            ->sum('money');
        //发出红包的钱+中雷的钱
        $loss_money = CapitalLog::where(['user_id' => $user_id, 'order_id' => $group_id])
            ->where(['capital_type' => [6, 8]])
            ->sum('money');
        return bcsub($award_money, $loss_money, 2);
    }

    public static function addVendorRobot($params)
    {
        $insert = [
            'username' => $params['username'],
            'nickname' => $params['username'],
            'password' => $params['password'],
            'agent_id' => 1,
            'is_robot' => 1,
            'money' => $params['money'] ?? 0
        ];
        if (User::where(['username' => $params['username']])->find()) {
            return JsonDataService::fail('该用户名已存在!');
        }
        $user = User::create($insert);
        if (!$user) return JsonDataService::fail('创建失败!');
        UserStateService::setRandPhoto(['user_id' => $user->id]); //默认头像
        //进群
        $vendor_info = VendorUser::find($params['id']);
        //查询有多少个机器人
        $count = ChatMember::where(['list_id' => $vendor_info['list_id'], 'is_robot' => 1])->count();
        if ($count >= 9) return json(JsonDataService::fail('机器人不能超过9个!'));
        $ret = GroupService::addGroup($vendor_info['list_id'], $user->id, 1);
        if (!JsonDataService::checkRes($ret)) return $ret;
        return JsonDataService::success('操作成功!');
    }

    public static function robotTuiQun($params = array())
    {
        //判断是否还有余额
        $user_id = $params['robot_user_id'];
        $user_info = UserService::getUserInfo($user_id);
        if ($user_info['money'] > 0) return JsonDataService::fail('请提现后再退群!');
        $params['users'] = [$user_id];
        return GroupService::tuiQun($params);
    }

    /**
     *机器人自定发包
     */
    public static function robotAutoHongbao($params = array())
    {
        //判断是否是群主
        if (!isset($params['list_id'])) return JsonDataService::fail('插件信息不存在！');
        $vendor_user_info = VendorUser::where(['list_id' => $params['list_id']])->find();
        if (empty($vendor_user_info)) return JsonDataService::fail('插件信息不存在！');
        if ($vendor_user_info['user_id'] != $params['user_id'])
            return JsonDataService::fail('您无权限操作!');
        //发包
        //查询红包设置
        $info = VendorSetting::where(['vendor_user_id' => $vendor_user_info['id']])->find();
        if (empty($info)) return JsonDataService::fail('暂无红包设置');
        $lei = json_decode($info['lei_info'], true);
        $num = $info['num'];
        if (!$lei) return JsonDataService::fail('玩法未设置!');
        $lei_num = $lei[0];
        //生成不重复的数字
        $num_arr = no_repe_number(0, 9, $lei_num);
        $num_str = implode('', $num_arr);
        //查询机器人
        $robot_list = ChatMember::where(['list_id' => $params['list_id'], 'is_robot' => 1])
            ->field('user_id')->select()
            ->toArray();
        if (!$robot_list) return JsonDataService::fail('暂无机器人!');
        $count = mt_rand(0, count($robot_list) - 1);
        $robot_user_id = $robot_list[$count]['user_id'];
        //hongbao_msg amount num list_id user_id
        return self::createLeiHongBao([
            'hongbao_msg' => $num_str,
            'type' => 2,
            'num' => $num,
            'user_id' => $robot_user_id,
            'amount' => $info['amount'],
            'list_id' => $params['list_id']
        ], 1);
    }

    /**
     * 更新用户的交易密码
     */
    public static function updateUserTradePassword($params)
    {
        $user_info = UserService::getUserInfo($params['user_id']);
        if (!$user_info) return JsonDataService::fail('用户信息不存在');
        $key = ConfigService::SMS_CODE . $params['type'] . ':' . $user_info['phone'];
        $code = RedisService::get($key);
        if (!$code) return JsonDataService::fail('验证码已失效，请重新获取');
        if ($params['code'] != $code) return JsonDataService::fail('验证码不正确!');
        if ($params['confirmPassword'] != $params['password']) return JsonDataService::fail('两次验证码输入不一致!');
        $password = create_password($params['password']);
        $ret = User::where(['id' => $params['user_id']])->update(['trade_password' => $password]);
        if ($ret !== false) return JsonDataService::success('重置成功!');
        return JsonDataService::fail('操作失败!!');

    }

    /**
     * 保存成员在群中的昵称
     */
    public static function saveGroupNickName($params)
    {
        $where = ['list_id' => $params['list_id'], 'user_id' => $params['user_id']];
        $chat_member = ChatMember::where($where)->find();
        if (!$chat_member) return JsonDataService::fail('成员信息不存在!');
        $ret = ChatMember::where($where)->update(['nickname' => $params['nickname']]);
        if ($ret === false) return JsonDataService::fail('操作失败!');
        return JsonDataService::success('操作成功!');
    }

    /**
     * 群成员列表
     */
    public static function memberList($post_data)
    {
        $data = [];
        //群成员列表排除机器人和用户自己
        $member = ChatMember::field('user_id,is_admin,is_disturb,nickname')
            ->where([
                ['list_id', '=', $post_data['list_id']],
                ['user_id', '<>', 1],
                ['user_id', '<>', $post_data['user_id']]
            ])
            ->order('is_admin', 'DESC')
            ->order('time', 'ASC')
            ->select()
            ->toArray();


        $char_array = [];
        if (count($member)) {
            foreach ($member as $key => $value) {
                $db_user = UserService::getUserInfo($value['user_id']);
                if (empty($db_user)) {
                    unset($member[$key]);
                    continue;
                }
                if (($friend = Friend::where([
                        'user_id' => $post_data['user_id'],
                        'friend_id' => $value['user_id'],
                    ])->find()) && $friend->remarks) {
                    $show_name = $friend->remarks;
                } else {
                    $show_name = $db_user['nickname'];
                }
                //如果有群备注就显示群备注
                $name = $value['nickname'] ? $value['nickname'] : $show_name;
                $char = NameFirstChar::get($name);
                $char_array[$char][] = [
                    'photo' => $db_user['face'],
                    'user_id' => $value['user_id'],
                    'name' => $name,
                ];
            }
            foreach ($char_array as $key => $value) {
                $index = NameFirstChar::findIndex($key);
                $data[] = [
                    'letter' => $key,
                    'data' => $value,
                    'index' => $index,
                ];
            }
        }
        $is_field = array_column($data, 'letter');
        array_multisort($is_field, SORT_ASC, $data);
        $data = array_column($data, NULL, 'index');

        $member = [];
        $data = object_to_array($data);
        return JsonDataService::success('', ['data' => $data, 'member' => $member]);
    }

    /**
     * 通知群主
     */
    public static function noticeMember($params = array())
    {
        $user_id = $params['user_id'];
        $user_info = UserService::getUserInfo($user_id);
        if (empty($user_info)) return false;
        //查询出用户所在的群
        $list = ChatMember::where(['user_id' => $user_id])->select()->toArray();
        if (!empty($list)) {
            foreach ($list as $v) {
                $group = ChatGroup::where(['list_id' => $v['list_id']])->find();
                if (!$group || $group['main_id'] == $user_id) continue;
                //通知群主
                MsgService::senNormalMsgToUid($group['main_id'], 'memberIsOnline');
            }
        }
    }

    public static function addGroup($params)
    {
        $list_id = $params['list_id'];
        $user_id = $params['user_id'];
        if (ChatMember::where([
            'list_id' => $list_id,
            'user_id' => $user_id
        ])->find()) {
            return JsonDataService::fail('这个用户已经加入群了');
        }
        $chat_user_ids = ChatList::field('user_ids')->where('list_id', $list_id)->find()->user_ids;
        $chat_user_ids = json_decode($chat_user_ids, true);
        $chat_user_ids[] = $user_id;
        sort($chat_user_ids);
        $chat_user_ids_string = json_encode($chat_user_ids);

        /** 增加会话列表 */
        ChatList::create([
            'user_id' => $user_id,
            'list_id' => $list_id,
            'user_ids' => $chat_user_ids_string,
            'type' => 1,
        ]);

        /** 增加到成员表 */
        ChatMember::create([
            'list_id' => $list_id,
            'user_id' => $user_id,
            'invite_id' => $params['invite_user_id'] ? intval($params['invite_user_id']) : 0,
            'is_admin' => 0,
        ]);

        $content = [
            'text' => User::get($user_id)->username . ' 加入群聊',
        ];

        /** 增加一条系统消息 */
        $chat_obj = Chat::createChatMsg([
            'list_id' => $list_id,
            'user_id' => 0,
            'content_type' => 0,
            'msg_type' => 1,
            'content' => $content,
            'time' => time(),
        ]);

        $msg = [
            'list_id' => $list_id,
            'data' => [
                'type' => 1,
                'msg' => [
                    'user_info' => [
                        'uid' => 0,
                    ],
                    'id' => $chat_obj->id,
                    'type' => 0,
                    'content' => $content,
                    'time' => time(),
                ],
            ],
        ];

        /** 通知被邀请的人重新获取会话列表 */
        MsgService::senNormalMsgToUid($user_id, 'getChatList');

        /** 通知群所有人新成员的加入 */
        foreach ($chat_user_ids as $user_id) {
            MsgService::senNormalMsgToUid($user_id, 'chatData', $msg);
        }

        return JsonDataService::success('邀请成功!');
    }

    /**
     * 获取邀请人名称
     */
    public static function getInviteName($params)
    {
        $user_id = $params['user_id'] * 1;
        $list_id = $params['list_id'];
        $group = ChatGroup::where(['list_id' => $list_id])->find();
        $user_info = UserService::getUserInfo($user_id);
        if ($group['main_id'] == $user_id) return JsonDataService::success('', ['invite_name' => $user_info['nickname'], 'invite_id' => $user_id]);
        $main_info = UserService::getUserInfo($group['main_id']);
        $reply = ChatGroupApply::where(['invite_to_user_id' => $user_id, 'list_id' => $list_id])->order('time', 'desc')->find();
        if (!$reply || $reply['invite_user_id'] == $reply['invite_to_user_id']) return JsonDataService::success('', ['invite_name' => $main_info['nickname'],'invite_id'=>$group['main_id']]);
        $chat_member = ChatMember::where(['user_id' => $reply['invite_user_id'], 'list_id' => $list_id])->find();
        if (!$chat_member) return JsonDataService::success('', ['invite_name' => $main_info['nickname'],'invite_id'=>$group['main_id']]);
        $invite_user = UserService::getUserInfo($reply['invite_user_id']);
        if (!$invite_user) return JsonDataService::success('', ['invite_name' => $main_info['nickname'],'invite_id'=>$group['main_id']]);
        $name = $chat_member['nickname'] ? $chat_member['nickname'] : $invite_user['nickname'];
        return JsonDataService::success('', ['invite_name' => $name, 'invite_id' => $invite_user['id']]);
    }

    /**
     * 转让群
     */
    public static function transferQun($params)
    {
        $user_id = $params['user_id'];
        $list_id = $params['list_id'];
        $trans_user_id = $params['trans_user_id'] * 1;
        //查询出群
        $group = ChatGroup::where(['list_id' => $list_id])->find();
        if (empty($group)) return JsonDataService::fail('该群不存在!');
        if ($trans_user_id == $user_id) return JsonDataService::fail('不能转让给自己!');
        if ($group['main_id'] != $user_id) return JsonDataService::fail('您不是群主暂不能转让!');
        $trans_user = ChatMember::where(['list_id' => $list_id, 'user_id' => $trans_user_id])->find();
        if (empty($trans_user)) return JsonDataService::fail('要转让的成员不在该群!');
        //判断用户
        $trans_user_info = UserService::getUserInfo($trans_user_id);
        if (empty($trans_user_info) || $trans_user_info['status'] != 0) return JsonDataService::fail('转让者帐号状态异常不能转让!');

        //开始转让
        $ret_1 = $group->save(['main_id' => $trans_user_id]);
        if ($ret_1 === false) return JsonDataService::fail('转让失败1!');
        $ret_2 = $trans_user->save(['is_admin' => 1]);
        if ($ret_2 === false) return JsonDataService::fail('转让失败2!');
        $ret_3 = ChatMember::where(['list_id' => $list_id, 'user_id' => $user_id])->update(['is_admin' => 0]);
        if ($ret_3 === false) return JsonDataService::fail('转让失败3!');
        VendorUser::where(['list_id' => $list_id])->update(['user_id' => $trans_user_id]);
        UserLog::create([
            'user_id' => $user_id,
            'remark' => date('Y-m-d H:i:s') . '转让给用户user_id:' . $trans_user_id . '群:' . $group['id'] . '插件:' . $list_id,
        ]);
        //发送消息
        $nickname = $trans_user_info['nickname'];
        self::sendSysMsg($params['list_id'], $nickname . '成为了新的群主');
        return JsonDataService::success('转让成功!');

    }

    /**
     * 发送系统消息
     */
    public static function sendSysMsg($list_id, $text = '')
    {
        $content = [
            'text' => $text,
        ];
        /** 增加一条系统消息 */
        $chat_obj = Chat::createChatMsg([
            'list_id' => $list_id,
            'user_id' => 0,
            'content_type' => 0,
            'msg_type' => 1,
            'content' => $content,
            'time' => time(),
        ]);

        $send['action'] = 'chatData';
        $send['user_id'] = 0;
        $send['list_id'] = $list_id;
        $send['sendData'] = [
            'list_id' => $list_id,
            'data' => [
                'type' => 1,
                'msg' => [
                    'id' => $chat_obj->id,
                    'type' => 0,
                    'time' => time(),
                    'user_info' => [
                    ],
                    'content' => $content,
                ],
            ]
        ];
        MsgService::sendMsg($send, 1);
    }

    /**
     * 24小时后没有领取的红包自动退回
     */
    public static function backRedpackage()
    {
        //查询出所有一天之前的红包
        $time = strtotime('-1 days', strtotime(date('Y-m-d H:i:s')));
        $arr = HongBao::where([
            ['time', '<', $time],
            ['sy_money', '>', 0],
            ['is_back', '=', 0],
        ])->select()->toArray();
        print_r($arr);
        if (!empty($arr)) {
            foreach ($arr as $v) {
                $user = UserService::getUserInfo($v['user_id']);
                $ret = CapitalLog::where(['order_id' => $v['id'], 'capital_type' => 11])->find();
                if (!$ret && $user && $v['sy_money'] > 0) {
                    //更改状态
                    $ret_1 = HongBao::where(['id' => $v['id']])->update(['is_back' => 1]);
                    //创建流水
                    CapitalLog::create([
                        'user_id' => $v['user_id'],
                        'money' => $v['sy_money'],
                        'user_money' => bcadd($v['sy_money'], $user['money'], 2),
                        'explain' => '红包退回',
                        'record_type' => 1,
                        'capital_type' => 11,
                        'order_id' => $v['id'],
                    ]);
                    //增加钱
                    User::where(['id' => $v['user_id']])->setInc('money', $v['sy_money']);
                } else {
                    HongBao::where(['id' => $v['id']])->update(['is_back' => 1]);
                }
            }
        }
    }

    /**
     * 获取成员数据
     */
    public static function getMemberData($post_data = array())
    {
        $user_id = $post_data['user_id'];
        if (!isset($post_data['list_id']) || !isset($post_data['type'])) {
            return JsonDataService::fail('参数错误');
        }
        $group_data = ChatGroup::field('main_id')->where('list_id', $post_data['list_id'])->find();
        if (!$group_data) {
            return JsonDataService::fail('没有这条群聊消息');
        }

        if ($group_data->main_id != $user_id) {
            $return_data['msg'] = '你没有权限,操作已取消';
            return json($return_data);
        }

        /** 如果是群主自己，获得除自己所有成员数据，如果是管理员，获得除去自己，除去管理员的数据 */
        if ($group_data->main_id == $user_id) {
            $where = [
                ['list_id', '=', $post_data['list_id']],
                ['user_id', '<>', 1],
            ];
        }
        $db_data = ChatMember::field('user_id,nickname,is_admin,is_msg')
            ->where($where)
            ->select()
            ->toArray();
        $char_array = [];
        $data = [];
        $user_ids = [];
        if (count($db_data)) {
            foreach ($db_data as $key => $value) {
                $User = User::field('nickname,sex')->get($value['user_id']);
                if (!$User) {
                    unset($db_data[$key]);
                    continue;
                }
                if ($value['nickname']) {
                    $name = $value['nickname'];
                } else {
                    $name = $User->nickname;
                }
                $user_state_obj = UserState::field('photo')->where('user_id', $value['user_id'])->find();
                $face = getShowPhoto($user_state_obj, $User->sex, $value['user_id'], 300);
                $char = NameFirstChar::get($name);

                $is_admin = false;
                switch ($post_data['type']) {
                    case 1:
                        if ($value['is_admin']) {
                            $is_admin = true;
                            $user_ids[] = $value['user_id'] . '';
                        }
                        break;
                    case 2:
                        if ($value['is_msg']) {
                            $is_admin = true;
                            $user_ids[] = $value['user_id'] . '';
                        }
                        break;
                    case 3:
                        if ($value['is_admin']) {
                            $is_admin = true;
                            $user_ids[] = $value['user_id'] . '';
                        }
                        break;
                    default:
                        $return_data['msg'] = '未知类型';
                        return json($return_data);
                        break;
                }
                $char_array[$char][] = [
                    'photo' => $face,
                    'user_id' => $value['user_id'],
                    'name' => $name,
                    'is_admin' => $is_admin,
                ];
            }
            foreach ($char_array as $key => $value) {
                $data[] = [
                    'letter' => $key,
                    'data' => $value,
                ];
            }
        }
        $is_field = array_column($data, 'letter');
        array_multisort($is_field, SORT_ASC, $data);

        $return_data = [
            'err' => 0,
            'data' => [
                'list' => $data,
                'user_ids' => $user_ids,
            ],
        ];
        return JsonDataService::success('', ['list' => $data, 'user_ids' => $user_ids]);
    }

    /**
     * 复制新群
     */
    public static function copyNewQun($post_data = array())
    {
        //main_id  jiesan = 1/0 list_id
        //先复制群
        $user_id = $post_data['user_id'];
        $old_list_id = $post_data['list_id'];
        $member = ChatMember::where([
            'user_id' => $user_id,
            'list_id' => $old_list_id,
        ])->find();
        if (empty($member) || $member['is_admin'] != 1) return JsonDataService::fail('您无权限操作!');
        //先复制群
        $group = ChatGroup::where(['list_id' => $old_list_id])->find();
        if (!$group) return JsonDataService::fail('群不存在!');
        if ($group['main_id'] != $user_id) return JsonDataService::fail('只有群主才能复制群哦!');
        //查询出成员
        //创建聊天
        $ret = [];
        $list_id = create_guid();
        $member_list = ChatMember::where([
            'list_id' => $old_list_id,
        ])->select()->toArray();
        if (!$member_list) return JsonDataService::fail('群成员不存在!');

        $user_names = '';
        //合成群头像

        //机器人进群
        $user_ids_arr = array_values(array_column($member_list, 'user_id'));
        sort($user_ids_arr);
        $chat_user_ids = json_encode($user_ids_arr, 256);
        UserStateService::setGroupPhoto(['list_id' => $list_id, 'user_ids' => $user_ids_arr, 'main_id' => $post_data['main_id']]);
        /** 增加到群表 */
        ChatGroup::create([
            'list_id' => $list_id,
            'main_id' => $post_data['main_id'],
            'can_niming' => 0,
            'name' => '群聊(新)',
            'agent_id' => $post_data['_agent_id'],
        ]);
        foreach ($member_list as $v) {
            /** 增加会话列表 */
            ChatList::create([
                'user_id' => $v['user_id'],
                'list_id' => $list_id,
                'user_ids' => $chat_user_ids,
                'type' => 1,
                'last_chat_time' => time(),
            ]);
            /** 增加到成员表 */
            ChatMember::create([
                'list_id' => $list_id,
                'user_id' => $v['user_id'],
                'is_admin' => $v['is_admin'],
            ]);
            $user_names .= ($user_names ? ',' : '') . User::field('nickname')->get($v['user_id'])->nickname;
        }
        /** 增加一条系统消息 */
        $chat_obj = Chat::createChatMsg([
            'list_id' => $list_id,
            'user_id' => 0,
            'content_type' => 0,
            'msg_type' => 1,
            'content' => [
                'text' => $user_names . ' 加入群聊',
            ],
            'time' => time(),
        ]);

        foreach ($member_list as $val) {
            /** 通知双方重新获取列表数据 */
            SendData::sendToUid($val['user_id'], 'getChatList');
        }
        $return_data['err'] = 0;
        $return_data['msg'] = '已成功创建';
        //解算群
        if ($post_data['jiesan'] == 1) self::removeGroup($post_data);

        return JsonDataService::success('已成功创建');
    }

    /**
     * 解散群
     * @param $post_data
     * @return mixed
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\db\exception\PDOException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public static function removeGroup($post_data)
    {
        if (!isset($post_data['list_id'])) {
            return JsonDataService::fail('参数错误!');
        }
        $list_data = ChatList::field('type')->where('list_id', $post_data['list_id'])->find();
        if (!$list_data) {
            return JsonDataService::fail('没有找到对话数据!');
        }
        if ($list_data->type != 1) {
            return JsonDataService::fail('不是群聊不能解散!');
        }
        $group_data = ChatGroup::field('main_id,name')->where('list_id', $post_data['list_id'])->find();
        if (!$group_data) {
            return JsonDataService::fail('群数据有误!');
        }
        if ($group_data->main_id != $post_data['user_id']) {
            return JsonDataService::fail('不是群主,没有权限操作!');
        }
        /** 删除对话数据 */
        Chat::where('list_id', $post_data['list_id'])->delete();
        /** 删除对话列表数据 */
        ChatList::where('list_id', $post_data['list_id'])->delete();
        /** 删除群表数据 */
        ChatGroup::where('list_id', $post_data['list_id'])->delete();
        /** 删除群申请数据表数据 */
        ChatGroupApply::where('list_id', $post_data['list_id'])->delete();
        /** 通知所有成员群解散 */
        foreach (ChatMember::field('user_id')->where('list_id', $post_data['list_id'])->select() as $item) {
            SendData::sendToUid($item->user_id, 'removeGroup', [
                'list_id' => $post_data['list_id'],
                'group_name' => $group_data->name,
            ]);
        }
        /** 删除成员表数据 */
        ChatMember::where('list_id', $post_data['list_id'])->delete();

        return JsonDataService::success('解散成功!');
    }

    /**
     * 获取群详情
     */
    public static function getRoomInfo($post_data)
    {
        $num = ChatMember::field('user_id,is_admin,is_disturb,nickname')
            ->where([
                ['list_id', '=', $post_data['list_id']],
                ['user_id', '<>', 1]
            ])
            ->count();

        $group = ChatGroup::where('list_id', $post_data['list_id'])
            ->find()->toArray();
        if (isset($group['is_photo']) && $group['is_photo']) {
            $photo_path = '/group_photo/' . $post_data['list_id'] . '/90.jpg';
        } else {
            $photo_path = 'default_group_photo/90.jpg';
        }
        $group['photo_path'] = $photo_path;
        return JsonDataService::success('', ['num' => $num, 'group' => $group]);

    }

    /*
     * 振动
     */
    public static function zhendong($post_data)
    {
        $ret = JsonDataService::fastClick($post_data['user_id']);
        if (!JsonDataService::checkRes($ret)) return $ret;
        $user = UserService::getUserInfo($post_data['user_id']);
        if (!$user) return JsonDataService::fail();
        //增加一条消息
        $params['action'] = 'zhenDong';
        $params['list_id'] = $post_data['list_id'];
        $params['user_id'] = $post_data['user_id'];
        $params['sendData'] = [
            'list_id' => $params['list_id'],
            'user_id' => $params['user_id'],
        ];
        //发个振动
        MsgService::sendMsg($params);
        $content = ['text' => '群主大大发起了集合'];
        $chat = Chat::createUserMsg([
            'list_id' => $params['list_id'],
            'user_id' => $params['user_id'],
            'content_type' => 0,
            'content' => $content
        ]);
        MsgService::sendChatDataMsgToAll($params['list_id'], $params['user_id'], $chat->id, 0, $content, 0);
        return JsonDataService::success();
    }

    /**
     * 编辑
     */
    public static function editChange($post_data = array())
    {
        if (!(ChatGroup::where([
            'list_id' => $post_data['list_id'],
            'main_id' => $post_data['user_id'],
        ])->find())) {
            //不是群组和管理员没有权限
            return JsonDataService::fail('没有权限设置');
        }
        //can_add_friend
        ChatGroup::where('list_id', $post_data['list_id'])->update([
            'edit_photo' => $post_data['value'] * 1
        ]);
        $return_data['err'] = 0;
        $return_data['msg'] = 'success';
        return JsonDataService::success('success');
    }


    /**
     * 红包切换
     */
    public static function getRedChange($post_data)
    {
        if (!(ChatGroup::where([
            'list_id' => $post_data['list_id'],
            'main_id' => $post_data['user_id'],
        ])->find())) {
            //不是群组和管理员没有权限
            return JsonDataService::fail('没有权限设置');
        }
        //can_add_friend
        ChatGroup::where('list_id', $post_data['list_id'])->update([
            'can_get_bigred' => $post_data['value'] * 1
        ]);
        $return_data['err'] = 0;
        $return_data['msg'] = 'success';
        return JsonDataService::success('success');
    }

    /**
     * 查找出十分钟之前的红包
     */
    public static function getExpireBigRed($params = array())
    {
        $end = strtotime('-10 minute', strtotime(date('Y-m-d H:i:s')));
        $red_list = HongBao::where([
            ['list_id', '=', $params['list_id']],
            ['sy_number', '>', 0],
            ['is_back', '=', 0],
            ['time', '<=', $end],
        ])->select()->toArray();
        if (!empty($red_list)) {
            foreach ($red_list as $key => &$v) {
                $get = HongBaoDetails::where(['user_id' => $v['user_id'], 'hongbao_id' => $v['id']])->find();
                if ($get) {
                    unset($red_list[$key]);
                    continue;
                }
                $v['user_info'] = UserService::getUserInfo($v['user_id']);
            }
        }
        return JsonDataService::success('未领取红包列表', $red_list);
    }

    /**
     * 发送戳一戳消息
     * @param array $prams
     */
    public static function sendChuoYiChuoMsg($params = array())
    {
        $user = UserService::getUserInfo($params['user_id']);
        $content = ['text' => $user['nickname'] . '戳了一下'];
        $chat = Chat::createUserMsg([
            'list_id' => $params['list_id'],
            'user_id' => $params['user_id'],
            'content_type' => 9,
            'content' => $content
        ]);
        return MsgService::sendChatDataMsgToAll($params['list_id'], $params['user_id'], $chat->id, 9, $content, 0);
    }

    /**
     * 获取用户流水
     */
    public static function getUserCapitalList($params = array())
    {
        $user_id = $params['user_id'];
        $user = UserService::getUserInfo($user_id);
        if (empty($user)) return JsonDataService::fail('用户信息不存在!');
        $query = CapitalLog::where(['user_id' => $user_id]);
        $query = $query->where(['capital_type' => [1, 2, 3, 4, 5, 6]]);
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
        //默认是收到
        if ($params['get'] == 1) {
            $query = $query->where(['record_type' => 1]);
        } else {
            $query = $query->where(['record_type' => 0]);
        }
        $query = $query->where([
            ['create_time', '>=', $begin],
            ['create_time', '<=', $end],
        ]);
        $total_money = $query->sum('money');
        $capitalList = $query->order('id', 'desc')->paginate(10)->toArray();
        $capitalList['info'] = ['amount' => $total_money, 'user_money' => $user['money']];
        $capitalList['sql'] = CapitalLog::getLastSql();
        return JsonDataService::success('账单', $capitalList);
    }

    /**
     * 获取文章列表
     */
    public static function getArticleList($params = array())
    {
        $list = Article::where(['status' => 1])->order(['sort' => 'asc', 'id' => 'desc'])->select()->toArray();
        return JsonDataService::success('', $list);
    }

    /**
     * 获取文章详情
     */
    public static function getArticleDetail($pramas = array())
    {
        $article = Article::find($pramas['article_id']);
        if (!$article) return JsonDataService::fail('文章不存在!');
        return JsonDataService::success('', $article);
    }

    /**
     * 获取收藏的数据
     */
    public static function getUserStore($params = array())
    {
        $user_info = UserService::getUserInfo($params['user_id']);
        if (!$user_info) return JsonDataService::fail('收藏失败!');
        $query = Store::where(['user_id' => $params['user_id']]);
        if (isset($params['type']) && $params['type']) {
            $query = $query->where(['type' => $params['type'] * 1]);
        }
        $query = $query->order('time', 'desc')->paginate(10)->toArray();
        if ($query['data']) {
            foreach ($query['data'] as $key => $v) {
                $query['data'][$key]['user_info'] = UserService::getUserInfo($v['to_user_id']);
            }
        }
        $query['info']['user_storge_count'] = Store::where(['user_id' => $params['user_id']])->count();
        $query['info']['user_storge'] = format_file_size($user_info['storge']);
        $query['info']['max_count'] = self::MAX_COUNT;
        $query['info']['max_storge'] = format_file_size(self::MAX_STORGE);
        $query['info']['user_info'] = $user_info;
        return JsonDataService::success('', $query);
    }

    /**
     * type = 1 文字 2 图片 3 语音 4 视频
     * 创建用户的收藏记录
     */
    public static function createStore($params = array())
    {
        $size = Store::getSize($params['type'], $params['value']);
        return Store::create([
            'user_id' => $params['user_id'],
            'type' => $params['type'],
            'time' => time(),
            'size' => $size,
            'to_user_id' => $params['to_user_id'],
            'list_id' => $params['list_id'],
            'chat_id' => $params['chat_id'],
            'content' => $params['content'],
        ]);
    }

    /**
     * 收藏聊天记录
     * @param array $params
     */
    public static function saveStore($params = array())
    {
        $chat_info = Chat::find($params['msg_id'])->toArray();
        $type = $chat_info['content_type'];

        switch ($type) {
            case 0:
                /** 文本 */
                $store_type = 1;
                $value = $chat_info['content']['text'];
                $content = ['text' => $value];
                break;
            case 1:
                /** 语音 */
                $store_type = 3;
                $value = $chat_info['content']['url'];
                $content = ['url' => $value, 'length' => $chat_info['content']['length']];
                break;
            case 2:
                /** 图片 */
                $store_type = 2;
                $value = $chat_info['content']['url'];
                $content = ['url' => $value, 'w' => $chat_info['content']['w'], 'h' => $chat_info['content']['h']];
                break;
            case 3:
                /** 视频 */
                $store_type = 4;
                $value = $chat_info['content']['url'];
                $content = ['url' => $value, 'image' => $chat_info['content']['save_pic_path']];
                break;
            default:
                /** 未知消息类型 */
                return JsonDataService::success('此类型消息不能收藏');
                break;
        }
        $ret = self::createStore([
            'user_id' => $params['user_id'],
            'list_id' => $chat_info['list_id'],
            'chat_id' => $chat_info['id'],
            'type' => $store_type,
            'to_user_id' => $chat_info['user_id'],
            'value' => $type == 0 ? $value : get_chat_img($chat_info['list_id'], $value),
            'content' => $content,
        ]);
        User::where(['id' => $params['user_id']])->setInc('storge', $ret->size);
        if ($ret === false) return JsonDataService::fail('收藏失败!');
        return JsonDataService::success('收藏成功！');
    }

    /**
     * 获取收藏统计
     */
    public static function getStoreStatics($params = array())
    {
        $user_info = UserService::getUserInfo($params['user_id']);
        $s_store_1 = Store::where(['user_id' => $params['user_id'], 'type' => 1])->sum('size');
        $c_store_1 = Store::where(['user_id' => $params['user_id'], 'type' => 1])->count();

        $s_store_2 = Store::where(['user_id' => $params['user_id'], 'type' => 2])->sum('size');
        $c_store_2 = Store::where(['user_id' => $params['user_id'], 'type' => 2])->count();

        $s_store_3 = Store::where(['user_id' => $params['user_id'], 'type' => 3])->sum('size');
        $c_store_3 = Store::where(['user_id' => $params['user_id'], 'type' => 3])->count();

        $s_store_4 = Store::where(['user_id' => $params['user_id'], 'type' => 4])->sum('size');
        $c_store_4 = Store::where(['user_id' => $params['user_id'], 'type' => 4])->count();

        //总大小
        //已经用大小
        $ret['list']['s1'] = format_file_size($s_store_1);
        $ret['list']['c1'] = $c_store_1;
        $ret['list']['s2'] = format_file_size($s_store_2);
        $ret['list']['c2'] = $c_store_2;
        $ret['list']['s3'] = format_file_size($s_store_3);
        $ret['list']['c3'] = $c_store_3;
        $ret['list']['s4'] = format_file_size($s_store_4);
        $ret['list']['c4'] = $c_store_4;

        $ret['info']['user_storge_count'] = Store::where(['user_id' => $params['user_id']])->count();
        $ret['info']['user_storge'] = format_file_size($user_info['storge']);
        $ret['info']['max_storge'] = self::MAX_STORGE;
        $ret['info']['max_count'] = self::MAX_COUNT;
        $ret['info']['rate_1'] = bcdiv($ret['info']['user_storge'], $ret['info']['max_storge'], 4) * 100;
        $ret['info']['rate_2'] = bcdiv($ret['info']['user_storge_count'], $ret['info']['max_count'], 4) * 100;;
        $ret['info']['splus_storge'] = format_file_size(bcsub(self::MAX_STORGE, $ret['info']['user_storge'], 2));
        $ret['info']['splus_count'] = bcsub(self::MAX_COUNT, $ret['info']['user_storge_count']);
        return JsonDataService::success('', $ret);
    }

    public static function deleteStore($params = array())
    {
        $store_info = Store::where(['id' => $params['id'], 'user_id' => $params['user_id']])->find();
        if (empty($store_info)) return JsonDataService::fail('操作失败!');
        $ret = $store_info->delete();
        if ($ret === false) return JsonDataService::fail('操作失败!');
        return JsonDataService::success('操作成功!');
    }

    /**
     * 获取成员头像
     */
    public static function getMemberPhotos($params = array())
    {
        $list = ChatMember::where([
            ['list_id', '=', $params['list_id']],
            ['user_id', '<>', 1],
        ])->limit(10)->field('user_id')->select()->toArray();
        foreach ($list as $key => &$v) {
            $user_info = UserService::getUserInfo($v['user_id']);
            if ($user_info) $v['photo'] = $user_info['face'];
            else unset($list[$key]);
        }
        return JsonDataService::success('', $list);
    }

    /**
     * 转发消息
     */
    public static function transUserStore($params = array())
    {
        $trans_id = $params['trans_id'];
        $list_id = $params['list_id'];
        $store_info = Store::find($trans_id);
        $source_dir = CHAT_PATH.$store_info['list_id'].'/';
        $to_dir = CHAT_PATH.$list_id.'/';
        switch (true) {
            case $store_info['type'] == 1: //文本
//                {"text":"213"}
                $content_type = 0;
                $content = $store_info['content'];
                break;
            case $store_info['type'] == 2: //图片
                //获取图片宽高
                $content_type = 2;
                $w = $store_info['content']['w'] ?? '180';
                $h = $store_info['content']['h'] ?? '180';
                $url = $store_info['content']['url'];
                $content = ['w' => $w, 'h' => $h, 'url' => $url];
                $image_arr = explode('.',$url);
                $source_file =  $source_dir.$url;
                //复制缩略图
                $image = Image::open($source_file);
                $path_name = $to_dir.$image_arr[0].'_thumb.'.$image_arr[1];
                $image->thumb($w,$h)->save($path_name);
                copyResource($source_file,$to_dir,$url);
                //                {"url":"20201009/545af5d1e1213fb3cbb5bbb4cf82ea21.png","w":480,"h":762,"save_pic_path":""}
                break;
            case $store_info['type'] == 3: //语音
                //{url:'',length:''}
                $content_type = 1;
                $content = $store_info['content'];
                $source_file = $source_dir.$store_info['content']['url'];
                copyResource($source_file,$to_dir,$store_info['content']['url']);
                break;
            case $store_info['type'] == 4: //视频
                $content_type = 3;
                //{"url":"20201009/cd4549caa4fc0c22f494168f57c4abe3.MP4","length":"433584:06","save_pic_path":"6FDCADAC229859FD1788B4FA6A88A5B0.jpg"}
                $save_pic_path = $store_info['content']['image'];
                $url = $store_info['content']['url'];
                //复制视频
                $source_file = $source_dir.$url;
                copyResource($source_file,$to_dir,$url);
                //复制图片
                $image_file = $source_dir.$save_pic_path;
                copyResource($image_file,$to_dir,$save_pic_path);
                $content = ['save_pic_path' => $save_pic_path, 'url' => $url];
                break;
            default:
                $content_type = 0;
                $content = $store_info['content'];
        }
       return MsgService::textMsg([
            'content_type'=>$content_type,
            'content'=>$content,
            'list_id'=>$list_id,
            '_agent_id'=>1,
            'user_id'=>$params['user_id'],
        ]);
    }

    /**
     * 加入语音聊天室
     */
    public static function joinVoiceRoom($params = array()){
        //给其他人发送广播加入房间
        //设置用户语音聊天状态 (onShwo的时候去获取,如果存在)
       $ret = JsonDataService::fastClick(ConfigService::JOINVOICEROOM.$params['list_id']);
       if(!JsonDataService::checkRes($ret)) return JsonDataService::fail('已有人抢到房主啦!');
        //查询是否创建了房间
        $room_info = VoiceRoom::where(['list_id'=>$params['list_id']])->find();
        if(!$room_info){
            $room_key = ConfigService::TENDENCE_VOICE_ROOMID;
            $roomid = RedisService::get($room_key);
            if(!$roomid){
                $roomid = 10000;
                RedisService::set($room_key,$roomid);
            }else{
                $roomid = RedisService::inc($room_key);
            }
            VoiceRoom::create([
                'roomid'=>$roomid,
                'user_id'=>$params['user_id'],
                'list_id'=>$params['list_id'],
                'member_count'=>1,
                'user_ids'=>[$params['user_id']],
            ]);
        }else{
            //创建过房间
            $roomid = $room_info['roomid'];
            //将房间人数重置为1人
            $room_info->save(['user_id'=>$params['user_id'],'member_count'=>1,'user_ids'=>[$params['user_id']]]);
        }
        //请求API生成密钥
       $api = VedioSdk::joinRoom($params['user_id'],$roomid);
        //首先先把其他房间得状态设置未0
        ChatMember::where(['user_id'=>$params['user_id']])->update(['voice_room_state'=>0]);
        ChatMember::where([
            ['list_id','=',$params['list_id']],
            ['user_id','<>',$params['user_id']]
        ])->update(['voice_room_state'=>1]);
        //
        MsgService::setNormalMsgToAll($params['user_id'],$params['list_id'],'getVoiceRoom',['roomid'=>$roomid,'list_id'=>$params['list_id']],[$params['user_id']]);
        return JsonDataService::success('加入房间',$api);
    }

    /**
     * 检查语音房间状态并加入
     * @param array $params
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think
     */
    public static function checkVoiceRoomState($params = array()){
       $ret =  VoiceRoom::where(['list_id'=>$params['list_id']])->find();
        if($ret && $ret['member_count'] > 0 && !in_array($params['user_id'],$params['user_ids'])){
           //加入房间
            $roomid = $ret['roomid'];
            $api = VedioSdk::joinRoom($params['user_id'],$roomid);
            return JsonDataService::success('加入房间!',$api);
       }
       return JsonDataService::fail('');
    }

    /**
     * 加入成功之后
     */
    public static function setVoiceRoomMsg($params = array()){
        $user = UserService::getUserInfo($params['user_id']);
        $text= $user['nickname'].($params['type']?'上麦了':'下麦了');
        $chat = Chat::createSysMsg([
            'list_id' => $params['list_id'],
            'user_id' => $params['user_id'],
            'content_type' => 0,
            'content' => $text,
        ]);
        //返回在线人数
        $room = VoiceRoom::where(['list_id'=>$params['list_id']])->find();
        if(in_array($params['user_id'],$room['user_ids'])){
            MsgService::sendChatDataMsgToAll($params['list_id'], $params['user_id'], $chat->id, 0, ['text'=>$text], 1);
        }
        if($params['type'])$num = VoiceRoom::setIncMenBerCount($params['list_id'],$params['user_id']);
            else $num = VoiceRoom::setDecMenBerCount($params['list_id'],$params['user_id']);
        //判断是否在聊天室内

        if($num == 0 && in_array($params['user_id'],$room['user_ids'])){
            MsgService::setNormalMsgToAll($params['user_id'],$params['list_id'],'closeVoiceRoom',[],[$params['user_id']]);
        }
        return JsonDataService::success('',$num);
    }


    /**
     * 成员加入房间
     * @param array $params
     */
    public static function memberjoinVoiceRoom($params = array()){
        $room_info = VoiceRoom::where(['list_id'=>$params['list_id']])->find();
        if(empty($room_info)) return JsonDataService::fail('加入QT失败!');
        $api = VedioSdk::joinRoom($params['user_id'],$room_info['roomid']);
        return JsonDataService::success('成员加入',$api);
    }


    /**
     * 设置上麦
     * @param array $params
     */
    public static function setShangmai($params = array()){
        if (!(ChatGroup::where([
            'list_id' => $params['list_id'],
            'main_id' => $params['user_id'],
        ])->find())) {
            //不是群组和管理员没有权限
            return JsonDataService::fail('没有权限设置');
        }
        //can_add_friend
        ChatGroup::where('list_id', $params['list_id'])->update([
            'can_shangmai' => $params['value'] * 1
        ]);
        $return_data['err'] = 0;
        $return_data['msg'] = 'success';
        return JsonDataService::success('success');
    }
}