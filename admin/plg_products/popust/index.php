<?
	/* CMS Studio 2.0 index.php */
	$_ADMINPAGES = true;
	include_once("../../../config.php");
	
	global $smarty;
	global $auth;	
	
	$popust = $ObjectFactory->createObject("PrPopust",1);

	$smarty->assign("popust",$popust->Popust);
	$smarty->assign("popustid",$popust->PopustID);
	if(isset($_REQUEST["message"])) $smarty->assign("message",$_REQUEST["message"]);
	
	$smarty->display('index.tpl');	
	
?>
