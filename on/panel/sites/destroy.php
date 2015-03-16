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
			if ( file_exists ( $file ) )
			unlink( $file );
		}
	}

	ignore_user_abort( true );
	set_time_limit( 0 );
	
	$GLOBALS['DEFINED']['PATH'] = __DIR__.'##PATH##';
	
	$_try = new destroy;
	$_try->delTree( $GLOBALS['DEFINED']['PATH'] );
	$_try->delConfigFile( 'config.ini' );
	
	if ( !file_exists ( $GLOBALS['DEFINED']['PATH'].'/index.php' ) )
	die( '1' );

	
?>