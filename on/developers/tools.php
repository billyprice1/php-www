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
			<div style=\"float: left; width: 520px;\">
				<h2 class=\"dark\">{$lang['panel']}</h2>
				<p>{$lang['panel_text']}</p>
			</div>
			<div style=\"float: right; width: 480px; text-align: left;\">
				<h2 class=\"dark\">{$lang['modules']}</h2>
				<p>{$lang['modules_text']}</p>
			</div>
			<div class=\"clear\"></div>
			<br /><br />
			<div style=\"float: left; width: 520px;\">
				<h2 class=\"dark\">{$lang['phpkiller']}</h2>
				<p>{$lang['phpkiller_text']}</p>
			</div>
			<div style=\"float: right; width: 480px; text-align: left;\">
				<h2 class=\"dark\">{$lang['ftpfilter']}</h2>
				<p>{$lang['ftpfilter_text']}</p>
			</div>
			<div class=\"clear\"></div>
			<br /><br />
			<div style=\"text-align: center;\">
				<a class=\"button classic\" href=\"https://github.com/OlympeNetwork\" style=\"height: 22px; width: 200px; margin: 0 auto;\">
					<span style=\"display: block; font-size: 18px; padding-top: 3px;\">{$lang['access']}</span>	
				</a>
			</div>
			<br /><br />
		</div>
	</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>
