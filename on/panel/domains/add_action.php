<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

try
{
	if( $_POST['dir'] == $lang['folder'] )
		$_POST['dir'] = '';

	api::send('self/domain/add', array('domain'=>$_POST['domain'], 'site'=>$_POST['subdomain'], 'dir'=>$_POST['dir']));
}
catch( Exception $e )
{
	$_SESSION['MESSAGE']['TYPE'] = 'error';
	$_SESSION['MESSAGE']['TEXT'] = $lang['error'];	
}

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	$template->redirect('/panel/domains');

?>
