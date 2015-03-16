<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

api::send('group/user/quit', array('group'=>$_GET['group'], 'user'=>$_GET['user']));
if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	template::redirect('/admin/user/detail?id=' . $_GET['user']);

?>