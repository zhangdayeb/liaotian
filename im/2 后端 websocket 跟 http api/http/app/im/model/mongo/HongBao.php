<?php
namespace app\im\model\mongo;
use think\Model;

class HongBao extends Model
{
	/** 设置数据库配置 */
	protected $connection = 'mongo';
	/** 自动完成 */
  protected $insert = [
      'is_back' => 0,
  ];
  protected $update = [];
	/** 设置json类型字段 */
	protected $json = [];
	/** 类型转换 */
	protected $type = [
        'is_back' => 'integer',
    ];

	protected static function init()
	{

	}
	//生成红包
	public static function createHongbao(array $params){

    }
    //将红包保存到数据库
    //使用队列 防止抢包并发
}
