<?php
/**
 * Created by PhpStorm.
 * User: 38339
 * Date: 2021-05-26
 * Time: 15:02
 */

namespace app\common\business\mysql;


use app\common\model\mysql\YwCustomer;
use think\facade\Cache;
use think\facade\Log;

class Common
{
    /*
     * 验证传入的token
     */
    public static function checkToken($token){
        if(empty($token)){
            jsonFail('token不能为空',config('code.token_no_null'));
        }
        if(Cache::has($token)){
            Log::write('cache里面存在这个');
            $load = Cache::get($token);
            if(!empty($load)){
                return $load;
            }
        }
        $load = YwCustomer::getOneByToken($token);
        if(empty($load)){
            jsonFail('用户不存在',config('code.user_no_found'));
        }
        Cache::set($token,$load,3600);
        return $load;
    }
}