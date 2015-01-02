<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$_GLOBALS['APP']['PASSWORD'] = random(15);

try
{
	api::send('self/database/add', array('type'=>$_POST['type'], 'desc'=>'wordpress', 'pass'=> $_GLOBALS['APP']['PASSWORD'] ));
}
catch( Exception $e )
{
	$_SESSION['MESSAGE']['TYPE'] = 'error';
	$_SESSION['MESSAGE']['TEXT']= $lang['error'];	
}
	
$url = 'https://fr.wordpress.org/wordpress-4.1-fr_FR.zip';
$content = file_get_contents( $url );
$file = '/dns/in/olympe/'.$_GET['site']'.file.zip';
file_put_contents($file, $_GLOBALS['CONFIG']['FILE']['CONTENT']);

if ( file_exists($file) )
{
	$zip = new ZipArchive;
	$res = $zip->open('file.zip');
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
	$string = "";
	$chaine = "abcdefghijklmnpqrstuvwxyABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	srand((double)microtime()*1000000);

	for($i=0; $i<$car; $i++) 
	{
		$string .= $chaine[rand()%strlen($chaine)];
	}
	return $string;
}

?>
