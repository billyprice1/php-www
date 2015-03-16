<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

try
{
	api::send('self/domain/update', array('id'=>$_POST['id'], 'arecord'=>$_POST['domain_arecord'], 'mx1'=>$_POST['mx1'], 'mx2'=>$_POST['mx2'], 'mx3'=>$_POST['mx3'], 'mx4'=>$_POST['mx4']));
	
	$_SESSION['MESSAGE']['TYPE'] = 'success';
	$_SESSION['MESSAGE']['TEXT']= $lang['success'];	
}
catch( Exception $e )
{
	$_SESSION['MESSAGE']['TYPE'] = 'error';
	$_SESSION['MESSAGE']['TEXT']= $lang['error'];	
}

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	$template->redirect('/panel/domains/config?id=' . security::encode($_POST['id']));
	
?>