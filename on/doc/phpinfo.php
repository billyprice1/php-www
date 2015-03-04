<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

phpinfo();

echo "Test Memcache";

$memcache = new Memcache;
$memcache->connect('localhost', 11211) or die ("Connexion impossible");
$version = $memcache->getVersion();
echo "Version du serveur : ".$version."<br/>\n";

?>