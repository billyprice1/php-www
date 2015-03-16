<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$userinfo = api::send('self/user/list');
$userinfo = $userinfo[0];

if( $_FILES['avatar']['error'] == UPLOAD_ERR_OK )
{
	$resizer = new resizer($_FILES['avatar']['tmp_name'], 256, 256);
	$resizer->save('on/images/users/', $userinfo['id'].'.png', resizer::PNG);
}
	
if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	$template->redirect('/panel/settings');
	
?>