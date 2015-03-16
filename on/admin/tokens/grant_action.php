<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

// 1) rekvoke all grants that are not selected
$token = api::send('grant/token/list', array('user'=>$_POST['user'], 'token'=>$_POST['token']));

if( !isset($_POST['grant']) || !is_array($_POST['grant']) )
	$_POST['grant'] = array();

if( count($token) > 0 )
{
	$grants = array();
	foreach( $token as $t )
	{
		if( !in_array($t['id'], $_POST['grant']) )
			$grants[] = $t['id'];
	}

	if( count($grants) > 0 )
		api::send('grant/token/del', array('user'=>$_POST['user'], 'token'=>$_POST['token'], 'grants'=>implode(',', $grants)));
}

// 2) grant selected grants (existing ones will be ignored)
if( count($_POST['grant']) > 0 )
{
	api::send('grant/token/add', array('user'=>$_POST['user'], 'token'=>$_POST['token'], 'grants'=>implode(',', $_POST['grant'])));
}

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	template::redirect('/admin/tokens/detail?token=' . $_POST['token'] . '&user=' . $_POST['user']);

?>