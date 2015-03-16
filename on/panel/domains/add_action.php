<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$blocked = file("{$GLOBALS['CONFIG']['SITE']}/panel/domains/domainname_blacklist.txt");
$domain = htmlspecialchars(strtolower($_POST['domain']));

foreach ($blocked as $line_num => $blocked_keyword) {
	$blocked_keyword = trim($blocked_keyword);
	if (strpos($domain, $blocked_keyword) !== false) {
		$_SESSION['MESSAGE']['TYPE'] = 'error';
		$_SESSION['MESSAGE']['TEXT']= $lang['blocked'];
		$template->redirect('/panel/domains');
		exit();
	}
}

try
{
	if( $_POST['dir'] == $lang['folder'] )
		$_POST['dir'] = '';

	api::send('self/domain/add', array('domain'=>$_POST['domain'], 'site'=>$_POST['subdomain'], 'dir'=>$_POST['dir']));
}
catch( Exception $e )
{
	$_SESSION['MESSAGE']['TYPE'] = 'error';
	$_SESSION['MESSAGE']['TEXT'] = $lang['error'];	
}

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	$template->redirect('/panel/domains');

?>
