<?php
/**
 * Created by IntelliJ IDEA.
 * User: Administrator
 * Date: 2020/9/25 0025
 * Time: 17:12
 */

namespace extend\service;


use extend\sdk\upload\LocalUploader;

class UploadService
{
    /**
     * 上传
     */
    public static function upload($params){
        $path = BASE_PATH.'/uploads/' . date('Y-m-d').'/';
        $config = array(
            "maxSize" => 1000 ,                   //允许的文件最大尺寸，单位KB
            "allowFiles" => array( ".gif" , ".png" , ".jpg" , ".jpeg" , ".bmp" )  //允许的文件格式
        );
        //背景保存在临时目录中
        $config[ "savePath" ] = $path;
        $name = isset($_FILES['file']) ? 'file'  : 'upfile';
        $up = new LocalUploader( $name , $config );
        $ret =  $up->getFileInfo();
        $ret['url'] = str_replace(BASE_PATH,'',$ret['url']);
        exit(json_encode($ret));
    }
}