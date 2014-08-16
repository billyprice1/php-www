<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

if( isset($_GET['user']) && isset($_GET['token']) )
	$token = $_GET['token'];
else
	template::redirect('/admin');
	
$user = api::send('user/list', array('id'=>$_GET['user']));

if( count($user) == 0 )
	template::redirect('/admin');

$user = $user[0];

$email = $lang['content'];
$email = str_replace('{USERNAME}', $user['name'], $email);
$email = str_replace('{TOKEN}', $token, $email);

mail($user['email'], $lang['subject'], str_replace('{CONTENT}', $email, $GLOBALS['CONFIG']['MAIL_TEMPLATE']), "MIME-Version: 1.0\r\nContent-type: text/html; charset=utf-8\r\nFrom: Olympe <no-reply@olympe.in>\r\n");

$_SESSION['MESSAGE']['TYPE'] = 'success';
$_SESSION['MESSAGE']['TEXT']= $lang['success'];

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	template::redirect('/admin/users/detail?id='. $_GET['user']);

?>