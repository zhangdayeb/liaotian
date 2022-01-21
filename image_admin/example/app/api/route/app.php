<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\facade\Route;

/*
 * 业务前端路由开始
 */

Route::rule('home/cityList', 'Home/cityList');//获取城市列表
Route::rule('home/beautifulList', 'Home/beautifulList');//获取选美列表
Route::rule('home/videoTypeList', 'Home/videoTypeList');//获取视频分类列表
Route::rule('home/videoList', 'Home/videoList');//获取视频列表
Route::rule('home/videoDetail', 'Home/videoDetail');
Route::rule('home/notice', 'Home/notice');//公告

/*
 * 业务前端路由结束
 */

