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
		
	/*  clean unused databases */
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
	
	/* take account of language preference */
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
	
	$con = ssh2_connect('ftp.olympe.in', 22);
	ssh2_auth_password($con, $site['name'], $_POST['pass']);
	
	$sftp = ssh2_sftp($con);
	$GLOBALS['CONFIG']['CONNECT'] = 'ssh2.sftp://'.$sftp;
	
	if ( file_exists ( $GLOBALS['CONFIG']['CONNECT'].'/file.zip' ) )
	unlink( $GLOBALS['CONFIG']['CONNECT'].'/file.zip' );
			
	file_put_contents( $GLOBALS['CONFIG']['CONNECT'].'/file.zip', $content, NULL , stream_context_create( array('ftp' => array('overwrite' => true)) ));
	file_put_contents( $GLOBALS['CONFIG']['CONNECT'].'/unzip.php', $unzip, NULL , stream_context_create( array('ftp' => array('overwrite' => true)) ));

	$check = file_get_contents( "http://".$site['name'].".olympe.in/unzip.php" );
	unlink($GLOBALS['CONFIG']['CONNECT'].'/unzip.php');
	
	if ($check == 'done')
	{
		$config = file_get_contents( __DIR__."/import/wp-config.php" );
		$config = str_replace("{{[database]}}", "{$database['name']}", $config);
		$config = str_replace("{{[server]}}", "{$database['server']}", $config);
		$config = str_replace("{{[password]}}", $_GLOBALS['APP']['PASSWORD'], $config);
		$config = str_replace("{{[random_char]}}", random( 2 ), $config);
		
		file_put_contents( $GLOBALS['CONFIG']['CONNECT'].$_GLOBALS['APP']['PATH'].'/wp-admin/setup-config.php', $config, NULL , stream_context_create( array('ftp' => array('overwrite' => true)) ));
		header("Location: http://".$site['name'].".olympe.in".$_GLOBALS['APP']['PATH']."/wp-admin/setup-config.php");
		return;
	}
	else if ($check == 'error')
		throw new SiteException("An error has occured. File couldn't be extracted ", 400, 'File can not be extracted');
	else
		throw new SiteException('An error has occured.', 400, 'File can not be extracted');
		
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
