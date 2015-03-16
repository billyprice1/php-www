<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$content = "
		<div class=\"panel\">
			<div class=\"top\">
				<div class=\"left\" style=\"padding-top: 5px;\">
					<h1 class=\"dark\">{$lang['title']}</h1>
				</div>
				<div class=\"right\">
				</div>
			</div>
			<div class=\"clear\"></div><br />
			<div class=\"container\">
				<div style=\"float: left; width: 510px;\">
					<h2 class=\"dark\">{$lang['stats']}</h2>
					<p>{$lang['stats_text']}</p>
					<img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/panel/piwik.png\" style=\"display: block; padding: 10px; border: 1px solid #d1d1d1; border-radius: 3px; margin-left: 20px;\" />
					<p>{$lang['stats_text2']}</p>
				</div>
				<div style=\"float: right; width: 510px;\">
					<h2 class=\"dark\">{$lang['cloud']}</h2>
					<p>{$lang['cloud_text']}</p>
					<img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/panel/owncloud.png\" style=\"display: block; padding: 10px; border: 1px solid #d1d1d1; border-radius: 3px; margin-left: 20px;\" />
					<p>{$lang['cloud_text2']}</p>
			
				</div>
				<div class=\"clear\"></div>
				<div style=\"float: left; width: 510px;\">
					<a class=\"button classic\" href=\"http://stats.olympe.in\" style=\"height: 22px; width: 200px; margin: 0 auto;\">
						<span style=\"display: block; font-size: 18px; padding-top: 3px;\">{$lang['piwik']}</span>
					</a>						
				</div>
				<div style=\"float: right; width: 510px;\">
					<a class=\"button classic\" href=\"http://cloud.olympe.in\" style=\"height: 22px; width: 200px; margin: 0 auto;\">
						<span style=\"display: block; font-size: 18px; padding-top: 3px;\">{$lang['owncloud']}</span>
					</a>					
				</div>
				<div class=\"clear\"></div><br />
			</div>
		</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>
