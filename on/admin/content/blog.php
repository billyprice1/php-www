<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$news = api::send('news/list', array());

$content = "
		<div class=\"panel\">
			<div class=\"top\">
				<div class=\"left\" style=\"padding-top: 5px;\">
					<h1 class=\"dark\">{$lang['title']}</h1>
					<h2 class=\"dark\" style=\"margin-top:10px;margin-left:20px;\">{$lang['menu_blog']}</h1>
				</div>
				<div class=\"right\">
					<a class=\"button classic\" href=\"#\" onclick=\"$('#new').dialog('open');\" style=\"width: 180px; height: 22px; float: right;\">
						<img style=\"float: left;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/plus-white.png\" />
						<span style=\"display: block; padding-top: 3px;\">{$lang['add']}</span>
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
									<a href=\"/admin/content/blog\"><li class=\"active\">{$lang['menu_blog']}</li></a>
									<a href=\"/admin/content/directory\"><li>{$lang['menu_directory']}</li></a>
									<a href=\"/admin/content/stats\"><li>{$lang['menu_statistics']}</li></a>
								</ul>
							</ul>
						</div>
					</div>					
				</div>
				<div class=\"right big\">
";

if( count($news) > 0 )
{
	$content .= "
					<table>
						<tr>
							<th>{$lang['title2']}</th>
							<th>{$lang['author']}</th>
							<th>{$lang['date']}</th>
							<th>{$lang['lang']}</th>
							<th style=\"width: 100px; text-align: center;\">{$lang['actions']}</th>
						</tr>";

	foreach($news as $n)
	{
		
		$content .= "
						<tr>
							<td>{$n['title']}</td>
							<td><span style=\"display: block; float: left; padding-top: 6px;\">".$lang['author_' . $n['author']]."</span></td>
							<td>".date($lang['dateformat'], $n['date'])."</a></td>
							<td><span style=\"display: block; float: left; padding-top: 6px;\">".$lang['lang_' . $n['language']]."</span></td>
							<td style=\"width: 100px; text-align: center;\">
								<a href=\"/admin/content/blog/detail?id={$n['id']}\" title=\"\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/large/preview.png\" alt=\"\" /></a>
								<a href=\"#\" onclick=\"$('#id').val('{$n['id']}'); $('#delete').dialog('open'); return false;\" title=\"\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/large/close.png\" alt=\"\" /></a>
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
					<span style=\"font-size: 16px;\">{$lang['nonews']}</span><br /><br />
	";
}

$content .= "
				</div>
				<div class=\"clear\"></div>
			</div>
		</div>
		<div id=\"new\" class=\"floatingdialog\">
			<h3 class=\"center\">{$lang['new']}</h3>
			<div class=\"form-small\">		
				<form action=\"/admin/content/blog/add_action\" method=\"post\" class=\"center\">
					<fieldset>
						<input class=\"auto\" type=\"text\" style=\"width: 400px;\" maxlenght=\"150\" value=\"{$lang['subject']}\" name=\"title\" onfocus=\"this.value = this.value=='{$lang['subject']}' ? '' : this.value; this.style.color='#4c4c4c';\" onfocusout=\"this.value = this.value == '' ? this.value = '{$lang['subject']}' : this.value; this.value=='{$lang['subject']}' ? this.style.color='#cccccc' : this.style.color='#4c4c4c'\" />
						<span class=\"help-block\">{$lang['title_help']}</span>
					</fieldset>
					<fieldset>
						<textarea class=\"auto\" style=\"width: 400px; height: 50px;\" name=\"desc\" onfocus=\"this.value = this.value=='{$lang['desc']}' ? '' : this.value; this.style.color='#4c4c4c';\" onfocusout=\"this.value = this.value == '' ? this.value = '{$lang['desc']}' : this.value; this.value=='{$lang['desc']}' ? this.style.color='#cccccc' : this.style.color='#4c4c4c'\">{$lang['desc']}</textarea>
						<span class=\"help-block\">{$lang['desc_help']}</span>
					</fieldset>
					<fieldset>
						<textarea class=\"auto\" style=\"width: 400px; height: 150px;\" name=\"content\" onfocus=\"this.value = this.value=='{$lang['content']}' ? '' : this.value; this.style.color='#4c4c4c';\" onfocusout=\"this.value = this.value == '' ? this.value = '{$lang['content']}' : this.value; this.value=='{$lang['content']}' ? this.style.color='#cccccc' : this.style.color='#4c4c4c'\">{$lang['content']}</textarea>
						<span class=\"help-block\">{$lang['content_help']}</span>
					</fieldset>
					<fieldset>
						<select name=\"author\">
							<option value=\"1\">Yann Autissier</option>
							<option value=\"2\">Bruno Million</option>
							<option value=\"3\">Samuel Hassine</option>
							<option value=\"4\">Simon Uyttendaele</option>
						</select>
						<span class=\"help-block\">{$lang['author_help']}</span>
					</fieldset>
					<fieldset>
						<select name=\"lang\">
							<option value=\"FR\">Fran&ccedil;ais</option>
							<option value=\"EN\">English</option>
							<option value=\"ES\">Espagnol</option>
						</select>
						<span class=\"help-block\">{$lang['lang_help']}</span>
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
				<form action=\"/admin/content/blog/del_action\" method=\"get\" class=\"center\">
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
