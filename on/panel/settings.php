<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$userinfo = api::send('self/user/list');
$userinfo = $userinfo[0];

$limit_date = $userinfo['date'] + 1209600;

if($limit_date > time()) {
	$disabled = ' disabled="disabled" ';
	$limit_date_month = date('F', $limit_date);
	$limit_date_month_translate = $lang[$limit_date_month];
	$email_info = $lang['no_email_change'] . '<strong>' . str_replace($limit_date_month, $limit_date_month_translate, date($lang['DATEFORMAT'], $limit_date)) . '</strong>.';
}
		
$month = date('F', $userinfo['date']);
$month_translate = $lang[$month];
	
$content = "
	<div class=\"panel\">
		<div class=\"top\">
			<div class=\"left\" style=\"width: 500px;\">
				<h1 class=\"dark\" style=\"padding-top: 7px;\">{$lang['settings']}</h1>
				<blockquote style=\"width: 100%;\"><p>{$lang['registered']} <span style=\"font-weight: bold;\">".str_replace($month, $month_translate, date($lang['DATEFORMAT'], $userinfo['date']))."</span>. {$email_info}</p></blockquote>
			</div>
			<div class=\"right\" style=\"width: 550px; float: right; text-align: right;\">
				<a class=\"action pass big\" href=\"#\" onclick=\"$('#changepass').dialog('open'); return false;\">
					{$lang['pass']}
				</a>
				<a class=\"action apps big\" href=\"/panel/settings/tokens\">
					{$lang['apps']}
				</a>
				<a class=\"action delete big\" href=\"#\" onclick=\"$('#delete').dialog('open'); return false;\">
					{$lang['delete']}
				</a>					
			</div>
			<div class=\"clear\"></div>
		</div>
		<div class=\"container\">
			<div class=\"left\" style=\"width: 600px; margin-top: 20px;\">
				<h2 class=\"dark thin\">{$lang['config']}</h2>
				<form action=\"/panel/settings/update_action\" method=\"post\">
					<div style=\"float: left;\">
						<fieldset>
							<input type=\"text\" name=\"firstname\" value=\"{$userinfo['firstname']}\" style=\"width: 250px;\"/>
							<span class=\"help-block\">{$lang['firstname_help']}</span>
						</fieldset>
						<fieldset>
							<input {$disabled} type=\"text\" name=\"email\" value=\"{$userinfo['email']}\" style=\"width: 250px;\" />
							<span class=\"help-block\">{$lang['mail_help']}</span>
						</fieldset>
					</div>
					<div style=\"float: right;\">
						<fieldset>
							<input type=\"text\" name=\"lastname\" value=\"{$userinfo['lastname']}\" style=\"width: 250px;\" />
							<span class=\"help-block\">{$lang['lastname_help']}</span>
						</fieldset>
						<fieldset>
							<select name=\"language\" style=\"width: 270px;\">
								<option ".($userinfo['language']=='EN'?"selected":"")." value=\"EN\">English</option>
								<option ".($userinfo['language']=='FR'?"selected":"")." value=\"FR\">Fran&ccedil;ais</option>
								<option ".($userinfo['language']=='ES'?"selected":"")." value=\"ES\">Espa&ntilde;ol</option>
								<option ".($userinfo['language']=='DE'?"selected":"")." value=\"DE\">Deutsch</option>
								<option ".($userinfo['language']=='IT'?"selected":"")." value=\"IT\">Italiano</option>
							</select>
							<span class=\"help-block\">{$lang['lang_help']}</span>
						</fieldset>							
					</div>
					<div class=\"clear\"></div>
					<fieldset>
						<input type=\"submit\" value=\"{$lang['update']}\" />
					</fieldset>		
				</form>
			</div>
			<div class=\"right border\" style=\"width: 370px; padding-left: 60px; margin-left: 40px; margin-top: 20px;\">
				<h2 class=\"dark thin\">{$lang['avatar']}</h1>
				<br />
				<form action=\"/panel/settings/upload_action\" method=\"post\" enctype=\"multipart/form-data\">
					<input type=\"hidden\" name=\"id\" value=\"{$connector['connector_id']}\" />
					<fieldset>
						<img style=\"width: 100px; height: 100px;\" src=\"".(file_exists("{$GLOBALS['CONFIG']['SITE']}/images/users/{$userinfo['id']}.png")?"/{$GLOBALS['CONFIG']['SITE']}/images/users/{$userinfo['id']}.png":"/{$GLOBALS['CONFIG']['SITE']}/images/users/user.png")."\" /><br /><br />
						<input type=\"file\" name=\"avatar\" />
						<span class=\"help-block\">{$lang['avatar_100']}</span>
					</fieldset>
					<fieldset>
						<input type=\"submit\" value=\"{$lang['update']}\" />
					</fieldset>		
				</form>
			</div>
			<div class=\"clear\"></div>
		</div>
	</div>
	<div id=\"changepass\" class=\"floatingdialog\">
		<br />
		<h3 class=\"center\">{$lang['changepass']}</h3>
		<p style=\"text-align: center;\">{$lang['changepass_text']}</p>
		<div class=\"form-small\">		
			<form action=\"/panel/settings/update_action\" method=\"post\" class=\"center\">
				<fieldset>
					<input type=\"password\" name=\"pass\" />
					<span class=\"help-block\">{$lang['pass_help']}</span>
				</fieldset>
				<fieldset>
					<input type=\"password\" name=\"confirm\" />
					<span class=\"help-block\">{$lang['confirm_help']}</span>
				</fieldset>
				<fieldset>	
					<input autofocus type=\"submit\" value=\"{$lang['update']}\" />
				</fieldset>
			</form>
		</div>
	</div>
	<div id=\"delete\" class=\"floatingdialog\">
		<h3 class=\"center\">{$lang['delete']}</h3>
		<p style=\"text-align: center;\">{$lang['delete_text']}</p>
		<div class=\"form-small\">		
			<form action=\"/panel/settings/del_action\" method=\"post\" class=\"center\">
				<fieldset autofocus>	
					<input type=\"submit\" value=\"{$lang['delete_now']}\" />
				</fieldset>
			</form>
		</div>
	</div>
	<script>
		newFlexibleDialog('changepass', 550);
		newFlexibleDialog('delete', 550);
	</script>	
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>