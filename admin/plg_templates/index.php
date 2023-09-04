<?
	/* CMS Studio 3.0 index.php */

	$_ADMINPAGES = true;
	include_once("../../config.php");

	global $smarty;
	global $auth;

	$ObjectFactory = ObjectFactory::getInstance();

	if($auth->isActionAllowed("ACTION_TEMPLATES_VIEW"))
	{
		$ap = new AdminTable();
		// da li se aktivira settings za excel
		if($CMSSetting->getSettingByID(SETTING_EXCEL_EXPORT_TEMPLATE) == SETTING_TYPE_ON)
		{
			$ap->ShowExportLinks();
		}
		$ap->SetOffsetName("offset_tmpl");
		$ap->SetTitle("Promena templejta:");
		$ap->SetHeader(array(
							"<span class='promeni'>".getTranslation("PLG_CHANGE")."</span>",	
							SortLink::generateLink(getTranslation("PLG_NAME"),"title"),
							SortLink::generateLink(getTranslation("PLG_DESCRIPTION"),"description"),
							getTranslation("PLG_COPY"),
							getTranslation("PLG_DELETE"))
						);

		$ap->SetCountAllRows($DBBR->prebrojSveSlogove($ObjectFactory->createObject("Template",-1), $ObjectFactory->filters));

		$ObjectFactory->AddLimit($ap->GetRowCount());
		$ObjectFactory->AddOffset($ap->GetOffset());
		$ObjectFactory->ManageSort();

		$objlist = $ObjectFactory->createObjects("Template");

		$ap->SetBrowseString($ObjectFactory);
		$ap->SetRecordCount(countObject($objlist));

		$ObjectFactory->ResetFilters();
		$ObjectFactory->ResetLimitOffset();

		$html_img_edit = "<div class='btn btn-white'><i class='fa fa-pencil-square-o'></i></div>";
		$html_img_delete = "<div class='btn btn-white'><i class='fa fa-trash'></i></div>";
		$html_img_copy = "<div class='btn btn-white'><i class='fa fa-clone' aria-hidden='true'></i></div>";

		//ZA SADRZAJ TABELE
		foreach($objlist as $tm)
		{
			if($tm->TemplateID <> TEMPLATE_STANDARD )
			{
				if($auth->isActionAllowed("ACTION_TEMPLATES_MODIFY"))
				{
					$modify_link = "<a class='naziv' href='modify.php?template_id=".$tm->TemplateID."'>".$html_img_edit."</a>";
				}
				else
				{
					$modify_link = $html_img_edit;
				}

				if($tm->TemplateID >20)
				{
					if($auth->isActionAllowed("ACTION_TEMPLATES_DELETE"))
					{
						$delete_link = "<a href='delete_final.php?action=delete&template_id=".$tm->TemplateID."'>".$html_img_delete."</a>";
					}
					else
					{
						$delete_link = $html_img_delete;
					}
				}
				else
				{
					$delete_link ="&nbsp;";
				}

				$copy_link = "<a href='copy_templ.php?template_id=".$tm->TemplateID."' >".$html_img_copy."</a>";
			}
			else
			{
				$modify_link = "&nbsp;";
				$delete_link ="&nbsp;";
				$copy_link = "&nbsp;";
			}

			$ap->AddTableRow(array($modify_link,$tm->Title, $tm->Description, $copy_link, $delete_link ));
		}

		$ap->RegisterAdminPage($smarty);
		$smarty->display('index.tpl');
	}
	else
	{
		// show error message not enough rights
		$smarty->assign("norights_message",getTranslation("PLG_TEMPLATES_NORIGHT_VIEW"));
		$smarty->display('../../templates/norights.tpl');
	}
?>
