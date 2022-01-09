<?php
/**
 * Created by IntelliJ IDEA.
 * User: Administrator
 * Date: 2020/9/7 0007
 * Time: 11:15
 */

namespace app\job;
use extend\service\HongBaoService;
use extend\service\JsonDataService;
use extend\service\VendorService;
use think\queue\Job;

class GroupJob
{
    /**
     * fire方法是消息队列默认调用的方法
     * @param Job            $job      当前的任务对象
     * @param array|mixed    $params     发布任务时自定义的数据
     */
    public function fire(Job $job,$params)
    {
        $this->doJob($params,$job);
        $job->delete();
    }

    /**
     * 根据消息中的数据进行实际的业务处理...
     */
    private function doJob($params,Job $job)
    {
        $ret = VendorService::robotAutoReply($params);
        $job->delete();
    }
}