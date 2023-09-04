<?
	/* CMS Studio 3.0 modify.php */
	
	$_ADMINPAGES = true;
	include_once("../../../config.php");
		
	global $smarty;
	global $auth;
	
	$ObjectFactory = ObjectFactory::getInstance();
			
	if($auth->isActionAllowed("ACTION_PRODUCTCOMMENT_MODIFY"))
	{
	
		if(isset($_REQUEST["proizvodkomentarid"]))
		{
			$proizvodKomentar = $ObjectFactory->createObject("PrProizvodKomentar",$_REQUEST["proizvodkomentarid"], array("PrProizvod"));
			$smarty->assign($proizvodKomentar->toArray());
		}
	
		$smarty->display('modify.tpl');
	}
	else
	{
		// show error message not enough rights
		$smarty->assign("norights_message",getTranslation("PLG_PRODUCT_COMMENT_NORIGHT_MODIFY"));
		$smarty->display('../../../templates/norights.tpl');
	}

?>