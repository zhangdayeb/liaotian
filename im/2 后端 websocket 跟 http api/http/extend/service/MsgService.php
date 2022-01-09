<?php
/**
 * Created by IntelliJ IDEA.
 * User: Administrator
 * Date: 2020-06-12
 * Time: 17:54
 */

namespace extend\service;


use app\im\model\mongo\Chat;
use app\im\model\mongo\ChatGroup;
use app\im\model\mongo\ChatList;
use app\im\model\mongo\ChatMember;
use app\im\model\mongo\UserState;
use \app\common\controller\SendData;
use app\im\model\mysql\User;
use app\super\model\BsysConfig;
use extend\sdk\tendence\im\VedioSdk;
use think\Exception;
use think\facade\Log;
use TLSSigAPI;

class MsgService
{
    /**
     * @param $params
     * @return array
     * user_id   用户ID
     * list_id   会话ID
     * content   会话内容
     * chat_id   会话id
     * chat_type 会话类型
     */
    public static function sendMsg($params = array(),$type =0)
    {
        //发客户端消息
        $user_info = UserService::getUserInfo($params['user_id']);
        if (!$user_info && !$type) return JsonDataService::fail('用户信息不存在!');
        $member = ChatMember::field('user_id')
            ->where('list_id', $params['list_id'])
            ->select()
            ->toArray();
        if (empty($member)) return JsonDataService::fail('会话列表不存在!');
        /** 这里通知其他对象 */
        foreach ($member as $value) {
            ChatList::where(['list_id'=>$params['list_id'],'user_id'=>$value['user_id']])->update(['last_chat_time'=>time()]);
            if ($params['user_id'] != $value['user_id']) {
                ChatList::where([
                    'list_id' => $params['list_id'],
                    'user_id' => ($value['user_id'] * 1),
                ])
                    ->setInc('no_reader_num', 1);
            }
            $params['sendData']['user_id'] = $value['user_id'];
            /** 发送通知 */
            if(isset($params['except_user_id']) && $params['except_user_id'] == $value['user_id']){
                continue;
            }
            SendData::sendToUid($value['user_id'], $params['action'], $params['sendData']);

        }
        return JsonDataService::success('发送消息成功!', $params['sendData']);
    }

    /**
     * 发送卡片消息
     * user_id list_id friend_ids
     */
    public static function sendCardMsg(array $params)
    {
        $user = UserService::getUserInfo($params['user_id']);
        if (!$user) return JsonDataService::fail();
        //查询出好友
        $ids = $params['friend_ids'];
        if (!$ids) return JsonDataService::fail();
        $ids = array_unique($ids);
        foreach ($ids as $id) {
            $friends_info = UserService::getUserInfo($id);
            if (!$friends_info) continue;
            //添加消息记录
            $params['action'] = 'sendCard';
            $params['sendData'] = [
                'list_id' => $params['list_id'],
                'user_info' => [
                    'user_id' => $params['user_id'],
                    'face' => $user['face']
                ],
                'friend_info' => [
                    'user_id' => $friends_info['id'],
                    'face' => $friends_info['face'],
                    'nickname' => $friends_info['nickname']
                ]
            ];
            self::sendMsg($params);
        }
        return JsonDataService::success();
    }

    /**
     * 取消会话
     * user_id list_id
     * @param array $params
     */
    public static function closeVideo(array $params)
    {
        $redis_key = ConfigService::VEDIO_FAST_CLICK.$params['list_id'].":".$params['content_type'];
        $flat = RedisService::setnx($redis_key,1,5);
        if(!$flat)return JsonDataService::success('fast click!');
        $user_info = UserService::getUserInfo($params['user_id']);
        if (!$user_info) return JsonDataService::fail();
        //添加一条系统消息
        $type_msg = $params['content_type'] == 6 ? '视频': '语音';
        $text = '取消了'.$type_msg.'通话';
        $redis_key = ConfigService::VEDIO_START_TIME.$params['content_type'].':'.$params['list_id'];
        $time = $params['time'];

        if($time){
            $time_info = explode(':',$time);
            $s = $time_info[count($time_info)-1];
            $m = $time_info[count($time_info)-2];
            $s = intval($s);
            $m = intval($m);
            if($s || $m){
                if($s>0){
                    $m = intval($m) +1;
                }
                RedisService::del($redis_key);
                $text = $type_msg.'通话结束,时长:'.intval($m).'分钟';

            }
        }
        $chat = Chat::createUserMsg([
            'text' => $text,
            'content_type' => $params['content_type'],
            'user_id' => $user_info['id'],
            'list_id' => $params['list_id'],
        ]);
        //发送系统消息
        $send['action'] = 'chatData';
        $send['user_id'] = $params['user_id'];
        $send['list_id'] = $params['list_id'];
        $send['sendData'] = [
            'list_id' => $params['list_id'],
            'data' => [
                'type' => 0,
                'msg' => [
                    'id' => $chat->id,
                    'type' => $params['content_type'],
                    'time' => time(),
                    'user_info' => [
                        'uid' => $params['user_id'],
                        'name' => $user_info['username'],
                        'face' => $user_info['face'],
                    ],
                    'content' => ['text' => $text],
                ],
            ]
        ];

        self::sendMsg($send);

        //取消视频
        $send2['action'] = 'cancleVedio';
        $send2['roomid'] = $params['roomid'];
//        $send['except_user_id'] = $params['roomid'];
        $send2['user_id'] = $params['user_id'];
        $send2['list_id'] = $params['list_id'];
        $send2['sendData'] = [
            'list_id' => $params['list_id'],
            'prompt' => $text,
            'user_id' => $params['user_id'],
            'username' => $user_info['username'],
            'face' => $user_info['face']
        ];
        $ret = self::sendMsg($send2);
        //销毁房间和时时支付
        $redis_key = ConfigService::VIDEO_CALL_ROOM.$params['list_id'];
        $pay_key =  ConfigService::VIDEO_CALL_PAY.$params['list_id'];
        RedisService::del($redis_key);
        RedisService::del($pay_key);
        return JsonDataService::success('',$ret);
    }



    /**
     * @param array $post_data
     * @return array
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function sendVideo(array $post_data)
    {
        $type_msg = $post_data['content_type'] == 6 ? '视频': '语音';
        $user_id = $post_data['user_id'];
        $user_info = UserService::getUserInfo($user_id);
        $face = $user_info['face'];
        if (!$chat_list = ChatList::field('id,type,status,user_ids')->where('list_id', $post_data['list_id'])->find()) {
            return JsonDataService::fail('没有这条会话,发送消息失败!');
        }
        $user_ids = is_array($chat_list['user_ids']) ? $chat_list['user_ids'] :json_decode($chat_list['user_ids'], true);
        if (!in_array($user_id, $user_ids)) {
            return JsonDataService::fail('没有这条会话,发送消息失败!');
        }
//        require_once (dirname(dirname(__DIR__))) . '/extend/video/TLSSigAPI.php';
//        $api = new TLSSigAPI();
//        $api->SetAppid(config('vedio_appid'));
//        $private = config('vedio_privatekey');
//        $api->SetPrivateKey($private);

        $userid = clientOS() . '_trtc_' . $user_info['id'];
        $ttl = config('vedio_ttl');

        $member = ChatMember::field('user_id')
            ->where('list_id', $post_data['list_id'])
            ->select()
            ->toArray();
        $user_ids = [];
        foreach ($member as $val) {
            if ($val['user_id'] != $user_id) {
                array_push($user_ids,$val['user_id']);
                $friends_info = User::get($val['user_id']);
                /** 增加一条未读消息提醒 */
                ChatList::where([
                    'list_id' => $post_data['list_id'],
                    'user_id' => ($val['user_id'] * 1),
                ])->setInc('no_reader_num', 1);

                if ($chat_list->status) {
                    $chat_list->status = 0;
                    $chat_list->save();
                }
                if (!$friends_info) {
                    return JsonDataService::fail('你还不是对方好友,发送消息失败');
                }
                $return_data = [
                    'myavatar' => $face,
                    'myname' => $user_info['nickname'],
                    'wait' => '正在等待对方接受邀请...',
                    'prompt' => '通话中...',
                    'userid' => $userid,
                    'roomid' => $user_id,
                    'usersig' => VedioSdk::getUsersig($user_id),
                ];
                $friend_info = UserService::getUserInfo($friends_info->id);
                if(!$friends_info)continue;
                $callType = $post_data['content_type'] == 6 ? 'video' : 'voice';
                $return_data['username'] = $friend_info['nickname'];
                $return_data['useravatar'] = $friend_info['face'];
                $return_data['content_type'] = $post_data['content_type'];
                $return_data['list_id'] = $post_data['list_id'];
                $return_data['callType'] = $callType;
                $friend_id = clientOS() . '_trtc_' . $friends_info['id'];
                $send_data = [
                    'roomid' => $user_id,
                    'userid' => $friend_id,
                    'name' => $user_info['nickname'],
                    'avatar' =>$friend_info['face'], //我的
                    'callType'=>$callType,
                    'list_id' => $post_data['list_id'],
                    'content_type' => $post_data['content_type'],
                    'myavatar' => $face,
                    'myname' => $friends_info['nickname'],
                    'usersig' => VedioSdk::getUsersig($friends_info['id']),
                    'wait' => '邀请您'.$type_msg.'通话...',
                    'prompt' => '通话中...',
                ];
                SendData::sendToUid($val['user_id'], 'vedioData', $send_data);
                self::pushMsg([$val['user_id']],$post_data['content_type'],$user_info['username'],'',$send_data);
            }
        }
        return JsonDataService::success('成功',$return_data);
    }


    /**
     * 发送消息到消息列表
     *
     */
    public static function sendChatDataMsgToAll($list_id, $user_id, $chat_id, $content_type = 0, $content = array(), $msg_type = 0)
    {
        $user = UserService::getUserInfo($user_id);
        if(!$user) return JsonDataService::fail();
        $data = [
            'list_id' => $list_id,
            'data' => [
                'type' => $msg_type,
                'msg' => [
                    'id' => $chat_id,
                    'type' => $content_type,
                    'time' => time(),
                    'user_info' => [
                        'uid' => $user_id,
                        'name' => $user['username'],
                        'face' => $user['face'],
                    ],
                    'content' => $content
                ],
            ]
        ];
        $send['user_id'] = $user_id;
        $send['list_id'] = $list_id;
        $send['action'] = 'chatData';
        $send['sendData'] = $data;

        return self::sendMsg($send);
    }

    public static function sendChatDataMsg($list_id, $user_id, $chat_id, $content_type = 0, $content = array(), $msg_type = 0){
        $user = UserService::getUserInfo($user_id);
        if(!$user) return JsonDataService::fail();
        $data = [
            'list_id' => $list_id,
            'data' => [
                'type' => $msg_type,
                'msg' => [
                    'id' => $chat_id,
                    'type' => $content_type,
                    'time' => time(),
                    'user_info' => [
                        'uid' => $user_id,
                        'name' => $user['username'],
                        'face' => $user['face'],
                    ],
                    'content' => $content
                ],
            ]
        ];
        SendData::sendToUid($user_id, 'chatData', $data);
        ChatList::where(['list_id'=>$list_id])->update(['last_chat_time'=>time()]);
    }

    /**
     * 同意音视频
     */
    public static function agreeVedio(array $params){
        $list_id = $params['list_id'];
        $chat_list = ChatListService::getChatListByListId($list_id);
        if(!$chat_list)return JsonDataService::fail('会话不存在!');
        RedisService::set(ConfigService::VEDIO_START_TIME.$params['content_type'].':'.$list_id,time());
        $callType = $params['content_type'] == 6 ? 'video' : 'voice';
        $ret = RedisService::set(ConfigService::VIDEO_CALL_ROOM.$list_id,json_encode(['roomid'=>$params['roomid'],'to_user_id'=>$params['user_id'],'type'=>$callType],256));
        Log::info("agreeVedio：".print_r($ret,true));
        return JsonDataService::success();
    }

    /**
     * 发送名片
     */
    public static function sendCard(array $params){
        $user_id = $params['user_id'];
        $user_info = UserService::getUserInfo($user_id);
        if(!$user_info) return JsonDataService::fail('erro');
        $user_ids = $params['user_ids'];
        foreach ($user_ids as $v){
            $friend = UserService::getUserInfo($v);
            if(!$friend) continue;
            $content = ['text'=>$friend['nickname'].'的名片','nickname'=>$friend['nickname'],'face'=>$friend['face'],'user_id'=>$v];
            $chat = Chat::createUserMsg([
                'list_id' => $params['list_id'],
                'user_id' => $user_id,
                'content_type' => 8,
                'content' => $content
            ]);
            self::sendChatDataMsgToAll($params['list_id'],$user_id,$chat->id,8,$content,0);
        }
        return JsonDataService::success();
    }

    /**
     * 推送消息
     */
    public static function pushMsg($user_ids,$type,$title,$content = '',$paylod = []){
        if(!(clientOS() == 'IOS')) return false;
        $config = BsysConfig::getAllVal('basic_config');
        if(!isset($config['user_push_appid']) || !isset($config['user_push_appKey']) || !isset($config['user_push_masterSecret'])) return JsonDataService::fail(json_encode($config,256));
        $user_list = User::where(['id'=>$user_ids])->field('client_id')->select()->toArray();
        $client_ids = array_column($user_list,'client_id');
        if(!$client_ids) return JsonDataService::fail();
        switch ($type) {
            case 0:
                break;
            case 1:
                /** 语音 */
                $content = '[语音]';
                break;
            case 2:
                /** 图片 */
                $content = '[图片]';
                break;
            case 3:
                /** 视频 */
                $content = '[视频]';
                break;
            case 4:
                /** 文件 */
                $content = '[文件]';
                break;
            case 5:
                /** 红包 */
                $content = '[红包]';
                break;
            case 6:
                /** 在线视频 */
                $content = '邀请您视频通话';
                break;
            case 7:
                /** 在线语音 */
                $content = '邀请您语音通话';
                break;
            case 8:
                /** 名片 */
                $content = '[名片]';
        }
        $ret = (new PushService($config['user_push_appid'],$config['user_push_appKey'],$config['user_push_masterSecret']));
        return $ret->pushMsgByClientIds($title,$content,$client_ids,$paylod);
    }

    public static function senNormalMsgToUid($uid,$type='',$data = []){
        SendData::sendToUid($uid, $type, $data);
        return JsonDataService::success();
    }
    public static function isOnline($user_id){
       return SendData::isOnline($user_id);
    }

    /**
     * 发送消息
     * @param $post_data
     * @return mixed
     * @throws Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\db\exception\PDOException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public static function textMsg($post_data){
        if (!isset($post_data['list_id']) || !isset($post_data['content_type']) || !isset($post_data['content'])) {
            return JsonDataService::fail('msg data error');
        }

        if (!$chat_list = ChatList::field('id,type,status')->where('list_id', $post_data['list_id'])->find()) {
            return JsonDataService::fail('没有这条会话,发送消息失败!');
        }
        $is_niming = 0;
        switch ($chat_list->type) {
            case 0:
                /** 如果是对话，检测对方是不是把自己删除了 */
                if (count(ChatList::field('id')->where('list_id', $post_data['list_id'])->select()->toArray()) == 1) {
                    return JsonDataService::fail('你还不是对方好友,发送消息失败');
                }
                break;
            case 1:
                /** 如果是群聊禁言中不能发送消息 */
                $chat_group = ChatGroup::field('is_msg,main_id')->where('list_id', $post_data['list_id'])->find();
                $chat_member_data = ChatMember::field('is_admin,is_msg,is_niming')
                    ->where([
                        'list_id' => $post_data['list_id'],
                        'user_id' => $post_data['user_id'],
                    ])
                    ->find();
                /** 被禁言了或者群状态为禁言中，群主和管理员不被禁言 */
                $is_niming = $chat_member_data->is_niming ?? 0;
                if ($chat_member_data->is_msg || ($chat_group->is_msg && $chat_group->main_id != $post_data['user_id'] && $chat_member_data->is_admin == 0)) {
                    return JsonDataService::fail('禁言了..');
                }
                break;
            default:
                return JsonDataService::fail('未知对话类型');
                break;
        }

        if ($chat_list->status) {
            $chat_list->status = 0;
            $chat_list->save();
        }

        $chat_obj = Chat::createChatMsg([
            'list_id' => $post_data['list_id'],
            'user_id' => $post_data['user_id'],
            'content_type' => $post_data['content_type'],
            'msg_type' => 0,
            'content' => $post_data['content'],
            'time' => time(),
            'is_niming' =>$is_niming
        ]);

        $member = ChatMember::field('user_id')
            ->where('list_id', $post_data['list_id'])
            ->select()
            ->toArray();

        /** 这里通知其他对象 */
        $user_ids = [];

        foreach ($member as $value) {
            if ($post_data['user_id'] != $value['user_id']) {
                ChatList::where([
                    'list_id' => $post_data['list_id'],
                    'user_id' => ($value['user_id'] * 1),
                ])
                    ->setInc('no_reader_num', 1);
            }
            array_push($user_ids,$value['user_id']);
            $user_info = UserService::getUserInfo($post_data['user_id']);


            $face = $user_info['face'];

            /** 发送通知 */
            SendData::sendToUid($value['user_id'], 'chatData', [
                'list_id' => $post_data['list_id'],
                'data' => [
                    'type' => 0,
                    'msg' => [
                        'id' => $chat_obj->id,
                        'type' => $post_data['content_type'],
                        'time' => time(),
                        'user_info' => [
                            'uid' => $post_data['user_id'],
                            'name' => $user_info['username'],
                            'face' => $face,
                        ],
                        'content' => $post_data['content'],
                        'is_niming'=>$is_niming
                    ],
                ]
            ]);
        }
        ChatList::where(['list_id'=>$post_data['list_id'],'user_id'=>$post_data['user_id']])->update(['last_chat_time'=>time()]);
        QueueService::AfterSendMsg([
            'user_ids'=>$user_ids,
            'content_type'=>$post_data['content_type'],
            'username'=>$user_info['username'],
            'content'=>$post_data['content']->text ?? '',
            'type'=>$chat_list->type,
            'user_id'=>$post_data['user_id'],
            'list_id'=>$post_data['list_id'],
        ]);
        return JsonDataService::success('success');
    }

    /**
     * 向群组里广播消息
     * @param $user_id
     * @param $list_id
     * @param $type
     * @param $data
     * @param array $except
     * @return array
     */
    public static function setNormalMsgToAll($user_id,$list_id,$type,$data,$except = []){
        $member = ChatMember::field('user_id')
            ->where('list_id', $list_id)
            ->select()
            ->toArray();
        if (empty($member)) return JsonDataService::fail('会话列表不存在!');
        /** 这里通知其他对象 */
        foreach ($member as $value) {
            ChatList::where(['list_id'=>$list_id,'user_id'=>$value['user_id']])->update(['last_chat_time'=>time()]);
            if ($user_id != $value['user_id']) {
                ChatList::where([
                    'list_id' => $list_id,
                    'user_id' => ($value['user_id'] * 1),
                ])
                    ->setInc('no_reader_num', 1);
            }
            $params['sendData']['user_id'] = $value['user_id'];
            /** 发送通知 */
            if($except && in_array($value['user_id'],$except)){
                continue;
            }
            SendData::sendToUid($value['user_id'], $type,$data);

        }
        return JsonDataService::success('发送消息成功!', $data);
    }

}