<?php
namespace app\im\model\mysql;
use think\Model;

class LoginLog extends Model
{
	/** 设置数据库配置 */
	protected $connection = 'mysql';
	/** 自动完成 */
	protected $auto = [];
  protected $insert = [];
  protected $update = [];
	/** 自动时间戳 */
	protected $autoWriteTimestamp = true;
	/** 关闭自动写入update_time字段 */
  protected $updateTime = false;

	protected static function init()
	{

	}

}
