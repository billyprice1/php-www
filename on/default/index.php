<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$content = "
			<div class=\"head\">
				<div>
					<br />
					<div id=\"homepage\">
						<img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/computer.png\" alt=\"\" class=\"animated fadeInRight\" />
						<h1 class=\"fadeInLeft animated\">{$lang['title']}</h1>
						<h2 class=\"fadeInLeft animated\">{$lang['subtitle']}</h2>
					</div>
					<br />
";

if( $security->hasAccess('/panel') )
{
	$content .= "
					<div class=\"homepage_button fadeInUp animated\">
						<a class=\"button main\" href=\"/panel\">{$lang['panel']}</a>
						<a class=\"button main second\" href=\"/panel/settings\"><i class=\"fa fa-user\"></i> ".security::get('USER')."</a>
					</div>
	";
}
else
{
	$content .= "
					<div class=\"homepage_button fadeInUp animated\">
						<a class=\"button main\" href=\"#\" onclick=\"showSignup(); return false;\">{$lang['signup']}</a>
						<a class=\"button main second\" href=\"#\" onclick=\"showLogin(); return false;\">{$lang['login_now']}</a>
					</div>
	";
}

if( !isset($_SESSION['ANTISPAM']) )
	$_SESSION['ANTISPAM'] = md5(time().'olympe');

$content .= "
					<div class=\"clear\"></div>
				</div>
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
							<label class=\"clean\">
								<input class=\"auto\" type=\"text\" placeholder=\"{$lang['ph_username']}\" name=\"username\" />
								<span class=\"help-block\">{$lang['lab_username']}</span>
							</label>
						</fieldset>
						<fieldset>
							<label class=\"clean\">
								<input class=\"auto\" type=\"password\" placeholder=\"**************\" name=\"password\" />
								".(isset($_GET['elogin'])?"<span class=\"help-block\" style=\"color: #bc0000;\">{$lang['auth']}</span>":"<span class=\"help-block\">{$lang['lab_password']}</span>")."
							</label>
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
							<label class=\"clean\">
								<input class=\"auto\" type=\"text\" placeholder=\"john@example.com\" value=\"".($_SESSION['JOIN_EMAIL']?"{$_SESSION['JOIN_EMAIL']}":"")."\" name=\"email\" />
								<span class=\"help-block\">{$lang['email']}</span>
							</label>
						</fieldset>
						<fieldset>
							<label class=\"clean\">
								<input type=\"checkbox\" name=\"conditions\" value=\"1\" />
								{$GLOBALS['lang']['conditions']}
							</label>
						</fieldset>
						<input type=\"submit\" style=\"margin-bottom: 0; margin-top: 5px;\" value=\"{$lang['signup']}\" ".($_SESSION['JOIN_STATUS']===0?'disabled':'')." />
					</form>
				</div>
			</div>
			<div class=\"lines\">
				<div class=\"lines-content\">
					<div class=\"hfree\">
						<a href=\"/service/hosting\" class=\"hfree\">
							<span class=\"zoomIn animated\"></span>
							<h3 class=\"red\">{$lang['free']}</h3>
						</a>
						<p>{$lang['free_text']}</p>
					</div>
					<div class=\"hinnovation\">
						<a href=\"/service/infrastructure\" class=\"hinnovation\">
							<span class=\"zoomIn animated\"></span>
							<h3 class=\"blue\">{$lang['innovation']}</h3>
						</a>
						<p>{$lang['innovation_text']}</p>
					</div>
					<div class=\"hopen\">
						<a href=\"/developers\" class=\"hopen\">
							<span class=\"zoomIn animated\"></span>
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