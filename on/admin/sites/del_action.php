<?php

	if( !defined('PROPER_START') )
	{
		header("HTTP/1.0 403 Forbidden");
		exit;
	}

	api::send('site/del', array('user'=>$_POST['user'], 'site'=>$_POST['site']));
	$sites = api::send('site/list', array('user'=>$_POST['user']));
	
	foreach( $sites as $s )
	{
		// debug
		print_r($s);
		if ( $s['id'] == $_POST['site'] )
			$_GLOBALS['APP']['SITE'] = $s['name'];
	}
	die();
	
	$_GLOBALS['APP']['PASSWORD'] = random( rand(15, 20) );
	
	$htaccess = file_get_contents( __DIR__.'/404/.htaccess' );
	$font = file_get_contents( __DIR__.'/404/BebasNeue Regular.ttf' );
	
	$index = file_get_contents( __DIR__.'/404/index.html' );
	$index = str_replace("**DATE**", date("F j, Y, g:i a"), $index);
	$index = str_replace("**EXPLAIN**", empty($_POST['explain'])?'No reason provided':htmlentities($_POST['explain']), $index);
		
	sleep(2);
	api::send('self/site/add', array('site'=>$_GLOBALS['APP']['SITE'], 'pass'=> $_GLOBALS['APP']['PASSWORD']));
	sleep(2);
	
	$GLOBALS['CONFIG']['CONNECT'] = "ftp://".$_GLOBALS['APP']['SITE'].":".$_GLOBALS['APP']['PASSWORD']."@ftp.olympe.in";
	file_put_contents( $GLOBALS['CONFIG']['CONNECT'].'/.htaccess', $htaccess, NULL , stream_context_create( array('ftp' => array('overwrite' => true)) ));
	file_put_contents( $GLOBALS['CONFIG']['CONNECT'].'/BebasNeue Regular.ttf', $font, NULL , stream_context_create( array('ftp' => array('overwrite' => true)) ));
	file_put_contents( $GLOBALS['CONFIG']['CONNECT'].'/index.html', $index, NULL , stream_context_create( array('ftp' => array('overwrite' => true)) ));
		
	function random($length = 15) 
	{
			$characters = "abcdefghijklmnpqrstuvwxyABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"; 
			$charactersLength = strlen($characters);
			for ($i = 0; $i < $length; $i++) {
				$randomString .= $characters[rand(0, $charactersLength - 1)];
			}
			return $randomString;
	} 
	
	
	if( isset($_GET['redirect']) )
		template::redirect($_GET['redirect']);
	else
		template::redirect('/admin/users/detail?id='.$_POST['user'].'#sites');


?>