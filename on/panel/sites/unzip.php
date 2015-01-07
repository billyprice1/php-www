<?php

	$path = __DIR__.'##PATH##';
	mkdir( $path );
	
	$zip = new ZipArchive;
	$res = $zip->open('file.zip');
	if ($res === TRUE) 
	{
		// extract it to the path we determined above
		$zip->extractTo($path);
		$zip->close();
		  
		// create config.ini file
		$conf = "##FILE##";
		  
		 file_put_contents( 'config.ini' , $conf );
		 chmod('config.ini', 0400);
	  
		 // delete zip file
		unlink('file.zip');
		die('done'); 
	}
	else 
		  die('error');

	
?>