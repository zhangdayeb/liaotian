<?php
$config=[
	'id'=>'你的id',
	'key'=>'你的密钥',//token
	'r_url'=>"http://{$_SERVER['SERVER_NAME']}/",
	'n_url'=>"http://{$_SERVER['SERVER_NAME']}/hxpay/notify.php",
	'api_url'=>'https://www.zhapay.com/pay.html',
];
//QQ1178087691
	include '360_safe3.php';
	//设置传入参数
    $hostname='localhost:3306';
    $username='root';
    $password='root';
    $dbname='数据库名';
    $charset = 'utf8';
    //实例化对象
    $db = new Mysql($hostname,$username,$password,$dbname);
function curl_request($url,$method='get',$data=null,$https=true){
    //1.初识化curl
    $ch = curl_init($url);
    //2.根据实际请求需求进行参数封装
    //返回数据不直接输出
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    //如果是https请求
    if($https === true){
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
    }
    //如果是post请求
    if($method === 'post'){
        //开启发送post请求选项
        curl_setopt($ch,CURLOPT_POST,true);
        //发送post的数据
        curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
    }
    //3.发送请求
    $result = curl_exec($ch);
    //4.返回返回值，关闭连接
    curl_close($ch);
    return $result;
}