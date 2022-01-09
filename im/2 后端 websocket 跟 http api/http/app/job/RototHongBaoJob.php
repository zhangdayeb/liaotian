<?php
/**
 * Created by IntelliJ IDEA.
 * User: Administrator
 * Date: 2020/9/6 0006
 * Time: 12:27
 */

namespace app\job;
use extend\service\HongBaoService;
use extend\service\JsonDataService;
use extend\service\MsgService;
use think\queue\Job;

class RototHongBaoJob
{
    /**
     * fire方法是消息队列默认调用的方法
     * @param Job            $job      当前的任务对象
     * @param array|mixed    $params     发布任务时自定义的数据
     */
    public function fire(Job $job,$params)
    {
        $job->delete();
        $this->doJob($params,$job);
    }

    /**
     * 根据消息中的数据进行实际的业务处理...
     */
    private function doJob($params,Job $job)
    {
        $ret = HongBaoService::robotAutoRedPackage($params);
        echo json_encode($ret,256);
    }
}