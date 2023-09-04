<?
	/* CMS Studio 3.0 modify_grp.php */

	$_ADMINPAGES = true;
	include_once("../../../config.php");
		
	global $smarty;
	global $auth;
	
	$ObjectFactory = ObjectFactory::getInstance();
	
	if($auth->isActionAllowed("ACTION_SPAGE_MODIFY"))
	{
		if(isset($_REQUEST["mode"])) $_REQUEST["spage_id"]=-1;
		if(isset($_REQUEST["spage_id"]))
		{
			//punjenje i/ili postavljanje kategorijeid iz/u sesije
			$_SESSION["spage_id"] = $_REQUEST["spage_id"];
			
			$spg = $ObjectFactory->createObject("StaticPage",$_REQUEST["spage_id"],  array("SfPageType"));
			// deo za insertovanje novog sloga
			if(isset($_REQUEST["mode"])) 
			{
				$typeid = PAGE_TYPE_PAGE;
				$smarty->assign("mode", 'insert');
			}
			else
			{		
				$smarty->assign("mode", 'edit');
				$typeid = $spg->SfPageType->GetPageTypeID();
			}			
			$html = $spg->getHtml();
			htmldecode($html);
			
			$header = $spg->getHeader();
			$order = $spg->getOrder();
			
			// punjenje kombo boxa sa Template-ima
			$templates = $ObjectFactory->createObjects("Template");
			
			$tmpl_values = array();
			$tmpl_output  = array();
			$tmpl_selected = array();
			
			foreach($templates as $tm)
			{
				array_push($tmpl_values,$tm->TemplateID);
				array_push($tmpl_output,$tm->Title);
			}
			
			array_push($tmpl_selected,$spg->getTemplate()->TemplateID);
			
			$smarty->assign("tmpl_values", $tmpl_values);
			$smarty->assign("tmpl_output", $tmpl_output);
			$smarty->assign("tmpl_selected", $tmpl_selected);
			
			// statusi
			$ObjectFactory->AddFilter(" tip_status_id = " . STATUS_TIP_PAGE);
			$statusi = $ObjectFactory->createObjects("SfStatus");
				
			$shStatus = new SmartyHtmlSelection("status",$smarty);
			foreach ($statusi as $s) 
			{
				$shStatus->AddOutput($s->Vrednost);
				$shStatus->AddValue($s->StatusID);
			}
			$shStatus->AddSelected($spg->SfStatus->StatusID);
			$shStatus->SmartyAssign();
			$ObjectFactory->ResetFilters();
			
			$smarty->assign("spage_id", $spg->getSPageID());
			$smarty->assign("order", $order);
			$smarty->assign("header", $header);
			$smarty->assign("typeid", $typeid);
			$smarty->assign("html",$html);
		}
	
		$smarty->display('modify_grp.tpl');
	}
	else 
	{
		// show error message not enough rights
		$smarty->assign("norights_message",getTranslation("PLG_NORIGHT"));
		$smarty->display('../../templates/norights.tpl');
	}
?>