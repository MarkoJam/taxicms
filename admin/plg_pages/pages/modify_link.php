<?
	/* CMS Studio 3.0 modify_link.php */
	
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
		
		if(isset($_REQUEST["parent_id"])) $_REQUEST["page_id"]=-1;		
		if(isset($_REQUEST["page_id"]))
		{
			//punjenje i/ili postavljanje kategorijeid iz/u sesije
			$page_id = $_SESSION["page_id"] = $_REQUEST["page_id"];
			
			$pg = $ObjectFactory->createObject("Page", $_REQUEST["page_id"], array("SfPageType"));
			// deo za insertovanje novog sloga
			if(isset($_REQUEST["parent_id"])) 
			{
				$pg->setParentID($_REQUEST["parent_id"]);
				$typeid = $_REQUEST["pagetypeid"];
				$smarty->assign("mode", 'insert');
			}
			else
			{		
				$smarty->assign("mode", 'edit');
				$typeid = $pg->SfPageType->GetPageTypeID();
			}
			$pg->setPageID($_REQUEST["page_id"]);
			$DBBR->nadjiSlogVratiGa($pg);
			
			$pagelink = $ObjectFactory->createObject("PageLink",-1);
			$pagelink->PageID = $pg->getPageID();
			$DBBR->nadjiSlogVratiGa($pagelink);
			
			$html = $pg->getHtml();
			$header = $pg->getHeader();
			$subHeader = $pg->getSubHeader();
			$parent_id = $pg->getParentID();
			$order = $pg->getOrder();
			$navigationType = $pg->getNavigationType();
						
			$ObjectFactory->AddFilter(" tip_status_id = " . STATUS_TIP_PAGE);
			$statusi = $ObjectFactory->createObjects("SfStatus");
			
			$shStatus = new SmartyHtmlSelection("status",$smarty);
			foreach ($statusi as $s) 
			{
				$shStatus->AddOutput($s->getVrednost());
				$shStatus->AddValue($s->getStatusID());
			}
			$shStatus->AddSelected($pg->SfStatus->getStatusID());
			$shStatus->SmartyAssign();	
			$ObjectFactory->ResetFilters();
			
			// nadredjena stranica
			$ObjectFactory->Reset();
			//$ObjectFactory->AddFilter("page_id <> " . $page_id);
			$parentPage = $ObjectFactory->createObjects("Page");
			$ObjectFactory->Reset();
				
			// Assign Parent groups to smarty
			if(count($parentPage) > 0)
			{
				$pageArray = array();
				foreach($parentPage as $pageP)
					$pageArray[] = $pageP->toArrayHierarchy();
					
				$tree = new MemTree();
				$tree->FillItems($pageArray);
				$parentPageCmb = $tree->DrawCombobox("parent_id",$pg->getParentID());
				$smarty->assign("parentPageCmb" , $parentPageCmb);
			}
			
			$target_values = array("_blank","_parent","_self","_top");
			$target_output  = array("U novom prozoru (_blank)","U roditeljskom prozoru (_parent)","U istom prozoru (_self)","U najvisem prozoru (_top)" );
			$target_selected = array($pagelink->Target);		
			
			$smarty->assign("target_values", $target_values);
			$smarty->assign("target_output", $target_output);
			$smarty->assign("target_selected", $target_selected);
			
			$smarty->assign("page_id",$pg->getPageID());
			$smarty->assign("parent_id",$parent_id);
			$smarty->assign("template_id", 1); //bezveze dodeljujem standardni template!
			$smarty->assign("order",$order);
			
			$smarty->assign("header",$header);
			$smarty->assign("subHeader",$subHeader);
			$smarty->assign("html",$html);
			$smarty->assign("pagetypeid",$typeid);
			$smarty->assign("navigationtype", $navigationType);
		}
	
		$smarty->display('modify_link.tpl');
	}
	else
	{
		// show error message not enough rights
		$smarty->assign("norights_message", $LanguageArray["value"]["PLG_NORIGHT"]);
		$smarty->display('../../templates/norights.tpl');
	}
?>