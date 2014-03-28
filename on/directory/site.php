<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$site = api::send('site/list', array('id'=>$_GET['id'], 'directory'=>1), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
$site = $site[0];

$lang['TITLE'] = $lang['olympe'] . $site['title'];

if( $security->hasAccess('/panel') )
	$rating = api::send('self/site/getrate', array('id'=>$_GET['id']));

if( $site['rating']['count'] == 0 )
	$site['rating']['count'] = 1;
	
$content .= "
		<div id=\"directorycontainer\">
			<div class=\"directory\">
				<div class=\"container\">
					<div class=\"logo\">
						<img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/sites/?url={$site['url']}\" />
					</div>
					<div style=\"float: left; width: 600px;\">
						<h1 class=\"dark\">{$site['title']}</h1>
						<span class=\"category\">".$lang['CAT_' . $site['category']]."</span>
						<div class=\"clear\"></div>
						<br />
						<a class=\"callout\" href=\"http://{$site['url']}\">{$lang['visit']}</a>
						<br /><br /><br />
						<div class=\"seperator-mini\" style=\"width: 620px;\"></div>
						<div class=\"star\" data-score=\"{$rating['rating_value']}\" data-id=\"{$site['id']}\"></div>
						<span class=\"label\">{$lang['edited']} {$site['user']}</span>
						<div class=\"social\">
							<div class=\"fb-like\" data-href=\"https://www.olympe.in/directory/site?id={$site['id']}\" data-width=\"\" data-height=\"\" data-colorscheme=\"light\" data-layout=\"button_count\" data-action=\"like\" data-show-faces=\"true\" data-send=\"false\"></div>
						</div>
						<div class=\"social\">
							<div class=\"g-plusone\" data-size=\"medium\"></div>
						</div>
					</div>
					<div style=\"float: right; width: 100px;\">
						<a class=\"action report\" href=\"#\" onclick=\"$('#report').dialog('open'); $('input[name=site]').val('{$site['id']}'); return false;\">
							{$lang['report']}
						</a>	
					</div>
				</div>
				<div class=\"clear\"></div>
			</div>
			<div class=\"directorylight\">
				<div style=\"float: right;\">
					<h1 class=\"dark thin\">{$lang['rating']}</h1>
					<br />
					<div style=\"background-color: #f2f2f2; width: 360px; height: 120px; padding: 8px 10px 10px 10px;\">
						<div style=\"float: left; width: 150px; text-align: center;\">
							<span style=\"font-size: 4em; text-align: center;\">".round($site['rating']['value'], 2)."</span>
							<div class=\"bigstar\" data-score=\"{$site['rating']['value']}\"></div>
							<img style=\"display: inline-block;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/mini-user.png\" />
							<span style=\"color: #a6a6a6; font-size: 12px;\">{$site['rating']['count']} {$lang['total']}</span>
						</div>
						<div style=\"float: left; width: 180px; text-align: left; margin-left: 15px;\">
							<div style=\"clear: left; height: 25px;\">
								<img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/star-on.png\" style=\"float: left; display: block; padding-top: 4px;\" />
								<span style=\"float: left; font-size: 12px; margin-left: 10px; display: block; padding-top: 4px; width: 5px;\">5</span>
								<span style=\"margin-left: 10px; width: ".(($site['rating']['count5']*70/$site['rating']['count'])==0?"10":"".($site['rating']['count5']*70/$site['rating']['count'])."")."%; background-color: #9fc05a; display: block; height: 25px; float: left; text-align: center;\"><span style=\"padding: 4px; display: block; margin: 0 auto; text-align: center;\">{$site['rating']['count5']}</span></span></span>
							</div>
							<div style=\"clear: left; height: 25px;\">
								<img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/star-on.png\" style=\"float: left; display: block; padding-top: 4px;\" />
								<span style=\"float: left; font-size: 12px; margin-left: 10px; display: block; padding-top: 4px; width: 5px;\">4</span>
								<span style=\"margin-left: 10px; width: ".(($site['rating']['count4']*70/$site['rating']['count'])==0?"10":"".($site['rating']['count4']*70/$site['rating']['count'])."")."%; background-color: #add633; display: block; height: 25px; float: left; text-align: center;\"><span style=\"padding: 4px; display: block; margin: 0 auto; text-align: center;\">{$site['rating']['count4']}</span></span>
							</div>
							<div style=\"clear: left; height: 25px;\">
								<img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/star-on.png\" style=\"float: left; display: block; padding-top: 4px;\" />
								<span style=\"float: left; font-size: 12px; margin-left: 10px; display: block; padding-top: 4px; width: 5px;\">3</span>
								<span style=\"margin-left: 10px; width: ".(($site['rating']['count3']*70/$site['rating']['count'])==0?"10":"".($site['rating']['count3']*70/$site['rating']['count'])."")."%; background-color: #ffd834; display: block; height: 25px; float: left; text-align: center;\"><span style=\"padding: 4px; display: block; margin: 0 auto; text-align: center;\">{$site['rating']['count3']}</span></span>
							</div>
							<div style=\"clear: left; height: 25px;\">
								<img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/star-on.png\" style=\"float: left; display: block; padding-top: 4px;\" />
								<span style=\"float: left; font-size: 12px; margin-left: 10px; display: block; padding-top: 4px; width: 5px;\">2</span>
								<span style=\"margin-left: 10px; width: ".(($site['rating']['count2']*70/$site['rating']['count'])==0?"10":"".($site['rating']['count2']*70/$site['rating']['count'])."")."%; background-color: #ffb234; display: block; height: 25px; float: left; text-align: center;\"><span style=\"padding: 4px; display: block; margin: 0 auto; text-align: center;\">{$site['rating']['count2']}</span></span>
							</div>
							<div style=\"clear: left; height: 25px;\">
								<img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/star-on.png\" style=\"float: left; display: block; padding-top: 4px;\" />
								<span style=\"float: left; font-size: 12px; margin-left: 10px; display: block; padding-top: 4px; width: 5px;\">1</span>
								<span style=\"margin-left: 10px;width: ".(($site['rating']['count1']*70/$site['rating']['count'])==0?"10":"".($site['rating']['count1']*70/$site['rating']['count'])."")."%; background-color: #ff8b5a; display: block; height: 25px; float: left; text-align: center;\"><span style=\"padding: 4px; display: block; margin: 0 auto; text-align: center;\">{$site['rating']['count1']}</span>
							</div>
						</div>						
						<div class=\"clear\"></div>
					</div>
				</div>
				<h1 class=\"dark thin\">{$lang['description']}</h1>
				<p style=\"margin-top: 15px; font-size: 18px; width: 600px;\">".bbcode::display($site['description'])."</p>
				<div class=\"clear\"><br /><br /></div>
				<br />
				<div class=\"seperator-light\"></div>
				<div class=\"comments\">
					<h1 class=\"dark thin\">{$lang['comments']}</h1>
					<br />
					<div id=\"disqus_thread\"></div>
					<script type=\"text/javascript\">
						/* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
						var disqus_developer = 0; // developer mode
						var disqus_shortname = 'olympe'; // required: replace example with your forum shortname
						var disqus_identifier = 'Site - {$site['title']}';
						var disqus_url = 'https://www.olympe.in/directory/site?id={$site['id']}';
						/* * * DON'T EDIT BELOW THIS LINE * * */
						(function() {
							var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
							dsq.src = 'https://' + disqus_shortname + '.disqus.com/embed.js';
							(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
						})();
					</script>
					
				</div>
				<div class=\"clear\"><br /></div>
			</div>
		</div>
		<div id=\"report\" class=\"floatingdialog\">
			<br />
			<h3 class=\"center\">{$lang['newreport']}</h3>
			<p style=\"text-align: center;\">{$lang['newreport_text']}</p>
			<div class=\"form-small\">
				<form action=\"/directory/report_action\" method=\"post\" class=\"center\">
					<input type=\"hidden\" name=\"site\" value=\"\" />
					<fieldset>
						<input class=\"auto\" type=\"text\" style=\"width: 400px;\" value=\"{$lang['title']}\" name=\"title\" onfocus=\"this.value = this.value=='{$lang['title']}' ? '' : this.value; this.style.color='#4c4c4c';\" onfocusout=\"this.value = this.value == '' ? this.value = '{$lang['title']}' : this.value; this.value=='{$lang['title']}' ? this.style.color='#cccccc' : this.style.color='#4c4c4c'\" />
						<span class=\"help-block\">{$lang['title_help']}</span>
					</fieldset>
					<fieldset>
						<textarea class=\"auto\" style=\"width: 400px; height: 150px;\" name=\"content\" onfocus=\"this.value = this.value=='{$lang['content']}' ? '' : this.value; this.style.color='#4c4c4c';\" onfocusout=\"this.value = this.value == '' ? this.value = '{$lang['content']}' : this.value; this.value=='{$lang['content']}' ? this.style.color='#cccccc' : this.style.color='#4c4c4c'\">{$lang['content']}</textarea>
						<span class=\"help-block\">{$lang['content_help']}</span>
					</fieldset>
					<fieldset>	
						<input autofocus type=\"submit\" value=\"{$lang['submit']}\" />
					</fieldset>
				</form>							
			</div>
		</div>	
		<script type=\"text/javascript\">
			window.___gcfg = {lang: 'fr'};
		
			(function() {
				var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
				po.src = 'https://apis.google.com/js/plusone.js';
				var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
			})();
			
			newFlexibleDialog('report', 550);
		</script>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>