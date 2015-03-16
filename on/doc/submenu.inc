<?php

if( isset($GLOBALS['lang']) && is_object($GLOBALS['lang']) )
	$GLOBALS['lang']->import(__DIR__ . '/submenu.lang');

// initialize the menu
$menu = array(
	array('text'=>"menu_intro", 'default'=>true, 'link'=>"/doc"),
	array('text'=>"menu_first", 'link'=>"/doc/first"),
	array('text'=>"menu_infos", 'link'=>"/doc/info"),
	array('text'=>"menu_faq", 'link'=>"/doc/faq"),
);

return $menu;

?>
