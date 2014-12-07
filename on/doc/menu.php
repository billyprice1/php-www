<?php

if( isset($GLOBALS['lang']) && is_object($GLOBALS['lang']) )
	$GLOBALS['lang']->import(__DIR__ . '/menu.lang');

$menu = "		
						<ul>
							<a href=\"/doc\"><li class=\"".(strpos(rtrim($GLOBALS['CONFIG']['PAGE'], '/'), rtrim('/doc', '/'))===0?"active":"")."\">{$lang['index']}</li></a>
							<li style=\"cursor: auto;\">{$lang['started']}</li>
							<ul>
								<a href=\"/doc/first\"><li class=\"".(strpos(rtrim($GLOBALS['CONFIG']['PAGE'], '/'), rtrim('/doc/first', '/'))===0?"active":"")."\">{$lang['first']}</li></a>
								<a href=\"/doc/publish\"><li class=\"".(strpos(rtrim($GLOBALS['CONFIG']['PAGE'], '/'), rtrim('/doc/publish', '/'))===0?"active":"")."\">{$lang['publish']}</li></a>
								<a href=\"/doc/info\"><li class=\"".(strpos(rtrim($GLOBALS['CONFIG']['PAGE'], '/'), rtrim('/doc/info', '/'))===0?"active":"")."\">{$lang['infos']}</li></a>
								<a href=\"/doc/php\"><li class=\"".(strpos(rtrim($GLOBALS['CONFIG']['PAGE'], '/'), rtrim('/doc/php', '/'))===0?"active":"")."\">{$lang['php']}</li></a>
							</ul>
							<li style=\"cursor: auto;\">{$lang['features']}</li>
							<ul>
								<a href=\"/doc/domains\"><li class=\"".(strpos(rtrim($GLOBALS['CONFIG']['PAGE'], '/'), rtrim('/doc/domains', '/'))===0?"active":"")."\">{$lang['domains']}</li></a>
								<a href=\"/doc/databases\"><li class=\"".(strpos(rtrim($GLOBALS['CONFIG']['PAGE'], '/'), rtrim('/doc/databases', '/'))===0?"active":"")."\">{$lang['databases']}</li></a>
								<a href=\"/doc/mails\"><li class=\"".(strpos(rtrim($GLOBALS['CONFIG']['PAGE'], '/'), rtrim('/doc/mails', '/'))===0?"active":"")."\">{$lang['mails']}</li></a>
								<a href=\"/doc/directory\"><li class=\"".(strpos(rtrim($GLOBALS['CONFIG']['PAGE'], '/'), rtrim('/doc/directory', '/'))===0?"active":"")."\">{$lang['directory']}</li></a>
								<a href=\"/doc/backups\"><li class=\"".(strpos(rtrim($GLOBALS['CONFIG']['PAGE'], '/'), rtrim('/doc/backups', '/'))===0?"active":"")."\">{$lang['backups']}</li></a>
							</ul>
							<li style=\"cursor: auto;\">{$lang['services']}</li>
							<ul>
								<a href=\"/doc/stats\"><li class=\"".(strpos(rtrim($GLOBALS['CONFIG']['PAGE'], '/'), rtrim('/doc/stats', '/'))===0?"active":"")."\">{$lang['stats']}</li></a>
								<a href=\"/doc/quotas\"><li class=\"".(strpos(rtrim($GLOBALS['CONFIG']['PAGE'], '/'), rtrim('/doc/quotas', '/'))===0?"active":"")."\">{$lang['quota']}</li></a>
								<a href=\"/doc/tokens\"><li class=\"".(strpos(rtrim($GLOBALS['CONFIG']['PAGE'], '/'), rtrim('/doc/tokens', '/'))===0?"active":"")."\">{$lang['tokens']}</li></a>
								<a href=\"/doc/cloud\"><li class=\"".(strpos(rtrim($GLOBALS['CONFIG']['PAGE'], '/'), rtrim('/doc/cloud', '/'))===0?"active":"")."\">{$lang['cloud']}</li></a>
							</ul>							
							<li style=\"cursor: auto;\">{$lang['about']}</li>
							<ul>
								<a href=\"/doc/what\"><li class=\"".(strpos(rtrim($GLOBALS['CONFIG']['PAGE'], '/'), rtrim('/doc/what', '/'))===0?"active":"")."\">{$lang['what']}</li></a>
								<a href=\"/doc/techno\"><li class=\"".(strpos(rtrim($GLOBALS['CONFIG']['PAGE'], '/'), rtrim('/doc/techno', '/'))===0?"active":"")."\">{$lang['techno']}</li></a>
								<a href=\"/about/contact\"><li>{$lang['contact']}</li></a>
							</ul>
							<li style=\"cursor: auto;\">{$lang['more']}</li>
							<ul>
								<a href=\"/doc/email\"><li class=\"".(strpos(rtrim($GLOBALS['CONFIG']['PAGE'], '/'), rtrim('/doc/email', '/'))===0?"active":"")."\">{$lang['about_email']}</li></a>
							</u1>
						</ul>
";