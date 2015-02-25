<?php
if( !defined('PROPER_START') ) 
{ 
    header("HTTP/1.0 403 Forbidden"); 
    exit; 
} 
$cache = __DIR__.'/cache/stats.txt';
$expire = time() -3600 ; //cache une heure à voir si je l'active entièrement de 17h30 à 22h et de 6h à 10h (les périodes de rush)
$file = fopen($cache, 'a+');
$txt = fgets($file);
$txt = explode('-', $txt);
if($txt['0'] > $expire)
{
	$users['count'] = $txt['1'];
	$sites['count'] = $txt['2'];
	$dbs['count'] = $txt['3'];
	$domains['count'] = $txt['4'];
}
else{
	$users = api::send('user/list', array('count'=>1), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
	$sites = api::send('site/list', array('count'=>1), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
	$dbs = api::send('database/list', array('count'=>1), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
	$domains = api::send('domain/list', array('count'=>1), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
	$txt = time().'-'.$users['count'].'-'.$sites['count'].'-'.$dbs['count'].'-'.$domains['count'];
	ftruncate($file, 0);
	fseek($file, 0);
	fputs($file, $txt);
}
	fclose($file);
switch( translator::getLanguage() )
{
	case 'FR':
		$users['count'] = number_format($users['count'], 0, ',', ' ');
		$sites['count'] = number_format($sites['count'], 0, ',', ' ');
		$dbs['count'] = number_format($dbs['count'], 0, ',', ' ');
		$domains['count'] = number_format($domains['count'], 0, ',', ' ');
	break;
	default:
		$users['count'] = number_format($users['count']);
		$sites['count'] = number_format($sites['count']);
		$dbs['count'] = number_format($dbs['count']);
		$domains['count'] = number_format($domains['count']);
}

$content = "		
			<span style=\"display: block; font-size: 70px; margin: 0 auto;\">{$users['count']}</span>
			<span style=\"display: block; font-size: 30px; color: #7bbb51; margin-top: 5px;\">{$lang['users']}</span>
			<span style=\"display: block; font-size: 18px; margin-top: 20px;\">
				<span style=\"color: #910000\">{$sites['count']}</span> {$lang['sites']}, 
				<span style=\"color: #910000\">{$dbs['count']}</span> {$lang['databases']} 
				<span style=\"color: #910000\">{$domains['count']}</span> {$lang['domains']}
			</span>
";

echo $content;

?>