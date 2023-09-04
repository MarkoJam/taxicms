<?
	/* CMS Studio 3.0 index.php */	
	
	$_ADMINPAGES = true;
	include_once("../../../../config.php");
		
	global $smarty;
	global $auth;

	if(isset($_REQUEST["adminuserid"]))
	{	
		$smarty->assign("adminuserid", $_REQUEST["adminuserid"]);
	}
	
	$smarty->display("changepass.tpl");
?>