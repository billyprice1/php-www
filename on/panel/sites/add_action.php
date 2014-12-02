<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$blocked = file("{$GLOBALS['CONFIG']['SITE']}/panel/sites/sitename_blacklist.txt");
$subdomain = htmlspecialchars(strtolower($_POST['subdomain']));

foreach ($blocked as $line_num => $blocked_keyword) {
	$blocked_keyword = trim($blocked_keyword);
	if (strpos($subdomain, $blocked_keyword) !== false) {
		$_SESSION['MESSAGE']['TYPE'] = 'error';
		$_SESSION['MESSAGE']['TEXT']= $lang['blocked'];
		$template->redirect('/panel');
		exit();
	}
}

try
{
	api::send('self/site/add', array('site'=>$subdomain, 'pass'=>$_POST['password']));
	unset($_SESSION['subdomain']);
}
catch( Exception $e )
{
	$_SESSION['MESSAGE']['TYPE'] = 'error';
	$_SESSION['MESSAGE']['TEXT']= $lang['error'];	
}


if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	$template->redirect('/panel');

?>
