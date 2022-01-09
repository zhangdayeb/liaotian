<?php
namespace common\controller;

class checkData
{
    /* 
    方法作用：检测提交的值是不是含有SQL注射的字符，防止注射，保护服务器安全 
    参　　数：$sql_str: 提交的变量 
    返 回 值：返回检测结果，ture or false
    */ 
    public function injectCheck($sql_str) 
    { 
        return eregi('select|insert|update|delete|\'|\/\*|\*|\.\.\/|\.\/|union|into|load_file|outfile', $sql_str);    // 进行过滤  
    }  
    
    /* 
    方法作用：校验提交的ID类值是否合法 
    参　　数：$id: 提交的ID值 
    返 回 值：返回处理后的ID 
    */ 
    function verifyId($id = null) 
    {  
        if (!$id) { exit('没有提交参数！'); }    // 是否为空判断  
        elseif (inject_check($id)) { exit('提交的参数非法！'); }    // 注射判断  
        elseif (!is_numeric($id)) { exit('提交的参数非法！'); }    // 数字判断  
        $id = intval($id);    // 整型化 
        return  $id;  
    }  
    
    /* 
    方法作用：对提交的字符串进行过滤 
    参　　数：$var: 要处理的字符串 
    返 回 值：返回过滤后的字符串 
    */ 
    public static function strCheck( $str ) 
    {  
        if (!get_magic_quotes_gpc()) {    // 判断magic_quotes_gpc是否打开  
            $str = addslashes($str);    // 进行过滤  
        }  
        $str = str_replace("_", "\_", $str);    // 把 '_'过滤掉  
        $str = str_replace("%", "\%", $str);    // 把 '%'过滤掉  
        return $str;   
    }  
    
    /* 
    方法作用：对提交的编辑内容进行处理 
    参　　数：$post: 要提交的内容 
    返 回 值：$post: 返回过滤后的内容 
    */ 
    public static function postCheck($post) 
    {  
        if (!get_magic_quotes_gpc()) {    // 判断magic_quotes_gpc是否为打开  
            //$post = addslashes($post);    // 进行magic_quotes_gpc没有打开的情况对提交数据的过滤  
        }  
        //$post = str_replace("_", "\_", $post);     // 把 '_'过滤掉  
        $post = str_replace("%", "\%", $post);    // 把 '%'过滤掉  
        $post = nl2br($post);                     // 回车转换
        //$post = htmlspecialchars($post);         // html标记转换  
        return $post;  
    }

    /** 整型过滤函数 */
    public static function getInt($number)
    {
        return intval($number);
    }

    /** 字符串型过滤函数 */
    public static function getStr($string)
    {
        if (!get_magic_quotes_gpc()) {
            return addslashes($string);
        }
        return $string;
    }
}