<? 
	/* CMS Studio 3.0 modify.php */
	
	$_ADMINPAGES = true;
	include_once("../../../config.php");

	global $smarty;
	global $auth;
	
	if($auth->isActionAllowed("ACTION_UNIVERSAL_MODIFY"))
	{
		if(isset($_REQUEST["mode"])) $_REQUEST["universalpluginid"]=-1;		
		if(isset($_REQUEST["universalpluginid"]))
		{
			// deo za insertovanje novog sloga
			if(isset($_REQUEST["mode"])) $smarty->assign("mode", 'insert');
			else $smarty->assign("mode", 'edit');
			$universalPlugin = $ObjectFactory->createObject("UniversalPlugin",$_REQUEST["universalpluginid"]);
			$smarty->assign($universalPlugin->toArray());
			
			$html = $universalPlugin->Html;
			htmldecode($html);
			$smarty->assign("html",$html);
		}
	
		$smarty->display('modify.tpl');
	}
	else
	{
		// show error message not enough rights
		$smarty->assign("norights_message",getTranslation("PLG_NORIGHT"));
		$smarty->display('../../templates/norights.tpl');	
	}
?>