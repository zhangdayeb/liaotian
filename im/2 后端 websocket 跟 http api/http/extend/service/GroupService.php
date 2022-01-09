<?php
/**
 * Created by IntelliJ IDEA.
 * User: Administrator
 * Date: 2020/9/6 0006
 * Time: 11:42
 */

namespace extend\service;


use app\im\model\mongo\Chat;
use app\im\model\mongo\ChatGroup;
use app\im\model\mongo\ChatList;
use app\im\model\mongo\ChatMember;
use app\im\model\mysql\User;
use \app\common\controller\SendData;

class GroupService
{
    public static function addGroup($list_id,$user_id,$is_robot = 0){

        if(!ChatGroup::where(['list_id'=>$list_id])->find())return JsonDataService::fail('群不存在');
        if (ChatMember::where([
            'list_id' => $list_id,
            'user_id' =>$user_id,
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
            'user_id' =>$user_id,
            'list_id' => $list_id,
            'user_ids' => $chat_user_ids_string,
            'type' => 1,
        ]);

        /** 增加到成员表 */
        ChatMember::create([

            'list_id' => $list_id,
            'user_id' => $user_id,
            'is_admin' => 0,
            'is_robot' => $is_robot,
        ]);

        $content = [
            'text' => User::get($user_id)->nickname . ' 加入群聊',
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

        /** 通知群所有人新成员的加入 */
        foreach ($chat_user_ids as $user_id) {
            SendData::sendToUid($user_id, 'chatData', $msg);
        }
        return JsonDataService::success('加入成功!');
    }

    public static function tuiQun($post_data,$can = 0){
        if (!isset($post_data['list_id']) || !isset($post_data['users'])) {
            return JsonDataService::fail('参数错误');
        }

        $group_data = ChatGroup::field('main_id')
            ->where('list_id', $post_data['list_id'])
            ->find();

        if (!$group_data) {
            return JsonDataService::fail('群聊数据有误');
        }

        $chat_member_data = ChatMember::field('is_admin')
            ->where([
                'list_id' => $post_data['list_id'],
                'user_id' => $post_data['user_id'],
            ])
            ->find();
        if ($group_data->main_id != $post_data['user_id'] && $chat_member_data->is_admin == 0 && !$can) {
            $return_data['msg'] = '你没有权限,操作已取消';
            return JsonDataService::fail('你没有权限,操作已取消');
        }

        $db_chat_list = ChatList::field('type,user_ids')
            ->where([
                'user_id' => $post_data['user_id'],
                'list_id' => $post_data['list_id']
            ])
            ->find();

        if (!$db_chat_list) {
            $return_data['msg'] = '没有这条对话';
            return JsonDataService::fail('没有这条对话');
        }

        $user_ids = json_decode($db_chat_list['user_ids'], true);
        if(in_array(1,$post_data['users'])) return JsonDataService::fail('群通知机器人不能被删除!');
        $last_user_ids = array_diff($user_ids, $post_data['users']);

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
            /** 通知被移除的成员重新获取会话列表 */
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

        }
        sort($last_user_ids);
        /** 更新这条会话成员 */
        ChatList::where('list_id', $post_data['list_id'])->update(['user_ids' => json_encode($last_user_ids)]);
        return JsonDataService::success();
    }

    /**
     * 销毁聊天记录
     */
    public static function xiaoHuiMessage($params = array()){
        //查找出所有的聊天记录
        $user_id = $params['user_id'] * 1;
        $list_id = $params['list_id'];
        $chat_list = ChatList::where(['list_id'=>$params['list_id'],'user_id'=>$user_id])->find();
        if(empty($chat_list)) return JsonDataService::fail('非法操作');
        if($params['type'] == 1){
            //如果是群则交易有无权限
            ChatGroup::where(['list_id'=>$list_id])->find();
        }
    }
}