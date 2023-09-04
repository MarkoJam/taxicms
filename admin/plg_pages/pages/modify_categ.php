<?
	/* CMS Studio 3.0 modify_categ.php */	

	$_ADMINPAGES = true;
	include_once("../../../config.php");
		
	global $smarty;
	global $auth;
	global $LanguageArray;
	
	$ObjectFactory = ObjectFactory::getInstance();
	
	if($auth->isActionAllowed("ACTION_PAGE_MODIFY"))
	{
		
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
			
			$html = $pg->getHtml();
			$header = $pg->getHeader();
			$subHeader = $pg->getSubHeader();
			$parent_id = $pg->getParentID();
			$order = $pg->getOrder();
			$navigationType = $pg->getNavigationType();

			
			// statusi
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
			
			$smarty->assign("page_id",$pg->getPageID());
			$smarty->assign("parent_id",$parent_id);
			$smarty->assign("template_id", 1);
			$smarty->assign("order",$order);
			
			// nadredjena stranica
			$ObjectFactory->Reset();
			$ObjectFactory->AddFilter("page_id <> " . $page_id);
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
			
			
			$smarty->assign("header",$header);
			$smarty->assign("subheader",$subHeader);
			$smarty->assign("html",$html);
			$smarty->assign("pagetypeid",$typeid);
			$smarty->assign("navigationtype", $navigationType);
		}
		$smarty->display('modify_categ.tpl');
	}
	else
	{
		// show error message not enough rights
		$smarty->assign("norights_message",$LanguageArray["value"]["PLG_SNORIGHT"]);
		$smarty->display('../../templates/norights.tpl');
	}
?>