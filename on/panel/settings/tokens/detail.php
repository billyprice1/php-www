<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$token = api::send('self/token/list', array('token'=>htmlspecialchars($_GET['token'])));
if( count($token) == 0 )
	template::redirect('/panel/tokens');
$token = $token[0];

if($token['name'] == 'Olympe') {
	$main_token = true;
	$disabled = 'disabled="disabled"';
} else {
	$main_token = false;
	$disabled = '';
}

$content = "
		<div class=\"panel\">
			<div class=\"top\">
				<div class=\"left\" style=\"padding-top: 5px; width: 700px;\">
					<h1 class=\"dark\">{$lang['title']} ". htmlspecialchars($token['name']) ."</h1>
				</div>
				<div class=\"right\" style=\"width: 200px;\">
					<a class=\"button classic\" href=\"/panel/settings/tokens\" style=\"width: 180px; height: 22px; float: right;\">
						<span style=\"display: block; font-size: 18px; padding-top: 3px;\">{$lang['back']}</span>
					</a>
				</div>
			</div>
			<div class=\"clear\"></div><br />
			<div class=\"container\">
				<div style=\"width: 380px; float: left;\">
					<h2 class=\"dark\">{$lang['grants']}</h3>
";

$tokengrants = api::send('self/token/grant/list', array('token'=>$_GET['token']));
$grants = api::send('self/grant/user/list', array('overall'=>true));

$content .= "
					<form action=\"/panel/settings/tokens/grant_action\" method=\"post\">
						<table>
							<tr>
								<th>{$lang['grantname']}</th>
								<th>{$lang['granted']}</th>
							</tr>
";

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
								<input {$disabled} style=\"margin: 0 auto;\" type=\"checkbox\" name=\"grant[]\" value=\"{$g['id']}\" {$checked} />
							</td>
						</tr>";
}

$content .= "
					</table>
					<input type=\"hidden\" name=\"token\" value=\"".security::encode($_GET['token'])."\" />
					<br />
					<input {$disabled} type=\"submit\" value=\"{$lang['update']}\" />
				</form>
			</div>
			<div style=\"width: 600px; float: right;\">
				<h2 class=\"dark\">{$lang['tokeninfo']}</h2>
";

if($main_token == 1)
	$content .= "
					<div style=\"margin-bottom: 20px; padding: 10px 10px 10px 45px; background: url('/{$GLOBALS['CONFIG']['SITE']}/images/icons/large/denied.png') no-repeat scroll 10px 8px rgb(238, 238, 238);\">
					 {$lang['maintoken_text']}
					</div>
";


$tokendate = '';
if( $token['lease'] > 0 )
	$tokendate = date($lang['dateformat'], $token['lease']);

$content .= "
				<form action=\"/panel/settings/tokens/update_action\" method=\"post\">
					<input type=\"hidden\" name=\"token\" value=\"".security::encode($_GET['token'])."\" />
					<fieldset>
						<input {$disabled} type=\"text\" name=\"value\" value=\"{$token['token']}\" style=\"width: 400px;\" disabled />
						<span class=\"help-block\">{$lang['tokentoken']}</span>
					</fieldset>	
					<fieldset>
						<input {$disabled} type=\"text\" name=\"name\" value=\"". htmlspecialchars($token['name']) ."\" style=\"width: 400px;\" />
						<span class=\"help-block\">{$lang['tokenname']}</span>
					</fieldset>					
					<fieldset>
						<input {$disabled} type=\"text\" name=\"lease\" id=\"lease\" value=\"{$tokendate}\" style=\"width: 400px;\"/>
						<span class=\"help-block\">{$lang['tokenlease']}</span>
					</fieldset>
					<fieldset>
						<input {$disabled} type=\"submit\" value=\"{$lang['update']}\" />
					</fieldset>
				</form>
			</div>
			<div class=\"clear\"></div><br /><br />
		</div>
	</div>";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>