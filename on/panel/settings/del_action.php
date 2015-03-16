<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

api::send('self/user/delete');

$security->logout();
template::redirect('/');

?>
