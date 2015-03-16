<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$banned = array();
$handle = fopen(__DIR__ . '/banned.txt', 'r');
if( $handle )
{
	while( ($line = fgets($handle)) !== false )
		$banned[] = trim($line);
}

if( isset($_POST['antispam']) && $_POST['antispam'] == $_SESSION['ANTISPAM'] && $_POST['conditions'] == 1 )
{
	try
	{
		unset($_SESSION['ANTISPAM']);
		$_SESSION['JOIN_EMAIL'] = $_POST['email'];
		$parts = explode('@', $_POST['email']);

		if( array_search($parts[1], $banned) !== false )
			throw new SiteException('Invalid or missing arguments', 400, 'Parameter email is on a spammer domain');

		if( in_array(gethostbyname($parts[1]), array(gethostbyname('ns1.olympe.in'), gethostbyname('ns2.olympe.in'), gethostbyname('mx1.anotherservice.com'), gethostbyname('mx2.anotherservice.com'))) )
			throw new SiteException('Invalid or missing arguments', 400, 'Email does not exist');
	
		$result = api::send('registration/add', array('auth'=>'', 'email'=>$_POST['email']), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);

		$email = str_replace(array('{EMAIL}', '{CODE}', '{DOMAIN}'), array($_POST['email'], $result['code'], $_SERVER["HTTP_HOST"]), $lang['content']);
		$result = mail($_POST['email'], $lang['subject'], str_replace('{CONTENT}', $email, $GLOBALS['CONFIG']['MAIL_TEMPLATE']), "MIME-Version: 1.0\r\nContent-type: text/html; charset=utf-8\r\nFrom: Olympe <no-reply@olympe.in>\r\n");
		
		$_SESSION['MESSAGE']['TYPE'] = 'success';
		$_SESSION['MESSAGE']['TEXT']= $lang['success'];
	}
	catch(Exception $e)
	{
		$_SESSION['FORM']['OPEN'] = 'signup';
		$template->redirect($_SERVER['HTTP_REFERER'] . (strstr($_SERVER['HTTP_REFERER'], 'esignup')===false?"?esignup":""));
	}
}
else
{
	$_SESSION['FORM']['OPEN'] = 'signup';
	$template->redirect($_SERVER['HTTP_REFERER'] . (strstr($_SERVER['HTTP_REFERER'], 'esignup')===false?"?esignup":""));
}

$template->redirect($_SERVER['HTTP_REFERER']);

?>