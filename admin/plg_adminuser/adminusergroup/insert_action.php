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
		if(isset($_REQUEST["adminuseractionid"]))
		{
			$userGroupAction = $ObjectFactory->createObject("AdminUserGroupAction",-1);
			$userGroupAction->AdminUserActionID = $_REQUEST["adminuseractionid"];
			$userGroupAction->AdminUserGroupID = $_REQUEST["adminusergroupid"];
			
			$DBBR->kreirajSlog($userGroupAction);
			
			echo "<div class='success'>".getTranslation("PLG_ADD_SUCCESS")."</div>";
		}
		else echo "<div class='error'>".getTranslation("PLG_CHANGE_FAILED")."</div>";
	}
	else echo "<div class='warning'>".getTranslation("PLG_NORIGHT_ACTIONADD")."</div>";
	
?>