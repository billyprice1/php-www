<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$ports = array(21, 22, 25, 80, 110, 143, 443);
$host = 'cloud.olympe.in';

if( !in_array($_GET['port'], $ports) )
	exit();
	
$time_start = microtime();
$connection = @fsockopen($host, $_GET['port']);
$time_end = microtime();

$time = round(($time_end-$time_start)*1000);
if( $time < 0 )
	$time = 0;

if( is_resource($connection) )
{
	$content = "
	<div style=\"width: 45px; height: 45px; border-radius: 50%; border: 3px solid #2d6d03; padding: 10px; vertical-align: middle; text-align: center;\">
		<span style=\"display: block; padding-top: 8px; color: #2d6d03; font-weight: bold; font-size: 15px;\">".$lang['port_' . $_GET['port']]."</span><span style=\"display: block; font-size: 10px; color: #377b0b;\">{$time}ms</span>
	</div>";
}

echo $content;

?>