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
		  
		  // delete zip file
		  unlink('file.zip');
		  die('done'); 
	}
	else 	
		  die('error');

?>