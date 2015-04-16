<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$m_parent = htmlspecialchars($_POST['parent']);
$m_title = htmlspecialchars($_POST['title']);
$m_quota = htmlspecialchars($_POST['quota']);
$m_max = htmlspecialchars($_POST['max']);
$m_content = htmlspecialchars($_POST['content']);

if( !$m_parent )
{
	$message = "[i]{$lang['type']}[/i] {$lang['quota']}
[i]{$lang['select']}[/i] {$m_quota}
[i]{$lang['request']}[/i] {$m_max}

{$m_content}
	";
}
else
{
	$message = $m_content;
	api::send('self/message/update', array('id'=>$m_parent, 'status'=>1));
}	

$params = array();
$params['content'] = bbcode::encode($message);
$params['type'] = 1;
if( $m_title )
	$params['title'] = $m_title;
if( $m_parent )
	$params['parent'] = $m_parent;

try
{
	api::send('self/message/add', $params);
}
catch( Exception $e )
{
	$_SESSION['MESSAGE']['TYPE'] = 'error';
	$_SESSION['MESSAGE']['TEXT']= $lang['error'];	
}

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else if( $m_parent )
		$template->redirect('/panel/messages/detail?id=' . security::encode($m_parent));
else
	$template->redirect('/panel/messages');

?>
