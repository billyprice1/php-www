<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

api::send('news/del', array('id'=>$_GET['id']));

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	template::redirect('/admin/blog');

?>
