<?php
if( !defined('PROPER_START') ) 
{ 
    header("HTTP/1.0 403 Forbidden"); 
    exit; 
} 

if($_SERVER["HTTP_HOST"] == 'localhost' || $_SERVER["HTTP_HOST"] == '127.0.0.1' || $_SERVER["HTTP_HOST"] == 'local.olympe.in'){
	$users = api::send('user/list', array('count'=>1), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
	$sites = api::send('site/list', array('count'=>1), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
	$dbs = api::send('database/list', array('count'=>1), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
	$domains = api::send('domain/list', array('count'=>1), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
}
else
{
	try
	{
		$m = new Memcache;
		if( !$m->connect('tralala', 11211) )
			throw new Exception("Memcache failed to connect");
		if( ($value = $m->get("stats")) === false || !is_array($value) )
			throw new Exception("Memcache could not retrieve value");
		$m->close();
		
		$users = array('count' => $value['users']);
		$sites = array('count' => $value['sites']);
		$dbs = array('count' => $value['dbs']);
		$domains = array('count' => $value['domains']);
	}
	catch( Exception $e )
	{
		// if value was not in memcache or if memcache failed to connect then get the API values (slow)
		$users = api::send('user/list', array('count'=>1), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
		$sites = api::send('site/list', array('count'=>1), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
		$dbs = api::send('database/list', array('count'=>1), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
		$domains = api::send('domain/list', array('count'=>1), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
		
		// try to store the values back in memcache
		try
		{
			$m = new Memcache;
			if( !$m->connect('tralala', 11211) )
				throw new Exception("Memcache failed to connect");
			$stats = array('users'=>$users['count'], 'sites'=>$sites['count'], 'dbs'=>$dbs['count'], 'domains'=>$domains['count']);
			if( !$m->set("stats", $stats, false, 86400) )
				throw new Exception("Memcache could not store value");
			$m->close();
		}
		catch(Exception $e2)
		{
			// memcache failed to store value... well, ignore and continue
		}
	}
}

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