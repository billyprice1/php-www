<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

if( !$_GET['user'] || !$_GET['token'] )
	exit();
	
$_SESSION['CHANGEPASS']['TOKEN'] = security::encode($_GET['token']);
$_SESSION['CHANGEPASS']['USER'] = security::encode($_GET['user']);

template::redirect('/');

?>