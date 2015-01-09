<?php

	class destroy
	{
		public static function delTree($dir) {
		
			$files = array_diff(scandir($dir), array('.','..'));
			foreach ($files as $file) {
			  (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file");
			}
			return rmdir($dir);
			
		} 
		
		function delConfigFile( $file ) {
			unlink( $file );
		}
	}

	$_try = new destroy;
	$_try->delTree(__DIR__.'##PATH##');
	$_try->delConfigFile( 'config.ini' );
	
	if ( file_exists ( __DIR__.'##PATH##'.'/index.php' ) ) die('erreur');	else 	die ('done');

	
?>