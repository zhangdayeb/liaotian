<?php
namespace app\im\model\mongo;
use think\Model;

class UserState extends Model
{
	/** 设置数据库配置 */
	protected $connection = 'mongo';
	/** 自动完成 */
	protected $auto = [];
  protected $insert = [
		'reader_circle' => 0,
		'reader_circle_ids' => [],
		'photo' => 0,
		'circle_img' => 0,
	];
  protected $update = [];
	/** 设置json类型字段 */
	protected $json = [
		'reader_circle_ids'
	];
	/** 类型转换 */
	protected $type = [
		'user_id' => 'integer',
		'reader_circle' => 'integer',
		'photo' => 'integer',
		'circle_img' => 'integer',
	];

	protected static function init()
	{

	}

}
