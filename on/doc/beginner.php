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
				<h2 class=\"dark\">{$lang['begin_keywords']}</h2>
				<p>{$lang['begin_keywords_text']}</p>
				<br /><br />
				<h3>{$lang['begin_build']}</h3>
				<p>{$lang['begin_build_text']}</p>
				<br /><br />
				<h2 class=\"dark\">{$lang['begin_index']}</h2>
				<p>{$lang['begin_index_text1']}</p>
				<img class=\"doc\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/doc/33.png\" alt=\"33\" />
				<p>{$lang['begin_index_text2']}</p>
			</div>
			<div class=\"clear\"></div><br /><br />
		</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>