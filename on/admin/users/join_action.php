<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

// 1) quit all groups that are not selected
$user = api::send('group/user/list', array('user'=>$_POST['id']));

if( !isset($_POST['group']) || !is_array($_POST['group']) )
	$_POST['group'] = array();

if( count($user) > 0 )
{
	$groups = array();
	foreach( $user as $u )
	{
		if( !in_array($u['id'], $_POST['group']) )
			$groups[] = $u['id'];
	}

	if( count($groups) > 0 )
		api::send('group/user/del', array('user'=>$_POST['id'], 'groups'=>implode(',', $groups)));
}

// 2) group selected groups (existing ones will be ignored)
if( count($_POST['group']) > 0 )
{
	api::send('group/user/add', array('user'=>$_POST['id'], 'groups'=>implode(',', $_POST['group'])));
}

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	template::redirect('/admin/users/detail?id=' . $_POST['id']);

?>