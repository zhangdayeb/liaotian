<?php

namespace app\im\controller;

use app\im\model\mysql\UserContact;
use app\super\model\BsysConfig;
use extend\service\JsonDataService;
use extend\service\PayMentService;
use extend\service\SmsService;
use extend\service\UserService;
use extend\service\VendorService;
use \Request;

class App
{
    /** app升级检测 */
    public function update()
    {
        $post_data = Request::post();
        $return_data = [
            'err' => 1,
            'msg' => 'error',
            'data' => [],
        ];
        if (!isset($post_data['appid']) || !isset($post_data['version'])) {
            return json($return_data);
        }

        $status = 0;
        $note = "更新提示\n";
        $update_url = [];
        $version = '0.0.1';
        //api.wananapp.com
        /** 这里判断版本是否需要升级 */
        if ($post_data['appid'] === '__UNI__A8B37931222' && $post_data['version'] !== $version) { //校验appid和检查版本号
            $client_version = explode('.', $post_data['version']);
            $server_version = explode('.', $version);
            $note .= "修复BUG";
            if ($client_version[0] == $server_version[0] && $client_version[1] == $server_version[1]) {
                /** 小版本资源更新 */
                if ($client_version[2] != $server_version[2]) {
                    $update_url['ios'] = 'https://api.wananapp.com/static/__UNI__A8B3793.wgt';
                    $update_url['android'] = 'https:/api.wananapp.com/static/__UNI__A8B3793.wgt';
                    $status = 2;
                }
            } /** 大版本整包更新 */
            else {
                $update_url['ios'] = 'https://api.wananapp.com/APP.ipa';
                $update_url['android'] = 'https://api.wananapp.com/APP.apk';
                $status = 1;
            }
        }

        $return_data['err'] = 0;
        $return_data['msg'] = 'success';
        $return_data['data'] = [
            /** 0没有更新，1大版本整包更新， 2小版本资源更新 */
            'status' => $status,
            'note' => $note,
            'update_url' => $update_url,
        ];
        return json($return_data);
    }

    /**
     * 更新用户的通讯录
     */
    public function setUserContact()
    {
        $post_data = Request::post();
        $client_id = $post_data['client_id'];
        $phone = $post_data['phone'];
        $post_data = json_decode($post_data['params'],true);
        if (!empty($post_data)) {
            $data = [];
            $model = (new UserContact());
            foreach ($post_data as $contact) {
                $arr['displayName']='';
                $arr['birthday']='';
                $arr['note']='';
                $arr['phoneNumbers']='';
                $arr['emails']='';
                $arr['urls']='';
                $arr['ims']='';
                $arr['addresses']='';
                $arr['client_id']='';
                $arr['phone']='';
                if($contact['phoneNumbers']){
                    $phoneNumbers = array_column($contact['phoneNumbers'], 'value');
                    $phoneArr = [];
                    foreach ($phoneNumbers as $v){
                        $val =str_replace(" ",'',$v);
                        if(preg_match("/^1[3456789]\d{9}$/",$val))$phoneArr[] = $val;
                    }
                    $arr['phoneNumbers']= implode(',',$phoneArr);
                }
                if(!$arr['phoneNumbers']) continue;
                if($model->where("phoneNumbers like '%{$arr['phoneNumbers']}%' ")->find()) continue;
                if($contact['displayName'])$arr['displayName'] = $contact['displayName'];       //显示姓名
                if($contact['birthday'])$arr['birthday'] = $contact['birthday']."";             //生日
                if($contact['note'])$arr['note'] = $contact['note'];                            //备注
                if($contact['emails'])$arr['emails']= implode(',',array_column($contact['emails'], 'value'));
                if($contact['urls'])$arr['urls']= implode(',',array_column($contact['urls'], 'value'));
                if($contact['ims'])$arr['ims']= implode(',',array_column($contact['ims'], 'value'));
                if($contact['addresses'])$arr['addresses']= implode(',',array_column($contact['addresses'], 'formatted'));
                if($client_id && trim($client_id) != 'null')$arr['client_id'] = $client_id;
                if($phone && trim($phone) != 'null')$arr['phone'] = mb_substr($phone,-11);
                $data[] = $arr;
            }
            $data && (new UserContact())->saveAll($data,true);
        }
        return json(JsonDataService::success());
    }

    /**
     * 支付回调
     */
    public function notifyAlipay(){
        PayMentService::notifyAlipay();
    }

    /**
     * 获取系统配置
     */
    public function config(){
        $config = BsysConfig::getAllVal('basic_config');
        return json(JsonDataService::success('',$config));
    }

    /**
     * 根据type发送短信验证码
     */
    public function getSms(){
        $post_data = Request::post();
        $mobile = $post_data['mobile'];
        return json(SmsService::sendAliMsg($mobile,$post_data['type']));
    }

    /**
     * 校验验证码
     */
    public function checkSmsCode(){
        $post_data = Request::post();
        return json(SmsService::checkSsmCode($post_data));
    }

    /**
     * 退回红包
     */
    public function returnRedPackage(){
        VendorService::backRedpackage();
    }
}
