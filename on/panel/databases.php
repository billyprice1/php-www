<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$databases = api::send('self/database/list');

$content = "
	<div class=\"panel\">
		<div class=\"top\">
			<div class=\"left\" style=\"width: 500px; padding-top: 5px;\">
				<h1 class=\"dark\">{$lang['databases']}</h1>
			</div>
			<div class=\"right\">
				<a class=\"button classic\" href=\"#\" onclick=\"$('#new').dialog('open');\" style=\"width: 200px; height: 22px; float: right;\">
					<img style=\"float: left;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/plus-white.png\" />
					<span style=\"display: block; padding-top: 3px;\">{$lang['add']}</span>
				</a>
			</div>
		</div>
		<div class=\"clear\"></div><br />
		<div class=\"container\">
";

if( count($databases) > 0 )
{
	$j = 1;
	foreach( $databases as $d )
	{
		$content .= "
				<div class=\"database ".($j==1?"first":"")."\" onclick=\"window.location.href='/panel/databases/config?database={$d['name']}'; return false;\">
					<img style=\"float: left; margin: 5px 15px 0 0;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/services/icon-{$d['type']}.png\" />
					<span class=\"name\" style=\"margin-top: 0\">{$d['name']}</span>
					<span class=\"subname\" title=\"{$d['desc']}\">{$d['desc']}</span>
					<span class=\"disk\">{$lang['disk']} {$d['size']} {$lang['mb']}</span></span>
				</div>
		";
		
		$j++;
		
		if( $j == 5 )
			$j = 1;
	}
	
	$content .= "
					<div class=\"clear\"></div><br />
					<a class=\"button classic\" href=\"https://pma.olympe.in\" style=\"width: 140px; float: left;\">
						<span style=\"display: block; font-size: 18px; padding-top: 3px;\">{$lang['pma']}</span>
					</a>
					<a class=\"button classic\" href=\"https://ppa.olympe.in\" style=\"width: 180px; float: left; margin-left: 20px;\">
						<span style=\"display: block; font-size: 18px; padding-top: 3px;\">{$lang['ppa']}</span>
					</a>
	";
}
else
{
	$content .= "
					<span style=\"font-size: 16px;\">{$lang['nodatabase']}</span><br /><br />
					<a class=\"button classic\" href=\"/doc/databases\" style=\"width: 140px;\">
						<span style=\"display: block; font-size: 18px; padding-top: 3px;\">{$lang['doc']}</span>
					</a>";
	
}
	$content .= "
		</div>		
	</div>
	<div id=\"new\" class=\"floatingdialog\">
		<h3 class=\"center\">{$lang['new']}</h3>
		<p style=\"text-align: center;\">{$lang['new_text']}</p>
		<div class=\"form-small\">		
			<form action=\"/panel/databases/add_action\" method=\"post\" class=\"center\">
				<fieldset>
					<input class=\"auto\" type=\"text\" value=\"{$lang['desc']}\" name=\"desc\" onfocus=\"this.value = this.value=='{$lang['desc']}' ? '' : this.value; this.style.color='#4c4c4c';\" onfocusout=\"this.value = this.value == '' ? this.value = '{$lang['desc']}' : this.value; this.value=='{$lang['desc']}' ? this.style.color='#cccccc' : this.style.color='#4c4c4c'\" />
					<span class=\"help-block\">{$lang['desc_help']}</span>
				</fieldset>
				<fieldset>
					<input class=\"auto\" type=\"password\" value=\"{$lang['password']}\" name=\"password\" onfocus=\"this.value = this.value=='{$lang['password']}' ? '' : this.value; this.style.color='#4c4c4c';\" onfocusout=\"this.value = this.value == '' ? this.value = '{$lang['password']}' : this.value; this.value=='{$lang['password']}' ? this.style.color='#cccccc' : this.style.color='#4c4c4c'\" />
					<span class=\"help-block\">{$lang['password_help']}</span>
				</fieldset>
				<fieldset>
					<select name=\"type\">
						<option value=\"mysql\">MySQL</option>
						<option value=\"pgsql\">PostgreSQL</option>
						<option value=\"mongodb\">MongoDB</option>
					</select>
					<span class=\"help-block\">{$lang['type_help']}</span>
				</fieldset>
				<fieldset>	
					<input autofocus type=\"submit\" value=\"{$lang['create']}\" />
				</fieldset>
			</form>
		</div>
	</div>
	<script>
		newFlexibleDialog('new', 550);
	</script>
";
	
	
/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>
