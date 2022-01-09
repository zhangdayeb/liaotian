<?php
/**
 * Created by IntelliJ IDEA.
 * User: Administrator
 * Date: 2020-08-03
 * Time: 3:18
 */

namespace app\job;


use app\im\model\mysql\VendorSetting;
use extend\service\JsonDataService;
use extend\service\MsgService;
use extend\service\UserService;
use extend\service\VendorService;
use think\queue\Job;

class UserJob
{
    /**
     * fire方法是消息队列默认调用的方法
     * @param Job            $job      当前的任务对象
     * @param array|mixed    $params     发布任务时自定义的数据
     */
    public function fire(Job $job,$params)
    {
         $this->doJob($params,$job);
    }

    /**
     * 根据消息中的数据进行实际的业务处理...
     */
    private function doJob($params,Job $job)
    {
        VendorService::noticeMember($params);
        $job->delete();
    }
}