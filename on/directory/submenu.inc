<?php

if( isset($GLOBALS['lang']) && is_object($GLOBALS['lang']) )
	$GLOBALS['lang']->import(__DIR__ . '/submenu.lang');


$sub = array();
for( $i = 1; $i <= 20; $i++ )
{
	$sites = api::send('site/list', array('directory'=>1, 'category'=>$i, 'count'=>1), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
	$sub[] = array('text'=> $GLOBALS['lang']['CAT_' . $i] . " (<span style='color: #ff8827;'>{$sites['count']}</span>)", 'link'=>"#", 'onclick'=>"loadDirectoryPart('category', {$i}); return false;");
}

// initialize the menu
$menu = array(
	array('text'=>"shome", 'default'=>true, 'link'=>"#", 'onclick'=>"loadDirectoryPart('featured', null); return false;"),
	array('text'=>"stop", 'link'=>"#", 'onclick'=>"loadDirectoryPart('top', null); return false;"),
	array('text'=>"snew", 'link'=>"#", 'onclick'=>"loadDirectoryPart('last', null); return false;"),
	array('text'=>"scategory", 'link'=>"#", 'sub'=>$sub)
);

return $menu;

?>
