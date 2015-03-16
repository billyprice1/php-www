<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

if( !isset($_SESSION['RECOVERY_ATTEMPTS']) )
	$_SESSION['RECOVERY_ATTEMPTS'] = 0;
	
if( isset($_POST['antispam']) && $_POST['antispam'] == $_SESSION['ANTISPAM'] )
{
	try
	{
		unset($_SESSION['ANTISPAM']);
		
		$_SESSION['RECOVERY_ATTEMPTS']++;
		if( $_SESSION['RECOVERY_ATTEMPTS'] > 5 )
			throw new Exception("SPAM");
		
	
		$result = api::send('user/list', array('auth'=>'', 'user'=>$_POST['username']), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);

		foreach( $result as $r )
		{
			if( $r['name'] == $_POST['username'] )
			{
				if( strlen($r['email']) < 5 )
					throw new Exception("Bad email");

				$tokenresult = api::send('token/insert', array('user'=>$r['id'], 'lease'=>time()+10800, 'name'=>'Recovery', 'grants'=>'ACCESS,SELF_UPDATE,SELF_SELECT,SELF_GRANT_SELECT,SELF_TOKEN_SELECT,SELF_TOKEN_UPDATE,SELF_TOKEN_GRANT_INSERT,SELF_TOKEN_GRANT_DELETE'), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
				$token = $tokenresult['token'];
				
				$email = str_replace(array('{USER}', '{TOKEN}'), array($_POST['username'], $token), $lang['content']);
				mail($r['email'], $lang['subject'], str_replace('{CONTENT}', $email, $GLOBALS['CONFIG']['MAIL_TEMPLATE']), "MIME-Version: 1.0\r\nContent-type: text/html; charset=utf-8\r\nFrom: Olympe <no-reply@olympe.in>\r\n");
				
				if( isset($_SESSION['RECOVERY_ATTEMPTS']) )
					unset($_SESSION['RECOVERY_ATTEMPTS']);
					
				$_SESSION['MESSAGE']['TYPE'] = 'success';
				$_SESSION['MESSAGE']['TEXT']= $lang['success'];

				$_SERVER['HTTP_REFERER'] = str_replace(array('?elogin&erecovery', '?elogin', '?elogin#'), array('', '', ''), $_SERVER['HTTP_REFERER']);
				
				$template->redirect($_SERVER['HTTP_REFERER']);
			}
		}
		throw new Exception("User not found");
	}
	catch(Exception $e)
	{
		if( $GLOBALS['CONFIG']['DEBUG'] )
			throw $e;
		else
			$template->redirect($_SERVER['HTTP_REFERER'] . (strstr($_SERVER['HTTP_REFERER'], 'erecovery')===false?"&erecovery":""));
	}
}
else
	$template->redirect($_SERVER['HTTP_REFERER'] . (strstr($_SERVER['HTTP_REFERER'], 'erecovery')===false?"&erecovery":""));

?>