<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$news = api::send('news/list', array('id'=>$_GET['id']), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
$news = $news[0];

$month = date('F', $news['date']);
$month_translate = $lang[$month];

$lang['TITLE'] = $lang['olympe'] . $news['title'];

$content = "
			<div class=\"head-light\">
				<div class=\"container\" style=\"text-align: center;\">
					<h1 class=\"dark\" style=\"text-align: center;\">{$news['title']}</h1>
					<div style=\"width: 305px; margin: 0 auto;\">
						<span style=\"color: #797979; font-size: 14px; display: block; float: left; padding-top: 7px;\">".str_replace($month, $month_translate, date($lang['DATEFORMAT'], $news['date']))." {$lang['by']}</span>
						<img style=\"display: block; float: left; margin-left: 10px;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/team/{$news['author']}.png\" class=\"author\" />
						<a style=\"display: block; float: left; padding-top: 8px; margin-left: 10px;\" href=\"/about/team#".$lang['author_' . $news['author']]."\">".$lang['author_' . $news['author']]."</a>
						<div class=\"clear\"></div>
						<div style=\"margin: 0 auto; width: 260px; margin-top: 25px;\">
							<div style=\"float: left; width: 80px;\">
								<div class=\"fb-like\" data-href=\"https://www.olympe.in/blog/post?id={$news['id']}\" data-width=\"\" data-height=\"\" data-colorscheme=\"light\" data-layout=\"button_count\" data-action=\"like\" data-show-faces=\"true\" data-send=\"false\"></div>
							</div>
							<div style=\"float: left; width: 80px; margin-left: 10px;\">
								<a href=\"https://twitter.com/share\" class=\"twitter-share-button\" data-via=\"olympe_fr\">Tweet</a>
							</div>
							<div style=\"float: left; width: 80px; margin-left: 10px;\">
								<div class=\"g-plusone\" data-size=\"medium\"></div>
							</div>
							<div class=\"clear\"></div>
						</div>
					</div>
				</div>
			</div>
			<div class=\"content\" style=\"width: 850px;\">
<!-- DESCRIPTION -->
				{$news['description']}
<!-- END DESCRIPTION -->
				<br /><br />
<!-- ARTICLE -->
				{$news['content']}
<!-- FIN ARTICLE -->
				<div class=\"clear\"></div><br />
				<br />
				<div class=\"comments\">
					<h1 class=\"dark thin\">{$lang['comments']}</h1>
					<br />
					<div id=\"disqus_thread\"></div>
					<script type=\"text/javascript\">
						/* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
						var disqus_developer = 0; // developer mode
						var disqus_shortname = 'olympe'; // required: replace example with your forum shortname
						var disqus_identifier = 'Blog - {$news['id']}';
						var disqus_url = 'https://www.olympe.in/blog/post?id={$news['id']}';
						/* * * DON'T EDIT BELOW THIS LINE * * */
						(function() {
							var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
							dsq.src = 'https://' + disqus_shortname + '.disqus.com/embed.js';
							(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
						})();
					</script>
				</div>
				<br /><br />
			</div>
			<script type=\"text/javascript\">
				window.___gcfg = {lang: 'fr'};
		
				(function() {
					var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
					po.src = 'https://apis.google.com/js/plusone.js';
					var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
				})();
				
				!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
			</script>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>