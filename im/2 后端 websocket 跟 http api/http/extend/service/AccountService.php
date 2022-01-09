<?php
/**
 * Created by IntelliJ IDEA.
 * User: Administrator
 * Date: 2020-08-02
 * Time: 17:27
 */

namespace extend\service;


use app\im\model\mysql\CapitalLog;
use app\im\model\mysql\User;

class AccountService
{
    public static function doMoney(array $params)
    {
          $type = $params['type'];
            //加钱
            User::startTrans();
            if($type == 1) $ret1 = User::where(['id' => $params['user_id']])
                ->setInc('money', $params['amount']);
            else $ret1 = User::where(['id' => $params['user_id']])
                ->setDec('money', $params['amount']);

            $user_info = UserService::getUserInfo($params['user_id']);
            try {
                $ret2 = CapitalLog::create([
                    'user_id'=>$params['user_id'],
                    'money'=>$params['amount'],
                    'user_money'=>$user_info['money'],
                    'explain'=>$params['remark'],
                    'capital_type'=>$params['capital_type'],
                    'record_type'=>$type == 1 ? 1 :0
                ]);
                if($ret1 === false)throw new Exception('操作失败!');
                if($ret2 === false)throw new Exception('操作失败!');
            } catch (\Exception $e) {
                User::rollback();
                return json(JsonDataService::fail($e->getMessage()));
            }
              User::commit();
        MsgService::senNormalMsgToUid($params['user_id'],'payAmount',$user_info);
        return JsonDataService::success();
    }
}