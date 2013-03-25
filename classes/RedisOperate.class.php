<?php

/**
 * redis基础操作类
 * @author zt3862266
 *
 */
	class RedisOperate{
		
		private $redis ;
		private $log;
		
		function __construct($redis)
		{
			$this->redis = $redis;
			$this->log = new Rlogger();
			
			
		}
		
		//设置key ,value
		function set($key,$value)
		{
			$this->log->debug("set:" . $key . '==>' . $value);
			return $this->redis->set($key,$value);
		}
		//获得value
		function get($key)
		{
			return $this->redis->get($key);
		}
		//将$key加入队列
		function push($key)
		{
			$this->log->debug($key);
			return $this->redis->lPush(REDIS_QUEUE_NAME,$key);
		}
		//从队列取出一个元素
		function pop()
		{
			return $this->redis->rPop(REDIS_QUEUE_NAME);
		}
		//获得队列大小
		function getQueueSize()
		{
			return $this->redis->lSize(REDIS_QUEUE_NAME);
		}
		//获得start,end之间的所有元素值
		function getElementByrange($start,$end=-1)
		{
			if($end<$start && $end >0)
				$end = -1;
				
			return $this->redis->lRange(REDIS_QUEUE_NAME, $start,$end);
		}
		
		function close(){
			 $this->redis->close();
		}
		
		
		
	}