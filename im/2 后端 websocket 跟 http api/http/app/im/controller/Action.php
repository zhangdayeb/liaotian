<?php

namespace app\im\controller;

use app\im\model\mongo\VoiceRoom;
use app\im\model\mysql\VendorUser;
use app\im\model\mysql\Vendor as MVendor;
use extend\service\JsonDataService;
use extend\service\UserService;
use \Request;
use \app\im\model\mongo\FriendApply;
use \app\im\model\mongo\ChatMember;
use \app\im\model\mongo\ChatList;
use \app\im\model\mongo\Chat;
use \app\im\model\mongo\Friend;
use \app\common\controller\SendData;
use \app\im\model\mongo\UserState;
use \app\im\model\mongo\ChatGroup;

class Action
{
    /** 添加好友申请 */
    public function friendAdd()
    {
        $post_data = Request::post();
        $return_data = [
            'err' => 1,
            'msg' => 'error'
        ];
        if (!isset($post_data['user_id']) || !isset($post_data['is_type']) || !isset($post_data['content'])) {
            $return_data['msg'] = '参数错误';
            return json($return_data);
        }

        $post_data['user_id'] *= 1;

        if (USER_ID == $post_data['user_id']) {
            $return_data['msg'] = '你不能添加自己为好友';
            return json($return_data);
        }

        $friend_data = Friend::where([
            'user_id' => USER_ID,
            'friend_id' => intval($post_data['user_id']),
        ])
            ->select()
            ->toArray();
        if (count($friend_data) && Friend::field('id')
                ->where([
                    'user_id' => $post_data['user_id'],
                    'friend_id' => USER_ID,
                ])
                ->find()) {
            $return_data['msg'] = '对方已经是你的好友了';
            return json($return_data);
        }

        $return_data['err'] = 0;

        $friend_data = Friend::where([
            'user_id' => intval($post_data['user_id']),
            'friend_id' => USER_ID,
        ])
            ->select()
            ->toArray();
        /** 这里是把对方删除了，对方没有删除自己，直接添加到自己通讯录 */
        if (count($friend_data)) {
            /** 增加好友数据 */
            Friend::create([
                'user_id' => USER_ID,
                'friend_id' => $post_data['user_id'],
                'from' => $friend_data[0]['from'],
            ]);

            $chat_user_ids = [USER_ID, $post_data['user_id']];
            sort($chat_user_ids);
            $chat_user_ids = json_encode($chat_user_ids);

            $chat_list_data = ChatList::field('list_id')
                ->where([
                    'user_id' => $post_data['user_id'],
                    'user_ids' => $chat_user_ids,
                    'type' => 0,
                ])
                ->find();
            /** 增加会话数据 */
            ChatList::create([
                'user_id' => USER_ID,
                'list_id' => $chat_list_data->list_id,
                'user_ids' => $chat_user_ids,
                'type' => 0,
            ]);
            $return_data['err'] = 1;
            $return_data['msg'] = '添加成功';
            return json($return_data);
        }

        /** 这里如果已经申请了，并且对方没有处理，更新原有的数据 */
        $is_apply = FriendApply::where([
            'apply_user_id' => USER_ID,
            'friend_user_id' => ($post_data['user_id'] * 1),
            'action' => 0,
        ])
            ->find();
        if ($is_apply) {
            FriendApply::update([
                'id' => $is_apply->id,
                'content' => $post_data['content'],
                'from' => $post_data['is_type'],
            ]);
        } else {
            FriendApply::create([
                'apply_user_id' => USER_ID,
                'friend_user_id' => $post_data['user_id'],
                'content' => $post_data['content'],
                'from' => $post_data['is_type'],
            ]);
        }
        $return_data['msg'] = '已申请添加';
        /** 通知对方处理 */
        SendData::sendToUid($post_data['user_id'], 'newFriend', [
            'num' => 1
        ]);
        return json($return_data);
    }

    /** 添加好友操作 */
    public function friendAddAction()
    {
        $post_data = Request::post();
        $return_data = [
            'err' => 1,
            'msg' => 'error',
        ];
        if (!isset($post_data['apply_id'])) {
            return json($return_data);
        }

        $db_data = FriendApply::field('apply_user_id,content,action,from,time')
            ->where([
                'id' => $post_data['apply_id']
            ])
            ->select()
            ->toArray();
        if (count($db_data) == 0) {
            $return_data['msg'] = '没有这条申请数据';
            return json($return_data);
        }
        $db_data[0]['apply_user_id'] *= 1;
        if ($db_data[0]['action']) {
            $return_data['msg'] = '已经操作过这条数据了';
            return json($return_data);
        }

        $friend_data = Friend::where([
            'user_id' => USER_ID,
            'friend_id' => $db_data[0]['apply_user_id'],
        ])
            ->select()
            ->toArray();
        if (count($friend_data)) {
            $return_data['msg'] = '对方已经是你的好友了';
            return json($return_data);
        }

        if ($db_data[0]['apply_user_id'] == USER_ID) {
            $return_data['msg'] = '你不能添加自己为好友';
            return json($return_data);
        }

        // 这里是我把对方删除，对方重新添加我
        $friend_data_obj = Friend::field('id')
            ->where([
                'user_id' => $db_data[0]['apply_user_id'],
                'friend_id' => USER_ID,
            ])
            ->find();
        $chat_user_ids = [USER_ID, $db_data[0]['apply_user_id']];
        sort($chat_user_ids);
        $chat_user_ids = json_encode($chat_user_ids);
        if ($friend_data_obj) {
            $list_data_obj = ChatList::field('list_id')
                ->where([
                    'user_id' => $db_data[0]['apply_user_id'],
                    'user_ids' => $chat_user_ids,
                ])
                ->find();
            $list_id = $list_data_obj->list_id;
        } else {
            $list_id = md5(uniqid('JWT', true) . rand(1, 100000));
        }

        FriendApply::update([
            'id' => $post_data['apply_id'],
            'action' => 1,
        ]);
        /** 增加会话列表 */
        ChatList::create([
            'user_id' => USER_ID,
            'list_id' => $list_id,
            'user_ids' => $chat_user_ids,
            'type' => 0,
        ]);

        /** 增加到好友表 */
        Friend::create([
            'user_id' => USER_ID,
            'friend_id' => $db_data[0]['apply_user_id'],
            'from' => $db_data[0]['from'],
        ]);

        if (!$friend_data_obj) {
            /** 增加会话列表 */
            ChatList::create([
                'user_id' => $db_data[0]['apply_user_id'],
                'list_id' => $list_id,
                'user_ids' => $chat_user_ids,
                'type' => 0,
            ]);
            /** 增加到成员表 */
            ChatMember::create([
                'list_id' => $list_id,
                'user_id' => $db_data[0]['apply_user_id'],
            ]);
            ChatMember::create([
                'list_id' => $list_id,
                'user_id' => USER_ID,
            ]);
            /** 增加到好友表 */
            Friend::create([
                'user_id' => $db_data[0]['apply_user_id'],
                'friend_id' => USER_ID,
                'from' => $db_data[0]['from'],
            ]);
        }
        /** 增加到对话表 */

        /** 有申请内容才写入对话 */
        if ($db_data[0]['content']) {
            Chat::createChatMsg([
                'list_id' => $list_id,
                'user_id' => $db_data[0]['apply_user_id'],
                'content_type' => 0,
                'msg_type' => 0,
                'content' => [
                    'text' => $db_data[0]['content'],
                ],
                'time' => $db_data[0]['time'],
            ]);
        }

        Chat::createChatMsg([
            'list_id' => $list_id,
            'user_id' => USER_ID,
            'content_type' => 0,
            'msg_type' => 0,
            'content' => [
                'text' => '我通过了你的朋友验证请求,现在我们可以开始聊天了',
            ],
            'time' => time(),
        ]);

        /** 通知双方重新获取会话列表和通讯录数据 */
        SendData::sendToUid(USER_ID, 'getChatList');
        SendData::sendToUid(USER_ID, 'getFriendList');
        SendData::sendToUid($db_data[0]['apply_user_id'], 'getChatList');
        SendData::sendToUid($db_data[0]['apply_user_id'], 'getFriendList');

        $return_data['err'] = 0;
        $return_data['msg'] = 'success';

        return json($return_data);
    }

    /** 更新头像状态 */
    public function upPhoto()
    {
        $return_data = [
            'err' => 1,
            'msg' => 'fail',
        ];

        $obj = self::userState(USER_ID);
        $obj->photo = 1;
        $obj->save();

        $return_data['err'] = 0;
        $return_data['msg'] = 'success';
        return json($return_data);
    }

    /** 更新头朋友圈背景图片 */
    public function upCircleImg()
    {
        $return_data = [
            'err' => 1,
            'msg' => 'fail',
        ];

        $obj = self::userState(USER_ID);
        $obj->circle_img = 1;
        $obj->save();

        $return_data['err'] = 0;
        $return_data['msg'] = 'success';
        return json($return_data);
    }

    /** 查看群聊状态 */
    public function groupState()
    {
        $post_data = Request::post();
        $return_data = [
            'err' => 1,
            'msg' => 'error',
            'data' => 0,
        ];
        if (!isset($post_data['list_id'])) {
            $return_data['msg'] = 'list_id null';
            return json($return_data);
        }
        $return_data['err'] = 0;
        $return_data['msg'] = 'success';

        $chat_group = ChatGroup::field('id,main_id,is_msg,notice,can_shangmai')->where('list_id', $post_data['list_id'])->find();
        $chat_member_data = ChatMember::field('is_admin,is_msg,is_niming,miaoqiang,qiang_time,voice_room_state')
            ->where([
                'list_id' => $post_data['list_id'],
                'user_id' => USER_ID,
            ])
            ->find();
        $is_msg = 0;
        $is_action = 0;
        /** 如果禁言了，自己不是群主和管理员的话，就不能发言 */
        if ($chat_member_data->is_msg || ($chat_group->is_msg && $chat_group->main_id != USER_ID && $chat_member_data->is_admin == 0)) {
            $is_msg = 1;
        }
        if ($chat_group->main_id == USER_ID || $chat_member_data->is_admin) {
            $is_action = 1;
        }
        $is_main = $chat_group->main_id == USER_ID ? 1 : 0 ;
        $vendor_info = VendorUser::where(['group_id'=>$chat_group->id])->find();
        $vend_status = $vendor_info ? ($vendor_info['status'] == 1 ? 1 : 0) : 0;
        $res = MVendor::where(['vendor_code'=>'HongBaoLei'])->find();
        $vend_status = ($res && $res['status'] == 1) ? $vend_status : 0;
        $is_niming = $chat_member_data['is_niming'] ?? 0;
        $qiang_time= $chat_member_data['qiang_time'] ?? 0;
        $miaoqiang = $chat_member_data['miaoqiang'] ?? 0;
        $voice_room_state = 0;
        $ret =  VoiceRoom::where(['list_id'=>$post_data['list_id']])->find();
        if($ret && $ret['member_count'] > 0 && !in_array(USER_ID,$ret['user_ids']))$voice_room_state=1;
        $return_data['data'] = [
            'is_msg' => $is_msg,
            'is_niming' => $is_niming,
            'is_action' => $is_action,
            'miaoqiang' => $miaoqiang,
            'vendor_status' => $vend_status,
            'notice'=>$chat_group['notice'],
            'is_main'=>$is_main,
            'can_shangmai'=>$chat_group['can_shangmai'],
            'qiang_time'=>$qiang_time,
            'voice_room_state'=>$voice_room_state,
        ];
        return json($return_data);
    }

    /** 用户状态实列，如果有就返回有的实列，没有创建再返回实列 */
    private static function userState($user_id)
    {
        $obj = UserState::where('user_id', ($user_id * 1))->find();
        if (!$obj) {
            $obj = UserState::create(['user_id' => $user_id]);
        }
        return $obj;
    }

    public function updateUserSayType()
    {
        $post_data = Request::post();
        return json(UserService::updateUserSayType(array_merge($post_data, ['user_id' => USER_ID])));

    }

}
