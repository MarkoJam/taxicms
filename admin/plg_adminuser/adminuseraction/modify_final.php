<?
	/* CMS Studio 3.0 modify_final.php */

	$_ADMINPAGES = true;
	include_once("../../../config.php");
		
	global $smarty;
	global $auth;
	
	if($auth->isActionAllowed("ACTION_USERACTIONS_MODIFY"))
	{
		//insertovanje praznog sloga, umesto insert_pre.php
		if ($_REQUEST['mode']=='insert') 
		{
			require ("insert_pre.php");
			$obj = $ObjectFactory->createObject("AdminUserAction");
			$colid=$DBBR->vratiPoslednjiID($obj);
			$col=$colid[0];
			$id=$colid[1];
			$_REQUEST[$col]=$_POST[$col]=$id;
			$_REQUEST["adminuseractionid"]=$id;
		}		
		if(isset($_REQUEST["adminuseractionid"]))
		{
			$useraction = $ObjectFactory->createObject("AdminUserAction",-1);
			$useraction->AdminUserAction_POST($_REQUEST);
			$DBBR->promeniSlog($useraction);

			echo "<div class='success'>".getTranslation("PLG_CHANGE_SUCCESS")."</div>";
		}
		else echo "<div class='error'>".getTranslation("PLG_CHANGE_FAILED")."</div>";
	}
	else echo "<div class='warning'>".getTranslation("PLG_NORIGHT")."</div>";
?>