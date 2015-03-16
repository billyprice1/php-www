<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

api::send('self/subdomain/add', array('domain'=>$_POST['domain'], 'subdomain'=>$_POST['subdomain']));

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	$template->redirect('/panel/domains/config?id='.$_POST['id']);

?>
