<?php
/**
 * Created by IntelliJ IDEA.
 * User: Administrator
 * Date: 2020-06-24
 * Time: 17:52
 */

namespace extend\service;


use app\im\common\controller\NameFirstChar;
use app\im\model\mongo\ChatMember;
use app\im\model\mongo\Friend;
use app\im\model\mongo\UserState;
use app\im\model\mysql\User;
use MongoDB\BSON\Regex;
use think\Db;

class FriendService
{
    //根据备注/账号/昵称 检索好友
    public static function searchFriends(array $params)
    {
        $user_id = $params['user_id'];
        $keyword = trim($params['keyword']);
        //查找出friends_id
//        $friend_list = Friend::where(['user_id'=>$user_id])->field('friend_id','remarks')->select();
        $str = '%' . $keyword . '%';
        $user = new User();
        $friend_list_all = Friend::where(['user_id' => $user_id])
            ->field('friend_id,remarks')
            ->select();
        if (!$friend_list_all) JsonDataService::success();
        $friend_list = Friend::where(['remarks' =>(new Regex('^'.$keyword))])
            ->where(['user_id' => $user_id])
            ->field('friend_id,remarks')
            ->select();
        $firend_ids = array_column($friend_list_all->toArray(), 'friend_id');
        $user_list = $user->where(Db::raw("nickname like '{$str}' or username like '{$str}' or email like '{$str}' or phone like '{$str}'"))
            ->field('id')
            ->where(['id' => $firend_ids])
            ->select();
        if (!$user_list && !$friend_list) return JsonDataService::success();
        $u_ids = array_column($user_list->toArray(), 'id');
        $f_ids = array_column($friend_list->toArray(),'friend_id');
        $all_friend_ids = array_unique(array_merge($u_ids, $f_ids));
        $db_data = Friend::field('friend_id,remarks')->where('user_id', $user_id)
                    ->where(['friend_id'=>$all_friend_ids])
                    ->select()->toArray();
        $char_array = [];
        $data = [];
        if (count($db_data)) {
            foreach ($db_data as $key => $value) {
                $user = User::field('nickname,sex')->get($value['friend_id']);
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

        $member = [];
        if (isset($params['list_id']) && $params['list_id']) {
            $db_member = ChatMember::field('user_id')
                ->where('list_id', $params['list_id'])
                ->select()
                ->toArray();
            if (count($db_member)) {
                foreach ($db_member as $value) {
                    $member[] = $value['user_id'];
                }
            }
        }
        return JsonDataService::success('success',['data'=>$data,'member'=>$member]);

    }
}