<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

if( isset($_POST['pass']) && (!isset($_POST['confirm']) || $_POST['pass'] != $_POST['confirm']) )
	throw new SiteException("Password mismatch", 400, "Password and confirmation do not match");
	
$userinfo = api::send('self/user/list');
$userinfo = $userinfo[0];
$limit_date = $userinfo['date'] + 1209600;
$user_current_email = $userinfo['email'];

$params = array();
if( isset($_POST['email']) && strlen($_POST['email']) > 0 && $limit_date < time())
	$params['email'] = security::encode($_POST['email'], true, true);
if( isset($_POST['firstname']) && strlen($_POST['firstname']) > 0 )
	$params['firstname'] = security::encode($_POST['firstname'], true, true);
if( isset($_POST['lastname']) && strlen($_POST['lastname']) > 0 )
	$params['lastname'] = security::encode($_POST['lastname'], true, true);
if( isset($_POST['language']) && strlen($_POST['language']) > 0 )
	$params['language'] = $_POST['language'];
if( isset($_POST['pass']) && strlen($_POST['pass']) > 0 )
	$params['pass'] = $_POST['pass'];

api::send('self/user/update', $params);

if( (isset($_POST['email']) && strlen($_POST['email']) > 0 && $limit_date < time()) && ($_POST['email'] != $user_current_email)) {
	$email = str_replace(array('{USER}', '{OLD}', '{NEW}'), array($userinfo['name'], $user_current_email, $_POST['email']), $lang['content']);
	mail($user_current_email, $lang['subject'], str_replace('{CONTENT}', $email, $GLOBALS['CONFIG']['MAIL_TEMPLATE']), "MIME-Version: 1.0\r\nContent-type: text/html; charset=utf-8\r\nFrom: Olympe <no-reply@olympe.in>\r\n");
	mail($_POST['email'], $lang['subject'], str_replace('{CONTENT}', $email, $GLOBALS['CONFIG']['MAIL_TEMPLATE']), "MIME-Version: 1.0\r\nContent-type: text/html; charset=utf-8\r\nFrom: Olympe <no-reply@olympe.in>\r\n");
}

$_SESSION['MESSAGE']['TYPE'] = 'success';
$_SESSION['MESSAGE']['TEXT']= $lang['success'];	
			
if( isset($_GET['redirect']) )
	template::redirect(security::encode($_GET['redirect'], true, true));
else
	template::redirect('/panel/settings');

?>
