<?php
namespace App\Xnw;

class Config {
    //必须有， 自动错误日志文件需要
    const PROJECT_NAME = 'XiaoNeiWai';
    const PROMPT_TITLE = '校内外提示你';

    const GROUP_CONCAT_SQL = 'SET SESSION group_concat_max_len = 3600000';  #group_concat 最大长度


    const DB_ADMIN = 'dbadmin';

    const DB_WEIBO_SEARCH = 'weibosearchdb';

    const DB_KPI_WEIBO_R = 'kpi_weibor';

    const DB_ADMIN_R = 'adminr';
    const DB_ADMIN_W = 'adminw';

    const DB_WEIBO_R = 'weibor';
    const DB_WEIBO_W = 'weibow';

    const DB_PAYR_R = 'payr';
    const DB_PAYR_W = 'payw';

    const DB_TONGJI = 'tongji';

    const DB_JUREN = 'juren';

    const DB_OAUTH_SERVER_W = 'oauth_serverw';
    const DB_OAUTH_SERVER_R = 'oauth_serverr';

    /**
     * db server param
     */
    public static $db = array(
        self::DB_JUREN => array (
            'host' => XNW_DB_ADMIN_SERVER,
            'port' => XNW_DB_ADMIN_SERVER_PORT,
            'dbname' => 'juren',
            'username' => 'dbr',
            'password' => 'ls8nXZ2R',
            'driver_options' => array(
                PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
                PDO::ATTR_EMULATE_PREPARES => true,
            ),
        ),
        self::DB_ADMIN => array (
            'host' => XNW_DB_ADMIN_SERVER,
            'port' => XNW_DB_ADMIN_SERVER_PORT,
            'dbname' => 'y123_admin',
            'username' => 'dbw',
            'password' => 'IuEbZ8JV',
            'driver_options' => array(
                PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
                PDO::ATTR_EMULATE_PREPARES => true,
            ),
        ),
        self::DB_WEIBO_SEARCH => array (
            'host' => XNW_SPHINX_SERVER,
            'port' => XNW_SPHINX_SERVER_PORT,
        ),
        self::DB_KPI_WEIBO_R => array (
            'host' => XNW_DB_KPI_WEIBOR_SERVER,
            'port' => XNW_DB_KPI_WEIBOR_SERVER_PORT,
            'dbname' => XNW_WEIBO_DATABASE_NAME,
            'username' => 'dbr',
            'password' => 'ls8nXZ2R',
            'driver_options' => array(
                PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
                PDO::ATTR_EMULATE_PREPARES => true,
            ),
        ),
        self::DB_ADMIN_R => array (
            'host' => XNW_DB_WEIBOR_SERVER,
            'port' => XNW_DB_WEIBOR_SERVER_PORT,
            'dbname' => 'admin',
            'username' => 'dbr',
            'password' => 'ls8nXZ2R',
            'driver_options' => array(
                PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
                PDO::ATTR_EMULATE_PREPARES => true,
            ),
        ),
        self::DB_ADMIN_W => array (
            'host' => XNW_DB_WEIBOW_SERVER,
            'port' => XNW_DB_WEIBOW_SERVER_PORT,
            'dbname' => 'admin',
            'username' => 'dbw',
            'password' => 'IuEbZ8JV',
            'driver_options' => array(
                PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
                PDO::ATTR_EMULATE_PREPARES => true,
            ),
        ),
        self::DB_WEIBO_R => array (
            'host' => XNW_DB_WEIBOR_SERVER,
            'port' => XNW_DB_WEIBOR_SERVER_PORT,
            'dbname' => XNW_WEIBO_DATABASE_NAME,
            'username' => 'dbr',
            'password' => 'ls8nXZ2R',
            'driver_options' => array(
                PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
                PDO::ATTR_EMULATE_PREPARES => true,
            ),
        ),
        self::DB_WEIBO_W => array (
            'host' => XNW_DB_WEIBOW_SERVER,
            'port' => XNW_DB_WEIBOW_SERVER_PORT,
            'dbname' => XNW_WEIBO_DATABASE_NAME,
            'username' => 'dbw',
            'password' => 'IuEbZ8JV',
            'driver_options' => array(
                PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
                PDO::ATTR_EMULATE_PREPARES => true,
            ),
        ),
        self::DB_PAYR_R => array (
            'host' => '172.16.0.163',
            'port' => '4446',
            'dbname' => 'pay',
            'username' => 'dbr',
            'password' => 'ls8nXZ2R',
            'driver_options' => array(
                PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
                PDO::ATTR_EMULATE_PREPARES => true,
            ),
        ),
        self::DB_PAYR_W => array (
            'host' => '172.16.0.10',
            'port' => '4444',
            'dbname' => 'pay',
            'username' => 'dbw',
            'password' => 'IuEbZ8JV',
            'driver_options' => array(
                PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
                PDO::ATTR_EMULATE_PREPARES => true,
            ),
        ),
        self::DB_TONGJI => array (
            'host' => XNW_DB_TONGJI_SERVER,
            'port' => XNW_DB_TONGJI_SERVER_PORT,
            'dbname' => 'tongji',
            'username' => 'dbw',
            'password' => 'IuEbZ8JV',
            'driver_options' => array(
                PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
                PDO::ATTR_EMULATE_PREPARES => true,
            ),
        ),
        self::DB_OAUTH_SERVER_W => array(
            'host' => XNW_DB_WEIBOW_SERVER,
            'port' => XNW_DB_WEIBOW_SERVER_PORT,
            'dbname' => 'oauth_server',
            'username' => 'dbw',
            'password' => 'IuEbZ8JV',
            'driver_options' => array(
                PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
                PDO::ATTR_EMULATE_PREPARES => true,
            ),
        ),
        self::DB_OAUTH_SERVER_R => array(
            'host' => XNW_DB_WEIBOW_SERVER,
            'port' => XNW_DB_WEIBOR_SERVER_PORT,
            'dbname' => 'oauth_server',
            'username' => 'dbr',
            'password' => 'ls8nXZ2R',
            'driver_options' => array(
                PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
                PDO::ATTR_EMULATE_PREPARES => true,
            ),
        ),
    );

    const MC_KEYS_LIMIT     = 500;              #一次memcache连接最多可获取的对象数
    const SHORT_EXPIRE_TIME = 30;
    const NORMAL_EXPIRE_TIME = 900;
    const SEARCH_EXPIRE_TIME = 1800;

    const SHORT_EXPIRE_TIME_MINUTES = 2;
    const NORMAL_EXPIRE_TIME_MINUTES = 15;
    const SEARCH_EXPIRE_TIME_MINUTES = 30;

    /**
     * memcache server param
     */
    public static $mc = array();
    public static function setMemcacheServer($array) {
        self::$mc = $array;
    }

    /**
     * @var bool 全局memcache开关
     */
    public static $MC_ENABLE = true;

    public static function setMcDisable() {
        self::$MC_ENABLE = false;
    }

    public static function setMcEnable() {
        self::$MC_ENABLE = true;
    }

    /**
     * redis server param
     */
    public static $redis = array();
    public static function setRedisServer($array) {
        self::$redis = $array;
    }

    /**
     * 可用对象库， 方便获取常用对象
     *
     */
    public static $valid_obj_ary = array();
    public static function setValidObj($array) {
        self::$valid_obj_ary = $array;
    }
}
