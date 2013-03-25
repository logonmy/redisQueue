#!/opt/app/php_5.3.8/bin/php -q

<?php

//创建子进程
	$pid = pcntl_fork(); // fork


	if ($pid < 0)
	{
		echo 'could not fork';
		exit;
	}
	else if ($pid)
	{
		exit;
		
	}else { // child

		$sid = posix_setsid();

		if ($sid < 0)
		{	echo "setsid error!";
			exit;
		}

		include_once('/ITC/pub/include/redisq_conf.php');
		
		//获得redis长连接
		$myredis = RedisFactory::getPInstance();



		//从队列取数据,一直执行下去,每次最多执行100条语句
		$i = 1;
		while(1)
		{
	
			$value = "insert into users( name ) values('zhangtao{$i}');";
			$myredis->push($value);
			$i++;
			sleep(1);
			
		}
	}
	?>

    
