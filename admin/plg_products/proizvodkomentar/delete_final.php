<?
	/* CMS Studio 3.0 delete_final.php */
	
	$_ADMINPAGES = true;
	include_once("../../../config.php");
	
	global $smarty;
	global $auth;
	
	$ObjectFactory = ObjectFactory::getInstance();
	
	if($auth->isActionAllowed("ACTION_PRODUCTCOMMENT_DELETE"))
	{
		if(isset($_REQUEST["proizvodkomentarid"]))
		{
			$proizvodKomentar = $ObjectFactory->createObject("PrProizvodKomentar",$_REQUEST["proizvodkomentarid"]);
			
			$DBBR->obrisiSlog($proizvodKomentar);
					
			header('Location: index.php?statusmessage=delete_success');
			exit();
		}
		else
		{
			header('Location: index.php?statusmessage=failed');
		}
	}
	else
	{
		// show error message not enough rights
		$smarty->assign("norights_message",getTranslation("PLG_PRODUCT_COMMENT_NORIGHT_DELETE"));
		$smarty->display('../../../templates/norights.tpl');
	}
		
?>