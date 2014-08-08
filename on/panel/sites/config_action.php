<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$params = array('site'=>$_POST['id']);

if( $_POST['pass'] && $_POST['confirm'] == $_POST['pass'] )
	$params['pass'] = $_POST['pass'];
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
	
api::send('self/site/update', $params);

$_SESSION['MESSAGE']['TYPE'] = 'success';
$_SESSION['MESSAGE']['TEXT']= $lang['success'];	

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	$template->redirect('/panel/sites/config?id=' . security::encode($_POST['id']));

?>
