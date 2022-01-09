<?php
namespace app\im\model\mysql;
use think\Model;

class UserLog extends Model
{
	/** 设置数据库配置 */
	protected $connection = 'mysql';
	/** 自动完成 */
	protected $auto = [];
  protected $insert = [];
  protected $update = [];

    /** 自动时间戳 */
    protected $autoWriteTimestamp = true;

	protected static function init()
	{

	}


}
