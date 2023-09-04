<?
	/* CMS Studio 3.0 index.php */

	$_ADMINPAGES = true;
	include_once("../../config.php");

	global $smarty;
	global $auth;

	$ObjectFactory = ObjectFactory::getInstance();
	
	if($auth->isActionAllowed("ACTION_TEMPLATES_VIEW"))
	{
		$pts = $ObjectFactory->createObjects("PluginTemplate");
		foreach($pts as $pt)
		{
			$id=$pt->getTemplateID();
			$ObjectFactory->ResetFilters();
			$ObjectFactory->AddFilter("template_id=" . $id);
			$temps=$ObjectFactory->createObjects("Template");
			if (count($temps)==0) $DBBR->obrisiSlog($pt);
			else {
				$id=$pt->getPluginID();
				$ObjectFactory->ResetFilters();
				$ObjectFactory->AddFilter("plugin_id=" . $id);
				$plgs=$ObjectFactory->createObjects("Plugin");
				if (count($plgs)==0) $DBBR->obrisiSlog($pt);
			}
		}
		$objlist = $ObjectFactory->createObjects("Template");	
		foreach($objlist as $tm)
		{
			
		}
		echo "<div class='success'>".getTranslation("PLG_CHANGE_SUCCESS")."</div>";
	}
?>