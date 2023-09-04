<?
	/* CMS Studio 3.0 modify_tmpl_final.php */

	$_ADMINPAGES = true;
	include_once("../../config.php");

	global $smary;
	global $auth;

	if(isset($_REQUEST["tmplplgid"]) && isset($_REQUEST["pluginid"]))
	{
		//potrebno je izmeniti trenutno odabrani zapis iz tabele veza...
		$plgtmpl = $ObjectFactory->createObject("PluginTemplate",-1);//& new Plug_templ();
		
		$plgtmpl->PlgtemID = $_REQUEST['tmplplgid'];
		$plgtmpl->Plugin->PluginID = $_REQUEST['pluginid'];
		
		$plg = $ObjectFactory->createObject("Plugin",$plgtmpl->Plugin->PluginID);
				
		$plgtmpl->Template->TemplateID = $_REQUEST['template_id'];
		$plgtmpl->FileName = $plg->FileName;
		$plgtmpl->FilterID = $_REQUEST['selectionid'];
		$plgtmpl->Position = $_REQUEST['position'];
		$DBBR->promeniSlog($plgtmpl);
		echo "<div class='success'>".getTranslation("PLG_SUCCESS")."</div>";	
	}
	else 
	{
		echo "<div class='error'>".getTranslation("PLG_CHANGE_FAILED")."</div>";
	}	
	
?>