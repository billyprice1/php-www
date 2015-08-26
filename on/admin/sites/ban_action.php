<?php

	if( !defined('PROPER_START') )
	{
		header("HTTP/1.0 403 Forbidden");
		exit;
	}

	function random($length = 15) 
	{
			$characters = "abcdefghijklmnpqrstuvwxyABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"; 
			$charactersLength = strlen($characters);
			for ($i = 0; $i < $length; $i++) {
				$randomString .= $characters[rand(0, $charactersLength - 1)];
			}
			return $randomString;
	} 
	
	/* recreate banned website */
	$new_password = random( rand(15, 20) );
	$banned_sites_user_id = '119354';
	$site_name = $_POST['sitename'];
	
	api::send('site/del', array('user'=>$_POST['user'], 'site'=>$_POST['site']));
	sleep(2);
	
	/* display banned page */
	$htaccess = __DIR__.'/404/.htaccess';
	$index = __DIR__.'/404/index.html';
	
	api::send('site/insert', array('site'=>$site_name, 'user'=>$banned_sites_user_id, 'pass'=>$new_password));
	sleep(10);
	
	$conn_id = ftp_connect("ftp.olympe.in") or die("Couldn't connect to $ftp_server");
	ftp_login($conn_id, $site_name, $new_password);
	ftp_pasv($conn_id, true);
	ftp_put($conn_id, "index.html", $index, FTP_ASCII);
	ftp_put($conn_id, ".htaccess", $htaccess, FTP_ASCII);
	ftp_close($conn_id);
	
	if( isset($_GET['redirect']) )
		template::redirect($_GET['redirect']);
	else
		template::redirect('/admin/users/detail?id='.$_POST['user'].'#sites');
?>
