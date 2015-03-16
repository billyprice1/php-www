<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$params = array('site'=>$_POST['id']);

// Update password
if( $_POST['action'] == 'changepass' ) {
	if($_POST['pass'] && ($_POST['confirm'] == $_POST['pass'])) {
		$params['pass'] = $_POST['pass'];
		
	} else {

		$_SESSION['MESSAGE']['TYPE'] = 'error';
		$_SESSION['MESSAGE']['TEXT']= $lang['passworderror'];
		$template->redirect('/panel/sites/config?id=' . security::encode($_POST['id']));
	}
}

// Update directory config
if( $_POST['action'] == 'changedirectory' ) {

	if($_POST['category'] == '-1' || $_POST['title'] == '' || $_POST['description'] == '') {

		$_SESSION['MESSAGE']['TYPE'] = 'error';
		$_SESSION['MESSAGE']['TEXT']= $lang['error'];
		$template->redirect('/panel/sites/config?id=' . security::encode($_POST['id']));
	
	} else {
	
		if( $_POST['title'] )
			$params['title'] = str_replace("'", "&#39;", htmlspecialchars($_POST['title']));
		if( $_POST['description'] )
			$params['description'] = str_replace("'", "&#39;", htmlspecialchars($_POST['description']));
		if( $_POST['category'] )
			$params['category'] = $_POST['category'];
		if( $_POST['directory'] == 1 )
			$params['directory'] = 1;
		else
			$params['directory'] = 0;

	}
}


api::send('self/site/update', $params);

$_SESSION['MESSAGE']['TYPE'] = 'success';
$_SESSION['MESSAGE']['TEXT']= $lang['success'];	

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	$template->redirect('/panel/sites/config?id=' . security::encode($_POST['id']));

?>
