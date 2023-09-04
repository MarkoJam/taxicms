<?
	/* CMS Studio 3.0 modify.php *///

	$_ADMINPAGES = true;
	include_once("../../../config.php");
		
	global $smarty;
	global $auth;
	
	if($auth->isActionAllowed("ACTION_ADMINISTRATOR_MODIFY"))
	{
		if(isset($_REQUEST["mode"])) $_REQUEST["adminuserid"]=-1;						
		if(isset($_REQUEST["adminuserid"]))
		{
			// deo za insertovanje novog sloga
			if(isset($_REQUEST["mode"])) $smarty->assign("mode", 'insert');
			else $smarty->assign("mode", 'edit');
			
			$admin = $ObjectFactory->createObject("AdminUser",$_REQUEST["adminuserid"]);
			$smarty->assign($admin->toArray());
			
			// punjenje comboboxova za admin user groups
			$adminUserGroup_arr = $ObjectFactory->createObjects("AdminUserGroup");
			
			$shAdminUserGroup = new SmartyHtmlSelection("adminusergroup", $smarty);
			
			if(count($adminUserGroup_arr)>0)
			{
				foreach ($adminUserGroup_arr as $usergroup)
				{
					$shAdminUserGroup->AddOutput($usergroup->Title);
					$shAdminUserGroup->AddValue($usergroup->AdminUserGroupID);
				}
				$shAdminUserGroup->AddSelected($admin->AdminUserGroup->AdminUserGroupID);
			}
			$shAdminUserGroup->SmartyAssign();
			
			$subsites = $ObjectFactory->createObjects("SubSite");
			
			$shSubSite = new SmartyHtmlSelection("subsite", $smarty);
			if(count($subsites)>0)
			{
				
				foreach ($subsites as $subsite)
				{
					$shSubSite->AddOutput($subsite->Name);
					$shSubSite->AddValue($subsite->SubSiteID);
				}
				$shSubSite->AddSelected($admin->SubSite->SubSiteID);
			}
			$shSubSite->SmartyAssign();
			
			
			//registrujem smarty promenljivu za izbor meseca
			$sMonth = new SmartyHtmlSelection("dateMonth", $smarty);
			$cnt = 1;
			//foreach ($months_strings[$language] as $month){
			foreach (range(1,12) as $month){
				$sMonth->AddOutput($month);
				$sMonth->AddValue($cnt);
				$cnt++;
			}
			
			$sMonth->AddSelected(date("n",$admin->ExpiryDate));
			$sMonth->SmartyAssign();
			
			//registrujem smarty promenljivu za izbor dana
			$sDay = new SmartyHtmlSelection("dateDay", $smarty);
			foreach ( range(1,31) as $day){
				$sDay->AddOutput($day);
				$sDay->AddValue($day);
				$cnt++;
			}
			
			$sDay->AddSelected(date("j",$admin->ExpiryDate));
			$sDay->SmartyAssign();
			
			//registrujem smarty promenljivu za izbor godine
			$sYear = new SmartyHtmlSelection("dateYear", $smarty);
			$cnt = 2006;
			foreach (range(2006,2030) as $year){
				$sYear->AddOutput($year);
				$sYear->AddValue($cnt);
				$cnt++;
			}
			
			$sYear->AddSelected(date("Y",$admin->ExpiryDate));
			$sYear->SmartyAssign();
			
			$ObjectFactory->AddFilter(" tip_status_id = ".STATUS_TIP_ADMINUSER);
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
		$smarty->display('../../../templates/norights.tpl');
	}

?>
