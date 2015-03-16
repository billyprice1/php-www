<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

try
{
	api::send('self/account/add', array('account'=>$_POST['mail'], 'domain'=>$_POST['domain'], 'pass'=>$_POST['password'], 'firstname'=>$_POST['firstname'], 'lastname'=>$_POST['lastname']));
}
catch( Exception $e )
{
	$_SESSION['MESSAGE']['TYPE'] = 'error';
	$_SESSION['MESSAGE']['TEXT']= $lang['error'];	
}

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	$template->redirect('/panel/users/list?domain=' . security::encode($_POST['domain']));

?>
