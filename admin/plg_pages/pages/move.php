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
	if($auth->isActionAllowed("ACTION_PAGE_MOVE"))
	{
		for ($i = 0; $i <$cnt_array; $i++) 
		{
			$page = $ObjectFactory->createObject("Page",$id_array[$i]);
			$page->setOrder($i+1);
			$DBBR->promeniSlog($page);			
		}	
	}
	else
	{
		// show error message not enough rights
		$smarty->assign("norights_message",getTranslation("PLG_NORIGHT"));
		$smarty->display('../../../templates/norights.tpl');
	}	
?>