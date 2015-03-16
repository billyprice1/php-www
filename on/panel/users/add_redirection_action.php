<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

try
{
	api::send('self/account/update', array('id'=>$_POST['id'], 'domain'=>$_POST['domain'], 'mode'=>'add', 'redirection'=>$_POST['redirection']));
}
catch( Exception $e )
{
	$_SESSION['MESSAGE']['TYPE'] = 'error';
	$_SESSION['MESSAGE']['TEXT']= $lang['error'];	
}

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	$template->redirect('/panel/users/config?id='.$_POST['id'].'&domain='.$_POST['domain']);

?>
