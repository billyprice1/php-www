<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$content = "
		<div class=\"head-light\">
			<div class=\"container\">
				<h1 class=\"dark\">{$lang['title']}</h1>
			</div>
		</div>	
		<div class=\"content\">
			<p>{$lang['intro']}</p>
			<br />
			<div style=\"width: 650px; float: left;\">
				<table>
					<tr>
						<th>{$lang['service']}</th>
						<th>{$lang['description']}</th>
						<th style=\"width: 60px;\">{$lang['quota']}</th>
					</tr>
					<tr>
						<td style=\"font-weight: bold;\">{$lang['script']}</td>
						<td>{$lang['script_text']}</td>
						<td></td>
					</tr>
					<tr>
						<td style=\"font-weight: bold;\">{$lang['access']}</td>
						<td>{$lang['access_text']}</td>
						<td></td>
					</tr>
					<tr>
						<td style=\"font-weight: bold;\">{$lang['stats']}</td>
						<td>{$lang['stats_text']}</td>
						<td></td>
					</tr>
					<tr>
						<td style=\"font-weight: bold;\">{$lang['databases']}</td>
						<td>{$lang['databases_text']}</td>
						<td>{$lang['databases_limit']}</td>
					</tr>
					<tr>
						<td style=\"font-weight: bold;\">{$lang['disk']}</td>
						<td>{$lang['disk_text']}</td>
						<td>{$lang['disk_limit']}</td>
					</tr>
					<tr>
						<td style=\"font-weight: bold;\">{$lang['domains']}</td>
						<td>{$lang['domains_text']}</td>
						<td>{$lang['domains_limit']}</td>
					</tr>
					<tr>
						<td style=\"font-weight: bold;\">{$lang['accounts']}</td>
						<td>{$lang['accounts_text']}</td>
						<td>{$lang['accounts_limit']}</td>
					</tr>
					<tr>
						<td style=\"font-weight: bold;\">{$lang['traffic']}</td>
						<td>{$lang['traffic_text']}</td>
						<td>{$lang['traffic_limit']}</td>
					</tr>
				</table>
			</div>
			<div style=\"width: 400px; float: right;\">
				<img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/pages/apps.png\" alt=\"\" />
			</div>
			<div class=\"clear\"></div><br />
			<div class=\"separator light\"></div>
			<div style=\"text-align: center;\">
				<a class=\"button classic\" href=\"#\" onclick=\"$('#signup').dialog('open'); return false;\" style=\"height: 22px; width: 200px; margin: 0 auto;\">
					<span style=\"display: block; font-size: 18px; padding-top: 3px;\">{$lang['signup_now']}</span>
				</a>
				<p>{$lang['help']}</p>
			</div>
			<br />
		</div>
	</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>