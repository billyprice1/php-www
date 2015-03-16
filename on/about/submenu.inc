<?php

if( isset($GLOBALS['lang']) && is_object($GLOBALS['lang']) )
	$GLOBALS['lang']->import(__DIR__ . '/submenu.lang');

// initialize the menu
$menu = array(
	array('text'=>"menu_overview", 'default'=>true, 'link'=>"/about"),
	array('text'=>"menu_contact", 'link'=>"/about/contact"),
	array('text'=>"menu_partners", 'link'=>"/about/partners"),
	array('text'=>"menu_team", 'link'=>"/about/team")
);

return $menu;

?>
