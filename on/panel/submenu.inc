<?php

if( isset($GLOBALS['lang']) && is_object($GLOBALS['lang']) )
	$GLOBALS['lang']->import(__DIR__ . '/submenu.lang');

// initialize the menu
$menu = array(
	array('text'=>"phome", 'default'=>true, 'link'=>"/panel"),
	array('text'=>"pdomains", 'link'=>"/panel/domains"),
	array('text'=>"pdatabases", 'link'=>"/panel/databases"),
	array('text'=>"pmails", 'link'=>"/panel/users"),
	array('text'=>"pservices", 'link'=>"/panel/services"),
	array('text'=>"pquotas", 'link'=>"/panel/quotas"),
	array('text'=>"pbackups", 'link'=>"/panel/backups"),
	array('text'=>"pmessages", 'link'=>"/panel/messages"),
	array('text'=>"psettings", 'link'=>"/panel/settings")
);

return $menu;

?>
