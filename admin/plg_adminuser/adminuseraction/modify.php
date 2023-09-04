<?
	/* CMS Studio 3.0 modify.php */
	
	$_ADMINPAGES = true;
	include_once("../../../config.php");
		
	global $smarty;
	global $auth;
	
	if($auth->isActionAllowed("ACTION_USERACTIONS_MODIFY"))
	{
		if(isset($_REQUEST["mode"])) $_REQUEST["adminuseractionid"]=-1;				
		if(isset($_REQUEST["adminuseractionid"]))
		{
			// deo za insertovanje novog sloga
			if(isset($_REQUEST["mode"])) $smarty->assign("mode", 'insert');
			else $smarty->assign("mode", 'edit');
			
			$useraction = $ObjectFactory->createObject("AdminUserAction",$_REQUEST["adminuseractionid"]);
			$smarty->assign($useraction->toArray());
			
			// punjenje combobox-a sa dostupnim pluginovima
			$plugins_arr = $ObjectFactory->createObjects("Plugin");
			
			$shPlugins = new SmartyHtmlSelection("plugins", $smarty);
			if(count($plugins_arr)>0)
			{
				foreach ($plugins_arr as $plugin)
				{
					$shPlugins->AddOutput($plugin->Title);
					$shPlugins->AddValue($plugin->PluginID);
				}
				$shPlugins->AddSelected($useraction->Plugin->PluginID);
			}
			$shPlugins->SmartyAssign();
			
		}
		
		$smarty->display('modify.tpl');
	}
	else 
	{
		// show error message not enough rights
		$smarty->assign("norights_message",getTranslation("PLG_NORIGHT"));
		$smarty->display('../../../templates/norights.tpl');	
	}

?>