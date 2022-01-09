<?php
/**
 * Created by IntelliJ IDEA.
 * User: Administrator
 * Date: 2020-07-04
 * Time: 22:24
 */

namespace app\super\controller;


use app\super\model\BsysConfig;
use extend\service\JsonDataService;
use FormBuilder\Form;
use think\App;
use think\Controller;;

use think\facade\Request;
use think\Url;


class System extends Controller
{
    public function __construct(App $app = null)
    {

        parent::__construct($app);
        $this->assign('menu',['系统设置','系统设置']);

    }

    public function setData(){
        $get =  Request::param();
        $tab_id = $get['tab_id'] ?? 1;
        switch ($tab_id){
            case 1:
                $file = $this->getBasicConfig();
                break;
            case 2:
                //支付配置
                $file = $this->payConfig();
                break;
            case 3:
                $file = $this->getVedioConfig();
                break;
            case 4:
                //短信配置
                $file = $this->smsConfig();
                break;
            default:

        }
        $file[] = Form::hidden('tab_id',$tab_id);
        $form = Form::create('/admin_saveConfig');
        $form->setMethod('post')->setTitle('系统设置')->components($file);
        $this->assign(compact('form'));
        $this->assign('tab_id',$tab_id);
        return $this->fetch('public/form_tab');
    }

    /**
     * 支付配置
     * @return array
     */
    protected function payConfig(){
        $info = BsysConfig::where(['field_key'=>'pay_config'])->find();

        $field_val = json_decode($info['field_val'],true);
        return [
            Form::input('alipay_appid','支付宝应用ID',isset($field_val['alipay_appid']) ? $field_val['alipay_appid']:'')->type('text')->col(13)->info("支付宝应用ID"),
            Form::input('alipay_private_key','应用私钥',isset($field_val['alipay_private_key']) ? $field_val['alipay_private_key']:'')->col(13)->info("支付宝公钥"),
            Form::input('alipay_public_key', '支付宝公钥', $field_val['alipay_public_key'] ?? '')->col(13)->info("应用私钥"),
            Form::hidden('key','pay_config'),
        ];
    }
    protected function smsConfig(){
        $info = BsysConfig::where(['field_key'=>'sms_config'])->find();

        $field_val = json_decode($info['field_val'],true);
        return [
            Form::input('sms_appkey','阿里云短信appkey',isset($field_val['sms_appkey']) ? $field_val['sms_appkey']:'')->type('text')->col(13)->info("阿里云短信appkey"),
            Form::input('sms_appScript','阿里云短信appScript',isset($field_val['sms_appScript']) ? $field_val['sms_appScript']:'')->col(13)->info("阿里云短信appScript"),
            Form::input('sms_code', '短信模板code', $field_val['sms_code'] ?? '')->col(13)->info("短信模板code"),
            Form::input('sms_sign', '短信签名', $field_val['sms_sign'] ?? '')->col(13)->info("短信签名"),
            Form::hidden('key','sms_config'),
        ];
    }
    protected function getBasicConfig(){
        $info = BsysConfig::where(['field_key'=>'basic_config'])->find();
        $field_val = json_decode($info['field_val'],true);
        return [
            Form::input('user_default_friend','注册默认成为好友的会员ID多个用|隔开',isset($field_val['user_default_friend']) ? $field_val['user_default_friend']:'')->type('text')->col(13)->info("注册默认成为好友的会员ID多个用|隔开"),
            Form::textarea('user_default_friend_speak','自动添加好友默认话术',isset($field_val['user_default_friend_speak']) ? $field_val['user_default_friend_speak']:'')->rows(6)->col(13)->info("请输入话术"),
			Form::radio('user_create_group', '仅客服账号可建群', $field_val['user_create_group'] ?? 0)->options([['label' => '开', 'value' => 1],['label' => '关', 'value' => 0]])->col(13),
            Form::radio('user_withdraw_status', '提现审核开关', $field_val['user_withdraw_status'] ?? 0)->options([['label' => '开', 'value' => 1],['label' => '关', 'value' => 0]])->col(13),
            Form::radio('user_regiter_sms_status', '注册验证码开关', $field_val['user_regiter_sms_status'] ?? 0)->options([['label' => '开', 'value' => 1],['label' => '关', 'value' => 0]])->col(13),
            Form::input('user_min_withdraw','用户最小提现金额',isset($field_val['user_min_withdraw']) ? $field_val['user_min_withdraw']:'')->type('number')->col(13)->info("用户最小提现金额"),
            Form::input('user_max_withdraw','用户每天最多提现金额',isset($field_val['user_max_withdraw']) ? $field_val['user_max_withdraw']:'')->type('number')->col(13)->info("用户每天最多提现金额"),
            Form::input('user_day_withdraw_times','用户每天最多提现次数',isset($field_val['user_day_withdraw_times']) ? $field_val['user_day_withdraw_times']:'')->type('number')->col(13)->info("用户每天最多提现次数"),
            Form::input('user_withdraw_fee','用户提现费率',isset($field_val['user_withdraw_fee']) ? $field_val['user_withdraw_fee']:'')->type('number')->col(13)->info("请输入会员id"),
            Form::input('user_push_appid','请输入uniPush的appid',isset($field_val['user_push_appid']) ? $field_val['user_push_appid']:'')->col(13)->info("请输入uniPush的appid"),
            Form::input('user_push_appKey','请输入uniPush的appKey',isset($field_val['user_push_appKey']) ? $field_val['user_push_appKey']:'')->col(13)->info("请输入uniPush的appKey"),
            Form::input('user_push_masterSecret','请输入uniPush的masterSecret',isset($field_val['user_push_masterSecret']) ? $field_val['user_push_masterSecret']:'')->col(13)->info("请输入uniPush的masterSecret"),
            Form::hidden('key','basic_config'),

        ];
    }
    protected function uploadConfig(){
        return [
            Form::hidden('key','upload'),
        ];
    }

    protected function getVedioConfig(){
        $info = BsysConfig::where(['field_key'=>'vedio'])->find();
        $field_val = json_decode($info['field_val'],true);
        return [
            Form::input('vedio_publickey','腾讯云公钥',isset($field_val['vedio_publickey']) ? $field_val['vedio_publickey']:'')->col(13)->info("腾讯云公钥,请到腾讯云后台获取"),
            Form::input('vedio_privatekey','腾讯云私钥',isset($field_val['vedio_privatekey']) ? $field_val['vedio_privatekey']:'')->col(13)->info("腾讯云私钥,请到腾讯云后台获取"),
            Form::input('vedio_appid','腾讯云视频appid',isset($field_val['vedio_appid']) ? $field_val['vedio_appid']:'')->col(13)->info("腾讯云私钥,请到腾讯云后台获取"),
            Form::input('vedio_pay_amount','视频聊天每分钟价格',isset($field_val['vedio_pay_amount']) ? $field_val['vedio_pay_amount']:'')->type('number')->col(13)->info("视频聊天每分钟价格"),
            Form::input('voice_pay_amount','语音聊天每分钟价格',isset($field_val['voice_pay_amount']) ? $field_val['voice_pay_amount']:'')->type('number')->col(13)->info("语音聊天每分钟价格"),
            Form::hidden('key','vedio'),
        ];
    }

    /**
     * 保存配置
     */
    public function saveConfig(){
        $params = Request::post();
        $key = $params['key'];
        $ret = BsysConfig::where(['field_key'=>$key])->update(['field_val'=>json_encode($params,256)]);
        if($ret === false) return json(JsonDataService::fail('操作失败!'));
        return json(JsonDataService::success('操作成功!'));
    }


    public function demo(){
        $field = [
//            Form::select('cate_id','产品分类')->setOptions(function(){
//                $list = CategoryModel::getTierList();
//                foreach ($list as $menu){
//                    $menus[] = ['value'=>$menu['id'],'label'=>$menu['html'].$menu['cate_name'],'disabled'=>$menu['pid']== 0];//,'disabled'=>$menu['pid']== 0];
//                }
//                return $menus;
//            })->filterable(1)->multiple(1),
            Form::input('store_name','产品名称')->col(Form::col(8)),
            Form::input('store_info','产品简介')->type('textarea')->col(20),
            Form::input('keyword','产品关键字')->placeholder('多个用英文状态下的逗号隔开')->col(8),
            Form::input('unit_name','产品单位','件')->col(8),
            Form::frameImageOne('image','产品主图片(305*305px)','admin/widget.images/index')->icon('image')->width('100%')->height('550px'),
            Form::frameImages('slider_image','产品轮播图(640*640px)','admin/widget.images/index')->maxLength(5)->icon('images')->width('100%')->height('550px')->spin(0),
            Form::number('price','产品售价')->min(0)->col(8),
            Form::number('ot_price','产品市场价')->min(0)->col(8),
            Form::number('give_integral','赠送积分')->min(0)->precision(0)->col(8),
            Form::number('postage','邮费')->min(0)->col(Form::col(8)),
            Form::number('sales','销量')->min(0)->precision(0)->col(8),
            Form::number('ficti','虚拟销量')->min(0)->precision(0)->col(8),
            Form::number('stock','库存')->min(0)->precision(0)->col(8),
            Form::number('cost','产品成本价')->min(0)->col(8),
            Form::number('sort','排序')->col(8),
            Form::radio('is_show','产品状态',0)->options([['label'=>'上架','value'=>1],['label'=>'下架','value'=>0]])->col(8),
            Form::radio('is_hot','热卖单品',0)->options([['label'=>'是','value'=>1],['label'=>'否','value'=>0]])->col(8),
            Form::radio('is_benefit','促销单品',0)->options([['label'=>'是','value'=>1],['label'=>'否','value'=>0]])->col(8),
            Form::radio('is_best','精品推荐',0)->options([['label'=>'是','value'=>1],['label'=>'否','value'=>0]])->col(8),
            Form::radio('is_new','首发新品',0)->options([['label'=>'是','value'=>1],['label'=>'否','value'=>0]])->col(8),
            Form::radio('is_postage','是否包邮',0)->options([['label'=>'是','value'=>1],['label'=>'否','value'=>0]])->col(8)
        ];
        $form = Form::create('/save');
        $form->setMethod('post')->setTitle('添加产品')->components($field);
        $this->assign(compact('form'));
        return $this->fetch('public/form-builder');
    }
}