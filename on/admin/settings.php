<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}


$content = "
		<div class=\"panel\">
			<div class=\"top\">
				<div class=\"left\" style=\"padding-top: 5px;\">
					<h1 class=\"dark\">{$lang['title']}</h1>
				</div>
				<div class=\"right\">
				</div>
			</div>
			<div class=\"clear\"></div><br />
			<div class=\"container center\">
				<div class=\"case\">
					<a href=\"/admin/settings/groups\">
						<span><i class=\"fa fa-group\"></i></span>
						{$lang['groups']}
					</a>
				</div>
				<div class=\"case\">
					<a href=\"/admin/settings/grants\">
						<span><i class=\"fa fa-key\"></i></span>
						{$lang['grants']}
					</a>
				</div>
				<div class=\"case\">
					<a href=\"/admin/settings/quotas\">
						<span><i class=\"fa fa-pie-chart\"></i></span>
						{$lang['quotas']}
					</a>
				</div>
			</div>
		</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>