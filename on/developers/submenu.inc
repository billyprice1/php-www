<?php

if( isset($GLOBALS['lang']) && is_object($GLOBALS['lang']) )
	$GLOBALS['lang']->import(__DIR__ . '/submenu.lang');

// initialize the menu
$menu = array(
	array('text'=>"menu_home", 'default'=>true, 'link'=>"/developers"),
	array('text'=>"menu_api", 'link'=>"/developers/api"),
	array('text'=>"menu_tools", 'link'=>"/developers/tools"),
	array('text'=>"menu_sources", 'link'=>"https://github.com/OlympeNetwork")
);

return $menu;

?>
