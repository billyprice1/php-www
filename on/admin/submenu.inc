<?php

if( isset($GLOBALS['lang']) && is_object($GLOBALS['lang']) )
	$GLOBALS['lang']->import(__DIR__ . '/submenu.lang');

// initialize the menu
$menu = array(
	array('text'=>"menu_home", 'icon'=>"iDownload", 'link'=>"/admin"),
	array('text'=>"menu_messages", 'icon'=>"iUsers", 'link'=>"/admin/messages"),
	array('text'=>"menu_groups", 'icon'=>"iUsers", 'link'=>"/admin/groups"),
	array('text'=>"menu_grants", 'icon'=>"iKey", 'link'=>"/admin/grants"),
	array('text'=>"menu_quotas", 'icon'=>"iChart8", 'link'=>"/admin/quotas"),
	array('text'=>"menu_stats", 'icon'=>"iChart8", 'link'=>"/admin/stats"),
	array('text'=>"menu_blog", 'icon'=>"iChart8", 'link'=>"/admin/blog"),
	array('text'=>"menu_logs", 'icon'=>"iChart8", 'link'=>"/admin/logs")
);

return $menu;

?>
