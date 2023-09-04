<?
	/* CMS Studio 3.0 index.php */
	
	$_ADMINPAGES = true;
	include_once("../../../config.php");
		
	global $smarty;
	global $auth;
	
	
	
	$smarty->display('index.tpl');
	

	
?>