<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

if( strlen($_GET['id']) < 1 )
	template::redirect('/admin');

$user = api::send('user/list', array('id'=>$_GET['id']));

if( count($user) == 0 )
	template::redirect('/admin');
$user = $user[0];

if($user['comment'] == "0" || $user['comment'] == '')
	$user_comment = "";
else 
	$user_comment = $user['comment'];

$content = "
		<div class=\"admin\">
			<div class=\"top\">
				<div class=\"left\" style=\"width: 700px; padding-top: 5px;\">
					<h1 class=\"dark\">{$lang['title']} : {$user['name']}</h1>
				</div>
				<div class=\"right\" style=\"width: 360px;\">
					<a class=\"button classic\" href=\"#\" onclick=\"$('#user').val('{$user['id']}'); $('#delete').dialog('open'); return false;\" style=\"width: 180px; height: 22px; float: right;\">
						<span style=\"display: block; padding-top: 3px;\">{$lang['delete_user']}</span>
					</a>
					<a class=\"button classic\" href=\"#\" onclick=\"$('#user10').val('{$user['id']}'); $('#email').dialog('open'); return false;\" style=\"width: 80px; height: 22px; float: right; margin-right: 15px;\">
						<span style=\"display: block; padding-top: 3px;\">{$lang['email_help']}</span>
					</a>
				</div>
			</div>
			<div class=\"clear\"></div><br />
			
			<div class=\"container\">
				<div style=\"width: 700px; float: left;\">
				
				
					<div class=\"comments\">
						<form action=\"/admin/users/update_action\" method=\"post\">
							<div style=\"float: left; width: 300px; padding-top: 5px;\">
								<h2 class=\"dark\" style=\"padding-top: 7px;\" id=\"comments\">{$lang['comments']}</h2>
							</div>
							<div style=\"float: right; width: 200px;\">
								<input type=\"submit\" value=\"{$lang['update']}\" style=\"width: 100px; float: right;\">
							</div>
							<div class=\"clear\"></div>
							
							<input type=\"hidden\" name=\"action\" value=\"update_user_comment\" />
							<input type=\"hidden\" name=\"id\" value=\"{$user['id']}\" />
							<textarea style=\"width: 100%; box-sizing: border-box; font-family: inherit; font-size: 13px;\" name=\"user_comment\" id=\"admincomment\" placeholder=\"{$lang['no_comment']}\">{$user_comment}</textarea>
							
							<br />
						</form>
					</div>
					<br />
				
					<h2 class=\"dark\" id=\"sites\">{$lang['sites']}</h2>
					<table>
						<tr>
							<th style=\"width: 60px; text-align: center;\">{$lang['id']}</th>
							<th>{$lang['url']}</th>
							<th>{$lang['size']}</th>
							<th style=\"width: 50px; text-align: center;\">{$lang['actions']}</th>
						</tr>
";

if( security::hasGrant('SITE_SELECT') )
{
	$sites = api::send('site/list', array('user'=>$_GET['id']));
	
	foreach( $sites as $s )
	{
		$content .= "
						<tr>
							<td style=\"width: 60px; text-align: center;\">{$s['id']}</td>
							<td><a href=\"http://{$s['hostname']}\">{$s['hostname']}</a></td>
							<td>{$s['size']} {$lang['mb']}</td>
							<td style=\"width: 100px; text-align: center;\">
								<a href=\"#\" onclick=\"$('#site_overview_link').attr('href', '/admin/sites/overview_action?user={$user['id']}&site={$s['hostname']}'); $('#site_overview').attr('src','/{$GLOBALS['CONFIG']['SITE']}/images/sites/?url={$s['hostname']}'); $('#site_overview_name').text('{$s['hostname']}'); $('#overview').dialog('open'); return false;\" title=\"{$lang['overview']}\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/view.png\" alt=\"\" /></a>
								
								<a href=\"#\" onclick=\"$('#user6').val('{$user['id']}'); $('#site_id').val('{$s['id']}'); $('#deletesite').dialog('open'); return false;\" title=\"{$lang['delete_site']}\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/close.png\" alt=\"\" /></a>
							</td>
						</tr>";
	}
}

$content .= "
					</table>
					<br /><br />
					<h2 class=\"dark\" id=\"backups\">{$lang['backups']}</h2>
					<table>
						<tr>
							
							<th>{$lang['type']}</th>
							<th>{$lang['name']}</th>
							<th>{$lang['date']}</th>
							<th style=\"width: 100px; text-align: center;\">{$lang['actions']}</th>
						</tr>
";
		
if( security::hasGrant('BACKUP_SELECT') )
{
	$backups = api::send('backup/list', array('user'=>$_GET['id']));
	
	foreach( $backups as $b )
	{		
		$content .= "
						<tr>
							
							<td>".$lang['type_' . $b['type']]."</td>
							<td>{$b['title']}</td>
							<td>".date($lang['dateformat'], $b['date'])."</td>
							<td style=\"width: 100px; text-align: center;\">
								<a href=\"{$b['url']}\" title=\"\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/download2.png\" alt=\"\" /></a>
								<a href=\"#\" onclick=\"$('#user5').val('{$user['id']}'); $('#backup_id').val('{$b['id']}'); $('#deletebackup').dialog('open'); return false;\" title=\"\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/close.png\" alt=\"\" /></a>
							</td>
						</tr>
		";
	}
}

$content .= "
					</table>
					<br /><br />
					<h2 class=\"dark\" id=\"domains\">{$lang['domains']}</h2>
					<table>
						<tr>
							<th style=\"width: 60px; text-align: center;\">{$lang['id']}</th>
							<th>{$lang['domain']}</th>
							<th>{$lang['arecord']}</th>
							<th>{$lang['target']}</th>
							<th style=\"width: 50px; text-align: center;\">{$lang['actions']}</th>
						</tr>
";
		
if( security::hasGrant('DOMAIN_SELECT') )
{
	$domains = api::send('domain/list', array('user'=>$_GET['id']));
	
	foreach( $domains as $d )
	{		
		$content .= "
						<tr>
							<td style=\"width: 60px; text-align: center;\">{$d['id']}</td>
							<td>{$d['hostname']}</td>
							<td>{$d['aRecord']}</td>
							<td>".($d['destination']?"{$d['destination']}":"{$d['homeDirectory']}")."</td>
							<td style=\"width: 50px; text-align: center;\">
								<a href=\"#\" onclick=\"$('#user8').val('{$user['id']}'); $('#domain_id').val('{$d['id']}'); $('#deletedomain').dialog('open'); return false;\" title=\"\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/close.png\" alt=\"\" /></a>
							</td>
						</tr>";
	}
}

$content .= "
					</table>
					<br /><br />
					<h2 class=\"dark\" id=\"accounts\">{$lang['accounts']}</h2>
					<table>
						<tr>
							<th style=\"width: 60px; text-align: center;\">{$lang['id']}</th>
							<th>{$lang['name']}</th>
							<th>{$lang['size']}</th>
							<th style=\"width: 50px; text-align: center;\">{$lang['actions']}</th>
						</tr>
";
		
if( security::hasGrant('ACCOUNT_SELECT') )
{
	foreach( $domains as $d )
	{		
		$accounts = api::send('account/list', array('user'=> $user['id'], 'domain'=>$d['hostname']));
	
		foreach( $accounts as $a )
		{
			$content .= "
						<tr>
							<td style=\"width: 60px; text-align: center;\">{$a['id']}</td>
							<td>{$a['mail']}</td>
							<td>{$a['size']} {$lang['mb']}</td>
							<td style=\"width: 50px; text-align: center;\">
								<a href=\"#\" onclick=\"$('#user9').val('{$user['id']}'); $('#domain').val('{$d['hostname']}'); $('#account_id').val('{$a['id']}'); $('#deletemail').dialog('open'); return false;\" title=\"\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/close.png\" alt=\"\" /></a>
							</td>
						</tr>";
		}
	}
}

$content .= "
					</table>
					<br /><br />		
					<h2 class=\"dark\" id=\"databases\">{$lang['databases']}</h2>
					<table>
						<tr>
							<th>{$lang['type']}</th>
							<th>{$lang['server']}</th>
							<th>{$lang['database']}</th>
							<th>{$lang['size']}</th>
							<th style=\"width: 50px; text-align: center;\">{$lang['actions']}</th>
						</tr>
";
		
if( security::hasGrant('DATABASE_SELECT') )
{
	$databases = api::send('database/list', array('user'=>$_GET['id']));
	
	foreach( $databases as $d )
	{		
		$content .= "
						<tr>
							<td>{$d['type']}</td>
							<td>{$d['server']}</td>
							<td>{$d['name']}</td>
							<td>{$d['size']} {$lang['mb']}</td>
							<td style=\"width: 50px; text-align: center;\">
								<a href=\"#\" onclick=\"$('#user7').val('{$user['id']}'); $('#db_id').val('{$d['name']}'); $('#deletedatabase').dialog('open'); return false;\" title=\"\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/close.png\" alt=\"\" /></a>
							</td>
						</tr>";
	}
}

$content .= "
					</table>
					<br /><br />					
					<div style=\"float: left; width: 300px; padding-top: 5px;\">
						<h2 class=\"dark\" style=\"padding-top: 7px;\" id=\"tokens\">{$lang['tokens']}</h2>
					</div>
					<div style=\"float: right; width: 200px;\">
						<a class=\"button classic\" href=\"#\" onclick=\"$('#user3').val('{$user['id']}'); $('#newtoken').dialog('open'); return false;\" style=\"width: 22px; height: 22px; float: right;\">
							<img style=\"float: left;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/plus-white.png\" alt=\"\" />
						</a>
					</div>
					<div class=\"clear\"></div>
					<br />
					<table>
						<tr>
							<th>{$lang['tokenname']}</th>
							<th>{$lang['tokenvalue']}</th>
							<th style=\"width: 100px; text-align: center;\">{$lang['actions']}</th>
						</tr>
	";

if( security::hasGrant('TOKEN_SELECT') )
{
	$tokens = api::send('token/list', array('user'=>$_GET['id']));
	
	foreach( $tokens as $t )
	{
		$content .= "
					<tr>
						<td>{$t['name']}</td>
						<td>{$t['token']}</td>
						<td style=\"width: 100px; text-align: center;\">
		";
		
		if( $t['name'] == "Olympe" ) 
			$content .= "
							<a href=\"/admin/tokens/send_action?user={$_GET['id']}&token={$t['token']}\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/mail.png\" alt=\"\" /></a>";
		
		if( security::hasGrant('TOKEN_UPDATE') )
		{
			$content .= "
							<a href=\"/admin/tokens/detail?user={$_GET['id']}&token={$t['token']}\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/settings.png\" alt=\"{$lang['update']}\" /></a>";
		}
		
		if( security::hasGrant('TOKEN_DELETE') )
		{
			$content .= "
							<a href=\"/admin/tokens/del_action?user={$_GET['id']}&token={$t['token']}\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/close.png\" alt=\"{$lang['delete']}\" /></a>";
		}
		
		$content .= "
						</td>
					</tr>";
	}

	$content .= "
				</table>";
}

$content .= "
				<br /><br />					
				<h2 class=\"dark\" id=\"messages\">{$lang['messages']}</h2>
				<table>
					<tr>
						<th>{$lang['subject']}</th>
						<th>{$lang['date']}</th>
						<th>{$lang['status']}</th>
						<th style=\"width: 50px; text-align: center;\">{$lang['actions']}</th>
					</tr>
	";


if( security::hasGrant('MESSAGE_SELECT') )
{
	$messages = api::send('message/list', array('user'=>$_GET['id'], 'topic'=>1));
	
	foreach( $messages as $m )
	{
		$content .= "
						<tr>
							<td><a href=\"/admin/messages/detail?id={$m['id']}\" title=\"\">{$m['title']}</a></td>
							<td>".date($lang['dateformat'], $m['date'])."</td>
							<td>".$lang['status_' . $m['status']]."</td>
							<td style=\"width: 50px; text-align: center;\">
								<a href=\"/admin/messages/detail?id={$m['id']}\" title=\"\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/preview.png\" alt=\"\" /></a>
							</td>
						</tr>
		";
	}

	$content .= "
				</table>";
}

$content .= "<br /><br />";

if( security::hasGrant('QUOTA_USER_SELECT') )
{
	$userquotas = api::send('quota/user/list', array('user'=>$_GET['id']));

	$content .= "
				<div style=\"float: left; width: 300px; padding-top: 5px;\">
					<h2 class=\"dark\" style=\"padding-top: 7px;\" id=\"quotas\">{$lang['quotas']} (".date($lang['dateformat'], $user['last']).")</h2>
				</div>
				<div style=\"float: right; width: 200px;\">
					<a class=\"button classic\" href=\"/admin/quotas/refresh_action?id={$user['id']}\" style=\"width: 22px; height: 22px; float: right;\">
						<img style=\"float: left;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/refresh-white.png\" alt=\"\" />
					</a>
				</div>
				<div class=\"clear\"></div>
				<br />
				<table>
					<tr>
						<th style=\"width: 100px;\">{$lang['quotaname']}</th>
						<th>{$lang['quotavalue']}</th>
						<th style=\"width: 50px; text-align: center;\">{$lang['actions']}</th>
					</tr>
						";
	
	$disabled = array('add'=>'', 'del'=>'', 'set'=>'');
	if( !security::hasGrant('QUOTA_USER_INSERT') )
		$disabled['add'] = 'disabled';
	if( security::hasGrant('QUOTA_USER_DELETE') )
		$disabled['del'] = 'disabled';
	if( security::hasGrant('QUOTA_USER_UPDATE') )
		$disabled['set'] = 'disabled';

	foreach( $userquotas as $u )
	{
		if( $u['max'] != 0 )
			$percent = $u['used']*100/$u['max'];
		
		if( $percent > 100 )
			$percent = 100;
			
		$content .= "
					<tr>
						<td>{$u['name']}</td>
						<td style=\"width: 300px;\">
							<div class=\"fillgraph\" style=\"margin-top: 10px;\">
								<small style=\"width: {$percent}%;\"></small>
							</div>
							<span class=\"quota\"><span style='font-weight: bold;'>{$u['used']}</span> {$lang['of']} {$u['max']}</span>
						</td>
						<td style=\"width: 50px; text-align: center;\">
							<a href=\"#\" onclick=\"$('#user2').val('{$user['id']}'); $('#quota').val('{$u['name']}'); $('#max').val('{$u['max']}'); $('#quotachange').dialog('open'); return false;\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/settings.png\" alt=\"{$lang['update']}\" /></a>
						</td>
					</tr>
		";
	}
	
	$content .= "
				</table>
				<br />
	";
}

$content .= "
			</div>
			<div style=\"width: 350px; float: right;\">
			";


if( security::hasGrant('USER_SELECT') )
{
	$content .= "			
				<h2 class=\"dark\">{$lang['infos']}</h2>
				<form action=\"/admin/users/update_action\" method=\"post\">
					<input type=\"hidden\" name=\"id\" value=\"{$user['id']}\" />
					<fieldset>
						<input style=\"width: 300px;\" type=\"password\" name=\"pass\" />
						<span class=\"help-block\">{$lang['pass_help']}</span>
					</fieldset>
					<fieldset>
						<input style=\"width: 300px;\" type=\"password\" name=\"confirm\" />
						<span class=\"help-block\">{$lang['confirm_help']}</span>
					</fieldset>
					<fieldset>
						<input style=\"width: 300px;\" type=\"text\" name=\"date\" value=\"".date($lang['dateformat'], $user['date'])."\" disabled />
						<span class=\"help-block\">{$lang['date_help']}</span>
					</fieldset>
					<fieldset>
						<input style=\"width: 300px;\" type=\"text\" name=\"email\" value=\"{$user['email']}\" />
						<span class=\"help-block\">{$lang['email_help']}</span>
					</fieldset>
					<fieldset>
						<input style=\"width: 300px;\" type=\"text\" name=\"email\" value=\"{$user['ip']}\" disabled />
						<span class=\"help-block\">{$lang['ip_help']}</span>
					</fieldset>
					<fieldset>
						<input style=\"width: 300px;\" type=\"text\" name=\"firstname\" value=\"{$user['firstname']}\" />
						<span class=\"help-block\">{$lang['firstname_help']}</span>
					</fieldset>
					<fieldset>
						<input style=\"width: 300px;\" type=\"text\" name=\"lastname\" value=\"{$user['lastname']}\" />
						<span class=\"help-block\">{$lang['lastname_help']}</span>
					</fieldset>
					<fieldset>
						<input style=\"width: 300px;\" type=\"text\" name=\"language\" placeholder=\"{$lang['lang_NO']}\" value=\"{$lang['lang_'.$user['language']]}\" disabled />
						<span class=\"help-block\">{$lang['language_help']}</span>
					</fieldset>
					<fieldset>
						<input type=\"hidden\" name=\"action\" value=\"update_user_infos\" />
						<input type=\"submit\" value=\"{$lang['update']}\" />
					</fieldset>
				</form>";
}

$content .= "
				<br />
";

if( security::hasGrant('GROUP_USER_SELECT') )
{
	$usergroups = api::send('group/user/list', array('user'=>$_GET['id']));
	if( security::hasGrant('GROUP_SELECT') )
		$groups = api::send('group/list');
	else
		$groups = $usergroups;

	$content .= "
					<h2 class=\"dark\">{$lang['groups']}</h2>
					<form action=\"/admin/users/join_action\" method=\"post\">
						<table>
							<tr>
								<th>{$lang['groupname']}</th>
								<th>{$lang['member']}</th>
							</tr>
	";

	if( security::hasGrant(array('GROUP_USER_INSERT','GROUP_USER_DELETE')) )
		$disabled = '';
	else
		$disabled = 'disabled';

	foreach( $groups as $g )
	{
		$checked = '';
		foreach( $usergroups as $g2 )
		{
			if( $g['id'] == $g2['id'] )
			{
				$checked = 'checked';
				break;
			}
		}

		$content .= "
						<tr>
							<td>{$g['name']}</td>
							<td class=\"center\">
								<input type=\"checkbox\" name=\"group[]\" value=\"{$g['id']}\" {$disabled} {$checked} />
							</td>
						</tr>";
	}

	$content .= "
					</table>
					<input type=\"hidden\" name=\"id\" value=\"{$user['id']}\" />
					<br />
					<input type=\"submit\" value=\"{$lang['update']}\" {$disabled} />
				</form>";
}

$content .= "
			</div>
			<div class=\"clear\"></div><br /><br />
			<h2 class=\"dark\">{$lang['sizes']}</h2>
			<table>
				<tr>
					<th style=\"text-align: center; width: 40px;\">#</th>
					<th>{$lang['name']}</th>
					<th>{$lang['type']}</th>
					<th>{$lang['path']}</th>
					<th>{$lang['size']}</th>
				</tr>
				<tr>
					<td style=\"text-align: center; width: 40px;\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/ftp.png\" /></td>
					<td>{$lang['cloud']}</td>
					<td>{$lang['cloud_type']}</td>
					<td>/dns/in/olympe/Users/{$user['name']}</td>
					<td><span style=\"font-weight: bold;\">{$user['size']} {$lang['mb']}</span></td>
				</tr>
";

foreach( $sites as $s )
{
	$content .= "
				<tr>
					<td style=\"text-align: center; width: 40px;\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/site.png\" /></td>
					<td>{$s['hostname']}</td>
					<td>{$lang['site']}</td>
					<td>{$s['homeDirectory']}</td>
					<td><span style=\"font-weight: bold;\">{$s['size']} {$lang['mb']}</span></td>
				</tr>
	";
}

foreach( $databases as $d )
{
	$content .= "
				<tr>
					<td style=\"text-align: center; width: 40px;\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/database.png\" /></td>
					<td>{$d['name']}</td>
					<td>{$lang['database2']} {$d['type']}</td>
					<td>/databases/{$d['name']}</td>
					<td><span style=\"font-weight: bold;\">{$d['size']} {$lang['mb']}</span></td>
				</tr>
	";
}

foreach( $domains as $d )
{
	$users = api::send('account/list', array('user'=> $user['id'], 'domain'=>$d['hostname']));
	
	foreach( $users as $u )
	{
		$content .= "
				<tr>
					<td style=\"text-align: center; width: 40px;\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/user.png\" /></td>
					<td>{$u['mail']}</td>
					<td>{$lang['account']}</td>
					<td>{$u['homeDirectory']}</td>
					<td><span style=\"font-weight: bold;\">{$u['size']} {$lang['mb']}</span></td>
				</tr>
		";
	}
}

$content .= "
			</table>
		</div>
		<div id=\"quotachange\" class=\"floatingdialog delete-link\">
			<br />
			<h3 class=\"center\">{$lang['quota']}</h3>
			<p style=\"text-align: center;\">{$lang['quota_text']}</p>
			<div class=\"form-small\">		
				<form action=\"/admin/users/set_quota_action\" method=\"post\" class=\"center\">
					<input id=\"user2\" type=\"hidden\" value=\"\" name=\"user\" />
					<input id=\"quota\" type=\"hidden\" value=\"\" name=\"quota\" />
					<fieldset>
						<input id=\"max\" type=\"text\" name=\"max\" value=\"\" />
						<span class=\"help-block\">{$lang['max_help']}</span>
					</fieldset>
					<fieldset autofocus>	
						<input type=\"submit\" value=\"{$lang['update']}\" />
					</fieldset>
				</form>
			</div>
		</div>
		<div id=\"delete\" class=\"floatingdialog delete-link\">
			<h3 class=\"center\">{$lang['delete_user']}</h3>
			<p style=\"text-align: center;\">{$lang['delete_user_text']}</p>
			<div class=\"form-small\">		
				<form action=\"/admin/users/del_action\" method=\"post\" class=\"center\">
					<input id=\"user\" type=\"hidden\" value=\"\" name=\"user\" />
					<fieldset autofocus>	
						<input type=\"submit\" value=\"{$lang['delete_now']}\" />
					</fieldset>
				</form>
			</div>
		</div>
		<div id=\"deletebackup\" class=\"floatingdialog delete-link\">
			<h3 class=\"center\">{$lang['delete_backup']}</h3>
			<p style=\"text-align: center;\">{$lang['delete_backup_text']}</p>
			<div class=\"form-small\">		
				<form action=\"/admin/backups/del_action\" method=\"post\" class=\"center\">
					<input id=\"user5\" type=\"hidden\" value=\"{$user['id']}\" name=\"user\" />
					<input id=\"backup_id\" type=\"hidden\" value=\"\" name=\"id\" />
					<fieldset autofocus>	
						<input type=\"submit\" value=\"{$lang['delete_now']}\" />
					</fieldset>
				</form>
			</div>
		</div>
		<div id=\"deletesite\" class=\"floatingdialog delete-link\">
			<h3 class=\"center\">{$lang['delete_site']}</h3>
			<p style=\"text-align: center;\">{$lang['delete_site_text']}</p>
			<div class=\"form-small\">		
				<form action=\"/admin/sites/del_action\" method=\"post\" class=\"center\">
					<input id=\"user6\" type=\"hidden\" value=\"\" name=\"user\" />
					<input id=\"site_id\" type=\"hidden\" value=\"\" name=\"site\" />
					<fieldset autofocus>
						<input type=\"submit\" value=\"{$lang['delete_now']}\" />
					</fieldset>
				</form>
			</div>
		</div>
		<div id=\"deletedatabase\" class=\"floatingdialog delete-link\">
			<h3 class=\"center\">{$lang['delete_bdd']}</h3>
			<p style=\"text-align: center;\">{$lang['delete_bdd_text']}</p>
			<div class=\"form-small\">		
				<form action=\"/admin/databases/del_action\" method=\"post\" class=\"center\">
					<input id=\"user7\" type=\"hidden\" value=\"\" name=\"user\" />
					<input id=\"db_id\" type=\"hidden\" value=\"\" name=\"database\" />
					<fieldset autofocus>
						<input type=\"submit\" value=\"{$lang['delete_now']}\" />
					</fieldset>
				</form>
			</div>
		</div>
		<div id=\"deletedomain\" class=\"floatingdialog delete-link\">
			<h3 class=\"center\">{$lang['delete_domain']}</h3>
			<p style=\"text-align: center;\">{$lang['delete_domain_text']}</p>
			<div class=\"form-small\">		
				<form action=\"/admin/domains/del_action\" method=\"post\" class=\"center\">
					<input id=\"user8\" type=\"hidden\" value=\"\" name=\"user\" />
					<input id=\"domain_id\" type=\"hidden\" value=\"\" name=\"domain\" />
					<fieldset autofocus>
						<input type=\"submit\" value=\"{$lang['delete_now']}\" />
					</fieldset>
				</form>
			</div>
		</div>
		<div id=\"deletemail\" class=\"floatingdialog delete-link\">
			<h3 class=\"center\">{$lang['delete_mail']}</h3>
			<p style=\"text-align: center;\">{$lang['delete_mail_text']}</p>
			<div class=\"form-small\">		
				<form action=\"/admin/accounts/del_action\" method=\"post\" class=\"center\">
					<input id=\"user9\" type=\"hidden\" value=\"\" name=\"user\" />
					<input id=\"domain\" type=\"hidden\" value=\"\" name=\"domain\" />
					<input id=\"account_id\" type=\"hidden\" value=\"\" name=\"account\" />
					<fieldset autofocus>
						<input type=\"submit\" value=\"{$lang['delete_now']}\" />
					</fieldset>
				</form>
			</div>
		</div>
		<div id=\"newtoken\" class=\"floatingdialog delete-link\">
			<br />
			<h3 class=\"center\">{$lang['newtoken']}</h3>
			<p style=\"text-align: center;\">{$lang['newtoken_text']}</p>
			<div class=\"form-small\">		
				<form action=\"/admin/tokens/add_action\" method=\"post\" class=\"center\">
					<input id=\"user3\" type=\"hidden\" value=\"\" name=\"user\" />
					<fieldset>
						<input type=\"text\" name=\"name\" />
						<span class=\"help-block\">{$lang['tokenname_help']}</span>
					</fieldset>
					<fieldset>
						<select name=\"type\">
							<option value=\"user\">{$lang['user']}</option>
							<option value=\"admin\">{$lang['admin']}</option>
							<option value=\"blank\">{$lang['blank']}</option>
						</select>
						<span class=\"help-block\">{$lang['tokentype_help']}</span>
					</fieldset>
					<fieldset autofocus>	
						<input type=\"submit\" value=\"{$lang['create']}\" />
					</fieldset>
				</form>
			</div>
		</div>
		<div id=\"email\" class=\"floatingdialog delete-link\">
			<br />
			<h3 class=\"center\">{$lang['send_mail']}</h3>
			<div class=\"form-small\">		
				<form action=\"/admin/users/mail_action\" method=\"post\" class=\"center\">
					<input id=\"user10\" type=\"hidden\" value=\"\" name=\"user\" />
					<input type=\"text\" name=\"mail_title\" placeholder=\"{$lang['send_mail_title']}\" value=\"\" style=\"text-align: left; width: 500px;\"/>
					<textarea name=\"mail\" placeholder=\"{$lang['send_mail_text']}\" style=\"width: 500px; height: 220px; text-align: left;\"></textarea>
					<fieldset autofocus>	
						<input type=\"submit\" value=\"{$lang['send']}\" />
					</fieldset>
				</form>
			</div>
		</div>
		<div id=\"overview\" class=\"floatingdialog delete-link\">
			<br />
			<h3 class=\"center\">{$lang['overview']} (<span id=\"site_overview_name\"></span>)</h3>
			<img src=\"\" id=\"site_overview\" alt=\"\" style=\"margin: auto; border: 1px solid rgb(221, 221, 221); display: block; width: 512px; height: 384px; background: url('/{$GLOBALS['CONFIG']['SITE']}/images/anim_loading_75x75.gif') no-repeat scroll center center transparent;\" />
			<a id=\"site_overview_link\" style=\"height: 22px; width: 130px; margin: 20px auto;\" href=\"\" class=\"button classic\">
				<img src=\"/on/images/refresh-white.png\" style=\"float: left; height: 98%;\">
				<span style=\"display: block; padding-top: 3px;\">Actualiser</span>
			</a>
		</div>
		<script>
			newFlexibleDialog('delete', 550);
			newFlexibleDialog('deletebackup', 550);
			newFlexibleDialog('deletesite', 550);
			newFlexibleDialog('deletedatabase', 550);
			newFlexibleDialog('deletedomain', 550);
			newFlexibleDialog('deletemail', 550);
			newFlexibleDialog('quotachange', 550);
			newFlexibleDialog('newtoken', 550);
			newFlexibleDialog('email', 700);
			newFlexibleDialog('overview', 700);
			$(function() {
				$('#admincomment').focus(function() {
 
						var currentVal = $(this).val(),
							adminName = '". security::get('USER') ."',
							today = new Date(),
							dd = today.getDate(),
							mm = today.getMonth() + 1,
							yyyy = today.getFullYear();
						
						if (dd < 10) dd = '0' + dd;
						if (mm < 10) mm = '0' + mm;
						today = dd + '/' + mm + '/' + yyyy;
						
						if(! $(this).hasClass('editing')) {
							if(currentVal != '') {
								$(this).val(currentVal + '\\n' + adminName +' ('+today+') - ');
							} else {
								$(this).val(adminName +' ('+today+') - ');
							}
						}
						$(this).addClass('editing');
				});
				
				var comment_lht = parseInt($('textarea#admincomment').css('lineHeight'),10);
				var comment_lines = Math.round(($('textarea#admincomment').prop('scrollHeight') / comment_lht) - 1); 
				var comment_height = (comment_lines * 20);
				
				$('#admincomment').css('min-height', comment_height +'px');
				
			});
			
		</script>	
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>