<?
	/* CMS Studio 3.0 index.php */
	$_ADMINPAGES = true;	
	include_once("../../config.php");

	global $auth;
	global $smarty;
	global $LanguageArray;
	
	$ap = new AdminTable();
	if($CMSSetting->getSettingByID(SETTING_EXCEL_EXPORT_PLUGIN) == SETTING_TYPE_ON) 
	{
		$ap->ShowExportLinks();
	}
	$ap->SetTitle("Azuriranje plugins:");
	$ap->SetHeader(
					array(	
						getTranslation("PLG_CHANGE"),
						SortLink::generateLink(getTranslation("PLG_NAME"),"title"),
						SortLink::generateLink(getTranslation("PLG_FILENAME"),"file_name"),
						SortLink::generateLink(getTranslation("PLG_CLASSNAME"),"classname"),
						SortLink::generateLink(getTranslation("PLG_MODULE"),"plugin_module_id"),
						SortLink::generateLink(getTranslation("PLG_TEMPLATEBASE"),"template_base"),
						SortLink::generateLink(getTranslation("PLG_ACTIVE"),"active"),
						getTranslation("PLG_DELETE"))
					);
					
	$ap->SetOffsetName("offset_plugins");
	$ap->SetCountAllRows($DBBR->prebrojSveSlogove($ObjectFactory->createObject("Plugin",-1), $ObjectFactory->filters));
	
	$ObjectFactory->AddLimit($ap->GetRowCount()); 
	$ObjectFactory->AddOffset($ap->GetOffset());
	$ObjectFactory->ManageSort();
	
	$objlist = $ObjectFactory->createObjects("Plugin",array("SfPluginModule"));
	
	$ap->SetBrowseString($ObjectFactory);
	$ap->SetRecordCount(count($objlist));

	$html_img_edit = "<div class='btn btn-white'><i class='fa fa-pencil-square-o'></i></div>";
	$html_img_delete = "<div class='btn btn-white'><i class='fa fa-trash'></i></div>";
	
	//ZA SADRZAJ TABELE
	foreach($objlist as $odo)
	{		
		$modify_link = "<a class='naziv' href='modify.php?".$odo->getLinkID()."'  >".$html_img_edit."</a>";
		$delete_link = "<a href='delete_final.php?action=delete&".$odo->getLinkID()."' >".$html_img_delete."</a>";
		
		$action_box = '<input type="checkbox" name="action" />';
		$templatebase_box = '<input type="checkbox" name="templatebase" />';
		
		$ap->AddTableRow(array($modify_link, 
			$odo->getTitle()."&nbsp;",
			$odo->getFileName()."&nbsp;",
			$odo->getClassname()."&nbsp;",
			$odo->getModule()."&nbsp;",
			$odo->getTemplateBase()."&nbsp;",
			//$action_box."&nbsp;",
			$odo->getActive()."&nbsp;",
			$delete_link));
	}
	$ap->RegisterAdminPage($smarty);
	$smarty->display('index.tpl');

?>