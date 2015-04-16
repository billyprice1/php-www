<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$m_title = htmlspecialchars();
$m_parent = htmlspecialchars();
$m_quota = htmlspecialchars($_POST['quota']);
$m_max = htmlspecialchars($_POST['max']);
$m_content = htmlspecialchars($_POST['content']);

if( !$_POST['parent'] )
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
	api::send('message/update', array('id'=>$m_parent, 'status'=>2));
	
	// send email
	$msg = api::send('message/list', array('id'=>$m_parent));
	$msg = $msg[0];
	$user = api::send('user/list', array('id'=>$msg['user']['id']));
	$user = $user[0];
	
	$email = str_replace(array('{ID}'), array($msg['id']), $lang['content']);
	mail($user['email'], $lang['subject'], str_replace('{CONTENT}', $email, $GLOBALS['CONFIG']['MAIL_TEMPLATE']), "MIME-Version: 1.0\r\nContent-type: text/html; charset=utf-8\r\nFrom: Olympe <no-reply@olympe.in>\r\n");
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

if(isset($_POST['close']) && ($_POST['close']==1)) 
	api::send('message/update', array('id'=>$m_parent, 'status'=>3));

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	$template->redirect('/admin/messages/detail?id='.$m_parent);

?>
