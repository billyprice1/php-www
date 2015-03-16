<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

api::send('message/update', array('id'=>$_POST['id'], 'content'=>bbcode::encode($_POST['content'])));

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	$template->redirect('/admin/messages/detail?id='.security::encode($_POST['parent']));

?>
