<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

try
{
	api::send('/domain/add', array('user'=>$_POST['user'], 'domain'=>$_POST['domain'], 'site'=>$_POST['site'], 'dir'=>$_POST['dir']));
	$_SESSION['MESSAGE']['TYPE'] = 'success';
	$_SESSION['MESSAGE']['TEXT'] = $lang['success'];	
}
catch( Exception $e )
{
	$_SESSION['MESSAGE']['TYPE'] = 'error';
	$_SESSION['MESSAGE']['TEXT'] = $lang['error'];	
}

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	$template->redirect('/admin/users/detail?id='. $_POST['user']);

?>
