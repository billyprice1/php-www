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

					<br />
					<h4>{$lang['cookie']}</h4>
					<p>{$lang['cookie_explain']}</p>
					<p style=\"padding-top: 10px;\">{$lang['cookie_explain_2']}</p>
					<ul class=\"classic\">
						<li><a  href=\"http://windows.microsoft.com/fr-fr/internet-explorer/delete-manage-cookies#ie=ie-11\">Internet Explorer</a></li>
						<li><a  href=\"https://support.mozilla.org/fr/kb/activer-desactiver-cookies\">Mozilla Firefox</a></li>
						<li><a  href=\"https://support.google.com/accounts/answer/61416\">Google Chrome</a></li>
						<li><a  href=\"https://support.apple.com/fr-fr/HT1677\">Apple Safari</a></li>
					</ul><br />
					<p>{$lang['cookie_explain_3']}</p>
					<form method=\"post\" id=\"cookie_action\" action=\"about/cookie_action\">
						<input type=\"hidden\" name=\"cookie_current\" value=\"\" />
";

if(isset($_COOKIE["cookie_agreement"]) && $_COOKIE['cookie_agreement'] == 0)
	$content .= "
		<label id=\"cookie_agreement\" style=\"width:400px;\">
			<input type=\"checkbox\" name=\"cookie_agree\" value=\"1\" style=\"float: left; margin: 6px 13px;\" /> {$lang['cookie_unagree']}
		</label>
	";

if(!isset($_COOKIE["cookie_agreement"]) || $_COOKIE['cookie_agreement'] == 1)
	$content .= "
		<label id=\"cookie_agreement\" style=\"width:400px;\">
			<input type=\"checkbox\" name=\"cookie_agree\" checked value=\"1\" style=\"float: left; margin: 6px 13px;\" /> {$lang['cookie_agreed']}
		</label>
	";
	
/*
TODO :
[] traduire cookie_explain2 ; 3 et cookie_unagree / agreed
[] gérer l'acceptation / refus
*/

$content .= "
					</form>
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
			<script>
			$(function() {
				$('#cookie_agreement').click(function() {
					$('#cookie_action').submit();
				});
			});
			</script>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>