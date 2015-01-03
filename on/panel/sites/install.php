<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$site = api::send('self/site/list', array('id'=> security::encode($_POST['id']) ));
$site = $site[0];

try
{
	$_GLOBALS['APP']['PASSWORD'] = random( rand(15, 20) );
	api::send('self/database/add', array('type'=>'mysql', 'desc'=>'wordpress', 'pass'=> $_GLOBALS['APP']['PASSWORD'] ));
	
	$database = api::send('self/database/list');
	
	if ($database[0]['desc'] != 'wordpress')
		throw new SiteException('Internal Error. Database could not be created', 400, 'database was not created');
}
catch( Exception $e )
{
	$_SESSION['MESSAGE']['TYPE'] = 'error';
	$_SESSION['MESSAGE']['TEXT']= $lang['error'];
}

$content = file_get_contents( 'https://fr.wordpress.org/wordpress-4.1-fr_FR.zip' );
$unzip = file_get_contents( __DIR__.'/unzip.php' );
file_put_contents( 'ftp://'.$site['name'].':'.$_POST['pass'].'@ftp.olympe.in/file.zip', $content, NULL , stream_context_create( array('ftp' => array('overwrite' => true)) ));
file_put_contents( 'ftp://'.$site['name'].':'.$_POST['pass'].'@ftp.olympe.in/unzip.php', $unzip, NULL , stream_context_create( array('ftp' => array('overwrite' => true)) ));

$check = file_get_contents( "http://".$site['name'].".olympe.in/unzip.php" );
	
	if ($check == 'done')
	{
		$config = file_get_contents( "/on/panel/sites/import/wp-config.php" );
		$config = str_replace("{{[database]}}", "{$database['name']}", $config);
		$config = str_replace("{{[server]}}", "{$database['server']}", $config);
		$config = str_replace("{{[password]}}", $_GLOBALS['APP']['PASSWORD'], $config);
		$config = str_replace("{{[random_char]}}", random( 2 ), $config);
		
		file_put_contents( 'ftp://'.$site['name'].':'.$_POST['pass'].'@ftp.olympe.in/wordpress/wp-admin/setup-config.php', $config, NULL , stream_context_create( array('ftp' => array('overwrite' => true)) ));
		
		header("Location: http://".$site['name'].".olympe.in/wordpress/wp-admin/setup-config.php");
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
