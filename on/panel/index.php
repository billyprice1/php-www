<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$userinfo = api::send('self/user/list');
$userinfo = $userinfo[0];

$quotas =  api::send('self/quota/user/list');
$sites =  api::send('self/site/list');

foreach( $quotas as $q )
{
	if( $q['name'] == 'BYTES' ) {
		$quota['used'] = $q['used'];
		$quota['max'] = $q['max'];
	}
	
	if( $q['name'] == 'SITES' ) {
		$quota_sites['used'] = $q['used'];
		$quota_sites['max'] = $q['max'];
	}
}

if($quota['used'] == '' && $quota['max'] == '') {
	
	$_SESSION['MESSAGE']['TYPE'] = 'error';
	$_SESSION['MESSAGE']['TEXT']= $lang['error_quotas'];
	template::redirect('/about/contact');
	
} else {
	
	$percent = $quota['used']*100/$quota['max'];

	if( $quota['used'] >= 1024 )
		$quota['used'] = round($quota['used']/1024, 2) . " {$lang['gb']}";
	else
		$quota['used'] = "{$quota['used']} {$lang['mb']}";

	if( $quota['max'] >= 1024 )
		$quota['max'] = round($quota['max']/1024, 2) . " {$lang['gb']}";
	else
		$quota['max'] = "{$quota['max']} {$lang['mb']}";
}
	
$content = "
	<div class=\"panel\">
		<div class=\"top\">
			<div class=\"left\" style=\"width: 500px;\">
				<img style=\"width: 60px; height: 60px; float: left; margin: 0px 15px 0px 0px; border-radius: 100px; display: block;\" src=\"".(file_exists("{$GLOBALS['CONFIG']['SITE']}/images/users/{$userinfo['id']}.png")?"/{$GLOBALS['CONFIG']['SITE']}/images/users/{$userinfo['id']}.png":"/{$GLOBALS['CONFIG']['SITE']}/images/users/user.png")."\" />
				<h1 class=\"dark title\">".security::get('USER')."</h1>
				<h2 class=\"dark title\">".($userinfo['firstname']?"{$userinfo['firstname']} {$userinfo['lastname']}":"{$lang['nolastname']}")."</h2>
			</div>
			<div class=\"right\" style=\"width: 460px;\">
				<span style=\"block; float: left; padding-top: 7px; font-size: 18px; color: #878787;\">{$lang['disk2']}</span>
				<div style=\"float: right;\">
					<div class=\"fillgraph\" style=\"margin-top: 10px;\">
						<small style=\"width: {$percent}%;\"></small>
					</div>
					<span class=\"quota\"><span style='font-weight: bold;'>{$quota['used']}</span> {$lang['of']} {$quota['max']}. <a href=\"/panel/messages\">{$lang['request']}</a>.</span>
				</div>
			</div>
			<div class=\"clear\"></div>
		</div>
		<br />
		<div class=\"sites\">
			<div class=\"sitescontent\">";
				
				$display = rand(0,6);
				$twitter_text = 'twitter_text_' . rand(1,2);
				
				switch ($display) {
				case 0:
					$content .= "
					<div style=\"width: 1080px; padding: 10px; background-color: #fff; margin-bottom: 20px;\">
						<img style=\"display: block; float: left; margin-right: 10px; width: 70px;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/tax.png\" />
						<span style=\"font-size: 16px; display: block; padding: 10px 0px 0px; float: left;\">{$lang['help']} <a href=\"/org/help\" style=\"color:#5EA9DD\">{$lang['help_text']}</a> !</span><br /><br />
						<span style=\"color: #6C6C6C; left: -50px; display: block; font-size: 12px; position: relative; left:0px; bottom:0px\">{$lang['thanks']} <span style=\"font-weight: bold;\">{$lang['thanks2']}</span>.</span>
						<div class=\"clear\"></div>
					</div>";
					break;
				case 1:
					$content .= "
					<div style=\"width: 1080px; padding: 10px; background-color: #fff; margin-bottom: 20px;\">
						<img style=\"display: block; float: left; margin: 10px 10px 10px; width: 40px;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/social/twitter_icon.png\" />
						<span style=\"font-size: 16px; display: block; float: left; margin:5px 10px\">{$lang['twitter']}</span><br /><br />
						<span style=\"display: block; color: #959595; font-size: 12px; position: relative; left:10px; bottom:8px\">{$lang['share']}</span>
						<div class=\"clear\"></div>
					</div>";
					break;
				case 2:
					$content .= "
					<div style=\"width: 1080px; padding: 10px; background-color: #fff; margin-bottom: 20px;\">
						<img style=\"display: block; float: left; margin: 5px; width: 25px;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/love.png\" />
						<span style=\"font-size: 18px; display: block; float: left; margin:5px 10px\">{$lang['like_us']}</span>
						<div style=\"float: right; margin-top: 5px; margin-right: 25px;\">
							<a class=\"twitter-share-button\"
							   href=\"https://twitter.com/share\"
							  data-url=\"https://www.olympe.in\"
							  data-via=\"OlympeNet\"
							  data-text=\"{$lang[$twitter_text]}\"
							  data-count=\"none\">
							Tweet
							</a>
							<div class=\"fb-share-button\" data-href=\"https://www.olympe.in\" data-layout=\"button\" style=\"top: -5px; margin-left: 20px;\"></div>
						</div>
						<div class=\"clear\"></div>
					</div>";
					break;
				case 3:
					$content .= "
					<div style=\"width: 1080px; padding: 10px; background-color: #fff; margin-bottom: 20px;\">
						<img style=\"display: block; float: left; margin: 5px 10px; width: 40px;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/translate.png\" />
						<span style=\"font-size: 16px; display: block; float: left; margin:5px 10px\">{$lang['translate']}</span><br /><br />
						<span style=\"display: block; color: #959595; font-size: 12px; position: relative; left:10px; bottom:8px\">{$lang['translate_help']}</span>
						<div class=\"clear\"></div>
					</div>";
					break;
				case 4:
					$content .= "
					<div style=\"width: 1080px; padding: 10px; background-color: #F07C3E; margin-bottom: 20px; color:white; border-radius: 3px;\">
						<img style=\"display: block; float: left; margin: 5px 10px; width: 70px;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/cost-guy.png\" />
						<a class=\"animated infinite pulse\" style=\"color: white; float: right; background-color: rgb(237, 103, 31); padding: 10px; font-weight: bold; border-radius: 4px; font-size: 18px; margin-top: 25px; margin-right: 20px;\" href=\"http://www.tipeee.com/olympe-1\" target=\"_blank\"><i class=\"fa fa-chevron-right\"></i> {$lang['tip_button']}</a>
						<div class=\"animated fadeInUp\" style=\"float: left; margin: 20px 15px;\">
							<span style=\"font-size: 18px; display: block;\">{$lang['tip']}</span>
							<span style=\"display: block; color: #ffceb5; font-size: 16px; margin-top:5px;\">{$lang['tip_help']}</span>
						</div>
						<div class=\"clear\"></div>
					</div>";
					break;
				case 5:
					$content .= "
					<div style=\"width: 1080px; padding: 10px; background-color: #F07C3E; margin-bottom: 20px; color:white; border-radius: 3px;\">
						<img style=\"display: block; float: left; margin: 5px 10px; width: 70px;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/cost-guy.png\" />
						<a class=\"animated infinite pulse\" style=\"color: white; float: right; background-color: rgb(237, 103, 31); padding: 10px; font-weight: bold; border-radius: 4px; font-size: 18px; margin-top: 25px; margin-right: 20px;\" href=\"http://www.tipeee.com/olympe-1\" target=\"_blank\"><i class=\"fa fa-chevron-right\"></i> {$lang['tip_button']}</a>
						<div class=\"animated fadeInUp\" style=\"float: left; margin: 20px 15px;\">
							<span style=\"font-size: 18px; display: block;\">{$lang['tip']}</span>
							<span style=\"display: block; color: #ffceb5; font-size: 16px; margin-top:5px;\">{$lang['tip_help']}</span>
						</div>
						<div class=\"clear\"></div>
					</div>";
					break;
				case 6:
					$content .= "
					<div style=\"width: 1080px; padding: 10px; background-color: #F07C3E; margin-bottom: 20px; color:white; border-radius: 3px;\">
						<img style=\"display: block; float: left; margin: 5px 10px; width: 70px;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/cost-guy.png\" />
						<a class=\"animated infinite pulse\" style=\"color: white; float: right; background-color: rgb(237, 103, 31); padding: 10px; font-weight: bold; border-radius: 4px; font-size: 18px; margin-top: 25px; margin-right: 20px;\" href=\"http://www.tipeee.com/olympe-1\" target=\"_blank\"><i class=\"fa fa-chevron-right\"></i> {$lang['tip_button']}</a>
						<div class=\"animated fadeInUp\" style=\"float: left; margin: 20px 15px;\">
							<span style=\"font-size: 18px; display: block;\">{$lang['tip']}</span>
							<span style=\"display: block; color: #ffceb5; font-size: 16px; margin-top:5px;\">{$lang['tip_help']}</span>
						</div>
						<div class=\"clear\"></div>
					</div>";
					break;
				case 7:
					$content .= "
					<div style=\"width: 1080px; padding: 10px; background-color: #fff; margin-bottom: 20px;\">
						<img style=\"display: block; float: left; margin: 10px 10px 10px; width: 40px;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/check.png\" />
						<span style=\"font-size: 16px; display: block; float: left; margin:5px 10px\">{$lang['join_us']}</span><br /><br />
						<span style=\"display: block; color: #959595; font-size: 12px; position: relative; left:10px; bottom:8px\">{$lang['share']}</span>
						<div class=\"clear\"></div>
					</div>";
					break;

				}

				$content .="
				<div class=\"site newsite\" id=\"newsite\">
					<div id=\"addsite\">
						<a href=\"#\" onclick=\"showForm(); return false;\" class=\"button grey\" style=\"margin: 0 auto; margin-top: 97px; padding: 10px 0 0 0; height: 40px; width: 50px; text-align: center; \">
							<img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/plus-white.png\" style=\"margin: 3px 0px 0px;\" />
						</a>
					</div>
					<div id=\"formsite\" style=\"display: none; position: relative; padding: 30px 10px 10px 10px;\">
						<a href=\"#\" style=\"display: block; position: absolute; top: 5px; left: 5px;\" onclick=\"showNew(); return false;\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/arrowLeft.png\" alt=\"\" /></a>
						<div class=\"form-small\">					
";


if( $quota_sites['used'] == $quota_sites['max'] )
	$content .= "
							<div style=\"text-align: justify; line-height: 25px; padding: 25px 10px 10px;\">{$lang['reached_site_quota']}</div>
	";
	
else 
	$content .= "
							<form action=\"/panel/sites/add_action\" method=\"post\" class=\"center\">
								<fieldset style=\"padding-top: 10px;\">
									<input class=\"auto\" type=\"text\" placeholder=\"{$lang['name']}\" required name=\"subdomain\" />
									<span class=\"help-block\">{$lang['tipsite']}</span>
								</fieldset>
								<fieldset>
									<input class=\"auto\" type=\"password\" placeholder=\"{$lang['password']}\" required name=\"password\" />
									<span class=\"help-block\">{$lang['tippassword']}</span>
								</fieldset>
								<fieldset>	
									<input autofocus type=\"submit\" value=\"{$lang['create']}\" style=\"width: 120px;\" />
								</fieldset>
							</form>
	";
	
$content .= "
						</div>
					</div>
					<div id=\"nonewsite\" style=\"display:none; position: relative; padding: 50px 20px 20px; text-align: justify; line-height: 25px;\">
						<a href=\"#\" style=\"display: block; position: absolute; top: 5px; left: 5px;\" onclick=\"showNew(); return false;\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/arrowLeft.png\" alt=\"\" /></a>
						<div class=\"form-small\">		
							{$lang['reached_site_quota']}
						</div>
					</div>
				</div>
";

if( count($sites) == 0 )
{
	$content .= "<div class=\"new\">
					<div class=\"bullet\"></div>
					<div class=\"text\">
						<span class=\"title\">{$lang['welcome']}</span>
						{$lang['welcome_text']}
					</div>
				</div>
	";
}
else
{
	$count = count($sites);
	$i = 1;
	
	foreach( $sites as $s )
	{
		if( $i == $count )
			$last = "style=\"margin-right: 0;\"";
			
		$i++;
		
		if( !$s['size'] )
			$s['size'] = 0;
			
		$content .= "
				<div class=\"site\" {$last} onclick=\"window.location.href='/panel/sites/config?id={$s['id']}'; return false;\">
					<div class=\"normal\">
						<span style=\"font-size: 16px; font-weight: bold; display: block; margin-bottom: 5px; text-overflow: ellipsis; max-width: 100%; overflow: hidden; white-space:nowrap;\">{$s['hostname']}</span>
						<span style=\"color: #9a9a9a; font-size: 12px; display: block; margin-bottom: 20px;\">{$lang['disk']} {$s['size']} {$lang['mb']}</span></span>
						<div class=\"thumbshot\">
							<img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/sites/?url={$s['hostname']}\" />
						</div>
					</div>
				</div>
		";
	}
}

$content .= "
			<div class=\"clear\"></div>
			</div>
		</div>	
	</div>
	<div id=\"fb-root\"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = \"//connect.facebook.net/fr_FR/sdk.js#xfbml=1&version=v2.0\";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
	<script>
	window.twttr=(function(d,s,id){var t,js,fjs=d.getElementsByTagName(s)[0];if(d.getElementById(id)){return}js=d.createElement(s);js.id=id;js.src=\"https://platform.twitter.com/widgets.js\";fjs.parentNode.insertBefore(js,fjs);return window.twttr||(t={_e:[],ready:function(f){t._e.push(f)}})}(document,\"script\",\"twitter-wjs\"));
	</script>
	<script>
		function showForm()
		{
			var options = {};
			$(\"#addsite\").css(\"display\", \"none\");
			$(\"#formsite\").show(\"fade\", options, 200);
			$(\"#newsite\").css(\"background-color\", \"#ffffff\");
			
		}
		function showNew()
		{
			var options = {};
			$(\"#formsite\").css(\"display\", \"none\");
			$(\"#addsite\").show(\"fade\", options, 200);
			$(\"#newsite\").css(\"background\", \"rgba(0, 0, 0, 0.05)\");
		}
	</script>";


/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>