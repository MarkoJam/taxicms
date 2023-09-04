<?
	/* CMS Studio 3.0 delete_final.php */
	
	$_ADMINPAGES = true;
	include_once("../../../config.php");
	
	global $smarty;
	global $auth;
	
	if($auth->isActionAllowed("ACTION_USERACTIONS_DELETE"))
	{
		if(isset($_REQUEST["adminuseractionid"]))
		{
			$useraction = $ObjectFactory->createObject("AdminUserAction",$_REQUEST["adminuseractionid"]);
			$DBBR->obrisiSlog($useraction);
					
			echo "<div class='success'>".getTranslation("PLG_DELETE_SUCCESS")."</div>";
		}
		else echo "<div class='error'>".getTranslation("PLG_CHANGE_FAILED")."</div>";
	}
	else echo "<div class='warning'>". getTranslation("PLG_NORIGHT")."</div>";
?>