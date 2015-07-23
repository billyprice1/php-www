<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$content = "
			<div class=\"head\">
				<br />
				<div id=\"homepage\">
					<h1>{$lang['title']}</h1>
					<h2 style=\"margin: 15px auto;\">{$lang['subtitle']}</h2>
					
				</div>
				<br />
";

if( $security->hasAccess('/panel') )
{
	$content .= "
				<a class=\"button main\" href=\"/panel\">{$lang['panel']}</a>
				<span class=\"light\">{$lang['logged']} <span style=\"color: #ffffff;\">".security::get('USER')."</span>.</span>
	";
}
else
{
	$content .= "
				<a class=\"button main\" href=\"#\" onclick=\"showSignup(); return false;\">{$lang['signup']}</a>
				<span class=\"light\"><a href=\"#\" onclick=\"showLogin(); return false;\">{$lang['login_now']}</a></span>
	";
}

if( !isset($_SESSION['ANTISPAM']) )
	$_SESSION['ANTISPAM'] = md5(time().'olympe');

$content .= "
				<br />
			</div>
			<noscript>
				<div class=\"noscript-alert\">
					{$lang['noscript']}
				</div>
			</noscript>
			<div id=\"loginform\" style=\"display: none; padding-top: 20px;\">
				<div class=\"form-small\">
					<form action=\"/login_action\" method=\"post\" class=\"center\">
						<input type=\"hidden\" name=\"antispam\" value=\"{$_SESSION['ANTISPAM']}\" />
						<fieldset>
							<input class=\"auto\" type=\"text\" placeholder=\"{$lang['username']}\" name=\"username\" />
						</fieldset>
						<fieldset>
							<input class=\"auto\" type=\"password\" placeholder=\"{$lang['password']}\" name=\"password\" />
							".(isset($_GET['elogin'])?"<span class=\"help-block\" style=\"color: #bc0000;\">{$lang['auth']}</span>":"<span class=\"help-block\">{$lang['register']}</span>")."
						</fieldset>
						<input type=\"submit\" style=\"margin-bottom: 0; margin-top: 5px;\"  value=\"{$lang['login']}\" />											
					</form>
				</div>
			</div>
			<div id=\"signupform\" style=\"display: none; padding-top: 20px;\">
				<div class=\"form-small\">
					<form action=\"/signup_action\" method=\"post\" id=\"valid\" class=\"center\">
						<input type=\"hidden\" name=\"antispam\" value=\"{$_SESSION['ANTISPAM']}\" />
						<fieldset>
							<input class=\"auto\" type=\"text\" placeholder=\"{$lang['email']}\" value=\"".($_SESSION['JOIN_EMAIL']?"{$_SESSION['JOIN_EMAIL']}":"")."\" name=\"email\" />
						</fieldset>
						<fieldset>
							<input type=\"checkbox\" name=\"conditions\" value=\"1\" />
							{$GLOBALS['lang']['conditions']}
						</fieldset>
						<input type=\"submit\" style=\"margin-bottom: 0; margin-top: 5px;\" value=\"{$lang['signup']}\" ".($_SESSION['JOIN_STATUS']===0?'disabled':'')." />
					</form>
				</div>
			</div>
			<div class=\"lines\">
				<div class=\"lines-content\">
					<div class=\"hfree\">
						<a href=\"/service/hosting\" class=\"hfree\">
							<span></span>
							<h3 class=\"red\">{$lang['free']}</h3>
						</a>
						<p>{$lang['free_text']}</p>
					</div>
					<div class=\"hinnovation\">
						<a href=\"/service/infrastructure\" class=\"hinnovation\">
							<span></span>
							<h3 class=\"blue\">{$lang['innovation']}</h3>
						</a>
						<p>{$lang['innovation_text']}</p>
					</div>
					<div class=\"hopen\">
						<a href=\"/developers\" class=\"hopen\">
							<span></span>
							<h3 class=\"green\">{$lang['open']}</h3>
						</a>
						<p>{$lang['open_text']}</p>
					</div>
				</div>
			</div>
			<div class=\"separator light\"></div>
			<div id=\"stats\" style=\"text-align: center;\">
				<img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/anim_loading_16x16.gif\" alt=\"loading...\" />
			</div>
			<div class=\"separator light\"></div>
			<div class=\"content\">
				<div class=\"left\">
					<h3>{$lang['app']}</h3>
					<p>{$lang['app_text']}</p>
				</div>
				<div class=\"right\" style=\"text-align: center;\">
					<div class=\"terminal\">
						<div class=\"indicators\">
							<span class=\"circle\"></span>
							<span class=\"circle\"></span>
							<span class=\"circle\"></span>
						</div>
						<div class=\"terminal-text\">
							<a href=\"/service/hosting\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/pages/panel-1.png\" alt=\"map\" style=\"display: block; padding: 15px 0 0 50px;\" /></a>
						</div>
					</div>
				</div>
				<div class=\"clear\" style=\"margin-bottom: 60px;\"></div>
				<div class=\"left\" style=\"text-align: center;\">
					<div class=\"terminal\">
						<div class=\"indicators\">
							<span class=\"circle\"></span>
							<span class=\"circle\"></span>
							<span class=\"circle\"></span>
						</div>
						<div class=\"terminal-text\">
							<a href=\"/service/offer\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/pages/service.png\" alt=\"map\" style=\"display: block; padding: 10px 0 0 10px;\" /></a>
						</div>
					</div>
				</div>
				<div class=\"right\">
					<h3>{$lang['manage']}</h3>
					<p>{$lang['manage_text']}</p>
				</div>
				<div class=\"clear\"><br /></div>
				<div class=\"separator light\"></div>
				<div class=\"customers\">
					<blockquote>
						<p>{$lang['hosted']}</p>
						<p style=\"font-size: 18px; display: block; margin-top: 10px;\"><a href=\"/directory\">{$lang['directory']}</a></p>
					</blockquote>
				</div>
				<div class=\"separator light\"></div>
				<div style=\"text-align: center;\">
					<a class=\"button classic\" href=\"#\" onclick=\"$('#signup').dialog('open'); return false;\" style=\"height: 22px; width: 200px; margin: 0 auto;\">
						<span style=\"display: block; font-size: 18px; padding-top: 3px;\">{$lang['signup_now']}</span>
					</a>
					<p>{$lang['help']}</p>
				</div>
				<br />
				<br />
				<br />
			</div>

			<script>
				$.ajax(\"/default/stats\").done(function(result) {
					$(\"#stats\").html(result);
				});
			</script>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>