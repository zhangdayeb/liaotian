<?php
namespace app\im\model\mongo;
use think\Model;

class ChatList extends Model
{
	/** 设置数据库配置 */
	protected $connection = 'mongo';
	/** 自动完成 */
	protected $auto = ['last_chat_time'];
  protected $insert = [
		'top' => 0,
		'top_time' => 0,
		'no_reader_num' => 1,
		'ignore' => 0,
		'status' => 0,
      'is_disturb'=>0,
	];
  protected $update = [];
	/** 类型转换 */
	protected $type = [
		'no_reader_num' => 'integer',
		'user_id' => 'integer',
		'type' => 'integer',
		'top' => 'integer',
		'top_time' => 'integer',
		'ignore' => 'integer',
		'status' => 'integer',
        'is_disturb'=>'integer',
        'last_chat_time'=>'integer',
	];
	/** 设置json类型字段 */
	protected $json = [
	];

	public function setLastChatTimeAttr(){
        return time();
    }
	protected static function init()
	{

	}

//	public function getUserIdsAttr($user_ids){
//	    if(is_array($user_ids))return json_encode($user_ids);
//	    return $user_ids;
//    }
	public function setUserIdsAttr($user_ids){
	    if(is_array($user_ids)) return $user_ids;
	    $user_ids = json_decode($user_ids,true);
	    if(empty($user_ids)) return $user_ids;
        foreach ($user_ids as &$v){
            $v = intval($v);
        }
        return json_encode(array_filter($user_ids,'intval'));
    }

}
