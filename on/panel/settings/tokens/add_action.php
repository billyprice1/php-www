<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$name = htmlspecialchars($_POST['name']);
$token_type = htmlspecialchars($_POST['type']);

if($name == 'Olympe') {
	$_SESSION['MESSAGE']['TYPE'] = 'error';
	$_SESSION['MESSAGE']['TEXT']= $lang['error'];	
	
	template::redirect('/panel/settings/tokens');
	exit;
}

switch( $token_type )
{
	case 'admin':
		api::send('self/token/add', array('name'=>$name, 'lease'=>'never', 'grants'=>'ACCESS,SELF_SELECT,SELF_UPDATE,SELF_DELETE,SELF_GRANT_SELECT,SELF_GROUP_SELECT,SELF_GROUP_DELETE,SELF_TOKEN_INSERT,SELF_TOKEN_SELECT,SELF_TOKEN_UPDATE,SELF_TOKEN_DELETE,SELF_QUOTA_SELECT,SELF_TOKEN_GRANT_DELETE,SELF_TOKEN_GRANT_INSERT,SELF_SITE_SELECT,SELF_SITE_DELETE,SELF_SITE_INSERT,SELF_SITE_UPDATE,SELF_DOMAIN_INSERT,SELF_DOMAIN_SELECT,SELF_DOMAIN_DELETE,SELF_DOMAIN_UPDATE,SELF_DATABASE_INSERT,SELF_DATABASE_UPDATE,SELF_DATABASE_DELETE,SELF_DATABASE_SELECT,SELF_SUBDOMAIN_SELECT,SELF_SUBDOMAIN_UPDATE,SELF_SUBDOMAIN_INSERT,SELF_SUBDOMAIN_DELETE,SELF_ACCOUNT_DELETE,SELF_ACCOUNT_INSERT,SELF_ACCOUNT_SELECT,SELF_ACCOUNT_UPDATE,SELF_APP_INSERT,SELF_APP_DELETE,SELF_APP_UPDATE,SELF_APP_SELECT,SELF_MESSAGE_INSERT,SELF_MESSAGE_UPDATE,SELF_MESSAGE_SELECT,SELF_MESSAGE_DELETE'));
	break;
	case 'dba':
		api::send('self/token/add', array('name'=>$name, 'lease'=>'never', 'grants'=>'ACCESS,SELF_DATABASE_INSERT,SELF_DATABASE_SELECT,SELF_DATABASE_UPDATE,SELF_DATABASE_DELETE'));
	break;
	case 'site':
		api::send('self/token/add', array('name'=>$name, 'lease'=>'never', 'grants'=>'ACCESS,SELF_SITE_INSERT,SELF_SITE_SELECT,SELF_SITE_UPDATE,SELF_SITE_DELETE'));
	break;
	case 'domain':
		api::send('self/token/add', array('name'=>$name,  'lease'=>'never', 'grants'=>'ACCESS,SELF_DOMAIN_INSERT,SELF_DOMAIN_DELETE,SELF_DOMAIN_UPDATE,SELF_DOMAIN_SELECT,SELF_ACCOUNT_INSERT,SELF_ACCOUNT_DELETE,SELF_ACCOUNT_SELECT,SELF_ACCOUNT_UPDATE'));
	break;
	case 'blank':
		api::send('self/token/add', array('name'=>$name, 'lease'=>'never'));
	break;
}

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	template::redirect('/panel/settings/tokens');

?>