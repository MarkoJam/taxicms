<?
	/* CMS Studio 3.0 index.php */

	$_ADMINPAGES = true;
	include_once("../../../config.php");

	global $smarty;
	global $auth;

	if($auth->isActionAllowed("ACTION_USERROLE_VIEW"))
	{
		$ap = new AdminTable();
		$ap->SetTitle("Azuriranje rola korisnika:");
		$ap->SetOffsetName("offset_userroles");

		$ap->SetHeader(
						array(
							"<span class='promeni'>".getTranslation("PLG_CHANGE")."</span>",	
							SortLink::generateLink(getTranslation("PLG_NAME"),"role"),
							SortLink::generateLink(getTranslation("PLG_DESCRIPTION"),"description"),
							getTranslation("PLG_DELETE"))
						);

		$ap->SetCountAllRows($DBBR->prebrojSveSlogove($ObjectFactory->createObject("UserRole",-1), $ObjectFactory->filters));

		$objlist = $ObjectFactory->createObjects("UserRole");

		$ObjectFactory->AddLimit($ap->GetRowCount());
		$ObjectFactory->AddOffset($ap->GetOffset());
		$ObjectFactory->ManageSort();

		$ap->SetBrowseString($ObjectFactory);

		$ap->SetRecordCount(count($objlist));
		$ObjectFactory->ResetFilters();$ObjectFactory->ResetLimitOffset();

		$html_img_edit = "<div class='btn btn-white'><i class='fa fa-pencil-square-o'></i></div>";
		$html_img_delete = "<div class='btn btn-white'><i class='fa fa-trash'></i></div>";

		//ZA SADRZAJ TABELE
		if(count($objlist)>0)
		{
			foreach($objlist as $odo)
			{
				if($auth->isActionAllowed("ACTION_USERROLE_MODIFY"))
				{
					$modify_link = "<a class='naziv' href='modify.php?".$odo->getLinkID()."'>".$html_img_edit."</a>";
				}
				else
				{
					$modify_link = $html_img_edit;
				}
				if($auth->isActionAllowed("ACTION_USERROLE_DELETE"))
				{
					$delete_link = "<a href='delete_final.php?action=delete&".$odo->getLinkID()."'>".$html_img_delete."</a>";
				}
				else
				{
					$delete_link = 	$html_img_delete;
				}

				if($odo->UserRoleID == 1)
				{
					$modify_link = "&nbsp;";
					$delete_link = "&nbsp;";
				}
				$ap->AddTableRow(array($modify_link,$odo->Role."&nbsp;", $odo->Description."&nbsp;",$delete_link));
			}
		}
		$ap->RegisterAdminPage($smarty);
		$smarty->display('index.tpl');
	}
	else
	{
		// show error message not enough rights
		$smarty->assign("norights_message",getTranslation("PLG_NORIGHT_VIEW"));
		$smarty->display('../../templates/norights.tpl');
	}
?>
