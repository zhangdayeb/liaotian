<?php
namespace app\im\model\mongo;
use think\Model;

class Circle extends Model
{
	/** 设置数据库配置 */
	protected $connection = 'mongo';
	/** 自动完成 */
	protected $auto = [];
  protected $insert = [
		'like' => [],
	];
  protected $update = [];
	/** 设置json类型字段 */
	protected $json = [
		'content',
		'like',
	];
	/** 类型转换 */
	protected $type = [
		'user_id' => 'integer',
		'type' => 'integer',
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
