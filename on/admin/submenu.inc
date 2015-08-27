<?php

if( isset($GLOBALS['lang']) && is_object($GLOBALS['lang']) )
	$GLOBALS['lang']->import(__DIR__ . '/submenu.lang');

// initialize the menu
$menu = array(
	array('text'=>"menu_home", 'icon'=>"iDownload", 'link'=>"/admin"),
	array('text'=>"menu_messages", 'icon'=>"iUsers", 'link'=>"/admin/messages"),
	array('text'=>"menu_registrations", 'icon'=>"iChart8", 'link'=>"/admin/registrations"),
	array('text'=>"menu_stats", 'icon'=>"iChart8", 'link'=>"/admin/stats"),
	array('text'=>"menu_blog", 'icon'=>"iChart8", 'link'=>"/admin/blog"),
	array('text'=>"menu_directory", 'icon'=>"iChart8", 'link'=>"/admin/directory"),
	array('text'=>"menu_settings", 'icon'=>"iUsers", 'link'=>"/admin/settings"),
	array('text'=>"menu_logs", 'icon'=>"iChart8", 'link'=>"/admin/logs")
);

return $menu;

?>
