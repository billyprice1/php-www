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
				<h3>{$lang['publish']}</h3>
				<p class=\"large\">
					{$lang['publish_text']}
					<ul class=\"classic\">
						<li><a href=\"#winscp\">{$lang['publish_client1']}</a></li>
						<li><a href=\"#filezilla\">{$lang['publish_client2']}</a></li>
					</ul>
				</p>
				<br />
				<h3>{$lang['login']}</h3>
				<p class=\"large\">{$lang['login_text']}
					<table>
						<tbody><tr>
							<th>{$lang['service']}</th>
							<th>{$lang['hostname']}</th>
							<th>{$lang['port']}</th>
						</tr>
						<tr>
							<td>FTP</td>
							<td>ftp.olympe.in</td>
							<td>21</td>
						</tr>
						<tr>
							<td>SFTP</td>
							<td>ftp.olympe.in</td>
							<td>22</td>
						</tr>
					</table>
					<a name=\"winscp\"></a>
				</p>
				<br /><br />
				<h3>{$lang['winscp']}</h3>
				<p class=\"large\">{$lang['winscp_text']}</p>
				<img class=\"doc\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/doc/4.png\" alt=\"4\" />
				<p class=\"large\">{$lang['winscp_text2']}</p>
				<img class=\"doc\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/doc/5.png\" alt=\"5\" />
				<a name=\"filezilla\"></a>
				<br />
				<h3>{$lang['filezilla']}</h3>
				<p class=\"large\">{$lang['filezilla_text']}</p>
				<img class=\"doc\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/doc/31.png\" alt=\"4\" />
				<p class=\"large\">{$lang['filezilla_text2']}</p>
				<img class=\"doc\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/doc/32.png\" alt=\"5\" />
				
				<p>{$lang['end']}</p>
			</div>
			<div class=\"clear\"></div><br /><br />
		</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>