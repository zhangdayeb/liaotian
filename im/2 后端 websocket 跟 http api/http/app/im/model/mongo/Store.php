<?php
namespace app\im\model\mongo;
use think\Model;

class Store extends Model
{
	/** 设置数据库配置 */
	protected $connection = 'mongo';
	/** 自动完成 */
	protected $auto = [];
  protected $insert = [
  ];
  protected $update = [];
	/** 设置json类型字段 */
	protected $json = [];
	/** 类型转换 */
	protected $type = [
		'user_id' => 'integer',
		'type' => 'integer',
		'size' => 'integer',
		'time' => 'integer',
	];
	/** 自动时间戳 */
	protected $autoWriteTimestamp = true;
	protected $createTime = 'time';
	/** 关闭自动写入update_time字段 */
  protected $updateTime = false;

	protected static function init()
	{

	}

    /**
     * 获取文件大小
     */
	public static function getSize($type,$content){
        $size = 0;
	    switch (true){
            case $type == 1: //文字
                $size = sstrlen($content);
                break;
            case $type == 2: //图片
            case $type == 3: //语音
            case $type == 4: //视频
                $size = remote_filesize($content);
                break;
        }
        return $size;
    }

    public function getTimeAttr($val){
	    return date('Y-m-d',$val);
    }

}
