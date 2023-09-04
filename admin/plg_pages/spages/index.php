<?
	/* CMS Studio 3.0 index.php */

	$_ADMINPAGES = true;
	include_once("../../../config.php");

	if($auth->isActionAllowed("ACTION_SPAGE_VIEW"))
	{
		// kreiram administracionu tabelu
		$ap = new AdminTable();

		if($CMSSetting->getSettingByID(SETTING_EXCEL_EXPORT_STATICPAGE) == SETTING_TYPE_ON)
		{
			$ap->ShowExportLinks();
		}

		$ap->SetOffsetName("offset_spages");

		$comboFilterTipStranica = new PageTipStranicaFilter($ObjectFactory,$ap);
		$comboFilterTipStranica->generateProccessComboBox();

		$comboFilterStatus = new PageStatusFilter($ObjectFactory,$ap);
		$comboFilterStatus->generateProccessComboBox();

		$ap->SetHeader(
						array(
							"<span class='promeni'>".getTranslation("PLG_CHANGE")."</span>",	
							SortLink::generateLink(getTranslation("PLG_NAME"),"header"),
							SortLink::generateLink(getTranslation("PLG_TEMPLATE"),"template_id"),
							SortLink::generateLink(getTranslation("PLG_TYPE"),"type_id")."<br/>".$comboFilterTipStranica->getComboBox(),
							SortLink::generateLink(getTranslation("PLG_STATUS"),"status_id")."<br/>".$comboFilterStatus->getComboBox(),
							getTranslation("PLG_DELETE")
						));

		$ap->SetCountAllRows($DBBR->prebrojSveSlogove($ObjectFactory->createObject("StaticPage",-1), $ObjectFactory->filters));

		$ObjectFactory->AddLimit($ap->GetRowCount());
		$ObjectFactory->AddOffset($ap->GetOffset());
		$ObjectFactory->ManageSort();

		$objlist = $ObjectFactory->createObjects("StaticPage",array("Template","SfStatus","SfPageType"));

		$modify_script = "";
		$modify_message = "";
		$modify_mess = "";
		$delete_mess = "";

		$smarty->assign("ModifyScript",$modify_script);
		$smarty->assign("ModifyMessage",$modify_message);

		$ap->SetBrowseString($ObjectFactory);
		$ap->SetTitle("Promena statičnih linkova");
		$ap->SetRecordCount(count($objlist));

		//za slicice gore-dole
		$html_img_up = "<img border=0 src='../images/arr_up.gif'>";
		$html_img_down = "<img border=0 src='../images/arr_down.gif'>";
		$html_img_edit = "<div class='btn btn-white'><i class='fa fa-pencil-square-o'></i></div>";
		$html_img_delete = "<div class='btn btn-white'><i class='fa fa-trash'></i></div>";

		if(!empty($objlist))
		foreach($objlist as $spg1)
		{
			//uvezujem staticnu stranicu sa postojecim templejtom
			popuni_promenljive($spg1->SfPageType->GetPageTypeID(), $modify_script, $modify_message, $modify_mess, $delete_mess);

			if($auth->isActionAllowed("ACTION_SPAGE_MODIFY"))
			{
				$modify_spage = "<a class='naziv' href='".$modify_script."?spage_id=".$spg1->getSPageID()."'>".$html_img_edit."</a>";
			}
			else
			{
				$modify_spage =	$html_img_edit;
			}

			if($auth->isActionAllowed("ACTION_SPAGE_DELETE"))
			{
				$delete_spage = "<a href='delete_final.php?spage_id=".$spg1->getSPageID()."'>".$html_img_delete."</a>";
			}
			else
			{
				$delete_spage = $html_img_delete;
			}

			if($auth->isActionAllowed("ACTION_SPAGE_MOVE"))
			{
				$moveup_spage = "<a href='move_grp.php?direction=up&spage_id=".$spg1->getSPageID()."'>".$html_img_up."</a>";
				$movedown_spage = "<a href='move_grp.php?direction=down&spage_id=".$spg1->getSPageID()."'>".$html_img_down."</a>";
			}
			else
			{
				$moveup_spage = $html_img_up;
				$movedown_spage = $html_img_down;
			}

			$ap->AddTableRow(
					array(
							$modify_spage,
							$spg1->getHeader(),
							$spg1->getTemplate()->Title,
							$spg1->getSfPageType()->Vrednost,
							$spg1->getSfStatus()->Vrednost,
							$delete_spage
						//	$moveup_spage,
						//	$movedown_spage
						)
				);
			}
		$ap->RegisterAdminPage($smarty);

		$smarty->assign("PAGE_TYPE_PAGE",PAGE_TYPE_PAGE);
		$smarty->assign("PAGE_TYPE_LINK",PAGE_TYPE_LINK);

		$smarty->display('index.tpl');
	}
	else
	{
		// show error message not enough rights
		$smarty->assign("norights_message",getTranslation("PLG_SNORIGHT_VIEW"));
		$smarty->display('../../templates/norights.tpl');
	}

function popuni_promenljive($type_id, &$modify_script, &$modify_message, &$modify_mess, &$delete_mess){

	global $LanguageArray;

	switch($type_id){
		case PAGE_TYPE_PAGE:
			$modify_script = "modify_grp.php";
			$modify_message = getTranslation("PLG_MAINTITLE_PAGE");
			$modify_mess = getTranslation("PLG_PAGE_CHANGEQUESTION");
			$delete_mess = getTranslation("PLG_PAGE_DELETEQUESTION");
		break;
		case PAGE_TYPE_LINK:
			$modify_script = "modify_link.php";
			$modify_message = getTranslation("PLG_MAINTITLE_LINK");
			$modify_mess = getTranslation("PLG_CHANGEQUESTION");
			$delete_mess = getTranslation("PLG_DELETEQUESTION");
		break;
		default:
			$modify_script = "modify_grp.php";
			$modify_message = getTranslation("PLG_MAINTITLE_PAGE");
			$modify_mess = getTranslation("PLG_PAGE_CHANGEQUESTION");
			$delete_mess = getTranslation("PLG_PAGE_DELETEQUESTION");
		break;
	}
}
?>
