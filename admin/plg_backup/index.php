<?
	/* CMS Studio 3.0 index.php */

	$_ADMINPAGES = true;
	include_once("../../config.php");

	if($auth->isActionAllowed("ACTION_BACKUP_VIEW"))
	{

		$ap = new AdminTable();
		$ap->SetOffsetName("offset_tmpl");
		$ap->SetTitle(getTranslation("PLG"));
		$ap->SetHeader(array(
								"<span class='promeni'>".getTranslation("PLG_NAME")."</span>",
								getTranslation("PLG_SIZE"),
								getTranslation("PLG_DATE"),
								getTranslation("PLG_DELETE")

	));
		$ap->SetCountAllRows($DBBR->prebrojSveSlogove($ObjectFactory->createObject("News",-1) , $ObjectFactory->filters));


		$file_list = scandir ("../backup/");

		$html_img_delete = "<div class='btn btn-white'><i class='fa fa-trash'></i></div>";

		$ap->SetCountAllRows(count($file_list));

		//ZA SADRZAJ TABELE
		for($i=2;$i<count($file_list);$i++)
		{
				$modify_link = "<a id='zip' href='backup/".$file_list[$i]."'>".$file_list[$i]."</a>";

				$delete_link = "<a href='delete_final.php?filename=".$file_list[$i]."' >".$html_img_delete."</a>";

				$ap->AddTableRow(array($modify_link,number_format(filesize("../backup/".$file_list[$i])/1000,2,".",",")." kb",date("d-m-Y",filectime("../backup/".$file_list[$i])),$delete_link ));
		}

		$ap->RegisterAdminPage($smarty);
		$smarty->display('index.tpl');
	}
	else
	{
		// show error message not enough rights
		$smarty->assign("norights_message",$LanguageArray["value"]["PLG_NORIGHT"]);
		$smarty->display('../../templates/norights.tpl');
	}
?>
