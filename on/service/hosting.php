<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$lang['TITLE'] = 'Olympe - ' . $lang['title'];

$content = "
		<div class=\"head-light\">
			<div class=\"container\">
				<h1 class=\"dark\">{$lang['title']}</h1>
			</div>
		</div>	
		<div class=\"content\">
			<div style=\"float: left;  width: 520px;\">
				<h2 class=\"dark\">{$lang['free']}</h2>
				<p>{$lang['free_text']}</p>
			</div>
			<div style=\"float: right; width: 480px; text-align: right;\">
				<img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/pages/community.png\" style=\"float: left; display: block; padding: 10px; border: 1px solid #d1d1d1; border-radius: 3px;\" />
			</div>
			<div class=\"clear\"></div>
			<br /><br />
			<div style=\"float: left;  width: 440px;\">
				<img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/pages/panel-2.png\" style=\"display: block; padding: 10px; border: 1px solid #d1d1d1; border-radius: 3px; margin-left: 20px;\" />
			</div>
			<div style=\"float: right; width: 560px;\">
				<h2 class=\"dark\">{$lang['offer']}</h2>
				<p>{$lang['offer_text']}</p>			
			</div>
			<div class=\"clear\"></div>
			<br /><br />
			<div style=\"text-align: center;\">
				<a class=\"button classic\" href=\"/service/offer\" style=\"height: 22px; width: 200px; margin: 0 auto;\">
					<span style=\"display: block; font-size: 18px; padding-top: 3px;\">{$lang['offers']}</span>	
				</a>
			</div>
			<br /><br />
		</div>
	</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>