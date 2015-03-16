<?php

if( isset($GLOBALS['lang']) && is_object($GLOBALS['lang']) )
	$GLOBALS['lang']->import(__DIR__ . '/mainmenu.lang');

// initialize the menu
$menu = array(
	array('text'=>"mhosting", 'anonymous'=>true, 'link'=>"/service/hosting"),
	array('text'=>"mcommunity", 'anonymous'=>true, 'link'=>"https://community.olympe.in"),
	array('text'=>"mactions", 'anonymous'=>true, 'link'=>"/org"),
	array('text'=>"mblog", 'anonymous'=>true, 'link'=>"/blog"),
	array('text'=>"mdoc", 'anonymous'=>true, 'link'=>"/doc"),
	array('text'=>"mlogin", 'anonymous'=>true, 'link'=>"#", 'onclick'=>"$('#login').dialog('open'); return false;"),
	array('text'=>"msignup", 'anonymous'=>true, 'link'=>"#", 'onclick'=>"$('#signup').dialog('open'); return false;"),
	
	array('text'=>"mhosting", 'anonymous'=>false, 'link'=>"/service/hosting"),
	array('text'=>"mcommunity", 'anonymous'=>false, 'link'=>"https://community.olympe.in"),
	array('text'=>"mactions", 'anonymous'=>false, 'link'=>"/org"),
	array('text'=>"mblog", 'anonymous'=>false, 'link'=>"/blog"),
	array('text'=>"mdoc", 'anonymous'=>false, 'link'=>"/doc"),
	array('text'=>"mpanel", 'anonymous'=>false, 'link'=>"/panel"),
	array('text'=>"madmin", 'anonymous'=>false, 'link'=>"/admin"),
	array('text'=>"mlogout", 'anonymous'=>false, 'link'=>"/logout")
);

return $menu;

?>