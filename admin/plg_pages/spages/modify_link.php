<?
	/* CMS Studio 3.0 modify_link.php */

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
			$spageid = $_REQUEST["spage_id"];
			
			$spg = $ObjectFactory->createObject("StaticPage",$_REQUEST["spage_id"],  array("SfPageType"));
			// deo za insertovanje novog sloga
			if(isset($_REQUEST["mode"])) 
			{
				$typeid = PAGE_TYPE_LINK;
				$smarty->assign("mode", 'insert');
			}
			else
			{		
				$smarty->assign("mode", 'edit');
				$typeid = $spg->SfPageType->GetPageTypeID();
			}
			$spagelink = $ObjectFactory->createObject("StaticPageLink", $spageid);
			
			$html = $spg->getHtml();
			$header = $spg->getHeader();
			$order = $spg->getOrder();
			
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
			
			$target_values = array("_blank","_parent","_self","_top");
			$target_output  = array("U novom prozoru (_blank)","U roditeljskom prozoru (_parent)","U istom prozoru (_self)","U najvisem prozoru (_top)" );
			$target_selected = array($spagelink->Target);		
			
			$smarty->assign("target_values", $target_values);
			$smarty->assign("target_output", $target_output);
			$smarty->assign("target_selected", $target_selected);
			
			$smarty->assign("spage_id",$spg->getSPageID());
			$smarty->assign("template_id", 1); //dodeljujem standardni template!
			$smarty->assign("order",$order);
			
			
			$smarty->assign("header",$header);
			$smarty->assign("html",$html);
			$smarty->assign("typeid",$typeid);
		}
	
		$smarty->display('modify_link.tpl');
	}
	else 
	{
		// show error message not enough rights
		$smarty->display('../../templates/norights.tpl');
	}

?>