<?
	/* CMS Studio 3.0 modfify_ncateg.php */

	$_ADMINPAGES = true;
	include_once("../../../config.php");
		
	global $smarty;
	global $auth;
	
	if($auth->isActionAllowed("ACTION_MODULE_CATEGORY_MODIFY"))
	{
		if(isset($_REQUEST["mode"])) $_REQUEST["modulecategoryid"]=-1;
		if(isset($_REQUEST["modulecategoryid"]))
		{
			//punjenje i/ili postavljanje kategorijeid iz/u sesije
			$_SESSION["modulecategoryid"] = $_REQUEST["modulecategoryid"];
			
			$nc = $ObjectFactory->createObject("ModuleCategory",$_REQUEST["modulecategoryid"]);
			// deo za insertovanje novog sloga
			if(isset($_REQUEST["mode"])) $smarty->assign("mode", 'insert');
			else $smarty->assign("mode", 'edit');	
			
			$nazivKategorije = $nc->Title;
			// statusi
			$ObjectFactory->AddFilter(" tip_status_id = " . STATUS_TIP_CATEGORY);
			$statusi = $ObjectFactory->createObjects("SfStatus");
			
			$shStatus = new SmartyHtmlSelection("status",$smarty);
			foreach ($statusi as $s) 
			{
				$shStatus->AddOutput($s->getVrednost());
				$shStatus->AddValue($s->getStatusID());
			}
			$shStatus->AddSelected($nc->getStatus());
			$shStatus->SmartyAssign();
			$ObjectFactory->ResetFilters();
			
			
			$brojVestiKategorije = $nc->MessageNum;
			
			$smarty->assign("modulecategoryid",$nc->ModuleCategoryID);
			$smarty->assign("nazivkategorije",$nazivKategorije);
			$smarty->assign("brojVestiKategorije",$brojVestiKategorije);
			
			$smarty->display('modify.tpl');
		}
	}
	else 
	{
		// show error message not enough rights
		$smarty->assign("norights_message",$LanguageArray["value"]["PLG_NORIGHT"]);
		$smarty->display('../../../templates/norights.tpl');
	}
?>