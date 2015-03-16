<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$lang['TITLE'] = $lang['title'];

$content .= "
		<div id=\"directorycontainer\">
		</div>
		<script>
			loadDirectoryPart('featured', null);
		</script>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>