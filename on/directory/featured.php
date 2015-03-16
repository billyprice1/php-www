<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$featured = api::send('site/list', array('directory'=>1, 'directory_status'=>2, 'start'=>0, 'limit'=>12), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
$selection = api::send('site/list', array('directory'=>1, 'directory_status'=>3, 'start'=>0, 'limit'=>12), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);

$content = "
		<div class=\"directory\">
			<div class=\"container\">
				<h1 class=\"dark\">{$lang['featured']}</h1>
				<br />
";

foreach( $featured as $f )
{
	$content .= "
				<a href=\"/directory/site?id={$f['id']}\">
					<div class=\"site\" >
						<div class=\"thumbshot\">
							<img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/sites/?url={$f['url']}\" />
						</div>
						<div class=\"text\">
							<span class=\"name\">{$f['title']}</span>
							<span class=\"editor\">{$f['user']}</span>
							<br />
							<div class=\"star\" data-score=\"{$f['rating']['rating']}\" data-id=\"{$f['id']}\"></div>
						</div>
					</div>
				</a>
	";
}

$content .= "
				<div class=\"clear\"></div>
				<br />
				<h1 class=\"dark\">{$lang['top']}</h1>
				<br />
";

foreach( $selection as $s )
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