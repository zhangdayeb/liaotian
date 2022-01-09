<?php
namespace app\im\controller;

use \Request;
/** mongo表 */
use \app\im\model\mongo\ChatList;

class Chat
{
  /** 删除对话 */
  public function deleteChat()
  {
    $post_data = Request::post();
    $return_data = [
      'err' => 1,
      'msg' => 'fail',
    ];
    if(!isset($post_data['list_id'])){
      $return_data['msg'] = 'error';
      return json($return_data);
    }
    $chat_obj = ChatList::where([
      'list_id' => $post_data['list_id'],
      'user_id' => USER_ID,
    ])
    ->find();
    if(!$chat_obj){
      $return_data['msg'] = '没有这条对话数据';
        return json($return_data);
    }
    $chat_obj->status = 1;
    $chat_obj->save();
    $return_data['err'] = 0;
    $return_data['msg'] = 'success';
    return json($return_data);
  }

  /** 标为未/已读 */
  public function sign()
  {
    $post_data = Request::post();
    $return_data = [
      'err' => 1,
      'msg' => 'fail',
    ];
    if(!isset($post_data['no_reader_num']) || !isset($post_data['list_id'])){
      $return_data['msg'] = 'error';
      return json($return_data);
    }
    $num = 1;
    if($post_data['no_reader_num']){
      $num = 0;
    }
		if(ChatList::where([
			'list_id' => $post_data['list_id'],
			'user_id' => USER_ID,
		])
		->update([
			'no_reader_num' => $num,
		])){
      $return_data['err'] = 0;
      $return_data['msg'] = 'success';
    }
    return json($return_data);
  }
  
}
