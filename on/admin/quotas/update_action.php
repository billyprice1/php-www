<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

api::send('quota/update', array('id'=>$_POST['id'], 'name'=>$_POST['name']));

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	template::redirect('/admin/quota/detail?id='.$_POST['id'].'#quotas');

?>