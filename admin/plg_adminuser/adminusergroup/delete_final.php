<?
	/* CMS Studio 3.0 delete_final.php */
	
	$_ADMINPAGES = true;
	include_once("../../../config.php");
	
	global $smarty;
	global $auth;
	
	if($auth->isActionAllowed("ACTION_USER_DELETE"))
	{
		if(isset($_REQUEST["adminusergroupid"]))
		{
			$usergroup = $ObjectFactory->createObject("AdminUserGroup",$_REQUEST["adminusergroupid"]);
			$DBBR->obrisiSlog($usergroup);
					
			echo "<div class='success'>".getTranslation("PLG_DELETE_SUCCESS")."</div>";
		}
		else echo "<div class='error'>".getTranslation("PLG_CHANGE_FAILED")."</div>";
	}
	else echo "<div class='warning'>". getTranslation("PLG_NORIGHT")."</div>";
?>