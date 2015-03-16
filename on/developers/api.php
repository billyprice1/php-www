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
			<div style=\"float: left;  width: 520px;\">
				<h2 class=\"dark\">{$lang['subtitle']}</h2>
				<p>{$lang['intro']}</p>
			</div>
			<div style=\"float: right; width: 480px; text-align: right;\">
				<img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/pages/createdomain.png\" style=\"float: left; display: block; padding: 10px; border: 1px solid #d1d1d1; border-radius: 3px;\" />
			</div>
			<div class=\"clear\"></div>			
			<p><span style=\"font-weight: bold;\">{$lang['steps']}</span></p>
			<span style=\"font-size: 15px; color: #338100; display: block;\">1. {$lang['step_1']}</span>
			<code>
				HTML: GET <span>https://api.olympe.in/self/token/select?user={USERNAME}&password={PASSWORD}&format=html</span><br />
				JSON: GET <span>https://api.olympe.in/self/token/select?user={USERNAME}&password={PASSWORD}&format=json</span>
			</code>
			<br />
			<span style=\"font-size: 15px; color: #338100; display: block;\">2. {$lang['step_2']}</span>
			<code>
				HTML: GET <span>https://api.olympe.in/self/user/select?auth={USERNAME}:{TOKEN}&user={USERNAME}&format=html</span><br />
				JSON: GET <span>https://api.olympe.in/self/user/select?auth={USERNAME}:{TOKEN}&user={USERNAME}&format=json</span>
			</code>
			<br /><br />
			<div style=\"text-align: center;\">
				<a class=\"button classic\" href=\"https://api.olympe.in\" style=\"height: 22px; width: 200px; margin: 0 auto;\">
					<span style=\"display: block; font-size: 18px; padding-top: 3px;\">{$lang['api']}</span>	
				</a>
			</div>
			<br /><br />
		</div>
	</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>
