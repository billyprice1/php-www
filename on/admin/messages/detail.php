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

$content .= "
	<div class=\"panel\">
		<div class=\"top\">
			<div class=\"left\" style=\"width: 600px;\">
				<h3>{$message['title']}</h3>
				<h2 class=\"dark\">".$lang['status_' . $message['status']]."</h2>
			</div>
			<div class=\"right\" style=\"width: 400px; float: right; text-align: right;\">
				<a class=\"button classic\" href=\"#\" onclick=\"$('#reply').dialog('open'); return false;\" style=\"width: 180px; height: 22px; float: right;\">
					<span style=\"display: block; padding-top: 3px;\">{$lang['reply']}</span>
				</a>
			</div>
			<div class=\"clear\"></div>
		</div>
		<div class=\"container\">
			<div class=\"topic\">
";

foreach( $messages as $m )
{
		$content .= "
				<div class=\"message\">
					<div class=\"toppart\">
						<div class=\"messageid\">
							#{$m['id']}
						</div>
						<div class=\"date\">
							".date($lang['dateformat'], $m['date'])."
						</div>
						<div class=\"icons\">
							<a href=\"#\" onclick=\"showEdit('{$m['id']}'); return false;\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/pencil.png\" alt=\"\" /></a>
							<a href=\"#\" onclick=\"$('#id').val('{$m['id']}'); $('#delete').dialog('open'); return false;\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/close.png\" alt=\"\" /></a>
						</div>
						<div class=\"clear\"></div>
					</div>
					<div class=\"meta\">
						<a href=\"/admin/users/detail?id={$m['user']['id']}\"><img style=\"width: 80px; display: block;\" src=\"".(file_exists("{$GLOBALS['CONFIG']['SITE']}/images/users/{$m['user']['id']}.png")?"/{$GLOBALS['CONFIG']['SITE']}/images/users/{$m['user']['id']}.png":"/{$GLOBALS['CONFIG']['SITE']}/images/users/user.png")."\" /></a>
						<br />
						{$m['user']['name']}
					</div>
					<div class=\"text\">
						<form action=\"/admin/messages/update_action\" method=\"post\">
							<input type=\"hidden\" name=\"id\" value=\"{$m['id']}\" />
							<input type=\"hidden\" name=\"parent\" value=\"{$message['id']}\" />
							<p id=\"text{$m['id']}\">".bbcode::display($m['content'])."</p>
							<textarea id=\"edit{$m['id']}\" style=\"display: none; width: 700px; height: 200px;\" name=\"content\">".bbcode::edit($m['content'])."</textarea>
							<input id=\"submit{$m['id']}\" style=\"display: none;\" type=\"submit\" value=\"{$lang['update']}\" />
						</form>
					</div>
					<div class=\"clear\"></div>
				</div>
		";
}
$content .= "
				<div class=\"message\">
					<div class=\"toppart\">
						<div class=\"messageid\">
							#{$message['id']}
						</div>
						<div class=\"date\">
							".date($lang['dateformat'], $message['date'])."
						</div>
						<div class=\"icons\">
							<a href=\"#\" onclick=\"showEdit('{$message['id']}'); return false;\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/pencil.png\" alt=\"\" /></a>
							<a href=\"#\" onclick=\"$('#id').val('{$message['id']}'); $('#delete').dialog('open'); return false;\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/close.png\" alt=\"\" /></a>
						</div>
						<div class=\"clear\"></div>
					</div>
					<div class=\"meta\">
						<a href=\"/admin/users/detail?id={$message['user']['id']}\"><img style=\"width: 80px; display: block;\" src=\"".(file_exists("{$GLOBALS['CONFIG']['SITE']}/images/users/{$message['user']['id']}.png")?"/{$GLOBALS['CONFIG']['SITE']}/images/users/{$message['user']['id']}.png":"/{$GLOBALS['CONFIG']['SITE']}/images/users/user.png")."\" /></a>
						<br />
						{$message['user']['name']}
					</div>
					<div class=\"text\">
						<form action=\"/admin/messages/update_action\" method=\"post\">
							<input type=\"hidden\" name=\"id\" value=\"{$message['id']}\" />
							<input type=\"hidden\" name=\"parent\" value=\"{$message['id']}\" />
							<p id=\"text{$message['id']}\">".bbcode::display($message['content'])."</p>
							<textarea id=\"edit{$message['id']}\" style=\"display: none; width: 700px; height: 200px;\" name=\"content\">".bbcode::edit($message['content'])."</textarea>
							<input id=\"submit{$message['id']}\" style=\"display: none;\" type=\"submit\" value=\"{$lang['update']}\" />
						</form>						
					</div>
					<div class=\"clear\"></div>
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
			<a class=\"button classic\" href=\"#\" onclick=\"$('#close').dialog('open'); return false;\" style=\"width: 180px; height: 22px; float: right; margin-right: 20px;\">
				<span style=\"display: block; padding-top: 3px;\">{$lang['close']}</span>
			</a>
	";
}
else
{
	$content .= "
			<a class=\"button classic\" href=\"/admin/messages/open_action?id={$message['id']}\" style=\"width: 180px; height: 22px; float: right; margin-right: 20px;\">
				<span style=\"display: block; padding-top: 3px;\">{$lang['open']}</span>
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
					<textarea class=\"auto\" style=\"text-align: left; width: 400px; height: 150px;\" name=\"content\" onfocus=\"this.value = this.value=='{$lang['content']}' ? '' : this.value; this.style.color='#4c4c4c';\" onfocusout=\"this.value = this.value == '' ? this.value = '{$lang['content']}' : this.value; this.value=='{$lang['content']}' ? this.style.color='#cccccc' : this.style.color='#4c4c4c'\">{$lang['content']}</textarea>
					<span class=\"help-block\">{$lang['content_help']}</span>
				</fieldset>
				<fieldset>
					<input autofocus type=\"submit\" value=\"{$lang['send']}\" />
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
	</script>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>
