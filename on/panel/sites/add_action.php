<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

class analyse
{
	public static function contain  ( $search, $string )
	{
		if ( strpos( "{$string}", $search ) !== false )
			return true;
		if ( levenshtein( $string, $search ) <= 2 )
			return true;
		if ( soundex("{$string}")  == soundex("{$search}") )
			return true;
			
		return false;
	}	
}

if($_POST['subdomain'] != '' && $_POST['password'] != '') {
	
	$blocked = file("{$GLOBALS['CONFIG']['SITE']}/panel/sites/sitename_blacklist.txt");
	$subdomain = htmlspecialchars(strtolower($_POST['subdomain']));

	foreach ($blocked as $line => $keyword ) {
		$keyword = trim( $keyword );
		if ( analyse::contain ( $subdomain, $keyword ) ) 
		{
			$_SESSION['MESSAGE']['TYPE'] = 'error';
			$_SESSION['MESSAGE']['TEXT']= $lang['blocked'];
			$template->redirect('/panel');
			exit();
		}
	}

	try
	{
		api::send('self/site/add', array('site'=>$subdomain, 'pass'=>$_POST['password']));
		unset($_SESSION['subdomain']);
	}
	catch( Exception $e )
	{
		$_SESSION['MESSAGE']['TYPE'] = 'error';
		$_SESSION['MESSAGE']['TEXT']= $lang['error'];
	}
	
} else {
	$_SESSION['MESSAGE']['TYPE'] = 'error';
	$_SESSION['MESSAGE']['TEXT']= $lang['empty'];
}

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	$template->redirect('/panel');

?>
