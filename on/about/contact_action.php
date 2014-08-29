<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

if( $security->hasAccess('/panel') )
	$user = security::get('USER');
else {
	$user = htmlspecialchars(utf8_decode($_POST['account']));
}

if($_POST['email']=='' || $_POST['subject']=='' || $_POST['message']=='') {
	$_SESSION['MESSAGE']['TYPE'] = 'error';
	$_SESSION['MESSAGE']['TEXT']= $lang['empty_field'];
	template::redirect('/about/contact');
}

if(! filter_var(security::encode($_POST['email']), FILTER_VALIDATE_EMAIL)) {
	$_SESSION['MESSAGE']['TYPE'] = 'error';
	$_SESSION['MESSAGE']['TEXT']= $lang['email_wrong'];
	template::redirect('/about/contact');
}

$ip = $_SERVER['HTTP_X_REAL_IP'];
$subject = htmlspecialchars(utf8_decode($_POST['subject']));

$message = "
Nom : ".htmlspecialchars(utf8_decode($_POST['name']))."
Email : ".htmlspecialchars(utf8_decode($_POST['email']))."
Sujet : {$subject}
Compte : {$user}
IP : {$ip}

Message : ".htmlspecialchars(utf8_decode($_POST['message']))."
";

mail("contact@olympe.in", "[Olympe] [Contact] {$subject}", $message, "From: ".security::encode($_POST['email']));

$_SESSION['MESSAGE']['TYPE'] = 'success';
$_SESSION['MESSAGE']['TEXT']= $lang['success'];

template::redirect('/about/contact');

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>