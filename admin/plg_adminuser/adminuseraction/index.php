<?
	/* CMS Studio 3.0 index.php */
	$_ADMINPAGES = true;	
	include_once("../../../config.php");
		
	global $smarty;
	global $auth;
	
	if($auth->isActionAllowed("ACTION_USERGROUPACTIONS_VIEW"))
	{
		$ap = new AdminTable();
		$ap->ShowExportLinks();
		$ap->SetTitle("Azuriranje useraction:");
		$ap->SetHeader(array
					(
						getTranslation("PLG_CHANGE"),
						SortLink::generateLink(getTranslation("PLG_NAME"),"title"),
						SortLink::generateLink(getTranslation("PLG_DESCRIPTION"),"description"),
						SortLink::generateLink(getTranslation("PLG_CODE"),"action_code"),
						SortLink::generateLink(getTranslation("PLG_PLUGIN"),"pluginid"),
						getTranslation("PLG_DELETE")
						)
					);
						
		$ap->SetOffsetName("offset_useraction");
		$ap->SetCountAllRows($DBBR->prebrojSveSlogove($ObjectFactory->createObject("AdminUserAction",-1), $ObjectFactory->filters));
		
		$ObjectFactory->AddLimit($ap->GetRowCount()); 
		$ObjectFactory->AddOffset($ap->GetOffset());
		$ObjectFactory->ManageSort();
		
		$objlist = $ObjectFactory->createObjects("AdminUserAction",array("Plugin"));
		
		$ap->SetBrowseString($ObjectFactory);
		$ap->SetRecordCount(count($objlist));
		
		$html_img_edit = "<div class='btn btn-white'><i class='fa fa-pencil-square-o'></i></div>";
		$html_img_delete = "<div class='btn btn-white'><i class='fa fa-trash'></i></div>";
		
		//ZA SADRZAJ TABELE
		if(count($objlist)>0)
		{
			foreach($objlist as $odo)
			{		
				if($auth->isActionAllowed("ACTION_USERGROUPACTIONS_MODIFY"))
				{	
					$modify_link = "<a class='naziv' href='modify.php?".$odo->getLinkID()."'>".$html_img_edit."</a>";
				}
				else 
				{
					$modify_link = $html_img_edit;					
				}
				if($auth->isActionAllowed("ACTION_USERGROUPACTIONS_DELETE"))
				{
					$delete_link = "<a href='delete_final.php?action=delete&".$odo->getLinkID()."'>".$html_img_delete."</a>";					
				}

				
				$ap->AddTableRow(array($modify_link, 
					$odo->Title."&nbsp;",
					$odo->Description."&nbsp;",
					$odo->ActionCode."&nbsp;",
					$odo->Plugin->Title."&nbsp;",
					$delete_link));
			}
		}
		$ap->RegisterAdminPage($smarty);
		$smarty->display('index.tpl');
	}
	else
	{
		// show error message not enough rights
		$smarty->assign("norights_message",getTranslation("PLG_NORIGHT_VIEW"));
		$smarty->display('../../../templates/norights.tpl');	
	}
?>