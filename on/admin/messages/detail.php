<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

try
{
	$message = api::send('message/list', array('id'=>$_GET['id']));
	$message = $message[0];
	$messages = api::send('message/list', array('parent'=>$_GET['id']));
}
catch( Exception $e )
{
	template::redirect('/admin/messages');
}

if( !$message['id'] || !$_GET['id'] )
	template::redirect('/admin/messages');

$staff_icon = "<span class=\"staff\">{$lang['team']}</span>";
$online_icon = "<span class=\"online\">{$lang['online']}</span>";

$content .= "
	<div class=\"panel\">
		<div class=\"top\">
			<div class=\"left\" style=\"width: 600px;\">
				<h3>". htmlspecialchars($message['title']) ."</h3>
				<h2 class=\"dark\">".$lang['status_' . $message['status']]."</h2>
			</div>
			<div class=\"right\" style=\"width: 400px; float: right; text-align: right;\">
				<a class=\"button classic\" href=\"#\" onclick=\"$('#reply').dialog('open'); return false;\" style=\"width: 180px; height: 22px; float: right;\">
					<span style=\"display: block; padding-top: 3px;\">{$lang['reply']}</span>
				</a>
				<a class=\"button classic\" href=\"#\" onclick=\"$('#settings').dialog('open'); return false;\" style=\"height: 22px; float: right; width: 22px; margin-right: 20px;\">
					<img style=\"float: left; height: 98%;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/settings.png\" />
				</a>
			</div>
			<div class=\"clear\"></div>
		</div>
		<div class=\"container\">
			<div class=\"topic\">
";

foreach( $messages as $m )
{
	if($m['user']['status'] == '99')
		$staff = $staff_icon;
	else 
		$staff = "";
	
	$online = ''; //$online_icon;
	
		$content .= "
				<div class=\"message\">
					<div class=\"toppart\">
						<div class=\"icons\">
							<a href=\"#\" onclick=\"quote('{$m['id']}'); return false;\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/speech.png\" alt=\"\" title=\"{$lang['quote']}\" /></a>
							<a href=\"#\" onclick=\"showEdit('{$m['id']}'); return false;\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/pencil.png\" alt=\"\" title=\"{$lang['update']}\" /></a>
							<a href=\"#\" onclick=\"$('#id').val('{$m['id']}'); $('#delete').dialog('open'); return false;\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/close.png\" alt=\"\" title=\"{$lang['delete']}\" /></a>
						</div>
						<a class=\"author-name\" href=\"/admin/users/detail?id={$m['user']['id']}\">". htmlspecialchars($m['user']['name']) ."</a>
						<div class=\"clear\"></div>
					</div>
					<div class=\"meta\">
						<a href=\"/admin/users/detail?id={$m['user']['id']}\"><img class=\"lg-profile-pic\" src=\"".(file_exists("{$GLOBALS['CONFIG']['SITE']}/images/users/{$m['user']['id']}.png")?"/{$GLOBALS['CONFIG']['SITE']}/images/users/{$m['user']['id']}.png":"/{$GLOBALS['CONFIG']['SITE']}/images/users/user.png")."\" /></a>
						{$staff}
						{$online}
					</div>
					<div class=\"text\">
						<form action=\"/admin/messages/update_action\" method=\"post\">
							<input type=\"hidden\" name=\"id\" value=\"{$m['id']}\" />
							<input type=\"hidden\" name=\"parent\" value=\"{$message['id']}\" />
							<div id=\"text{$m['id']}\">".bbcode::display(htmlspecialchars($m['content']))."</div>
							<textarea id=\"edit{$m['id']}\" style=\"display: none; width: 700px; height: 200px;\" name=\"content\">".bbcode::edit(htmlspecialchars($m['content']))."</textarea>
							<input id=\"submit{$m['id']}\" style=\"display: none;\" type=\"submit\" value=\"{$lang['update']}\" />
						</form>
					</div>
					<div class=\"clear\"></div>
					<div class=\"bottompart\">
						<span class=\"date\">".date($lang['dateformat'], $m['date'])."</span>
						<span class=\"messageid\">#{$m['id']}</span>
					</div>
				</div>
		";
}

if($message['user']['status'] == '99')
	$staff = $staff_icon;
else 
	$staff = "";

$online = ''; //$staff_icon;

$content .= "
				<div class=\"message\">
					<div class=\"toppart\">
						<div class=\"icons\">
							<a href=\"#\" onclick=\"quote('{$message['id']}'); return false;\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/speech.png\" alt=\"\" title=\"{$lang['quote']}\" /></a>
							<a href=\"#\" onclick=\"showEdit('{$message['id']}'); return false;\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/pencil.png\" alt=\"\" title=\"{$lang['update']}\" /></a>
							<a href=\"#\" onclick=\"$('#id').val('{$message['id']}'); $('#delete').dialog('open'); return false;\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/close.png\" alt=\"\" title=\"{$lang['delete']}\" /></a>
						</div>
						<a class=\"author-name\" href=\"/admin/users/detail?id={$message['user']['id']}\">". htmlspecialchars($message['user']['name']) ."</a>
						<div class=\"clear\"></div>
					</div>
					<div class=\"meta\">
						<a href=\"/admin/users/detail?id={$message['user']['id']}\"><img class=\"lg-profile-pic\" src=\"".(file_exists("{$GLOBALS['CONFIG']['SITE']}/images/users/{$message['user']['id']}.png")?"/{$GLOBALS['CONFIG']['SITE']}/images/users/{$message['user']['id']}.png":"/{$GLOBALS['CONFIG']['SITE']}/images/users/user.png")."\" /></a>
						{$staff}
						{$online}
					</div>
					<div class=\"text\">
						<form action=\"/admin/messages/update_action\" method=\"post\">
							<input type=\"hidden\" name=\"id\" value=\"{$message['id']}\" />
							<input type=\"hidden\" name=\"parent\" value=\"{$message['id']}\" />
							<div id=\"text{$message['id']}\">".bbcode::display(htmlspecialchars($message['content']))."</div>
							<textarea id=\"edit{$message['id']}\" style=\"display: none; width: 700px; height: 200px;\" name=\"content\">".bbcode::edit(htmlspecialchars($message['content']))."</textarea>
							<input id=\"submit{$message['id']}\" style=\"display: none;\" type=\"submit\" value=\"{$lang['update']}\" />
						</form>						
					</div>
					<div class=\"clear\"></div>
					<div class=\"bottompart\">
						<span class=\"date\">".date($lang['dateformat'], $message['date'])."</span>
						<span class=\"messageid\">#{$message['id']}</span>
					</div>
				</div>
				
				
				
			</div>
			<br />
			<a class=\"button classic\" href=\"#\" onclick=\"$('#reply').dialog('open'); return false;\" style=\"width: 180px; height: 22px; float: right;\">
				<span style=\"display: block; padding-top: 3px;\">{$lang['reply']}</span>
			</a>
";

if( $message['status'] != 3 )
{
	$content .= "
			<a class=\"button classic\" href=\"#\" onclick=\"$('#close').dialog('open'); return false;\" style=\"height: 22px; float: right; width: 22px; margin-right: 20px;\">
				<img style=\"float: left; height: 98%;\" title=\"{$lang['close']}\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/lock.png\" />
			</a>
	";
}
else
{
	$content .= "
			<a class=\"button classic\" href=\"/admin/messages/open_action?id={$message['id']}\" style=\"height: 22px; float: right; width: 22px; margin-right: 20px;\">
				<img style=\"float: left; height: 98%;\" title=\"{$lang['open']}\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/unlock.png\" />
			</a>
	";
}

$content .= "
		</div>
		<div class=\"clear\"></div><br /><br />
	</div>
	<div id=\"reply\" class=\"floatingdialog\">
		<br />
		<h3 class=\"center\">{$lang['reply']}</h3>
		<div class=\"form-small\">		
			<form action=\"/admin/messages/add_action\" method=\"post\" class=\"center\">
				<input type=\"hidden\" name=\"parent\" value=\"{$message['id']}\" />
				<input type=\"hidden\" name=\"type\" value=\"{$message['type']}\" />
				<fieldset>
					<textarea style=\"text-align: left; width: 400px; height: 150px;\" name=\"content\" id=\"replyField\"></textarea>
					<span class=\"help-block\">{$lang['content_help']}</span>
				</fieldset>
				<fieldset>
					{$lang['close']} : 
					<input type=\"checkbox\" name=\"close\" value=\"1\" />
				</fieldset>
				<fieldset>
					<input autofocus type=\"submit\" value=\"{$lang['send']}\" />
				</fieldset>
			</form>
		</div>
	</div>
	<div id=\"settings\" class=\"floatingdialog\">
		<br />
		<h3 class=\"center\">{$lang['settings']}</h3>
		<div class=\"form-small\">		
			<form action=\"/admin/messages/status_action\" method=\"post\" class=\"center\">
				<input type=\"hidden\" value=\"{$message['id']}\" name=\"id\" />
				<fieldset>
					<select name=\"new_status\">
						<option value=\"1\">{$lang['status_1']}</option>
						<option value=\"2\">{$lang['status_2']}</option>
						<option value=\"4\">{$lang['status_4']}</option>
						<option value=\"3\">{$lang['status_3']}</option>
					</select>
					<span class=\"help-block\">{$lang['settings_help']}</span>
				</fieldset>
				<fieldset autofocus>	
					<input type=\"submit\" value=\"{$lang['send']}\" />
				</fieldset>
			</form>
		</div>
	</div>
	<div id=\"delete\" class=\"floatingdialog\">
		<h3 class=\"center\">{$lang['delete']}</h3>
		<p style=\"text-align: center;\">{$lang['delete_text']}</p>
		<div class=\"form-small\">		
			<form action=\"/admin/messages/del_action\" method=\"get\" class=\"center\">
				<input type=\"hidden\" value=\"{$message['id']}\" name=\"parent\" />
				<input id=\"id\" type=\"hidden\" value=\"\" name=\"id\" />
				<fieldset>	
					<input autofocus type=\"submit\" value=\"{$lang['delete_now']}\" />
				</fieldset>
			</form>
		</div>
	</div>
	<div id=\"close\" class=\"floatingdialog\">
		<br />
		<h3 class=\"center\">{$lang['close']}</h3>
		<p style=\"text-align: center;\">{$lang['close_text']}</p>
		<div class=\"form-small\">		
			<form action=\"/admin/messages/close_action\" method=\"get\" class=\"center\">
				<input type=\"hidden\" value=\"{$message['id']}\" name=\"id\" />
				<fieldset>	
					<input autofocus type=\"submit\" value=\"{$lang['close_now']}\" />
				</fieldset>
			</form>
		</div>
	</div>
	<script>
		newFlexibleDialog('reply', 550);
		newFlexibleDialog('delete', 550);
		newFlexibleDialog('close', 550);
		newFlexibleDialog('settings', 550);
		var status = 0;
		function showEdit(id)
		{
			var options = {};
			if( status == 0 )
			{
				$(\"#text\" + id).css(\"display\", \"none\");
				$(\"#submit\"  + id).show(\"fade\", options, 200);
				$(\"#edit\"  + id).show(\"fade\", options, 200);
				status = 1;
			}
			else
			{
				$(\"#submit\" + id).css(\"display\", \"none\");
				$(\"#edit\" + id).css(\"display\", \"none\");
				$(\"#text\"  + id).show(\"fade\", options, 200);
				status = 0;
			}
		}
		
		function quote(e)
		{
			var quotation = $('#edit' + e).val(); 
			var regExpE = /\[quote\]([^§]+)\[\/quote\]/;
			var clean_quotation = $.trim(quotation.replace(regExpE, '(...)'));
	
			$('#replyField').val('[quote]' + clean_quotation + '[/quote]');
			$('#reply').dialog('open'); 
			return false;
		}
	</script>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>
