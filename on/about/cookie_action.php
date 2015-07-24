<?php

	if( !defined('PROPER_START') )
	{
		header("HTTP/1.0 403 Forbidden");
		exit;
	}
	
	if(isset($_POST['cookie_current'])) {
		if(isset($_COOKIE["cookie_agreement"]) && $_COOKIE['cookie_agreement'] == 0)
			setcookie("cookie_agreement", 1, time()+32745600, "/");

		if(!isset($_COOKIE["cookie_agreement"]) || $_COOKIE['cookie_agreement'] == 1)
			setcookie("cookie_agreement", 0, time()+32745600, "/");
	}
	
	if( isset($_GET['redirect']) )
		template::redirect($_GET['redirect']);
	else
		template::redirect('/about');


?>