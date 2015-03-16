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
				<h3>{$lang['start']}</h3>
				<p>{$lang['intro']}</p>
				<br />
				<h3>{$lang['panel']}</h3>
				<p>{$lang['panel_text']}</p>
				<img class=\"doc\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/doc/1.png\" alt=\"1\" />
				<br />
				<h3>{$lang['site']}</h3>
				<p>{$lang['site_text']}</p>
				<img class=\"doc\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/doc/2.png\" alt=\"2\" />
				<p>{$lang['site_text2']}</p>
				<img class=\"doc\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/doc/3.png\" alt=\"3\" />
				<br />
				<h2 class=\"dark\">{$lang['site_error']}</h2>
				<img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/notifications/error.png\" alt=\"\" style=\"float: right;\" />
				<p>{$lang['site_error_text']}</p>
				
				<br /><hr /><br />
				<div>
					<div style=\"width: 300px; float: right;\">
						<a class=\"button classic\" style=\"width: 220px; height: 22px; float: right;\" href=\"/doc/publish\">
							<img src=\"/on/images/arrow-right.png\" style=\"float: left;\">
							<span style=\"display: block; padding-top: 3px;\">{$lang['next_button']}</span>
						</a>
					</div>
					<div style=\"margin-right: 300px;\">
						{$lang['next_text']}
					</div>
				</div>
			</div>
			<div class=\"clear\"></div><br /><br />
		</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>