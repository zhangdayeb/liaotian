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
 * 权限路由开始
 */
Route::rule('admin/list', 'CommonAdmin/list');
Route::rule('admin/edit', 'CommonAdmin/edit');
Route::rule('admin/delete', 'CommonAdmin/delete');

#
Route::rule('route/list', 'CommonRoute/list');
Route::rule('route/edit', 'CommonRoute/edit');
Route::rule('route/delete', 'CommonRoute/delete');

Route::rule('auth/list', 'CommonAuth/list');
Route::rule('auth/edit', 'CommonAuth/edit');
Route::rule('auth/delete', 'CommonAuth/delete');

Route::rule('login/login', 'Login/login');
Route::rule('login/captcha', 'Login/captcha');
Route::rule('login/load', 'Login/loadAdmin');

Route::rule('city-config/listAll', 'CommonCityConfig/listAll');
Route::rule('city-config/list', 'CommonCityConfig/list');

Route::rule('role/listAll', 'CommonRole/listAll');
Route::rule('role/list', 'CommonRole/list');
Route::rule('role/edit', 'CommonRole/edit');
Route::rule('role/delete', 'CommonRole/delete');

Route::rule('menu/listAll', 'CommonMenu/listAll');
Route::rule('menu/list', 'CommonMenu/list');
Route::rule('menu/edit', 'CommonMenu/edit');
Route::rule('menu/delete', 'CommonMenu/delete');
Route::rule('menu/parentList', 'CommonMenu/parentList');
/*
 * 权限路由结束
 */

//-------------------------------------------------------------------------------------------
/*
 * 业务后台路由开始
 */

Route::rule('uploadCommon/excelTemp', 'YwCommon/excelTemp');
Route::rule('uploadCommon/uploadImage', 'YwCommon/uploadImage');
Route::rule('uploadCommon/uploadImageOss', 'YwCommon/uploadImageOss');


Route::rule('beautiful/list', 'YwBeautiful/list');
Route::rule('beautiful/edit', 'YwBeautiful/edit');
Route::rule('beautiful/delete', 'YwBeautiful/delete');

Route::rule('video-type/list', 'YwVideoType/list');
Route::rule('video-type/edit', 'YwVideoType/edit');
Route::rule('video-type/delete', 'YwVideoType/delete');
Route::rule('video-type/listAll', 'YwVideoType/listAll');

Route::rule('video/list', 'YwVideo/list');
Route::rule('video/edit', 'YwVideo/edit');
Route::rule('video/delete', 'YwVideo/delete');

Route::rule('city/list', 'YwCity/list');
Route::rule('city/edit', 'YwCity/edit');
Route::rule('city/delete', 'YwCity/delete');
Route::rule('city/listAll', 'YwCity/listAll');

Route::rule('notice/list', 'YwNotice/list');
Route::rule('notice/edit', 'YwNotice/edit');

/*
 * 业务后台路由结束
 */

