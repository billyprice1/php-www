<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

api::send('self/token/del', array('token'=>$_GET['token']));

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	template::redirect('/panel/settings/tokens');

?>