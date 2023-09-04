<?
	/* CMS Studio 3.0 modify_grp.php */

	$_ADMINPAGES = true;	
	include_once("../../../config.php");
 
	global $smarty;
	global $auth;
	global $LanguageArray;

	$ObjectFactory = ObjectFactory::getInstance();
	
	if($auth->isActionAllowed("ACTION_PAGE_MODIFY"))
	{
		if(isset($_REQUEST["reload"])) 
		{
			$smarty->assign("reload","true");
			$smarty->assign("page_id_left",$_REQUEST["page_id"]);
		}
		
		if(isset($_REQUEST["page_id"]))
		{
			//punjenje i/ili postavljanje kategorijeid iz/u sesije
			$_SESSION["page_id"] = $_REQUEST["page_id"];
			
			$page = $ObjectFactory->createObject("Page", $_REQUEST["page_id"], array("SfPageType"));
			
			// TEMPLATE
			$templates = $ObjectFactory->createObjects("Template");
			
			$tmpl_values = array();
			$tmpl_output  = array();
			$tmpl_selected = array();
			
			foreach($templates as $tm)
			{
				array_push($tmpl_values,$tm->getTemplateID());
				array_push($tmpl_output,$tm->getTitle());
			}
			
			array_push($tmpl_selected,$page->getTemplate()->getTemplateID());
			
			$smarty->assign("tmpl_values", $tmpl_values);
			$smarty->assign("tmpl_output", $tmpl_output);
			$smarty->assign("tmpl_selected", $tmpl_selected);
			
			// STATUS
			$ObjectFactory->AddFilter(" tip_status_id = " . STATUS_TIP_PAGE);
			$statusi = $ObjectFactory->createObjects("SfStatus");
			
			$shStatus = new SmartyHtmlSelection("status",$smarty);
			foreach ($statusi as $s) 
			{
				$shStatus->AddOutput($s->getVrednost());
				$shStatus->AddValue($s->getStatusID());
			}
			$shStatus->AddSelected($page->SfStatus->getStatusID());
			$shStatus->SmartyAssign();
			$ObjectFactory->ResetFilters();

			// PRODUCT 
			$ObjectFactory->Reset();
			$parentGrp = $ObjectFactory->createObjects("PrGrupaProizvoda");
			$ObjectFactory->Reset();
			
			// Assign Parent groups to smarty
			if(count($parentGrp) > 0)
			{
				$grpArray = array();
				foreach($parentGrp as $grupaProizvoda)
					 $grpArray[] = $grupaProizvoda->toArrayHierarchy();

				$tree = new MemTree(); 
				$tree->FillItems($grpArray);
				$parentgrpCmb = $tree->DrawCombobox("grupaproizvodaid",$page->getGrupaProizvodaID(), false);
				$smarty->assign("parentgrpCmb" , $parentgrpCmb);
			}
			
			
			$smarty->assign("page", $page->toArray());
		}
		
		$smarty->display('modify_pgroup.tpl');
		
	}
	else
	{
		// show error message not enough rights
		$smarty->assign("norights_message",$LanguageArray["value"]["PLG_SNORIGHT"]);
		$smarty->display('../../templates/norights.tpl');
	}
?>