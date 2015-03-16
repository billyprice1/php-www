<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

if( preg_match("/^[0-9]{2,30}$/", $_POST['id']) != 1 )
	raise( new SecurityException(iSeverity::CRITICAL, $lang['ABNORMAL_PARAMETER_VALUE']) );

$url = '/domains/fake.com';
$data = array('uidNumber' => $_POST['id']);
$domain = $api->query($url, 'GET', $data);

$form = new form('add_subdomain');
$form->checkReferer();
$form->reset();
$form->importValues($_POST);

$form->setCheck('subdomain', $lang['check_subdomain'], formCheck::LOWERCASE.formCheck::NUMERIC.'_-', 2, 50, false);

$form->validate();

$url = '/' . $domain['associatedDomain'] . '/subdomains';
$data = array('subdomain' => $form->getValue('subdomain'), 'gidNumber' => security::get('user_id'));
$subdomain = $api->query($url, 'POST', $data);

// LOG ACTION IN HISTORY
$data = array('domain' => $domain['associatedDomain'], 'subdomain' => $form->getValue('subdomain'));
$logger = new logger();
$logger->log($data);

$form->cleanup();

$template->redirect('/panel/domains/config?id=' . $_POST['id']);

?>
