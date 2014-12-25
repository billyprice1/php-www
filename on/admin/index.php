<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$users = api::send('user/list', array('limit' => 10, 'order'=>'user_date', 'order_type'=>'DESC'));
$overquotas = api::send('quota/nearlimit', array('quota'=>'BYTES'));
$messages = api::send('message/list', array('topic'=>1, 'status'=>1));

if(isset($_GET['error'])) {
	$_SESSION['MESSAGE']['TYPE'] = 'error';
	$_SESSION['MESSAGE']['TEXT']= $lang['error_search'];
}

$content = "
	<div class=\"admin\">
		<div class=\"top\">
			<div class=\"left\" style=\"padding-top: 5px;\">
				<h1 class=\"dark\">{$lang['title']}</h1>
			</div>
			<div class=\"right\">
				<a class=\"button classic\" href=\"#\" onclick=\"$('#adduser').dialog('open');\" style=\"width: 180px; height: 22px; float: right;\">
					<img style=\"float: left;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/plus-white.png\" />
					<span style=\"display: block; padding-top: 3px;\">{$lang['add']}</span>
				</a>
			</div>
		</div>
		<div class=\"clear\"></div><br />
		<div class=\"container\">
			<div style=\"width: 350px; float: left;\">
				<h3 class=\"colored\">{$lang['search']}</h3>
				<form action=\"/admin/search_action\" method=\"post\" id=\"site_search_form\">
					<fieldset>
						<input class=\"auto\" style=\"width: 300px;\" type=\"text\" name=\"name\" placeholder=\"{$lang['name']}\" />
					</fieldset>
					<fieldset>
						<input class=\"auto\" id=\"site_search_val\" style=\"width: 300px;\" type=\"text\" name=\"site\" placeholder=\"{$lang['site']}\" />
					</fieldset>
					<fieldset>
						<input class=\"auto\" style=\"width: 300px;\" type=\"text\" name=\"email\" placeholder=\"{$lang['email']}\" />
					</fieldset>
					<fieldset>
						<input class=\"auto\" style=\"width: 300px;\" type=\"text\" name=\"domain\" placeholder=\"{$lang['domain']}\" />
					</fieldset>
					<fieldset>
						<input type=\"submit\" value=\"{$lang['go']}\" />
					</fieldset>					
				</form>
			</div>
			<div style=\"width: 700px; float: right;\">
				<h3 class=\"colored\">{$lang['messages']}</h3>
				<table>
					<tr>
						<th style=\"width: 40px; text-align: center;\">#</th>
						<th>{$lang['desc']}</th>
						<th>{$lang['date']}</th>						
					</tr>
";
if( count($messages) > 0 )
{
	foreach( $messages as $m )
	{
		$content .= "
					<tr>
						<td style=\"width: 40px; text-align: center;\"><a href=\"/admin/users/detail?id={$m['user']['id']}\"><img class=\"profile-pic\" src=\"".(file_exists("{$GLOBALS['CONFIG']['SITE']}/images/users/{$m['user']['id']}.png")?"/{$GLOBALS['CONFIG']['SITE']}/images/users/{$m['user']['id']}.png":"/{$GLOBALS['CONFIG']['SITE']}/images/users/user.png")."\" /></a></td>
						<td><a href=\"/admin/messages/detail?id={$m['id']}\">{$m['title']}</a></td>
						<td>".date('Y-m-d H:i', $m['date'])."</td>
					</tr>
		";
	}
}
else
{
	$content .= "
					<tr>
						<td colspan=\"3\" class=\"center\">{$lang['nomessage']}</td>
					</tr>
	";
}

$content .= "
				</table>
			</div>
			<div class=\"clear\"></div>
			<br />
			<div style=\"width: 350px; float: left;\">
				<h3 class=\"colored\">{$lang['overquota']}</h3>
				<table>
					<tr>
						<th style=\"width: 40px; text-align: center;\">#</th>
						<th>{$lang['username']}</th>
						<th>{$lang['disk']}</th>
						<th>{$lang['max']}</th>
					</tr>
";

$i = 0;
foreach( $overquotas as $o )
{
	$content .= "
					<tr>
						<td style=\"width: 40px; text-align: center;\"><a href=\"/admin/users/detail?id={$o['id']}\"><img class=\"profile-pic\" src=\"".(file_exists("{$GLOBALS['CONFIG']['SITE']}/images/users/{$o['id']}.png")?"/{$GLOBALS['CONFIG']['SITE']}/images/users/{$o['id']}.png":"/{$GLOBALS['CONFIG']['SITE']}/images/users/user.png")."\" /></a></td>
						<td><a href=\"/admin/users/detail?id={$o['id']}\">{$o['name']}</a></td>
						<td>{$o['quotas']['used']}</td>
						<td>{$o['quotas']['max']}</td>
					</tr>
	";
	$i++;
	
	if( $i > 9 )
		break;
}

$content .= "
				</table>
			</div>
			<div style=\"width: 700px; float: right;\">
				<h3 class=\"colored\">{$lang['last']}</h3>
				<table>
					<tr>
						<th style=\"width: 40px; text-align: center;\">#</th>
						<th>{$lang['username']}</th>
						<th>{$lang['email']}</th>
						<th>{$lang['date']}</th>
					</tr>
";

foreach( $users as $u )
{
	$content .= "
					<tr>
						<td style=\"width: 40px; text-align: center;\"><a href=\"/admin/users/detail?id={$u['id']}\"><img class=\"profile-pic\" src=\"".(file_exists("{$GLOBALS['CONFIG']['SITE']}/images/users/{$u['id']}.png")?"/{$GLOBALS['CONFIG']['SITE']}/images/users/{$u['id']}.png":"/{$GLOBALS['CONFIG']['SITE']}/images/users/user.png")."\" /></a></td>
						<td><a href=\"/admin/users/detail?id={$u['id']}\">{$u['name']}</a></td>
						<td>{$u['email']}</td>
						<td>".date('Y-m-d H:i', $u['date'])."</td>
					</tr>
	";
}

$content .= "
				</table>
			</div>

			<div class=\"clear\"></div>
		</div>
	</div>
	<div id=\"adduser\" class=\"floatingdialog delete-link\">
		<br />
		<h3 class=\"center\">{$lang['add']}</h3>
		<span id=\"adduser_error\" class=\"help-block center\" style=\"color: #bc0000;display:none;\">{$lang['add_error']}<hr /></span>
		<div class=\"form-small\">		
			<form action=\"/admin/create_action\" method=\"post\" class=\"center\">
				<input type=\"text\" name=\"user\" placeholder=\"{$lang['username']}\" />
				<span class=\"help-block\">Minuscules et chiffres seulement.</span>
				<input type=\"text\" name=\"email\" placeholder=\"{$lang['email']}\" />
				<input type=\"password\" name=\"password\" placeholder=\"{$lang['password']}\" />
				<fieldset autofocus>
					<br />
					<input type=\"submit\" value=\"{$lang['add']}\" />
				</fieldset>
			</form>
		</div>
	</div>
	<script>
		newFlexibleDialog('adduser', 550);
		
		$(document).ready(function() {
			$('#site_search_form').submit(function() {
				var site = $('#site_search_val').val();
				var site = site.replace(\"http://\", \"\");
				var site = site.replace(\".olympe.in/\", \"\");
				var site = site.replace(\".olympe.in\", \"\");
				$('#site_search_val').val(site);
			});
		});
	</script>
";

if( isset($_GET['enew']) )
{
	$content .= "<script type=\"text/javascript\">
					$(document).ready(function() {
						$(\"#adduser\").dialog(\"open\");
						$(\"#adduser_error\").show();
						$(\".ui-dialog-titlebar\").hide();
					});
				</script>
	";
}

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>