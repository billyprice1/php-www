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
			<h2 class=\"dark\">{$lang['kit']}</h2>
			<table style=\"border: 0; padding: 0;\">
				<tr style=\"border: 0; padding: 0;\">
					<td style=\"border: 0; text-align: center; padding: 0;\">
						<a href=\"/{$GLOBALS['CONFIG']['SITE']}/images/goodies/logo-small.png\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/goodies/logo-small.png\" /></a>
					</td>
					<td style=\"border: 0; text-align: center; padding: 0;\">
						<a href=\"/{$GLOBALS['CONFIG']['SITE']}/images/goodies/logo-normal.png\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/goodies/logo-normal.png\" /></a>
					</td>
					<td style=\"border: 0; text-align: center; padding: 0;\">
						<a href=\"/{$GLOBALS['CONFIG']['SITE']}/images/goodies/logo-square.png\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/goodies/logo-square.png\" /></a>
					</td>
					<td style=\"border: 0; text-align: center; padding: 0;\">
						<a href=\"/{$GLOBALS['CONFIG']['SITE']}/images/goodies/logo-big.png\"><img style=\"width: 300px;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/goodies/logo-big.png\" /></a>
					</td>
				</tr>
				<tr style=\"border: 0; padding: 0;\">
					<td style=\"border: 0; text-align: center; padding: 0;\"><span class=\"legend\">{$lang['small']}</span></td>
					<td style=\"border: 0; text-align: center; padding: 0;\"><span class=\"legend\">{$lang['normal']}</span></td>
					<td style=\"border: 0; text-align: center; padding: 0;\"><span class=\"legend\">{$lang['square']}</span></td>
					<td style=\"border: 0; text-align: center; padding: 0;\"><span class=\"legend\">{$lang['big']}</span></td>
				</tr>
			</table>
			<br /><br />
			<div style=\"float: left;  width: 770px;\">
				<h2 class=\"dark\">{$lang['press']}</h2>
				<a href=\"http://www.lejournaldunumerique.com/10/2008/olympe-network-la-premiere-base-de-donnees-dedie-au-phishing-francophone\"><img style=\"display: block; float: left; width: 120px; margin-right: 20px;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/press/jdn.png\" /></a>
				<span style=\"font-size: 18px;\"><a href=\"http://www.lejournaldunumerique.com/10/2008/olympe-network-la-premiere-base-de-donnees-dedie-au-phishing-francophone\">{$lang['article2_title']}</a></span><br />
				<span style=\"color: #9b9b9b;\">{$lang['published']} {$lang['article2_date']}</span>
				<p>{$lang['article2_extract']}</p>
				<div class=\"clear\"></div>
				<br />
				<a href=\"http://pro.01net.com/editorial/382928/une-association-offre-un-service-dhebergement-web-gratuit-aux-pros\"><img style=\"display: block; float: left; width: 120px; margin-right: 20px;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/press/01net.png\" /></a>
				<span style=\"font-size: 18px;\"><a href=\"http://pro.01net.com/editorial/382928/une-association-offre-un-service-dhebergement-web-gratuit-aux-pros\">{$lang['article1_title']}</a></span><br />
				<span style=\"color: #9b9b9b;\">{$lang['published']} {$lang['article1_date']}</span>
				<p>{$lang['article1_extract']}</p>
				
			</div>
			
			<div style=\"float: right; width: 300px;\">
				<h2 class=\"dark\">{$lang['print']}</h2>
				<a href=\"/{$GLOBALS['CONFIG']['SITE']}/documents/AfficheA3_Olympe_PRINT.pdf\"><img style=\"display: block; float: left; width: 120px; margin-right: 20px; padding: 5px; border: 1px solid #d6d6d6; border-radius: 3px;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/goodies/print-affiche.png\" /></a>
				<p>{$lang['affiche']}</p>
				<div class=\"clear\"></div>
				<br />
				<a href=\"/{$GLOBALS['CONFIG']['SITE']}/documents/Flyer_Olympe_PRINT.pdf\"><img style=\"display: block; float: left; width: 120px; margin-right: 20px; padding: 5px; border: 1px solid #d6d6d6; border-radius: 3px;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/goodies/print-flyer.png\" /></a>
				<p>{$lang['flyer']}</p>
			</div>
			<div class=\"clear\"></div>
			<br /><br />
		</div>
	</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>