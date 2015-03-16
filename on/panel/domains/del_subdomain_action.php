<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$domain = api::send('self/domain/list', array('domain'=>$_GET['domain']));
$domain = $domain[0];

api::send('self/subdomain/del', array('id'=>$_POST['subdomain'], 'domain'=>$_GET['domain']));

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	template::redirect('/panel/domains/config?id='.$domain['id']);

?>
