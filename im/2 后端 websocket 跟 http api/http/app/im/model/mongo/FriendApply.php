<?php
namespace app\im\model\mongo;
use think\Model;

class FriendApply extends Model
{
	/** 设置数据库配置 */
	protected $connection = 'mongo';
	/** 自动完成 */
	protected $auto = [];
  protected $insert = [
		'is_reader' => 0,
		'action' => 0,
	];
  protected $update = [
		'is_reader' => 0,
	];
	/** 类型转换 */
	protected $type = [
		'apply_user_id' => 'integer',
		'friend_user_id' => 'integer',
		'from' => 'integer',
		'time' => 'integer',
	];
	/** 自动时间戳 */
	protected $autoWriteTimestamp = true;
	protected $createTime = 'time';
	protected $updateTime = 'time';
	/** 设置json类型字段 */
	protected $json = [];

	protected static function init()
	{

	}
}
