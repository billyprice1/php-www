<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$params = array('site'=>$_POST['id']);

// Update directory infos
if( $_POST['action'] == 'changedirectory' ) {

	if( $_POST['title'] )
		$params['title'] = str_replace("'", "&#39;", htmlspecialchars($_POST['title']));
	if( $_POST['description'] )
		$params['description'] = str_replace("'", "&#39;", htmlspecialchars($_POST['description']));
	if( $_POST['category'] )
		$params['category'] = $_POST['category'];
		
}

// Update displaying infos
if( $_POST['action'] == 'displaydirectory' ) {

	if( $_POST['display'] == 0 ) {
		$params['directory'] = $_POST['status'];
	
	} elseif( $_POST['display'] == 1 ) { 
		$params['directory'] = 0;
	
	} elseif( $_POST['display'] == 2 ) { 
		$params['directory'] = 4;
	}
}

// Remove the special status
if( $_POST['action'] == 'delete_highlight') {
	$params['directory'] = 1;
}


api::send('self/site/update', $params);

$_SESSION['MESSAGE']['TYPE'] = 'success';
$_SESSION['MESSAGE']['TEXT']= $lang['success'];	

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	$template->redirect('/admin/directory/detail?id=' . security::encode($_POST['id']));

?>
