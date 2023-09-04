<?
	/* CMS Studio 3.0 modify.php */
	$_ADMINPAGES = true;
	include_once("../../config.php");
		
	global $smarty;
	global $auth;
	
	if(isset($_REQUEST["mode"])) $_REQUEST["pluginid"]=-1;							
	if(isset($_REQUEST["pluginid"]))
	{
		// deo za insertovanje novog sloga
		if(isset($_REQUEST["mode"])) $smarty->assign("mode", 'insert');
		else $smarty->assign("mode", 'edit');
		
		$plugin = $ObjectFactory->createObject("Plugin",$_REQUEST["pluginid"]);
		$smarty->assign($plugin->toArray());
		
		$shTemplateBase = new SmartyHtmlSelection("templatebase",$smarty);
		
		$shTemplateBase->AddOutput("Admin & front"); $shTemplateBase->AddValue("adminfront");
		$shTemplateBase->AddOutput("Admin"); $shTemplateBase->AddValue("admin");
		$shTemplateBase->AddOutput("Front"); $shTemplateBase->AddValue("front");
		$shTemplateBase->AddSelected($plugin->TemplateBase);
		$shTemplateBase->SmartyAssign();
		
		
		// plugin modules
		$pluginmodules = $ObjectFactory->createObjects("SfPluginModule");
		
		$shPluginModule = new SmartyHtmlSelection("pluginmodule",$smarty);
		foreach ($pluginmodules as $sf) 
		{
			$shPluginModule->AddOutput($sf->getVrednost());
			$shPluginModule->AddValue($sf->getID());
		}
		$shPluginModule->AddSelected($plugin->SfPluginModule->getID());
		$shPluginModule->SmartyAssign();
		$ObjectFactory->ResetFilters();
		
		$shActive = new SmartyHtmlSelection("active", $smarty);
		
		$shActive->AddOutput("Da"); $shActive->AddValue("true");
		$shActive->AddOutput("Ne"); $shActive->AddValue("false");
		$shActive->AddSelected($plugin->Active);
		$shActive->SmartyAssign();
	}
	
	$smarty->display('modify.tpl');

?>