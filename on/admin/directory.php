<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$featured = api::send('site/list', array('directory'=>1, 'directory_status'=>2, 'start'=>0, 'limit'=>12));
$selection = api::send('site/list', array('directory'=>1, 'directory_status'=>3, 'start'=>0, 'limit'=>12));

$content = "
	<style>li#search-li {display:none;}</style>
	<div class=\"panel\">
		<div class=\"top\">
			<div class=\"left\" style=\"padding-top: 5px;\">
				<h1 class=\"dark\">{$lang['title']}</h1>
			</div>
			<div class=\"right\">
				<a class=\"button classic\" href=\"/directory\" style=\"width: 180px; height: 22px; float: right;\">
					<span style=\"display: block; padding-top: 3px;\">{$lang['see']}</span>
				</a>
			</div>
		</div>
		<div class=\"clear\"></div><br />
		<div class=\"container\">
			<div style=\"margin-bottom: 25px;\">
				<form method=\"post\" action=\"/admin/directory/search_action\">
					<fieldset>
						<input type=\"text\" style=\"width: 35%; display: inline-block;\" value=\"\" placeholder=\"{$lang['edit']}\" name=\"search\">
						<input type=\"submit\" style=\"width: 50px; display: inline-block;\" value=\"{$lang['ok']}\">
					</fieldset>
				</form>
			</div>

			<div style=\"width: 49%; float: left;\">
				<div style=\"float: left; width: 300px; padding-top: 5px;\">
					<h2 class=\"dark\" style=\"padding-top: 7px;\" id=\"quotas\">{$lang['featured']}</h2>
				</div>
				<div style=\"float: right; width: 200px;\">
					<a class=\"button classic\" href=\"#\" onclick=\"$('#new').dialog('open'); return false;\" style=\"float: right; height: 17px; width: 17px; padding: 10px;\">
						<img style=\"float: left; width: 18px;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/plus-white.png\" alt=\"\" />
					</a>
				</div>
				<table>
					<tr>
						<th>Site</th>
						<th style=\"width: 150px;\">{$lang['user']}</th>
						<th style=\"width: 100px;\">{$lang['actions']}</th>
					</tr>
";

foreach( $featured as $f )
{
	$content .= "
					<tr>
						<td><a title=\"{$f['url']}\" href=\"http://{$f['url']}\" target=\"_blank\">{$f['url']}</a></td>
						<td><a href=\"\">{$f['user']}</a></td>
						<td>
							<a title=\"{$lang['preview']}\" href=\"/directory/site?id={$f['id']}\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/preview.png\" alt=\"\" /></a>
							<a title=\"{$lang['parameters']}\" href=\"/admin/directory/detail?id={$f['id']}\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/settings.png\" alt=\"\" /></a>
							<a title=\"{$lang['remove']}\" href=\"#\" onclick=\"$('#site_id').val('{$f['id']}'); $('#delete').dialog('open'); return false;\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/close.png\" alt=\"\" /></a>
						</td>
					</tr>
						
	";
}

$content .= "
				</table>
			</div>
			
			<div style=\"width: 49%; float: right;\">
				<div style=\"float: left; width: 300px; padding-top: 5px;\">
					<h2 class=\"dark\" style=\"padding-top: 7px;\" id=\"quotas\">{$lang['selection']}</h2>
				</div>
				<div style=\"float: right; width: 200px;\">
					<a class=\"button classic\" href=\"#\" onclick=\"$('#new').dialog('open'); return false;\" style=\"float: right; height: 17px; width: 17px; padding: 10px;\">
						<img style=\"float: left; width: 18px;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/plus-white.png\" alt=\"\" />
					</a>
				</div>
				<table>
					<tr>
						<th>Site</th>
						<th style=\"width: 150px;\">{$lang['user']}</th>
						<th style=\"width: 100px;\">{$lang['actions']}</th>
					</th>
";

foreach( $selection as $s )
{
	$content .= "
					<tr>
						<td><a title=\"{$s['url']}\" href=\"http://{$s['url']}\" target=\"_blank\">{$s['url']}</a></td>
						<td><a href=\"\">{$s['user']}</a></td>
						<td>
							<a title=\"{$lang['preview']}\" href=\"/directory/site?id={$s['id']}\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/preview.png\" alt=\"\" /></a>
							<a title=\"{$lang['parameters']}\" href=\"/admin/directory/detail?id={$s['id']}\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/settings.png\" alt=\"\" /></a>
							<a title=\"{$lang['remove']}\" href=\"#\" onclick=\"$('#site_id').val('{$s['id']}'); $('#delete').dialog('open'); return false;\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/close.png\" alt=\"\" /></a>
						</td>
					</tr>			
	";
}

$content .= "		
					</table>
				</div>
				<div class=\"clear\"></div>
";

$content .= "
		</div>
	</div>
";
		
$content .= "
	<div id=\"delete\" class=\"floatingdialog\">
		<h3 class=\"center\">{$lang['remove']}</h3>
		<p style=\"text-align: center;\">{$lang['remove_text']}</p>
		<div class=\"form-small\">		
			<form action=\"/admin/directory/detail_action\" method=\"post\" class=\"center\">
				<fieldset>
					<input type=\"hidden\" name=\"action\" value=\"delete_highlight\" />
					<input type=\"hidden\" name=\"id\" id=\"site_id\" value=\"\" />
					<input autofocus type=\"submit\" value=\"{$lang['ok']}\" />
				</fieldset>
			</form>
		</div>
	</div>
	
	<div id=\"new\" class=\"floatingdialog\">
		<h3 class=\"center\">{$lang['new']}</h3>
		<p style=\"text-align: justify;\">{$lang['new_text']}</p>
		<div class=\"form-small\">		
			<form action=\"/admin/directory/search_action\" method=\"post\" class=\"center\">
				<fieldset>
					<input type=\"text\" name=\"search\" placeholder=\"{$lang['sitename']}\" />
					<input autofocus type=\"submit\" value=\"{$lang['ok']}\" />
				</fieldset>
			</form>
		</div>
	</div>";

$content .= "
		<script type=\"text/javascript\">
			newFlexibleDialog('delete', 550);
			newFlexibleDialog('new', 400);
		</script>";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>