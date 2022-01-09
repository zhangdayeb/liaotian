<?php
namespace app\im\model\mongo;
use think\Model;

class ChatMember extends Model
{
	/** 设置数据库配置 */
	protected $connection = 'mongo';
	/** 自动完成 */
	protected $auto = [];
  protected $insert = [
		'nickname' => '',
		'is_admin' => '0',
		'is_msg' => '0',
		'is_niming' => '0', //匿名
		'miaoqiang' => '0',
		'qiang_time' => '0',
		'voice_room_state' => 0,
	];
  protected $update = [];
	/** 类型转换 */
	protected $type = [
		'user_id' => 'integer',
		'is_admin' => 'integer',
		'is_msg' => 'integer',
		'time' => 'integer',
		'is_niming' => 'integer',
		'miaoqiang' => 'integer',
		'qiang_time' => 'integer',
		'voice_room_state' => 'integer',
	];
	/** 设置json类型字段 */
	protected $json = [];
	/** 自动时间戳 */
	protected $autoWriteTimestamp = true;
	protected $createTime = 'time';
	/** 关闭自动写入update_time字段 */
  protected $updateTime = false;

	protected static function init()
	{

	}

}
