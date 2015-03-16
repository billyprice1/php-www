<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$params = array();
if( $_GET['database'] )
	$params['database'] = $_GET['database'];
else if( $_GET['site'] )
	$params['site'] = $_GET['site'];

api::send('self/backup/add', $params);

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	$template->redirect('/panel/backups');

?>
