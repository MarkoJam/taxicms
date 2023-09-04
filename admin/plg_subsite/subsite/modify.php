<? 
	/* CMS Studio 3.0 modify.php */
	$_ADMINPAGES = true;
	
	include_once("../../../config.php");
		
	global $smarty;
	global $auth;
	
	if($auth->isActionAllowed("ACTION_SUBSITE_MODIFY"))
	{
		if(isset($_REQUEST["mode"])) $_REQUEST["subsiteid"]=-1;																			
		if(isset($_REQUEST["subsiteid"]))
		{			
			// deo za insertovanje novog sloga
			if(($_REQUEST["mode"])=='insert') $smarty->assign("mode", 'insert');
			else $smarty->assign("mode", 'edit');			
			
			$ss = $ObjectFactory->createObject("SubSite",$_REQUEST["subsiteid"]);
			$smarty->assign($ss->toArray());			

			$ObjectFactory->AddFilter(" tip_status_id = ".STATUS_TIP_SUBSITE);
			$status_arr = $ObjectFactory->createObjects("SfStatus");
			$ObjectFactory->ResetFilters();
			
			$shStatus = new SmartyHtmlSelection("status", $smarty);
			if(count($status_arr)>0)
			{
				foreach ($status_arr as $status)
				{
					$shStatus->AddOutput($status->Vrednost);
					$shStatus->AddValue($status->StatusID);
				}
				$shStatus->AddSelected($admin->SfStatus->StatusID);
			}
			$shStatus->SmartyAssign();
			
		}	
		$smarty->display('modify.tpl');
	}
	else 
	{
		// show error message not enough rights
		$smarty->assign("norights_message","Nemate prava da menjate administratora sistema. Obratite se administratoru sistema.");
		$smarty->display('../../templates/norights.tpl');
	}

?>