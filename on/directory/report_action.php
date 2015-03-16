<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$site = api::send('site/list', array('id'=>$_POST['site']), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
$site = $site[0];

$email = str_replace(array('{SITE}', '{DESCRIPTION}', '{CONTENT}'), array($site['hostname'], $_POST['title'], $_POST['content']), $lang['content']);
mail('contact@olympe.in', $lang['subject'], str_replace('{CONTENT}', $email, $GLOBALS['CONFIG']['MAIL_TEMPLATE']), "MIME-Version: 1.0\r\nContent-type: text/html; charset=utf-8\r\nFrom: Olympe <no-reply@olympe.in>\r\n");

$_SESSION['MESSAGE']['TYPE'] = 'success';
$_SESSION['MESSAGE']['TEXT']= $lang['success'];

template::redirect('/directory/site?id=' . security::encode($_POST['s']));

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>