<?
	/* CMS Studio 3.0 delete_action.php */
	
	$_ADMINPAGES = true;
	include_once("../../../config.php");
	
	global $smarty;
	global $auth;
	
	if($auth->isActionAllowed("ACTION_USERACTION_REMOVE"))
	{
		if(isset($_REQUEST["adminusergroupid"]) && isset($_REQUEST["adminuseractionid"]))
		{
			$userGroupAction = $ObjectFactory->createObject("AdminUserGroupAction",$_REQUEST["adminuseractionid"]);
			$userGroupAction->AdminUserActionID = $_REQUEST["adminuseractionid"];
			$userGroupAction->AdminUserGroupID = $_REQUEST["adminusergroupid"];
			$DBBR->obrisiSlog($userGroupAction);		
			echo "<div class='success'>".getTranslation("PLG_DELETE_SUCCESS")."</div>";
		}
		else echo "<div class='error'>".getTranslation("PLG_CHANGE_FAILED")."</div>";
	}
	else echo "<div class='warning'>".getTranslation("PLG_NORIGHT")."</div>";

?>