<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$database = api::send('self/database/list', array('database'=>$_GET['database']));
$database = $database[0];

$percent = round($database['stats'][$database['server']]*100/6000);

if( $percent > 100 )
	$percent = 100;

$content .= "
	<div class=\"panel\">
		<div class=\"top\">
			<div class=\"left\" style=\"padding-top: 5px; width: 700px;\">
				<h1 class=\"dark\">{$lang['database']} {$database['name']}</h1>
			</div>
			<div class=\"right\" style=\"width: 400px;\">
				<a class=\"button classic\" href=\"#\" onclick=\"$('#delete').dialog('open'); return false;\" style=\"width: 180px; height: 22px; float: right;\">
					<span style=\"display: block; padding-top: 3px;\">{$lang['delete']}</span>
				</a>
			</div>
		</div>
		<div class=\"clear\"></div><br /><br />
		<div class=\"container\">
			<div style=\"width: 500px; float: left;\">
				<h3 class=\"colored\">{$lang['change_pass']}</h3>
				<form action=\"/panel/databases/password_action\" method=\"post\">
					<input type=\"hidden\" name=\"database\" value=\"".security::encode($_GET['database'])."\" />
					<fieldset>
						<input type=\"password\" name=\"pass\" style=\"width: 400px;\" />
						<span class=\"help-block\">{$lang['password']}</span>
					</fieldset>
					<fieldset>
						<input type=\"password\" name=\"confirm\" style=\"width: 400px;\" />
						<span class=\"help-block\">{$lang['password2']}</span>
					</fieldset>
					<fieldset>
						<input type=\"submit\" value=\"{$lang['update']}\" />
					</fieldset>
				</form>
			</div>
			<div style=\"width: 420px; float: right;\">
				<h3 class=\"colored\">{$lang['change_info']}</h3>
				<form action=\"/panel/databases/config_action\" method=\"post\">
					<input type=\"hidden\" name=\"database\" value=\"".security::encode($_GET['database'])."\" />
					<fieldset>
						<input type=\"text\" name=\"description\" value=\"{$database['desc']}\" style=\"width: 400px;\" />
						<span class=\"help-block\">{$lang['description_help']}</span>
					</fieldset>
					<fieldset>
						<select disabled name=\"\" style=\"width: 415px;\">
							<option value=\"\" ".($database['type']=='mysql'?"selected":"")." >MySQL</option>
							<option value=\"\" ".($database['type']=='pgsql'?"selected":"")." >PostgreSQL</option>
							<option value=\"\" ".($database['type']=='mongodb'?"selected":"")." >MongoDB</option>
						</select>
						<span class=\"help-block\">{$lang['type_help']}</span>
					</fieldset>
					<fieldset>
						<input type=\"submit\" value=\"{$lang['update']}\" />
					</fieldset>
				</form>
			</div>
			<div class=\"clear\"></div>
			<br /><br />
			<h2 class=\"dark\">{$lang['connection']}</h2>
			<table>
				<tr>
					<th style=\"text-align: center; width: 40px;\">#</th>
					<th>{$lang['server']}</th>
					<th>{$lang['username']}</th>
					<th>{$lang['database']}</th>
					<th>{$lang['load']}</th>
					<th style=\"width: 100px;  text-align: center;\">{$lang['actions']}</th>
				</tr>
				<tr>
					<td style=\"text-align: center; width: 40px;\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/server.png\" /></td>
					<td>{$database['server']}</td>
					<td>{$database['name']}</td>
					<td>{$database['name']}</td>
					<td>
						<div class=\"fillgraph\" style=\"margin-top: 10px;\">
							<small style=\"width: {$percent}%;\"></small>
						</div>
						<span class=\"quota\"><span style='font-weight: bold;'>{$database['stats'][$database['server']]}</span> {$lang['databases']}</span>
					</td>
					<td style=\"width: 100px; text-align: center;\">
";
if( $database['type'] == 'mysql' )
	$content .= "						<a href=\"#\" title=\"\" onclick=\"$('#migrate').dialog('open'); return false;\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/large/settings.png\" alt=\"\" /></a>";
	
$content .= "
						<a href=\"#\" title=\"\" onclick=\"$('#download').dialog('open'); return false;\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/large/download2.png\" alt=\"\" /></a>
					</td>
				</tr>
			</table>
			<br /><br />
		</div>
	</div>
	<div id=\"migrate\" class=\"floatingdialog\">
		<br />
		<h3 class=\"center\">{$lang['migrate']}</h3>
		<p style=\"text-align: center;\">{$lang['migrate_text']}</p>
		<div class=\"form-small\">		
			<form action=\"/panel/databases/migrate_action\" method=\"post\" class=\"center\">
				<input type=\"hidden\" value=\"{$database['name']}\" name=\"database\" />
				<fieldset>
					<select name=\"server\" style=\"width: 420px;\">
						<option value=\"sql1.olympe.in\" style=\"color: ".($database['stats']['sql1.olympe.in']>6000?"red":"green").";\">sql1.olympe.in ({$database['stats']['sql1.olympe.in']} {$lang['databases']})</option>
						<option value=\"sql2.olympe.in\" style=\"color: ".($database['stats']['sql2.olympe.in']>6000?"red":"green").";\">sql2.olympe.in ({$database['stats']['sql2.olympe.in']} {$lang['databases']})</option>
					</select>
					<span class=\"help-block\">{$lang['server_help']}</span>
				</fieldset>
					<fieldset>
						<input style=\"width: 400px;\" class=\"auto\" type=\"password\" value=\"{$lang['password']}\" name=\"password\" onfocus=\"this.value = this.value=='{$lang['password']}' ? '' : this.value; this.style.color='#4c4c4c';\" onfocusout=\"this.value = this.value == '' ? this.value = '{$lang['password']}' : this.value; this.value=='{$lang['password']}' ? this.style.color='#cccccc' : this.style.color='#4c4c4c'\" />
						<span class=\"help-block\">{$lang['password_help']}</span>
					</fieldset>	
				<fieldset autofocus>	
					<input type=\"submit\" value=\"{$lang['migrate_now']}\" />
				</fieldset>
			</form>
		</div>
	</div>
	<div id=\"delete\" class=\"floatingdialog\">
		<h3 class=\"center\">{$lang['delete']}</h3>
		<p style=\"text-align: center;\">{$lang['delete_text']}</p>
		<div class=\"form-small\">		
			<form action=\"/panel/databases/del_action\" method=\"post\" class=\"center\">
				<input type=\"hidden\" value=\"{$database['name']}\" name=\"database\" />
				<fieldset autofocus>	
					<input type=\"submit\" value=\"{$lang['delete_now']}\" />
				</fieldset>
			</form>
		</div>
	</div>
	<div id=\"download\" class=\"floatingdialog\">
		<br />
		<h3 class=\"center\">{$lang['backup']}</h3>
		<p style=\"text-align: center;\">{$lang['backup_text']}</p>
		<div class=\"form-small\">		
			<form action=\"/panel/backups/add_action\" method=\"get\" class=\"center\">
				<input type=\"hidden\" value=\"{$database['name']}\" name=\"database\" />
				<fieldset autofocus>	
					<input type=\"submit\" value=\"{$lang['backup_now']}\" />
				</fieldset>
			</form>
		</div>
	</div>
	<script>
		newFlexibleDialog('migrate', 550);
		newFlexibleDialog('download', 550);
		newFlexibleDialog('delete', 550);
	</script>	
	";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>
