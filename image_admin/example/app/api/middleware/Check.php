<?php
/**
 * Created by PhpStorm.
 * User: 38339
 * Date: 2021-05-26
 * Time: 14:41
 */

namespace app\api\middleware;
class Check
{
    public function handle($request,\Closure $next){
        return $next($request);
    }
}