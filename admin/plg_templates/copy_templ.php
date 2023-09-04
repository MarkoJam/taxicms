<?  
	/* CMS Studio 3.1 insert_tmpl_pre.php */
	
	$_ADMINPAGES = true;
	include_once("../../config.php");

	global $smarty;
	global $auth;
	
	if(isset($_REQUEST['template_id']))
	{
		$templateId = $_REQUEST['template_id'];
		
		$tmpl = $ObjectFactory->createObject("Template", $templateId, array("Plugin"));
		
		$tmplCopy = $ObjectFactory->createObject("Template", -1);
		
		$tmplCopy->setTitle($tmpl->getTitle() . " - Copy");
		$tmplCopy->setDescription($tmpl->getDescription());

		$DBBR->kreirajSlog($tmplCopy);
		
		foreach($tmpl->Plugin as $p)
		{
			$plgtmpl = $ObjectFactory->createObject("PluginTemplate",-1);
			
			$plgtmpl->setPluginID($p->getPluginID());
			$plgtmpl->setTemplateID($tmplCopy->getTemplateID());
			$plgtmpl->setFileName($p->getFileName());
			$plgtmpl->setFilterID($p->getFilterID());
			$plgtmpl->setPosition($p->getPosition());
			
			$DBBR->kreirajSlog($plgtmpl);
		}
		echo "<div class='success'>".getTranslation("PLG_COPY_SUCCESS")."</div>";
	}
	else echo "<div class='error'>".getTranslation("PLG_COPY_FAILED")."</div>";

?>