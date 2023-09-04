<?
	/* CMS Studio 3.0 delete_final.php */
	
	$_ADMINPAGES = true;
	include_once("../../../config.php");
	
	global $auth;
	global $smarty;

	if($auth->isActionAllowed("ACTION_ADMIN_DELETE"))
	{
		if(isset($_REQUEST["apage_id"]))
		{
			$apg = $ObjectFactory->createObject("AdminPage",$_REQUEST["apage_id"]);
			$DBBR->obrisiSlog($apg);
			
			echo "<div class='success'>".getTranslation("PLG_DELETE_SUCCESS")."</div>";
		}
		else
		{
			echo "<div class='error'>".getTranslation("PLG_CHANGE_FAILED")."</div>";
		}
	}
	else 
	{
		echo "<div class='warning'>". getTranslation("PLG_NORIGHT")."</div>";
	}
?>