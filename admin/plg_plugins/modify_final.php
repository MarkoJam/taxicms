<?
	/* CMS Studio 3.0 modify_final.php */
	$_ADMINPAGES = true;
	include_once("../../config.php");
	//insertovanje praznog sloga, umesto insert_pre.php
	if ($_REQUEST['mode']=='insert') 
	{
		require ("insert_pre.php");
		$obj = $ObjectFactory->createObject("Plugin");
		$colid=$DBBR->vratiPoslednjiID($obj);
		$col=$colid[0];
		$id=$colid[1];
		$_REQUEST[$col]=$_POST[$col]=$id;
		$_REQUEST["pluginid"]=$id;
	}	
	if(isset($_REQUEST["pluginid"]))
	{
		$plugin = $ObjectFactory->createObject("Plugin",-1);
		$plugin->Plugin_POST($_REQUEST);
		
		$DBBR->promeniSlog($plugin);
		
		echo "<div class='success'>".getTranslation("PLG_CHANGE_SUCCESS")."</div>";
	}
	else 
	{
		echo "<div class='error'>".getTranslation("PLG_CHANGE_FAILED")."</div>";
	}
?>