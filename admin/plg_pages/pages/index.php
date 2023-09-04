<?
	/* CMS Studio 3.0 frm_content.php */

	$_ADMINPAGES = true;
	include_once("../../../config.php");

	global $smarty;
	global $auth;

	$LanguageHelper = LanguageHelper::getInstance();
	$ObjectFactory = ObjectFactory::getInstance();

	if($auth->isActionAllowed("ACTION_PAGE_VIEW"))
	{
		//podesavanje parametra reload za osvezavanje levog frejma po potrebi
		if(isset($_REQUEST["reload"]))
		{
			$smarty->assign("reload","true");
			$smarty->assign("page_id_left",$_REQUEST["page_id"]);
		}
		else
		{
			$smarty->assign("reload","false");
		}

		$page_id = "";

		if(isset($_REQUEST["page_id"]))
		{
			$page_id = $_REQUEST["page_id"];

			// kreiram administracionu tabelu
			$ap = new AdminTable();
			// da li se aktivira settings za excel
			if($CMSSetting->getSettingByID(SETTING_EXCEL_EXPORT_PAGE) == SETTING_TYPE_ON)
			{
				$ap->ShowExportLinks();
			}

			$ap->SetOffsetName("pageoffset".$page_id);

			$comboFilterStatus = new PageStatusFilter($ObjectFactory,$ap);
			$comboFilterStatus->generateProccessComboBox();

			$comboFilterTipStranica = new PageTipStranicaFilter($ObjectFactory,$ap);
			$comboFilterTipStranica->generateProccessComboBox();

			$comboFilterTemplate = new PageTemplateFilter($ObjectFactory,$ap);
			$comboFilterTemplate->generateProccessComboBox();

			$filter_array=array('header','html');
			$ap->SetFilter($inputFilter->createFilter($filter_array));

			$pagelink = "index.php?page_id=".$page_id;
			$ap->SetHeader(
							array(
								"<span class='promeni'>".getTranslation("PLG_CHANGE")."</span>",
								SortLink::generateLink(getTranslation("PLG_NAME"),"header",$pagelink),
								getTranslation("PLG_TEMPLATE")."<br/>".$comboFilterTemplate->getComboBox(),
								getTranslation("PLG_TYPE")."<br/>".$comboFilterTipStranica->getComboBox(),
								SortLink::generateLink(getTranslation("PLG_STATUS"),"status_id",$pagelink)."</br>".$comboFilterStatus->getComboBox(),
								getTranslation("PLG_ACCESS"),
								getTranslation("PLG_VIEW"),
								getTranslation("PLG_COPY"),
								getTranslation("PLG_DELETE"),
							));

			//kreiram novi objekat Page
			$pg = $ObjectFactory->createObject("Page",$page_id,array("SfStatus"));

			$ObjectFactory->AddFilter("parent_id=".$pg->getPageID());
			$ap->SetCountAllRows($DBBR->prebrojSveSlogove($ObjectFactory->createObject("Page",-1), $ObjectFactory->filters));

			$ObjectFactory->AddLimit($ap->GetRowCount());
			$ObjectFactory->AddOffset($ap->GetOffset());
			$ObjectFactory->ManageSort();

			$objlist = $ObjectFactory->createObjects("Page",array("SfStatus","SfPageType","SfPageProtection"));

			$modify_script = "";
			$modify_message = "";
			$modify_mess = "";
			$delete_mess = "";
			$copy_mess = "";

			popuni_promenljive($pg->SfPageType->GetPageTypeID(), $modify_script, $modify_message, $modify_mess, $delete_mess, $copy_mess);

			$smarty->assign("ModifyScript",$modify_script);
			$smarty->assign("ModifyMessage",$modify_message);

			array_pop($ObjectFactory->filters);
			$ObjectFactory->AddFilter("page_id=".$pg->getPageID());
			$ap->SetBrowseString($ObjectFactory);
			$ap->SetTitle($pg->getHeader());
			$ap->SetRecordCount(count($objlist));

			$ObjectFactory->ResetFilters();
			$ObjectFactory->ResetLimitOffset();


			//za slicice gore-dole
			$html_img_up = "<img border=0 src='images/arr_up.gif'>";
			$html_img_down = "<img border=0 src='images/arr_down.gif'>";
			$html_img_edit = "<div class='btn btn-white'><i class='fa fa-pencil-square-o'></i></div>";
			$html_img_delete = "<div class='btn btn-white'><i class='fa fa-trash'></i></div>";
			$html_img_copy = "<div class='btn btn-white'><i class='fa fa-clone' aria-hidden='true'></i></div>";
			$html_img_view = "<div class='btn btn-white'><i class='fa fa-eye'></i></div>";

			// popunjavanje sadrzaja admin tabele
			if(count($objlist)>0)
			{
				$array_order=array();
				$j=1;
				foreach($objlist as $pg1)
				{
					$DBBR->poveziSaJednim($pg1,$pg1->getTemplate());
					popuni_promenljive($pg1->SfPageType->GetPageTypeID() , $modify_script, $modify_message, $modify_mess, $delete_mess, $copy_mess);

					if($auth->isActionAllowed("ACTION_PAGE_MODIFY"))
					{
						$modify_page = "<a class='naziv' href='".$modify_script."?page_id=".$pg1->getPageID()."'>".$html_img_edit."</a>";
					}
					else
					{
						$modify_page = $pg1->getHeader();
					}

					if($auth->isActionAllowed("ACTION_PAGE_DELETE"))
					{
						$delete_page = "<a href='delete_grp_final.php?page_id=".$pg1->getPageID()."'>".$html_img_delete."</a>";
					}
					else
					{
						$delete_page = $html_img_delete;
					}

					if($auth->isActionAllowed("ACTION_PAGE_MOVE"))
					{
						$move_page_up = "<a href='move_grp.php?direction=up&page_id=".$pg1->getPageID()."'>".$html_img_up."</a>";
						$move_page_down = "<a href='move_grp.php?direction=down&page_id=".$pg1->getPageID()."'>".$html_img_down."</a>";
					}
					else
					{
						$move_page_up = $html_img_up;
						$move_page_down = $html_img_down;
					}
					if ($j==1) $move_page_up = "";

					$copy_link = "<a href='copy_page.php?pageid=".$pg1->getPageID()."'>".$html_img_copy."</a>";
					$order_class = "class='sectionsid' id='sectionsid_".$pg1->getPageID()."'";
					array_push($array_order,$order_class);

					$HierarchicalTree = new Tree();
					$linkPage = new LinkPage($lh,$pg1->getPageID(),$pg1->getHeaderUnchanged(),$HierarchicalTree->path_to_url($pg1->getPageID()));
					$linkPage=$lh->GetPrintLink($linkPage);
					if ($pg1->SfPageType->getID()==1) $view_link = "<a id='zip' target='_blank' href='".$linkPage."'>".$html_img_view."</a>";
					else $view_link = "";
					$ap->AddTableRow(
						array(
								$modify_page,
								$pg1->getHeader()."&nbsp;",
								$pg1->getTemplate()->getTitle()."&nbsp;",
								$pg1->SfPageType->getVrednost()."&nbsp;",
								$pg1->SfStatus->getVrednost()."&nbsp;",
								$pg1->SfPageProtection->getVrednost()."&nbsp;",
								$view_link,
								$copy_link,
								$delete_page
							)
						);
					$j=2;
				}
				//$ap->SetTrTableAttributes($array_order);

			}

			$ap->RegisterAdminPage($smarty);
		}

		//pamtim na stranici trenutni id
		$smarty->assign("page_id",$page_id);

		if (file_exists('templates/index.tpl')) $smarty->display('index.tpl');
		else $smarty->display('../../../templates/index1.tpl');

	}
	else
	{
		// show error message not enough rights
		$smarty->assign("norights_message",getTranslation("PLG_NORIGHT"));
		$smarty->display('../../templates/norights.tpl');
	}


function popuni_promenljive($type, &$modify_script, &$modify_message, &$modify_mess, &$delete_mess, &$copy_mess)
{
	global $LanguageArray;

	switch($type)
	{
		case PAGE_TYPE_LINK:
			$modify_script = "modify_link.php";
			$modify_message = getTranslation("PLG_MAINTITLE_LINK");
			$modify_mess = getTranslation("PLG_CHANGEQUESTION");
			$delete_mess = getTranslation("PLG_DELETEQUESTION");
			$copy_mess = getTranslation("PLG_MESSAGE_COPY_LINK");
		break;
		case PAGE_TYPE_CATEGORY:
			$modify_script = "modify_categ.php";
			$modify_message = getTranslation("PLG_MAINTITLE_CATEGORY");
			$modify_mess = getTranslation("PLG_CHANGEQUESTION");
			$delete_mess = getTranslation("PLG_DELETEQUESTION");
			$copy_mess = getTranslation("PLG_MESSAGE_COPY_CATEGORY");
		break;
		case PAGE_TYPE_PRODUCTGROUP:
			$modify_script = "modify_pgroup.php";
			$modify_message = getTranslation("PLG_MAINTITLE_PRODUCTGROUP");
			$modify_mess = getTranslation("PLG_GROUP_CHANGEQUESTION");
			$delete_mess = getTranslation("PLG_GROUP_DELETEQUESTION");
			$copy_mess = getTranslation("PLG_MESSAGE_COPY_PRODUCTGROUP");
		break;
		case PAGE_TYPE_PAGE:
		default:
			$modify_script = "modify_grp.php";
			$modify_message = getTranslation("PLG_MAINTITLE_PAGE");
			$modify_mess = getTranslation("PLG_PAGE_CHANGEQUESTION");
			$delete_mess = getTranslation("PLG_PAGE_DELETEQUESTION");
			$copy_mess = getTranslation("PLG_MESSAGE_COPY_PAGE");
		break;
	}
}
?>
