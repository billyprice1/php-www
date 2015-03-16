<?php

if( isset($GLOBALS['lang']) && is_object($GLOBALS['lang']) )
	$GLOBALS['lang']->import(__DIR__ . '/submenu.lang');

// initialize the menu
$menu = array(
	array('text'=>"menu_hosting", 'default'=>true, 'link'=>"/service/hosting"),
	array('text'=>"menu_offer", 'link'=>"/service/offer"),
	array('text'=>"menu_infrastructure", 'link'=>"/service/infrastructure"),
	array('text'=>"menu_tos", 'link'=>"/on/documents/Olympe-CGS-".translator::getLanguage().".pdf"),
);

return $menu;

?>
