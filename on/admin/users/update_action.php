<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

if(isset($_POST['action']) && $_POST['action'] == 'update_user_infos') {

	if( isset($_POST['pass']) && (!isset($_POST['confirm']) || $_POST['pass'] != $_POST['confirm']) )
		throw new SiteException("Password mismatch", 400, "Password and confirmation do not match");

	$params = array('user'=>$_POST['id']);
	if( isset($_POST['email']) && strlen($_POST['email']) > 0 )
		$params['email'] = $_POST['email'];
	if( isset($_POST['firstname']) && strlen($_POST['firstname']) > 0 )
		$params['firstname'] = $_POST['firstname'];
	if( isset($_POST['lastname']) && strlen($_POST['lastname']) > 0 )
		$params['lastname'] = $_POST['lastname'];
	if( isset($_POST['pass']) && strlen($_POST['pass']) > 0 )
		$params['pass'] = $_POST['pass'];
	
} elseif(isset($_POST['action']) && $_POST['action'] == 'update_user_comment') {
	$params = array('user'=>$_POST['id']);
	if( isset($_POST['user_comment']) )
		$params['comment'] = htmlspecialchars($_POST['user_comment']);
}

api::send('user/update', $params);

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	template::redirect('/admin/users/detail?id=' . $_POST['id']);

?>