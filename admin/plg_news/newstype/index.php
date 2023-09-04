<?
	/* CMS Studio 3.0 index.php */

	$_ADMINPAGES = true;
	include_once("../../../config.php");
	
	global $smarty;
	global $auth;
	global $LanguageArray;

	if($auth->isActionAllowed("ACTION_NEWS_TYPE_VIEW"))
	{
		// kreiram administracionu tabelu
		$ap = new AdminTable();
		//$ap->SetTitle("Azuriranje kategorija vesti:");
		$ap->SetHeader(array(
								$LanguageArray["value"]["PLG_NAME"],
								$LanguageArray["value"]["PLG_DESCRIPTION"],
								$LanguageArray["value"]["PLG_DELETE"]
			));
		$ap->SetOffsetName("offset_newstype");
		$ap->SetCountAllRows($DBBR->prebrojSveSlogove($ObjectFactory->createObject("NewsType",-1), $ObjectFactory->filters));
			
		$ObjectFactory->AddLimit($ap->GetRowCount()); 
		$ObjectFactory->AddOffset($ap->GetOffset());	
		
		$objlist = $ObjectFactory->createObjects("NewsType");
		
		$ap->SetBrowseString($ObjectFactory);
		
		$ap->SetRecordCount(count($objlist));
		
		$ObjectFactory->ResetFilters();
		$ObjectFactory->ResetLimitOffset();

		$html_img_delete = "<div class='btn btn-white'><i class='fa fa-trash'></i></div>";
		
		//ZA SADRZAJ TABELE
		foreach($objlist as $nwType)
		{	
			// security check for modify action
			if($auth->isActionAllowed("ACTION_NEWS_TYPE_MODIFY"))
			{
				$modify_link = "<a class='naziv' href='modify.php?news_type_id=".$nwType->getNewsTypeID()."'>".$nwType->getTitle()."</a>";				
			}
			else
			{
				$modify_link = $nwType->getTitle();
			}
			// security check for delete action
			if($auth->isActionAllowed("ACTION_NEWS_TYPE_DELETE"))
			{
				$delete_link = "<a href='delete_final.php?news_type_id=".$nwType->getNewsTypeID()."'>".$html_img_delete."</a>";
			}

			
			$ap->AddTableRow(array($modify_link, $nwType->getDescription(), $delete_link,));
		}
		$ap->RegisterAdminPage($smarty);
		
		$smarty->display('index.tpl');
	}
	else 
	{
		// show error message not enough rights
		$smarty->assign("norights_message",$LanguageArray["value"]["PLG_NORIGHT"]);
		$smarty->display('../../../templates/norights.tpl');
	}

?>