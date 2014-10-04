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
				<p class=\"large\">{$lang['intro_text']}</p>
				<br />
				<h3>{$lang['languages']}</h3>
				<table>
					<tr>
						<th style=\"text-align: center; width: 50px;\">#</th>
						<th style=\"width: 110px;\">{$lang['name']}</th>
						<th style=\"width: 210px;\">{$lang['info']}</th>
						<th style=\"width: 40px;\">{$lang['version']}</th>
						<th style=\"width: 200px;\">{$lang['site']}</th>
					</tr>
					<tr>
						<td style=\"text-align: center;\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/languages/icon-php.png\" style=\"width: 40px;\" alt=\"PHP\"></td>
						<td>PHP</td>
						<td>{$lang['script']}</td>
						<td>5.5.3</td>
						<td><a href=\"http://www.php.net\">http://www.php.net</a></td>
					</tr>
				</table>
				<br />
				<h3>{$lang['services']}</h3>
				<table>
					<tr>
						<th style=\"text-align: center; width: 50px;\">#</th>
						<th style=\"width: 110px;\">{$lang['name']}</th>
						<th style=\"width: 210px;\">{$lang['info']}</th>
						<th style=\"width: 40px;\">{$lang['version']}</th>
						<th style=\"width: 200px;\">{$lang['site']}</th>
					</tr>
					<tr>
						<td style=\"text-align: center;\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/services/icon-mysql.png\" style=\"width: 40px;\" alt=\"MySQL\"></td>
						<td>MySQL MariaDB</td>
						<td>{$lang['db']}</td>
						<td>5.5</td>
						<td><a href=\"http://www.mariadb.com\">http://www.mariadb.com</a></td>
					</tr>
					<tr>
						<td style=\"text-align: center;\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/services/icon-pgsql.png\" style=\"width: 40px;\" alt=\"PostgeSQL\"></td>
						<td>PostgreSQL</td>
						<td>{$lang['db']}</td>
						<td>9.3.x</td>
						<td><a href=\"http://www.postgresql.org\">http://www.postgresql.org</a></td>
					</tr>
					<tr>
						<td style=\"text-align: center;\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/services/icon-mongodb.png\" style=\"width: 40px;\" alt=\"MongoDB\"></td>
						<td>MongoDB</td>
						<td>{$lang['key']}</td>
						<td>{$lang['soon']}</td>
						<td>{$lang['soon']}</td>
					</tr>	
					<tr>
						<td style=\"text-align: center;\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/services/icon-redis.png\" style=\"width: 40px;\" alt=\"Redis\"></td>
						<td>Redis</td>
						<td>{$lang['key']}</td>
						<td>{$lang['soon']}</td>
						<td>{$lang['soon']}</td>
					</tr>	
					<tr>
						<td style=\"text-align: center;\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/services/icon-memcached.png\" style=\"width: 40px;\" alt=\"Memcached\"></td>
						<td>MemCached</td>
						<td>{$lang['key']}</td>
						<td>{$lang['soon']}</td>
						<td>{$lang['soon']}</td>
					</tr>
					<tr>
						<td style=\"text-align: center;\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/services/icon-rabbitmq.png\" style=\"width: 40px;\" alt=\"RabbitMQ\"></td>
						<td>RabbitMQ</td>
						<td>{$lang['queue']}</td>
						<td>{$lang['soon']}</td>
						<td>{$lang['soon']}</td>
					</tr>	
				</table>
				<br />
				<h3>{$lang['admin']}</h3>
				<table>
					<tr>
						<th style=\"text-align: center; width: 50px;\">#</th>
						<th style=\"width: 100px;\">{$lang['name']}</th>
						<th style=\"width: 220px;\">{$lang['info']}</th>
						<th style=\"width: 40px;\">{$lang['version']}</th>
						<th style=\"width: 200px;\">{$lang['site']}</th>
					</tr>
					<tr>
						<td style=\"text-align: center;\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/services/icon-pma.png\" style=\"width: 40px;\" alt=\"PHPMyAdmin\"></td>
						<td>PHPMyAdmin</td>
						<td>{$lang['pma']}</td>
						<td>4.2.x</td>
						<td><a href=\"http://www.phpmyadmin.net\">http://www.phpmyadmin.net</a></td>
					</tr>
					<tr>
						<td style=\"text-align: center;\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/services/icon-ppa.png\" style=\"width: 40px;\" alt=\"PHPPgAdmin\"></td>
						<td>PHPPgAdmin</td>
						<td>{$lang['ppa']}</td>
						<td>5.1</td>
						<td><a href=\"http://phppgadmin.sourceforge.net\">http://phppgadmin.sourceforge.net</a></td>
					</tr>
				</table>
			</div>
			<div class=\"clear\"></div><br /><br />
		</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>