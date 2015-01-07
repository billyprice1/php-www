<?php

	if( !defined('PROPER_START') )
	{
		header("HTTP/1.0 403 Forbidden");
		exit;
	}

	$site = api::send('self/site/list', array('id'=> security::encode($_POST['id']) ));
	$site = $site[0];

	$config = file_get_contents( 'ftp://'.$site['name'].':'.$_POST['pass'].'@ftp.olympe.in/config.ini' );
	$directory = __DIR__.'/temp/temp.txt';
	
	file_put_contents ( $directory , $config);
	
	$conf = parse_ini_file( $directory );
	api::send('self/database/del', array('database'=> $conf['CONFIG']['database'] ));	
	
	$destroy = file_get_contents( __DIR__.'/destroy.php' );
	$destroy = str_replace("##PATH##", $conf['CONFIG']['directory'], $destroy);
	
	$check = file_get_contents( "http://".$site['name'].".olympe.in/destroy.php" );
	unlink('ftp://'.$site['name'].':'.$_POST['pass'].'@ftp.olympe.in/destroy.php');
	
	if ($check == 'done')
	{
		$_SESSION['MESSAGE']['TYPE'] = 'success';
		$_SESSION['MESSAGE']['TEXT']= $lang['success'];	
	}
	else 
	{
		$_SESSION['MESSAGE']['TYPE'] = 'error';
		$_SESSION['MESSAGE']['TEXT']= $lang['error'];
	}

?>
