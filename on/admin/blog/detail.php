<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$news = api::send('news/list', array('id'=>$_GET['id']));
$news = $news[0];

$content .= "
	<div class=\"panel\">
		<div class=\"top\">
			<div class=\"left\" style=\"width: 600px;\">
				<h3>{$lang['title']}</h3>
			</div>
			<div class=\"right\" style=\"width: 400px; float: right; text-align: right;\">
				<a class=\"button classic\" href=\"#\" onclick=\"$('#delete').dialog('open'); return false;\" style=\"width: 180px; height: 22px; float: right;\">
					<span style=\"display: block; padding-top: 3px;\">{$lang['delete']}</span>
				</a>
			</div>
			<div class=\"clear\"></div><br />
		</div>
		<div class=\"container\">
			<form action=\"/admin/blog/update_action\" method=\"post\">
				<input type=\"hidden\" name=\"id\" value=\"{$news['id']}\" />
				<fieldset>
					<input type=\"text\" style=\"width: 700px;\" maxlenght=\"150\" name=\"title\" value=\"{$news['title']}\" />
					<span class=\"help-block\">{$lang['title_help']}</span>
				</fieldset>
				<fieldset>
					<textarea style=\"width: 700px; height: 100px;\" name=\"desc\">{$news['description']}</textarea>
					<span class=\"help-block\">{$lang['desc_help']}</span>
				</fieldset>
				<fieldset>
					<textarea style=\"width: 700px; height: 350px;\" name=\"content\">{$news['content']}</textarea>
					<span class=\"help-block\">{$lang['content_help']}</span>
				</fieldset>
				<fieldset>
					<select name=\"author\">
						<option ".($news['author']==1?"selected":"")." value=\"1\">Yann Autissier</option>
						<option ".($news['author']==2?"selected":"")." value=\"2\">Bruno Million</option>
						<option ".($news['author']==3?"selected":"")." value=\"3\">Samuel Hassine</option>
						<option ".($news['author']==4?"selected":"")." value=\"4\">Simon Uyttendaele</option>
					</select>
					<span class=\"help-block\">{$lang['author_help']}</span>
				</fieldset>
				<fieldset>
					<select name=\"lang\">
						<option ".($news['language']=='FR'?"selected":"")." value=\"FR\">Fran&ccedil;ais</option>
						<option ".($news['language']=='EN'?"selected":"")." value=\"EN\">English</option>
						<option ".($news['language']=='ES'?"selected":"")." value=\"ES\">Espagnol</option>
						<option ".($news['language']=='DE'?"selected":"")." value=\"DE\">Allemand</option>
					</select>
					<span class=\"help-block\">{$lang['lang_help']}</span>
				</fieldset>	
				<fieldset autofocus>
					<input type=\"submit\" value=\"{$lang['update']}\" />
				</fieldset>
			</form>		
		</div>
	</div>
	<div id=\"delete\" class=\"floatingdialog\">
		<h3 class=\"center\">{$lang['delete']}</h3>
		<p style=\"text-align: center;\">{$lang['delete_text']}</p>
		<div class=\"form-small\">		
			<form action=\"/admin/news/del_action\" method=\"get\" class=\"center\">
				<input type=\"hidden\" value=\"{$news['id']}\" name=\"parent\" />
				<input id=\"id\" type=\"hidden\" value=\"\" name=\"id\" />
				<fieldset>	
					<input autofocus type=\"submit\" value=\"{$lang['delete_now']}\" />
				</fieldset>
			</form>
		</div>
	</div>
	<script>
		newFlexibleDialog('delete', 550);
	</script>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>
