<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

if( !isset($_POST['email']) || !isset($_POST['user']) || !isset($_POST['password']) )
	throw new SiteException('Invalid or missing arguments', 400, 'Parameter email or username or password is not present');
	
if( empty($_POST['email']) || empty($_POST['user']) || empty($_POST['password']) )
	template::redirect('/admin?enew');

$result = api::send('user/add', array('user'=>$_POST['user'], 'ip'=>"00.000.000.00", 'pass'=>$_POST['password'], 'email'=>$_POST['email'], 'firstname'=>'', 'lastname'=>'', 'language'=>"EN"), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
$uid = $result['id'];

if( !is_numeric($uid) || $uid <= 0 )
	throw new SiteException("User creation failed", 500, "Generated uid : {$uid}");

// INSERT THE USER IN THE USERS GROUP
api::send('group/user/add', array('user'=>$uid, 'group'=>'USERS'), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);

// CREATE THE FIRST TOKEN WITH BASIC ACCESS
$result = api::send('token/insert', array('user'=>$uid, 'lease'=>'never', 'name'=>'Olympe', 'grants'=>'ACCESS,SELF_SELECT,SELF_UPDATE,SELF_DELETE,SELF_GRANT_SELECT,SELF_GROUP_SELECT,SELF_GROUP_DELETE,SELF_TOKEN_INSERT,SELF_TOKEN_SELECT,SELF_TOKEN_UPDATE,SELF_TOKEN_DELETE,SELF_QUOTA_SELECT,SELF_TOKEN_GRANT_DELETE,SELF_TOKEN_GRANT_INSERT,SELF_SITE_SELECT,SELF_SITE_DELETE,SELF_SITE_INSERT,SELF_SITE_UPDATE,SELF_DOMAIN_INSERT,SELF_DOMAIN_SELECT,SELF_DOMAIN_DELETE,SELF_DOMAIN_UPDATE,SELF_DATABASE_INSERT,SELF_DATABASE_UPDATE,SELF_DATABASE_DELETE,SELF_DATABASE_SELECT,SELF_SUBDOMAIN_SELECT,SELF_SUBDOMAIN_UPDATE,SELF_SUBDOMAIN_INSERT,SELF_SUBDOMAIN_DELETE,SELF_ACCOUNT_DELETE,SELF_ACCOUNT_INSERT,SELF_ACCOUNT_SELECT,SELF_ACCOUNT_UPDATE,SELF_APP_INSERT,SELF_APP_DELETE,SELF_APP_UPDATE,SELF_APP_SELECT,SELF_MESSAGE_INSERT,SELF_MESSAGE_UPDATE,SELF_MESSAGE_SELECT,SELF_MESSAGE_DELETE,SELF_LOG_SELECT,SELF_LOG_INSERT,SELF_LOG_UPDATE,SELF_LOG_DELETE,SELF_BACKUP_SELECT,SELF_BACKUP_UPDATE,SELF_BACKUP_INSERT,SELF_BACKUP_DELETE'), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
$token = $result['token'];

// ADD USER QUOTAS
api::send('quota/user/add', array('user'=>$uid, 'quotas'=>'SITES,DATABASES,DOMAINS,BYTES,MAILS'), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
api::send('quota/user/update', array('user'=>$uid, 'quota'=>'SITES', 'max'=>1), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
api::send('quota/user/update', array('user'=>$uid, 'quota'=>'DATABASES', 'max'=>3), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
api::send('quota/user/update', array('user'=>$uid, 'quota'=>'DOMAINS', 'max'=>3), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
api::send('quota/user/update', array('user'=>$uid, 'quota'=>'BYTES', 'max'=>500), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
api::send('quota/user/update', array('user'=>$uid, 'quota'=>'MAILS', 'max'=>100), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);

$email = str_replace(array('{EMAIL}', '{USER}', '{PASS}'), array($_POST['email'], $_POST['user'], $_POST['password']), $lang['mail_add']);
mail($_POST['email'], $lang['subject'], str_replace('{CONTENT}', $email, $GLOBALS['CONFIG']['MAIL_TEMPLATE']), "MIME-Version: 1.0\r\nContent-type: text/html; charset=utf-8\r\nFrom: Olympe <no-reply@olympe.in>\r\n");
$email2 = str_replace(array('{EMAIL}', '{USER}', '{PASS}'), array($_POST['email'], $_POST['user'], '**********'), $lang['mail_add']);
mail('contact@olympe.in', $lang['subject'], str_replace('{CONTENT}', $email2, $GLOBALS['CONFIG']['MAIL_TEMPLATE']), "MIME-Version: 1.0\r\nContent-type: text/html; charset=utf-8\r\nFrom: Olympe <no-reply@olympe.in>\r\n");
	
$_SESSION['MESSAGE']['TYPE'] = 'success';
$_SESSION['MESSAGE']['TEXT']= $lang['success'];

template::redirect('/admin/users/detail?id='. $uid);



/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>