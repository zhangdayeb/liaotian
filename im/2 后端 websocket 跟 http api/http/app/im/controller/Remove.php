<?php
namespace app\im\controller;

use app\im\model\mysql\CapitalLog;
use \Request;
use \app\common\controller\SendData;
/** mongo表 */
use \app\im\model\mongo\Chat;
use \app\im\model\mongo\ChatList;
use \app\im\model\mongo\Friend;
use \app\im\model\mongo\ChatMember;
use \app\im\model\mongo\ChatGroup;
use \app\im\model\mongo\UserState;
use \app\im\model\mongo\Circle;
use \app\im\model\mongo\CircleComments;
use \app\im\model\mongo\FriendApply;
use \app\im\model\mongo\HongBao;
use \app\im\model\mongo\HongBaoDetails;
use \app\im\model\mongo\ChatGroupApply;

class Remove
{
	/** 删除所有数据 */
	public function deleteAllData()
	{
		(new Chat)::where('id','neq','1')->delete();
		(new ChatList)::where('id','neq','1')->delete();
		(new Friend)::where('id','neq','1')->delete();
		(new ChatMember)::where('id','neq','1')->delete();
		(new ChatGroup)::where('id','neq','1')->delete();
		(new UserState)::where('id','neq','1')->delete();
		(new Circle)::where('id','neq','1')->delete();
		(new CircleComments)::where('id','neq','1')->delete();
		(new FriendApply)::where('id','neq','1')->delete();
		(new ChatGroupApply)::where('id','neq','1')->delete();
		(new HongBaoDetails())::where('id','neq','1')->delete();
		(new HongBao())::where('id','neq','1')->delete();
		(new CapitalLog())::where('id','neq','1')->delete();
		self::deleteDir(__DIR__ . '/../../../public/static/chat');
		self::deleteDir(__DIR__ . '/../../../public/static/circle');
		self::deleteDir(__DIR__ . '/../../../public/static/photo/user');
		self::deleteDir(__DIR__ . '/../../../public/static/photo/circle');
		self::deleteDir(__DIR__ . '/../../../public/static/photo/group_photo');
		echo '删除所有数据成功';
	}

	private static function deleteDir($dir)
	{
		if (!$handle = @opendir($dir)) {
			return false;
		}
		while (false !== ($file = readdir($handle))) {
			if ($file !== "." && $file !== "..") { //排除当前目录与父级目录
					$file = $dir . '/' . $file;
					if (is_dir($file)) {
							self::deleteDir($file);
					} else {
							@unlink($file);
					}
			}
		}
		@rmdir($dir);
		return true;
	}

	/** 删除好友 */
	public function friend()
	{
		$post_data = Request::post();
		$return_data = [
			'err' => 1,
			'msg' => 'fail'
		];
		if(!isset($post_data['user_id'])){
			$return_data['msg'] = 'data error';
			return json($return_data);
		}

		$post_data['user_id'] *= 1;

		if(!Friend::field('id')->where([
			'user_id' => USER_ID,
			'friend_id' => $post_data['user_id'],
		])
		->find()){
			$return_data['msg'] = '对方还不是你的好友,操作失败';
			return json($return_data);
		}

		$chat_user_ids = [ USER_ID,$post_data['user_id'] ];
		sort($chat_user_ids);
		$chat_user_ids = json_encode($chat_user_ids);

		$list_data = ChatList::field('list_id')
		->where([
			'user_id' => USER_ID,
			'user_ids' => $chat_user_ids,
			'type' => 0,
		])
		->find();

		/** 从我的好友里删除掉对方 */
		Friend::where([
			'user_id' => USER_ID,
			'friend_id' => $post_data['user_id'],
		])
		->delete();

		if($list_data){

			$list_id = $list_data->list_id;

			/** 从我的会话列表里删除 */
			ChatList::where([
				'user_id' => USER_ID,
				'list_id' => $list_id,
			])
			->delete();

			/** 如果互相把对方删除了，就清空其他数据 */
			if(!ChatList::field('id')
				->where([
				'list_id' => $list_id,
			])
			->find()){
				/** 删除对话数据 */
				Chat::where('list_id',$list_id)->delete();
				/** 删除成员数据 */
				ChatMember::where('list_id',$list_id)->delete();
				/** 删除红包数据 */
				HongBao::where('list_id',$list_id)->delete();
				/** 删除红包领取详情数据 */
				HongBaoDetails::where('list_id',$list_id)->delete();
				/** 删除对话静态文件 */
				self::deleteDir(__DIR__ . '/../../../public/static/chat/' . $list_id);
			}
		}

		$return_data['err'] = 0;
		$return_data['msg'] = 'success';
		$return_data['data'] = $list_id;
		return json($return_data);
	}

	/** 删除群申请记录 */
	public function deleteGroupApply()
	{
		(new ChatGroupApply)::where('id','neq','1')->delete();
		echo '删除群申请记录成功';
	}

}
