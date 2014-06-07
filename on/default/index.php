<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$content = "
			<div class=\"head\">
				<br />
				<h1>{$lang['title']}</h1>
				<h2 style=\"margin: 15px 0 15px 0;\">{$lang['subtitle']}</h2>
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
			<div id=\"loginform\" style=\"display: none; padding-top: 20px;\">
				<div class=\"form-small\">
					<form action=\"/login_action\" method=\"post\" class=\"center\">
						<input type=\"hidden\" name=\"antispam\" value=\"{$_SESSION['ANTISPAM']}\" />
						<fieldset>
							<input class=\"auto\" type=\"text\" value=\"{$lang['username']}\" name=\"username\" onfocus=\"this.value = this.value=='{$lang['username']}' ? '' : this.value; this.style.color='#4c4c4c';\" onfocusout=\"this.value = this.value == '' ? this.value = '{$lang['username']}' : this.value; this.value=='{$lang['username']}' ? this.style.color='#cccccc' : this.style.color='#4c4c4c'\" />
						</fieldset>
						<fieldset>
							<input class=\"auto\" type=\"password\" value=\"{$lang['password']}\" name=\"password\" onfocus=\"this.value = this.value=='{$lang['password']}' ? '' : this.value; this.style.color='#4c4c4c';\" onfocusout=\"this.value = this.value == '' ? this.value = '{$lang['password']}' : this.value; this.value=='{$lang['password']}' ? this.style.color='#cccccc' : this.style.color='#4c4c4c'\"/>
							".(isset($_GET['elogin'])?"<span class=\"help-block\" style=\"color: #bc0000;\">{$lang['auth']}</span>":"<span class=\"help-block\">{$lang['register']}</span>")."
						</fieldset>
						<input autofocus type=\"submit\" style=\"margin-bottom: 0; margin-top: 5px;\"  value=\"{$lang['login']}\" />											
					</form>
				</div>
			</div>
			<div id=\"signupform\" style=\"display: none; padding-top: 20px;\">
				<div class=\"form-small\">
					<form action=\"/signup_action\" method=\"post\" id=\"valid\" class=\"center\">
						<input type=\"hidden\" name=\"antispam\" value=\"{$_SESSION['ANTISPAM']}\" />
						<fieldset>
							<input class=\"auto\" type=\"text\" value=\"".($_SESSION['JOIN_EMAIL']?"{$_SESSION['JOIN_EMAIL']}":"{$lang['email']}")."\" name=\"email\" onfocus=\"this.value = this.value=='{$lang['email']}' ? '' : this.value; this.style.color='#4c4c4c';\" onfocusout=\"this.value = this.value == '' ? this.value = '{$lang['email']}' : this.value; this.value=='{$lang['email']}' ? this.style.color='#cccccc' : this.style.color='#4c4c4c'\" />
						</fieldset>
						<fieldset>
							<input type=\"checkbox\" name=\"conditions\" value=\"1\" />
							{$GLOBALS['lang']['conditions']}
						</fieldset>
						<input autofocus type=\"submit\" style=\"margin-bottom: 0; margin-top: 5px;\" value=\"{$lang['signup']}\" ".($_SESSION['JOIN_STATUS']===0?'disabled':'')." />
					</form>
				</div>
			</div>
			<div class=\"lines\">
				<div class=\"lines-content\">
					<div class=\"hfree\">
						<a href=\"/service/hosting\" class=\"hfree\"><h3 class=\"red\" style=\"padding-top: 100px;\">{$lang['free']}</h3></a>
						<p>{$lang['free_text']}</p>
					</div>
					<div class=\"hinnovation\">
						<a href=\"/service/infrastructure\" class=\"hinnovation\"><h3 class=\"blue\"  style=\"padding-top: 100px;\">{$lang['innovation']}</h3></a>
						<p>{$lang['innovation_text']}</p>
					</div>
					<div class=\"hopen\">
						<a href=\"/developers\" class=\"hopen\"><h3 class=\"green\"  style=\"padding-top: 100px;\">{$lang['open']}</h3></a>
						<p>{$lang['open_text']}</p>
					</div>
				</div>
			</div>
			<div class=\"separator light\"></div>
			<div id=\"stats\" style=\"text-align: center;\"></div>
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
				$(\"#stats\").html(\"<img src='/{$GLOBALS['CONFIG']['SITE']}/images/anim_loading_16x16.gif' />\");
				$(\"#stats\").load(\"/default/stats\");
			
				function showLogin()
				{
					if( $(\"#signupform\").css('display') != 'none' )
						$(\"#signupform\").css('display', 'none');
						
					var options = { direction: \"up\"};
					$(\"#loginform\").toggle(\"blind\", options, 200);
				}
				function showSignup()
				{
					if( $(\"#loginform\").css('display') != 'none' )
						$(\"#loginform\").css('display', 'none');
						
					var options = { direction: \"up\"};
					$(\"#signupform\").toggle(\"blind\", options, 200);
				}
			</script>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>