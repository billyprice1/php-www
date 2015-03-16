<?php

	if( !defined('PROPER_START') )
	{
		header("HTTP/1.0 403 Forbidden");
		exit;
	}

	/* =========

	$sites = api::send('site/list', array('user'=>$_POST['user']));
	foreach( $sites as $s )
	{
		if ( $s['id'] == $_POST['site'] )
			$_GLOBALS['APP']['SITE'] = $s['name'];
	}
	
	$_GLOBALS['APP']['PASSWORD'] = random( rand(15, 20) );

	============= */

	api::send('site/del', array('user'=>$_POST['user'], 'site'=>$_POST['site']));

	/* ========= 
	$htaccess = file_get_contents( __DIR__.'/404/.htaccess' );
	$font = file_get_contents( __DIR__.'/404/BebasNeue Regular.ttf' );
	
	$index = file_get_contents( __DIR__.'/404/index.html' );
	$index = str_replace("**DATE**", date("F j, Y, g:i a"), $index);
	$index = str_replace("**EXPLAIN**", empty($_POST['explain'])?'No reason provided':htmlentities($_POST['explain']), $index);
	
	sleep(2);
	api::send('self/site/add', array('site'=>$_GLOBALS['APP']['SITE'], 'pass'=> $_GLOBALS['APP']['PASSWORD']));
	sleep(10);
	
	
	$connection = ssh2_connect('ftp.olympe.in', 22);
	ssh2_auth_password( $connection, $_GLOBALS['APP']['SITE'], $_GLOBALS['APP']['PASSWORD'] );
	ssh2_scp_send($connection, $htaccess, '/.htaccess', 0644);
	ssh2_scp_send($connection, $font, '/BebasNeue Regular.ttf', 0644);
	ssh2_scp_send($connection, $index, '/index.html', 0644);
		
	function random($length = 15) 
	{
			$characters = "abcdefghijklmnpqrstuvwxyABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"; 
			$charactersLength = strlen($characters);
			for ($i = 0; $i < $length; $i++) {
				$randomString .= $characters[rand(0, $charactersLength - 1)];
			}
			return $randomString;
	} 
	============= */
	
	
	if( isset($_GET['redirect']) )
		template::redirect($_GET['redirect']);
	else
		template::redirect('/admin/users/detail?id='.$_POST['user'].'#sites');


?>