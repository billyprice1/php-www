<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

require_once('on/doc/menu.php');

if( isset($_GET['keyword']) )
{
	$search = new search(__DIR__);
	$results = $search->find(security::encode($_GET['keyword']));
}

$content = "
		<div class=\"head-light\">
			<div class=\"container\">
				<h1 class=\"dark\" style=\"float: left;\">{$lang['title']}</h1>
				<form id=\"searchform\" action=\"/doc/search\" method=\"get\"><input type=\"submit\" style=\"display: none;\" /><input name=\"keyword\"  class=\"auto\" style=\"width: 380px; font-size: 15px; float: right;\" type=\"text\" id=\"search\" value=\"{$GLOBALS['lang']['search']}\" onfocus=\"this.value = this.value=='{$GLOBALS['lang']['search']}' ? '' : this.value; this.style.color='#4c4c4c';\" onfocusout=\"this.value = this.value == '' ? this.value = '{$GLOBALS['lang']['search']}' : this.value; this.value=='{$GLOBALS['lang']['search']}' ? this.style.color='#cccccc' : this.style.color='#4c4c4c'\" /></form>
				<div class=\"clear\"></div>
			</div>
		</div>	
		<div class=\"content\">		
			<div class=\"left small\">
				<div class=\"sidemenu\">
					{$menu}
				</div>					
			</div>
			<div class=\"right big\">	
				<h3>{$lang['result']} \"".security::encode($_GET['keyword'], true, true)."\"</h3>
				<br />
				
";

if( count($results) > 0 )
{
	$content .= "<ul class=\"search\">";
	
	foreach( $results as $key => $value )
	{
		$content .= "
					<li>
						<h2 class=\"dark\" style=\"margin-bottom: 5px;\">{$value['title']}</h2>
						<a href=\"/doc/{$key}\">https://www.olympe.in/doc/{$key}</a><br />
						<p>{$value['content']}</p>
					</li>
		";
	}
	$content .= "</ul>";
}
else
	$content .= "<span style=\"font-size: 16px;\">{$lang['noresult']}</span>";

$content .= "
			</div>
			<div class=\"clear\"></div><br /><br />
		</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>
