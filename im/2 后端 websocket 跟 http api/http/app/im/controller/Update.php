<?php
namespace app\im\controller;

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

class Update
{
	/** 更新数据表字段 */
	public function index()
	{
		(new ChatList)::where('id','neq','1')->update([ 'top_time'=> 0 ]);
	}

	/** 修复群主在成员表不是管理员 */
	public function mainIdAdmin()
	{
		$chat_group = ChatGroup::field('list_id,main_id')->select();
		foreach ($chat_group as $key => $value) {
			ChatMember::where([
				'list_id' => $value->list_id,
				'user_id' => $value->main_id
			])
			->update([
				'is_admin' => 1,
			]);
		}
		echo '修复所有群聊群主在成员表不是管理员成功';
	}

	/** 修复聊天数据为null的数据（修复因为<符号导致thinkphp过滤后为NUll的问题） */
	public function deleteChatNull()
	{
		(new Chat)::where('content','eq','NULL')->delete();
		echo '删除聊天数据为NULL的数据成功';
	}
}
