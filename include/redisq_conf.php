<?php

	//redis数据库信息
    define("REDIS_HOST",'10.11.155.23');
    define('REDIS_PORT',6379);
    define('REDIS_QUEUE_NAME','WRE_REDIS_QUEUE');
    define('REDIS_DB_PASSWORD','wre');
    
    // 数据库信息
	define("REDIS_DBHOST", "10.11.155.23");
	define("REDIS_DBNAME", "appstore_pro");
	define("REDIS_DBUSER", "app");
	define("REDIS_DBPASS", "app123");
	
	//日志目录
	define("REDIS_LOG_ROOT",'/opt/logs/redisq/');
	

    include_once('/ITC/pub/classes/RedisFactory.class.php');
    include_once('/ITC/pub/classes/RedisOperate.class.php');
    include_once('/ITC/pub/classes/Rlogger.class.php');


    ?>
