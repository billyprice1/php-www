<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

require_once('on/doc/menu.php');

$content = "
		<div class=\"head-light\">
			<div class=\"container\">
				<h1 class=\"dark\" style=\"float: left;\">{$lang['title']}</h1>
				<form id=\"searchform\" action=\"/doc/search\" method=\"get\"><input type=\"submit\" style=\"display: none;\" /><input name=\"keyword\" class=\"auto\" style=\"width: 380px; font-size: 15px; float: right;\" type=\"text\" id=\"search\" value=\"{$GLOBALS['lang']['search']}\" onfocus=\"this.value = this.value=='{$GLOBALS['lang']['search']}' ? '' : this.value; this.style.color='#4c4c4c';\" onfocusout=\"this.value = this.value == '' ? this.value = '{$GLOBALS['lang']['search']}' : this.value; this.value=='{$GLOBALS['lang']['search']}' ? this.style.color='#cccccc' : this.style.color='#4c4c4c'\" /></form>
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
				<h3>{$lang['registration_step']}</h3>
				<p>{$lang['registration_step_text']}</p>
				<br />
				<h3>{$lang['registration_first']}</h3>
				<img class=\"doc\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/doc/34.png\" alt=\"34\" />
				<p>{$lang['registration_first_text']}</p>
				<p>{$lang['registration_first_text2']}</p>
				<blockquote class=\"toggleDoc\" data-doc=\"1\" style=\"display:none;\">
					<ul class=\"classic\">
						{$lang['registration_error_list1']}
					</ul>
				</blockquote>
				<br />
				<h3>{$lang['registration_second']}</h3>
				<p>{$lang['registration_second_text']}</p>
				<img class=\"doc mini right\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/doc/35.png\" alt=\"35\" />
				<p style=\"text-align: justify; line-height: 27px;\">{$lang['registration_second_text2']}</p>
				<p style=\"clear:both;\">{$lang['registration_second_text3']}</p>
				<blockquote class=\"toggleDoc\" data-doc=\"2\" style=\"display:none;\">
					<ul class=\"classic\">
						{$lang['registration_error_list2']}
					</ul>
				</blockquote>
				<p>{$lang['registration_second_text4']}</p>
				<br />
				<h3>{$lang['registration_error']}</h3>
				<p>{$lang['registration_error_text']}</p>
			</div>
			<div class=\"clear\"></div><br /><br />
		</div>
		<script>
			$(function() {
				$(\"a.toggleDoc\").click(function() {
					var doc = $(this).attr('data-doc');
				  $(\"blockquote.toggleDoc[data-doc='\"+ doc +\"']\").slideToggle();
				  return false;
				});
			});
		</script>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>