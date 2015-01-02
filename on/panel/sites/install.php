<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$site = api::send('self/site/list', array('id'=>$_GET['id']));

try
{
	$_GLOBALS['APP']['PASSWORD'] = random(15);
	api::send('self/database/add', array('type'=>$_POST['type'], 'desc'=>'wordpress', 'pass'=> $_GLOBALS['APP']['PASSWORD'] ));
}
catch( Exception $e )
{
	$_SESSION['MESSAGE']['TYPE'] = 'error';
	$_SESSION['MESSAGE']['TEXT']= $lang['error'];	
}
	
$url = 'https://fr.wordpress.org/wordpress-4.1-fr_FR.zip';
$content = file_get_contents( $url );
$file = "/dns/in/olympe/{$site['name']}/file.zip";

print_r($site);
return;

/* set the FTP hostname */
$user = $_GET['site'];
$host = "ftp.olympe.in";
$file = "file.zip";
$hostname = $user . ":" . $pass . "@" . $host . "/" . $file;

/* the file content */
$content = "this is just a test.";

/* create a stream context telling PHP to overwrite the file */
$options = array('ftp' => array('overwrite' => true));
$stream = stream_context_create($options);

/* and finally, put the contents */
file_put_contents($hostname, $content, 0, $stream); 

file_put_contents($file, $content);

if ( file_exists($file) )
{
	$zip = new ZipArchive;
	$res = $zip->open($file);
	if ($res === TRUE) 
	{
		 // extract it to the path we determined above
		  $zip->extractTo($path);
		  $zip->close();
		  
		  // delete zip file
		  unlink($_GLOBALS['CONFIG']['FILE']['NAME']);
		  
		  // redirect
		  header('Location: http://'.$_GET['site'].'olympe.in/wordpress/wp-admin/setup-config.php');
		  return;
	} 
	else 
	  throw new SiteException('Internal Error', 400, 'File can not be extracted');
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
