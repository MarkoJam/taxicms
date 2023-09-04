<?
	/* CMS Studio 3.0 insert_plugin.php */

	$_ADMINPAGES = true;
	include_once("../../../config.php");

	global $smary;
	global $auth;


		//insertovanje praznog sloga, umesto insert_pre.php
		if ($_REQUEST['mode']=='insert') 
		{
			require ("insert_pre.php");
			$obj = $ObjectFactory->createObject("Module");
			$colid=$DBBR->vratiPoslednjiID($obj);
			$col=$colid[0];
			$id=$colid[1];
			$_REQUEST[$col]=$_POST[$col]=$id;
		}
		if (isset($_REQUEST['module_id']) && isset($_REQUEST['conmodule_id']) && $_REQUEST['conmodule_id']>-1)
		{
			$modulemodule = $ObjectFactory->createObject("ModuleModule",-1);
			$modulemodule->ConModuleID = $_REQUEST['conmodule_id'];
			$modulemodule->ModuleID = $_REQUEST['module_id'];
			$DBBR->kreirajSlog($modulemodule);
			echo "<div class='success'>".getTranslation("PLG_ADD_SUCCESS")."</div>";	
		}
		else echo "<div class='error'>".getTranslation("PLG_CHANGE_FAILED")."</div>";
									

?>