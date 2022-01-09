<?php
namespace app\im\model\mongo;
use think\Model;

class VoiceRoom extends Model
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
        'roomid' => 'integer',
        'user_id' => 'integer',
        'time' => 'integer',
        'member_count' => 'integer',
    ];
    /** 自动时间戳 */
    protected $autoWriteTimestamp = true;
    protected $createTime = 'time';
    /** 关闭自动写入update_time字段 */
    protected $updateTime = false;

    protected static function init()
    {

    }



    public function getTimeAttr($val){
        return date('Y-m-d',$val);
    }

    /**
     * 减员
     */
    public static function setDecMenBerCount($list_id,$user_id){
        $room = self::where(['list_id'=>$list_id])->find();
        if(empty($room)) return 0;
        $user_ids = $room['user_ids'];
       $key =  array_search($user_id,$user_ids);
       if($key !== false){
           unset($user_ids[$key]);
           sort($user_ids);
           self::where(['list_id'=>$list_id])->update(['user_ids'=>$user_ids,'member_count'=>count($user_ids)]);
       }
        return count($user_ids);
    }

    /**
     * 加入房间
     */
    public static function setIncMenBerCount($list_id,$user_id){
        $room = self::where(['list_id'=>$list_id])->find();
        if(empty($room)) return 0;
        $user_ids = $room['user_ids'];
        $key =  array_search($user_id,$user_ids);
        if($key === false){
           array_push($user_ids,$user_id);
            sort($user_ids);
            self::where(['list_id'=>$list_id])->update(['user_ids'=>$user_ids,'member_count'=>count($user_ids)]);
        }
        return count($user_ids);
    }

}
