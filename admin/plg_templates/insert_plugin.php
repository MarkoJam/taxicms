<?
	/* CMS Studio 3.0 insert_plugin.php */

	$_ADMINPAGES = true;
	include_once("../../config.php");

	global $smary;
	global $auth;

	if($auth->isActionAllowed("ACTION_PLUGINADD"))
	{
		//insertovanje praznog sloga, umesto insert_pre.php
		if ($_REQUEST['mode']=='insert') 
		{
			require ("insert_pre.php");
			$obj = $ObjectFactory->createObject("Template");
			$colid=$DBBR->vratiPoslednjiID($obj);
			$col=$colid[0];
			$id=$colid[1];
			$_REQUEST[$col]=$_POST[$col]=$id;
		}
		//potrebno je u vezu izmedju template-a i pluginova ubaciti nov unos...
		$plgtmpl = $ObjectFactory->createObject("PluginTemplate",-1);
		$plgtmpl->Plugin->PluginID = $_REQUEST['pluginid1'];
		
		$plg = $ObjectFactory->createObject("Plugin",$plgtmpl->Plugin->PluginID);
		$plgtmpl->Template->TemplateID = $_REQUEST['template_id'];
		$plgtmpl->FileName = $plg->FileName;
		$plgtmpl->FilterID = -1;

		$DBBR->kreirajSlog($plgtmpl);
		echo "<div class='success'>".getTranslation("PLG_ADD_SUCCESS")."</div>";	
	}
	else 
	{
		echo "<div class='warning'>".getTranslation("PLG_NORIGHT")."</div>";
	}
											

?>