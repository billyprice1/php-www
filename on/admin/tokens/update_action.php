<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$params = array('user'=>$_POST['user'], 'token'=>$_POST['token']);
$params['name'] = $_POST['name'];

if( strlen($_POST['lease']) == 0 )
	$params['lease'] = 'never';
else if( is_numeric($_POST['lease']) )
	$params['lease'] = $_POST['lease'];
else
	$params['lease'] = strtotime($_POST['lease']);
	
api::send('token/update', $params);
if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	template::redirect('/admin/tokens/detail?token=' . $_POST['token'] . '&user=' . $_POST['user']);

?>