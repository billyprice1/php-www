<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$a = "";
$cname = "";

if( preg_match("/^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$/", $_POST['record']) )
	$a = $_POST['record'];
else if( preg_match("/^[a-zA-Z0-9\.-]{1,100}\.[a-zA-Z0-9]{2,6}$/", $_POST['record']) )
	$cname = $_POST['record'];

api::send('self/subdomain/update', array('id'=>$_POST['id'], 'domain'=>$_POST['domain'], 'arecord'=>$a, 'cnamerecord'=>$cname));

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	$template->redirect('/panel/domains/config?id='.$_POST['domain_id']);
	
?>
