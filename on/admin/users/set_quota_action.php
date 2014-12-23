<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

api::send('quota/user/update', array('user'=>$_POST['user'], 'quota'=>$_POST['quota'], 'max'=>$_POST['max']));

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	template::redirect('/admin/users/detail?id='.$_POST['user'].'#quotas');

?>