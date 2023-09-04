<?
	/* CMS Studio 3.0 index.php */
	
	$_ADMINPAGES = true;	
	include_once("../../config.php");

	global $smarty;
	global $auth;
	global $LanguageArray;


	// default view for settings
	if($auth->isActionAllowed("ACTION_VIEW"))
	{
		
		// prepare settings
		if(isset($_REQUEST["id"]))
		{
			$currentPluginModule = $_REQUEST["id"];
		}
		
		$ObjectFactory->ResetFilters();
		$ObjectFactory->SetSortBy("setting_cover_id, `order`", "asc");
		$ObjectFactory->AddFilter("plugin_module_id=".$currentPluginModule);
		$settings = $ObjectFactory->createObjects("Setting",array("SfSettingGroup"));
		
		$settingsSmarty = array();
		$settingTypesForCombo = array();
		if(!empty($settings))
		{
			foreach ($settings as $setting)
			{
				if($setting->SfSettingType->getSettingTypeID() != -1)
				{
					$ObjectFactory->ResetFilters();
					$ObjectFactory->ResetSortBy();
					$ObjectFactory->AddFilter("setting_type_id=".$setting->SfSettingType->getSettingTypeID());
					$settingValues = $ObjectFactory->createObjects("SfSettingTypeValues");
					$out  = "";
					foreach ($settingValues as $val)
					{
						$selected = "";
						if($setting->getValue() == $val->getSettingTypeValuesID())
						{
							$selected = "selected";
						}
						$out .= "<option ".$selected." value='".$val->getSettingTypeValuesID()."'>".$val->getValue()."</option>";
					}
					
					$settingsSmarty[$setting->SfSettingCover->getSettingCoverID()][] = array_merge( $setting->toArray(),
																									array(
																										"output" => $out, 
																										"ctrltype" => "combobox"
																										)
																									);
				}
				else
				{
					$settingsSmarty[$setting->SfSettingCover->getSettingCoverID()][] = array_merge( $setting->toArray(),
																									array(	
																										"output" => $setting->getValue(),
																										"ctrltype" => "input")
																									);
				}
				
			}
			$smarty->assign("setting",$settingsSmarty);
		}
		
		// prepare needed combos
		
		foreach ($settingTypesForCombo as $typeForCombo)
		{
			$ShGeneric = new SmartyHtmlSelection("comboType".$typeForCombo, $smarty);
			$ObjectFactory->ResetFilters();
			$ObjectFactory->ResetSortBy();
			$ObjectFactory->AddFilter("setting_type_id=".$typeForCombo);
			$settingValues = $ObjectFactory->createObjects("SfSettingTypeValues");
			foreach ($settingValues as $val)
			{
				$ShGeneric->AddOutput($val->getValue());
				$ShGeneric->AddValue($val->getSettingTypeValueID());
			}
			
		}
		
		$ObjectFactory->ResetFilters();
		$ObjectFactory->ResetSortBy();
		$settingCoverings = $ObjectFactory->createObjects("SfSettingCover");
		
		$settingCoveringSmarty = array();
		if(!empty($settingCoverings))
		{
			foreach ($settingCoverings as $cover)
			{
				$settingCoveringSmarty[] = $cover->toArray();
			}
			$smarty->assign("settingCovering",$settingCoveringSmarty);
		}
		
		
		$smarty->assign("pluginmoduleid",$currentPluginModule);		
		$smarty->display('modify.tpl');
	}
	else 
	{
		// show error message not enough rights
		$smarty->assign("norights_message",getTranslation("PLG_NORIGHT"));
		$smarty->display('../../templates/norights.tpl');	
	}
	

	
?>
