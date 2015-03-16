<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$grant = api::send('grant/list', array('id'=>$_GET['id']));
if( count($grant) == 0 )
	template::redirect('/admin/grant');
$grant = $grant[0];
	
$content = "
		<div class=\"admin\">
			<div class=\"top\">
				<h1 class=\"dark\">{$lang['title']} : {$grant['name']}</h1>
			</div>
			<div class=\"clear\"></div><br />
			<div class=\"container\">
				<div style=\"width: 380px; float: left;\">
					<h2 class=\"dark\">{$lang['groups']}</h3>";
			
if( security::hasGrant('GRANT_GROUP_SELECT') )
{
	$grantgroups = api::send('grant/group/list', array('grant'=>$_GET['id']));
	
	$content .= "
					<table>
						<tr>
							<th>{$lang['groupname']}</th>
							<th style=\"text-align: center; width: 100px;\">{$lang['action']}</th>
						</tr>	
	";

	foreach( $grantgroups as $g )
	{
		$content .= "
						<tr>
							<td>{$g['name']}</td>
							<td style=\"text-align: center; width: 100px;\">";

		if( security::hasGrant('GROUP_SELECT') )
		{
			$content .= "
								<a href=\"/admin/groups/detail?id={$g['id']}\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/preview.png\" alt=\"{$lang['detail']}\" /></a>";
		}
	
		if( security::hasGrant('GRANT_GROUP_DELETE') )
		{
			$content .= "
								<a href=\"/admin/groups/revoke_action?group={$g['id']}&grant={$g['id']}\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/close.png\" alt=\"{$lang['revoke']}\" /></a>";
		}
	
		$content .= "
							</td>
						</tr>";
	}
	
	$content .= "
					</table>
	";
}

$content .= "
				</div>
				<div style=\"width: 600px; float: right;\">
					<h2 class=\"dark\">{$lang['rename']}</h2>
					<form action=\"/admin/grants/update_action\" method=\"post\">
						<input type=\"hidden\" name=\"id\" value=\"{$grant['id']}\" />
						<fieldset>
							<input type=\"text\" name=\"name\" value=\"{$grant['name']}\" style=\"width: 400px;\" />
							<span class=\"help-block\">{$lang['name']}</span>
						</fieldset>				
						<fieldset>
							<input type=\"submit\" value=\"{$lang['update']}\" ".(security::hasGrant('GRANT_UPDATE')?'':'disabled')." />
						</fieldset>
					</form>
				</div>
				<div class=\"clear\"></div><br /><br />
			</div>
		</div>";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>