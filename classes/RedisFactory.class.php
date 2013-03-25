<?php

/**
 * redis工厂类
 * @author zt3862266
 *
 */
    class RedisFactory{
        
     
        private static $instance = null; 
        
        
       	private function __construct(){

       	}
       	
       	public function __clone(){
       		
       	}
       	
       	//获得长连接实例
       	
       	static function getPInstance()
       	{
       		if(is_null(self::$instance))
       		{
       		
       			$redis = new Redis();
       			$redis -> pconnect(REDIS_HOST,REDIS_PORT);
       			$redis ->auth(REDIS_DB_PASSWORD);
       			self::$instance = new RedisOperate($redis);
       			return self::$instance;
       			 
       		}
       	
       		
       		return self::$instance ;
       	}

       	//获得短连接实例
        static function getInstance()
        {
            if(is_null(self::$instance))
            {

       			$redis = new Redis();
       			$redis -> connect(REDIS_HOST,REDIS_PORT);
       			$redis ->auth(REDIS_DB_PASSWORD);
       			self::$instance = new RedisOperate($redis);
       			return self::$instance;
       		
            }


            return self::$instance ;
        }
        static function close()
        {
            if(!is_null(self::$instance))
            {
                self::$instance->close();

            }
        }

       
    }

