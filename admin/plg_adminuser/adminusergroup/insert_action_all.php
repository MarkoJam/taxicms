<?
	/* CMS Studio 3.0 modify_final.php */
	
	$_ADMINPAGES = true;
	include_once("../../../config.php");
	
	global $smarty;
	global $auth;
	global $LanguageArray;
	
	if($auth->isActionAllowed("ACTION_USER_MODIFY"))
	{
		//insertovanje praznog sloga, umesto insert_pre.php
		if ($_REQUEST['mode']=='insert') 
		{
			require ("insert_pre.php");
			$obj = $ObjectFactory->createObject("AdminUserGroup");
			$colid=$DBBR->vratiPoslednjiID($obj);
			$col=$colid[0];
			$id=$colid[1];
			$_REQUEST[$col]=$_POST[$col]=$id;
			$_REQUEST["adminusergroupid"]=$id;			
		}
		$useraction_arr = $ObjectFactory->createObjects("AdminUserAction",array("Plugin"));			
		foreach ($useraction_arr as $useraction)
		{
			if($useraction->Plugin->Active == "true")
			{
				$userGroupAction = $ObjectFactory->createObject("AdminUserGroupAction",-1);
				$userGroupAction->AdminUserActionID = $useraction->AdminUserActionID;
				$userGroupAction->AdminUserGroupID = $_REQUEST["adminusergroupid"];
			
				$DBBR->obrisiSlog($userGroupAction);
				$DBBR->kreirajSlog($userGroupAction);
			}
		}
		echo "<div class='success'>".getTranslation("PLG_ADD_ALL_SUCCESS")."</div>";
	}
	else echo "<div class='warning'>".getTranslation("PLG_NORIGHT")."</div>";
	
?>