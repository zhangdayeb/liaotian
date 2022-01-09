<?php
/**
 * Created by IntelliJ IDEA.
 * User: Administrator
 * Date: 2020-07-25
 * Time: 15:03
 */

namespace extend\service;


use app\common\controller\SendData;
use app\im\model\mongo\ChatList;
use app\im\model\mongo\Circle;
use app\im\model\mongo\Friend;
use app\im\model\mysql\CapitalLog;
use app\im\model\mysql\ChargeOrder;
use app\im\model\mysql\ProductOrder;
use app\im\model\mysql\User;
use app\super\model\BsysConfig;
use think\Db;
use think\Exception;
use think\facade\Log;
use Yansongda\Pay\Exceptions\GatewayException;
use Yansongda\Pay\Pay;

class PayMentService
{
    protected static $_aliConfig = null;    //支付宝配置
    protected static $_weixinConfig = null;  //微信配置
    //支付宝
    protected $config = [
        'app_id' => '2016082000295641',
        'notify_url' => 'http://yansongda.cn/notify.php',
        'return_url' => 'http://yansongda.cn/return.php',
        'ali_public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAuWJKrQ6SWvS6niI+4vEVZiYfjkCfLQfoFI2nCp9ZLDS42QtiL4Ccyx8scgc3nhVwmVRte8f57TFvGhvJD0upT4O5O/lRxmTjechXAorirVdAODpOu0mFfQV9y/T9o9hHnU+VmO5spoVb3umqpq6D/Pt8p25Yk852/w01VTIczrXC4QlrbOEe3sr1E9auoC7rgYjjCO6lZUIDjX/oBmNXZxhRDrYx4Yf5X7y8FRBFvygIE2FgxV4Yw+SL3QAa2m5MLcbusJpxOml9YVQfP8iSurx41PvvXUMo49JG3BDVernaCYXQCoUJv9fJwbnfZd7J5YByC+5KM4sblJTq7bXZWQIDAQAB',
        // 加密方式： **RSA2**
        'private_key' => 'MIIEpAIBAAKCAQEAs6+F2leOgOrvj9jTeDhb5q46GewOjqLBlGSs/bVL4Z3fMr3p+Q1Tux/6uogeVi/eHd84xvQdfpZ87A1SfoWnEGH5z15yorccxSOwWUI+q8gz51IWqjgZxhWKe31BxNZ+prnQpyeMBtE25fXp5nQZ/pftgePyUUvUZRcAUisswntobDQKbwx28VCXw5XB2A+lvYEvxmMv/QexYjwKK4M54j435TuC3UctZbnuynSPpOmCu45ZhEYXd4YMsGMdZE5/077ZU1aU7wx/gk07PiHImEOCDkzqsFo0Buc/knGcdOiUDvm2hn2y1XvwjyFOThsqCsQYi4JmwZdRa8kvOf57nwIDAQABAoIBAQCw5QCqln4VTrTvcW+msB1ReX57nJgsNfDLbV2dG8mLYQemBa9833DqDK6iynTLNq69y88ylose33o2TVtEccGp8Dqluv6yUAED14G6LexS43KtrXPgugAtsXE253ZDGUNwUggnN1i0MW2RcMqHdQ9ORDWvJUCeZj/AEafgPN8AyiLrZeL07jJz/uaRfAuNqkImCVIarKUX3HBCjl9TpuoMjcMhz/MsOmQ0agtCatO1eoH1sqv5Odvxb1i59c8Hvq/mGEXyRuoiDo05SE6IyXYXr84/Nf2xvVNHNQA6kTckj8shSi+HGM4mO1Y4Pbb7XcnxNkT0Inn6oJMSiy56P+CpAoGBAO1O+5FE1ZuVGuLb48cY+0lHCD+nhSBd66B5FrxgPYCkFOQWR7pWyfNDBlmO3SSooQ8TQXA25blrkDxzOAEGX57EPiipXr/hy5e+WNoukpy09rsO1TMsvC+v0FXLvZ+TIAkqfnYBgaT56ku7yZ8aFGMwdCPL7WJYAwUIcZX8wZ3dAoGBAMHWplAqhe4bfkGOEEpfs6VvEQxCqYMYVyR65K0rI1LiDZn6Ij8fdVtwMjGKFSZZTspmsqnbbuCE/VTyDzF4NpAxdm3cBtZACv1Lpu2Om+aTzhK2PI6WTDVTKAJBYegXaahBCqVbSxieR62IWtmOMjggTtAKWZ1P5LQcRwdkaB2rAoGAWnAPT318Kp7YcDx8whOzMGnxqtCc24jvk2iSUZgb2Dqv+3zCOTF6JUsV0Guxu5bISoZ8GdfSFKf5gBAo97sGFeuUBMsHYPkcLehM1FmLZk1Q+ljcx3P1A/ds3kWXLolTXCrlpvNMBSN5NwOKAyhdPK/qkvnUrfX8sJ5XK2H4J8ECgYAGIZ0HIiE0Y+g9eJnpUFelXvsCEUW9YNK4065SD/BBGedmPHRC3OLgbo8X5A9BNEf6vP7fwpIiRfKhcjqqzOuk6fueA/yvYD04v+Da2MzzoS8+hkcqF3T3pta4I4tORRdRfCUzD80zTSZlRc/h286Y2eTETd+By1onnFFe2X01mwKBgQDaxo4PBcLL2OyVT5DoXiIdTCJ8KNZL9+kV1aiBuOWxnRgkDjPngslzNa1bK+klGgJNYDbQqohKNn1HeFX3mYNfCUpuSnD2Yag53Dd/1DLO+NxzwvTu4D6DCUnMMMBVaF42ig31Bs0jI3JQZVqeeFzSET8fkoFopJf3G6UXlrIEAQ==',
        'log' => [ // optional
            'file' => './logs/alipay.log',
            'level' => 'info', // 建议生产环境等级调整为 info，开发环境为 debug
            'type' => 'single', // optional, 可选 daily.
            'max_file' => 30, // optional, 当 type 为 daily 时有效，默认 30 天
        ],
        'http' => [ // optional
            'timeout' => 5.0,
            'connect_timeout' => 5.0,
            // 更多配置项请参考 [Guzzle](https://guzzle-cn.readthedocs.io/zh_CN/latest/request-options.html)
        ],
        'mode' => 'dev', // optional,设置此参数，将进入沙箱模式
    ];
    //微信
    protected $config2 = [
        'appid' => 'wxb3fxxxxxxxxxxx', // APP APPID
        'app_id' => 'wxb3fxxxxxxxxxxx', // 公众号 APPID
        'miniapp_id' => 'wxb3fxxxxxxxxxxx', // 小程序 APPID
        'mch_id' => '14577xxxx',
        'key' => 'mF2suE9sU6Mk1Cxxxxxxxxxxx',
        'notify_url' => 'http://yanda.net.cn/notify.php',
        'cert_client' => './cert/apiclient_cert.pem', // optional，退款等情况时用到
        'cert_key' => './cert/apiclient_key.pem',// optional，退款等情况时用到
        'log' => [ // optional
            'file' => './logs/wechat.log',
            'level' => 'info', // 建议生产环境等级调整为 info，开发环境为 debug
            'type' => 'single', // optional, 可选 daily.
            'max_file' => 30, // optional, 当 type 为 daily 时有效，默认 30 天
        ],
        'http' => [ // optional
            'timeout' => 5.0,
            'connect_timeout' => 5.0,
            // 更多配置项请参考 [Guzzle](https://guzzle-cn.readthedocs.io/zh_CN/latest/request-options.html)
        ],
        'mode' => 'dev', // optional, dev/hk;当为 `hk` 时，为香港 gateway。
    ];

    /**
     * 构造支付方法
     * @param int $type
     */
    public static function allipay(){
        //支付宝 TODO 从数据库获取配置信息
        $config = BsysConfig::getAllVal('pay_config');
        if(!$config) return JsonDataService::fail('支付未配置');
          Log::info('config:'.print_r($config,true));
        if(!self::$_aliConfig){
            self::$_aliConfig = [
                'app_id' => $config['alipay_appid'],
                'notify_url' => get_server().'/im/app/notifyAlipay',
                'return_url' => get_server().'/h5',
                'ali_public_key' => $config['alipay_public_key'],
                // 加密方式： **RSA2**
                'private_key' =>$config['alipay_private_key'],
                'log' => [ // optional
                    'file' => ALIPAYMENT_LOG,
                    'level' => 'info', // 建议生产环境等级调整为 info，开发环境为 debug
                    'type' => 'single', // optional, 可选 daily.
                    'max_file' => 30, // optional, 当 type 为 daily 时有效，默认 30 天
                ],
                'http' => [ // optional
                    'timeout' => 5.0,
                    'connect_timeout' => 5.0,
                    // 更多配置项请参考 [Guzzle](https://guzzle-cn.readthedocs.io/zh_CN/latest/request-options.html)
                ],
                'mode' => 'normal', // optional,设置此参数，将进入沙箱模式
            ];
        }
        return Pay::alipay(self::$_aliConfig);
    }

    public static function transfer($params = []){

        $order_id = $params['order_id'] ?? create_guid();
        if($params['amount'] < 0.1) return JsonDataService::fail('最少提现0.1元');
        $order = [
            'out_biz_no' => $order_id,
            'payee_type' => 'ALIPAY_LOGONID',
            'payee_account' => $params['account'],
            'amount' => $params['amount'],
            'payee_real_name' =>$params['realname'],
            'remark' =>$params['app_name'].'APP提现',
        ];
        try{
            $ret = self::allipay()->transfer($order)->toArray();
            if(isset($ret) && $ret && $ret['code'] == 10000){
                //成功
                return JsonDataService::success('转账成功!',['order_id'=>$order_id,'ali_order_id'=>$ret['order_id']]);
            }
            return JsonDataService::fail($ret['sub_msg']);
        }catch (GatewayException $e){
            $str = $e->getMessage();
            $msg = '账号信息有误!';
            if(strpos($str,'PAYEE_NOT_EXIST') !== false)$msg = '支付宝帐号不存在';
            if(strpos($str,'PAYEE_NOT_EXIST') !== false)$msg = '支付宝帐号不存在';
            if(strpos($str,'BLOCK_USER_FORBBIDEN_RECIEVE') !== false)$msg = '账户异常被冻结，无法收款，请咨询支付宝客服95188';
            if(strpos($str,'PAYEE_USER_TYPE_ERROR') !== false)$msg = '不支持的收款用户类型，请联系收款用户，更换支付宝账户后收款';
            if(strpos($str,'RELEASE_USER_FORBBIDEN_RECIEVE') !== false)$msg = '支付宝手机号被二次放号禁止收款';
            if(strpos($str,'MAX_VISIT_LIMIT') !== false)$msg = '超出最大访问限制';
            if(strpos($str,'PERMIT_CHECK_PERM_LIMITED') !== false)$msg = '根据监管部门的要求，请补全您的身份信息解除限制';
            if(strpos($str,'TRANSFER_ERROR') !== false)$msg = '转账失败';
            if(strpos($str,'SYNC_SECURITY_CHECK_FAILED') !== false)$msg = '转账失败';
            if(strpos($str,'PAYER_PAYEE_CANNOT_SAME') !== false)$msg = '收付款方不能相同';
            if(strpos($str,'EXCEED_LIMIT_UNRN_DM_AMOUNT') !== false)$msg = '收款账户未实名，单日最多可收款1000元';
            if(strpos($str,'EXCEED_LIMIT_DM_MAX_AMOUNT') !== false)$msg = '超过单日最大转账额度';
            if(strpos($str,'EXCEED_LIMIT_SM_MIN_AMOUNT') !== false)$msg = '单笔最低转账金额0.1元';
            if(strpos($str,'EXCEED_LIMIT_ENT_SM_AMOUNT') !== false)$msg = '转账给企业支付宝账户单笔最多10万元';
            if(strpos($str,'EXCEED_LIMIT_PERSONAL_SM_AMOUNT') !== false)$msg = '转账给个人支付宝账户单笔最多5万元';
            if(strpos($str,'PERMIT_NON_BANK_LIMIT_PAYEE') !== false)$msg = '根据监管部门的要求，对方未完善身份信息或未开立余额账户，无法收款	';
            if(strpos($str,'PAYER_CERT_EXPIRED') !== false)$msg = '根据监管部门的要求，需要付款用户更新身份信息才能继续操作';
            if(strpos($str,'ACCOUNT_NOT_EXIST') !== false)$msg = '根据监管部门的要求，请补全你的身份信息，开立余额账户';
            if(strpos($str,'REMARK_HAS_SENSITIVE_WORD') !== false)$msg = '转账备注包含敏感词，请修改备注文案后重试';
            if(strpos($str,'PERMIT_CHECK_PERM_IDENTITY_THEFT') !== false)$msg = '您的账户存在身份冒用风险，请进行身份核实解除限制	';
            if(strpos($str,'PERMIT_PAYER_FORBIDDEN') !== false)$msg = '根据监管部门要求，付款方余额支付额度受限	';
            if(strpos($str,'PERMIT_PAYER_LOWEST_FORBIDDEN') !== false)$msg = '根据监管部门要求，付款方身份信息完整程度较低，余额支付额度受限	';
            if(strpos($str,'PERMIT_NON_BANK_LIMIT_PAYEE') !== false)$msg = '根据监管部门的要求，对方未完善身份信息或未开立余额账户，无法收款	';
            if(strpos($str,'MEMO_REQUIRED_IN_TRANSFER_ERROR') !== false)$msg = '根据监管部门的要求，单笔转账金额达到50000元时，需要填写付款理由		';
            if(strpos($str,'PAYEE_ACC_OCUPIED') !== false)$msg = '该手机号对应多个支付宝账户，请传入收款方姓名确定正确的收款账号	';
            if(strpos($str,'CERT_MISS_ACC_LIMIT') !== false)$msg = '您连续10天余额账户的资金都超过5000元，根据监管部门的要求，需要付款用户补充身份信息才能继续操作';
            if(strpos($str,'CERT_MISS_TRANS_LIMIT') !== false)$msg = '您的付款金额已达单笔1万元或月累计5万元，根据监管部门的要求，需要付款用户补充身份信息才能继续操作';
            if(strpos($str,'PAYEE_USER_INFO_ERROR') !== false)$msg = '支付宝账号和姓名不匹配，请确认姓名是否正确';
            if(strpos($str,'PERM_AML_NOT_REALNAME_REV') !== false)$msg = '根据监管部门的要求，需要收款用户补充身份信息才能继续操作';
            if(strpos($str,'PAYER_DATA_INCOMPLETE') !== false)$msg = '根据监管部门的要求，需要付款用户补充身份信息才能继续操作';
            if(strpos($str,'PAYEE_NOT_EXIST') !== false)$msg = '收款账号不存在';
            if(strpos($str,'PAYCARD_UNABLE_PAYMENT') !== false)$msg = '付款方账户余额支付功能不可用';
            if(strpos($str,'PERMIT_CHECK_PERM_LIMITED') !== false)$msg = '根据监管部门的要求，请补全您的身份信息解除限制';
            if(strpos($str,'SYSTEM_ERROR') !== false)$msg = '系统繁忙';
//            if(strpos($str,'PAYER_USER_INFO_ERROR') !== false)$msg = '付款用户姓名或其它信息不一致';
//            if(strpos($str,'PAYER_DATA_INCOMPLETE') !== false)$msg = '根据监管部门的要求，需要付款用户补充身份信息才能继续操作';
//            if(strpos($str,'PAYER_BALANCE_NOT_ENOUGH') !== false)$msg = '支付时间点付款方余额不足，请保持付款账户余额充足。';
            return JsonDataService::fail("支付宝返回:".$msg);
        }

    }
    /**
     * 微信支付
     * @param int $type
     * @return \Yansongda\Pay\Gateways\Alipay
     */
    public static function weixinPay($type = 1){
        //从数据库获取配置信息
        if(!self::$_weixinConfig){
            self::$_weixinConfig = [
                'appid' => 'wxb3fxxxxxxxxxxx', // APP APPID
                'app_id' => 'wxb3fxxxxxxxxxxx', // 公众号 APPID
                'miniapp_id' => 'wxb3fxxxxxxxxxxx', // 小程序 APPID
                'mch_id' => '14577xxxx',
                'key' => 'mF2suE9sU6Mk1Cxxxxxxxxxxx',
                'notify_url' => 'http://yanda.net.cn/notify.php',
                'cert_client' => './cert/apiclient_cert.pem', // optional，退款等情况时用到
                'cert_key' => './cert/apiclient_key.pem',// optional，退款等情况时用到
                'log' => [ // optional
                    'file' => './logs/wechat.log',
                    'level' => 'info', // 建议生产环境等级调整为 info，开发环境为 debug
                    'type' => 'single', // optional, 可选 daily.
                    'max_file' => 30, // optional, 当 type 为 daily 时有效，默认 30 天
                ],
                'http' => [ // optional
                    'timeout' => 5.0,
                    'connect_timeout' => 5.0,
                    // 更多配置项请参考 [Guzzle](https://guzzle-cn.readthedocs.io/zh_CN/latest/request-options.html)
                ],
                'mode' => 'dev', // optional, dev/hk;当为 `hk` 时，为香港 gateway。
            ];
        }
        return Pay::alipay(self::$_weixinConfig);
    }

    /**
     * 支付宝APP支付
     */
    public static function aliAppPay($total_amount,$out_trade_no,$subject){
        return self::allipay()->app([
            'total_amount'=>$total_amount,
            'subject'=>$subject,
            'out_trade_no'=>$out_trade_no,
        ]);
    }
    /**
     * 支付宝H5支付
     */
    public static function aliH5Pay($total_amount,$out_trade_no,$subject){
        $order = [
            'out_trade_no' => $total_amount,
            'total_amount' => $out_trade_no,
            'subject'      => $subject,
        ];
        return  self::allipay()->wap($order);
    }

    /**
     * 支付
     */
    public static function userCharge(array $params){
        $ret = JsonDataService::fastClick($params['user_id']);
        if(!JsonDataService::checkRes($ret)) return $ret;
        $pay_type = $params['charge_type'];
        $user_id = $params['user_id'];
        $amount = $params['amount'];
        $subject_name = '充值订单';
        if($pay_type == 2) return JsonDataService::fail('该充值通道暂未开放');
        if($amount < 0.01) return JsonDataService::fail('最少充值1块钱');
        $ret = ChargeOrder::createOrder([
            'user_id'=>$user_id,
            'goods_name'=>$subject_name,
            'amount'=>floatval($amount),
            'pay_type'=>1,
        ]);
        if(!$ret) return JsonDataService::fail('支付失败!');
        $ret = self::aliAppPay($amount,$ret->order_id,$subject_name)->getContent();
        if(!$ret) return JsonDataService::fail('充值通道异常,请联系客服!');
        return JsonDataService::success('',['orderInfo'=>$ret]);
    }


    /**
     * 支付回调
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public static function notifyAlipay()
    {
        $alipay =self::allipay();

        try{
            $data = $alipay->verify();
            $params = $data->all();
            Log::debug('Alipay notify', $data->all());
            $order = ChargeOrder::where(['order_id'=>$params['out_trade_no']])->find();
            if(!$order) throw Exception('订单不存在');
            if($order['status'] == 1)  return $alipay->success()->send();
            if($order['status'] != 0) throw Exception('订单状态异常!');
            //先更新状态再加钱
            ChargeOrder::startTrans();
            $ret = ChargeOrder::where(['order_id'=>$params['out_trade_no']])->update([
                'auth_app_id'=>$params['auth_app_id'],
                'status'=>1,
                'seller_id'=>$params['seller_id'],
                'pay_type'=>1,
                'payment_id'=>$params['trade_no'],
                'notify_id'=>$params['notify_id'],
            ]);
            if($ret === false) throw Exception('更新订单失败!');
            Log::debug('amount:'.$order['amount']);
            $ret_2 = User::where(['id'=>$order['user_id']])->setInc('money',$order['amount']);
            if($ret_2 === false) throw Exception('更新订单失败!');
            $user_info =  UserService::getUserInfo($order['user_id']);
            $ret_3 = CapitalLog::create([
                'user_id'=>$order['user_id'],
                'order_id'=>$params['out_trade_no'],
                'capital_type'=>2,
                'record_type'=>1,
                'explain'=>'在线充值',
                'user_money'=>$user_info['money'],
                'money'=>$order['amount']
            ]);
            if($ret_3 === false) throw Exception('更新订单失败!');
        } catch (\Exception $e) {
            ChargeOrder::rollback();
            Log::debug('Alipay notify fail'.$e->getMessage());
            exit('fail');
        }
        ChargeOrder::commit();
        //TODO 通知用户支付成功!刷新用户信息
        MsgService::senNormalMsgToUid($order['user_id'],'onlinePaySuccess',$user_info);
        return $alipay->success()->send();// laravel 框架中请直接 `return $alipay->success()`
    }

    /**
     * 付费音视频配置信息
     */
    public static function getVedioPayConfig(){
       $config = BsysConfig::getAllVal('vedio');
        $voice_pay_amount = $config['voice_pay_amount'] ?? 0;
        $vedio_pay_amount = $config['vedio_pay_amount'] ?? 0;
        return JsonDataService::success('配置信息',['voice'=>$voice_pay_amount,'vedio'=>$vedio_pay_amount]);
    }

    /**
     * 朋友圈商品支付
     */
    public static function payCircleOrder(array $params){
        //根据POSY_ID查找商品詳情
        $goods_info = Circle::get($params['post_id']);
        if(!$goods_info) return JsonDataService::fail('商品信息不存在!');
        $user_info = UserService::getUserInfo($params['user_id']);
        //校验交易密码
        if($goods_info['user_id'] == $params['user_id'])return JsonDataService::fail('不能购买自己的商品哦!');
        if($goods_info['can_pay'] != 1) return JsonDataService::fail('改商品未上架!');
        if($goods_info['pay_amount']<= 0) return JsonDataService::fail('该商品不能被购买');
        if($goods_info['can_pay_times']<= 0) return JsonDataService::fail('该商品已被购买');
//        if(!check_password($params['password'],$user_info['trade_password'])) return JsonDataService::fail('交易密码不正确!');
        //判断用户余额
        $ret = UserService::canPayAmount($params['user_id'],$goods_info['pay_amount']);
        if(!JsonDataService::checkRes($ret)) return $ret;
        //下单
        $order_id = create_guid();
        ProductOrder::startTrans();
        try{
            //
            $ret = UserService::payAmount(
                [
                    'user_id'=>$params['user_id'],
                    'order_id'=>$order_id,
                    'dbh'=>false,
                    'to_user_id'=>$goods_info['user_id'],
                    'amount'=>$goods_info['pay_amount'],
                    'capital_type'=> 3,         //朋友圈动态类型
                    'explain1'=>'购买朋友圈动态',
                    'explain2'=>'朋友圈动态收入'
                ]);
            if(!JsonDataService::checkRes($ret))throw new Exception('购买失败!');
            //创建订单
            $content =$goods_info['content'];
            $order_info = ProductOrder::createOrder([
                'goods_name'=>$content['text'] ?? '朋友圈动态商品',
                'goods_relation_table'=>'Circle',
                'type'=>'mongo',
                'order_id'=>$order_id,
                'goods_relation_id'=>$goods_info['id'],
                'amount'=>$goods_info['pay_amount'],
                'user_id'=>$params['user_id'],
                'to_user_id'=>$goods_info['user_id'],
                'status'=>1,
                'username'=>$params['username'],
                'mobile'=>$params['mobile'],
                'address'=>$params['regionStr'].$params['address'],
                'small_pic'=>$params['small_pic']
            ]);
            if($order_info === false)throw new Exception('购买失败!');
        }catch (Exception $e){
            ProductOrder::rollback();
            return JsonDataService::fail($e->getMessage());
        }
        ProductOrder::commit();
        $user_info = $ret['data'];
        //更新状态 TODO 后面单独表维护状态
        Circle::where(['id'=>$goods_info['id']])->update(['pay_status'=>1]);
        Circle::where(['id'=>$goods_info['id']])->setDec('can_pay_times',1);
        //通知所有人
        $notice = ['circle_id'=>$goods_info['id'],'can_pay_times'=>0];
        SendData::sendToUid(USER_ID, 'payCircleOrder',$notice);
        $data =Friend::where(['user_id'=>$goods_info['user_id'] * 1])->select()->toArray();
       if($data){
            foreach ($data as $v){
                if($v['user_id'] == $params['user_id']) continue;
                $notice['friend_id'] = $v['friend_id'];
                SendData::sendToUid($v['friend_id'], 'payCircleOrder',$notice);
            }
        }
        MsgService::senNormalMsgToUid($params['user_id'],'payAmount',$user_info);
        $user_info['can_pay_times'] = 0;
        return JsonDataService::success('购买成功!',$user_info);
    }

    /**
     * m:时长(分钟)
     * roomid:房主ID
     * list_id：需要支付的房间
     * 在线视频语音之后扣费
     */
    public static function afterCallVideo(array $params){
        //扣费
        $redis_key = ConfigService::VIDEO_CALL_ROOM.$params['list_id'];
        $pay_key =  ConfigService::VIDEO_CALL_PAY.$params['list_id'];
        $info = json_decode(RedisService::get($redis_key),true);
        Log::debug('付款信息:'.print_r($info,true));
        if(!$info) return JsonDataService::fail('未发起视频');
        $config = self::getVedioPayConfig();
        $voice_pay_amount = $config['data']['voice'];
        $vedio_pay_amount = $config['data']['vedio'];
        $type = $info['type'];
        $amount = $type == 'video' ? $vedio_pay_amount : $voice_pay_amount;
        if(!$amount) return JsonDataService::fail('视频限时免费');
        if (!$chat_list = ChatList::field('id,type,status,user_ids')->where('list_id', $params['list_id'])->find()) {
            return JsonDataService::fail('没有这条会话,扣费失败!');
        }
        //判断是否可以支付
        $can_pay = UserService::canPayAmount($info['roomid'],$amount);
        $content_type = $type =='video' ? 6 : 7;
        $name = $type =='video' ? '视频' : '语音';
        if(!JsonDataService::checkRes($can_pay)){  //不够扣直接关闭
            //调用close方法
            RedisService::inc($pay_key); //每次进入需扣一次费用
            $m = RedisService::get($pay_key);
            RedisService::del($pay_key);
            MsgService::closeVideo([
                'user_id'=>$params['user_id'],
                'list_id'=>$params['list_id'],
                'roomid'=>$info['roomid'],
                'time'=>$m.':'.'00',
                'content_type'=>$content_type
            ]);
            //TODO 发送消息
            return JsonDataService::fail('不够扣关闭');
        }
        $del_redis_key = ConfigService::VEDIO_START_TIME.$content_type.':'.$params['list_id'];
        if(!RedisService::get($del_redis_key)){  //关闭的视频则扣费
            //扣费
            UserService::payAmount(
                [
                    'user_id'=>$info['roomid'],
                    'to_user_id'=>$info['to_user_id'],
                    'amount'=>$amount,
                    'capital_type'=> 4,         //在线视频付费
                    'explain1'=>$name.'聊天支出',
                    'explain2'=>$name.'聊天收入',
                ]);
            //TODO 发送消息
            return JsonDataService::fail('已关闭视频');
        } //已经执行过关闭逻辑这里不处理

        $ret = UserService::payAmount(
            [
                'user_id'=>$info['roomid'],
                'to_user_id'=>$info['to_user_id'],
                'amount'=>$amount,
                'capital_type'=> 4,         //在线视频付费
                'explain1'=>$name.'聊天支出',
                'explain2'=>$name.'聊天收入',
            ]);
        if(!JsonDataService::checkRes($ret)) { //扣费失败关闭
            RedisService::inc($pay_key); //每次进入需扣一次费用
            $m = RedisService::get($pay_key);
            RedisService::del($pay_key);
            MsgService::closeVideo([
                'user_id'=>$params['user_id'],
                'list_id'=>$params['list_id'],
                'roomid'=>$info['roomid'],
                'time'=>$m.':'.'00',
                'content_type'=>$content_type
            ]);
            //TODO 发送消息
            return JsonDataService::fail('扣费失败!',$ret);
        }

        //检查用户是否够下一支付
        $can_pay = UserService::canPayAmount($info['roomid'],$amount);
        if(!JsonDataService::checkRes($can_pay)){
            RedisService::inc($pay_key); //每次进入需扣一次费用
            $m = RedisService::get($redis_key);
            RedisService::del($redis_key);
            MsgService::closeVideo([
                'user_id'=>$params['user_id'],
                'list_id'=>$params['list_id'],
                'roomid'=>$info['roomid'],
                'time'=>$m.':'.'00',
                'content_type'=>$content_type
            ]);
            //不够下次扣费关闭
            //TODO 发送消息
            return JsonDataService::fail('不够下次扣费');
        }
        RedisService::inc($pay_key); //每次进入需扣一次费用
        return JsonDataService::success('付费成功');
    }
}