<?php
namespace app\im\controller;

use \Request;
/** mongo表 */
use \app\im\model\mongo\Friend as dbFriend;
use \app\im\model\mongo\FriendApply;

class Friend
{
  /** 设置朋友备注 */
  public function setRemarks()
  {
    $post_data = Request::post();
    $return_data = [
      'err' => 1,
      'msg' => 'fail',
    ];
    if(!isset($post_data['content']) || !isset($post_data['user_id'])){
      $return_data['msg'] = 'error';
      return json($return_data);
    }
    $chat_obj = dbFriend::where([
      'user_id' => USER_ID,
      'friend_id' => ($post_data['user_id'] * 1),
    ])
    ->find();
    if(!$chat_obj){
      $return_data['msg'] = '对方不是好友';
      return json($return_data);
    }
    $chat_obj->remarks = $post_data['content'];
    $chat_obj->save();
    $return_data['err'] = 0;
    $return_data['msg'] = '设置成功';
    return json($return_data);
  }

  public function getRemarks()
  {
    $post_data = Request::post();
    $return_data = [
      'err' => 1,
      'msg' => 'fail',
      'data' => [],
    ];
    if(!isset($post_data['user_id'])){
      $return_data['msg'] = 'error';
      return json($return_data);
    }
    $chat_obj = dbFriend::where([
      'user_id' => USER_ID,
      'friend_id' => ($post_data['user_id'] * 1),
    ])
    ->find();
    if(!$chat_obj){
      $return_data['msg'] = '对方不是好友';
      return json($return_data);
    }
    $return_data['err'] = 0;
    $return_data['msg'] = 'success';
    $return_data['data']['remarks'] = $chat_obj->remarks;
    return json($return_data);
  }

  public function details()
  {
    $post_data = Request::post();
    $return_data = [
      'err' => 1,
      'msg' => 'fail',
    ];
    if(!isset($post_data['user_id'])){
      $return_data['msg'] = 'error';
      return json($return_data);
    }
    $is_remove = $post_data['user_id'] == 7 ? 0 : 1;
    $return_data['err'] = 0;
    $return_data['msg'] = 'success';
    $return_data['data'] = [
      'remove' => $is_remove,
    ];
    return json($return_data);
  }

  public function removeApply()
  {
    $post_data = Request::post();
    $return_data = [
      'err' => 1,
      'msg' => 'fail',
    ];
    if(!isset($post_data['id'])){
      $return_data['msg'] = 'error';
      return json($return_data);
    }
    if(FriendApply::destroy($post_data['id'])){
      $return_data['err'] = 0;
      $return_data['msg'] = 'success';
    }
    return json($return_data);
  }
}
