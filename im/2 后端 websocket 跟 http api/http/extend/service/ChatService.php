<?php
/**
 * Created by IntelliJ IDEA.
 * User: Administrator
 * Date: 2020-06-24
 * Time: 16:03
 */

namespace extend\service;


use app\im\model\mongo\Chat;
use app\im\model\mongo\ChatGroup;
use app\im\model\mongo\ChatList;
use app\im\model\mongo\Friend;
use app\im\model\mongo\UserState;
use app\im\model\mysql\User;
use app\im\model\traits\MongoObj;
use MongoDB\BSON\Regex;
use think\Db;

class ChatService
{

    public static function getSerchList(array $params)
    {
        $user_id = $params['user_id'];
        $chat_msg = preg_quote($params['chat_msg']);
        $total_data = $db_data = ChatList::field('list_id,user_ids,no_reader_num,type,top,top_time')->where([
            'user_id' => $user_id,
            'status' => 0,
        ])->select()->toArray();
        if (!$total_data) return JsonDataService::success('会话列表!');
        $list_ids = array_values(array_unique(array_column($total_data, 'list_id')));
        $chat_data = Chat::field('list_id,user_id')
            ->where(['content.text' => (new Regex('^' . $chat_msg))])
            ->where([
                'content_type' => 0,
                'msg_type' => 0
            ])
            ->where(['list_id' => $list_ids])
            ->order('time', 'DESC')
            ->select();
        if (!$chat_data) return JsonDataService::success('会话列表!');
        $list_ids = array_values(array_unique(array_column($chat_data->toArray(), 'list_id')));
        $db_data = MongoObj::init('chat_list')->find([
            'user_id' => $user_id,
            'status' => 0,
            'list_id' => ['$in' => $list_ids]
        ], [
            'projection' => [  //指定字段
                'user_id' => 1,
                'status' => 1,
                'list_id' => 1,
                'no_reader_num' => 1,
                'user_ids' => 1,
                'type' => 1,
                'top_time' => 1,
                'top' => 1,
            ],
        ]);

//        $map['list_id'] = array_unique($list_ids);
//        $db_data = ChatList::field('list_id,user_ids,no_reader_num,type,top,top_time')->where([
//            'user_id' => $user_id,
//            'status' => 0,
//        ])
//            ->where($map)
//            ->select()
//            ->toArray();
//        $map['act'] = array('$exists'=>true, '$not'=>array('$in'=>array("click", "listview")) );
        $chat_other_data = [];
        $top_data = [];
        if (!empty($db_data)) {
            foreach ($db_data as $key => $value) {
                switch ($value['type']) {
                    case 0:
                        /** 对话 */
                        $chat_data = Chat::field('user_id,content_type,msg_type,content,time,id')
                            ->where('list_id', $value['list_id'])
                            ->where(['content.text' => (new Regex('^' . $chat_msg))])
                            ->order('time', 'DESC')
                            ->find();
                        $value['user_ids'] = json_decode($value['user_ids']);
                        $friend_id = $value['user_ids'][0] == $user_id ? $value['user_ids'][1] : $value['user_ids'][0];
                        $friend_data = Friend::field('remarks')
                            ->where([
                                'user_id' => $user_id,
                                'friend_id' => ($friend_id * 1),
                            ])
                            ->find();
                        $db_user = User::get($friend_id);
                        /** 如果没有设置备注就显示用户昵称 */
                        if (!$friend_data || !$db_user) {
                            unset($db_data[$key]);
                            break;
                        }
                        if ($friend_data->remarks) {
                            $show_name = $friend_data->remarks;
                        } else {
                            $show_name = $db_user->nickname;
                        }
                        $last_msg = '';
                        if ($chat_data) {
                            $last_msg = $chat_data->content_type ? self::chatType($chat_data->content_type) : $chat_data['content']['text'] ?? '';
                            $time = $chat_data->time;
                        }

                        $user_state = UserState::field('photo')->where('user_id', $friend_id)->find();
                        $photo_path = getShowPhoto($user_state, $db_user->sex, $friend_id, 300);
                        break;
                    case 1:
                        /** 群聊 */
                        $chat_data = Chat::field('user_id,content_type,msg_type,content,time,id')
                            ->where('list_id', $value['list_id'])
                            ->where(['content.text' => (new Regex('^' . $chat_msg))])
                            ->order('time', 'DESC')->find();
                        $last_msg = $chat_data->content_type ? self::chatType($chat_data->content_type) : $chat_data['content']['text'] ?? '';
                        $time = $chat_data->time;

                        $group_data = ChatGroup::field('name,is_photo')->where('list_id', $value['list_id'])->find()->toArray();
                        $show_name = $group_data['name'];
                        if (isset($group_data['is_photo']) && $group_data['is_photo']) {
                            $photo_path = '/group_photo/' . $value['list_id'] . '/90.jpg';
                        } else {
                            $photo_path = 'default_group_photo/90.jpg';
                        }
                        break;
                    default:
                        /** 未知类消息 */
                        $last_msg = '';
                        $time = 0;
                        $show_name = '未知消息';
                        break;
                }
                $data = [
                    'list_id' => $value['list_id'],
                    'no_reader_num' => $value['no_reader_num'],
                    'show_name' => $show_name,
                    'last_msg' => $last_msg,
                    'photo_path' => $photo_path,
                    'time' => $time,
                    'top' => $value['top'],
                    'top_time' => (isset($value['top_time']) ? $value['top_time'] : 0),
                    'type' => $value['type'],
                    'chat_id' => $chat_data->id,
                ];
                if ($value['top']) {
                    $top_data[] = $data;
                } else {
                    $chat_other_data[] = $data;
                }
            }
            /** 消息置顶的根据置顶时间来排序 */
            if (count($top_data)) {
                $is_field = array_column($top_data, 'top_time');
                array_multisort($is_field, SORT_DESC, $top_data);
            }
            /** 根据消息最后时间排序 */
            if (count($chat_other_data)) {
                $is_field = array_column($chat_other_data, 'time');
                array_multisort($is_field, SORT_DESC, $chat_other_data);
            }
        }
        return JsonDataService::success('会话列表', array_merge($top_data, $chat_other_data));
    }

    /**
     * 会话列表
     */
    public static function chatList($user_id,$type= -1)
    {
        /**
         * $gt:大于
        $lt:小于
        $gte:大于或等于
        $lte:小于或等于
         */
        $limit = 1000;
        $mongo_chat_list= MongoObj::init('chat_list');
        $where = [
            'status' => 0,
            'user_id' => $user_id,
        ];
        if($type > - 1)$where['type'] = 1;
        $db_data = $mongo_chat_list->find($where, [
            'projection' => [  //指定字段
                'user_id' => 1,
                'status' => 1,
                'list_id' => 1,
                'no_reader_num' => 1,
                'user_ids' => 1,
                'type' => 1,
                'top_time' => 1,
                'top' => 1,
                'last_chat_time'=>1,
            ],
            'sort' => ['top'=>-1,'last_chat_time' => -1],
            'limit'=>$limit
        ]);
        $db_data = $db_data->toArray();
        $list = [];
        foreach ($db_data as $key => $value) {
            $chat_id = '';
            switch ($value['type']) {
                case 0:
                    /** 对话 */
                    $chat_data = Chat::field('user_id,content_type,msg_type,content,time,id')
                        ->where('list_id', $value['list_id'])
                        ->order('time', 'DESC')
                        ->find();
                    $value['user_ids'] = is_array($value['user_ids']) ? $value['user_ids'] : json_decode($value['user_ids']);
                    $friend_id = $value['user_ids'][0] == $user_id ? $value['user_ids'][1] : $value['user_ids'][0];
                    $friend_data = Friend::field('remarks')
                        ->where([
                            'user_id' => $user_id,
                            'friend_id' => ($friend_id * 1),
                        ])
                        ->find();
                    $db_user = User::get($friend_id);
                    if (!$db_user) {
                        unset($db_data[$key]);
                        break;
                    }
                    /** 如果没有设置备注就显示用户昵称 */
                    if (!$friend_data) {
                        unset($db_data[$key]);
                        break;
                    }
                    if ($friend_data->remarks) {
                        $show_name = $friend_data->remarks;
                    } else {
                        $show_name = $db_user->nickname ?? '';
                    }
                    $last_msg = '';
                    if ($chat_data) {
                        $chat_id = $chat_data->id;
                        $last_msg = $chat_data->content_type ? self::chatType($chat_data->content_type) : $chat_data['content']['text'] ?? '';
                        $time = $chat_data->time;
                    }

                    $user_state = UserState::field('photo')->where('user_id', intval($friend_id))->find();
                    $photo_path = getShowPhoto($user_state, $db_user->sex, $friend_id, 300);
                    break;
                case 1:
                    /** 群聊 */
                    $chat_data = Chat::field('user_id,content_type,msg_type,content,time,id')->where('list_id', $value['list_id'])->order('time', 'DESC')->find();
                    if(!$chat_data){
                        unset($db_data[$key]);
                        break;
                    }
                    $last_msg = $chat_data->content_type ? self::chatType($chat_data->content_type) : $chat_data['content']['text'] ?? '';
                    $time = $chat_data->time;
                    $chat_id = $chat_data->id;
                    $group_data = ChatGroup::field('name,is_photo')->where('list_id', $value['list_id'])->find()->toArray();
                    $show_name = $group_data['name'];
                    if (isset($group_data['is_photo']) && $group_data['is_photo']) {
                        $photo_path = '/group_photo/' . $value['list_id'] . '/90.jpg';
                    } else {
                        $photo_path = 'default_group_photo/90.jpg';
                    }
                    break;
                case 2:
                    /** 系统消息 */
                    $last_msg = '';
                    $time = 0;
                    $show_name = '系统消息';
                    break;
                case 3:
                    /** 公众号消息 */
                    $last_msg = '';
                    $time = '';
                    $show_name = 0;
                    break;
                default:
                    /** 未知类消息 */
                    $last_msg = '';
                    $time = 0;
                    $show_name = '未知消息';
                    break;
            }
            if(empty($chat_id)){
                unset($db_data[$key]);
                break;
            }
            $data = [
                'list_id' => $value['list_id'],
                'last_chat_time' => $value['last_chat_time'],
                'chat_id' => $chat_id,
                'no_reader_num' => $value['no_reader_num'],
                'show_name' => $show_name,
                'last_msg' => $last_msg,
                'photo_path' => $photo_path,
                'time' => $time,
                'top' => $value['top'],
                'top_time' => (isset($value['top_time']) ? $value['top_time'] : 0),
                'type' => $value['type'],
            ];
            $list[] = $data;
        }
        return JsonDataService::success('',$list);
    }
    /** 对话消息类型 */
    public static function chatType($type)
    {
        switch ($type) {
            case 1:
                /** 语音 */
                $last_msg = '[语音]';
                break;
            case 2:
                /** 图片 */
                $last_msg = '[图片]';
                break;
            case 3:
                /** 视频 */
                $last_msg = '[视频]';
                break;
            case 4:
                /** 文件 */
                $last_msg = '[文件]';
                break;
            case 5:
                /** 红包 */
                $last_msg = '[红包]';
                break;
            case 6:
                /** 在线视频 */
                $last_msg = '[在线视频]';
                break;
            case 7:
                /** 在线视频 */
                $last_msg = '[在线语音]';
                break;
            case 8:
                /** 在线视频 */
                $last_msg = '[名片]';
                break;
            case 9:
                /** 在线视频 */
                $last_msg = '[戳一戳]';
                break;
            default:
                /** 未知消息类型 */
                $last_msg = '[未知]';
                break;
        }
        return $last_msg;
    }
}