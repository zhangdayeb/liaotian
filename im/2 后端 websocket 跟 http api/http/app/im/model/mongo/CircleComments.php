<?php
namespace app\im\model\mongo;
use think\Model;

class CircleComments extends Model
{
	/** 设置数据库配置 */
	protected $connection = 'mongo';
	/** 自动完成 */
	protected $auto = [];
  protected $insert = [];
  protected $update = [];
	/** 设置json类型字段 */
	protected $json = [];
	/** 类型转换 */
	protected $type = [
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
