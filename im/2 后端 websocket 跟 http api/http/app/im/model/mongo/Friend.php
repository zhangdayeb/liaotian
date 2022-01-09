<?php
namespace app\im\model\mongo;
use think\Model;

class Friend extends Model
{
	/** 设置数据库配置 */
	protected $connection = 'mongo';
	/** 自动完成 */
	protected $auto = [];
  protected $insert = [
		'remarks' => '',
		'show_circle_he' => 0,
		'show_circle_my' => 0,
	];
  protected $update = [];
	/** 设置json类型字段 */
	protected $json = [];
	/** 类型转换 */
	protected $type = [
		'user_id' => 'integer',
		'friend_id' => 'integer',
		'show_circle_he' => 'integer',
		'show_circle_my' => 'integer',
		'from' => 'integer',
		'time' => 'integer',
	];
	/** 自动时间戳 */
	protected $autoWriteTimestamp = true;
	protected $createTime = 'time';
	/** 关闭自动写入update_time字段 */
  protected $updateTime = false;

	protected static function init()
	{

	}

}
