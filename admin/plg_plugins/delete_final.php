<?
	/* CMS Studio 3.0 delete_final.php */	
	$_ADMINPAGES = true;
	include_once("../../config.php");
	
	global $smary;
	global $auth;
	
	if(isset($_REQUEST["pluginid"]))
	{
		$plugin = $ObjectFactory->createObject("Plugin",$_REQUEST["pluginid"]);

		$DBBR->obrisiSlog($plugin);

		echo "<div class='success'>".getTranslation("PLG_DELETE_SUCCESS")."</div>";
	}
	else
	{
		echo "<div class='error'>".getTranslation("PLG_CHANGE_FAILED")."</div>";
	}
?>