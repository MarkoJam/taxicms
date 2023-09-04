<?
	/* CMS Studio 3.0 index.php */
	
	$_ADMINPAGES = true;	
	include_once("../../config.php");

	global $smarty;
	global $auth;
	global $LanguageArray;
	if($auth->isActionAllowed("ACTION_SETTINGS_VIEW"))
	{
		$ap = new AdminTable();
		$ap->SetOffsetName("offset_links");
		$ap->SetTitle("Parametri sistema:");
		$ap->SetHeader(
						array(	
							getTranslation("PLG_CHANGE"),							
							SortLink::generateLink(getTranslation("PLG_NAME"),"vrednost"),
								)
						);

		$ap->SetCountAllRows($DBBR->prebrojSveSlogove($ObjectFactory->createObject("SfPluginModule",-1),$ObjectFactory->filters));
		
		$ObjectFactory->AddLimit($ap->GetRowCount()); 
		$ObjectFactory->AddOffset($ap->GetOffset());
		$ObjectFactory->ManageSort();
		
		$objlist = $ObjectFactory->createObjects("SfPluginModule");
		
		$ap->SetBrowseString($ObjectFactory);
		$ap->SetRecordCount(count($objlist));
		
		$ObjectFactory->ResetFilters();
		$ObjectFactory->ResetLimitOffset();
		
		$html_img_edit = "<div class='btn btn-white'><i class='fa fa-pencil-square-o'></i></div>";
		$html_img_delete = "<div class='btn btn-white'><i class='fa fa-trash'></i></div>";

		//ZA SADRZAJ TABELE
		if(!empty($objlist))
		$plugins = $ObjectFactory->createObjects("Plugin");			
		foreach($objlist as $odo)
		{	
			if(isModuleActive($odo, $plugins))
			{
				if($auth->isActionAllowed("ACTION_SETTINGS_MODIFY"))
				{
					$modify_link = "<a class='naziv' href='modify.php?".$odo->getLinkID()."'>".$html_img_edit."</a>";
				}
				else 
				{
					$modify_link = $html_img_edit;
				}		
				$ap->AddTableRow(array($modify_link, $odo->Vrednost ));
			}
		}
		$ap->RegisterAdminPage($smarty);

		$smarty->display('index.tpl');
	}
	else 
	{
		// show error message not enough rights
		$smarty->assign("norights_message",getTranslation("PLG_SETTINGS_NORIGHT_VIEW"));
		$smarty->display('../../templates/norights.tpl');	
	}

	function isModuleActive($pluginmodule, $plugins)
	{
		foreach ($plugins as $plugin)
		{
			if(	$pluginmodule->getID() == $plugin->SfPluginModule->getID()
				&& $plugin->Active == "true")
			{
				return TRUE;
			}
		}
		
		return FALSE;
	}	
?>