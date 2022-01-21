<?php
// 应用公共文件


/**
 * 密码加密
 * @param $pwd
 */
function pwdMd5($pwd)
{
    if (empty($pwd)) return false;
    return md5($pwd);
}

/*
 * 处理图片
 */
function fullurl($image){
    if(empty($image)){
        return '';
    }
    return env('api_url').$image;
}

/*
 * 处理图片
 */
function getImage($image){
    if(empty($image)){
        return '';
    }
    return '/uploads'.explode('uploads',$image)[1];
}

/*
 * 请求返回成功
*/
function jsonSuccess($data = NULL, $message = '操作成功')
{
    header('Access-Control-Allow-Origin:*');
    $json = array ();
    $json['code'] = 1;
    $json['data'] = $data;
    $json['msg'] = $message;
    $json['request_time'] = date('Y-m-d H:i:s');
    echo json_encode($json);
    exit();
}

/**
 * 错误信息
 * @example1 jsonFail();
 * @example1 jsonFail("删除失败！");
 * @example2 jsonFail($model->getErrors());
 */
function jsonFail($message = '请求失败', $code = 0, $data = null)
{
    header('Access-Control-Allow-Origin:*');
    $json = array ();
    $json['code'] = $code;
    $json['data'] = $data;
    $json['msg'] = $message;
    $json['request_time'] = date('Y-m-d H:i:s');
    echo json_encode($json);
    exit();
}

//金额数量，只保留小数点后两位
function getDecimalNum($num){

    $arr = explode('.',$num);
    if (count($arr) == 1) {
        return $arr[0];
    }
    return $arr[0].'.'.substr($arr[1],0,2);
}

function api_token($id)
{
    return md5($id . 'api' . date('Y-m-d H:i:s', time()) . 'token');
}

/*
 * 处理传入的数据
 */
function getData($post,$filed){
    $filed_arr = explode(',',$filed);
    $data = [];
    foreach ($filed_arr as $item){
        if(isset($post[$item])){
            $data[$item] = $post[$item];
        }else{
            $data[$item] = '';
        }
    }
    return $data;
}

//生成随机字符串
function generateStr($length = 6, $char = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ') {
    if(!is_int($length) || $length < 0) return false;
    $string = '';
    for($i = $length; $i > 0; $i--) {
        $string .= $char[mt_rand(0, strlen($char) - 1)];
    }
    return $string;
}

/*
 * 检测是否是电话号码
 */
function isCellphone($str){
    return preg_match ( "/^1\d{10}$/i", $str);
}

//生成手机验证码
function generateCode($length = 6) {
    return rand(pow(10,($length-1)), pow(10,$length)-1);
}

/*
 * 获取总数据条数
 */
function getAllPage($count){
    return intval($count);
}

/*
 * 获取订单编号
 */
function getNewOrderNumber(){
    $time = date('Y-m-d H:i:s');
    return substr(str_replace(' ','',str_replace(':','',str_replace('-','',$time))).rand(100,999),2);
}

/**
 * POST远程网页内容
 * @param unknown $url
 * @param unknown $post_data =>  array ("username" => "bob","key" => "12345")
 */
function postData($url, $post_data) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    // post数据
    curl_setopt($ch, CURLOPT_POST, 1);
    // post的变量
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    $output = curl_exec($ch);
    curl_close($ch);
    //打印获得的数据
    return $output;
}

/*
 * 处理级联时候的城市数据
 */
 function checkCityConfigArr($arr){
    if(empty($arr)){
        return [];
    }
    $arr = json_decode($arr);
    if(count($arr) <= 0){
        return [];
    }
    $data = [];
    foreach ($arr as $a){
        $data[] = intval($a);
    }
    return $data;
}

/**
把用户输入的文本转义（主要针对特殊符号和emoji表情）
 */
function userTextEncode($str){
    if(!is_string($str))return $str;
    if(!$str || $str=='undefined')return '';

    $text = json_encode($str); //暴露出unicode
    $text = preg_replace_callback("/(\\\u[ed][0-9a-f]{3})/i",function($str){
        return addslashes($str[0]);
    },$text); //将emoji的unicode留下，其他不动，这里的正则比原答案增加了d，因为我发现我很多emoji实际上是\ud开头的，反而暂时没发现有\ue开头。
    return json_decode($text);
}
/**
解码上面的转义
 */
function userTextDecode($str){
    $text = json_encode($str); //暴露出unicode
    $text = preg_replace_callback('/\\\\\\\\/i',function($str){
        return '\\';
    },$text); //将两条斜杠变成一条，其他不动
    return json_decode($text);
}

/*
 * 处理图片数组[用于返回]
 */
function fullurlList($imageList): array{
    if(!empty($imageList)) {
        $imageList = explode('[]',$imageList);
        $imageArr = [];
        foreach ($imageList as $image) {
            $imageArr[] = fullurl($image);
        }
        return $imageArr;
    }
    return [];
}

/*
 *处理图片数组[用于存储数据库]
 */
function getImageListToStr($imageList): string{
    if(!empty($imageList) && count($imageList) > 0) {
        $imageArr = [];
        foreach ($imageList as $image) {
            $imageArr[] = getImage($image);
        }
        return implode('[]',$imageArr);
    }
    return '';
}

/*
 *处理图片数组[用于存储数据库]，针对Element
 */
function getImageListElementToStr($imageList): string{
    if(!empty($imageList) && count($imageList) > 0) {
        $imageArr = [];
        foreach ($imageList as $item) {
            $imageArr[] = getImage($item['url']);
        }
        return implode('[]',$imageArr);
    }
    return '';
}

/*
 * 富文本存储，需要把域名替换下
 */
function saveEditor($content){
    return str_replace(env('api_url'),'/',$content);
}

/*
 * 富文本返回，需要把域名加上
 */
function returnEditor($content){
    return str_replace('/uploads/file/',env('api_url').'uploads/file/',$content);
}

/*
 * 判断是否加载完数据
 */
function getIsLoad($num,$pageSize){
    if($num < $pageSize){
        return 0;
    }else{
        return 1;
    }
}

/**
 * 获取客户端IP地址
 * @return string
 */
function get_server_ip() {
    if (isset($_SERVER)) {
        if($_SERVER['SERVER_ADDR']) {
            $server_ip = $_SERVER['SERVER_ADDR'];
        } else {
            $server_ip = $_SERVER['LOCAL_ADDR'];
        }
    } else {
        $server_ip = getenv('SERVER_ADDR');
    }
    return $server_ip;
}

/**
 * 获取两个坐标点之间的距离，单位km，小数点后2位
 */
function getSquarePointDistance($lng1,$lat1,$lng2,$lat2)
{
    $EARTH_RADIUS = 6378.137;
    $radLat1 = rad($lat1);
    $radLat2 = rad($lat2);
    $a = $radLat1 - $radLat2;
    $b = rad($lng1) - rad($lng2);
    $s = 2 * asin(sqrt(pow(sin($a/2),2) + cos($radLat1)*cos($radLat2)*pow(sin($b/2),2)));
    $s = $s * $EARTH_RADIUS;
    $s = round($s * 100) / 100 / 1000;
    //$s = $s*1000;	//米  为单位
    return getDecimalNum($s);
}

/**
 * 得到半径
 * @param unknown $d
 */
function rad($d)
{
    return $d * M_PI / 180.0;
}

//隐藏手机号，加*方式
function markMobile($mobile){
    return substr($mobile, 0, 3).'****'.substr($mobile, -4);
}

//比较两个内容的差集，并想git history那样显示
function diff($str1,$str2) {

    require_once $_SERVER["DOCUMENT_ROOT"].'/../extend/Diff.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/../extend/Diff/Renderer/Html/SideBySide.php';

    $a = explode("\n", $str1);
    $b = explode("\n", $str2);

    $options = array(
        //'ignoreWhitespace' => true,
        //'ignoreCase' => true,
    );
    $diff = new \Diff($a, $b, $options);

    $renderer = new \Diff_Renderer_Html_SideBySide;
    return $diff->Render($renderer);
}

//将图片处理成圆形
function imageRadis($avatar_url){
    $uploadDir = $_SERVER['DOCUMENT_ROOT'].'/../public/uploads/temp/';
    if (!file_exists($uploadDir)) {
        @mkdir($uploadDir);
    }
    list ($avatarImageWidth, $avatarImageHeight) = getimagesize ($avatar_url);
    $avatar = imagecreatefrompng($avatar_url);
    if(!$avatar){
        $avatar = imagecreatefromjpeg($avatar_url);
    }
    $avatarNewImage = imagecreatetruecolor(98, 98);
    imagecopyresampled($avatarNewImage, $avatar, 0, 0, 0, 0, 98, 98, intval($avatarImageWidth), intval($avatarImageHeight));
    imagejpeg($avatarNewImage, $uploadDir.'1.png');

    $w = 98;
    $h = 98;
    $src = imagecreatefromstring(file_get_contents($uploadDir.'1.png'));
    $newpic = imagecreatetruecolor($w,$h);
    imagealphablending($newpic,false);
    $transparent = imagecolorallocatealpha($newpic, 0, 0, 0, 127);
    $r=$w/2;
    for($x=0;$x<$w;$x++)
        for($y=0;$y<$h;$y++){
            $c = imagecolorat($src,$x,$y);
            $_x = $x - $w/2;
            $_y = $y - $h/2;
            if((($_x*$_x) + ($_y*$_y)) < ($r*$r)){
                imagesetpixel($newpic,$x,$y,$c);
            }else{
                imagesetpixel($newpic,$x,$y,$transparent);
            }
        }
    imagesavealpha($newpic, true);
    imagepng($newpic, $uploadDir.'1.png');
    imagedestroy($newpic);
    imagedestroy($src);
    // unlink($url);
    return $uploadDir.'1.png';
}