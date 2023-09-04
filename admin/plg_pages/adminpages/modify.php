<?
	/* CMS Studio 3.0 modify_grp.php */

	$_ADMINPAGES = true;	
	include_once("../../../config.php");
		
	global $smarty;
	global $auth;
	
	if($auth->isActionAllowed("ACTION_ADMIN_MODIFY"))
	{
		if(isset($_REQUEST["mode"])) $_REQUEST["apage_id"]=-1;
		if(isset($_REQUEST["apage_id"]))
		{
			//punjenje i/ili postavljanje kategorijeid iz/u sesije
			$_SESSION["apage_id"] = $_REQUEST["apage_id"];			
			$apage = $ObjectFactory->createObject("AdminPage",$_REQUEST["apage_id"]);
			// deo za insertovanje novog sloga
			if(isset($_REQUEST["mode"])) 
			{
				$smarty->assign("mode", 'insert');
			}
			else
			{		
				$smarty->assign("mode", 'edit');
			}
			
			$html = $apage->Html;
					
			// izvrsiti konverziju teksta iz baze u normalan html kod
			htmldecode($html);
			
			$header = $apage->Header;

			$templates = $ObjectFactory->createObjects("Template");
			
			$ShTemplates = new SmartyHtmlSelection("tmpl",$smarty);
			foreach($templates as $tm)
			{
				$ShTemplates->AddValue($tm->TemplateID);
				$ShTemplates->AddOutput($tm->Title);
			}
			$ShTemplates->AddSelected($apage->Template->TemplateID);
			$ShTemplates->SmartyAssign();
			
			$smarty->assign("adminpage_id",$_REQUEST["apage_id"]);
			$smarty->assign("header",$header);
			$smarty->assign("adminpagename",$apage->AdminPageName);
			$smarty->assign("html",$html);
			
			$smarty->display('modify.tpl');
		}
	}
	else 
	{
		// show error message not enough rights
		$smarty->assign("norights_message",getTranslation("PLG_NORIGHT"));
		$smarty->display('../../templates/norights.tpl');
	}
?>