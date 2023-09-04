<?
	/* CMS Studio 3.0 index.php */

	$_ADMINPAGES = true;
	include_once("../../../config.php");

	global $smarty;
	global $auth;
	global $LanguageArray;

	if($auth->isActionAllowed("ACTION_OPTION_CATEGORY_VIEW"))
	{
		// kreiram administracionu tabelu
		$ap = new AdminTable();
		$ap->SetTitle("Azuriranje kategorija vesti:");
		$ap->SetHeader(array(
								"<span class='promeni'>".$LanguageArray["value"]["PLG_CHANGE"]."</span>",
								$LanguageArray["value"]["PLG_NAME"],
								$LanguageArray["value"]["PLG_STATUS"],
								$LanguageArray["value"]["PLG_NUMBER"],
								$LanguageArray["value"]["PLG_DELETE"]
			));
		$ap->SetOffsetName("offset_optioncategory");
		$ap->SetCountAllRows($DBBR->prebrojSveSlogove($ObjectFactory->createObject("OptionCategory",-1), $ObjectFactory->filters));

		$ObjectFactory->AddLimit($ap->GetRowCount());
		$ObjectFactory->AddOffset($ap->GetOffset());

		$objlist = $ObjectFactory->createObjects("OptionCategory");

		$ap->SetBrowseString($ObjectFactory);

		$ap->SetRecordCount(count($objlist));

		$ObjectFactory->ResetFilters();
		$ObjectFactory->ResetLimitOffset();

		//za slicice gore-dole
		$html_img_edit = "<div class='btn btn-white'><i class='fa fa-pencil-square-o'></i></div>";
		$html_img_delete = "<div class='btn btn-white'><i class='fa fa-trash'></i></div>";

		//ZA SADRZAJ TABELE
		foreach($objlist as $nwc)
		{
			$status= $ObjectFactory->createObject("SfStatus",$nwc->Status);
			$statusTitle=$status->getVrednost();
			// security check for modify action
			if($auth->isActionAllowed("ACTION_OPTION_CATEGORY_MODIFY"))
			{
				$modify_link = "<a class='naziv' href='modify.php?optioncategoryid=".$nwc->OptionCategoryID."'>".$html_img_edit."</a>";
			}
			else
			{
				$modify_link = $html_img_edit;
			}
			// security check for delete action
			if($auth->isActionAllowed("ACTION_OPTION_CATEGORY_DELETE"))
			{
				$delete_link = "<a href='delete_final.php?optioncategoryid=".$nwc->OptionCategoryID."'>".$html_img_delete."</a>";
			}
			else
			{
				$delete_link = $html_img_delete;
			}

			$ap->AddTableRow(array(
				$modify_link,$nwc->Title, 
				$statusTitle,
				$nwc->MessageNum,
				$delete_link
			));
		}
		$ap->RegisterAdminPage($smarty);

		$smarty->display('index.tpl');
	}
	else
	{
		// show error message not enough rights
		$smarty->assign("norights_message",$LanguageArray["value"]["PLG_OPTION_CATEGORY_NORIGHT_MODIFY"]);
		$smarty->display('../../../templates/norights.tpl');
	}

?>
