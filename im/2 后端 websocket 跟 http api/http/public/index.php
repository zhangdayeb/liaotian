<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// [ 应用入口文件 ]
namespace think;

// 定义应用目录
define('BASE_PATH', __DIR__ );
define('APP_PATH', __DIR__ . '/../app/');
define('VENDOR_PATH', __DIR__.'/../vendor/');
define('PHOTO_PATH', __DIR__.'/static/photo/');
define('CHAT_PATH', __DIR__.'/static/chat/');
define('PHOTO_USER_PATH', __DIR__.'/static/photo/user/');
define('PHOTO_GROUP_PATH', __DIR__.'/static/photo/group_photo/');

define('ALIPAYMENT_LOG', __DIR__.'/../paymet_log/ali.log');
define('WEICHAT_LOG', __DIR__.'/../paymet_log/weicht.log');

define('ORIGINARR',[
    'https://im.smiaoshen.com',
    'https://m-im.smiaoshen.com'
]);

setheader();
// 加载基础文件
require __DIR__ . '/../thinkphp/base.php';

function setheader()
{
    // 获取当前跨域域名
    $origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '';
    if (in_array($origin, ORIGINARR)) {
        // 允许 $originarr 数组内的 域名跨域访问
        header('Access-Control-Allow-Origin:' . $origin);
        // 响应类型
        header('Access-Control-Allow-Methods:POST,GET');
        // 带 cookie 的跨域访问
        header('Access-Control-Allow-Credentials: true');
        // 响应头设置
        header('Access-Control-Allow-Headers:x-requested-with,Content-Type,X-CSRF-Token');
    }
}
// 支持事先使用静态方法设置Request对象和Config对象

// 执行应用并响应
Container::get('app')->path(APP_PATH)->run()->send();
