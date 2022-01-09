<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

//cors同源设置(除了第一项，其他都是解决前端框架因为头的问题报错)
header('Access-Control-Allow-Origin: *');
// header('Access-Control-Allow-Methods:OPTIONS, GET, POST');
// header('Access-Control-Allow-Headers:x-requested-with');
// header('Access-Control-Max-Age:86400');
// header('Access-Control-Allow-Credentials:true');
header('Access-Control-Allow-Methods:GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers:x-requested-with,content-type');
header('Access-Control-Allow-Headers:Origin, No-Cache, X-Requested-With, If-Modified-Since, Pragma, Last-Modified, Cache-Control, Expires, Content-Type, X-E4M-With');
// 应用公共文件

function clientOS()
{

    $agent = strtolower($_SERVER['HTTP_USER_AGENT'] ?? 'android');

    if (strpos($agent, 'windows nt')) {
        $platform = 'Windows';
    } elseif (strpos($agent, 'macintosh')) {
        $platform = 'Mac';
    } elseif (strpos($agent, 'ipod')) {
        $platform = 'Ipod';
    } elseif (strpos($agent, 'ipad')) {
        $platform = 'Ipad';
    } elseif (strpos($agent, 'iphone')) {
        $platform = 'IOS';
    } elseif (strpos($agent, 'android')) {
        $platform = 'Android';
    } elseif (strpos($agent, 'unix')) {
        $platform = 'Unix';
    } elseif (strpos($agent, 'linux')) {
        $platform = 'Linux';
    } else {
        $platform = 'Other';
    }

    return $platform;
}

function object_to_array($obj)
{
    $_arr = is_object($obj) ? get_object_vars($obj) : $obj;
    $arr = [];
    foreach ($_arr as $key => $val) {
        $val = (is_array($val) || is_object($val)) ? object_to_array($val) : $val;
        $arr[$key] = $val;
    }
    return $arr;
}

function time_diff($time)
{
    $timediff = time() - $time;
    $remain = $timediff % 86400;
    $hours = intval($remain / 3600);
    //计算分钟数
    $remain = $remain % 3600;
    $mins = intval($remain / 60);
    //计算秒数
    $secs = $remain % 60;
    //$res = array("day" => $days,"hour" => $hours,"min" => $mins,"sec" => $secs);
    if ($hours) {
        $hours = "{$hours}时";
    } else {
        $hours = '';
    }
    if ($mins) {
        $mins = "{$mins}分";
    } else {
        $mins = '';
    }
    if ($secs) {
        $secs = "{$secs}秒";
    } else {
        $secs = '';
    }
    return $hours . $mins . $secs;
}

function create_password($pwd)
{
    return password_hash($pwd, PASSWORD_DEFAULT);
}

function check_password($input, $db_password)
{
    return password_verify($input, $db_password);
}

//生成唯一用户标识id
function create_guid()
{
    $charid = strtoupper(md5(uniqid(mt_rand(), true)));
    $uuid = substr($charid, 0, 8)
        . substr($charid, 8, 4)
        . substr($charid, 12, 4)
        . substr($charid, 16, 4)
        . substr($charid, 20, 12);
    return $uuid;
}


/** 获得显示的头像 */
function getShowPhoto($user_state_obj, $sex, $user_id, $size)
{

    if ($user_state_obj && isset($user_state_obj->photo) && $user_state_obj->photo) {
        $photo_path = 'user/' . $user_id . '/' . $size . '.jpg';
    } else {
        if ($sex) {
            $photo_path = 'default_woman/' . $size . '.jpg';
        } else {
            $photo_path = 'default_man/' . $size . '.jpg';
        }
    }
    return $photo_path;
}

/**
 * 合成图片
 * @param array $pic_list [图片列表数组]
 * @param boolean $is_save [是否保存，true保存，false输出到浏览器]
 * @param string $save_path [保存路径]
 * @return boolean|string
 */
function getGroupAvatar($pic_list = array(), $is_save = false, $save_path = '')
{
    //验证参数
    if (empty($pic_list) || empty($save_path)) {
        return false;
    }
    if ($is_save) {
        //如果需要保存，需要传保存地址
        if (empty($save_path)) {
            return false;
        }
    }
    // 只操作前9个图片
    $pic_list = array_slice($pic_list, 0, 9);
    //设置背景图片宽高
    $bg_w = 150; // 背景图片宽度
    $bg_h = 150; // 背景图片高度
    //新建一个真彩色图像作为背景
    $background = imagecreatetruecolor($bg_w, $bg_h);
    //为真彩色画布创建白灰色背景，再设置为透明
    $color = imagecolorallocate($background, 202, 201, 201);
    imagefill($background, 0, 0, $color);
    imageColorTransparent($background, $color);
    //根据图片个数设置图片位置
    $pic_count = count($pic_list);
    $lineArr = array();//需要换行的位置
    $space_x = 3;
    $space_y = 3;
    $line_x = 0;
    switch ($pic_count) {
        case 1: // 正中间
            $start_x = intval($bg_w / 4); // 开始位置X
            $start_y = intval($bg_h / 4); // 开始位置Y
            $pic_w = intval($bg_w / 2); // 宽度
            $pic_h = intval($bg_h / 2); // 高度
            break;
        case 2: // 中间位置并排
            $start_x = 2;
            $start_y = intval($bg_h / 4) + 3;
            $pic_w = intval($bg_w / 2) - 5;
            $pic_h = intval($bg_h / 2) - 5;
            $space_x = 5;
            break;
        case 3:
            $start_x = 40; // 开始位置X
            $start_y = 5; // 开始位置Y
            $pic_w = intval($bg_w / 2) - 5; // 宽度
            $pic_h = intval($bg_h / 2) - 5; // 高度
            $lineArr = array(2);
            $line_x = 4;
            break;
        case 4:
            $start_x = 4; // 开始位置X
            $start_y = 5; // 开始位置Y
            $pic_w = intval($bg_w / 2) - 5; // 宽度
            $pic_h = intval($bg_h / 2) - 5; // 高度
            $lineArr = array(3);
            $line_x = 4;
            break;
        case 5:
            $start_x = 30; // 开始位置X
            $start_y = 30; // 开始位置Y
            $pic_w = intval($bg_w / 3) - 5; // 宽度
            $pic_h = intval($bg_h / 3) - 5; // 高度
            $lineArr = array(3);
            $line_x = 5;
            break;
        case 6:
            $start_x = 5; // 开始位置X
            $start_y = 30; // 开始位置Y
            $pic_w = intval($bg_w / 3) - 5; // 宽度
            $pic_h = intval($bg_h / 3) - 5; // 高度
            $lineArr = array(4);
            $line_x = 5;
            break;
        case 7:
            $start_x = 53; // 开始位置X
            $start_y = 5; // 开始位置Y
            $pic_w = intval($bg_w / 3) - 5; // 宽度
            $pic_h = intval($bg_h / 3) - 5; // 高度
            $lineArr = array(2, 5);
            $line_x = 5;
            break;
        case 8:
            $start_x = 30; // 开始位置X
            $start_y = 5; // 开始位置Y
            $pic_w = intval($bg_w / 3) - 5; // 宽度
            $pic_h = intval($bg_h / 3) - 5; // 高度
            $lineArr = array(3, 6);
            $line_x = 5;
            break;
        case 9:
            $start_x = 5; // 开始位置X
            $start_y = 5; // 开始位置Y
            $pic_w = intval($bg_w / 3) - 5; // 宽度
            $pic_h = intval($bg_h / 3) - 5; // 高度
            $lineArr = array(4, 7);
            $line_x = 5;
            break;
    }
    foreach ($pic_list as $k => $pic_path) {
        $kk = $k + 1;
        if (in_array($kk, $lineArr)) {
            $start_x = $line_x;
            $start_y = $start_y + $pic_h + $space_y;
        }
        //获取图片文件扩展类型和mime类型，判断是否是正常图片文件
        //非正常图片文件，相应位置空着，跳过处理
        $image_mime_info = @getimagesize($pic_path);
        if ($image_mime_info && !empty($image_mime_info['mime'])) {
            $mime_arr = explode('/', $image_mime_info['mime']);
            if (is_array($mime_arr) && $mime_arr[0] == 'image' && !empty($mime_arr[1])) {
                switch ($mime_arr[1]) {
                    case 'jpg':
                    case 'jpeg':
                        $imagecreatefromjpeg = 'imagecreatefromjpeg';
                        break;
                    case 'png':
                        $imagecreatefromjpeg = 'imagecreatefrompng';
                        break;
                    case 'gif':
                    default:
                        $imagecreatefromjpeg = 'imagecreatefromstring';
                        $pic_path = file_get_contents($pic_path);
                        break;
                }
                //创建一个新图像
                $resource = $imagecreatefromjpeg($pic_path);
                //将图像中的一块矩形区域拷贝到另一个背景图像中
                // $start_x,$start_y 放置在背景中的起始位置
                // 0,0 裁剪的源头像的起点位置
                // $pic_w,$pic_h copy后的高度和宽度
                imagecopyresized($background, $resource, $start_x, $start_y, 0, 0, $pic_w, $pic_h, imagesx($resource), imagesy($resource));
            }
        }
        // 最后两个参数为原始图片宽度和高度，倒数两个参数为copy时的图片宽度和高度
        $start_x = $start_x + $pic_w + $space_x;
    }
    if ($is_save) {
        $dir = pathinfo($save_path, PATHINFO_DIRNAME);
        if (!is_dir($dir)) {
            $file_create_res = mkdir($dir, 0777, true);
            if (!$file_create_res) {
                return false;//没有创建成功
            }
        }
        $res = imagejpeg($background, $save_path);
        imagedestroy($background);
        if ($res) {
            return true;
        } else {
            return false;
        }
    } else {
        //直接输出
        header("Content-type: image/jpg");
        imagejpeg($background);
        imagedestroy($background);
    }
}

function getVideoCover($file, $time, $name)
{
    if (empty($time)) $time = '1';//默认截取第一秒第一帧
    $str = "ffmpeg -i " . $file . " -y -f mjpeg -ss 3 -t " . $time . " -s 320x240 " . $name;
    return system($str);
}

function getVideoGif($file, $time, $name, $type = 'gif', $style = '190x190')
{
    if (empty($time)) $time = '3';//默认截取5帧
    $str = "ffmpeg  -t {$time} -i {$file} -s {$style} -f {$type} -r 1 " . $name;
    system($str, $arr);
    while (!file_exists($name)) {
        usleep(300);
    }
    return $arr;
}

//获得视频文件的总长度时间和创建时间
function getTime($file)
{
    $vtime = exec("ffmpeg -i " . $file . " 2>&1 | grep 'Duration' | cut -d ' ' -f 4 | sed s/,//");//总长度
    $ctime = date("Y-m-d H:i:s", filectime($file));//创建时间
    return array('vtime' => $vtime,
        'ctime' => $ctime
    );
}

function strFullTrim($str)
{
    $search = array(" ", "　", "\n", "\r", "\t");
    $replace = array("", "", "", "", "");
    return str_replace($search, $replace, $str);
}

/**
 * 根据金额得到元角分
 * @param  float $amount
 *  [
 *     'y'=>1,
 *     'j'=>5,
 *     'f'=>6
 * ]
 */
if (!function_exists('getJF')) {
    function getJF($amount)
    {
        $amount = sprintf('%.2f', $amount);
        $newsYuanArr = [];
        $newsYuanArr = [
            's' => $amount,
            'y' => intval(mb_substr($amount, -4, 1)),
            'j' => intval(mb_substr($amount, -2, 1)),
            'f' => intval(mb_substr($amount, -1))
        ];
        return $newsYuanArr;
    }
}
//赢得概率
if (!function_exists('getGailv')) {
    function getGailv($ps)
    {
        static $arr = array();
        $key = md5(serialize($ps));
        $z_k = '';
        if (!isset($arr[$key])) {
            $max = array_sum($ps);
            foreach ($ps as $k => $v) {
                //设置为0.01直接返回 判断另一方赢
                if ($v == 0.1) {
                    $z_k = $k;
                    continue;
                }
                $v = $v / $max * 10000;
                for ($i = 0; $i < $v; $i++) $arr[$key][] = $k;
            }
        }
        if (!empty($z_k)) {
            unset($ps[$z_k]);
            return key($ps);
        }

        return $arr[$key][mt_rand(0, count($arr[$key]) - 1)];
    }
}


/**
 * 根据游戏类型创建可运用的游戏红包
 * @param array $redpacket 红包信息
 * @param int $i 递归次数
 * @param int $is_robot 是否是机器人
 */
if (!function_exists('createCanRedPacket')) {
    function createCanRedPacket($redpacket, $i = 0, $is_robot = 0, $rand = 'sys')
    {
        $packet = CreateRedPacket($redpacket['red_amount'], $redpacket['red_nums']);
        # 防止内存益出
        if ($i > 1000)return $packet;
        //机器人踩雷高
        # 单雷 和 多雷 让开奖结果更有机会中雷 防止用户恶意刷红包 提高雷值出现几率
        $lei_array = $redpacket['red_lei'];
//        $rule = getGameRule($redpacket['group_type'], $redpacket);
        $amount = $redpacket['red_amount'];
        $total_lei = count($lei_array);
        # 多雷
        $caiAmount = [];
        $kui = 0;
        foreach ($packet as $uk => $uv) {
            $aArr = getJF($uv);
            if (in_array($aArr['f'],$redpacket['red_lei'])) {
                //将分位重新组成一个新的数组
                $caiAmount[$uk] = $aArr['f'];
                $kui += $amount;
                //如果中雷 则剔除 $tmp_lei_arr 里面对应的值
                $key = array_search((string)$aArr['f'], $lei_array);
                    if ($key !== false) {
                    unset($lei_array[$key]);
                }
            }
        }
        //多雷必须全中
        if (!empty($lei_array)) {
            $kui = 0;
        }
        $rand = getGailv([
            'user' => 1-$redpacket['full_account_rate'],
            'rob' => $redpacket['full_account_rate'] //
        ]);
        //系统用户发包
        if (($is_robot == 1 && !empty($lei_array)) && $rand == 'rob') {
            $i++;
            $packet = createCanRedPacket($redpacket, $i, $is_robot, $rand);
        }

        //玩家发包
        if ($is_robot == 0) {
            //四雷以上保证没人中奖,
            if ($total_lei >= 5) {
                //保证没人中
                if (!empty($caiAmount)) {
                    $i++;
                    $packet = createCanRedPacket($redpacket, $i, $is_robot, $rand);
                }
            } else {
//                $duopool = (new \App\Until\GameCommonFactory())->getGroupTypePool($redpacket['group_type'], 0, 'find');
                #$rand = getGailv((new \App\Until\ProbabilitySum())->getSystemRate($redpacket['user_id']));
                //大于4包的时候，计算用户盈利，如果盈利大于10000则，输钱，
                if ($total_lei < 4 && $i < 900 && ($kui) && !$redpacket['loss']) { //赢面小于1万
                    $rand = getGailv(['user' =>$redpacket['win_amount_rate'], 'sys' => round(1-$redpacket['win_amount_rate'], 2)]);
                    //保证有人中奖
                    if (!empty($lei_array) && $rand == 'user') {
                        $i++;
                        $packet = createCanRedPacket($redpacket, $i, $is_robot, $rand);
                    }
                } else {
                    //保证没人中 让发包者输掉钱
                    if (!empty($caiAmount)) {
                        $i++;
                        $packet = createCanRedPacket($redpacket, $i, $is_robot, $rand);
                    }
                }
            }
        }
        return $packet;
    }
}

/**
 * 创建红包
 */
if (!function_exists("CreateRedPacket")) {
    function CreateRedPacket($total, $num, $min = 0.01)
    {
        $redArr = [];
        for ($i = 1; $i < $num; $i++) {
            $safe_total = ($total - ($num - $i) * $min) / ($num - $i);//随机安全上限
            $money = mt_rand($min * 100, $safe_total * 100) / 100;
            $total = $total - $money;
            array_push($redArr, sprintf('%.2f', round($money, 2)));
        }
        array_push($redArr, sprintf('%.2f', round($total, 2)));
        return $redArr;
    }
}

function get_http_type()
{
    $http_type = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';
    return $http_type;
}


function get_server(){
    return get_http_type().$_SERVER['HTTP_HOST'];
}

function isMobile($mobile){
    if(!preg_match("/^1[3456789]\d{9}$/", $mobile)){
         return false;
    }
    return true;
}

function strHasRepeat($str){
    if(!$str) return false;
    $arr = str_split($str);
    foreach ($arr as $v){
//        if()
        if(mb_substr_count($str,$v) > 1){
            return true;
        }
    }
    return false;
}

function no_repe_number($start=0,$end=9,$len=6){
    $co = 0;
    $arr = $reArr = array();
    while($co<$len){
        $arr[] = mt_rand($start,$end);
        $reArr = array_unique($arr);
        $co = count($reArr);
    }
    return $reArr;
}

/**
 * 格式化文件大小
 * @param $size
 * @return string
 */
function format_file_size($size){
    $units = array('B', 'KB', 'MB', 'GB', 'TB');
    for ($i = 0; $size >= 1024 && $i < 4; $i++){
        $size /= 1024;
    }
    return round($size, 2).$units[$i];
}

/**
 * php计算字节数（含中文）
 * @param $str
 * @param string $charset
 * @return int
 */
function sstrlen($str,$charset = 'utf-8') {
    $n = 0; $p = 0; $c = '';
    $len = strlen($str);
    if($charset == 'utf-8') {
        for($i = 0; $i < $len; $i++) {
            $c = ord($str{$i});
            if($c > 252) {
                $p = 5;
            } elseif($c > 248) {
                $p = 4;
            } elseif($c > 240) {
                $p = 3;
            } elseif($c > 224) {
                $p = 2;
            } elseif($c > 192) {
                $p = 1;
            } else {
                $p = 0;
            }
            $i+=$p;$n++;
        }
    } else {
        for($i = 0; $i < $len; $i++) {
            $c = ord($str{$i});
            if($c > 127) {
                $p = 1;
            } else {
                $p = 0;
            }
            $i+=$p;$n++;
        }
    }
    return $n;
}


/**
 * CURL获取远程图片大小
 * -----------------------------------------------------------------
 */
function remote_filesize($uri,$user='',$pw='')
{
    ob_start();
    $ch = curl_init($uri);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLOPT_NOBODY, 1);
    if (!empty($user) && !empty($pw)) {
        $headers = array('Authorization: Basic ' . base64_encode($user.':'.$pw));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    }
    $okay = curl_exec($ch);
    curl_close($ch);
    $head = ob_get_contents();
    ob_end_clean();
    $regex = '/Content-Length:\s([0-9].+?)\s/';
    $count = preg_match($regex, $head, $matches);
    return isset($matches[1]) ? $matches[1] : 'unknown';
}

/**
 * 获取聊天文件地址
 * @param $path
 */
function get_chat_img($list_id,$path){
 return  get_server().'/static/chat/'.$list_id.'/'.$path;
}


function copyResource($sourcefile, $dir,$filename){
     if( ! file_exists($sourcefile)){
         return false;
     }
     return copy($sourcefile, $dir . $filename);
}

