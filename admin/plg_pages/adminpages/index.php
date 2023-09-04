<? 
	/* CMS Studio 3.0 index.php */
	
	$_ADMINPAGES = true;
	include_once("../../../config.php");
	
	global $smarty;
	global $auth;

	
	if($auth->isActionAllowed("ACTION_ADMIN_VIEW"))
	{
		// kreiram administracionu tabelu
		$ap = new AdminTable();
		if($CMSSetting->getSettingByID(SETTING_EXCEL_EXPORT_ADMINPAGE) == SETTING_TYPE_ON) 
		{
			$ap->ShowExportLinks();
		}
		
		$ap->SetOffsetName("offset_adminpages");
		$ap->SetHeader(
						array(
							getTranslation("PLG_CHANGE"),
							SortLink::generateLink(getTranslation("PLG_NAME"),"header"),
							SortLink::generateLink(getTranslation("PLG_PAGENAME"),"adminpagename"),
							SortLink::generateLink(getTranslation("PLG_TEMPLATE"),"template_id"),
							getTranslation("PLG_DELETE")
							 )
						);

		$ap->SetCountAllRows($DBBR->prebrojSveSlogove($ObjectFactory->createObject("AdminPage",-1), $ObjectFactory->filters));
	
		$ObjectFactory->AddLimit($ap->GetRowCount()); 
		$ObjectFactory->AddOffset($ap->GetOffset());
		$ObjectFactory->ManageSort();
		
		$objlist = $ObjectFactory->createObjects("AdminPage",array("Template"));
		
		$ap->SetBrowseString($ObjectFactory);
		$ap->SetRecordCount(count($objlist));
		
		$html_img_edit = "<div class='btn btn-white'><i class='fa fa-pencil-square-o'></i></div>";
		$html_img_delete = "<div class='btn btn-white'><i class='fa fa-trash'></i></div>";
		
		//ZA SADRZAJ TABELE
		foreach($objlist as $apg1){
			
			$ap->AddTableRow(
					array("<a class='naziv' href='modify.php?apage_id=".$apg1->AdminPageID."'  >".$html_img_edit."</a>",$apg1->Header,$apg1->AdminPageName,$apg1->Template->Title,
						  "<a href='delete_final.php?apage_id=".$apg1->AdminPageID."'>".$html_img_delete."</a>"
						)
				);
			}
		$ap->RegisterAdminPage($smarty);	
		$smarty->display('index.tpl');
	}
	else 
	{
		// show error message not enough rights
		$smarty->assign("norights_message",getTranslation("PLG_NORIGHTS_MESSAGE"));
		$smarty->display('../../templates/norights.tpl');
	}
?>