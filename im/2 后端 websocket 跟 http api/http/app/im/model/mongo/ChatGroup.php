<?php
namespace app\im\model\mongo;
use think\Model;

class ChatGroup extends Model
{
	/** 设置数据库配置 */
	protected $connection = 'mongo';
	/** 自动完成 */
	protected $auto = [];
  protected $insert = [
		'notice' => '没有群公告',
		'is_msg' => 0,
		'is_photo' => 0,
		'edit_photo' => 0,
		'can_get_bigred' => 0,
		'can_shangmai' => 1,
	];
  protected $update = [];
	/** 设置json类型字段 */
	protected $json = [];
	/** 类型转换 */
	protected $type = [
		'main_id' => 'integer',
		'is_msg' => 'integer',
		'is_photo' => 'integer',
		'edit_photo' => 'integer',
		'can_get_bigred' => 'integer',
		'can_shangmai' => 'integer',
	];

	protected static function init()
	{

	}

}
