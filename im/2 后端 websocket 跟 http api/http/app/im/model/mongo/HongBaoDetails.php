<?php
namespace app\im\model\mongo;
use think\Model;

class HongBaoDetails extends Model
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
	protected $type = [];

	protected static function init()
	{

	}

	public function getTimeAttr($val){
	    return date('Y-m-d H:i:s',$val);
    }

}
