<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

if( !isset($_POST['pass']) || !isset($_POST['confirm']) || $_POST['pass'] != $_POST['confirm'] )
	throw new SiteException("Password mismatch", 400, "Password and confirmation do not match");

$params = array('user'=>$_POST['name'], 'pass'=>$_POST['pass']);
if( isset($_POST['email']) && strlen($_POST['email']) > 0 )
	$params['email'] = $_POST['email'];
if( isset($_POST['firstname']) && strlen($_POST['firstname']) > 0 )
	$params['firstname'] = $_POST['firstname'];
if( isset($_POST['lastname']) && strlen($_POST['lastname']) > 0 )
	$params['lastname'] = $_POST['lastname'];

$result = api::send('user/add', $params);

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	template::redirect('/admin/user/detail?id='.$result['id']);

?>