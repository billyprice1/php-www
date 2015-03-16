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
				<div style=\"float: left; width: 380px;\">
					<h2 class=\"dark\">{$lang['dns']}</h2>
					<table>
						<tr>
							<th>{$lang['serv']}</th>
							<th>{$lang['host']}</th>
							<th>{$lang['ip']}</th>
						</tr>
						<tr>
							<td>{$lang['ns1']}</td>
							<td>ns1.olympe.in</td>
							<td>178.32.167.243</td>
						</tr>
						<tr>
							<td>{$lang['ns2']}</td>
							<td>ns2.olympe.in</td>
							<td>178.32.65.67</td>
						</tr>
					</table>
					<br /><br />
					<h2 class=\"dark\">{$lang['addresses']}</h2>
					<table>
						<tr>
							<th>{$lang['service']}</th>
							<th>{$lang['address']}</th>
						</tr>
						<tr>
							<td>PHP Info</td>
							<td><a href=\"https://phpinfo.olympe.in\">https://phpinfo.olympe.in</a></td>
						</tr>
						<tr>
							<td>{$lang['webmail']}</td>
							<td><a href=\"https://webmail.olympe.in\">https://webmail.olympe.in</a></td>
						</tr>
						<tr>
							<td>{$lang['cloud']}</td>
							<td><a href=\"https://cloud.olympe.in\">https://cloud.olympe.in</a></td>
						</tr>
						<tr>
							<td>{$lang['pma']}</td>
							<td><a href=\"https://pma.olympe.in\">https://pma.olympe.in</a></td>
						</tr>
						<tr>
							<td>{$lang['ppa']}</td>
							<td><a href=\"https://ppa.olympe.in\">https://ppa.olympe.in</a></td>
						</tr>
						<tr>
							<td>{$lang['stats']}</td>
							<td><a href=\"https://stats.olympe.in\">https://stats.olympe.in</a></td>
						</tr>				
					</table>
				</div>
				<div style=\"float: right; width: 380px;\">
					<h2 class=\"dark\">{$lang['connection']}</h2>
					<table>
						<tr>
							<th>{$lang['service']}</th>
							<th>{$lang['host']}</th>
							<th>{$lang['port']}</th>
						</tr>
						<tr>
							<td>{$lang['ftp']}</td>
							<td>ftp.olympe.in</td>
							<td>21</td>
						</tr>
						<tr>
							<td>{$lang['sftp']}</td>
							<td>ftp.olympe.in</td>
							<td>22</td>
						</tr>
						<tr>
							<td>{$lang['ssh']}</td>
							<td>olympe.in</td>
							<td>22</td>
						</tr>
						<tr>
							<td>{$lang['mysql']}</td>
							<td>sql1.olympe.in</td>
							<td>3306</td>
						</tr>
						<tr>
							<td>{$lang['mysql2']}</td>
							<td>sql2.olympe.in</td>
							<td>3306</td>
						</tr>
						<tr>
							<td>{$lang['mysql3']}</td>
							<td>sql3.olympe.in</td>
							<td>3306</td>
						</tr>
						<tr>
							<td>{$lang['pgsql']}</td>
							<td>psql.olympe.in</td>
							<td>5432</td>
						</tr>
						<tr>
							<td>{$lang['mongo']}</td>
							<td>mongo.olympe.in</td>
							<td>27017</td>
						</tr>
						<tr>
							<td>{$lang['smtp']}</td>
							<td>mail.olympe.in</td>
							<td>25 / 465</td>
						</tr>
						<tr>
							<td>{$lang['pop']}</td>
							<td>mail.olympe.in</td>
							<td>110 / 995</td>
						</tr>
						<tr>
							<td>{$lang['imap']}</td>
							<td>mail.olympe.in</td>
							<td>143 / 993</td>
						</tr>						
					</table>
				</div>
			</div>
			<div class=\"clear\"></div><br /><br />
		</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>