<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$messages = api::send('self/message/list', array('topic'=>1));

$content = "
			<div class=\"panel\">
				<div class=\"top\">
					<div class=\"left\" style=\"padding-top: 5px;\">
						<h1 class=\"dark\">{$lang['title']}</h1>
					</div>
					<div class=\"right\">
						<a class=\"button classic\" href=\"#\" onclick=\"$('#preinfo').dialog('open');\" style=\"width: 180px; height: 22px; float: right;\">
							<img style=\"float: left;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/plus-white.png\" />
							<span style=\"display: block; padding-top: 3px;\">{$lang['add']}</span>
						</a>
					</div>
				</div>
				<div class=\"clear\"></div><br />
				<div class=\"container\">
";

if( count($messages) > 0 )
{
	$content .= "
					<table>
						<tr>
							<th style=\"text-align: center; width: 40px;\">#</th>
							<th>{$lang['subject']}</th>
							<th>{$lang['date']}</th>
							<th>{$lang['status']}</th>
							<th style=\"width: 100px; text-align: center;\">{$lang['actions']}</th>
						</tr>";

	foreach($messages as $m)
	{
		
		$content .= "
						<tr>
							<td style=\"text-align: center; width: 40px;\"><a href=\"/panel/messages/detail?id={$m['id']}\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/email.png\" /></a></td>
							<td>{$m['title']}</td>
							<td>".date($lang['dateformat'], $m['date'])."</a></td>
							<td>".$lang['status_' . $m['status']]."</td>
							<td style=\"width: 100px; text-align: center;\">
								<a href=\"/panel/messages/detail?id={$m['id']}\" title=\"\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/large/preview.png\" alt=\"\" /></a>
								<a href=\"#\" onclick=\"$('#id').val('{$m['id']}'); $('#delete').dialog('open'); return false;\" title=\"\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/large/close.png\" alt=\"\" /></a>
							</td>
						</tr>
		";
	}
	
	$content .= "
					</table>
					<br /><br />
	";
}
else
{
	$content .= "
					<span style=\"font-size: 16px;\">{$lang['nomessage']}</span><br /><br />
	";
}

$content .= "
					<a class=\"button classic\" href=\"https://community.olympe.in\" style=\"width: 160px;\">
						<span style=\"display: block; font-size: 18px; padding-top: 3px;\">{$lang['support']}</span>
					</a>
				</div>
			</div>
			
			<div id=\"preinfo\" class=\"floatingdialog\">
				<h3 class=\"center\">{$lang['new_info_title']}</h3>
				<p style=\"text-align: justify;\">{$lang['new_info_contain']}</p>
				<br />
				<a style=\"width: 180px; height: 22px; margin:auto;\" onclick=\"$('#preinfo').dialog('close'); $('#new').dialog('open');\" href=\"#\" class=\"button classic\">
					<img src=\"/on/images/plus-white.png\" style=\"float: left;\" />
					<span style=\"display: block; padding-top: 3px;\">{$lang['continue']}</span>
				</a>
			</div>
			
			<div id=\"new\" class=\"floatingdialog\">
				<h3 class=\"center\">{$lang['new']}</h3>
				<div class=\"form-small\">		
					<form action=\"/panel/messages/add_action\" method=\"post\" class=\"center\">
						<fieldset>
							<select name=\"quota\" style=\"width: 420px;\">
								<option value=\"{$lang['disk']}\">{$lang['disk']}</option>
								<option value=\"{$lang['sites']}\">{$lang['sites']}</option>
								<option value=\"{$lang['dbs']}\">{$lang['dbs']}</option>
								<option value=\"{$lang['domains']}\">{$lang['domains']}</option>
							</select>
							<span class=\"help-block\">{$lang['quota_select']}</span>
						</fieldset>
						<fieldset>
							<input class=\"auto\" type=\"text\" style=\"width: 400px;\" value=\"{$lang['number']}\" name=\"max\" onfocus=\"this.value = this.value=='{$lang['number']}' ? '' : this.value; this.style.color='#4c4c4c';\" onfocusout=\"this.value = this.value == '' ? this.value = '{$lang['number']}' : this.value; this.value=='{$lang['number']}' ? this.style.color='#cccccc' : this.style.color='#4c4c4c'\" />
							<span class=\"help-block\">{$lang['number_help']}</span>
						</fieldset>
						<fieldset>
							<input class=\"auto\" type=\"text\" style=\"width: 400px;\" maxlenght=\"150\" value=\"{$lang['subject']}\" name=\"title\" onfocus=\"this.value = this.value=='{$lang['subject']}' ? '' : this.value; this.style.color='#4c4c4c';\" onfocusout=\"this.value = this.value == '' ? this.value = '{$lang['subject']}' : this.value; this.value=='{$lang['subject']}' ? this.style.color='#cccccc' : this.style.color='#4c4c4c'\" />
							<span class=\"help-block\">{$lang['title_help']}</span>
						</fieldset>
						<fieldset>
							<textarea class=\"auto\" style=\"width: 400px; height: 100px;\" name=\"content\" onfocus=\"this.value = this.value=='{$lang['content']}' ? '' : this.value; this.style.color='#4c4c4c';\" onfocusout=\"this.value = this.value == '' ? this.value = '{$lang['content']}' : this.value; this.value=='{$lang['content']}' ? this.style.color='#cccccc' : this.style.color='#4c4c4c'\">{$lang['content']}</textarea>
							<span class=\"help-block\">{$lang['content_help']}</span>
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
					<form action=\"/panel/messages/del_action\" method=\"get\" class=\"center\">
						<input id=\"id\" type=\"hidden\" value=\"\" name=\"id\" />
						<fieldset autofocus>	
							<input type=\"submit\" value=\"{$lang['delete_now']}\" />
						</fieldset>
					</form>
				</div>
			</div>
			<script>
				newFlexibleDialog('new', 700);
				newFlexibleDialog('delete', 550);
			</script>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>
