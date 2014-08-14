<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

if( isset($_POST['pass']) && (!isset($_POST['confirm']) || $_POST['pass'] != $_POST['confirm']) )
	throw new SiteException("Password mismatch", 400, "Password and confirmation do not match");
	
$userinfo = api::send('self/user/list');
$userinfo = $userinfo[0];
$limit_date = $userinfo['date'] + 1209600;

$params = array();
if( isset($_POST['email']) && strlen($_POST['email']) > 0 && $limit_date < time())
	$params['email'] = $_POST['email'];
if( isset($_POST['firstname']) && strlen($_POST['firstname']) > 0 )
	$params['firstname'] = $_POST['firstname'];
if( isset($_POST['lastname']) && strlen($_POST['lastname']) > 0 )
	$params['lastname'] = $_POST['lastname'];
if( isset($_POST['language']) && strlen($_POST['language']) > 0 )
	$params['language'] = $_POST['language'];
if( isset($_POST['pass']) && strlen($_POST['pass']) > 0 )
	$params['pass'] = $_POST['pass'];
	
api::send('self/user/update', $params);

$_SESSION['MESSAGE']['TYPE'] = 'success';
$_SESSION['MESSAGE']['TEXT']= $lang['success'];	
			
if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	template::redirect('/panel/settings');

?>