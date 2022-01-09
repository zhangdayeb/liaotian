<?php
namespace app\im\model\mongo;
use think\Model;

class Chat extends Model
{
	/** 设置数据库配置 */
	protected $connection = 'mongo';
	/** 自动完成 */
	protected $auto = [];
  protected $insert = [];
  protected $update = [];
	/** 设置json类型字段 */
	protected $json = [
		'content',
	];

    /** 自动时间戳 */
    protected $autoWriteTimestamp = true;
    protected $createTime = 'time';
    /** 关闭自动写入update_time字段 */
    protected $updateTime = false;

	/** 类型转换 */
	protected $type = [
		'user_id' => 'integer',
		'content_type' => 'integer',
		'msg_type' => 'integer',
		'time' => 'integer',
	];

	protected static function init()
	{

	}
	public static function createChatMsg($data){
        $is_niming = $data['is_niming'] ?? 0;
	     return self::create($data);
    }

    /**
     *
     * @param $type
     * @param $msg
     */
    public static function createSysMsg(array  $data){
        return self::createChatMsg([
            'list_id' => $data['list_id'],
            'user_id' => $data['user_id'],
            'content_type' => $data['content_type'],
            'msg_type' => 1,
            'content' => isset($data['text']) ? ['text'=>$data['text']] : $data['content'],
        ]);
    }

    /**
     *
     * @param $type
     * @param $msg
     */
    public static function createUserMsg(array  $data){
        return self::createChatMsg([
            'list_id' => $data['list_id'],
            'user_id' => $data['user_id'],
            'content_type' => $data['content_type'],
            'msg_type' => 0,
            'content' => isset($data['text']) ? ['text'=>$data['text']] : $data['content'],
        ]);
    }

}
