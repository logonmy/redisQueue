<?php
$redis = new Redis();
$redis->connect('10.13.81.111',6379);
$redis->auth('wre');
$redis->set('test','hello world');
echo $redis->get('test');
?>
