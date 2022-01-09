<?php
/**
 * Created by IntelliJ IDEA.
 * User: Administrator
 * Date: 2020-07-14
 * Time: 16:07
 */

namespace extend\service;


use app\im\model\mongo\ChatGroup;
use app\im\model\mongo\UserState;
use think\Image;

class UserStateService
{
    public static function setState($user_id, $field = 'photo')
    {
        $obj = UserState::where('user_id', ($user_id * 1))->find();
        if (!$obj) {
            $obj = UserState::create(['user_id' => $user_id]);
        }
        $obj->$field = 1;
        $ret = $obj->save();
        if (!$ret) return JsonDataService::fail('设置失败!');
        return JsonDataService::success('设置成功!');
    }

    /**
     * 设置用户头像以及状态
     */
    public static function setRandPhoto(array $params)
    {
        $mt_rand = mt_rand(0, 20);
        //头像地址
        if (!is_dir(PHOTO_USER_PATH)) mkdir(PHOTO_USER_PATH);
        $path = PHOTO_USER_PATH . $params['user_id'];
        $default_path = PHOTO_PATH . 'default_reg_photo/' . $mt_rand . '.jpg'; //默认的随机头像
        if (!is_dir($path)) mkdir($path);
        $image = Image::open($default_path);
        $image->thumb(190, 190)->save($path . '/190.jpg');
        $image->thumb(300, 300)->save($path . '/300.jpg');
        $image->thumb(90, 90)->save($path . '/90.jpg');
        $image->thumb(70, 70)->save($path . '/70.jpg');
        $image->thumb(50, 50)->save($path . '/50.jpg');
        return self::setState($params['user_id']);
    }

    /**
     * 合成群头像
     */
    public static function setGroupPhoto(array $params, $is_qunzhu_photo = 1)
    {
        $chat_group = ChatGroup::field('is_photo')->where('list_id', $params['list_id'])->find();
        if (!$chat_group) {
            return JsonDataService::fail();
        }
        $dir = PHOTO_GROUP_PATH . $params['list_id'];
        if (!is_dir($dir)) mkdir($dir);
        $save_path = $dir . '/90.jpg';
        $img_list = [];
        $params['user_ids'] = array_slice($params['user_ids'], 0, 9);
        foreach ($params['user_ids'] as $v) {
            $user_info = UserService::getUserInfo($v);
            if (!$user_info) continue;
            $face = $user_info['face'];
            $face = PHOTO_PATH . $face;
            array_push($img_list, $face);
        }
        if (!$is_qunzhu_photo) {
            $res = getGroupAvatar($img_list, true, $save_path);
        } else {
            //获取群主头像main_id
            $user_info = UserService::getUserInfo($params['main_id']);
            $path = PHOTO_PATH . $user_info['face'];
            $image = Image::open($path);
            $image->thumb(90, 90)->save($save_path);
            $image->thumb(300, 300)->save($save_path);
        }
        $chat_group->is_photo = 1;
        $chat_group->save();
        return JsonDataService::success();
    }

}