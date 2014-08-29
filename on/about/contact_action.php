<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

if( $security->hasAccess('/panel') )
	$user = security::get('USER');
else {
	$user = htmlspecialchars($_POST['account']);
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

$message = "
Name: ".htmlspecialchars($_POST['name'])."
Email: ".htmlspecialchars($_POST['email'])."
Subject: ".htmlspecialchars($_POST['subject'])."
Compte: {$user}

Message: ".htmlspecialchars($_POST['message'])."
";

mail("contact@olympe.in", "[Olympe] {$_POST['subject']}", $message, "From: ".security::encode($_POST['email']));

$_SESSION['MESSAGE']['TYPE'] = 'success';
$_SESSION['MESSAGE']['TEXT']= $lang['success'];

template::redirect('/about/contact');

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>