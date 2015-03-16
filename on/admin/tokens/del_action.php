<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

api::send('token/del', array('user'=>$_GET['user'], 'token'=>$_GET['token']));
if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	template::redirect('/admin/users/detail?id='.$_GET['user'].'#tokens');

?>