<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$token = api::send('token/list', array('user'=>$_GET['user'], 'token'=>$_GET['token']));
if( count($token) == 0 )
	template::redirect('/admin/user/detail?id='.$_GET['user']);
$token = $token[0];

$content = "
		<div class=\"admin\">
			<div class=\"top\">
				<div class=\"left\" style=\"padding-top: 5px;\">
					<h1 class=\"dark\">{$lang['title']} {$token['name']}</h1>
				</div>
				<div class=\"right\">
					<a class=\"button classic\" href=\"/admin/users/detail?id={$_GET['user']}\" style=\"width: 180px; height: 22px; float: right;\">
						<span style=\"display: block; font-size: 18px; padding-top: 3px;\">{$lang['back']}</span>
					</a>
				</div>
			</div>
			<div class=\"clear\"></div><br />
			<div class=\"container\">
				<div style=\"width: 380px; float: left;\">
					<h2 class=\"dark\">{$lang['grants']}</h3>
";

if( security::hasGrant('GRANT_TOKEN_SELECT') )
{
	$tokengrants = api::send('grant/token/list', array('user'=>$_GET['user'], 'token'=>$_GET['token']));
	if( security::hasGrant('GRANT_USER_SELECT') )
		$grants = api::send('grant/user/list', array('user'=>$_GET['user'], 'overall'=>true));
	else
		$grants = $tokengrants;

	$content .= "
					<form action=\"/admin/tokens/grant_action\" method=\"post\">
						<table>
							<tr>
								<th>{$lang['grantname']}</th>
								<th>{$lang['granted']}</th>
							</tr>
	";
	
	if( security::hasGrant(array('GRANT_TOKEN_INSERT','GRANT_TOKEN_DELETE')) )
		$disabled = '';
	else
		$disabled = 'disabled';

	foreach( $grants as $g )
	{
		$checked = '';
		foreach( $tokengrants as $k )
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
					<input type=\"hidden\" name=\"user\" value=\"{$_GET['user']}\" />
					<input type=\"hidden\" name=\"token\" value=\"{$_GET['token']}\" />
					<br />
					<input type=\"submit\" value=\"{$lang['update']}\" {$disabled} />
				</form>
";
}

$content .= "
			</div>
			<div style=\"width: 600px; float: right;\">
				<h2 class=\"dark\">{$lang['tokeninfo']}</h2>
";

$tokendate = '';
if( $token['lease'] > 0 )
	$tokendate = date('j-n-Y', $token['lease']);

$content .= "
				<form action=\"/admin/tokens/update_action\" method=\"post\">
					<input type=\"hidden\" name=\"user\" value=\"{$_GET['user']}\" />
					<input type=\"hidden\" name=\"token\" value=\"{$_GET['token']}\" />
					<fieldset>
						<input type=\"text\" name=\"value\" value=\"{$token['token']}\" style=\"width: 400px;\" disabled />
						<span class=\"help-block\">{$lang['tokentoken']}</span>
					</fieldset>	
					<fieldset>
						<input type=\"text\" name=\"name\" value=\"{$token['name']}\" style=\"width: 400px;\" />
						<span class=\"help-block\">{$lang['tokenname']}</span>
					</fieldset>					
					<fieldset>
						<input type=\"text\" name=\"lease\" id=\"lease\" value=\"{$tokendate}\" style=\"width: 400px;\"/>
						<span class=\"help-block\">{$lang['tokenlease']}</span>
					</fieldset>
					<fieldset>
						<input type=\"submit\" value=\"{$lang['update']}\" ".(security::hasGrant('TOKEN_UPDATE')?'':'disabled')." />
					</fieldset>
				</form>
			</div>
			<div class=\"clear\"></div><br /><br />
		</div>
	</div>";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>