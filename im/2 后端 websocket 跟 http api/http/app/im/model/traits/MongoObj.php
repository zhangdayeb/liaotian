<?php
/**
 * Created by IntelliJ IDEA.
 * User: Administrator
 * Date: 2020-06-25
 * Time: 17:19
 */

namespace app\im\model\traits;


use MongoDB\Collection;
use MongoDB\Driver\BulkWrite;
use MongoDB\Driver\Manager;


class MongoObj
{
    protected $config = null;
    protected $writer = null;
    protected $database ='';
    protected $table = '';
    //单例模式
    static protected $_instance;
    static protected $_writer_instance;
    static protected $_table_instance = [];
    public function __construct($table="")
    {
        $config = config('database.mongo');
        $table = $config['prefix'].$table;
        $uri = $config['hostname'].':'.$config['hostport'];
        $this->config = $config;
        $this->table = $table;
        $this->database = $config['database'];
        $this->prefix = $config['prefix'];
        $xie_yi = "mongodb://";
        if($this->config['username'])$uri =$xie_yi.$config['username'].':'.$config['password'].'@'.$uri;
    }

    /**
     * @param $table
     * @return MongoObj
     */
    public static function init($table){
        $model = (new self());
        $config = config('database.mongo');
        $uri = $config['hostname'].':'.$config['hostport'];
        $xie_yi = "mongodb://";
        $uri = $xie_yi.$uri;
        $table = $config['prefix'].$table;
        if($config['username'])$uri =$xie_yi.$config['username'].':'.$config['password'].'@'.$uri;
        $model->config = $config;
        $model->database = $config['database'];
        $model->table = $table;
        $model->prefix = $config['prefix'];
        //判断$_instance是否是Singleton的对象，不是则创建
        if (!self::$_instance instanceof Manager) {
            self::$_instance = new  Manager($uri);
        }
        //Collection
        if (!isset(self::$_table_instance[$table]) || !self::$_table_instance[$table] instanceof Collection) {
            self::$_table_instance[$table] = new  Collection(self::$_instance,$config['database'],$table);
        }

        return  self::$_table_instance[$table];
    }

    public  function where($params){

    }


}