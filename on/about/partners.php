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
			<div style=\"float: left; text-align: justify; margin-right: 50px; width: 330px;\">
				<a href=\"http://www.interxion.fr\" style=\"display: block; height: 120px;\"><img style=\"display: block; margin: 0 auto;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/partners/interxion.png\" alt=\"\" /></a>
				<p>{$lang['interxion']}</p>
			</div>
			<div style=\"float: left; text-align: justify; margin-right: 50px; width: 330px;\">
				<a href=\"http://www.anotherservice.com\" style=\"display: block; height: 120px;\"><img style=\"padding-top: 0px; display: block; margin: 0 auto;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/partners/as.png\" alt=\"\" /></a>
				<p>{$lang['as']}</p>			
			</div>
			<div style=\"float: left; text-align: justify; width: 330px;\">
				<a href=\"{$lang['fa_link']}\" style=\"display: block; height: 100px; padding-top: 20px;\"><img style=\"padding-top: 0px; display: block; margin: 0 auto; width: 100%;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/partners/{$lang['fa_img']}.png\" alt=\"\" /></a>
				<p>{$lang['fa_text']}</p>			
			</div>
			<div class=\"clear\"></div><br />
		</div>
	</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>