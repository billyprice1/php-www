<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

api::send('self/message/del', array('id'=>$_GET['id']));

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	template::redirect('/panel/messages/detail?id='.security::encode($_GET['parent']));

?>
