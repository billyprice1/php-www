<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$group = api::send('group/list', array('id'=>$_GET['id']));
if( count($group) == 0 )
	template::redirect('/admin/groups');
$group = $group[0];

$content = "
		<div class=\"admin\">
			<div class=\"top\">
				<h1 class=\"dark\">{$lang['title']}</h1>
			</div>
			<div class=\"clear\"></div><br />
			<div class=\"container\">
				<div style=\"width: 380px; float: left;\">
						<h2 class=\"dark\">{$lang['grants']}</h3>
";

if( security::hasGrant('GRANT_GROUP_SELECT') )
{
	$groupgrants = api::send('grant/group/list', array('group'=>$_GET['id']));
	if( security::hasGrant('GRANT_SELECT') )
		$grants = api::send('grant/list');
	else
		$grants = $groupgrants;
	
	$content .= "
					<form action=\"/admin/groups/grant_action\" method=\"post\">
						<input type=\"hidden\" name=\"id\" value=\"{$_GET['id']}\" />
						<table>
							<tr>
								<th>{$lang['grantname']}</th>
								<th>{$lang['granted']}</th>
							</tr>";

	if( security::hasGrant(array('GRANT_GROUP_INSERT','GRANT_GROUP_DELETE')) )
		$disabled = '';
	else
		$disabled = 'disabled';

	foreach( $grants as $g )
	{
		$checked = '';
		foreach( $groupgrants as $k )
		{
			if( $g['id'] == $k['id'] )
			{
				$checked = 'checked';
				break;
			}
		}
		
		$content .= "
						<tr>
							<td>{$g['name']}</td>
							<td style=\"text-align: center;\">
								<input style=\"margin: 0 auto;\" type=\"checkbox\" name=\"grant[]\" value=\"{$g['id']}\" {$disabled} {$checked} />
							</td>
						</tr>";
	}

	$content .= "
					</table>
					<br />
					<input type=\"submit\" value=\"{$lang['update']}\" {$disabled} />
				</form>
	";
}

$content .= "
			</div>
			<div style=\"width: 600px; float: right;\">
				<h2 class=\"dark\">{$lang['rename']}</h2>
				<form action=\"/admin/groups/update_action\" method=\"post\">
					<input type=\"hidden\" name=\"id\" value=\"{$group['id']}\" />
					<fieldset>
						<input type=\"text\" name=\"name\" value=\"{$group['name']}\" style=\"width: 400px;\" />
						<span class=\"help-block\">{$lang['name']}</span>
					</fieldset>				
					<fieldset>
						<input type=\"submit\" value=\"{$lang['update']}\" ".(security::hasGrant('GROUP_UPDATE')?'':'disabled')." />
					</fieldset>
				</form>
			</div>
			<div class=\"clear\"></div><br /><br />
		</div>
	</div>";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>