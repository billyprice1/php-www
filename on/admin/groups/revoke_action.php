<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

api::send('grant/group/revoke', array('group'=>$_GET['group'], 'grant'=>$_GET['grant']));
if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	template::redirect('/admin/group/detail?id=' . $_GET['group']);

?>