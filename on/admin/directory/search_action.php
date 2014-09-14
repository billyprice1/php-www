<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

if(!isset($_POST['search']) || $_POST['search'] == '') 
	$template->redirect('/admin/directory');

$site = api::send('site/list', array('site'=>$_POST['search'], 'fast'=>1));

if(count($site) == 1) 
	$template->redirect('/admin/directory/detail?id=' . $site[0]['id']);
	
else {
	$_SESSION['MESSAGE']['TYPE'] = 'error';
	$_SESSION['MESSAGE']['TEXT']= $lang['error'];	

	$template->redirect('/admin/directory');
}

?>
