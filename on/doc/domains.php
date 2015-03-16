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
				<form id=\"searchform\" action=\"/doc/search\" method=\"get\"><input type=\"submit\" style=\"display: none;\" /><input  name=\"keyword\"  class=\"auto\" style=\"width: 380px; font-size: 15px; float: right;\" type=\"text\" id=\"search\" value=\"{$GLOBALS['lang']['search']}\" onfocus=\"this.value = this.value=='{$GLOBALS['lang']['search']}' ? '' : this.value; this.style.color='#4c4c4c';\" onfocusout=\"this.value = this.value == '' ? this.value = '{$GLOBALS['lang']['search']}' : this.value; this.value=='{$GLOBALS['lang']['search']}' ? this.style.color='#cccccc' : this.style.color='#4c4c4c'\" /></form>
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
				<h3>{$lang['buy']}</h3>
				<p>{$lang['buy_text']}</p>
				<br />
				<h3>{$lang['create']}</h3>
				<p>{$lang['create_text']}</p>
				<img class=\"doc\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/doc/7.png\" alt=\"7\" />
				<p>{$lang['create_text2']}</p>
				<img class=\"doc\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/doc/9.png\" alt=\"9\" />
				<p>{$lang['create_text3']}</p>
				<blockquote style=\"width: 500px; margin: 0 auto;\">
					<p>
						<span style=\"font-weight: bold;\">{$lang['primary']}</span> ns1.olympe.in - 178.32.167.243<br />
						<span style=\"font-weight: bold;\">{$lang['secondary']}</span> ns2.olympe.in - 178.32.65.67
					</p>
				</blockquote>
				<p>{$lang['create_text4']}</p>
				<img class=\"doc\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/doc/10.png\" alt=\"10\" />
				
				<br /><hr /><br />
				<div>
					<div style=\"width: 300px; float: right;\">
						<a class=\"button classic\" style=\"width: 220px; height: 22px; float: right;\" href=\"/doc/mails\">
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