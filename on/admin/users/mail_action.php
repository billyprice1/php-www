<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$user = api::send('user/list', array('id'=>$_POST['user']));
$user = $user[0];

$mail = nl2br($_POST['mail']);
$subject = $_POST['mail_title'];
	
$email = str_replace(array('{USER}'), array($user['name']), $mail);
mail($user['email'], $subject, str_replace('{CONTENT}', $email, $GLOBALS['CONFIG']['MAIL_TEMPLATE']), "MIME-Version: 1.0\r\nContent-type: text/html; charset=utf-8\r\nFrom: Olympe <no-reply@olympe.in>\r\n");

$_SESSION['MESSAGE']['TYPE'] = 'success';
$_SESSION['MESSAGE']['TEXT']= $lang['success'];

template::redirect('/admin/users/detail?id='. $_POST['user']);

?>