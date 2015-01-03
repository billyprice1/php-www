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
	$_GLOBALS['APP']['PASSWORD'] = random(15);
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

$con = ftp_connect('ftp.olympe.in');
$login = ftp_login($con, $site['name'], $_POST['pass']);

if ( !is_array( ftp_nlist($con, ".") ) )
	throw new SiteException('FTP connection to the server failed. Invalid password supplied', 400, 'connection failed');

ftp_close($con);

	
$content = file_get_contents( 'https://fr.wordpress.org/wordpress-4.1-fr_FR.zip' );
file_put_contents( 'ftp://'.$site['name'].':'.$_POST['pass'].'@ftp.olympe.in/file.zip', $content, 0, stream_context_create( array('ftp' => array('overwrite' => true)) ));

if ( file_exists('ftp://'.$site['name'].':'.$_POST['pass'].'@ftp.olympe.in/file.zip') )
{
	$zip = new ZipArchive;
	$res = $zip->open('ftp://'.$site['name'].':'.$_POST['pass'].'@ftp.olympe.in/file.zip');
	if ( $res  === TRUE) 
	{
		 // extract it to the path we determined above
		  $zip->extractTo('ftp://'.$site['name'].':'.$_POST['pass'].'@ftp.olympe.in');
		  $zip->close();
		  
		  // delete zip file
		  unlink('ftp://'.$site['name'].':'.$_POST['pass'].'@ftp.olympe.in/file.zip');
		  
		  // redirect
		  header("Location: http://{$site['name']}.olympe.in/wordpress/wp-admin/setup-config.php?name={$database['name']}&server={$database['server']}");
		  return;
	} 
	else 
	  throw new SiteException('Internal Error '.$res, 400, 'File can not be extracted');
}
else
	throw new SiteException('Invalid argument', 400, 'File not uploaded');
	
function random($car) 
{
	$chaine = "abcdefghijklmnpqrstuvwxyABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"; srand((double)microtime()*1000000);
	for($i=0; $i<$car; $i++) 
		$string .= $chaine[rand()%strlen($chaine)];
		
	return $string;
}

?>
