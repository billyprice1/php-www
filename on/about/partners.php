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
			<div style=\"float: left; width: 500px;\">
				<a href=\"http://www.interxion.fr\" style=\"display: block; height: 120px;\"><img style=\"display: block; margin: 0 auto;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/partners/interxion.png\" alt=\"\" /></a>
				<p>{$lang['interxion']}</p>
			</div>
			<div style=\"float: right; width: 500px;\">
				<a href=\"http://www.anotherservice.com\" style=\"display: block; height: 120px;\"><img style=\"padding-top: 0px; display: block; margin: 0 auto;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/partners/as.png\" alt=\"\" /></a>
				<p>{$lang['as']}</p>			
			</div>
			<div class=\"clear\"></div><br />
		</div>
	</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>