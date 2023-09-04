<?
	/* CMS Studio 3.0 index.php */

	$_ADMINPAGES = true;
	include_once("../../../config.php");

	global $smarty;
	global $auth;

	$ObjectFactory = ObjectFactory::getInstance();

	if($auth->isActionAllowed("ACTION_PRODUCTMANUFACTURER_VIEW"))
	{
		$ap = new AdminTable();
		$ap->SetTitle(getTranslation("PLG_MAINTITLE"));
		$ap->SetHeader(array
						(
							"<span class='promeni'>".getTranslation("PLG_CHANGE")."</span>",
							SortLink::generateLink(getTranslation("PLG_NAME"),"naziv"),
							SortLink::generateLink(getTranslation("PLG_DESCRIPTION"),"opis"),
							getTranslation("PLG_DELETE")
						));

		$ap->SetOffsetName("offset_prproizvodjaci");
		$ap->SetCountAllRows($DBBR->prebrojSveSlogove($ObjectFactory->createObject("PrProizvodjac",-1), $ObjectFactory->filters));

		$ObjectFactory->AddLimit($ap->GetRowCount());
		$ObjectFactory->AddOffset($ap->GetOffset());
		$ObjectFactory->ManageSort();

		$objlist = $ObjectFactory->createObjects("PrProizvodjac");

		$ap->SetBrowseString($ObjectFactory);
		$ap->SetRecordCount(count($objlist));

		//za slicice gore-dole
		$html_img_up = "<img border=0 src='images/arr_up.gif'>";
		$html_img_down = "<img border=0 src='images/arr_down.gif'>";
		$html_img_edit = "<div class='btn btn-white'><i class='fa fa-pencil-square-o'></i></div>";
		$html_img_delete = "<div class='btn btn-white'><i class='fa fa-trash'></i></div>";

		//ZA SADRZAJ TABELE
		if(!empty($objlist))
		{
			foreach($objlist as $odo)
			{
				$modify_link = "<a class='naziv' href='modify.php?".$odo->getLinkID()."' >".$html_img_edit."</a>";
				$delete_link = "<a href='delete_final.php?action=delete&".$odo->getLinkID()."'>".$html_img_delete."</a>";

				$ap->AddTableRow(array($modify_link, $odo->getNaziv(), $odo->getOpis(), $delete_link));
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
