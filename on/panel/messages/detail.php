<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

try
{
	$message = api::send('self/message/list', array('id'=>$_GET['id']));
	$message = $message[0];
	$messages = api::send('message/list', array('parent'=>$_GET['id']), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
}
catch( Exception $e )
{
	template::redirect('/panel/messages');
}

if( !$message['id'] || !$_GET['id'] )
	template::redirect('/panel/messages');

$staff_icon = "<span class=\"staff\">{$lang['team']}</span>";
$online_icon = "<span class=\"online\">{$lang['online']}</span>";

if($message['status']==3) $replyButton = "
		<a class=\"button classic\" href=\"#\" onclick=\"$('#noreply').dialog('open'); return false;\" style=\"width: 180px; height: 22px; float: right;\">
			<span style=\"display: block; padding-top: 3px;\">{$lang['closed']}</span>
		</a>
";
else $replyButton = "
		<a class=\"button classic\" href=\"#\" onclick=\"$('#reply').dialog('open'); return false;\" style=\"width: 180px; height: 22px; float: right;\">
			<span style=\"display: block; padding-top: 3px;\">{$lang['reply']}</span>
		</a>
";
	
$content .= "
	<div class=\"panel\">
		<div class=\"top\">
			<div class=\"left\" style=\"width: 600px;\">
				<h3>{$message['title']}</h3> 
			</div>
			
			<div class=\"right\" style=\"width: 400px; float: right; text-align: right;\">
				".$replyButton."
			</div>
			<div class=\"clear\"></div><br />
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
	
	$online = ''; //$staff_icon;
	
	
		$content .= "
				<div class=\"message\">
					<div class=\"toppart\">
						<div class=\"icons\">
		";

		if( $m['user']['name'] == security::get('USER') && ($message['status']!=3) )
			$content .= "
							<a href=\"#\" onclick=\"quote('{$m['id']}'); return false;\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/speech.png\" alt=\"\" title=\"{$lang['quote']}\" /></a>
							<a href=\"#\" onclick=\"showEdit('{$m['id']}'); return false;\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/pencil.png\" alt=\"\" title=\"{$lang['update']}\" /></a>
							<a href=\"#\" onclick=\"$('#id').val('{$m['id']}'); $('#delete').dialog('open'); return false;\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/close.png\" alt=\"\" title=\"{$lang['delete']}\" /></a>
			";
			
		$content .= "
						</div>
						<a class=\"author-name\" href=\"#\">{$m['user']['name']}</a>
						<div class=\"clear\"></div>
					</div>
					<div class=\"meta\">
						<img class=\"lg-profile-pic\" src=\"".(file_exists("{$GLOBALS['CONFIG']['SITE']}/images/users/{$m['user']['id']}.png")?"/{$GLOBALS['CONFIG']['SITE']}/images/users/{$m['user']['id']}.png":"/{$GLOBALS['CONFIG']['SITE']}/images/users/user.png")."\" />
						{$staff}
						{$online}
					</div>
					<div class=\"text\">
						<form action=\"/panel/messages/update_action\" method=\"post\">
							<input type=\"hidden\" name=\"id\" value=\"{$m['id']}\" />
							<input type=\"hidden\" name=\"parent\" value=\"{$message['id']}\" />
							<p id=\"text{$m['id']}\">".bbcode::display($m['content'])."</p>
							<textarea id=\"edit{$m['id']}\" style=\"display: none; width: 800px; height: 100px;\" name=\"content\">".bbcode::edit($m['content'])."</textarea>
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
";

if( $message['status']!=3 )
	$content .= "
							<a href=\"#\" onclick=\"quote('{$message['id']}'); return false;\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/speech.png\" alt=\"\" title=\"{$lang['quote']}\" /></a>
							<a href=\"#\" onclick=\"showEdit('{$message['id']}'); return false;\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/pencil.png\" alt=\"\" title=\"{$lang['update']}\" /></a>
							<a href=\"#\" onclick=\"$('#id').val('{$message['id']}'); $('#delete').dialog('open'); return false;\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/close.png\" alt=\"\" title=\"{$lang['delete']}\" /></a>
	";

$content .= "
						</div>
						<a class=\"author-name\" href=\"#\">{$message['user']['name']}</a>
						<div class=\"clear\"></div>
					</div>
					<div class=\"meta\">
						<a href=\"#\"><img class=\"lg-profile-pic\" src=\"".(file_exists("{$GLOBALS['CONFIG']['SITE']}/images/users/{$message['user']['id']}.png")?"/{$GLOBALS['CONFIG']['SITE']}/images/users/{$message['user']['id']}.png":"/{$GLOBALS['CONFIG']['SITE']}/images/users/user.png")."\" /></a>
						{$staff}
						{$online}
					</div>
					<div class=\"text\">
						<form action=\"/panel/messages/update_action\" method=\"post\">
							<input type=\"hidden\" name=\"id\" value=\"{$message['id']}\" />
							<input type=\"hidden\" name=\"parent\" value=\"{$message['id']}\" />
							<p id=\"text{$message['id']}\">".bbcode::display($message['content'])."</p>
							<textarea id=\"edit{$message['id']}\" style=\"display: none; width: 700px; height: 200px;\" name=\"content\">".bbcode::edit($message['content'])."</textarea>
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
			{$replyButton}
		</div>
		<div class=\"clear\"></div><br /><br />
	</div>
	<div id=\"reply\" class=\"floatingdialog\">
		<br />
		<h3 class=\"center\">{$lang['reply']}</h3>
		<div class=\"form-small\">		
			<form action=\"/panel/messages/add_action\" method=\"post\" class=\"center\">
				<input type=\"hidden\" name=\"parent\" value=\"{$message['id']}\" />
				<input type=\"hidden\" name=\"type\" value=\"{$message['type']}\" />
				<fieldset>
					<textarea class=\"auto\" id=\"replyField\" style=\"text-align: left; width: 400px; height: 150px;\" name=\"content\" placeholder=\"{$lang['content']}\"></textarea>
					<span class=\"help-block\">{$lang['content_help']}</span>
				</fieldset>
				<fieldset>
					<input autofocus type=\"submit\" value=\"{$lang['send']}\" />
				</fieldset>
			</form>
		</div>
	</div>
	<div id=\"noreply\" class=\"floatingdialog\">
		<br />
		<h3 class=\"center\">{$lang['reply']}</h3>
		<p style=\"text-align: center;\">{$lang['noreply']}</p>
	</div>
	<div id=\"delete\" class=\"floatingdialog\">
		<h3 class=\"center\">{$lang['delete']}</h3>
		<p style=\"text-align: center;\">{$lang['delete_text']}</p>
		<div class=\"form-small\">		
			<form action=\"/panel/messages/del_action\" method=\"get\" class=\"center\">
				<input id=\"id\" type=\"hidden\" value=\"\" name=\"id\" />
				<input type=\"hidden\" value=\"{$message['id']}\" name=\"parent\" />
				<fieldset>	
					<input autofocus type=\"submit\" value=\"{$lang['delete_now']}\" />
				</fieldset>
			</form>
		</div>
	</div>
	<script>
		newFlexibleDialog('reply', 550);
		newFlexibleDialog('delete', 550);
		newFlexibleDialog('noreply', 550);
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
			var clean_quotation = $.trim(quotation.replace(regExpE, ''));
	
			$('#replyField').val('[quote]' + clean_quotation + '[/quote]');
			$('#reply').dialog('open'); 
			return false;
		}
	</script>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>
