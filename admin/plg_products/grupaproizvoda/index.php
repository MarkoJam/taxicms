<?
	/* CMS Studio 3.0 index.php */

	$_ADMINPAGES = true;
	include_once("../../../config.php");

	global $smarty;
	global $auth;

	$ObjectFactory = ObjectFactory::getInstance();

	if($auth->isActionAllowed("ACTION_PRODUCT_GROUPPRODUCT_VIEW"))
	{
		$filter = "";
		$parentGrp = $ObjectFactory->createObject("PrGrupaProizvoda", -1 );

		if(isset($_REQUEST["reload"]))
		{
			$smarty->assign("parentid",$_REQUEST["parentid"]);
			$smarty->assign("reload","true");
		}
		else
		{
			$smarty->assign("reload","false");
		}

		if(isset($_REQUEST["parentid"]))
		{
			$parentID = $_REQUEST["parentid"];
			$filter = "parentid = " . quote_smart($parentID);
			$parentGrp = $ObjectFactory->createObject("PrGrupaProizvoda", $parentID );
		}
		else
		{
			$filter = "parentid IS NULL ";
		}

		$ap = new AdminTable();
		$ap->SetOffsetName("offset_prgrupaproizvoda");
		$ap->SetTitle(getTranslation("PLG_MAINTITLE"));

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


		$ap->SetHeader(array
							(
								"<span class='promeni'>".getTranslation("PLG_CHANGE")."</span>",
								SortLink::generateLink(getTranslation("PLG_NAME"),"naziv"),
							//	SortLink::generateLink(getTranslation("PLG_DESCRIPTION"),"opis"),
								getTranslation("PLG_PARENT"),
								getTranslation("PLG_TEMPLATE"),
								SortLink::generateLink(getTranslation("PLG_STATUS"),"statusid"),
					//			getTranslation("PLG_MOVE_UP"),
					//			getTranslation("PLG_MOVE_DOWN"),
								getTranslation("PLG_DELETE")
							)
						);


		$ObjectFactory->Reset();
		$ObjectFactory->AddFilter($filter);
		$ap->SetCountAllRows($DBBR->prebrojSveSlogove($ObjectFactory->createObject("PrGrupaProizvoda",-1), $ObjectFactory->filters));

		$ObjectFactory->AddLimit($ap->GetRowCount());
		$ObjectFactory->addOffset($ap->GetOffset());
		$ObjectFactory->ManageSort();

		$objlist = $ObjectFactory->createObjects("PrGrupaProizvoda", array("SfStatus","Template"));

		$ap->SetBrowseString($ObjectFactory);
		$ap->SetRecordCount(count($objlist));

		$ObjectFactory->ResetFilters();
		$ObjectFactory->ResetLimitOffset();

		//za slicice gore-dole
		$html_img_up = "<img border=0 src='images/arr_up.gif'>";
		$html_img_down = "<img border=0 src='images/arr_down.gif'>";
		$html_img_edit = "<div class='btn btn-white'><i class='fa fa-pencil-square-o'></i></div>";
		$html_img_delete = "<div class='btn btn-white'><i class='fa fa-trash'></i></div>";
		$html_img_copy = "<div class='btn btn-white'><i class='fa fa-clone' aria-hidden='true'></i></div>";

		$move=1;
		if(!empty($objlist))
		{
			foreach($objlist as $odo)
			{
				if ($odo->getParentID()!=NULL) {
					$parentGrpProizvoda = $ObjectFactory->createObject("PrGrupaProizvoda", $odo->getParentID());
					$naziv=$parentGrpProizvoda->getNaziv();
				}
				else {
					$naziv='';	
					$move=0;
				}	

				$modify_link = "<a class='naziv' id='".$odo->getGrupaProizvodaID()."' href='modify.php?".$odo->getLinkID()."' >".$html_img_edit."</a>";
				$delete_link = "<a href='delete_final.php?action=delete&".$odo->getLinkID()."' >".$html_img_delete."</a>";
				$move_up = "<a href='movegrp.php?direction=up&".$odo->getLinkID()."'>".$html_img_up."</a>";
				$move_down = "<a href='movegrp.php?direction=down&".$odo->getLinkID()."'>".$html_img_down."</a>";

				$ap->AddTableRow(
					array(
						$modify_link,
					//	$odo->getOpis(),
						$odo->getNaziv()."&nbsp;",
						$naziv."&nbsp;",
						$odo->Template->getTitle()."&nbsp;",
						$odo->SfStatus->getVrednost(),
					//	$move_up,
					//	$move_down,
						$delete_link));
			}
		}
		$ap->RegisterAdminPage($smarty);
		if($parentGrp->getNaziv() != "")
		{
			$smarty->assign("parentGrpProizvoda", $parentGrp->toArray());
			$smarty->assign("parentTitle", $parentGrp->getNaziv());
			$smarty->assign("modifyLink", "modify.php?grupaproizvodaid=".$parentGrp->getGrupaProizvodaID());
			$smarty->assign("insertLink", "parentid=".$parentGrp->getGrupaProizvodaID());
		}
		else
		{
			$smarty->assign("parentGrpProizvoda", $parentGrp->toArray());
			$smarty->assign("parentTitle", $parentGrp->getNaziv());
			$smarty->assign("modifyLink", "#");
			$smarty->assign("insertLink", "");
		}
		$smarty->assign("move", $move);

		$smarty->display('index.tpl');
	}
	else
	{
		// show error message not enough rights
		$smarty->assign("norights_message",getTranslation("PLG_NORIGHT_VIEW"));
		$smarty->display('../../../templates/norights.tpl');
	}
?>
