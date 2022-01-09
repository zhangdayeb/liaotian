<?php
/**
 * Created by IntelliJ IDEA.
 * User: Administrator
 * Date: 2020/8/30 0030
 * Time: 3:31
 */

namespace app\im\controller;


use app\im\model\mysql\VendorUser;
use extend\service\HongBaoService;
use extend\service\JsonDataService;
use extend\service\JwtService;
use extend\service\UtilService;
use extend\service\VendorService;
use think\facade\Request;
use \app\im\model\mysql\User;

class Vendor
{
    //更改雷参数接口
    //获取群红包雷配置接口
    //红包下单接口
    //秒抢接口
    /**
     * 秒抢
     */
    public function bigRegQiang(){
        $post_data = Request::post(); //user_id
        $res = VendorService::updateMiaoQiang([
            'list_id'=>$post_data['list_id'],
            'status'=>$post_data['status'],
            'qiang_time'=>$post_data['num'],
            'user_id'=>USER_ID
        ]);
        return json($res);
    }

    /**
     *获取秒抢详情
     */
    public function getVendorInfo(){
        $post_data = Request::post(); //user_id
        $res = VendorService::getVendorInfo([
            'list_id'=>$post_data['list_id'],
            'user_id'=>USER_ID
        ]);
        return json($res);
    }

    /**
     * 发送雷红包
     */
    public function createLeiHongBao(){
        $post_data = Request::post(); //user_id
        $res = VendorService::createLeiHongBao(array_merge($post_data,['user_id'=>USER_ID]));
        return json($res);
    }

    /**
     * 发送雷红包
     */
    public function getLeiHongBao(){
        $post_data = Request::post(); //user_id
        $res = HongBaoService::getLeiHongBao(array_merge($post_data,['user_id'=>USER_ID]));
        return json($res);
    }

    /**
     * 设置红包插件
     */
    public function setHongBaoConfig(){
        $post_data = Request::post(); //user_id
        $res = VendorService::setHongBaoConfig(array_merge($post_data,['user_id'=>USER_ID]));
        return json($res);

    }

    /**
     * 获取用户插件信息
     */
    public function getUserVendor(){
        $post_data = Request::post(); //user_id
        $res = VendorService::getUserVendor(array_merge($post_data,['user_id'=>USER_ID]));
        return json($res);
    }

    public function getVendor(){
        $post_data = Request::post(); //user_id
        $res = VendorService::getVendorHongBaoInfo(array_merge($post_data,['user_id'=>USER_ID]));
        return json($res);
    }

    /**
     * 获取机器人列表
     */
    public function getRobotList(){
        return json(VendorService::getRobotList( Request::post()));
    }


    /**
     * 添加机器人人
     */
    public function addRobot(){
       return json(VendorService::addVendorRobot(Request::post()));
    }


    /**
     * 机器人退群
     * @return \think\response\Json
     */
    public function robotTuiQun(){
        return json(VendorService::robotTuiQun(array_merge(Request::post(),['user_id'=>USER_ID])));
    }


    /**
     * 机器人自动发包
     */
    public function robotAutoHongbao(){
        return json(VendorService::robotAutoHongbao(array_merge(Request::post(),['user_id'=>USER_ID])));
    }

    /**
     * 更新用户的交易密码
     */
    public function updateUserTradePassword(){
        return json(VendorService::updateUserTradePassword(array_merge(Request::post(),['user_id'=>USER_ID])));
    }

    /**
     * 保存成员在群中的昵称
     */
    public function saveGroupNickName(){
        return json(VendorService::saveGroupNickName(array_merge(Request::post(),['user_id'=>USER_ID])));
    }

    /**
     * 群成员列表
     */
    public function getMemberList(){
        return json(VendorService::memberList(array_merge(Request::post(),['user_id'=>USER_ID])));
    }

    /**
     * 获取邀请人
     */
    public function getInviteName(){
        return json(VendorService::getInviteName(Request::post()));
    }

    /**
     * 转让群
     * @return \think\response\Json
     */
    public function transferQun(){
        return json(VendorService::transferQun(array_merge(Request::post(),['user_id'=>USER_ID])));
    }


    public function getMemberData(){
        return json(VendorService::getMemberData(array_merge(Request::post(),['user_id'=>USER_ID])));
    }

    /**
     * 复制新的群
     */
    public function copyNewQun(){
        return json(VendorService::copyNewQun(array_merge(Request::post(),['user_id'=>USER_ID])));
    }

    public function getRoomInfo(){
        return json(VendorService::getRoomInfo(array_merge(Request::post(),['user_id'=>USER_ID])));
    }

    /**
     * 振动
     */
    public function zhendong(){
        return json(VendorService::zhendong(array_merge(Request::post(),['user_id'=>USER_ID])));
    }

    /**
     * 振动
     */
    public function editChange(){
        return json(VendorService::editChange(array_merge(Request::post(),['user_id'=>USER_ID])));
    }

    public function getGroupDetail(){
        return json(VendorService::getRoomInfo(array_merge(Request::post(),['user_id'=>USER_ID])));
    }

    public function getRedChange(){
        return json(VendorService::getRedChange(array_merge(Request::post(),['user_id'=>USER_ID])));
    }

    /**
     * 长时间未领取的红包列表
     */
    public function getExpireBigRed(){
        return json(VendorService::getExpireBigRed(array_merge(Request::post(),['user_id'=>USER_ID])));
    }

    /**
     * 发送戳一戳消息
     * @return \think\response\Json
     */
    public function sendChuoYiChuoMsg(){
        return json(VendorService::sendChuoYiChuoMsg(array_merge(Request::post(),['user_id'=>USER_ID])));
    }

    public function getUserCapitalList(){
        return json(VendorService::getUserCapitalList(array_merge(Request::post(),['user_id'=>USER_ID])));
    }

    /**
     * 获取文章列表
     */
    public function getArticleList(){
        return json(VendorService::getArticleList(array_merge(Request::post(),['user_id'=>USER_ID])));
    }

    /**
     * 获取文章详情
     */
    public function getArticleDetail(){
        return json(VendorService::getArticleDetail(array_merge(Request::post(),['user_id'=>USER_ID])));
    }

    /**
     * 获取收藏数据
     */
    public function getUserStore(){
        return json(VendorService::getUserStore(array_merge(Request::post(),['user_id'=>USER_ID])));
    }

    public function saveStore(){
        return json(VendorService::saveStore(array_merge(Request::post(),['user_id'=>USER_ID])));
    }

    /**
     * 获取存储统计
     * @return \think\response\Json
     */
    public function getStoreStatics(){
        return json(VendorService::getStoreStatics(array_merge(Request::post(),['user_id'=>USER_ID])));
    }

    /**
     * 删除储存
     */
    public function deleteStore(){
        return json(VendorService::deleteStore(array_merge(Request::post(),['user_id'=>USER_ID])));
    }


    /**
     * 获取成员头像
     */
    public function getMemberPhotos(){
        return json(VendorService::getMemberPhotos(array_merge(Request::post(),['user_id'=>USER_ID])));
    }
    /**
     * 转发储存
     */
    public function transMsg(){
        return json(VendorService::transUserStore(array_merge(Request::post(),['user_id'=>USER_ID])));
    }

    /**
     * 加入语音聊天室
     */
    public function joinVoiceRoom(){
        return json(VendorService::joinVoiceRoom(array_merge(Request::post(),['user_id'=>USER_ID])));
    }

    /**
     * 校验语音房间状态
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think
     */
    public function checkVoiceRoomState(){
        return json(VendorService::checkVoiceRoomState(array_merge(Request::post(),['user_id'=>USER_ID])));
    }

    /**
     * 发送加入房间成功消息
     */
    public function setVoiceRoomMsg(){
        return json(VendorService::setVoiceRoomMsg(array_merge(Request::post(),['user_id'=>USER_ID])));
    }

    /**
     * 成员加入
     * @return \think\response\Json
     */
    public function memberjoinVoiceRoom(){
        return json(VendorService::memberjoinVoiceRoom(array_merge(Request::post(),['user_id'=>USER_ID])));
    }

    /**
     * 设置群成员上麦
     * @return \think\response\Json
     */
    public function setShangmai(){
        return json(VendorService::setShangmai(array_merge(Request::post(),['user_id'=>USER_ID])));
    }
}