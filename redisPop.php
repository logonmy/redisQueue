#!/opt/app/php_5.3.8/bin/php -q

<?php

//创建子进程
	$pid = pcntl_fork(); 


	if ($pid < 0)
	{
		echo 'could not fork';
		exit;
	}
	else if ($pid)
	{
		
		exit;
		
	}else {

		$sid = posix_setsid();

		if ($sid < 0)
		{
			echo "setsid error!";
			exit;
		}

		include_once('/ITC/pub/include/redisq_conf.php');
		
		//获得redis长连接
		$myredis = RedisFactory::getPInstance();

		$log = new Rlogger();
		
		$db = mysql_pconnect(REDIS_DBHOST, REDIS_DBUSER, REDIS_DBPASS);
		mysql_select_db(REDIS_DBNAME);
		
		while(1)
		{

			
			//如果连接失效,则重连
			if(!mysql_ping($db))
			{
				mysql_close($db);
				$db = mysql_pconnect(REDIS_DBHOST, REDIS_DBUSER, REDIS_DBPASS);
				mysql_select_db(REDIS_DBNAME);
				
				
			}


			$len = $myredis->getQueueSize();
		
			if($len>100)
				$len = 100;
		
			$sql = array();
		
			mysql_query('set autocommit = 0');
				
			
			for($i = 0;$i<$len;$i++)
			{
		
				$str = $myredis->pop();
				$log->debug($str);
						
					
				$result = mysql_query($str);
				
				if (mysql_errno() != 0)
				{
					$log->debug('wrong sql;' . $str);

				}
		
			}
			mysql_query('commit');

			sleep(1);

		}
	}
	?>

    
