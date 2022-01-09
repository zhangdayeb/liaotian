<?php

namespace app\im\controller;

use extend\service\HongBaoService;
use extend\service\JsonDataService;
use extend\service\MsgService;
use extend\service\QueueService;
use extend\service\UserService;
use extend\service\UserStateService;
use \Request;
use \app\im\common\controller\NameFirstChar;
use \app\common\controller\SendData;
use app\super\model\BsysConfig;
/** mongo表 */

use \app\im\model\mongo\Chat;
use \app\im\model\mongo\ChatList;
use \app\im\model\mongo\Friend;
use \app\im\model\mongo\ChatMember;
use \app\im\model\mongo\UserState;
use \app\im\model\mongo\ChatGroup;
use \app\im\model\mongo\ChatGroupApply;
/** mysql表 */

use \app\im\model\mysql\User;
use think\facade\Log;
use TLSSigAPI;

class Message
{
    //发送普通消息
    public function textMsg()
    {
        $post_data = Request::post();
        $return_data = [
            'err' => 1,
            'msg' => 'error',
        ];
        if (!isset($post_data['list_id']) || !isset($post_data['content_type']) || !isset($post_data['content'])) {
            $return_data['msg'] = 'msg data error';
            return json($return_data);
        }

        $post_data['content'] = json_decode($post_data['content']);

        if (!$chat_list = ChatList::field('id,type,status')->where('list_id', $post_data['list_id'])->find()) {
            $return_data['msg'] = '没有这条会话,发送消息失败!';
            return json($return_data);
        }
        $is_niming = 0;
        switch ($chat_list->type) {
            case 0:
                /** 如果是对话，检测对方是不是把自己删除了 */
                if (count(ChatList::field('id')->where('list_id', $post_data['list_id'])->select()->toArray()) == 1) {
                    $return_data['err'] = 1;
                    $return_data['msg'] = '你还不是对方好友,发送消息失败';
                    return json($return_data);
                }
                break;
            case 1:
                /** 如果是群聊禁言中不能发送消息 */
                $chat_group = ChatGroup::field('is_msg,main_id')->where('list_id', $post_data['list_id'])->find();
                $chat_member_data = ChatMember::field('is_admin,is_msg,is_niming')
                    ->where([
                        'list_id' => $post_data['list_id'],
                        'user_id' => USER_ID,
                    ])
                    ->find();
                /** 被禁言了或者群状态为禁言中，群主和管理员不被禁言 */
                $is_niming = $chat_member_data->is_niming ?? 0;
                if ($chat_member_data->is_msg || ($chat_group->is_msg && $chat_group->main_id != USER_ID && $chat_member_data->is_admin == 0)) {
                    $return_data['err'] = '2';
                    $return_data['msg'] = '禁言了...';
                    return json($return_data);
                }
                break;
            default:
                $return_data['err'] = '3';
                $return_data['msg'] = '未知对话类型';
                return json($return_data);
                break;
        }

        if ($chat_list->status) {
            $chat_list->status = 0;
            $chat_list->save();
        }

        $chat_obj = Chat::createChatMsg([
            'list_id' => $post_data['list_id'],
            'user_id' => USER_ID,
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
            if (USER_ID != $value['user_id']) {
                ChatList::where([
                    'list_id' => $post_data['list_id'],
                    'user_id' => ($value['user_id'] * 1),
                ])
                    ->setInc('no_reader_num', 1);
            }
            array_push($user_ids,$value['user_id']);
            $user_info = UserService::getUserInfo(USER_ID);


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
                            'uid' => USER_ID,
                            'name' => $user_info['username'],
                            'face' => $face,
                        ],
                        'content' => $post_data['content'],
                        'is_niming'=>$is_niming
                    ],
                ]
            ]);
        }
        ChatList::where(['list_id'=>$post_data['list_id'],'user_id'=>USER_ID])->update(['last_chat_time'=>time()]);
        QueueService::AfterSendMsg([
            'user_ids'=>$user_ids,
            'content_type'=>$post_data['content_type'],
            'username'=>$user_info['username'],
            'content'=>$post_data['content']->text ?? '',
            'type'=>$chat_list->type,
            'user_id'=>USER_ID,
            'list_id'=>$post_data['list_id'],
        ]);
        $return_data['err'] = 0;
        $return_data['msg'] = 'success';
        return json($return_data);
    }


    /** 获得与对方的会话id */
    public function getListId()
    {
        $post_data = Request::post();
        $return_data = [
            'err' => 1,
            'msg' => 'fail',
        ];
        if (!isset($post_data['user_id'])) {
            $return_data['msg'] = 'user_id data error';
            return json($return_data);
        }

        $chat_user_ids = [USER_ID, ($post_data['user_id'] * 1)];
        sort($chat_user_ids);
        $chat_user_ids = json_encode($chat_user_ids);

        $chat_list_data = ChatList::field('list_id')
            ->where([
                'user_id' => USER_ID,
                'user_ids' => $chat_user_ids,
                'type' => 0,
            ])
            ->find();
        /** 如果没有对话（说明与对方对方对话数据已经升级为群了）新建会话数据 */
        if ($chat_list_data) {
            $list_id = $chat_list_data->list_id;
        } else {
            $list_id = create_guid();
            /** 增加会话列表 */
            ChatList::create([
                'user_id' => USER_ID,
                'list_id' => $list_id,
                'user_ids' => $chat_user_ids,
                'status' => 1,
                'type' => 0,
            ]);
            ChatList::create([
                'user_id' => $post_data['user_id'],
                'list_id' => $list_id,
                'user_ids' => $chat_user_ids,
                'status' => 1,
                'type' => 0,
            ]);
            /** 增加到成员表 */
            ChatMember::create([
                'list_id' => $list_id,
                'user_id' => $post_data['user_id'],
            ]);
            ChatMember::create([
                'list_id' => $list_id,
                'user_id' => USER_ID,
            ]);
        }
        $return_data['err'] = 0;
        $return_data['msg'] = 'success';
        $return_data['data'] = [
            'list_id' => $list_id,
        ];
        return json($return_data);
    }

    public function updataNoReader()
    {
        $post_data = Request::post();
        $return_data = [
            'err' => 1,
            'msg' => 'error',
        ];
        if (!isset($post_data['list_id'])) {
            $return_data['msg'] = 'list_id data error';
            return json($return_data);
        }
        ChatList::where([
            'list_id' => $post_data['list_id'],
            'user_id' => USER_ID,
        ])
            ->update([
                'no_reader_num' => 0,
            ]);
        $return_data['err'] = 0;
        $return_data['msg'] = 'success';
        return json($return_data);
    }

    /** 获得会话详情 */
    public function getChatDetails()
    {
        $post_data = Request::post();
        $return_data = [
            'err' => 1,
            'msg' => 'error',
        ];
        if (!isset($post_data['list_id'])) {
            $return_data['msg'] = 'list_id data error';
            return json($return_data);
        }
        $member = ChatMember::field('user_id,is_admin,is_disturb,nickname')
            ->where([
                ['list_id', '=', $post_data['list_id']],
                ['user_id','<>',1]
            ])
            ->order('is_admin', 'DESC')
            ->order('time', 'ASC')
            ->select()
            ->toArray();
        $data = [];
        $is_action = 0;
        $chat_list_data = ChatList::field('type,top,is_disturb')
            ->where(['user_id' => USER_ID,'list_id' => $post_data['list_id'],])
            ->find();
        $is_disturb = $chat_list_data['is_disturb'];
        switch ($chat_list_data->type) {
            case 1:
                $group = ChatGroup::where('list_id', $post_data['list_id'])
                    ->find()
                    ->toArray();
                if (isset($group['is_photo']) && $group['is_photo']) {
                    $group['is_photo'] = '/group_photo/' . $post_data['list_id'] . '/90.jpg';
                } else {
                    $group['is_photo'] = 'default_group_photo/90.jpg';
                }
                break;
            default:
                $group = [];
                break;
        }
        $my_nickname = '';
        if (count($member)) {
            foreach ($member as $key => $value) {
                /** 如果是自己好友，显示自己的备注 */
                $db_user = User::get($value['user_id']);
                if(empty($db_user)){
                    unset($member[$key]);
                    continue;
                }
                if (($friend = Friend::where([
                        'user_id' => USER_ID,
                        'friend_id' => $value['user_id'],
                    ])->find()) && $friend->remarks) {
                    $show_name = $friend->remarks;
                } else {
                    $show_name = $db_user->nickname;
                }
                //如果有群备注就显示群备注
                $show_name = $value['nickname'] ? $value['nickname'] : $show_name;
                if($value['user_id'] == USER_ID) $my_nickname= $value['nickname'];
                //检测是否在线
                $is_online = MsgService::isOnline($value['user_id']);

                $user_state_obj = UserState::field('photo')->where('user_id', $value['user_id'])->find();
                $face = getShowPhoto($user_state_obj, $db_user->sex, $value['user_id'], 300);
                if ($chat_list_data->type == 1 && $value['user_id'] != USER_ID) {
                    $show_name = mb_substr($show_name, 0, 1) . '***';
                }
                if($group && $value['user_id'] == $group['main_id']) $value['is_admin'] = 2;
                $data[] = [
                    'user_id' => $value['user_id'],
                    'show_name' => $show_name,
                    'photo' => $face,
                    'is_admin' => $value['is_admin'],
                    'is_online' =>$is_online,
                ];
                /** 如果自己是管理员（获得权限） */
                if ($value['user_id'] == USER_ID && $value['is_admin']) {
                    $is_action = 1;
                }
                /** 如果自己是群主也可以操作 */
                if ($group && $group['main_id'] == USER_ID) {
                    $is_action = 2;
                }
            }
        }
        $return_data['err'] = 0;
        $return_data['msg'] = 'success';


        //根据群主排序

        $return_data['data'] = [
            'member' => $data,
            'type' => $chat_list_data->type,
            'group' => $group,
            'is_action' => $is_action,
            'my_nickname' => $my_nickname,
            'top' => $chat_list_data->top,
            'is_disturb'=>$is_disturb,
            'user_id'=>USER_ID,
        ];
        return json($return_data);
    }

    /** 添加会话成员（从会话变成群聊） */
    public function addChat()
    {
        $post_data = Request::post();
        $return_data = [
            'err' => 1,
            'msg' => 'fail',
        ];
        if (!isset($post_data['list_id']) || !isset($post_data['users'])) {
            $return_data['msg'] = 'data error';
            return json($return_data);
        }

        $obj_id = 0;
        if (isset($post_data['type']) && $post_data['type'] == 1) {
            $main_id = $post_data['users'] * 1;
            $post_data['users'] = '[' . USER_ID . ']';
            $obj_id = USER_ID;
        } else {
            $main_id = USER_ID;
        }

        if (!($db_chat_list = ChatList::field('type,user_ids')
            ->where([
                'list_id' => $post_data['list_id']
            ])
            ->find())) {
            $return_data['msg'] = '没有这条对话';
            return json($return_data);
        }

        if (!ChatMember::where([
            'user_id' => USER_ID,
            'list_id' => $post_data['list_id'],
        ] && !isset($post_data['add_type']))
            ->find()) {
            $return_data['msg'] = '您不在该群!';
            return json($return_data);
        }
        if(isset($post_data['add_type'])){
            $main_id = $post_data['user_id'];
        }
        $user_ids = is_array($db_chat_list['user_ids']) ? $db_chat_list['user_ids'] :json_decode($db_chat_list['user_ids'], true);
        $db_chat_list['user_ids'] = $user_ids;
        $post_data['users'] = json_decode($post_data['users'], true);

        $is_admin = 0;
        $chat_member_ = ChatMember::where([
            'user_id' => $main_id,
            'list_id' => $post_data['list_id'],
        ])
            ->find();
        if ($chat_member_) {
            $is_admin = $chat_member_->is_admin;
        }

        if (($db_chat_list['type'] == 1 && $is_admin == 0) || $obj_id) {
            if ($chat_replay = ChatGroupApply::where([
                'list_id' => $post_data['list_id'],
//                'invite_user_id' => $main_id,
                'invite_to_user_id' => USER_ID,
                'status' => 0,
            ])
                ->find()) {
                $return_data['msg'] = '已提交申请,请耐心等待管理员审核';
                return json($return_data);
            }
            /* 获取群管理员 */
            $chat_member_data_ = ChatMember::where([
                'list_id' => $post_data['list_id'],
                'is_admin' => 1,
            ])
                ->select();
            $group_data_ = ChatGroup::field('name,is_photo')->where('list_id', $post_data['list_id'])->find()->toArray();
            $show_name = $group_data_['name'];
            if (isset($group_data_['is_photo']) && $group_data_['is_photo']) {
                $photo_path = '/group_photo/' . $post_data['list_id'] . '/90.jpg';
            } else {
                $photo_path = 'default_group_photo/90.jpg';
            }
        }
        Log::info('提交审核222.....');
        foreach ($post_data['users'] as $user_id) {
            $user_id *= 1;
            /** 如果用户存在这个会话中，则跳过这个用户 */
            if (in_array($user_id, $user_ids)) {
                continue;
            }

            $user_ids[] = $user_id;

            /** 如果已经是群聊了，邀请的人不是管理员和群主，邀请的人进入邀请申请列表，经群主或者管理员同意了后才进群 */
            if (($db_chat_list['type'] == 1 && $is_admin == 0) || ($obj_id && $is_admin == 0)) {
                $chat_member_add = ChatGroupApply::create([
                    'list_id' => $post_data['list_id'],
                    'invite_user_id' => $main_id,
                    'invite_to_user_id' => $user_id,
                ]);
                foreach ($chat_member_data_ as $key => $item) {
                    SendData::sendToUid($item->user_id, 'chatGroupApply', [
                        'id' => $chat_member_add->id,
                        'user_id' => $user_id,
                        'content' => User::get($main_id)->nickname . ' 邀请 ' . User::get($user_id)->nickname . '进入群聊',
                        'text' => '未处理',
                        'photo' => $photo_path,
                        'nickname' => $show_name,
                    ]);
                }
                continue;
            }

            /** 增加到会话列表 */
            ChatList::create([
                'user_id' => $user_id,
                'list_id' => $post_data['list_id'],
                'user_ids' => '',
                'type' => 1,
            ]);
            /** 增加到成员 */
            ChatMember::create([
                'list_id' => $post_data['list_id'],
                'user_id' => $user_id,
            ]);
            $content = [
                'text' => User::get($main_id)->nickname . '邀请了' . User::get($user_id)->nickname . '进入会话',
            ];
            /** 增加一条系统消息 */
            $chat_obj = Chat::createChatMsg([
                'list_id' => $post_data['list_id'],
                'user_id' => 0,
                'content_type' => 0,
                'msg_type' => 1,
                'content' => $content,
                'time' => time(),
            ]);
            /** 通知新加入的成员重新获取会话列表 */
            SendData::sendToUid($user_id, 'getChatList');
            /** 给其他原先用户发送加入的消息 */
            foreach ($db_chat_list['user_ids'] as $is_user_id) {
                SendData::sendToUid($is_user_id, 'chatData', [
                    'list_id' => $post_data['list_id'],
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
                    ]
                ]);
            }
        }

        $return_data['err'] = 0;

        if (($db_chat_list['type'] == 1 && $is_admin == 0) || $obj_id) {
            $return_data['msg'] = '已提交申请' . count($post_data['users']) . '位好友加入群聊';
        } else {
            $main_id = (Chat::where('list_id', $post_data['list_id'])->order('time', 'ASC')->find())->user_id;
            /** 如果还没有升级为群聊，添加群表 */
            if ($db_chat_list['type'] == 0) {
                ChatGroup::create([
                    'list_id' => $post_data['list_id'],
                    /** 默认第一个发起会话的人就是群主 */
                    'main_id' => $main_id,
                    'can_niming' => 0,
                    'name' => '群聊',
                    'agent_id' => $post_data['_agent_id'],
                ]);
                ChatMember::where([
                    'list_id' => $post_data['list_id'],
                    'user_id' => $main_id,
                ])
                    ->update([
                        'is_admin' => 1,
                    ]);
            }
            sort($user_ids);
            /** 更新这条会话类型为群聊，和更新成员字段 */
            ChatList::where('list_id', $post_data['list_id'])->update(['type' => 1, 'user_ids' => json_encode($user_ids)]);
            $return_data['msg'] = '已邀请' . count($post_data['users']) . '位好友';
        }
        Log::info('提交审核222.....'. $return_data['msg']);
        return json($return_data);
    }

    /** 获得群会话数据 */
    public function getGroupData()
    {
        $post_data = Request::post();
        $return_data = [
            'err' => 1,
            'msg' => 'fail',
            'data' => '',
        ];
        if (!isset($post_data['list_id']) || !isset($post_data['type'])) {
            $return_data['msg'] = 'data error';
            return json($return_data);
        }
        $db_group = ChatGroup::field($post_data['type'])->where('list_id', $post_data['list_id'])->find();
        if (!$db_group) {
            $return_data['msg'] = 'group data error';
            return json($return_data);
        }
        $return_data['err'] = 0;
        $return_data['msg'] = 'success';
        $return_data['data'] = $db_group->{$post_data['type']};
        return json($return_data);
    }

    /** 设置群会话数据 */
    public function setGroupData()
    {
        $post_data = Request::post();
        $return_data = [
            'err' => 1,
            'msg' => 'fail',
        ];
        if (!isset($post_data['list_id']) || !isset($post_data['type']) || !isset($post_data['content'])) {
            $return_data['msg'] = 'data error';
            return json($return_data);
        }
        $db_group = ChatGroup::field($post_data['type'])->where('list_id', $post_data['list_id'])->find();
        if (!$db_group) {
            $return_data['msg'] = 'group data error';
            return json($return_data);
        }
        ChatGroup::where('list_id', $post_data['list_id'])->update([
            $post_data['type'] => $post_data['content']
        ]);
        $chat_member_count = ChatMember::where('list_id', $post_data['list_id'])->count();
        $return_data['err'] = 0;
        $return_data['data']['show_name'] = $post_data['content']. "($chat_member_count)";
        $return_data['msg'] = 'success';
        return json($return_data);
    }

    /** 设置群的禁言 */
    public function groupIsMsg()
    {
        $post_data = Request::post();
        $return_data = [
            'err' => 1,
            'msg' => 'fail',
        ];
        if (!isset($post_data['list_id']) || !isset($post_data['value'])) {
            $return_data['msg'] = 'data error';
            return json($return_data);
        }

        /** 如果不是群主和管理员,就没有权限设置 */
        if (!(ChatGroup::where([
                'list_id' => $post_data['list_id'],
                'main_id' => USER_ID,
            ])
                ->find()) && !(ChatMember::where([
                'list_id' => $post_data['list_id'],
                'user_id' => USER_ID,
                'is_admin' => 1,
            ])
                ->find())) {
            $return_data['msg'] = '没有权限设置';
            return json($return_data);
        }

        $content = [
            'text' => '群已经被 ' . User::get(USER_ID)->nickname . ' ' . ($post_data['value'] == 0 ? '解除' : '') . '禁言了',
        ];
        /** 增加一条系统消息 */
        $chat_obj = Chat::createChatMsg([
            'list_id' => $post_data['list_id'],
            'user_id' => 0,
            'content_type' => 0,
            'msg_type' => 1,
            'content' => $content,
            'time' => time(),
        ]);

        $chat_member = ChatMember::field('user_id')
            ->where([
                'list_id' => $post_data['list_id']
            ])
            ->select()
            ->toArray();

        /** 给其他原先用户发送加入的消息 */
        foreach ($chat_member as $value) {
            SendData::sendToUid($value['user_id'], 'chatData', [
                'list_id' => $post_data['list_id'],
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
                ]
            ]);
        }
        ChatGroup::where('list_id', $post_data['list_id'])->update([
            'is_msg' => $post_data['value'],
        ]);
        $return_data['err'] = 0;
        $return_data['msg'] = 'success';
        return json($return_data);
    }

    /** 获得群成员 */
    public function groupMember()
    {
        $post_data = Request::post();
        $return_data = [
            'err' => 1,
            'msg' => 'fail',
            'data' => [],
        ];
        if (!isset($post_data['list_id'])) {
            $return_data['msg'] = 'data error';
            return json($return_data);
        }

        $group_data = ChatGroup::field('main_id')->where('list_id', $post_data['list_id'])->find();

        /** 如果是群主自己，获得除自己所有成员数据，如果是管理员，获得除去自己，除去管理员的数据 */
        if ($group_data->main_id == USER_ID) {
            $where = [
                ['list_id', '=', $post_data['list_id']],
                ['user_id', '<>', USER_ID],
            ];
        } else {
            $where = [
                ['list_id', '=', $post_data['list_id']],
                ['user_id', '<>', USER_ID],
                ['user_id', '<>', $group_data->main_id],
                ['is_admin', '=', 0],
            ];
        }
        $member_data = ChatMember::field('user_id,nickname')
            ->where($where)
            ->order('time', 'ASC')
            ->select()
            ->toArray();
        foreach ($member_data as $key => &$value) {
            $state_data = UserState::field('photo')
                ->where('user_id', $value['user_id'])
                ->find();
            $user_data = User::field('sex,nickname')->get($value['user_id']);
            if(!$user_data){
                unset($member_data[$key]);
                continue;
            }
            $friend_data = Friend::field('remarks')->where([
                'user_id' => USER_ID,
                'friend_id' => ($value['user_id'] * 1),
            ])
                ->find();
            if ($friend_data && $friend_data->remarks) {
                $value['nickname'] = $friend_data->remarks;
            } else {
                if (!$value['nickname']) {
                    $value['nickname'] = $user_data->nickname;
                }
            }
            $value['photo'] = getShowPhoto($state_data, $user_data->sex, $value['user_id'], 300);
        }
        $return_data['err'] = 0;
        $return_data['msg'] = 'success';
        $return_data['data'] = $member_data;
        return json($return_data);
    }

    /** 移除群成员 */
    public function removeChat()
    {
        $post_data = Request::post();
        $return_data = [
            'err' => 1,
            'msg' => 'fail',
        ];
        if (!isset($post_data['list_id']) || !isset($post_data['users'])) {
            $return_data['msg'] = 'data error';
            return json($return_data);
        }

        $group_data = ChatGroup::field('main_id,name')
            ->where('list_id', $post_data['list_id'])
            ->find();

        if (!$group_data) {
            $return_data['msg'] = '群聊数据有误';
            return json($return_data);
        }

        $chat_member_data = ChatMember::field('is_admin')
            ->where([
                'list_id' => $post_data['list_id'],
                'user_id' => USER_ID,
            ])
            ->find();
        if ($group_data->main_id != USER_ID && $chat_member_data->is_admin == 0) {
            $return_data['msg'] = '你没有权限,操作已取消';
            return json($return_data);
        }

        $db_chat_list = ChatList::field('type,user_ids')
            ->where([
                'user_id' => USER_ID,
                'list_id' => $post_data['list_id']
            ])
            ->find();

        if (!$db_chat_list) {
            $return_data['msg'] = '没有这条对话';
            return json($return_data);
        }

        $user_ids = json_decode($db_chat_list['user_ids'], true);
        $post_data['users'] = json_decode($post_data['users'], true);
        if(in_array(1,$post_data['users'])) return json(JsonDataService::fail('群通知机器人不能被删除!'));
        $last_user_ids = array_diff($user_ids, $post_data['users']);

        $i = 1;
        foreach ($post_data['users'] as $user_id) {
            if($user_id == 1) continue;
            $user_id *= 1;
            /** 删除会话列表 */
            ChatList::where([
                'user_id' => $user_id,
                'list_id' => $post_data['list_id'],
            ])
                ->delete();
            /** 删除成员列表 */
            ChatMember::where([
                'list_id' => $post_data['list_id'],
                'user_id' => $user_id,
            ])
                ->delete();
            $content = [
                'text' => User::get($user_id)->nickname . '被' . User::get(USER_ID)->nickname . '移除了群聊',
            ];
            /** 增加一条系统消息 */
            $chat_obj = Chat::createChatMsg([
                'list_id' => $post_data['list_id'],
                'user_id' => 0,
                'content_type' => 0,
                'msg_type' => 1,
                'content' => $content,
                'time' => time(),
            ]);
            /** 通知被移除的成员重新获取会话列表 */
            SendData::sendToUid($user_id, 'getChatList');
            /** 通知还在群里的成员 */
            $member_count = count($last_user_ids) - $i;
            foreach ($last_user_ids as $is_user_id) {
                SendData::sendToUid($is_user_id, 'setMessagePageTitle', ['list_id'=> $post_data['list_id'],'show_name'=>$group_data['name']."($member_count)"]);
                SendData::sendToUid($is_user_id, 'chatData', [
                    'list_id' => $post_data['list_id'],
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
                    ]
                ]);
            }
            $i++;
        }
        sort($last_user_ids);
        /** 更新这条会话成员 */
        ChatList::where('list_id', $post_data['list_id'])->update(['user_ids' => json_encode($last_user_ids)]);
        $return_data['err'] = 0;
        $return_data['msg'] = '已移除' . count($post_data['users']) . '位成员';
        return json($return_data);
    }

    /** 获得群头像 */
    public function getGroupPhoto()
    {
        $post_data = Request::post();
        $return_data = [
            'err' => 1,
            'msg' => 'fail',
        ];
        if (!isset($post_data['list_id'])) {
            $return_data['msg'] = 'data error';
            return json($return_data);
        }
        $group = ChatGroup::where('list_id', $post_data['list_id'])->find()->toArray();
        if (isset($group['is_photo']) && $group['is_photo']) {
            $photo = 'group_photo/' . $post_data['list_id'] . '/90.jpg';
        } else {
            $photo = 'default_group_photo/300.jpg';
        }
        $return_data['err'] = 0;
        $return_data['msg'] = 'success';
        $return_data['data'] = $photo;
        return json($return_data);
    }

    /** 更新群头像状态 */
    public function upGroupPhoto()
    {
        $post_data = Request::post();
        $return_data = [
            'err' => 1,
            'msg' => 'fail',
        ];

        if (!isset($post_data['list_id'])) {
            $return_data['msg'] = 'data error';
            return json($return_data);
        }

        $chat_group = ChatGroup::field('is_photo')->where('list_id', $post_data['list_id'])->find();

        if (!$chat_group) {
            $return_data['msg'] = '群聊数据错误';
            return json($return_data);
        }

        $chat_group->is_photo = 1;
        $chat_group->save();

        $return_data['err'] = 0;
        $return_data['msg'] = 'success';
        return json($return_data);
    }

    /** 获得群管理员表 */
    public function getGroupAdmin()
    {
        $post_data = Request::post();
        if (!isset($post_data['list_id']) || !isset($post_data['type'])) {
            $return_data['msg'] = 'data error';
            return json($return_data);
        }
        $group_data = ChatGroup::field('main_id')->where('list_id', $post_data['list_id'])->find();
        if (!$group_data) {
            $return_data['msg'] = '没有这条群聊消息';
            return json($return_data);
        }

        $chat_member_data = ChatMember::field('is_admin')
            ->where([
                'list_id' => $post_data['list_id'],
                'user_id' => USER_ID,
            ])
            ->find();

        if ($group_data->main_id != USER_ID && $chat_member_data->is_admin == 0) {
            $return_data['msg'] = '你没有权限,操作已取消';
            return json($return_data);
        }

        /** 如果是群主自己，获得除自己所有成员数据，如果是管理员，获得除去自己，除去管理员的数据 */
        if ($group_data->main_id == USER_ID) {
            $where = [
                ['list_id', '=', $post_data['list_id']],
                ['user_id', '<>', USER_ID],
                ['user_id', '<>', 1],
            ];
        } else {
            $where = [
                ['list_id', '=', $post_data['list_id']],
                ['user_id', '<>', USER_ID],
                ['user_id', '<>', 1],
                ['user_id', '<>', $group_data->main_id],
                ['is_admin', '=', 0],
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
            foreach ($db_data as $key =>$value) {
                $User = User::field('nickname,sex')->get($value['user_id']);
                if(!$User){
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
        return json($return_data);
    }

    /** 设置管理员 */
    public function setGroupAdmin()
    {
        $post_data = Request::post();
        $return_data = [
            'err' => 1,
            'msg' => 'fail',
        ];
        if (!isset($post_data['list_id']) || !isset($post_data['users']) || !isset($post_data['type'])) {
            $return_data['msg'] = 'data error';
            return json($return_data);
        }

        $group_data = ChatGroup::field('main_id')->where('list_id', $post_data['list_id'])->find();
        if (!$group_data) {
            $return_data['msg'] = '没有这条群聊消息';
            return json($return_data);
        }

        $chat_member_data = ChatMember::field('is_admin')
            ->where([
                'list_id' => $post_data['list_id'],
                'user_id' => USER_ID,
            ])
            ->find();

        if ($group_data->main_id != USER_ID && $chat_member_data->is_admin == 0) {
            $return_data['msg'] = '你没有权限,操作已取消';
            return json($return_data);
        }

        switch ($post_data['type']) {
            case 1:
                ChatMember::where([
                    ['list_id', '=', $post_data['list_id']],
                    ['user_id', '<>', USER_ID],
                ])
                    ->update([
                        'is_admin' => 0,
                    ]);
                $post_data['users'] = json_decode($post_data['users'], true);
                foreach ($post_data['users'] as &$value) {
                    $value *= 1;
                }
                ChatMember::where([
                    ['list_id', '=', $post_data['list_id']],
                    ['user_id', 'in', $post_data['users']],
                ])
                    ->update([
                        'is_admin' => 1,
                    ]);
                break;
            case 2:
                /** 群主设置所有 */
                if ($group_data->main_id == USER_ID) {
                    $where = [
                        ['list_id', '=', $post_data['list_id']],
                        ['user_id', '<>', USER_ID],
                    ];
                } /** 管理员只能设置普通会员 */
                else {
                    $where = [
                        ['list_id', '=', $post_data['list_id']],
                        ['user_id', '<>', USER_ID],
                        ['is_admin', '=', 0],
                    ];
                }
                ChatMember::where($where)
                    ->update([
                        'is_msg' => 0,
                    ]);
                $post_data['users'] = json_decode($post_data['users'], true);
                foreach ($post_data['users'] as &$value) {
                    $value *= 1;
                }
                ChatMember::where([
                    ['list_id', '=', $post_data['list_id']],
                    ['user_id', 'in', $post_data['users']],
                ])
                    ->update([
                        'is_msg' => 1,
                    ]);
                break;
            default:
                $return_data['msg'] = '未知类型';
                return json($return_data);
                break;
        }
        $return_data['err'] = 0;
        $return_data['msg'] = '已设置';
        return json($return_data);
    }

    /** 撤回消息 */
    public function withdraw()
    {
        $post_data = Request::post();
        $return_data = [
            'err' => 1,
            'msg' => 'fail',
        ];
        if (!isset($post_data['list_id']) || !isset($post_data['type']) || !isset($post_data['msg_id'])) {
            $return_data['msg'] = 'data error';
            return json($return_data);
        }

        $chat_data = Chat::field('time,user_id')
            ->where([
                'list_id' => $post_data['list_id'],
                'id' => $post_data['msg_id'],
            ])
            ->find();

        if (!$chat_data) {
            $return_data['msg'] = '没有这条消息';
            return json($return_data);
        }

        switch ($post_data['type']) {
            /** 这里是对话，撤回消息，时间不能超过 2 分钟 */
            case 0:
                if ($chat_data->user_id != USER_ID) {
                    $return_data['msg'] = '不能撤回其他人的消息';
                    return json($return_data);
                }
                if (intval((time() - $chat_data->time) / 60) > 2) {
                    $return_data['msg'] = '只能撤回2分钟之内的消息';
                    return json($return_data);
                }
                break;
            case 1:
                $member_data = ChatMember::field('is_admin')
                    ->where([
                        'list_id' => $post_data['list_id'],
                        'user_id' => USER_ID,
                    ])
                    ->find();

                if (!$member_data) {
                    $return_data['msg'] = '成员消息错误';
                    return json($return_data);
                }

                $group_data = ChatGroup::field('main_id')
                    ->where('list_id', $post_data['list_id'])
                    ->find();

                if (!$group_data) {
                    $return_data['msg'] = '群聊数据错误';
                    return json($return_data);
                }

                /** 如果自己是群主，可以撤回任何时间的消息 */
                if (USER_ID != $group_data->main_id) {
                    if ($chat_data->user_id == $group_data->main_id) {
                        $return_data['msg'] = '不能撤回群主的消息';
                        return json($return_data);
                    }
                    /** 如果自己是管理员，只能撤回自己的和普通会员的消息 */
                    if ($member_data->is_admin) {
                        $member_obj = ChatMember::field('is_admin')
                            ->where([
                                'list_id' => $post_data['list_id'],
                                'user_id' => $chat_data->user_id,
                            ])
                            ->find();
                        if ($member_obj->is_admin && $chat_data->user_id != USER_ID) {
                            $return_data['msg'] = '不能撤回其他管理员的消息';
                            return json($return_data);
                        }
                    } /** 如果自己不是管理员，不是群主，只能撤回自己2分钟之内的消息 */
                    else {
                        if ($chat_data->user_id != USER_ID) {
                            $return_data['msg'] = '不能撤回其他人的消息';
                            return json($return_data);
                        }
                        if (intval((time() - $chat_data->time) / 60) > 2) {
                            $return_data['msg'] = '只能撤回2分钟之内的消息';
                            return json($return_data);
                        }
                    }
                }
                break;
            default:
                $return_data['msg'] = '未知错误';
                return json($return_data);
                break;
        }

        $chat_member_data = ChatMember::field('user_id')
            ->where('list_id', $post_data['list_id'])
            ->select()
            ->toArray();

        $content = [
            'text' => User::get(USER_ID)->nickname . ' 撤回了一条消息',
        ];

        /** 更新撤回的那条消息为系统提示测回消息 */
        Chat::update([
            'id' => $post_data['msg_id'],
            'user_id' => 0,
            'content_type' => 0,
            'msg_type' => 1,
            'content' => $content,
        ]);

        /** 通知所有成员 */
        foreach ($chat_member_data as $value) {
            SendData::sendToUid($value['user_id'], 'deleteChat', [
                'list_id' => $post_data['list_id'],
                'data' => [
                    'type' => 1,
                    'msg' => [
                        'user_info' => [
                            'uid' => 0,
                        ],
                        'id' => $post_data['msg_id'],
                        'type' => 0,
                        'content' => $content,
                        'time' => time(),
                    ],
                ]
            ]);
        }

        $return_data['err'] = 0;
        $return_data['msg'] = '已撤回';
        return json($return_data);
    }

    /** 发起群聊 */
    public function addGroup()
    {
        $post_data = Request::post();
        $return_data = [
            'err' => 1,
            'msg' => 'fail',
        ];
		//判断是否只有客户账号可以创建群聊
        $config = BsysConfig::getAllVal('basic_config');
        if($config['user_create_group'] == 1){
            //判断当前账号是否客服账号
            $user_info = UserService::getUserInfo(USER_ID);
            if($user_info['is_customer_service'] != 1){
                $return_data['msg'] = '不允许创建群聊';
                return json($return_data);
            }
        }
        if (!isset($post_data['list_id']) || !isset($post_data['users'])) {
            $return_data['msg'] = 'data error';
            return json($return_data);
        }
        $post_data['users'] = json_decode($post_data['users'], true);
        if (count($post_data['users']) < 1) {
            $return_data['msg'] = '请选择群聊成员';
            return json($return_data);
        }

        $post_data['users'][] = USER_ID;
        sort($post_data['users']);
        $chat_user_ids = json_encode($post_data['users']);
        $list_id = create_guid();

        /** 增加到群表 */
        ChatGroup::create([
            'list_id' => $list_id,
            'main_id' => USER_ID,
            'can_niming' => 0,
            'name' => '群聊',
            'agent_id' => $post_data['_agent_id'],
        ]);
        $user_names = '';
        //合成群头像

        UserStateService::setGroupPhoto(['list_id'=>$list_id,'user_ids'=>$post_data['users'],'main_id'=>USER_ID]);
        //机器人进群
        array_push($post_data['users'],1);
        foreach ($post_data['users'] as $user_id) {

            /** 增加会话列表 */
            ChatList::create([
                'user_id' => $user_id,
                'list_id' => $list_id,
                'user_ids' => $chat_user_ids,
                'type' => 1,
                'last_chat_time'=>time(),
            ]);
            /** 增加到成员表 */
            ChatMember::create([
                'list_id' => $list_id,
                'user_id' => $user_id,
            ]);

            if ($user_id == USER_ID) {
                ChatMember::where([
                    'list_id' => $list_id,
                    'user_id' => $user_id,
                ])
                    ->update([
                        'is_admin' => 1,
                    ]);
            }

            $user_names .= ($user_names ? ',' : '') . User::field('nickname')->get($user_id)->nickname;
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

        foreach ($post_data['users'] as $user_id) {
            /** 通知双方重新获取列表数据 */
            SendData::sendToUid($user_id, 'getChatList');
        }
        $return_data['err'] = 0;
        $return_data['msg'] = '已成功创建';
        return json($return_data);
    }

    /** 设置会话置顶 */
    public function chatTop()
    {
        $post_data = Request::post();
        $return_data = [
            'err' => 1,
            'msg' => 'fail',
        ];
        if (!isset($post_data['list_id']) || !isset($post_data['value'])) {
            $return_data['msg'] = 'data error';
            return json($return_data);
        }
        ChatList::where([
            'list_id' => $post_data['list_id'],
            'user_id' => USER_ID,
        ])
            ->update([
                'top' => $post_data['value'],
                'top_time' => ($post_data['value'] ? time() : 0),
            ]);

        $return_data['err'] = 0;
        $return_data['msg'] = 'success';
        return json($return_data);
    }

    /** 允许普通会员邀请的成员加入群聊 */
    public function addGroupAllow()
    {
        $post_data = Request::post();
        $return_data = [
            'err' => 1,
            'msg' => 'fail',
        ];
        if (!isset($post_data['id'])) {
            $return_data['msg'] = 'data error';
            return json($return_data);
        }
        $group_apply_data = ChatGroupApply::get($post_data['id']);
        if (!$group_apply_data) {
            $return_data['msg'] = '没有找到这条申请记录';
            return json($return_data);
        }

        if (ChatMember::where([
            'list_id' => $group_apply_data->list_id,
            'user_id' => $group_apply_data->invite_to_user_id,
        ])->find()) {
            $return_data['msg'] = '这个用户已经加入群了';
            return json($return_data);
        }

        $chat_user_ids = ChatList::field('user_ids')->where('list_id', $group_apply_data->list_id)->find()->user_ids;
        $chat_user_ids = json_decode($chat_user_ids, true);
        $chat_user_ids[] = $group_apply_data->invite_to_user_id;
        sort($chat_user_ids);
        $chat_user_ids_string = json_encode($chat_user_ids);

        /** 增加会话列表 */
        ChatList::create([
            'user_id' => $group_apply_data->invite_to_user_id,
            'list_id' => $group_apply_data->list_id,
            'user_ids' => $chat_user_ids_string,
            'type' => 1,
            'last_chat_time'=>time(),
        ]);

        /** 增加到成员表 */
        ChatMember::create([
            'list_id' => $group_apply_data->list_id,
            'user_id' => $group_apply_data->invite_to_user_id,
            'is_admin' => 0,
        ]);

        $content = [
            'text' => User::get($group_apply_data->invite_to_user_id)->username . ' 加入群聊',
        ];

        /** 增加一条系统消息 */
        $chat_obj = Chat::createChatMsg([
            'list_id' => $group_apply_data->list_id,
            'user_id' => 0,
            'content_type' => 0,
            'msg_type' => 1,
            'content' => $content,
            'time' => time(),
        ]);

        $msg = [
            'list_id' => $group_apply_data->list_id,
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
        SendData::sendToUid($group_apply_data->invite_to_user_id, 'getChatList');

        /** 通知群所有人新成员的加入 */
        $member_count = count($chat_user_ids) - 1; //扣除机器人的数量
       $group = ChatGroup::where(['list_id'=>$group_apply_data->list_id])->find();
       if(!$group) return json(['err'=>1,'msg'=>'该群不存在或已解散']);
        foreach ($chat_user_ids as $user_id) {
            SendData::sendToUid($user_id, 'chatData', $msg);
            SendData::sendToUid($user_id, 'setMessagePageTitle', ['list_id'=>$group_apply_data->list_id,'show_name'=>$group['name']."($member_count)"]);
        }

        /** 通知所有群管理，申请已处理 */
        foreach (ChatMember::field('user_id')->where(['list_id' => $group_apply_data->list_id, 'is_admin' => 1])->select() as $v) {
            SendData::sendToUid($v->user_id, 'groupChatApplyAllow', $post_data['id']);
        }

        ChatGroupApply::update([
            'id' => $post_data['id'],
            'status' => 1,
            'handle_user_id' => USER_ID,
        ]);

        $return_data['err'] = 0;
        $return_data['msg'] = 'success';
        return json($return_data);
    }

    /** 解散群 */
    public function removeGroup()
    {
        $post_data = Request::post();
        $return_data = [
            'err' => 1,
            'msg' => 'fail',
        ];
        if (!isset($post_data['list_id'])) {
            $return_data['msg'] = 'data error';
            return json($return_data);
        }
        $list_data = ChatList::field('type')->where('list_id', $post_data['list_id'])->find();
        if (!$list_data) {
            $return_data['msg'] = '没有找到对话数据';
            return json($return_data);
        }
        if ($list_data->type != 1) {
            $return_data['msg'] = '不是群聊不能解散';
            return json($return_data);
        }
        $group_data = ChatGroup::field('main_id,name')->where('list_id', $post_data['list_id'])->find();
        if (!$group_data) {
            $return_data['msg'] = '群数据有误';
            return json($return_data);
        }
        if ($group_data->main_id != USER_ID) {
            $return_data['msg'] = '不是群主,没有权限操作';
            return json($return_data);
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
        $return_data['err'] = 0;
        $return_data['msg'] = 'success';
        return json($return_data);
    }

    //发送视频
    public function sendVideo()
    {

        $post_data = Request::post();
        $return_data = MsgService::sendVideo([
            'user_id'=>USER_ID,
            'list_id'=>$post_data['list_id'],
            'content_type'=>$post_data['content_type'],
        ]);
        return json($return_data);
    }

    /**
     * 同意音视频
     * @return \think\response\Json
     */
    public function agreeVedio(){
        $post_data = Request::post();
        $return_data = MsgService::agreeVedio(array_merge(['user_id'=>USER_ID],$post_data));
        return json($return_data);
    }

    //关闭音频通话
    public function closeVideo(){
        $post_data = Request::post();
        $return_data = MsgService::closeVideo([
            'user_id'=>USER_ID,
            'list_id'=>$post_data['list_id'],
            'roomid'=>$post_data['roomid'],
            'time'=>$post_data['time'] ?? 0,
            'ret_code'=>$post_data['ret_code'] ?? 0, //谁取消的
            'content_type'=>$post_data['content_type']
        ]);
        return json($return_data);
    }

    /**
     * list_id  会话ID
     * amount 金额 num 数量 type 类型
     * (单人获群聊)
     * 发送红包消息
     */
    public function createHongBao(){
        $post_data = Request::post(); //user_id
        $res = HongBaoService::createHongbao([
            'type' => $post_data['type'],
            'num' => $post_data['num'],
            'user_id' => USER_ID,
            'list_id' => $post_data['list_id'],
            'msg' => $post_data['hongbao_msg'],
            'amount' => $post_data['amount'],
            'trade_password' => $post_data['trade_password'],
        ]);
        return json($res);
    }

    /**
     * list_id  会话ID
     * amount 金额 num 数量 type 类型
     * (单人获群聊)
     * 发送红包消息
     */
    public function getHongBao(){
        $post_data = Request::post(); //user_id
        $res = HongBaoService::getHongBao([
            'rid'=>$post_data['rid'],
            'user_id' => USER_ID
        ]);
        return json($res);
    }


    /**
     * 发送卡片消息
     */
    public function sendCard(){
        $post_data = Request::post(); //user_id
        $res = (new MsgService())->sendCard([
            'user_ids'=>json_decode($post_data['users'],true),
            'user_id'=>USER_ID,
            'list_id'=>$post_data['list_id']

        ]);
        return json($res);
    }

    /**
    * 查看群成员
    */
    public function speekChecked(){
        $post_data = Request::post(); //user_id
        if (!(ChatGroup::where([
                'list_id' => $post_data['list_id'],
                'main_id' => USER_ID,
            ])->find()) || !(ChatMember::where([
                'list_id' => $post_data['list_id'],
                'user_id' => USER_ID,
                'is_admin' => 1,
            ])
                ->find())) {
            //不是群组和管理员没有权限
            $return_data['msg'] = '没有权限设置';
            return json($return_data);
        }
        //can_add_friend
        ChatGroup::where('list_id', $post_data['list_id'])->update([
            'can_add_friend' => $post_data['value'] ? 0 : 1,
        ]);
        $return_data['err'] = 0;
        $return_data['msg'] = 'success';
        return json($return_data);

    }
    /**
     * 发送位置消息
     */
    public function nimingChange(){
        $post_data = Request::post(); //user_id
        if (!(ChatGroup::where([
                'list_id' => $post_data['list_id'],
                'main_id' => USER_ID,
            ])->find()) && !(ChatMember::where([
                'list_id' => $post_data['list_id'],
                'user_id' => USER_ID,
                'is_admin' => 1,
            ])
                ->find())) {
            //不是群组和管理员没有权限
            $return_data['msg'] = '没有权限设置';
            return json($return_data);
        }
        //can_add_friend
        $ret = ChatGroup::where('list_id', $post_data['list_id'])->update([
            'can_niming' => $post_data['value']
        ]);
        $return_data['err'] = 0;
        $return_data['data'] = ChatGroup::where('list_id', $post_data['list_id'])->find();
        $return_data['msg'] = 'success';
        return json($return_data);

    }

    /**
     * 离开群组
     */
    public function liveGroup(){
        $post_data = Request::post();
        $return_data = [
            'err' => 1,
            'msg' => 'fail',
        ];
        if (!isset($post_data['list_id'])) {
            $return_data['msg'] = 'data error';
            return json($return_data);
        }

        $group_data = ChatGroup::field('main_id')
            ->where('list_id', $post_data['list_id'])
            ->find();

        if (!$group_data) {
            $return_data['msg'] = '群聊数据有误';
            return json($return_data);
        }

        $db_chat_list = ChatList::field('type,user_ids')
            ->where([
                'user_id' => USER_ID,
                'list_id' => $post_data['list_id']
            ])
            ->find();

        if (!$db_chat_list) {
            $return_data['msg'] = '没有这条对话';
            return json($return_data);
        }

        $user_ids = json_decode($db_chat_list['user_ids'], true);
        $post_data['users'] = [USER_ID];
        if(in_array(1,$post_data['users'])) return json(JsonDataService::fail('群通知机器人不能退出!'));
        $last_user_ids = array_diff($user_ids, $post_data['users']);

            $user_id = USER_ID* 1;
            /** 删除会话列表 */
            ChatList::where([
                'user_id' => $user_id,
                'list_id' => $post_data['list_id'],
            ])->delete();
            /** 删除成员列表 */
            ChatMember::where([
                'list_id' => $post_data['list_id'],
                'user_id' => $user_id,
            ])->delete();
            $content = [
                'text' => User::get($user_id)->nickname .'退出了群聊',
            ];
            /** 增加一条系统消息 */
            $chat_obj = Chat::createChatMsg([
                'list_id' => $post_data['list_id'],
                'user_id' => 0,
                'content_type' => 0,
                'msg_type' => 1,
                'content' => $content,
                'time' => time(),
            ]);
            /** 重新获取列表 */
            SendData::sendToUid($user_id, 'getChatList');
            /** 通知还在群里的成员 */
            foreach ($last_user_ids as $is_user_id) {
                SendData::sendToUid($is_user_id, 'chatData', [
                    'list_id' => $post_data['list_id'],
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
                    ]
                ]);
            }
        sort($last_user_ids);
        /** 更新这条会话成员 */
        ChatList::where('list_id', $post_data['list_id'])->update(['user_ids' => json_encode($last_user_ids)]);
        $return_data['err'] = 0;
        $return_data['msg'] = '已退出群聊';
        return json($return_data);
    }

    /**
     * 消息免打扰
     */
    public function msgDisturb(){
        $post_data = Request::post();
        return json(UserService::updateChatMemberDistrub(array_merge($post_data,['user_id'=>USER_ID])));
    }

}
