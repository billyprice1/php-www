<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

require_once('on/doc/menu.php');

$content = "
		<div class=\"head-light\">
			<div class=\"container\">
				<h1 class=\"dark\" style=\"float: left;\">{$lang['title']}</h1>
				<form id=\"searchform\" action=\"/doc/search\" method=\"get\"><input type=\"submit\" style=\"display: none;\" /><input name=\"keyword\" class=\"auto\" style=\"width: 380px; font-size: 15px; float: right;\" type=\"text\" id=\"search\" value=\"{$GLOBALS['lang']['search']}\" onfocus=\"this.value = this.value=='{$GLOBALS['lang']['search']}' ? '' : this.value; this.style.color='#4c4c4c';\" onfocusout=\"this.value = this.value == '' ? this.value = '{$GLOBALS['lang']['search']}' : this.value; this.value=='{$GLOBALS['lang']['search']}' ? this.style.color='#cccccc' : this.style.color='#4c4c4c'\" /></form>
				<div class=\"clear\"></div>
			</div>
		</div>	
		<div class=\"content\">		
			<div class=\"left small\">
				<div class=\"sidemenu\">
					{$menu}
				</div>					
			</div>
			<div class=\"right big\">
				<h3>{$lang['intro']}</h3>
				<p>{$lang['intro_text']}</p>
				<br />
				<h3>{$lang['default']}</h3>
				<table>
					<tr>
						<th>{$lang['name']}</th>
						<th>{$lang['max']}</th>
					</tr>
					<tr>
						<td>{$lang['sites']}</td>
						<td>1</td>					
					</tr>
					<tr>
						<td>{$lang['databases']}</td>
						<td>3</td>
					</tr>
					<tr>
						<td>{$lang['disk']}</td>
						<td>500 {$lang['mb']}</td>
					</tr>	
					<tr>
						<td>{$lang['sent']}</td>
						<td>100</td>
					</tr>
				</table>
				<br /><br />
				<h3>{$lang['overview']}</h3>
				<p>{$lang['overview_text']}</p>
				<img class=\"doc\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/doc/26.png\" alt=\"26\" />
			</div>
			<div class=\"clear\"></div><br /><br />
		</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>