<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

if(isset($_POST['action']) && $_POST['action']=='search') {
	$user = security::encode($_POST['user']);
	
	if($_POST['user'] != '' && $_POST['statusmode']!= 0)
		$messages = api::send('message/list', array('topic'=>1, 'user'=>$user, 'status'=>$_POST['statusmode']));
	
	elseif($_POST['user'] != '' && $_POST['statusmode']== 0)
		$messages = api::send('message/list', array('topic'=>1, 'user'=>$user));
		
	elseif($_POST['user'] == '' && $_POST['statusmode']!= 0)
		$messages = api::send('message/list', array('topic'=>1, 'status'=>$_POST['statusmode']));
		
} else {
	$display = 'display:none';
	$messages = api::send('message/list', array('topic'=>1));
}

$content = "
			<div class=\"panel\">
				<div class=\"top\">
					<div class=\"left\" style=\"padding-top: 5px;\">
						<h1 class=\"dark\">{$lang['title']}</h1>
					</div>
					<div class=\"right\" style=\"width: 450px;\">
						<a class=\"button classic\" href=\"#\" onclick=\"$('#searchrequest').slideToggle('fast');\" style=\"height: 22px; float: right; width: 130px;\">
							<img style=\"float: left; height: 98%;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/search.png\" />
							<span style=\"display: block; padding-top: 3px;\">{$lang['search']}</span>
						</a>
					</div>
				</div>
				<div class=\"clear\"></div><br />
				<div id=\"searchrequest\" class=\"container\" style=\"{$display};\">
					<form action=\"\" method=\"post\">
						<fieldset>
							<input type=\"text\" name=\"user\" placeholder=\"{$lang['user']}\" value=\"{$user}\" style=\"width: 300px; display: inline-block;\" />
							<select name=\"statusmode\" style=\"display: inline-block;\">
								<option value=\"0\">{$lang['all_status']}</option>
								<option value=\"1\">{$lang['status_1']}</option>
								<option value=\"2\">{$lang['status_2']}</option>
								<option value=\"3\">{$lang['status_3']}</option>
								<option value=\"4\">{$lang['status_4']}</option>
							</select>
							<input type=\"hidden\" name=\"action\" value=\"search\" />
							<input type=\"submit\" value=\"Ok\" style=\"width: 50px; display: inline-block;\" />
						</fieldset>
					</form>
				</div>
				<div class=\"container\">
";

if( count($messages) > 0 )
{
	$content .= "
					<table>
						<tr>
							<th style=\"text-align: center; width: 40px;\">#</th>
							<th>{$lang['subject']}</th>
							<th>{$lang['user']}</th>
							<th>{$lang['date']}</th>
							<th>{$lang['status']}</th>
							<th style=\"width: 100px; text-align: center;\">{$lang['actions']}</th>
						</tr>";

	foreach($messages as $m)
	{
		
		$content .= "
						<tr>
							<td style=\"text-align: center; width: 40px;\"><a href=\"/admin/messages/detail?id={$m['id']}\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/email.png\" /></a></td>
							<td>{$m['title']}</td>
							<td>
								<a href=\"/admin/users/detail?id={$m['user']['id']}\"><img class=\"profile-pic\" style=\"float: left; margin-right: 10px;\" src=\"".(file_exists("{$GLOBALS['CONFIG']['SITE']}/images/users/{$m['user']['id']}.png")?"/{$GLOBALS['CONFIG']['SITE']}/images/users/{$m['user']['id']}.png":"/{$GLOBALS['CONFIG']['SITE']}/images/users/user.png")."\" /></a>
								<a style=\"display: block; float: left; padding-top: 6px; color:#de5711;\" class=\"author-name\" href=\"/admin/users/detail?id={$m['user']['id']}\">{$m['user']['name']}</a>
							</td>
							<td>".date($lang['dateformat'], $m['date'])."</a></td>
							<td style=\"text-align: center;\">".$lang['status_' . $m['status']]."</td>
							<td style=\"width: 100px; text-align: center;\">
								<a href=\"/admin/messages/detail?id={$m['id']}\" title=\"\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/large/preview.png\" alt=\"\" /></a>
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
				</div>
			</div>
			<div id=\"delete\" class=\"floatingdialog\">
				<h3 class=\"center\">{$lang['delete']}</h3>
				<p style=\"text-align: center;\">{$lang['delete_text']}</p>
				<div class=\"form-small\">		
					<form action=\"/admin/messages/del_action\" method=\"get\" class=\"center\">
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
