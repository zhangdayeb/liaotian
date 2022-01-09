<?php
/**
 * Created by IntelliJ IDEA.
 * User: Administrator
 * Date: 2020/9/5 0005
 * Time: 0:37
 */

namespace extend\service;

use app\super\model\BsysConfig;
use dh2y\sms\service\Jianzhou;
use Flc\Dysms\Client;
use Flc\Dysms\Request\SendSms;

class SmsService
{
    public static function sendAliMsg($mobile, $type = '', $code = '')
    {
        //查询key直接发
        $config = BsysConfig::getAllVal('sms_config');
        if (!$config) return JsonDataService::fail('短信未配置');
        $code = $code ? $code : rand(100000, 999999);
        $key = ConfigService::SMS_CODE . $type . ':' . $mobile;
//        if (RedisService::get($key)) return JsonDataService::fail('60秒后重新发送!');
        $ali_config = [
            'accessKeyId' => $config['sms_appkey'],
            'accessKeySecret' => $config['sms_appScript'],
        ];
        $client = new Client($ali_config);
        $sendSms = new SendSms;
        $sendSms->setPhoneNumbers($mobile);
        $sendSms->setSignName($config['sms_sign']);
        $sendSms->setTemplateCode($config['sms_code']);

        $sendSms->setTemplateParam(['code' => $code]);
        $res = $client->execute($sendSms);
        $res = (array)$res;
        if ($res['Message'] != 'OK') {
            return JsonDataService::fail('短信发送失败!'.json_encode($res), $res);
        }
        //缓存
        if ($type) RedisService::setex($key, $code, 300);
        return JsonDataService::success('短信发送成功!', ['code' => $code, 'key' => $key]);
    }

    /**
     * 校验验证码
     */
    public static function checkSsmCode($params)
    {
        $key = ConfigService::SMS_CODE.$params['type'].':'.$params['mobile'];
        $code = RedisService::get($key);
        if(!$code) return JsonDataService::fail('验证码已失效，请重新获取');
        if($params['code'] !=$code) return JsonDataService::fail('验证码不正确!');
        return JsonDataService::success('校验通过!');
    }
}