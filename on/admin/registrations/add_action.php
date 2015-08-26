<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

api::send('registration/insert', array('email'=>$_POST['email']));

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	template::redirect("/admin/registrations?new={$_POST['email']}");

?>