<? 
	/* CMS Studio 3.0 modify.php */
	
	$_ADMINPAGES = true;
	include_once("../../../config.php");

	global $smarty;
	global $auth;
	
	if($auth->isActionAllowed("ACTION_LEXICON_MODIFY"))
	{
		if(isset($_REQUEST["mode"])) $_REQUEST["lexiconid"]=-1;		
		if(isset($_REQUEST["lexiconid"]))
		{
			// deo za insertovanje novog sloga
			if(isset($_REQUEST["mode"])) $smarty->assign("mode", 'insert');
			else $smarty->assign("mode", 'edit');
			$lexiconPlugin = $ObjectFactory->createObject("Lexicon",$_REQUEST["lexiconid"]);
			$smarty->assign($lexiconPlugin->toArray());
			
			$html = $lexiconPlugin->Html;
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