<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$account = api::send('self/account/list', array('id'=>$_GET['id'], 'domain' => $_GET['domain']));
$account = $account[0];

$content .= "
	<div class=\"panel\">
		<div class=\"top\">
			<div class=\"left\" style=\"padding-top: 5px; width: 700px;\">
				<h1 class=\"dark\">{$lang['user']} {$account['mail']}</h1>
			</div>
			<div class=\"right\" style=\"width: 400px;\">
				<a class=\"button classic\" href=\"/panel/users/list?domain=".security::encode($_GET['domain'])."\" style=\"width: 180px; height: 22px; float: right;\">
					<span style=\"display: block; padding-top: 3px;\">{$lang['back']}</span>
				</a>
			</div>
		</div>
		<div class=\"clear\"></div><br /><br />
		<div class=\"container\">
			<div style=\"width: 500px; float: left;\">
				<h3 class=\"colored\">{$lang['change_pass']}</h3>
				<form action=\"/panel/users/config_action\" method=\"post\">
					<input type=\"hidden\" name=\"domain\" value=\"".security::encode($_GET['domain'])."\" />
					<input type=\"hidden\" name=\"id\" value=\"".security::encode($_GET['id'])."\" />
					<fieldset>
						<input type=\"password\" name=\"password\" style=\"width: 400px;\" />
						<span class=\"help-block\">{$lang['password']}</span>
					</fieldset>
					<fieldset>
						<input type=\"password\" name=\"confirm\" style=\"width: 400px;\" />
						<span class=\"help-block\">{$lang['password2']}</span>
					</fieldset>
					<fieldset>
						<input type=\"submit\" value=\"{$lang['update']}\" />
					</fieldset>
			</div>
			<div style=\"width: 420px; float: right;\">
				<h3 class=\"colored\">{$lang['change_info']}</h3>
				<form action=\"/panel/users/config_action\" method=\"post\">
					<fieldset>
						<input type=\"text\" name=\"firstname\" value=\"{$account['firstname']}\" style=\"width: 400px;\" />
						<span class=\"help-block\">{$lang['firstname']}</span>
					</fieldset>
					<fieldset>
						<input type=\"text\" name=\"lastname\" value=\"{$account['lastname']}\" style=\"width: 400px;\" />
						<span class=\"help-block\">{$lang['lastname']}</span>
					</fieldset>
				</form>
			</div>
			<div class=\"clear\"></div><br /><br />
			<div style=\"float: left; width: 530px;\">
				<div style=\"float: left; width: 300px; padding-top: 5px;\">
					<h3 class=\"colored\">{$lang['redirections']}</h3>
				</div>
				<div style=\"float: right; width: 200px;\">
					<a class=\"button classic\" href=\"#\" onclick=\"$('#new-redirect').dialog('open'); return false;\" style=\"width: 22px; height: 22px; float: right;\">
						<img style=\"float: left;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/plus-white.png\" />
					</a>
				</div>
				<div class=\"clear\"></div>
				<br />
				<table>
					<tr>
						<th>{$lang['email']}</th>
						<th style=\"width: 70px; text-align: center;\">{$lang['actions']}</th>
					</tr>
	";
	
	if( !is_array($account['redirection']) && $account['redirection'] )
		$account['redirection'] = array($account['redirection']);
	
	if( $account['redirection'] )
	{
		foreach( $account['redirection'] as $r )
		{
			$content .= "
					<tr>
						<td>{$r}</td>
						<td style=\"width: 35px; text-align: center;\">
							<a href=\"/panel/users/del_redirection_action?redirection={$r}&domain={$_GET['domain']}&id={$_GET['id']}\" title=\"\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/close.png\" alt=\"\" /></a>
						</td>
					</tr>";
		}
	}
	
	$content .= "		
				</table>
			</div>
			<div style=\"float: right; width: 530px;\">
				<div style=\"float: left; width: 300px; padding-top: 5px;\">
					<h3 class=\"colored\">{$lang['alternates']}</h3>
				</div>
				<div style=\"float: right; width: 200px;\">
					<a class=\"button classic\" href=\"#\" onclick=\"$('#new-alias').dialog('open'); return false;\" style=\"width: 22px; height: 22px; float: right;\">
						<img style=\"float: left;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/plus-white.png\" />
					</a>
				</div>
				<div class=\"clear\"></div>
				<br />
				<table>
					<tr>
						<th>{$lang['email']}</th>
						<th style=\"width: 35px; text-align: center;\">{$lang['actions']}</th>
					</tr>
	";
	
	if( !is_array($account['alternate']) && $account['alternate'] )
		$account['alternate'] = array($account['alternate']);
	
	if( $account['alternate'] )
	{
		foreach( $account['alternate'] as $a )
		{
			$content .= "
					<tr>
						<td>{$a}</td>
						<td style=\"width: 35px; text-align: center;\">
							<a href=\"/panel/users/del_alternate_action?alternate={$a}&domain={$_GET['domain']}&id={$_GET['id']}\" title=\"\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/close.png\" alt=\"\" /></a>
						</td>
					</tr>";
		}
	}
	
	$content .= "		
				</table>
			</div>
			<div class=\"clear\"></div>
		</div>
	</div><br />
	<div id=\"new-redirect\" style=\"display: none;\" class=\"floatingdialog\">
		<h3 class=\"center\">{$lang['new_redirect']}</h3>
		<p style=\"text-align: center;\">{$lang['new_redirect_text']}</p>
		<div class=\"form-small\">		
			<form action=\"/panel/users/add_redirection_action\" method=\"post\" class=\"center\">
				<input type=\"hidden\" name=\"id\" value=\"{$account['id']}\" />
				<input type=\"hidden\" name=\"domain\" value=\"".security::encode($_GET['domain'])."\" />
				<fieldset>
					<input class=\"auto\" type=\"text\" value=\"{$lang['redirection']}\" name=\"redirection\" onfocus=\"this.value = this.value=='{$lang['redirection']}' ? '' : this.value; this.style.color='#4c4c4c';\" onfocusout=\"this.value = this.value == '' ? this.value = '{$lang['redirection']}' : this.value; this.value=='{$lang['redirection']}' ? this.style.color='#cccccc' : this.style.color='#4c4c4c'\" />
					<span class=\"help-block\">{$lang['redirection_help']}</span>
				</fieldset>
				<fieldset autofocus>	
					<input type=\"submit\" value=\"{$lang['create']}\" />
				</fieldset>
			</form>
		</div>
	</div>
	<div id=\"new-alias\" style=\"display: none;\" class=\"floatingdialog\">
		<h3 class=\"center\">{$lang['new_alias']}</h3>
		<p style=\"text-align: center;\">{$lang['new_alias_text']}</p>
		<div class=\"form-small\">		
			<form action=\"/panel/users/add_alternate_action\" method=\"post\" class=\"center\">
				<input type=\"hidden\" name=\"id\" value=\"{$account['id']}\" />
				<input type=\"hidden\" name=\"domain\" value=\"".security::encode($_GET['domain'])."\" />
				<fieldset>
					<input class=\"auto\" type=\"text\" value=\"{$lang['alias']}\" name=\"alternate\" onfocus=\"this.value = this.value=='{$lang['alias']}' ? '' : this.value; this.style.color='#4c4c4c';\" onfocusout=\"this.value = this.value == '' ? this.value = '{$lang['alias']}' : this.value; this.value=='{$lang['alias']}' ? this.style.color='#cccccc' : this.style.color='#4c4c4c'\" />
					<span class=\"help-block\">".str_replace('{DOMAIN}', security::encode($_GET['domain']), $lang['alias_help'])."</span>
				</fieldset>
				<fieldset autofocus>	
					<input type=\"submit\" value=\"{$lang['create']}\" />
				</fieldset>
			</form>
		</div>
	</div>
	<script>
		newDialog('new-redirect', 550, 250);
		newDialog('new-alias', 550, 250);
	</script>	
	";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>
