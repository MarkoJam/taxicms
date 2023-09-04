<?
	/* CMS Studio 3.0 delete_final.php */	

	$_ADMINPAGES = true;
	include_once("../../../config.php");
	
	global $smarty;
	global $auth;
	global $LanguageArray;
	
	$ObjectFactory = ObjectFactory::getInstance();
	
	if($auth->isActionAllowed("ACTION_SPAGE_DELETE"))
	{
		if(isset($_REQUEST["spage_id"]))
		{
			// trazim stranicu samo da bi uzeo njen parent_id
			$statpg = $ObjectFactory->createObject("StaticPage",-1);
			$statpg->setSPageID($_REQUEST["spage_id"]);
			
			$DBBR->obrisiSlog($statpg);
		
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