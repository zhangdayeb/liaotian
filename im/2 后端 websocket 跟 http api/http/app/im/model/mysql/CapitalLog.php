<?php
namespace app\im\model\mysql;
use think\Model;

class CapitalLog extends Model
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

	protected static function getCapitalTypeAttr($type){
	    switch ($type){
            case 0:
                return '红包';
            case 1:
                return '转账';
            case 2:
                return '充值';
            case 3:
                return '朋友圈动态';
            case 4:
                return '聊天';
            case 5:
                return '提现';
            case 6:
                return '手动操作';
            case 7:
                return '红包中奖';
            case 8:
                return '红包扣除';
            case 9:
                return '红包抢包';
            case 10:
                return '发出红包';
            case 11:
                return '红包退回';
        }
    }

}
