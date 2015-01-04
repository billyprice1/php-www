<?php

	$path = pathinfo( realpath('##PATH##'), PATHINFO_DIRNAME );

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