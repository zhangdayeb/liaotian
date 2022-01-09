<?php
namespace extend\service;

use DictionaryAlertMsg;
use IGeTui;
use IGtAPNPayload;
use IGtAppMessage;
use IGtListMessage;
use IGtSingleMessage;
use IGtTarget;
use IGtTransmissionTemplate;

require_once VENDOR_PATH . '/getuilaboratory/getui-pushapi-php-client/' . 'IGt.Push.php';

class PushService
{
    public $gp_appid;       // 应用 ID（AppID）
    public $gp_appkey;      // 应用 key（AppKey）
    public $gp_token;       // 应用令牌（MasterSecret）
    public $gp_host;        // 个推服务器

    private $gpush;         // 个推
    public $result;         // 推送结果

    # 构造函数
    public function __construct($appid,$appkey,$token)
    {
        // 属性初始化
        $this->gp_appid = $appid;
        $this->gp_appkey = $appkey;
        $this->gp_token = $token;
        $this->gp_host = "http://sdk.open.api.igexin.com/apiex.htm";
        // 个推初始化
        $this->gpush = new IGeTui($this->gp_host,$appkey,$token);
        $this->result = [];
    }


    # 单个推送（支持安卓、苹果）
    public function PushMsgToApp($title,$content,$payload = [])
    {

        // 标准推送数据格式
        $Message1 = [
            "title"=> $title,
            "content"=> $content,
            "payload"=>$payload
        ];
        // 推送模板
        $tpl = $this->AwesomeTemplate($Message1);
        $this->result["arr"]["push_param"] = $Message1;
        // 推送消息
        $msg = new IGtAppMessage();
        $msg->set_isOffline(true);                            // 是否离线
        $msg->set_offlineExpireTime(12*3600*100);     // 离线时间
        $msg->set_data($tpl);                                          // 推送消息模板
        $msg->set_PushNetWorkType(0);                // 设置是否根据WIFI推送消息，2为4G/3G/2G，1为wifi推送，0为不限制推送
        $appIdList=array($this->gp_appid);
        $msg->set_appIdList($appIdList);
        // 发送
        $ret = $this->gpush->pushMessageToApp($msg);
        if($ret && $ret['result'] == 'ok')return JsonDataService::success('推送成功!');
        return JsonDataService::fail('推送失败!');
    }
    //根据clientId发消息(批量发消息)
    public function pushMsgByClientIds($title,$content,$client_ids,$payload = []){
        // 标准推送数据格式
        if(!$client_ids)return JsonDataService::fail('params erro');
        $Message1 = [
            "title"=> $title,
            "content"=> $content,
            "payload"=>$payload
        ];
        putenv("gexin_pushList_needDetails=true");
        putenv("gexin_pushList_needAsync=true");
        $template = $this->AwesomeTemplate($Message1);
        //个推信息体
        $message = new IGtListMessage();
        $message->set_isOffline(true);//是否离线
        $message->set_offlineExpireTime(3600 * 12 * 1000);//离线时间
        $message->set_data($template);//设置推送消息类型
        $contentId = $this->gpush->getContentId($message);	//根据TaskId设置组名，支持下划线，中文，英文，数字
        //接收方1
        $targetList = [];
        foreach ($client_ids as $v){
            $target = new IGtTarget();
            $target->set_appId($this->gp_appid);
            $target->set_clientId($v);
            $targetList[] = $target;
        }
        try {
            $ret = $this->gpush->pushMessageToList($contentId, $targetList);
            if($ret && $ret['result'] == 'ok')return JsonDataService::success('推送成功!');
            return JsonDataService::fail('推送失败!');
        } catch (\Exception $e) {
            return JsonDataService::fail('推送失败!');
        }

    }
    // 透传推送模板
   protected function AwesomeTemplate($param)
    {
        // 模板初始化
        $template = new IGtTransmissionTemplate();
        $template->set_appId($this->gp_appid);         // 应用appid
        $template->set_appkey($this->gp_appkey);       // 应用appkey
        // 安卓推送（外推+内推）、苹果内推
        $template->set_transmissionType(2);
        $template->set_transmissionContent(json_encode($param));  // 透传内容

        // 苹果处于后台时的推送（外推）
        $alertmsg = new DictionaryAlertMsg();
        $alertmsg->actionLocKey = "ActionLockey";       // 个推官网提供，文档无说明
        $alertmsg->launchImage = "launchimage";         // 个推官网提供，文档无说明
        $alertmsg->locArgs = array("locargs");          // 个推官网提供，文档无说明
        $alertmsg->locKey = $param["title"];            // 消息标题
        $alertmsg->body = $param["content"];            // 消息内容
        // iOS8.2 支持
        $alertmsg->title = $param["title"];             // 消息标题
        $alertmsg->titleLocKey = $param["title"];       // 消息标题
        $alertmsg->titleLocArgs = array("TitleLocArg"); // 个推官网提供，文档无说明

        $apn = new IGtAPNPayload();
        $apn->alertMsg = $alertmsg;
        //$apn->badge = 1;
        //$apn->sound = "";
        $param["payload"]["push"] = "outer";        // 调用此处代码证明是外推
        foreach($param as $key=>$val)
        {
            $apn->add_customMsg($key,$val);
        }
        $apn->contentAvailable = 1;                 // 个推官网提供，文档无说明
        $apn->category = "ACTIONABLE";              // 个推官网提供，文档无说明
        $template->set_apnInfo($apn);

        return $template;
    }

}

?>