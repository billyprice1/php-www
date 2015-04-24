<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$tokens = api::send('self/token/list');

$content = "
			<div class=\"panel\">
				<div class=\"top\">
					<div class=\"left\" style=\"padding-top: 5px;\">
						<h1 class=\"dark\">{$lang['title']}</h1>
					</div>
					<div class=\"right\">
						<a class=\"button classic\" href=\"#\" onclick=\"$('#new').dialog('open');\" style=\"width: 180px; height: 22px; float: right;\">
							<img style=\"float: left;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/plus-white.png\" />
							<span style=\"display: block; padding-top: 3px;\">{$lang['add']}</span>
						</a>
					</div>
				</div>
				<div class=\"clear\"></div><br />
				<div class=\"container\">
					<table>
						<tr>
							<th style=\"text-align: center; width: 40px;\">#</th>
							<th>{$lang['name']}</th>
							<th>{$lang['value']}</th>
							<th>{$lang['expiration']}</th>
							<th style=\"width: 100px; text-align: center;\">{$lang['actions']}</th>
						</tr>";

foreach( $tokens as $t )
{	
	$content .= "
						<tr>
							<td style=\"text-align: center; width: 40px;\"><a href=\"/panel/settings/tokens/detail?token={$t['token']}\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/token.png\" /></td>
							<td><span style=\"font-weight: bold;\">". htmlspecialchars($t['name']) ."</span></td>
							<td><span class=\"lightlarge\">{$t['token']}</a></td>
							<td>".($t['lease']==0?"{$lang['never']}":date($lang['dateformat'], $t['lease']))."</td>
							<td style=\"width: 100px; text-align: center;\">
								<a href=\"/panel/settings/tokens/detail?token={$t['token']}\" title=\"\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/large/settings.png\" alt=\"\" /></a>
		";
	
	if($t['name'] != 'Olympe')
		$content .= "
								
								<a href=\"#\" onclick=\"$('#token').val('{$t['token']}'); $('#delete').dialog('open'); return false;\" title=\"\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/large/close.png\" alt=\"\" /></a>
			";
			
	else
		$content .= "
								
								<a href=\"#\" onclick=\"$('#nodelete').dialog('open'); return false;\" title=\"\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/large/close.png\" alt=\"\" /></a>
			";
			
	$content .= "
							</td>
						</tr>
		";
}
	
$content .= "
					</table>
";


$content .= "
				</div>
			</div>
			<div id=\"new\" class=\"floatingdialog\">
				<h3 class=\"center\">{$lang['new']}</h3>
				<p style=\"text-align: center;\">{$lang['new_text']}</p>
				<div class=\"form-small\">		
					<form action=\"/panel/settings/tokens/add_action\" method=\"post\" class=\"center\">
						<fieldset>
							<input class=\"auto req\" type=\"text\" placeholder=\"{$lang['name']}\" name=\"name\" />
							<span class=\"help-block\">{$lang['tipname']}</span>
						</fieldset>
						<fieldset>
							<select name=\"type\">		
									<option value=\"admin\">{$lang['admin']}</option>
									<option value=\"blank\">{$lang['blank']}</option>
									<option value=\"dba\">{$lang['dba']}</option>
									<option value=\"site\">{$lang['site']}</option>
									<option value=\"domain\">{$lang['domain']}</option>
							</select>
							<span class=\"help-block\">{$lang['tiptype']}</span>
						</fieldset>
						<fieldset autofocus>
							<input type=\"submit\" value=\"{$lang['create']}\" />
						</fieldset>
					</form>
				</div>
			</div>
			<div id=\"delete\" class=\"floatingdialog\">
				<h3 class=\"center\">{$lang['delete']}</h3>
				<p style=\"text-align: center;\">{$lang['delete_text']}</p>
				<div class=\"form-small\">		
					<form action=\"/panel/settings/tokens/del_action\" method=\"get\" class=\"center\">
						<input id=\"token\" type=\"hidden\" value=\"\" name=\"token\" />
						<fieldset autofocus>	
							<input type=\"submit\" value=\"{$lang['delete_now']}\" />
						</fieldset>
					</form>
				</div>
			</div>
			<div id=\"nodelete\" class=\"floatingdialog\">
				<h3 class=\"center\">{$lang['delete']}</h3>
				<p style=\"text-align: center;\">{$lang['no_delete_text']}</p>
				<div class=\"form-small\">		
					<fieldset autofocus>
						<a href=\"/doc/tokens\">
							<input type=\"button\" value=\"{$lang['why']}\" style=\"margin: auto;\" />
						</a>
					</fieldset>
				</div>
			</div>
			<script>
				newFlexibleDialog('new', 550);
				newFlexibleDialog('delete', 550);
				newFlexibleDialog('nodelete', 550);
			</script>
			<script type=\"text/javascript\" src=\"/{$GLOBALS['CONFIG']['SITE']}/js/checkForm.js\"></script>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>
