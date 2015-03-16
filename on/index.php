<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

template::redirect($GLOBALS['CONFIG']['DEFAULT_PAGE']);

?>