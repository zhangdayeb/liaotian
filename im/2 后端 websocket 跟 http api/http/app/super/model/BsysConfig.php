<?php
namespace app\super\model;
use \think\Model;

class BsysConfig extends Model
{
    protected $connection = 'mysql';

    /** 自动完成 */
	protected $auto = [];
    protected $insert = [];
    protected $update = [];
  
      protected static function init()
      {
  
      }
  

      /**
       * @param [type] $arr
       * @param [type] $newVal
       * @param integer $opt =1:添加,=0:移除
       * @return void
       */
      public static function udpdateValStr($str,$newVal,$opt=1){
            $ret = $str;
            
            if(strlen($str)<1){
                $ret .=$newVal.',';
            }
            $arr = explode(",", $str);
            if(in_array($newVal,$arr)){  
                if($opt==0){
                    $key = array_search($newVal,$arr);
                    if ($key !== false){
                        array_splice($arr, $key, 1);
                        return  implode(",", $arr);
                    }
                 }
            }else{  
                if($opt==1){
                     array_push($arr,$newVal);
                     return  implode(",", $arr);
                }
            } 
           
            return  $ret;
      }

      public static function udpdateValJson($str,$post){
        $ret = $str;
        $opt = $post['act'];
        unset($post['act']);

        $newVal =  json_encode($post, JSON_FORCE_OBJECT);  
        
        if(strlen($str)<1){
            $ret .= $newVal.'||';
        }

        $arr = explode("||", $str);
        if(in_array($newVal,$arr)){  
            if($opt==0){
                $key = array_search($newVal,$arr);
                if ($key !== false){
                    array_splice($arr, $key, 1);
                    return  implode("||", $arr);
                }
             }
        }else{  
            if($opt==1){
                 array_push($arr,$newVal);
                 return  implode("||", $arr);
            }
        } 
      
        return  $ret;
  }
  

      /**
       * @param [type] $id
       * @param integer $opt =1:添加,=0:移除
       * @return void
       */
      public static function changeUserStatus($id,$opt=1)
      {
          $conf_id = 1;
          $userStatus = self::where('id',$conf_id)->find();
          if( $userStatus)
          {
              $update = ['field_val'=> self::udpdateValStr($userStatus->field_val,$id,$opt)];
             
              $change = self::where('id',$conf_id)->update($update);
              if($change)
              {
                  return ['status'=>true,'msg'=>'成功'];
              }
              else
              {
                  return ['status'=>false,'msg'=> $userStatus->field_val.'系统繁忙，请稍后重试'];
              }
          }
          else
          {
              return ['status'=>false,'msg'=>'抱歉，用户不存在'];
          }
      }

      /**
       * Undocumented function
       *
       * @param [type] $id
       * @param integer $opt =1:添加,=0:移除
       * @return void
       */ //changeUserService($post['act'],$service)
      public static function changeUserService($post)
      {
          $conf_id = 2;
          $userService = self::where('id',$conf_id)->find();
          if( $userService)
          {
             
              $update = ['field_val'=> self::udpdateValJson($userService->field_val, $post)];
             
              $change = self::where('id',$conf_id)->update($update);
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

    /**
     * 获取单个配置
     * @param $key
     * @param $json_key
     * @return String
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
      public static function getVal($key,$json_key){
          $info = self::where(['field_key'=>$key])->find();
          $arr = json_decode($info['field_val'],true);
          if(!$arr) return false;
          return $arr[$json_key];
      }

    /**
     * 获取单个配置
     * @param $key
     * @param $json_key
     * @return array
     */
    public static function getAllVal($key){
        $info = self::where(['field_key'=>$key])->find();
        $arr = json_decode($info['field_val'],true);
        if(!$arr) return false;
        return $arr;
    }

    /**
     * 获取单个配置
     * @param $key
     * @param $json_key
     * @return String
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function setVal($key,$json_key,$json_val){
        $info = self::where(['field_key'=>$key])->find();
        $arr = json_decode($info['field_val'],true);
        if(!$arr) return self::where(['field_key'=>$key])->update(['field_val'=>json_encode([$json_key=>$json_val],256)]);
        $arr[$json_key] = $json_val;
         return self::where(['field_key'=>$key])->update(['field_val'=>json_encode($arr,256)]);
    }
      
}
