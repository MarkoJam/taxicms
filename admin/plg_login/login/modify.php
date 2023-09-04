<?
	/* CMS Studio 3.0 modify.php *///

	$_ADMINPAGES = true;
	include_once("../../../config.php");
		
	global $smarty;
	global $auth;
	
	if($auth->isActionAllowed("ACTION_LOGIN_MODIFY"))
	{
		if(isset($_REQUEST["mode"])) $_REQUEST["userid"]=-1;				
		if(isset($_REQUEST["userid"]))
		{
			// deo za insertovanje novog sloga
			if(isset($_REQUEST["mode"])) $smarty->assign("mode", 'insert');
			else $smarty->assign("mode", 'edit');
			
			$user = $ObjectFactory->createObject("User",$_REQUEST["userid"]);

			/* part for user log history */
			$ObjectFactory->SetSortBy("last_log_date","desc");
			$ObjectFactory->AddFilter("user_id = " .$user->getUserID());
			$user_log_history = $ObjectFactory->createObjects("UserLogHistory",$_REQUEST["userid"]);
			$ObjectFactory->ResetFilters();
			$ObjectFactory->ResetSortBy();
			
			if(!empty($user_log_history))
			{
				$user_log_history_data = array();
				foreach ($user_log_history as $usr_log_hist) 
				{
					$user_log_history_data[] = $usr_log_hist->toArray();
				}
				
				$smarty->assign("user_log_history_data",$user_log_history_data);
			}
			
			$smarty->assign($user->toArray());
			
			$datum=date("d.m.Y", $user->getExpiryDate());
			$smarty->assign("datum", $datum);
			
			// statusi
			$ObjectFactory->AddFilter(" tip_status_id = " . STATUS_TIP_USER);
			$statusi = $ObjectFactory->createObjects("SfStatus");

			$shStatus = new SmartyHtmlSelection("status",$smarty);
			foreach ($statusi as $s) 
			{
				$shStatus->AddOutput($s->getVrednost());
				$shStatus->AddValue($s->getStatusID());
			}
			$shStatus->AddSelected($user->SfStatus->getStatusID());
			$shStatus->SmartyAssign();
			$ObjectFactory->ResetFilters();
			
			// kategorije
			$kategorije = $ObjectFactory->createObjects("SfUserCategory");

			$shKategorija = new SmartyHtmlSelection("usercategory",$smarty);
			foreach ($kategorije as $s) 
			{
				$shKategorija->AddOutput($s->getVrednost());
				$shKategorija->AddValue($s->getUserCategoryID());
			}
			$shKategorija->AddSelected($user->SfUserCategory->getUserCategoryID());
			$shKategorija->SmartyAssign();
			$ObjectFactory->ResetFilters();
			
			//tipovi
			$tipovi = $ObjectFactory->createObjects("SfUserType");

			$shTipKorisnika = new SmartyHtmlSelection("usertype",$smarty);
			foreach ($tipovi as $s) 
			{
				$shTipKorisnika->AddOutput($s->getVrednost());
				$shTipKorisnika->AddValue($s->getUserTypeID());
			}
			$shTipKorisnika->AddSelected($user->SfUserType->getUserTypeID());
			$shTipKorisnika->SmartyAssign();
			$ObjectFactory->ResetFilters();
			
			// potrebno je napuniti combobox sa subsiteovima
			$subsite_arr = $ObjectFactory->createObjects("SubSite");
		
			$shSubSite = new SmartyHtmlSelection("subsite", $smarty);
			if(count($subsite_arr)>0)
			{
				foreach ($subsite_arr as $subsite)
				{
					$shSubSite->AddOutput($subsite->Name);
					$shSubSite->AddValue($subsite->SubSiteID);
				}
			}
			$shSubSite->SmartyAssign();
			
			// html editor for info_page
			$html = $user->getUserDescription();
			//$html = htmldecode($html);
			
			$smarty->assign("html",$html);
			
			// deo koji povezuje korisnike sa vise podsajtova!
			
			$admTbl = new AdminTable();
			
			$admTbl->SetHeader(array(
									getTranslation("PLG_SUBSITE"),
									getTranslation("PLG_STATUS"),
									getTranslation("PLG_EXDATE"),
									getTranslation("PLG_DELETE")
									));
			$admTbl->SetOffsetName("offset_usersubsite".$user->UserID);
			
			$admTbl->AddBrowseString("userid=".$user->UserID);
			$admTbl->SetCountAllRows(count($user->UserSubSites));
			$html_img_delete = "<div class='btn btn-white'><i class='fa fa-trash'></i></div>";
			
			if(count($user->UserSubSites))
			{
				$i = 0;
				foreach ($user->UserSubSites as $usersubsite)
				{
					if($i >= $admTbl->GetOffset())
					{
						$subsite = $ObjectFactory->createObject("SubSite",$usersubsite->SubSiteID);
						
						$modify_link = "<a href='modify.php?action=modifyusersubsite&".$usersubsite->getLinkID()."'><b>".$subsite->Name. "</b></a>" ;
						
						$status_aktivan = "";
						$status_neaktivan = "";
						
						if($usersubsite->Status == "aktivan")
						{
							$status_link = getTranslation("PLG_STATUS_ACTIVE");
							$status_aktivan = "selected";
							
						}
						else 
						{
							$status_link = getTranslation("PLG_STATUS_NOACTIVE");
							$status_neaktivan = "selected";
						}
						
						$date_link = date("d/n/Y",$usersubsite->ExpiryDate)."&nbsp;";
						
						$delete_link = "&nbsp;";
						
						if(!(isset($_REQUEST["userid"]) && isset($_REQUEST["subsiteid"])))
						{
							if($user->SubSiteID != $usersubsite->SubSiteID)
							{
								$delete_link = "<a href='delete_usersubsite.php?action=delete&".$usersubsite->getLinkID()."&userid=".$user->UserID."' >".$html_img_delete."</a>";
							}
							
						}
						else 
						{
							if($usersubsite->SubSiteID == $_REQUEST["subsiteid"] && $usersubsite->UserID == $_REQUEST["userid"])
							{
								$modify_link = "<b>".$subsite->Name. "</b>";
								$delete_link = '<input name="modifybutt" id="modifybutt" type="submit" value="'.getTranslation("SUBMIT").'"><input name="userid_modify" id="userid_modify" type="hidden" value="'.$usersubsite->UserID.'"><input name="subsiteid_modify" id="subsiteid_modify" type="hidden" value="'.$usersubsite->SubSiteID.'">';
								
								$status_link = '<select name="status_modify" id="status">';
								$status_link .= '<option '.$status_aktivan.' value="aktivan">'.getTranslation("PLG_STATUS_ACTIVE").'</option>';
								$status_link .= '<option '.$status_neaktivan.' value="neaktivan">'.getTranslation("PLG_STATUS_NOACTIVE").'</option></select>';
								
								$date_link = '<input readonly="readonly" id="expirydate_modify" class="DatePicker" name="expirydate_modify" value="'.date("d/m/Y",$usersubsite->ExpiryDate).'" type="text">';
							}
							else
							{
								if($user->SubSiteID != $usersubsite->SubSiteID)
								{
									$delete_link = "<a href='delete_usersubsite.php?action=delete&".$usersubsite->getLinkID()."&userid=".$user->UserID."' >".$html_img_delete."</a>";
								}
							}
						}
						
						$admTbl->AddTableRow(
								array(	$modify_link, 
										$status_link,
										$date_link,
										$delete_link
										)
									);
						
						
					}
					$i++;
				}
			}
			
			$admTbl->RegisterAdminPage($smarty);
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