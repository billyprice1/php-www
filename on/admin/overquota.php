<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$overquotas = api::send('quota/nearlimit', array('quota'=>'BYTES'));

$content = "
	<div class=\"panel\">
		<div class=\"top\">
				<h1 class=\"dark\">{$lang['title']}</h1>
		</div>
		<div class=\"clear\"></div><br />
		<div class=\"container\">
			<table>
				<tr>
					<th style=\"width: 50px; text-align: center;\">#</th>
					<th>{$lang['username']}</th>
					<th>{$lang['disk']}</th>
					<th>{$lang['max']}</th>
					<th>{$lang['lastupdate']}</th>
					<th style=\"width: 50px; text-align: center;\">{$lang['actions']}</th>
				</tr>
";

$i = 0;
foreach( $overquotas as $o )
{
	$content .= "
				<tr>
					<td style=\"width: 40px; text-align: center;\"><a href=\"/admin/users/detail?id={$o['id']}\"><img style=\"width: 30px; height: 30px;\" src=\"".(file_exists("{$GLOBALS['CONFIG']['SITE']}/images/users/{$o['id']}.png")?"/{$GLOBALS['CONFIG']['SITE']}/images/users/{$o['id']}.png":"/{$GLOBALS['CONFIG']['SITE']}/images/users/user.png")."\" /></a></td>
					<td><a href=\"/admin/users/detail?id={$o['id']}\">{$o['name']}</a></td>
					<td>{$o['quotas']['used']}</td>
					<td>{$o['quotas']['max']}</td>
					<td>".date($lang['dateformat'], $o['last'])."</td>
					<td style=\"width: 50px; text-align: center;\">
						<a href=\"/admin/overquota/refresh_action?id={$o['id']}\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/large/refresh4.png\" alt=\"\" /></a>
					</td>
				</tr>
	";

	$i++;
	
	if ( $i > 49 )
		break;
}

$content .= "
			</table>
";


$content .= "
			<br /><br />
		</div>
	</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>