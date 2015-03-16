<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

api::send('message/update', array('id'=>$_GET['id'], 'status'=>3));

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	$template->redirect('/admin/messages/detail?id='.security::encode($_GET['id']));

?>
