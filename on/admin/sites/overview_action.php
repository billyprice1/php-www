<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

if( $_SERVER["HTTP_HOST"] == 'localhost' || $_SERVER["HTTP_HOST"] == '127.0.0.1' || $_SERVER["HTTP_HOST"] == 'local.olympe.in' )
	exit();

if( isset($_GET['user']) && isset($_GET['site']) ) {
	$user = $_GET['user'];
	$site = $_GET['site'];
} else
	template::redirect('/admin');
	
$url = str_replace(array('..', '\\', '|', '*', ' ', 'http://'), array('', '', '', '', '', ''), $_GET['url']);
$file = $url.'.png';

if( file_exists($file) )
	unlink($file);


if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	template::redirect('/admin/users/detail?id='. $user);

?>