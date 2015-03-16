<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

try
{
	if( isset($_POST['password']) && $_POST['password'] != $_POST['confirm'] )
		throw new SiteException("Password mismatch", 400, "Password and confirmation do not match");

	$params = array();
	$params['password'] = $_POST['password'];

	api::send('self/update', $params, $_POST['user'] . ':' . $_POST['token']);
}
catch(Exception $e)
{
	$template->redirect($_SERVER['HTTP_REFERER'] . (strstr($_SERVER['HTTP_REFERER'], 'echangepassword')===false?"?echangepassword":""));
}

$_SESSION['MESSAGE']['TYPE'] = 'success';
$_SESSION['MESSAGE']['TEXT']= $lang['message'];

unset($_SESSION['CHANGEPASS']);

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	template::redirect('/');

?>