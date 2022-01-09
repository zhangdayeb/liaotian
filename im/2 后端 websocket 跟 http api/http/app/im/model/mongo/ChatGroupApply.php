<?php
namespace app\im\model\mongo;
use think\Model;

class ChatGroupApply extends Model
{
	/** 设置数据库配置 */
	protected $connection = 'mongo';
	/** 自动完成 */
	protected $auto = [];
  protected $insert = [
		'handle_user_id' => 0,
		'status' => 0,
		'handle_time' => 0,
		'is_reader' => 0,
	];
  protected $update = [];
	/** 设置json类型字段 */
	protected $json = [];
	/** 类型转换 */
	protected $type = [
		'invite_user_id' => 'integer',
		'invite_to_user_id' => 'integer',
		'handle_user_id' => 'integer',
		'status' => 'integer',
		'handle_time' => 'integer',
		'time' => 'integer',
	];
	/** 自动时间戳 */
	protected $autoWriteTimestamp = true;
	protected $createTime = 'time';
	protected $updateTime = 'handle_time';

	protected static function init()
	{

	}

}
