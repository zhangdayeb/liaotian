<?php
namespace common\controller;

class Config
{
    public static $gateWayPort = '8383';
    public static $registerPort = '1236';
    
    /** 获取本机ip */
    public static function getLocalIP() {
        return "45.153.129.26";
        // $preg = "/\A((([0-9]?[0-9])|(1[0-9]{2})|(2[0-4][0-9])|(25[0-5]))\.){3}(([0-9]?[0-9])|(1[0-9]{2})|(2[0-4][0-9])|(25[0-5]))\Z/";
        // exec("ipconfig", $out, $stats);
        // if (!empty($out)) {
        //     foreach ($out AS $row) {
        //         if (strstr($row, "IP") && strstr($row, ":") && !strstr($row, "IPv6")) {
        //             $tmpIp = explode(":", $row);
        //             if (preg_match($preg, trim($tmpIp[1]))) {
        //                 return trim($tmpIp[1]);
        //             }
        //         }
        //     }
        // }
    }
}
