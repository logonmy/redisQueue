<?php
/**
 * redis日志类
 * @author zt3862266
 *
 */
class Rlogger {


	function __construct() {

	}

	function debug($msg) {
		
		date_default_timezone_set('Asia/Chongqing');
		$date = date("Y-m-d");
		$time = date("H:i:s");
		
		$pattern = "/([_a-zA-Z0-9]+)(.php)$/";
		
		preg_match($pattern,$_SERVER['PHP_SELF'],$result);
		

		$filename = REDIS_LOG_ROOT . $result[1]. $date.".log";
		$msg = "[".$time."] ".": ".$msg;

		$fp = fopen($filename, "ab+");
		fwrite($fp, $msg."\n");
		fclose($fp);
	}

}

?>