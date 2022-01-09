<?php
namespace app\im\model\mysql;
use think\Model;

class User extends Model
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


    public function setPasswordAttr($value)
    {
        return md5($value);
    }

    public static function getUserByUserId($user_id)
    {
        $user = self::where('id',$user_id)->find();
        if($user)
        {
            return $user ;
        }
        return ;
    }

    public static function getUserIdByNickname($nickname)
    {
        $user = self::field('id')->where('nickname','like','%'.$nickname.'%')->select();

        $userids = array();
        if($user)
        {
            foreach( $user as $key => $val){;
                array_push($userids,$val->id);
            }
            return  implode(",",$userids);
        }
        return ;
    }
    public static function changeStatus($id,$act)
    {
        $user = self::where('id',$id)->find();
        if($user)
        {
            if($act == 1)
            {
                $update = ['status'=>1];
            }
            else
            {
                $update = ['status'=>0];
            }
            $change = self::where('id',$id)->update($update);
            if($change)
            {
                return ['status'=>true,'msg'=>'成功'];
            }
            else
            {
                return ['status'=>false,'msg'=>'系统繁忙，请稍后重试'];
            }
        }
        else
        {
            return ['status'=>false,'msg'=>'抱歉，用户不存在'];
        }
    }

    public static function changeUserToCustomerService($id,$act)
    {
        $user = self::where('id',$id)->find();

        if($user)
        {
            if($act == 0)
            {
                self::where('is_customer_service',1)->update( ['is_customer_service'=>0]);
                $update = ['is_customer_service'=>1];
            }
            else
            {
                $update = ['is_customer_service'=>0];
            }
            $change = self::where('id',$id)->update($update);

            if($change)
            {
                return ['status'=>true,'msg'=>'成功'];
            }
            else
            {
                return ['status'=>false,'msg'=> '系统繁忙，请稍后重试'];
            }
        }
        else
        {
            return ['status'=>false,'msg'=>'抱歉，用户不存在'];
        }
    }

}
