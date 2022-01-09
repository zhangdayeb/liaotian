<?php
/**
 * Created by IntelliJ IDEA.
 * User: Administrator
 * Date: 2020-06-26
 * Time: 22:24
 */

namespace extend\service;


use app\im\model\mongo\ChatList;

class ChatListService
{
    /**
     * 获取chatlist
     */
    public static function getChatListByListId($list_id){
        return ChatList::field('id,type,status,user_ids')->where('list_id', $list_id)->find();
    }
}