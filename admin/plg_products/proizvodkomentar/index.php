<?
	/* CMS Studio 3.0 index.php */
	
	$_ADMINPAGES = true;
	include_once("../../../config.php");
		
	global $smarty;
	global $auth;
		
	$ObjectFactory = ObjectFactory::getInstance();
	
	if($auth->isActionAllowed("ACTION_PRODUCTCOMMENT_VIEW"))
	{
		$ap = new AdminTable();
		$ap->SetTitle(getTranslation("PLG_PRODUCT_COMMENT_MAINTITLE"));

		$comboFilterProizvod = new ProizvodFilter($ObjectFactory,$ap);
		$comboFilterProizvod->generateProccessComboBox();

		$comboFilterStatus= new ProizvodKomentarStatusFilter($ObjectFactory,$ap);
		$comboFilterStatus->generateProccessComboBox();

		$ap->SetHeader(array
						(
							SortLink::generateLink(getTranslation("PLG_PRODUCT_COMMENT_HEADER_TITLE"),"naslov"),
							SortLink::generateLink(getTranslation("PLG_PRODUCT_COMMENT_HEADER_PRODUCT"),"proizvodid")."<br/>".$comboFilterProizvod->getComboBox(),
							SortLink::generateLink(getTranslation("PLG_PRODUCT_COMMENT_HEADER_USER"),"ime_prezime"),
							SortLink::generateLink(getTranslation("PLG_PRODUCT_COMMENT_HEADER_STATUS"),"status_id")."<br/>".$comboFilterStatus->getComboBox(),
							getTranslation("PLG_PRODUCT_COMMENT_HEADER_ACTIVATE"),
							getTranslation("PLG_PRODUCT_COMMENT_HEADER_DELETE")
						));
		
		$ap->SetOffsetName("offset_prproizvodkomentar");
		$ap->SetCountAllRows($DBBR->prebrojSveSlogove($ObjectFactory->createObject("PrProizvodKomentar",-1), $ObjectFactory->filters));
		$ObjectFactory->AddLimit($ap->GetRowCount()); 
		$ObjectFactory->AddOffset($ap->GetOffset());
		$ObjectFactory->ManageSort();

		$objlist = $ObjectFactory->createObjects("PrProizvodKomentar", array("PrProizvod", "SfStatus"));
		$ap->SetBrowseString($ObjectFactory);
		$ap->SetRecordCount(count($objlist));

		//ZA SADRZAJ TABELE
		if(!empty($objlist))
		{
			foreach($objlist as $odo)
			{	
				$modify_link = "<a class='naziv' href='modify.php?".$odo->getLinkID()."' onclick=\"return confirmLink(this, '".getTranslation("PLG_PRODUCT_COMMENT_CHANGEQUESTION")."')\" >".$odo->getNaslov()."</a>";
				$delete_link = "<a href='delete_final.php?action=delete&".$odo->getLinkID()."' onclick=\"return confirmLink(this, '".getTranslation("PLG_PRODUCT_COMMENT_DELETEQUESTION")."')\" ><img border=0 src='../../images/delete.gif'></a>";
				
				if($odo->getSfStatusID() == STATUS_KOMENTAR_PROIZVODA_NEAKTIVAN)
				{
					$activate_link = "<a href='activate_final.php?".$odo->getLinkID()."' >". getTranslation("PLG_PRODUCT_COMMENT_HEADER_ACTIVATE"). "</a>";
				}
				else 
				{
					$activate_link = "<a href='deactivate_final.php?".$odo->getLinkID()."' >". getTranslation("PLG_PRODUCT_COMMENT_HEADER_DEACTIVATE"). "</a>";
				}
				
				$ap->AddTableRow(array($modify_link, $odo->PrProizvod->getNaziv() ,$odo->getImePrezime(), $odo->getSfStatus(), $activate_link, $delete_link));
			}
		}
		$ap->RegisterAdminPage($smarty);
		$smarty->display('index.tpl');
		
	}
	else 
	{
		// show error message not enough rights
		$smarty->assign("norights_message",getTranslation("PLG_PRODUCT_COMMENT_NORIGHT_VIEW"));
		$smarty->display('../../../templates/norights.tpl');
	}
?>