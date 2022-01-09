<?php
namespace app\im\model\mysql;
use think\Model;

class Article extends Model
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

	public function getPositionAttr($val){
	    return '帮助文档';
    }

    public function getCreateTimeAttr($attr){
	    return date('Y-m-d H:i:s',$attr);
    }
    public function getUpdateTimeAttr($attr){
        return date('Y-m-d H:i:s',$attr);
    }

    public function getContentAttr($attr){
        return htmlspecialchars_decode($attr);
    }

    public function setContentAttr($attr){
        return htmlspecialchars($attr);
    }
}
