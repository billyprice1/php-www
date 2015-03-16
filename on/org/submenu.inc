<?php

if( isset($GLOBALS['lang']) && is_object($GLOBALS['lang']) )
	$GLOBALS['lang']->import(__DIR__ . '/submenu.lang');

// initialize the menu
$menu = array(
	array('text'=>"menu_actions", 'default'=>true, 'link'=>"/org"),
	array('text'=>"menu_last", 'link'=>"/blog"),
	array('text'=>"menu_press", 'link'=>"/org/press"),
	array('text'=>"menu_help", 'link'=>"/org/help"),
);

return $menu;

?>