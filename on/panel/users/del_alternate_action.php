<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

api::send('self/account/update', array('id'=>$_GET['id'], 'domain'=>$_GET['domain'], 'mode'=>'delete', 'alternate'=>$_GET['alternate']));

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	$template->redirect('/panel/users/config?id='.$_GET['id'].'&domain='.$_GET['domain']);

?>
