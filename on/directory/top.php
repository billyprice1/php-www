<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$sites = api::send('site/list', array('directory'=>1, 'ordered'=>'site_score', 'start'=>0, 'limit'=>24), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);

$content = "
		<div class=\"directory\">
			<div class=\"container\">
				<h1 class=\"dark\">{$lang['top']}</h1>
				<br />
";

foreach( $sites as $s )
{
	$content .= "
				<a href=\"/directory/site?id={$s['id']}\">
					<div class=\"site\" >
						<div class=\"thumbshot\">
							<img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/sites/?url={$s['url']}\" />
						</div>
						<div class=\"text\">
							<span class=\"name\">{$s['title']}</span>
							<span class=\"editor\">{$s['user']}</span>
							<br />
							<div class=\"star\" data-score=\"{$s['rating']['rating']}\" data-id=\"{$s['id']}\"></div>
						</div>
					</div>
				</a>
	";
}

$content .= "
				<div class=\"clear\"></div>
			</div>
		</div>
		<script>
			$('.star').raty(
			{
				numberMax: 5,
				number: 500,
				readOnly: true,
				path: '/on/images/icons',
				score: function() {
					return $(this).attr('data-score');
				},
				click: function() {
					rate($(this).attr('data-id'), $('.star').raty('score'));
				}
			});
		</script>";

/* ========================== OUTPUT PAGE ========================== */
echo $content;

?>