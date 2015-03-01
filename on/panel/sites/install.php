<?php

	if( !defined('PROPER_START') )
	{
		header("HTTP/1.0 403 Forbidden");
		exit;
	}

	$site = api::send('self/site/list', array('id'=> security::encode($_POST['id']) ));
	$site = $site[0];

	$database = api::send('self/database/list');
	$me = api::send('self/whoami', array('quota'=>true))[0];
	
	if( !isset($_POST['sql']) || empty($_POST['sql']) )	
		$_GLOBALS['APP']['PASSWORD'] = random( rand(15, 20) );
	else
		$_GLOBALS['APP']['PASSWORD'] = security::encode( $_POST['sql'] );
	
	
	$_GLOBALS['APP']['VERSION'] = "4.1";
	$_GLOBALS['APP']['NAME'] = "wordpress";

	
	if( $_POST['path'] == 1 )
		$_GLOBALS['APP']['PATH'] = '/folder';
	else
		$_GLOBALS['APP']['PATH'] = '';
		
	/* ================ CLEAN UNUSED DATABASES ================ */
	foreach( $database as $d )
	{
		if ( ( empty( $d['size'] ) || $d['size']  == 0 ) && $d['desc'] == 'wordpress' )
		{
			api::send('self/database/del', array( 'database'=>  $d['name'] ));
			$count++;
		}
	}
	
	if ( $me['quotas'][2]['used'] >= $me['quotas'][2]['max'] )
		if ( $count <= 0 )
			throw new SiteException('Please remove one of your databases ', 400, 'quota reached');

			
	$new = api::send('self/database/add', array('type'=>'mysql', 'desc'=>'wordpress', 'pass'=> $_GLOBALS['APP']['PASSWORD'] ));
	$database = api::send( 'self/database/list', array( 'database' => $new['name'] ) )[0];
	
	/* =========== TAKE LANGUAGE PREFERENCE INTO ACCOUNT =========== */ 
	switch ($_COOKIE['language']) {
		case 'FR':
			$_lang = "fr_FR";
			break;
		case 'EN':
			$_lang = "en_EN";
			break;
		case 'DE':
			$_lang = "de_DE";
			break;
		case 'IT':
			$_lang = "it_IT";
			break;
		case 'ES':
			$_lang = "es_ES";
			break;
		default:
			$_lang = "fr_FR";
	}
	
	$content = file_get_contents( __DIR__.'/import/wordpress-'.$_lang.'.zip' );
	
		// write config file on remote directory
		$conf = "
		; This is a configuration file linked to the quick installation
		; It has been automatically generated
		; #### PLEASE DO NOT REMOVE ####
		
		[CONFIG]
		cms = '".$_GLOBALS['APP']['NAME']."'
		version = '".$_GLOBALS['APP']['VERSION']."'
		directory = '".$_GLOBALS['APP']['PATH']."'
		database = '{$database['name']}'
		";
	
	$unzip = file_get_contents( __DIR__.'/unzip.php' );
	$unzip = str_replace("##PATH##", $_GLOBALS['APP']['PATH'], $unzip);
	$unzip = str_replace("##FILE##", $conf, $unzip);
	
	
	// set up basic FTP connection
	$con = @ftp_connect( 'ftp.olympe.in' );
	$login = @ftp_login( $con, $site['name'], $_POST['pass']);
	
	// generate temporary files
	file_put_contents ( __DIR__.'/temp/archive.zip', $content );
	file_put_contents ( __DIR__.'/temp/unzip.php', $unzip );
	
	var_dump ( @ftp_put( $con, '/file.zip', __DIR__.'/temp/archive.zip', FTP_ASCII ) );
	ftp_put( $con, '/file.zip', __DIR__.'/temp/archive.zip', FTP_ASCII );
	
	@ftp_put( $con, 'file.zip', __DIR__.'/temp/archive.zip', FTP_BINARY );
	@ftp_put( $con, 'unzip.php', __DIR__.'/temp/unzip.php', FTP_BINARY );

	$check = @file_get_contents( "http://".$site['name'].".olympe.in/unzip.php" );
	@ftp_delete($con, '/unzip.php');
	
	var_dump ( $check );
	exit ();
	
	if ($check == 'done')
	{
		$config = file_get_contents( __DIR__."/import/wp-config.php" );
		$config = str_replace("{{[database]}}", "{$database['name']}", $config);
		$config = str_replace("{{[server]}}", "{$database['server']}", $config);
		$config = str_replace("{{[password]}}", $_GLOBALS['APP']['PASSWORD'], $config);
		$config = str_replace("{{[random_char]}}", random( 2 ), $config);
		
		@ftp_put( $con, $_GLOBALS['APP']['PATH'].'/wp-admin/setup-config.php', $config, FTP_ASCII );
		header("Location: http://".$site['name'].".olympe.in".$_GLOBALS['APP']['PATH']."/wp-admin/setup-config.php");
		return;
	}
	else if ($check == 'error')
	{
		$_SESSION['MESSAGE']['TYPE'] = 'error';
		$_SESSION['MESSAGE']['TEXT']= "An error has occured. Files couldn't be extracted. ";
		$template->redirect('/panel/sites/config?id='.$site['id']);
	}
	else
	{
		$_SESSION['MESSAGE']['TYPE'] = 'error';
		$_SESSION['MESSAGE']['TEXT']= "An error has occured. Cannot set up a connection to the remote directory.";
		$template->redirect('/panel/sites/config?id='.$site['id']);
	}
	
	function random($length = 15) 
	{
			$characters = "abcdefghijklmnpqrstuvwxyABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"; 
			$charactersLength = strlen($characters);
			for ($i = 0; $i < $length; $i++) {
				$randomString .= $characters[rand(0, $charactersLength - 1)];
			}
			return $randomString;
	} 

?>
