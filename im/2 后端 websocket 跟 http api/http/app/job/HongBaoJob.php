<?php
/**
 * Created by IntelliJ IDEA.
 * User: Administrator
 * Date: 2020/9/4 0004
 * Time: 11:29
 */

namespace app\job;
use extend\service\HongBaoService;
use extend\service\JsonDataService;
use extend\service\MsgService;
use think\facade\Log;
use think\queue\Job;


class HongBaoJob
{
    /**
     * fire方法是消息队列默认调用的方法
     * @param Job            $job      当前的任务对象
     * @param array|mixed    $params     发布任务时自定义的数据
     */
    public function fire(Job $job,$params)
    {
        $job->delete();
       Log::debug('处理队列');
        $this->doJob($params);

    }

    /**
     * 根据消息中的数据进行实际的业务处理...
     */
    private function doJob($params)
    {
        $ret = HongBaoService::afterHongbao($params);
    }
}