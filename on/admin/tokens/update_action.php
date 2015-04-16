<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$user = htmlspecialchars($_POST['user']);
$token = htmlspecialchars($_POST['token']);
$name = htmlspecialchars($_POST['name']);
$lease = htmlspecialchars($_POST['lease']);

$params = array('user'=>$user, 'token'=>$token);
$params['name'] = $name;

if( strlen($lease) == 0 )
	$params['lease'] = 'never';
else if( is_numeric($lease) )
	$params['lease'] = $lease;
else
	$params['lease'] = strtotime($lease);
	
api::send('token/update', $params);
if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	template::redirect('/admin/tokens/detail?token=' . $token . '&user=' . $user);

?>