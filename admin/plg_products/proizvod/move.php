<?
	/* CMS Studio 3.0 move.php */
	
	$_ADMINPAGES = true;
	include_once("../../../config.php");
	
	global $smarty;
	global $auth;
	
	$ObjectFactory = ObjectFactory::getInstance();
	$LanguageHelper = LanguageHelper::getInstance();
	
	
	$id_array=$_REQUEST["sectionsid"];
	$cnt_array=count($id_array);
	if($auth->isActionAllowed("ACTION_PRODUCT_MOVE"))
	{
		for ($i = 0; $i <$cnt_array; $i++) 
		{
			$proiz = $ObjectFactory->createObject("PrProizvod",$id_array[$i]);
			$proiz->setOrder($i+1);
			$DBBR->promeniSlog($proiz);			
		}	
		
	}
	else
	{
		// show error message not enough rights
		$smarty->assign("norights_message",getTranslation("PLG_NORIGHT"));
		$smarty->display('../../../templates/norights.tpl');
	}	
?>