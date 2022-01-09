<?php

namespace app\im\controller;

use app\im\model\mongo\HongBaoDetails;
use app\im\model\traits\MongoObj;
use extend\service\ChatService;
use extend\service\FriendService;
use extend\service\HongBaoService;
use extend\service\JsonDataService;
use extend\service\PayMentService;
use extend\service\UserService;
use \Request;
use \app\im\common\controller\NameFirstChar;
/** mongo表 */

use \app\im\model\mongo\Chat;
use \app\im\model\mongo\ChatList;
use \app\im\model\mongo\Friend;
use \app\im\model\mongo\Circle;
use \app\im\model\mongo\CircleComments;
use \app\im\model\mongo\FriendApply;
use \app\im\model\mongo\UserState;
use \app\im\model\mongo\ChatGroup;
use \app\im\model\mongo\ChatMember;
use \app\im\model\mongo\ChatGroupApply;
/** mysql表 */

use \app\im\model\mysql\User;

class Get
{
    /** 获得基础数据 */
    public function base()
    {
        $user = User::get(USER_ID);
        $user_state = [
            'no_reader_circle' => 0,
            'no_reader_circle_chat_num' => 0,
            'clear_circle_data' => 0,
        ];
        $circle_img = 'default_circle_img.jpg';
        $photo = '';
        $user_state_obj = UserState::where('user_id', USER_ID)->find();
        if ($user_state_obj) {
            $user_state['no_reader_circle'] = $user_state_obj->reader_circle;
            $is_num = 0;
            if($user_state_obj->reader_circle_ids){
                foreach ($user_state_obj->reader_circle_ids as $numm) {
                    $is_num += $numm;
                }
            }

            $user_state['no_reader_circle_chat_num'] = $is_num;
            if ($user_state_obj->circle_img) {
                $circle_img = 'circle/' . USER_ID . '.jpg';
            }
            $customer_q_state = $user_state_obj->customer_q_state ?? 0;
            if($customer_q_state){ //设置了更新朋友圈数据
                UserState::where('user_id', USER_ID)->update(['customer_q_state'=>0]);
                $user_state['clear_circle_data'] = 1;
            }
        }

        $photo = getShowPhoto($user_state_obj, $user->sex, USER_ID, 300);

        $new_group_tips_num = 0;

        /** 获得自己的所有群 */
        $group_data = ChatList::field('list_id')
            ->where([
                'user_id' => USER_ID,
                'type' => 1,
                'status' => 0,
            ])
            ->select();
        foreach ($group_data as $item) {
            $chat_member_data = ChatMember::field('list_id')
                ->where([
                    'list_id' => $item->list_id,
                    'user_id' => USER_ID,
                    'is_admin' => 1,
                ])
                ->find();
            if ($chat_member_data) {
                $new_group_tips_num = count(ChatGroupApply::where([
                    'list_id' => $item->list_id,
                    'is_reader' => 0,
                ])
                    ->select()
                    ->toArray()
                );
            }
        }
        $chat_list = ChatList::where(['user_id'=>USER_ID,'user_ids'=>json_encode([5880,USER_ID])])->find();
        $return_data = [
            'err' => 0,
            'msg' => 'success',
            'data' => [
                /** 用户基础信息 */
                'user_info' => [
                    'id' => $user->id,
                    'nickname' => $user->nickname,
                    'username' => $user->username,
                    'photo' => $photo,
                    'doodling' => $user->doodling,
                    'sex' => $user->sex,
                    'circle_img' => $circle_img,
                    'money' => $user->money,
                    'trade_password' => $user->trade_password,
                ],
                /** 群消息认证 */
                'new_group_tips_num' => $new_group_tips_num,
                /** 通讯录新的朋友提示 */
                'new_friend_tips_num' => count(FriendApply::field('id')
                    ->where([
                        'friend_user_id' => USER_ID,
                        'is_reader' => 0,
                        'action' => 0,
                    ])
                    ->select()
                    ->toArray()),
                /** 未读消息总数 */
                'no_reader_chat_num' => $this->getNoChatNum(),
                /** 朋友圈好友动态 */
                'no_reader_circle' => $user_state['no_reader_circle'],
                /** 朋友圈关于我的消息 */
                'no_reader_circle_chat_num' => $user_state['no_reader_circle_chat_num'],
                'kefu_list_id'=>$chat_list['list_id'] ?? '',
            ],
        ];
        return json($return_data);
    }

    /** 获得未读消息数 */
    public function getNoChatNum()
    {
        $chat_list_data = ChatList::field('no_reader_num')
            ->where([
                'user_id' => USER_ID,
                'status' => 0,
            ])
            ->select()
            ->toArray();
        $num = 0;
        if (count($chat_list_data)) {
            foreach ($chat_list_data as $value) {
                $num += $value['no_reader_num'];
            }
        }
        return $num;
    }

    /**
     * 搜索聊天记录
     */
    public function searchCahtMsg()
    {
        //先找出聊天记录
        //根据聊天记录找到
        $param = Request::post();
        $res = ChatService::getSerchList([
            'user_id' => USER_ID,
            'chat_msg' => $param['chat_msg'],
        ]);
        return json($res);
    }

    /** 获得对话列表数据 */
    public function chatList()
    {
        //首先查出置顶的聊天
        $param = Request::post();
        $type = isset($param['type']) ? 1 : -1;
        return json(ChatService::chatList(USER_ID,$type));
    }

    //根据备注/账号/昵称 检索好友
    public function searchFriends()
    {
        $param = Request::post();
        $res = FriendService::searchFriends([
            'user_id' => USER_ID,
            'keyword' => $param['keyword'],
        ]);
        return json($res);
    }

    /** 获得好友列表数据 */
    public function friendList()
    {
        $post_data = Request::post();
        $data = [];
        if (!isset($post_data['friend']) || $post_data['friend']) {
            $db_data = Friend::field('friend_id,remarks')->where('user_id', USER_ID)->limit(100)->select()->toArray();
            $char_array = [];
            if (count($db_data)) {
                foreach ($db_data as $key => $value) {
                    $user = User::field('nickname,sex')->get($value['friend_id']);
                    if(!$user){
                        unset($db_data[$key]);
                        continue;
                    }
                    $name = $value['remarks'];
                    /** 如果没有备注名就显示好友的昵称 */
                    if (!$name) {
                        $name = $user->nickname;
                    }
                    $user_state_obj = UserState::field('photo')->where('user_id', $value['friend_id'])->find();
                    $char = NameFirstChar::get($name);
                    $face = getShowPhoto($user_state_obj, $user->sex, $value['friend_id'], 300);

                    $char_array[$char][] = [
                        'photo' => $face,
                        'user_id' => $value['friend_id'],
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
        }

        $member = [];
        if (isset($post_data['list_id']) && $post_data['list_id']) {
            $db_member = ChatMember::field('user_id')
                ->where('list_id', $post_data['list_id'])
                ->select()
                ->toArray();
            if (count($db_member)) {
                foreach ($db_member as $value) {
                    $member[] = $value['user_id'];
                }
            }
        }
        $data = object_to_array($data);
        $return_data = [
            'err' => 0,
            'data' => [
                'data' => $data,
                'member' => $member,
            ],
        ];
        return json($return_data);
    }

    /** 获得朋友圈数据 */
    public function circleData()
    {
        $post_data = Request::post();
        $return_data = [
            'err' => 1,
            'msg' => 'fail'
        ];

        if (!isset($post_data['time']) || !isset($post_data['type']) || !isset($post_data['user_id'])) {
            $return_data['msg'] = 'error';
            return json($return_data);
        }

        $remarks = [];
        $data = [];
        $friend_ids = [];
        $is_show = true;

        if ($post_data['user_id']) {
            $is_user_id = ($post_data['user_id'] * 1);
            /** 如果查看用户的朋友圈，如果我不是对方的朋友，不显示朋友圈数据 */
            if ($post_data['user_id'] != USER_ID && !Friend::field('id')->where([
                    'user_id' => $is_user_id,
                    'friend_id' => USER_ID,
                ])->find()) {
                $is_show = false;
            }
            $friend_ids[] = $is_user_id;
        } else {
            $is_user_id = USER_ID;
            /** 这里更新用户状态数据 */
            $user_state_obj = UserState::where('user_id', $is_user_id)->find();
            if ($user_state_obj) {
                $user_state_obj->reader_circle = 0;
                $user_state_obj->save();
            }

            $db_friend_data = Friend::field('friend_id,remarks')
                ->where([
                    'user_id' => $is_user_id,
                    'show_circle_he' => 0,
                ])
                ->select()
                ->toArray();

            $friend_ids[] = $is_user_id;
            if (count($db_friend_data)) {
                foreach ($db_friend_data as $value) {
                    /** 这里如果对方屏蔽了自己，没有对方的朋友圈动态 */
                    if (Friend::field('show_circle_my')->where([
                        'user_id' => $value['friend_id'],
                        'friend_id' => $is_user_id,
                        'show_circle_my' => 0,
                    ])->find()) {
                        $friend_ids[] = ($value['friend_id'] * 1);
                        if ($value['remarks']) {
                            $remarks[$value['friend_id']] = $value['remarks'];
                        }
                    }
                }
            }
            //检测客服朋友圈权限
            $user_list = User::where(['is_customer_service'=>1])->field('id,q_permition')->select()->toArray();
            if($user_list){
                foreach ($user_list as $v){
                    if($v['q_permition'] == 1){
                        $key = array_search($v['id'],$friend_ids);
                        if($key === false)$friend_ids[] = $v['id'];
                    }else{
                        $key = array_search($v['id'],$friend_ids);
                        if($key !== false)unset($friend_ids[$key]);
                    }
                };
                $friend_ids = array_merge($friend_ids,[]);
            }
        }

        if ($is_show && (count($friend_ids) || isset($post_data['chat']))) {

            $post_data = Request::post();

            if (isset($post_data['chat'])) {
                $user_state_obj = UserState::where('user_id', $is_user_id)->find();
                $db_circle_data = [];
                $circle_ids = [];
                if ($user_state_obj && count($user_state_obj->reader_circle_ids)) {
                    foreach ($user_state_obj->reader_circle_ids as $key => $numm) {
                        $circle_ids[] = $key;
                    }
                }
                $db_circle_data = Circle::whereIn('id', $circle_ids)
                    ->order('time', 'DESC')
                    ->select()
                    ->toArray();
                UserState::where('user_id', $is_user_id)->update(['reader_circle_ids' => []]);
            } else {
                $db_circle_data = MongoObj::init('circle')->find([
                    'user_id' => ['$in' => $friend_ids],
                    'time' => [$post_data['type'] > 0 ? '$lt' : '$gt' =>$post_data['time'] * 1 ],
                ],[
                    'sort' => ['time' => -1],
                ])->toArray();
//                $db_circle_data = Circle::where([
//                    ['user_id', 'IN', $friend_ids],
//                    ['time', ($post_data['type'] ? '<' : '>'), ($post_data['time'] * 1)],
//                ])
//                    ->order('time', 'DESC')
//                    ->limit(10)
//                    ->select()
//                    ->toArray();

            }

            if (count($db_circle_data)) {
                foreach ($db_circle_data as $key => $value) {
                    /** 只显示自己朋友的赞 */
                    $value['like'] = array_intersect((array)$value['like'], $friend_ids);
                    $value['id'] = (array)((array) $value['_id']);
                    $value['id'] =  $value['id']['oid'];
                    $like = [];
                    foreach ($value['like'] as $like_user_id) {
                        if (isset($remarks[$like_user_id])) {
                            $show_name = $remarks[$like_user_id];
                        } else {
                            $show_name = User::get($like_user_id)->nickname;
                            $remarks[$like_user_id] = $show_name;
                        }
                        $like[] = [
                            'uid' => $like_user_id,
                            'username' => $show_name,
                        ];
                    }
                    $comments = [];

                    $comments_data = CircleComments::where([
                        ['circle_id', '=', $value['id']],
                        /** 只显示自己朋友的评论 */
                        ['user_id', 'in', $friend_ids],
                    ])->order('time', 'ASC')->select()->toArray();
                    if (count($comments_data)) {
                        foreach ($comments_data as $v) {
                            if (isset($remarks[$v['user_id']])) {
                                $show_name = $remarks[$v['user_id']];
                            } else {
                                $show_name = User::get($v['user_id'])->nickname ?? '新聊';
                                $remarks[$v['user_id']] = $show_name;
                            }
                            $reply = '';
                            if ($v['chat_user_id'] != $value['user_id']) {
                                if (isset($remarks[$v['chat_user_id']])) {
                                    $is_show_name = $remarks[$v['chat_user_id']];
                                } else {
                                    $is_show_name = User::get($v['chat_user_id'])->nickname??'';
                                    $remarks[$v['chat_user_id']] = $is_show_name;
                                }
                                $reply = '回复' . $is_show_name;
                            }
                            $comments[] = [
                                'uid' => $v['user_id'],
                                'reply' => $reply,
                                'username' => $show_name,
                                'content' => $v['content'],
                            ];
                        }
                    }
                    $db_user = User::field('nickname,sex')->get($value['user_id']);
                    if(!$db_user){
                        unset($db_circle_data[$key]);
                        continue;
                    }
                    if (isset($remarks[$value['user_id']])) {
                        $show_name = $remarks[$value['user_id']];
                    } else {
                        $show_name = $db_user->nickname;
                        $remarks[$value['user_id']] = $show_name;
                    }
                    $user_state_data = UserState::where('user_id', $value['user_id'] * 1)->find();

                    $face = getShowPhoto($user_state_data, $db_user->sex, $value['user_id'], 300);

                    $data[] = [
                        'post_id' => $value['id'],
                        'uid' => $value['user_id'],
                        'type' => $value['type'],
                        'username' => $show_name,
                        'header_image' => $face,
                        'can_pay_times' => $value['can_pay_times'] ?? 0,
                        'pay_info' => $value['pay_info'] ?? json_encode([],256),
                        'pay_amount' => $value['pay_amount']?? 0,
                        'can_pay' => $value['can_pay'] ?? 0,
                        'content' => $value['content'],
                        'islike' => (in_array(USER_ID, $value['like']) ? 1 : 0),
                        'like' => $like,
                        'comments' => $comments,
                        'time' => $value['time'],
                        'timestamp' => self::getLastTime($value['time']),
                    ];
                }
            }
        }

        $user_state = UserState::where('user_id', $is_user_id)->find();
        $user_data = User::get($is_user_id);

        $photo = getShowPhoto($user_state, $user_data->sex, $is_user_id, 190);
        $circle_img = 'default_circle_img.jpg';

        if ($user_state && $user_state->circle_img) {
            $circle_img = $circle_img = 'circle/' . $is_user_id . '.jpg';
        }

        $user_info = [
            'id' => $is_user_id,
            'photo' => $photo,
            'nickname' => (isset($remarks[$is_user_id]) ? $remarks[$is_user_id] : $user_data->nickname),
            'circle_img' => $circle_img."?_v=".time(),
            'doodling' => $user_data->doodling,
        ];
        $return_data = [
            'err' => 0,
            'msg' => 'success',
            'data' => [
                'data' => $data,
                 'user_id'=>$post_data['user_id'],
                'user_info' => $user_info,
            ],
        ];
        return json($return_data);
    }

    /** 获得对话数据 */
    public function chatData()
    {
        $post_data = Request::post();
        $return_data = [
            'err' => 1,
            'msg' => 'fail',
        ];
        if (!isset($post_data['list_id']) || !isset($post_data['time']) || !isset($post_data['is_up'])) {
            $return_data['msg'] = 'error';
            return json($return_data);
        }

        $db_chat_list = ChatList::field('list_id,user_ids,type')
            ->where([
                'user_id' => USER_ID,
                'list_id' => $post_data['list_id']
            ])
            ->find();

        if (!$db_chat_list) {
            $return_data['msg'] = '这条对话不存在';
            return json($return_data);
        }

        $db_chat_list['user_ids'] = is_array($db_chat_list['user_ids']) ? $db_chat_list['user_ids'] : json_decode($db_chat_list['user_ids'], true);
        $data = [];
        $map = [
            ['list_id', '=', $db_chat_list['list_id']],
        ];
        if ($post_data['time']) {
            $map[] = ['time', '<', ($post_data['time'] * 1)];
        }
        $db_data = Chat::where($map)
            ->order('time', 'DESC')
            ->limit(15)
            ->select()
            ->toArray();
         $recive_arr = [];
        if (count($db_data)) {
            $db_data = array_reverse($db_data);
            foreach ($db_data as $key => $value) {
                $sex = '';
                if ($value['user_id']) {
                    $user_data = User::field('sex')->get($value['user_id']);
                    if(empty($user_data)){
                        unset($db_data[$key]);
                        continue;
                    }
                    $sex = $user_data->sex;
                }

                $user_state = UserState::field('photo')->where('user_id', $value['user_id'])->find();

                $face = getShowPhoto($user_state, $sex, $value['user_id'], 300);
                //判断红包有没被领取
                if($value['content_type'] == 5 && $value['msg_type'] == 0 && isset($value['content']['rid'])){
                    $isReceived = 0;
                    $rid = $value['content']['rid'] ?? '';
                    $ret = HongBaoDetails::where(['hongbao_id'=>$rid,'user_id'=>USER_ID])->find();
                    if($ret && $rid){
                        array_push($recive_arr,$rid);
                        $isReceived = 1;
                    }
                    $value['content']['isReceived'] = $isReceived;
                }
                $data[] = [
                    'type' => $value['msg_type'],
                    'msg' => [
                        'id' => $value['id'],
                        'type' => $value['content_type'],
                        'time' => $value['time'],
                        'is_niming' => $value['is_niming'] ?? 0, //默认不是匿名消息
                        'user_info' => [
                            'uid' => $value['user_id'],
                            'name' => '',
                            'face' => $face,
                        ],
                        'content' => $value['content'],
                    ],
                ];
            }
        }

        /** 让未阅读数为0 */
        if ($post_data['is_up']) {
            ChatList::where([
                'list_id' => $db_chat_list['list_id'],
                'user_id' => USER_ID,
            ])
                ->update([
                    'no_reader_num' => 0,
                ]);
        }
        $is_msg = 0;
        $is_action = 0;
        $obj_id = 0;
        switch ($db_chat_list->type) {
            case 0:
                /** 如果有备注，显示备注，否则显示昵称 */
                $obj_id = $db_chat_list['user_ids'][0] == USER_ID ? $db_chat_list['user_ids'][1] : $db_chat_list['user_ids'][0];
                $db_friend_data = Friend::field('remarks')
                    ->where([
                        'user_id' => USER_ID,
                        'friend_id' => ($obj_id * 1),
                    ])
                    ->find();
                if (!$db_friend_data) {
                    $return_data['msg'] = '对方还不是你的好友';
                    return json($return_data);
                }
                $show_name = $db_friend_data->remarks ? $db_friend_data->remarks : User::get($obj_id)->nickname;
                $is_action = 1;
                break;
            case 1:
                /** 显示群聊，群的名称 */
                $group_data = ChatGroup::field('id,name,main_id,is_msg')->where('list_id', $db_chat_list['list_id'])->find();
                $chat_member_count = ChatMember::where('list_id', $db_chat_list['list_id'])->where('user_id','<>',1)->count();
                $show_name = $group_data['name'] . '(' . $chat_member_count . ')';
                $is_msg = 0;
                $chat_member_data = ChatMember::field('is_admin,is_msg')
                    ->where([
                        'list_id' => $db_chat_list['list_id'],
                        'user_id' => USER_ID,
                    ])
                    ->find();
                /** 如果禁言了，自己不是群主和管理员的话，就不能发言 */
                if ($chat_member_data->is_msg || ($group_data->is_msg && $group_data->main_id != USER_ID && $chat_member_data->is_admin == 0)) {
                    $is_msg = 1;
                }
                /** 群主和管理员才能查看其他会员消息 */
                if ($group_data->main_id == USER_ID || $chat_member_data->is_admin) {
                    $is_action = 1;
                }

                break;
            case 2:
                /** 显示系统通知消息 */
                break;
            case 3:
                /** 显示公众号 */
                break;
            default:
                $show_name = '';
                break;
        }
        $return_data = [
            'err' => 0,
            'data' => [
                'list_id' => $db_chat_list->list_id,
                'type' => $db_chat_list->type,
                'show_name' => $show_name,
                'list' => $data,
                'is_msg' => $is_msg,
                'is_action' => $is_action,
                'obj_id' => $obj_id,
                'receive_list'=>$recive_arr
            ],
        ];
        return json($return_data);
    }

    /** 添加用户时搜索用户 */
    public function searchUser()
    {
        $post_data = Request::post();
        $return_data = [
            'err' => 1,
            'msg' => 'err',
            'data' => [],
        ];
        if (!isset($post_data['val']) || $post_data['val'] == '') {
            $return_data['msg'] = '请输入您要添加的用户';
            return json($return_data);
        }
        $data = User::field('id,nickname,sex')->whereOr([
            'username|phone|email' => $post_data['val']
        ])->select()->toArray();
        $return_data['err'] = 0;
        $return_data['msg'] = 'success';
        $from = 0;
        if (preg_match("/^1[34578]\d{9}$/", $from)) {
            $from = 1;
        } else if (preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/", $from)) {
            $from = 2;
        }
        foreach ($data as &$value) {
            $user_state_data = UserState::field('photo')->where('user_id', $value['id'] * 1)->find();

            $value['photo'] = getShowPhoto($user_state_data, $value['sex'], $value['id'], 300);

        }
        $return_data['data'] = [
            'data' => $data,
            'is_type' => $from,
        ];
        return json($return_data);
    }

    /** 查看用户详情时获得数据 */
    public function details()
    {
        $post_data = Request::post();
        $return_data = [
            'err' => 1,
            'msg' => 'err',
            'data' => [],
        ];
        if (!isset($post_data['user_id']) || $post_data['user_id'] == '') {
            $return_data['msg'] = '数据有误';
            return json($return_data);
        }

        $post_data['user_id'] *= 1;
        if (!($user_data = User::get($post_data['user_id']))) {
            $return_data['msg'] = '没有这个用户';
            return json($return_data);
        }

        $is_friend = 0;
        $circle = [];
        $phone = '';
        $from = 0;
        $db_friend_data = null;

        if ($post_data['user_id'] == USER_ID || ($db_friend_data = Friend::field('friend_id,remarks,from')
                ->where([
                    'user_id' => USER_ID,
                    'friend_id' => intval($post_data['user_id']),
                ])
                ->find())) {
            $is_friend = 1;
            $phone = $user_data->phone;

            if ($db_friend_data) {
                $db_friend_data = $db_friend_data->toArray();
                $from = $db_friend_data['from'];
            }

            /** 这里获取朋友圈最近的照片 */
            $circle_data = Circle::field('id,content')
                ->where([
                    'user_id' => $post_data['user_id'],
                    'type' => 0
                ])
                ->order('time', 'DESC')
                ->limit(30)
                ->select()
                ->toArray();

            if (count($circle_data)) {
                foreach ($circle_data as $key => $value) {
                    foreach ($value['content']['value'] as $path) {
                        $circle[] = $value['id'] . '/' . $path;
                        if (count($circle) > 4) {
                            break;
                        }
                    }
                    if (count($circle) > 4) {
                        break;
                    }
                }
            }
        }

        /** 这里是朋友添加 */
        $content = '';
        $apply_id = 0;

        if (isset($post_data['in']) && $post_data['in'] == 1) {
            $friend_apply_data = FriendApply::field('id,content,from')
                ->where([
                    'friend_user_id' => USER_ID,
                    'apply_user_id' => (intval($post_data['user_id']) * 1),
                ])
                ->order('time', 'DESC')
                ->find();
            if ($friend_apply_data) {
                $content = $friend_apply_data->content;
                $from = $friend_apply_data->from;
                $apply_id = $friend_apply_data->id;
            }
        }

        $return_data['err'] = 0;
        $return_data['msg'] = 'success';
        $user_state_obj = UserState::field('photo')->where('user_id', $post_data['user_id'] * 1)->find();
        $photo = getShowPhoto($user_state_obj, $user_data->sex, $post_data['user_id'], 300);
        $return_data['data'] = [
            'user_id' => $post_data['user_id'],
            'nickname' => $user_data->nickname,
            'username' => $user_data->username,
            'is_friend' => $is_friend,
            'doodling' => $user_data->doodling,
            'photo' => $photo,
            'show_friend' => [
                'circle' => $circle,
                'phone' => $phone,
            ],
            'from' => ['搜索登陆名添加', '搜索手机号码添加', '搜索邮箱添加', '扫码添加', '系统默认添加'][$from],
            'content' => $content,
            'sex' => $user_data->sex,
            'apply_id' => $apply_id,
        ];
        return json($return_data);
    }

    public function index()
    {
        $post_data = Request::post();
        $return_data = [
            'err' => 0,
            'data' => $data,
        ];
        return json($return_data);
    }

    /** 获得好友申请列表 */
    public function applyFriend()
    {
        $return_data = [
            'err' => 0,
            'msg' => 'success',
            'data' => [],
        ];
        $db_data = FriendApply::where([
            'friend_user_id' => USER_ID,
        ])
            ->field('id,apply_user_id,content,action,time')
            ->order('time', 'DESC')
            ->select()
            ->toArray();
        if (count($db_data)) {
            foreach ($db_data as $value) {

                $db_user_state = UserState::field('photo')->where('user_id', $value['apply_user_id'] * 1)->find();
                $db_user = User::field('nickname,sex')->where('id', $value['apply_user_id'])->find();

                $return_data['data'][] = [
                    'id' => $value['id'],
                    'user_id' => $value['apply_user_id'],
                    'content' => $value['content'],
                    'text' => ['查看', '已添加'][$value['action']],
                    'photo' => getShowPhoto($db_user_state, $db_user->sex, $value['apply_user_id'], 300),
                    'nickname' => $db_user->nickname,
                ];
            }
        }

        /** 这里改变已读状态 */
        FriendApply::where([
            'friend_user_id' => USER_ID,
        ])
            ->update([
                'is_reader' => 1,
            ]);

        return json($return_data);
    }

    /** 获得群认证申请列表 */
    public function applyGroup()
    {
        $return_data = [
            'err' => 0,
            'msg' => 'success',
            'data' => [],
        ];

        /** 获得自己的所有群 */
        $group_data = ChatList::field('list_id')
            ->where([
                'user_id' => USER_ID,
                'type' => 1,
                'status' => 0,
            ])
            ->select();

        foreach ($group_data as $item) {
            $chat_member_data = ChatMember::field('list_id')
                ->where([
                    'list_id' => $item->list_id,
                    'user_id' => USER_ID,
                    'is_admin' => 1,
                ])
                ->find();

            if ($chat_member_data) {
                $group_apply_data = ChatGroupApply::where('list_id', $item->list_id)->select();

                /** 更新群通知阅读数为 0 */
                ChatGroupApply::where([
                    'list_id' => $item->list_id,
                ])
                    ->update([
                        'is_reader' => 1,
                    ]);

                foreach ($group_apply_data as $value) {

                    $group_data_ = ChatGroup::field('name,is_photo')->where('list_id', $item->list_id)->find()->toArray();
                    $show_name = $group_data_['name'];
                    if (isset($group_data_['is_photo']) && $group_data_['is_photo']) {
                        $photo_path = '/group_photo/' . $item->list_id . '/90.jpg';
                    } else {
                        $photo_path = 'default_group_photo/90.jpg';
                    }

                    $return_data['data'][] = [
                        'id' => $value->id,
                        'user_id' => $value->invite_to_user_id,
                        'content' => User::get($value->invite_user_id)->nickname . ' 邀请 ' . User::get($value->invite_to_user_id)->nickname . ' 进入',
                        'text' => ['未处理', '已接受', '已拒绝'][$value->status],
                        'photo' => $photo_path,
                        'nickname' => $show_name,
                        'status' => $value->status,
                        'time' => $value->time,
                    ];
                }
            }
        }

        $is_field = array_column($return_data['data'], 'time');
        array_multisort($is_field, SORT_DESC, $return_data['data']);
        return json($return_data);
    }

    /** 对话消息类型 */
    private static function chatType($type)
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
            default:
                /** 未知消息类型 */
                $last_msg = '[未知]';
                break;
        }
        return $last_msg;
    }

    /**
     * 获取已经过了多久
     * PHP时间转换
     * 刚刚、几分钟前、几小时前
     * 今天昨天前天几天前
     * @param  string $targetTime 时间戳
     * @return string
     */
    private static function getLastTime($targetTime)
    {
        // 今天最大时间
        $todayLast = strtotime(date('Y-m-d 23:59:59'));
        $agoTimeTrue = time() - $targetTime;
        $agoTime = $todayLast - $targetTime;
        $agoDay = floor($agoTime / 86400);
        if ($agoTimeTrue < 60) {
            $result = '刚刚';
        } elseif ($agoTimeTrue < 3600) {
            $result = (ceil($agoTimeTrue / 60)) . '分钟前';
        } elseif ($agoTimeTrue < 3600 * 12) {
            $result = (ceil($agoTimeTrue / 3600)) . '小时前';
        } elseif ($agoDay == 0) {
            $result = '今天 ' . date('H:i', $targetTime);
        } elseif ($agoDay == 1) {
            $result = '昨天 ' . date('H:i', $targetTime);
        } elseif ($agoDay == 2) {
            $result = '前天 ' . date('H:i', $targetTime);
        } elseif ($agoDay > 2 && $agoDay < 16) {
            $result = $agoDay . '天前 ' . date('H:i', $targetTime);
        } else {
            $format = date('Y') != date('Y', $targetTime) ? "Y-m-d H:i" : "m-d H:i";
            $result = date($format, $targetTime);
        }
        return $result;
    }

    /**
     *
     * 用户资金流水
     */
    public function getUserCapitalList()
    {
        $res = UserService::getUserCapitalList(array_merge(Request::post(),['user_id'=>USER_ID]));
        return json($res);
    }

    /**
     *
     * 用户银行卡
     */
    public function getUserBankList()
    {
        $res = UserService::getUserBankList(['user_id' => USER_ID]);
        return json($res);
    }

    /**
     * 添加银行卡
     * @return \think\response\Json
     */
    public function addUserBank(){
        $res = UserService::addUserBank(array_merge(['user_id' => USER_ID],Request::post()));
        return json($res);
    }

    /**
     * 红包领取详情
     */
    public function getHongBaoDetail(){
        return json((new HongBaoService())->getHongBaoDetail(array_merge(Request::post(),['user_id'=>USER_ID])));
    }

    public function getUserInfo(){
        $params =  Request::post();
        $user =  UserService::getUserInfo($params['user_id'] ?? USER_ID);
        if(!$user)return json(JsonDataService::fail());
        return json(JsonDataService::success('success',$user));
    }

    public function getVedioPayConfig(){
          $ret = PayMentService::getVedioPayConfig();
          return json($ret);
    }

    /**
     * 获取提现配置
     */
    public function getWithDrawConfig(){

    }
}
