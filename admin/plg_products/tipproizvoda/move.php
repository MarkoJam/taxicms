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
	if($auth->isActionAllowed("ACTION_PRODUCTTYPE_MOVE"))
	{
		for ($i = 0; $i <$cnt_array; $i++) 
		{
			$tip = $ObjectFactory->createObject("PrTipProizvoda",$id_array[$i]);
			$tip->setOrder($i+1);
			$DBBR->promeniSlog($tip);			
		}	
		
	}
	else
	{
		// show error message not enough rights
		$smarty->assign("norights_message",getTranslation("PLG_NORIGHT"));
		$smarty->display('../../../templates/norights.tpl');
	}	
?>