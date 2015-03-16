<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

if( $_POST['name'] != '' )
{
	$user = api::send('user/select', array('user'=>$_POST['name'], 'search'=>1));
	
	if( count($user) > 1 )
	{
		$content = "
		<div class=\"panel\">
			<div class=\"top\">
				<div class=\"left\" style=\"padding-top: 5px;\">
					<h1 class=\"dark\">{$lang['title']}</h1>
				</div>
				<div class=\"right\">
					
				</div>
			</div>
			<div class=\"clear\"></div><br />
			<div class=\"container\">
				<table>
					<tr>
						<th style=\"width: 40px; text-align: center;\">#</th>
						<th>{$lang['name']}</th>
						<th>{$lang['email']}</th>
						<th>{$lang['date']}</th>
						<th>{$lang['ip']}</th>
						<th  style=\"width: 50px; text-align: center;\">{$lang['actions']}</th>
					</tr>";

		foreach( $user as $u )
		{
			$content .= "
					<tr>
						<td style=\"width: 40px; text-align: center;\"><a href=\"/admin/users/detail?id={$u['id']}\"><img style=\"width: 30px; height: 30px;\" src=\"".(file_exists("{$GLOBALS['CONFIG']['SITE']}/images/users/{$u['id']}.png")?"/{$GLOBALS['CONFIG']['SITE']}/images/users/{$u['id']}.png":"/{$GLOBALS['CONFIG']['SITE']}/images/users/user.png")."\" /></a></td>
						<td>{$u['name']}</td>
						<td>{$u['email']}</td>
						<td>".date('Y-m-d', $u['date'])."</td>
						<td>{$u['ip']}</td>
						<td style=\"width: 50px; text-align: center;\">
							<a href=\"/admin/users/detail?id={$u['id']}\" title=\"\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/large/settings.png\" alt=\"\" /></a>
						</td>
					</tr>
			";
		}
	
		$content .= "
				</table>
			</div>
		</div>
		";

		$template->output($content);
	}
	else if( count($user) == 1 )
		$template->redirect('/admin/users/detail?id='.$user[0]['id']);
	else
		template::redirect('/admin?error=user');
		
}
else if( $_POST['email'] != '' )
{
	$user = api::send('user/select', array('email'=>$_POST['email']));

	if( count($user) > 1 )
	{
		$content = "
		<div class=\"panel\">
			<div class=\"top\">
				<div class=\"left\" style=\"padding-top: 5px;\">
					<h1 class=\"dark\">{$lang['title']}</h1>
				</div>
				<div class=\"right\">
					
				</div>
			</div>
			<div class=\"clear\"></div><br />
			<div class=\"container\">
				<table>
					<tr>
						<th style=\"width: 40px; text-align: center;\">#</th>
						<th>{$lang['name']}</th>
						<th>{$lang['email']}</th>
						<th>{$lang['date']}</th>
						<th>{$lang['ip']}</th>
						<th  style=\"width: 50px; text-align: center;\">{$lang['actions']}</th>
					</tr>";

		foreach( $user as $u )
		{
			$content .= "
					<tr>
						<td style=\"width: 40px; text-align: center;\"><a href=\"/admin/users/detail?id={$u['id']}\"><img style=\"width: 30px; height: 30px;\" src=\"".(file_exists("{$GLOBALS['CONFIG']['SITE']}/images/users/{$u['id']}.png")?"/{$GLOBALS['CONFIG']['SITE']}/images/users/{$u['id']}.png":"/{$GLOBALS['CONFIG']['SITE']}/images/users/user.png")."\" /></a></td>
						<td>{$u['name']}</td>
						<td>{$u['email']}</td>
						<td>".date('Y-m-d', $u['date'])."</td>
						<td>{$u['ip']}</td>
						<td style=\"width: 50px; text-align: center;\">
							<a href=\"/admin/users/detail?id={$u['id']}\" title=\"\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/large/settings.png\" alt=\"\" /></a>
						</td>
					</tr>
			";
		}
	
		$content .= "
				</table>
			</div>
		</div>
		";

		$template->output($content);
	}
	else if( count($user) == 1 )
		$template->redirect('/admin/users/detail?id='.$user[0]['id']);
	else
		template::redirect('/admin');
}
else if( $_POST['site'] != '' )
{
	try
	{
		$site = api::send('site/select', array('site'=>$_POST['site']));
	}
	catch(Exception $e )
	{
		template::redirect('/admin?error=site');
	}

	$template->redirect('/admin/users/detail?id='.$site[0]['user']['id']);
}
else if( $_POST['domain'] != '' )
{
	try
	{
		$domain = api::send('domain/select', array('domain'=>$_POST['domain']));
	}
	catch(Exception $e )
	{	
		template::redirect('/admin?error=domain');
	}

	$template->redirect('/admin/users/detail?id='.$domain[0]['user']['id']);
}
else
	template::redirect('/admin');

?>