<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$params = array();
$params['title'] = $_POST['title'];
$params['description'] = $_POST['desc'];
$params['content'] = $_POST['content'];
$params['author'] = $_POST['author'];
$params['language'] = $_POST['lang'];

api::send('news/add', $params);

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	$template->redirect('/admin/blog');

?>
