<?
	/* CMS Studio 3.0 index.php */

	$_ADMINPAGES = true;
	include_once("../../../config.php");

	global $smarty;
	global $auth;

	if($auth->isActionAllowed("ACTION_VIEW"))
	{
		$ap = new AdminTable();
		$ap->SetTitle("Ažuriranje jezika:");
		$ap->SetOffsetName("offset_administrators");

		$ap->SetHeader(array(
							SortLink::generateLink("<span class='promeni'>".getTranslation("PLG_NAME")."</span>","name"),
							SortLink::generateLink(getTranslation("PLG_STATUS"),"status_id")."<br/>",
							SortLink::generateLink(getTranslation("PLG_LANGUAGE"),"language"),
							SortLink::generateLink(getTranslation("PLG_STATE"),"country"),
							getTranslation("PLG_DELETE"))
						);

		$ap->SetCountAllRows($DBBR->prebrojSveSlogove($ObjectFactory->createObject("SubSite",-1), $ObjectFactory->filters));

		$ObjectFactory->AddLimit($ap->GetRowCount());
		$ObjectFactory->AddOffset($ap->GetOffset());
		$ObjectFactory->ManageSort();

		$objlist = $ObjectFactory->createObjects("SubSite",array("SfStatus"));

		$ap->SetBrowseString($ObjectFactory);
		$ObjectFactory->ResetFilters(); $ObjectFactory->ResetLimitOffset();

		//za slicice gore-dole
		$html_img_edit = "<div class='btn btn-white'><i class='fa fa-pencil-square-o'></i></div>";
		$html_img_delete = "<div class='btn btn-white'><i class='fa fa-trash'></i></div>";
		$html_img_copy = "<i class='fa fa-clone' aria-hidden='true'></i>";

		$ap->SetRecordCount(count($objlist));

		//ZA SADRZAJ TABELE
		$array_order=array();
		if(count($objlist)>0)
		{
			foreach($objlist as $odo)
			{
				if($auth->isActionAllowed("ACTION_SUBSITE_MODIFY"))
				{
					$modify_link = "<a class='naziv' href='modify.php?".$odo->getLinkID()."' onclick=\"return confirmLink(this, '".getTranslation("PLG_CHANGEQUESTION")."')\" >$odo->Name</a>";
				}
				else
				{
					$modify_link = $odo->Name;
				}

				if($auth->isActionAllowed("ACTION_SUBSITE_DELETE"))
				{
					$delete_link = "<a href='delete_final.php?".$odo->getLinkID()."' >".$html_img_delete."</a>";

				}
				else
				{
					$delete_link = "<img border=0 src='../images/delete.gif'>";
				}
				$order_class = "class='sectionsid' id='sectionsid_".$odo->getSubSiteID()."'";
				array_push($array_order,$order_class);
				$ap->AddTableRow(
									array(
											$modify_link,
											$odo->SfStatus->getVrednost()."&nbsp;",
											$odo->Language."&nbsp;",
											$odo->Country."&nbsp;",
											$delete_link
										)
						 		);
			}
		}
		$ap->SetTrTableAttributes($array_order);
		$ap->RegisterAdminPage($smarty);

		$smarty->display('index.tpl');
	}
	else
	{
		// show error message not enough rights
		$smarty->assign("norights_message",getTranslation("PLG_NORIGHT"));
		$smarty->display('../../templates/norights.tpl');
	}




?>
