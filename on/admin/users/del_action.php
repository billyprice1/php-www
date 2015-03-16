<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$user = api::send('user/list', array('id'=>$_POST['user']));
$user = $user[0];

if(isset($_POST['reason']) && $_POST['reason'] != 0) {

	if($_POST['reason'] == 1) // user request
		$content = $lang['content_1'];
		
	if($_POST['reason'] == 2) // multiple accounts
		$content = $lang['content_2'];
		
	if($_POST['reason'] == 3) // abuse
		$content = $lang['content_3'];
		
	if($_POST['reason'] == 4) // other
		$content = $lang['content_4'];

	api::send('user/del', array('id'=>$_POST['user']));
	
	if($_POST['reason'] != 5) {
		$email = str_replace(array('{USER}'), array($user['name']), $content);
		mail($user['email'], $lang['subject'], str_replace('{CONTENT}', $email, $GLOBALS['CONFIG']['MAIL_TEMPLATE']), "MIME-Version: 1.0\r\nContent-type: text/html; charset=utf-8\r\nFrom: Olympe <no-reply@olympe.in>\r\n");
	}
	
	if( isset($_GET['redirect']) )
		template::redirect($_GET['redirect']);
	else
		template::redirect('/admin');

} else {

	$_SESSION['MESSAGE']['TYPE'] = 'error';
	$_SESSION['MESSAGE']['TEXT']= $lang['error'];
	template::redirect('/admin/users/detail?id=' . $_POST['user']);
}
?>