<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

// 1) rekvoke all grants that are not selected
$group = api::send('grant/group/list', array('group'=>$_POST['id']));

if( !isset($_POST['grant']) || !is_array($_POST['grant']) )
	$_POST['grant'] = array();

if( count($group) > 0 )
{
	$grants = array();
	foreach( $group as $g )
	{
		if( !in_array($g['id'], $_POST['grant']) )
			$grants[] = $g['id'];
	}

	if( count($grants) > 0 )
		api::send('grant/group/del', array('group'=>$_POST['id'], 'grants'=>implode(',', $grants)));
}

// 2) grant selected grants (existing ones will be ignored)
if( count($_POST['grant']) > 0 )
{
	api::send('grant/group/add', array('group'=>$_POST['id'], 'grants'=>implode(',', $_POST['grant'])));
}

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	template::redirect('/admin/groups/detail?id=' . $_POST['id']);

?>