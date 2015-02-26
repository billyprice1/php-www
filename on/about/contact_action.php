<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

if( $security->hasAccess('/panel') )
	$user = security::get('USER');
else {
	$user = utf8_decode(htmlspecialchars($_POST['account']));
}

if($_POST['phone'] == '') { // Honeypot (antispam) - hide field should be empty

	/** - Checking about empty fields */
	if($_POST['email']=='' || $_POST['subject']=='' || $_POST['message']=='') {
		$_SESSION['MESSAGE']['TYPE'] = 'error';
		$_SESSION['MESSAGE']['TEXT']= $lang['error_empty_field'];
		template::redirect('/about/contact');
	}

	/** Checking email format */
	if(! filter_var(security::encode($_POST['email']), FILTER_VALIDATE_EMAIL)) {
		$_SESSION['MESSAGE']['TYPE'] = 'error';
		$_SESSION['MESSAGE']['TEXT']= $lang['error_email_wrong'];
		template::redirect('/about/contact');
	}

	/** Checking referer */
	if ($_SERVER["HTTP_REFERER"] != "https://{$_SERVER["HTTP_HOST"]}/about/contact" && $_SERVER["HTTP_REFERER"] != "http://{$_SERVER["HTTP_HOST"]}/about/contact") {
		$_SESSION['MESSAGE']['TYPE'] = 'error';
		$_SESSION['MESSAGE']['TEXT']= $lang['error_referer'];
		template::redirect('/about/contact');
	}

	/** Comparing fields (human user) */
	if(($_POST['ck1'] != $_POST['ck2']) || $_POST['email2'] != '') {
		$_SESSION['MESSAGE']['TYPE'] = 'error';
		$_SESSION['MESSAGE']['TEXT']= $lang['error_js'];
		template::redirect('/about/contact');
	}

	if(!isset($_SESSION[$_POST['random']])) {
		$_SESSION['MESSAGE']['TYPE'] = 'error';
		$_SESSION['MESSAGE']['TEXT']= $lang['error_referer'] . "23";
		template::redirect('/about/contact');
	}

	$ip = $_SERVER['HTTP_X_REAL_IP'];
	$subject = utf8_decode(htmlspecialchars($_POST['subject']));
	$language = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
	$browser = htmlspecialchars(addslashes($_SERVER['HTTP_USER_AGENT']));

	$message = "
	Nom : ".utf8_decode(htmlspecialchars($_POST['name']))."
	Email : ".utf8_decode(htmlspecialchars($_POST['email']))."
	Sujet : {$subject}
	Compte : {$user}
	Langage du navigateur : {$language}
	Navigateur : {$browser}
	IP : {$ip}

	Message : ".utf8_decode(htmlspecialchars($_POST['message']))."
	";

	mail("contact@olympe.in", "[Olympe] [Contact] {$subject}", $message, "From: ".security::encode($_POST['email']));

	$_SESSION['MESSAGE']['TYPE'] = 'success';
	$_SESSION['MESSAGE']['TEXT']= $lang['success'];

} 

template::redirect('/about/contact');

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>