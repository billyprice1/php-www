<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$news = api::send('news/list', array('limit'=>20), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);

$content = "
			<div class=\"head-light\">
				<div class=\"container\" style=\"text-align: center;\">
					<h1 class=\"dark\" style=\"text-align: center;\">{$lang['title']}</h1>
					<br />
					<a class=\"button classic\" href=\"/blog/rss\" style=\"width: 120px; height: 23px; padding: 8px 5px 3px 8px;  margin: 0; display: inline-block; font-size: 12px;\">
						<img style=\"float: left;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/rss.png\" />
						<span style=\"display: block; padding-top: 3px;\">{$lang['rss']}</span>
					</a>
					<a class=\"button classic\" href=\"http://twitter.com/OlympeNet\" style=\"width: 120px; height: 23px; padding: 8px 5px 3px 8px; margin: 0 0 0 10px; display: inline-block; font-size: 12px;\">
						<img style=\"float: left;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/twitter.png\" />
						<span style=\"display: block; padding-top: 3px;\">{$lang['follow']}</span>
					</a>
				</div>
			</div>	
			<div class=\"content\">
";

foreach( $news as $n )
{
	$month = date('F', $n['date']);
	$month_translate = $lang[$month];
	
	$content .= "
				<div class=\"article\">
					<a href=\"/blog/post?id={$n['id']}\"><h1 class=\"dark\" style=\"text-align: center;\">{$n['title']}</h1></a>
					<div style=\"width: 310px; margin: 0 auto;\">
						<span style=\"color: #797979; font-size: 14px; display: block; float: left; padding-top: 7px;\">".str_replace($month, $month_translate, date($lang['DATEFORMAT'], $n['date']))." {$lang['by']}</span>
						<img style=\"display: block; float: left; margin-left: 10px;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/team/{$n['author']}.png\" class=\"author\" />
						<a style=\"display: block; float: left; padding-top: 8px; margin-left: 10px;\" href=\"/about/team#".$lang['author_' . $n['author']]."\">".$lang['author_' . $n['author']]."</a>
						<div class=\"clear\"></div>
					</div>
					<br />
					<div style=\"width: 800px; margin: 0 auto; font-size: 16px;\">
						{$n['description']}
						<br />
						<a class=\"button classic\" style=\"float: right\" href=\"/blog/post?id={$n['id']}\">{$lang['read']}</a>
					</div>
					<div class=\"clear\"></div>
				</div>
				<br />
				<div class=\"separator\"></div>
	";
}

$content .= "
			</div>
			<br />
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>