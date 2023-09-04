<?
	/* CMS Studio 3.0 index.php */

	$_ADMINPAGES = true;
	include_once("../../../config.php");	

	global $smarty;
	global $auth;

	$subsite = $ObjectFactory->createObject("SubSite", $_SESSION["subsiteid"]);
	if($auth->isActionAllowed("ACTION_LABELS_VIEW"))
	{
		// kreiram administracionu tabelu
		$ap = new AdminTable();
		$ap->SetOffsetName("offset_labels");
		$ap->SetTitle(getTranslation("PLG_LABELS_MAINTITLE"));
		if($subsite->getIsDefault() == 1)
		{	
			$ap->SetHeader(array
								(
								SortLink::generateLink(getTranslation("PLG_NAME"),"name"),
								SortLink::generateLink(getTranslation("PLG_CONTENT"),"content"),
								getTranslation("PLG_DELETE"),
							));
		}	
		else
		{
			$ap->SetHeader(array
								(
								SortLink::generateLink(getTranslation("PLG_NAME"),"name"),
								SortLink::generateLink(getTranslation("PLG_CONTENT"),"content"),
								SortLink::generateLink(getTranslation("PLG_TRANSLATE"),"translate"),
							));			
		}		
		$ap->SetCountAllRows($DBBR->prebrojSveSlogove($ObjectFactory->createObject("Labels",-1), $ObjectFactory->filters));
		$ObjectFactory->AddLimit($ap->GetRowCount()); 
		$ObjectFactory->AddOffset($ap->GetOffset());
		$ObjectFactory->ManageSort();
		
		$objlist = $ObjectFactory->createObjects("Labels");

		$ap->SetBrowseString($ObjectFactory);
		$ap->SetRecordCount(count($objlist));
		/*if($subsite->getIsDefault() == 1) $ap->SetRowCount(25);
		else $ap->SetRowCount(35);*/
		$ap->SetRowCount(30);

		$ObjectFactory->ResetFilters();
		$ObjectFactory->ResetLimitOffset();
		
		//ZA SADRZAJ TABELE
		if(!empty($objlist))
		{
			foreach($objlist as $ank)
			{
				$delete_link = "<a href='delete_final.php?id=".$ank->ID."' >".$html_img_delete."</a>";
				$content_editbox = "<div class='edit-content' id='".$ank->getID()."'>".$ank->getContent()."</div>";
				$translate_editbox = "<div class='edit-translate' id='".$ank->getID()."'>".$ank->getTranslate()."</div>";

				if($subsite->getIsDefault() == 1) $ap->AddTableRow(array($ank->Name, $content_editbox,  $delete_link ));
				else $ap->AddTableRow(array($ank->Name, $ank->Content, $translate_editbox));
			}
		}
		$ap->RegisterAdminPage($smarty);
		if (file_exists('templates/index.tpl')) $smarty->display('index.tpl');
		else $smarty->display('../../../templates/index1.tpl');

	}
	else
	{
		// show error message not enough rights
		$smarty->assign("norights_message",getTranslation("PLG_NORIGHT"));
		$smarty->display('../../templates/norights.tpl');
	}	
?>