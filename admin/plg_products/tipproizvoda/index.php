<?
	/* CMS Studio 3.0 delete_kar_final.php */

	$_ADMINPAGES = true;
	include_once("../../../config.php");

	global $smarty;
	global $auth;

	$ObjectFactory = ObjectFactory::getInstance();

	if($auth->isActionAllowed("ACTION_PRODUCTTYPE_VIEW"))
	{
		$ap = new AdminTable();
		// da li se aktivira settings za excel
		if($CMSSetting->getSettingByID(SETTING_EXCEL_EXPORT_PRODUCTSTYPE) == SETTING_TYPE_ON)
		{
			$ap->ShowExportLinks();
		}
		$ap->SetOffsetName("offset_prtipproizvoda");
		$ap->SetTitle("Ažuriranje tipova proizvoda:");
		// REFAKTORISATI OVAJ DEO

		if(isset($_REQUEST["records_per_page"]) && is_numeric($_REQUEST["records_per_page"]))
		{
			$productsPerPage = $_REQUEST["records_per_page"];
			$_SESSION["records_per_page_prproizvod"] = $productsPerPage;
		}
		else if(isset($_SESSION["records_per_page_prproizvod"]) && is_numeric($_SESSION["records_per_page_prproizvod"]))
		{
			$productsPerPage = $_SESSION["records_per_page_prproizvod"];
		}
		else
		{
			$productsPerPage = 20;
		}

		$recordsPerPage = array(20,40,60,80,100,200);
		$shRecordsPerPage = new SmartyHtmlSelection("recordsPerPage",$smarty);
		foreach ($recordsPerPage as $num)
		{
			$shRecordsPerPage->AddOutput($num);
			$shRecordsPerPage->AddValue($num);
		}

		$shRecordsPerPage->AddSelected($productsPerPage);
		$shRecordsPerPage->SmartyAssign();

		$ap->SetRowCount($productsPerPage);
		$ap->SetColCount();


		$ap->SetHeader(
						array(
							"<span class='promeni'>".getTranslation("PLG_CHANGE")."</span>",
							SortLink::generateLink(getTranslation("PLG_NAME"),"naziv"),
							SortLink::generateLink(getTranslation("PLG_DESCRIPTION"),"opis"),
						//	getTranslation("PLG_GROUP"),
							getTranslation("PLG_DELETE")
						//	getTranslation("PLG_MOVEUP"),
						//	getTranslation("PLG_MOVEDOWN")
							)
						);

		$ap->SetCountAllRows($ObjectFactory->DBBR->prebrojSveSlogove($ObjectFactory->createObject("PrTipProizvoda",-1), $ObjectFactory->filters));

		$ObjectFactory->AddLimit($ap->GetRowCount());
		$ObjectFactory->AddOffset($ap->GetOffset());
		$ObjectFactory->ManageSort();

		$objlist = $ObjectFactory->createObjects("PrTipProizvoda");

		if(isset($_REQUEST["insertgrp"]))
		{
			$smarty->assign("insertgrp",$_REQUEST["insertgrp"]);
		}

		$ap->SetBrowseString($ObjectFactory);
		$ap->SetRecordCount(count($objlist));

		$filter_str = getBrowseString($ObjectFactory);

		$ObjectFactory->ResetFilters();
		$ObjectFactory->ResetLimitOffset();

		$grupetipovaproizvoda = $ObjectFactory->createObjects("PrGrupaTipovaProizvoda");

		$ShGrupeTipovaProizvoda = new SmartyHtmlSelection("grupatipovaproizvoda",$smarty);

		for($i=0;$i<count($grupetipovaproizvoda);$i++)
		{
			$ShGrupeTipovaProizvoda->AddValue($grupetipovaproizvoda[$i]->GrupaTipovaProizvodaID);
			$ShGrupeTipovaProizvoda->AddOutput($grupetipovaproizvoda[$i]->Naziv);
		}
		if(isset($_SESSION["grupatipovaproizvodaid_sel"])) $ShGrupeTipovaProizvoda->AddSelected($_SESSION["grupatipovaproizvodaid_sel"]);

		$ShGrupeTipovaProizvoda->SmartyAssign();

		//za slicice gore-dole
		$html_img_up = "<img border=0 src='images/arr_up.gif'>";
		$html_img_down = "<img border=0 src='images/arr_down.gif'>";
		$html_img_edit = "<div class='btn btn-white'><i class='fa fa-pencil-square-o'></i></div>";
		$html_img_delete = "<div class='btn btn-white'><i class='fa fa-trash'></i></div>";
		$html_img_add = "<div class='btn btn-white'><i class='fa fa-plus-square-o' aria-hidden='true'></i></div>";

		//ZA SADRZAJ TABELE
		foreach($objlist as $odo)
		{

			if($auth->isActionAllowed("ACTION_PRODUCTTYPE_MODIFY"))
			{
				$modify_link = "<a class='naziv' href='modify.php?".$odo->getLinkID()."'>".$html_img_edit."</a>";
			}
			else
			{
				$modify_link = $html_img_edit;
			}

			if($auth->isActionAllowed("ACTION_PRODUCTTYPE_DELETE"))
			{
				$delete_link = "<a href='delete_final.php?action=delete&".$odo->getLinkID()."'>".$html_img_delete."</a>";
			}
			else
			{
				$delete_link = $html_img_delete;
			}

			if($auth->isActionAllowed("ACTION_PRODUCTTYPE_ADDGROUP"))
			{
				$add_to_group = '<a href="javascript:GETLinkUbaciGrupa(\''.$odo->TipProizvodaID.'\');" onclick="return confirmLink(this, \''.getTranslation("PLG_GROUP_ADD").'\')" >'.$html_img_add.'</a>';
			}
			else
			{
				$add_to_group = $html_img_add;
			}

			if($auth->isActionAllowed("ACTION_PRODUCTTYPE_MOVE"))
			{
				$move_up = "<a href='move.php?direction=up".$filter_str."&".$odo->getLinkID()."'>".$html_img_up."</a>";
				$move_down = "<a href='move.php?direction=down".$filter_str."&".$odo->getLinkID()."'>".$html_img_down."</a>";
			}
			else
			{
				$move_up = $html_img_up;
				$move_down = $html_img_down;
				$add_to_group = "<a href='javascript:GETLinkUbaciGrupa(\"'.$odo->TipProizvodaID.'\");' oncli=\"return confirmLink(this, '".getTranslation("PLG_GROUP_ADD")."')\" >".$html_img_add."</a>";
			}
			$ap->AddTableRow(
							array($modify_link,
									$odo->Naziv,
								  $odo->Opis,
							//	  $add_to_group,
								  $delete_link
							//	  $move_up,
							// 	  $move_down
								  ));
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

	function getBrowseString($factory)
	{
		$str = "";
		if(count($factory->filters)!=0)
		{
			foreach ($factory->filters as $f) {
				$f = str_replace("'","",$f);
				$str .= "&".$f;
			}
		}
		return $str;
	}
?>
