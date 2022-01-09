<?php
/**
 * Created by IntelliJ IDEA.
 * User: Administrator
 * Date: 2020-06-12
 * Time: 16:32
 */

namespace extend\service;


class ConfigService
{
    const HONGBAO_NORMAL = "HONGBAO:NORMAL:"; //普通红包
    const HONGBAO_BEST = "HONGBAO:BEST:";     //拼手气红包
    const HONGBAO_FAST_SEND_KEY = "HONGBAO:SEND:KEY:";//红包防止连点key
    const NALMAL_FAST_SEND_KEY = "NALMAL:SEND:KEY:";//红包防止连点key
    const NALMAL_FAST_ADMIN_SEND_KEY = "NALMAL:ADMIN:SEND:KEY:";//红包防止连点key
    const VEDIO_START_TIME = 'VEDIO:STARTTIME:';
    const VEDIO_FAST_CLICK = 'VEDIO:FAST_CLICK:';
    const HONGBAO_BESY_PAKAGE = 'HONGBA:BESY:PAKAGE:';//最大的包
    const CLIENT_OFFLINE_LIST = 'CLIENT:OFFLINE:LIST:'; //

    const QUEUE_PUSH_TASK = 'app\\job\\PushJob'; //推送任务
    const QUEUE_ADD_FRIENDS_TASK = 'app\\job\\UserJob'; //注册好友任务
    const QUEUE_AFTER_LEIHONGBAO = 'app\\job\\HongBaoJob'; //注册好友任务
    const QUEUE_HONGBAO_GET_AUTO = 'app\\job\\RototHongBaoJob'; //注册好友任务
    const QUEUE_QUN_AUTO_REPLAY = 'app\\job\\GroupJob'; //注册好友任务

    const QUEUE_PUSH_TASK_NAME = 'pushTask';    //推送任务
    const VIDEO_CALL_ROOM = 'VIDEO:CALL:ROOM:';
    const VIDEO_CALL_PAY = 'VIDEO:CALL:PAY:';

    const SMS_CODE = 'SMS:CODE:';

    //红包雷
    const HONGBAO_LEI_WIN  = 'HONGBAO:LEI:WIN:'; //红包赢队列
    const HONGBAO_LEI_LOSS  = 'HONGBAO:LEI:LOSS:'; //红包赢队列
    const HONGBAO_AUTO_GET  = 'HONGBAO:AUTO:GET:'; //自动抢包开关

    const TENDENCE_VOICE_ROOMID = 'TENDENCE:VOICE:ROOMID';//房间ID

    const JOINVOICEROOM = 'JOIN:VOICE:ROOM:FAST:';  //抢麦
}