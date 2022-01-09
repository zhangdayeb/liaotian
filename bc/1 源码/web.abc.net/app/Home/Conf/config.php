<?php
define('STYLE_PATH','./resources'); 

return array(
    //'URL_CASE_INSENSITIVE' => true,
	'DEFAULT_FILTER'         =>  'trim,strip_tags,stripslashes',
	'VIEW_PATH'              =>  './resources/',
	//'THEME_LIST'             =>  'default,resources',
	//'DEFAULT_THEME'          =>  'resources',
	'THEME_LIST'             =>  '',
	'DEFAULT_THEME'          =>  '',
	'TMPL_DETECT_THEME'      =>  true,
	'SHOW_PAGE_TRACE'  => false,
	'TMPL_FILE_DEPR'         =>  '_',
	'TMPL_TEMPLATE_SUFFIX'   =>  '.php',
	'TMPL_PARSE_STRING'  =>array(
		'__CSS__' => __ROOT__.'/resources/css',
		'__FACE__' => __ROOT__.'/resources/images/face',
		'__IMG__' => __ROOT__.'/resources/images',
		'__JS__' => __ROOT__.'/resources/js',
		'__CSS2__' => __ROOT__.'/resources/css2',
		'__IMG2__' => __ROOT__.'/resources/images2',
		'__JS2__' => __ROOT__.'/resources/js2',
		'__UPLOADS__' => __ROOT__.'/Uploads',
	),
//	'TMPL_ACTION_ERROR' => 'resources/jump',
//默认成功跳转对应的模板文件
//	'TMPL_ACTION_SUCCESS' => 'resources/jump',
);
