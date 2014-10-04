<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

if( !isset($_GET['code']) || !isset($_GET['email']) )
	throw new SiteException('Invalid or missing arguments', 400, 'Parameter code or email is not present');
	
$result = api::send('registration/select', array('code'=>$_GET['code'], 'email'=>$_GET['email']), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);

if( count($result) == 0 ) {
	//throw new SiteException('Invalid user/code', 400, 'No registration matches for this user/code');
	$_SESSION['MESSAGE']['TYPE'] = 'error';
	$_SESSION['MESSAGE']['TEXT']= $lang['invalid'];
	template::redirect('/');
}
if( $result[0]['date'] < (time() - 864000) ) { // 10 days
	//throw new SiteException('Outdated registration', 400, 'The registration is outdated : ' . date('Y-n-j', $result[0]['date']));
	$_SESSION['MESSAGE']['TYPE'] = 'error';
	$_SESSION['MESSAGE']['TEXT']= $lang['outdated'];
	template::redirect('/');
}

$_SESSION['REGISTER']['STATUS'] = true;
$_SESSION['REGISTER']['CODE'] = security::encode($_GET['code']);
$_SESSION['REGISTER']['EMAIL'] = security::encode($_GET['email']);

template::redirect('/');

?>