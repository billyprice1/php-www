<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

if( preg_match("/^[0-9]{2,30}$/", $_POST['id']) != 1 )
	raise( new SecurityException(iSeverity::CRITICAL, $lang['ABNORMAL_PARAMETER_VALUE']) );

$form = new form('edit_domain');
$form->checkReferer();
$form->reset();
$form->importValues($_POST);

$form->setCheck('dir', $lang['check_dir'], formCheck::ALLTEXT, 2, 30, true);
if( preg_match("/(^\\/?\\.\\.|\\/\\.\\.\\/?$|\\/\\.\\.\\/|\\\\|\\s)/", $_POST['dir']) > 0 )
	$form->setError('dir', $lang['check_dir']);

$form->validate();

$home = '/dns/com/olympe-network/'.security::get('user').'/'.$form->getValue('dir');
$sql = "UPDATE domain SET homeDirectory = '".security::encode($home, false)."' WHERE uid = '{$_POST['id']}'";
$userapi->query($sql, iDatabase::NO_ROW);

// LOG ACTION IN HISTORY
$sql = "SELECT Hostname FROM domain WHERE uid = '{$_POST['id']}'";
$domain = $userapi->query($sql);
$data = array('domain'=>$domain['Hostname'], 'dir'=>$form->getValue('dir'));
$logger = new logger();
$logger->log($data);

$form->cleanup();

$template->redirect('/panel/domains/edit?done&id='.$_POST['id']);

?>
