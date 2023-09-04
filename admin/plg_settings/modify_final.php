<?
	/* CMS Studio 3.0 index.php */
	
	$_ADMINPAGES = true;	
	include_once("../../config.php");

	global $smarty;
	global $auth;
	global $LanguageArray;

	if($auth->isActionAllowed("ACTION_SETTINGS_MODIFY"))
	{
		if(isset($_REQUEST["pluginmoduleid"]))
		{
			foreach ($_REQUEST as $key => $value)
			{
				if(!(strpos($key,"VALUE_") === FALSE))
				{
					// it is settings
					$setting_name = substr($key,strlen("VALUE_"));
					
					$ObjectFactory->ResetFilters();
					$ObjectFactory->AddFilter("name='".$setting_name."'");
					$settings = $ObjectFactory->createObjects("Setting");
					if(count($settings) == 1)
					{
						$settings[0]->setValue($value);
						$DBBR->promeniSlog($settings[0]);
					}
				}
			}
			echo "<div class='success'>".getTranslation("PLG_CHANGE_SUCCESS")."</div>";
		}
		else echo "<div class='error'>".getTranslation("PLG_CHANGE_FAILED")."</div>";
	}
	else echo "<div class='warning'>".getTranslation("PLG_CHANGE_FAILED")."</div>";


	
?>
