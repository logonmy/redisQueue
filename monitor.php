#!/opt/app/php_5.3.8/bin/php -q
<?php

        include_once("/ITC/pub/include/redisq_conf.php");
                function getThreadCount( $command ){
                        $output = array();
                        $ret = 0;
                        exec($command,$output,$ret);
                        return $output[0];

                }

                function sendsms($destnumber,$content)
                {
                        exec("/home/zabbix/bin/sms.send.php" . " " . $destnumber . " " . $content);
                }


        $sendmsg ='';
        $sendflag =false;
        $destarray = array ("18911208851");

        $redis = new Redis();
        
        $time = date("Y-m-d-H:i:s");
        
        $command ="ps -ef | grep redis-server | grep -v grep  | wc -l" ;
        
        
        if(getThreadCount($command) == 0)
        {
        	$sendmsg .= $time . ':redis-server[down!]';
        	$result = exec('/opt/app/redis_2.4.7/bin/redis-server /opt/app/redis_2.4.7/etc/redis.conf');
        	if(getThreadCount($command) == 0)
        		$sendmsg .= 'restart[fail]!';
        	else
        		$sendmsg .= 'restart[suc]';
        
        	
        	foreach ($destarray as $row)
        	{
        		sendsms($row,$sendmsg);
        	}
        	exit;
        
        } 

        
        $command = "ps -ef | grep redisPop | grep -v grep  | wc -l" ;
        
        if(getThreadCount($command) == 0)
        {
                $sendmsg .= $time . ':redispop[down]!!'; 
                $result = exec('/ITC/pub/redisPop.php >/dev/null 2>&1');
                if(getThreadCount($command) == 0)
                        $sendmsg .= 'restart[fail]!';
                else
                        $sendmsg .= 'restart[suc]';
                
                $sendflag =true;

        }else
        {
                $redis -> connect(REDIS_HOST,REDIS_PORT);
                $redis -> auth(REDIS_DB_PASSWORD);
                $size =  $redis->llen(REDIS_QUEUE_NAME);
                if($size > 500)
                {
                        $sendmsg .= $time . ":[WRE_REDIS_QUEUE]size=[{$size}]!";
                        $sendflag =true;
                }
		$redis->close();
                
                
        }
        
        if($sendflag)
        {
             


                foreach ($destarray as $row)
                {
                        sendsms($row,$sendmsg);
                }
        }
        
?>
