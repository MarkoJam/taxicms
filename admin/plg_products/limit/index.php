<?
	/* CMS Studio 2.0 index.php */
	$_ADMINPAGES = true;
	include_once("../../../config.php");
	
	global $smarty;
	global $auth;	
	
	$price = $ObjectFactory->createObject("PrPrice",1);

	$smarty->assign("price",$price->Price);
	$smarty->assign("priceid",$price->PriceID);
	if(isset($_REQUEST["message"])) $smarty->assign("message",$_REQUEST["message"]);
	
	$smarty->display('index.tpl');	
	
?>