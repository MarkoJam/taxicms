<?
	/* CMS Studio 3.0 delete_final.php */

	$_ADMINPAGES = true;
	include_once("../../config.php");
	
	global $smarty;
	global $auth;
	
	if($auth->isActionAllowed("ACTION_PLUGINDELETE"))
	{
		$tmpl = $ObjectFactory->createObject("Template",-1);
		$tmpl->Template_POST($_REQUEST);
		$DBBR->promeniSlog($tmpl);
		
		if(isset($_REQUEST['tmplplgid']))
		{
			//potrebno je obrisati unos u tabeli veza izmedju pluginova i template-a
			$plgtmpl = $ObjectFactory->createObject("PluginTemplate",-1);
			$plgtmpl->PlgtemID = $_REQUEST['tmplplgid'];
			
			$DBBR->obrisiSlog($plgtmpl);	
			echo "<div class='success'>".getTranslation("PLG_DELETE_SUCCESS")."</div>";	
		}
		else echo "<div class='error'>".getTranslation("PLG_CHANGE_FAILED")."</div>";
	}
	else echo "<div class='warning'>". getTranslation("PLG_NORIGHT")."</div>";
	
?>