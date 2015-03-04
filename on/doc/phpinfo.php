<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

phpinfo();

echo "Test Memcache<br/>\n";

$memcache = new Memcache;
$memcache->connect('memcache', 11211);
$version = $memcache->getVersion();

echo "Adresse du serveur : memcache <br/>\n";
echo "Version du serveur : ".$version."<br/>\n";

?>