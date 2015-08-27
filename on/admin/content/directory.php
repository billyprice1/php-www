<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$featured = api::send('site/list', array('directory'=>1, 'directory_status'=>2, 'start'=>0, 'limit'=>12));
$selection = api::send('site/list', array('directory'=>1, 'directory_status'=>3, 'start'=>0, 'limit'=>12));


$content = "
	<div class=\"panel\">
		<div class=\"top\">
			<div class=\"left\" style=\"padding-top: 5px;\">
				<h1 class=\"dark\">{$lang['title']}</h1>
				<h2 class=\"dark\" style=\"margin-top:10px;margin-left:20px;\">{$lang['menu_directory']}</h1>
			</div>
			<div class=\"right\">
				<a class=\"button classic\" href=\"/directory\" style=\"width: 180px; height: 22px; float: right;\">
					<span style=\"display: block; padding-top: 3px;\">{$lang['see']}</span>
				</a>
			</div>
		</div>
		<div class=\"clear\"></div>
		<div class=\"content\">
			<div class=\"left small\">
				<div class=\"sidemenu\">
					<div class=\"sidemenu\">	
						<ul>
							<li style=\"cursor: auto;\">{$lang['menu_cat']}</li>
							<ul>
								<a href=\"/admin/content/blog\"><li>{$lang['menu_blog']}</li></a>
								<a href=\"/admin/content/directory\"><li class=\"active\">{$lang['menu_directory']}</li></a>
								<a href=\"/admin/content/stats\"><li>{$lang['menu_statistics']}</li></a>
							</ul>
						</ul>
					</div>
				</div>					
			</div>
			<div class=\"right big\">
				<div style=\"margin-bottom: 25px;\">
					<form method=\"post\" action=\"/admin/content/directory/search_action\">
						<fieldset>
							<input type=\"text\" style=\"width: 35%; display: inline-block;\" value=\"\" placeholder=\"{$lang['edit']}\" name=\"search\">
							<input type=\"submit\" style=\"width: 50px; display: inline-block;\" value=\"{$lang['ok']}\">
						</fieldset>
					</form>
				</div>
				
				<div style=\"float: left; width: 300px; padding-top: 5px;\">
					<h2 class=\"dark\" style=\"padding-top: 7px;\" id=\"featured\">{$lang['featured']}</h2>
				</div>
				<div style=\"float: right; width: 200px;\">
					<a class=\"button classic\" href=\"#\" onclick=\"$('#new').dialog('open'); return false;\" style=\"float: right; height: 17px; width: 17px; padding: 10px;\">
						<img style=\"float: left; width: 18px;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/plus-white.png\" alt=\"\" />
					</a>
				</div>
				<table style=\"margin-bottom:40px;\">
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
							<a title=\"{$lang['parameters']}\" href=\"/admin/content/directory/detail?id={$f['id']}\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/settings.png\" alt=\"\" /></a>
							<a title=\"{$lang['remove']}\" href=\"#\" onclick=\"$('#site_id').val('{$f['id']}'); $('#delete').dialog('open'); return false;\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/close.png\" alt=\"\" /></a>
						</td>
					</tr>
						
	";
}

$content .= "
				</table>
			
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
							<a title=\"{$lang['parameters']}\" href=\"/admin/content/directory/detail?id={$s['id']}\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/settings.png\" alt=\"\" /></a>
							<a title=\"{$lang['remove']}\" href=\"#\" onclick=\"$('#site_id').val('{$s['id']}'); $('#delete').dialog('open'); return false;\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/close.png\" alt=\"\" /></a>
						</td>
					</tr>			
	";
}

$content .= "		
				</table>
			</div>
		</div>
	</div>

	<div id=\"delete\" class=\"floatingdialog\">
		<h3 class=\"center\">{$lang['remove']}</h3>
		<p style=\"text-align: center;\">{$lang['remove_text']}</p>
		<div class=\"form-small\">		
			<form action=\"/admin/content/directory/detail_action\" method=\"post\" class=\"center\">
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
			<form action=\"/admin/content/directory/search_action\" method=\"post\" class=\"center\">
				<fieldset>
					<input type=\"text\" name=\"search\" placeholder=\"{$lang['sitename']}\" />
					<input autofocus type=\"submit\" value=\"{$lang['ok']}\" />
				</fieldset>
			</form>
		</div>
	</div>
	
	<script type=\"text/javascript\">
		newFlexibleDialog('delete', 550);
		newFlexibleDialog('new', 400);
	</script>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>