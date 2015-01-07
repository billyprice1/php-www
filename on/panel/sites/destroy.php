<?php

	$path = __DIR__.'##PATH##';
	array_map('unlink', glob($path."/*"));
	
	unlink('config.ini');
	rmdir($path);
	
	if ( file_exists ( $path.'/index.php' ) )
		die ('erreur');
	else 
		die ('done');

?>