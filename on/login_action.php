<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$_SERVER['HTTP_REFERER'] = str_replace('&erecovery', '', $_SERVER['HTTP_REFERER']);
$username = strtolower($_POST['username']);

if( isset($_POST['antispam']) && $_POST['antispam'] == $_SESSION['ANTISPAM'] )
{
	try
	{
		unset($_SESSION['ANTISPAM']);
		$security->login($username, $_POST['password'], ($_POST['remember'] == 'remember'));
	}
	catch(Exception $e)
	{
	}
}

$template->redirect($_SERVER['HTTP_REFERER'] . (strstr($_SERVER['HTTP_REFERER'], 'elogin')===false?"?elogin":""));

?>