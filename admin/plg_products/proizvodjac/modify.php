<?
	/* CMS Studio 3.0 modify.php */
	
	$_ADMINPAGES = true;
	include_once("../../../config.php");
		
	global $smarty;
	global $auth;
	
	$ObjectFactory = ObjectFactory::getInstance();
			
	if($auth->isActionAllowed("ACTION_PRODUCTMODIFY"))
	{
		if(isset($_REQUEST["mode"])) $_REQUEST["proizvodjacid"]=-1;	
		if(isset($_REQUEST["proizvodjacid"]))
		{
			// deo za insertovanje novog sloga
			if(isset($_REQUEST["mode"])) $smarty->assign("mode", 'insert');
			else $smarty->assign("mode", 'edit');

			$proizvodjac = $ObjectFactory->createObject("PrProizvodjac",$_REQUEST["proizvodjacid"]);
			$smarty->assign($proizvodjac->toArray());
		}
	
		$smarty->display('modify.tpl');
	}
	else
	{
		// show error message not enough rights
		$smarty->assign("norights_message",getTranslation("PLG_NORIGHT"));
		$smarty->display('../../../templates/norights.tpl');
	}

?>