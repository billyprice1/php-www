<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$new_status = intval($_POST['new_status']);
$id = intval($_POST['id']);

api::send('message/update', array('id'=>$id, 'status'=>$new_status));

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	$template->redirect('/admin/messages/detail?id='.security::encode($id));

?>