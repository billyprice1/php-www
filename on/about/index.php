<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

if( isset($_GET['cookie']) && $_GET['cookie']=='remove' ) {
	if (isset($_SERVER['HTTP_COOKIE'])) {
		$cookies = explode(';', $_SERVER['HTTP_COOKIE']);
		foreach($cookies as $cookie) {
			$parts = explode('=', $cookie);
			$name = trim($parts[0]);
			setcookie($name, '', time()-1000);
			setcookie($name, '', time()-1000, '/');
		}
	}
}

$content = "
			<div class=\"head-light\">
				<div class=\"container\">
					<h1 class=\"dark\">{$lang['title']}</h1>
				</div>
			</div>	
			<div class=\"content\">
				<div class=\"left big\">
					<h4>{$lang['intro']}</h4>
					<p>{$lang['intro_text']}</p>
					<br />
					<h4>{$lang['data']}</h4>
					<p>{$lang['data_text']}</p>
				</div>
				<div class=\"right small border\">
					<h4>{$lang['follow']}</h4>
					<p><a href=\"http://twitter.com/OlympeNet\">Twitter</a></p>
					<p><a href=\"http://www.facebook.com/olympe.org\">Facebook</a></p>
					<p><a href=\"http://www.linkedin.com/company/711968\">LinkedIn</a></p>
					<p><a href=\"/blog\">{$lang['news']}</a></p>
					<br />
					<h4>{$lang['behind']}</h4>
					<p>{$lang['behind_text']}</p>
					<br />
					<h4>{$lang['legal']}</h4>
					<p>{$lang['legal_text']}</p>
				</div>
				<div class=\"clear\"></div>
				<br /><br />
			</div>
			
			<div id=\"cookie\" class=\"floatingdialog delete-link\">
				<h3 class=\"center\">{$lang['cookie']}</h3>
				<p style=\"text-align: center;\">{$lang['cookie_explain']}</p>
				<a href=\"/about?cookie=remove\"><input type=\"button\" id=\"no_cookie\" style=\"margin:auto;\" value=\"{$lang['cookie_no']}\" /></a>
			</div>
";

if( isset($_GET['cookie']) &&  $_GET['cookie']!='remove' )
{
	$content .= "<script type=\"text/javascript\">
					newFlexibleDialog('cookie', 800);

					$(document).ready(function() {
						$(\"#cookie\").dialog(\"open\");
						$(\".ui-dialog-titlebar\").hide();
					});
				</script>
	";
}

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>