<?php

	class destroy
	{
		function delTree( $dir ) {
		
			$files = array_diff(scandir($dir), array('.','..'));
			foreach ($files as $file) {
			  (is_dir($dir.'/'.$file)) ? $this->delTree($dir.'/'.$file) : unlink($dir.'/'.$file);
			}
			return rmdir( $dir );
			
		} 
		
		function delConfigFile( $file ) {
			unlink( $file );
		}
	}

	$_try = new destroy;
	$_try->delTree(__DIR__.'##PATH##');
	$_try->delConfigFile( 'config.ini' );
	
	( file_exists ( __DIR__.'##PATH##'.'/index.php' ) ) ? die('22') : die ('25');

?>