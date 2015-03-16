<?php

if( !defined('PROPER_START') )
{
        header("HTTP/1.0 403 Forbidden");
        exit;
}

api::send('user/qcompute', array('user'=>$_GET['id'], 'force'=>1));

if( isset($_GET['redirect']) )
        template::redirect($_GET['redirect']);
else
        $template->redirect('/admin/overquota#quotas');

?>