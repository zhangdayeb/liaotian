<?php
/**
 * Created by IntelliJ IDEA.
 * User: Administrator
 * Date: 2020-07-15
 * Time: 22:54
 */

namespace app\job;
use extend\service\JsonDataService;
use extend\service\MsgService;
use think\queue\Job;


class PushJob
{
    /**
     * fire方法是消息队列默认调用的方法
     * @param Job            $job      当前的任务对象
     * @param array|mixed    $params     发布任务时自定义的数据
     */
    public function fire(Job $job,$params)
    {
        $isJobDone = $this->doJob($params);
        $job->delete();
    }

    /**
     * 根据消息中的数据进行实际的业务处理...
     */
    private function doJob($params)
    {
        MsgService::pushMsg($params['user_ids'],$params['content_type'],$params['username'],$params['content']);
    }
}