<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$content = "
			<div class=\"head-light\">
				<div class=\"container\" style=\"text-align: center;\">
					<h1 class=\"dark\" style=\"text-align: center;\">{$lang['title']}</h1>
				</div>
			</div>	
			<div class=\"content\">
			<div style=\"float: left; text-align: center; width: 275px;\">
				<a href=\"https://www.linkedin.com/profile/view?id=12837370\"><img class=\"photo\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/team/1.png\" /></a><br />
				<span style=\"color: #de5711; font-size: 20px;\" id=\"Yann Autissier\">Yann Autissier</span><br />
				<span style=\"color: #a8a8a8; font-size: 12px;\">{$lang['yann']}</span><br />
				<span style=\"color: #a8a8a8; font-size: 12px;\">yann.autissier@olympe.in</span><br />
			</div>
			<div style=\"float: left; text-align: center; width: 275px;\">
				<a href=\"#\"><img class=\"photo\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/team/9.png\" /></a><br />
				<span style=\"color: #de5711; font-size: 20px;\" id=\"Tristan Le Chanony\">Tristan Le Chanony</span><br />
				<span style=\"color: #a8a8a8; font-size: 12px;\">{$lang['tristan']}</span><br />
				<span style=\"color: #a8a8a8; font-size: 12px;\">tristan.lechanony@olympe.in</span><br />
			</div>
			<div style=\"float: left; text-align: center; width: 275px;\">
				<a href=\"#\"><img class=\"photo\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/team/6.png\" /></a><br />
				<span style=\"color: #de5711; font-size: 20px;\" id=\"Herv&eacute; Cognet\">Herv&eacute; Cognet</span><br />
				<span style=\"color: #a8a8a8; font-size: 12px;\">{$lang['herve']}</span><br />
				<span style=\"color: #a8a8a8; font-size: 12px;\">herve.cognet@olympe.in</span><br />
			</div>
			<div style=\"float: left; text-align: center; width: 275px;\">
				<a href=\"https://www.linkedin.com/pub/gael-frouin/2/985/1ab\"><img class=\"photo\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/team/8.png\" /></a><br />
				<span style=\"color: #de5711; font-size: 20px;\" id=\"Ga&euml;l Frouin\">Ga&euml;l Frouin</span><br />
				<span style=\"color: #a8a8a8; font-size: 12px;\">{$lang['gael']}</span><br />
				<span style=\"color: #a8a8a8; font-size: 12px;\">gael.frouin@olympe.in</span><br />
			</div>
			<div class=\"clear\"></div><br />
			<div style=\"float: left; text-align: center; width: 275px;\">
				<a href=\"https://twitter.com/SamuelHassine\"><img class=\"photo\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/team/3.png\" /></a><br />
				<span style=\"color: #de5711; font-size: 20px;\" id=\"Samuel Hassine\">Samuel Hassine</span><br />
				<span style=\"color: #a8a8a8; font-size: 12px;\">{$lang['sam']}</span><br />
				<span style=\"color: #a8a8a8; font-size: 12px;\">samuel.hassine@olympe.in</span><br />
			</div>
			<div style=\"float: left; text-align: center; width: 275px;\">
				<a href=\"https://twitter.com/BrunoMillion\"><img class=\"photo\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/team/2.png\" /></a><br />
				<span style=\"color: #de5711; font-size: 20px;\" id=\"Bruno Million\">Bruno Million</span><br />
				<span style=\"color: #a8a8a8; font-size: 12px;\">{$lang['bruno']}</span><br />
				<span style=\"color: #a8a8a8; font-size: 12px;\">bruno.million@olympe.in</span><br />
			</div>			
			<div style=\"float: left; text-align: center; width: 275px;\">
				<a href=\"#\"><img class=\"photo\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/team/7.png\" /></a><br />
				<span style=\"color: #de5711; font-size: 20px;\" id=\"Thomas Morain\">Thomas Morain</span><br />
				<span style=\"color: #a8a8a8; font-size: 12px;\">{$lang['thomas']}</span><br />
				<span style=\"color: #a8a8a8; font-size: 12px;\">thomas.morain@olympe.in</span><br />
			</div>
			<div style=\"float: left; text-align: center; width: 275px;\">
				<a href=\"https://twitter.com/gparisse\"><img class=\"photo\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/team/5.png\" /></a><br />
				<span style=\"color: #de5711; font-size: 20px;\" id=\"Ga&euml;tan Parisse\">Ga&euml;tan Parisse</span><br />
				<span style=\"color: #a8a8a8; font-size: 12px;\">{$lang['gaetan']}</span><br />
				<span style=\"color: #a8a8a8; font-size: 12px;\">gaetan.parisse@olympe.in</span><br />
			</div>
			<div class=\"clear\"></div><br />
			<div style=\"float: left; text-align: center; width: 275px;\">
				<a href=\"#\"><img class=\"photo\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/team/11.png\" /></a><br />
				<span style=\"color: #de5711; font-size: 20px;\" id=\"Romain Perronne\">Romain Perronne</span><br />
				<span style=\"color: #a8a8a8; font-size: 12px;\">{$lang['romain']}</span><br />
				<span style=\"color: #a8a8a8; font-size: 12px;\">romain.perronne@olympe.in</span><br />
			</div>
			<div style=\"float: left; text-align: center; width: 275px;\">
				<a href=\"#\"><img class=\"photo\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/team/10.png\" /></a><br />
				<span style=\"color: #de5711; font-size: 20px;\" id=\"Remi Rondia\">R&eacute;mi Rondia</span><br />
				<span style=\"color: #a8a8a8; font-size: 12px;\">{$lang['remi']}</span><br />
				<span style=\"color: #a8a8a8; font-size: 12px;\">remi.rondia@olympe.in</span><br />
			</div>
			<div style=\"float: left; text-align: center; width: 275px;\">
				<a href=\"https://twitter.com/suytt\"><img class=\"photo\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/team/4.png\" /></a><br />
				<span style=\"color: #de5711; font-size: 20px;\" id=\"Simon Uyttendaele\">Simon Uyttendaele</span><br />
				<span style=\"color: #a8a8a8; font-size: 12px;\">{$lang['simon']}</span><br />
				<span style=\"color: #a8a8a8; font-size: 12px;\">simon.uyttendaele@olympe.in</span><br />
			</div>
			<div class=\"clear\"></div>
			<br />
			<div class=\"separator\"></div>
			<br />
			<div style=\"text-align: center;\">
				<h1 class=\"dark\"  style=\"text-align: center;\">{$lang['hiring']}</h1>
				<br />
				<p style=\"font-size: 17px; text-align: center;\">{$lang['hiring_text']}</p>
				<br />
				<img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/pages/reunion.png\" style=\"height: 300px; padding: 10px; border: 1px solid #d1d1d1; border-radius: 3px;\" />
				<br /><br />
			</div>
				<div style=\"text-align: center;\">
				<a class=\"button classic\" href=\"/about/contact\" style=\"height: 22px; width: 200px; margin: 0 auto;\">
					<span style=\"display: block; font-size: 18px; padding-top: 3px;\">{$lang['contact']}</span>	
				</a>
				<p>{$lang['help']}</p>
			</div>
			<br /><br />	
		</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>