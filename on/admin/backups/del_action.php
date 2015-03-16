<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

api::send('backup/del', array('user'=>$_POST['user'], 'id'=>$_POST['id']));

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	template::redirect('/admin/users/detail?id='.$_POST['user'].'#backups');

?>