<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

try
{
	if( isset($_POST['pass']) && (!isset($_POST['pass2']) || $_POST['pass'] != $_POST['pass2']) )
		throw new Exception("Password mismatch");
	
	$params = array();
	$params['user'] = $_POST['user'];
	$params['pass'] = $_POST['pass'];
	$params['database'] = $_POST['database'];

	api::send('/database/update', $params);

	$_SESSION['MESSAGE']['TYPE'] = 'success';
	$_SESSION['MESSAGE']['TEXT']= $lang['success'];	
}
catch(Exception $e)
{
	$_SESSION['MESSAGE']['TYPE'] = 'error';
	$_SESSION['MESSAGE']['TEXT']= $lang['error'];	
}

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	$template->redirect('/admin/users/detail?id=' . $_POST['user']);

?>
