<?php
namespace common\model;

use \think\Model;

class System extends Model
{
	/** 自动完成 */
	protected $auto = [];
    protected $insert = [];
    protected $update = [];
    /** 设置json类型字段 */
    protected $json = ['value'];
	// 设置JSON数据返回数组
    protected $jsonAssoc = true;

    protected static function init()
    {
        
    }

}
