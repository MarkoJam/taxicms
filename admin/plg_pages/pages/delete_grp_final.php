<?
	/* CMS Studio 3.0 delete_grp_final.php */
	
	$_ADMINPAGES = true;
	include_once("../../../config.php");
	
	global $smarty;
	global $auth;
	global $LanguageArray;
		
	if($auth->isActionAllowed("ACTION_PAGE_DELETE"))
	{
		//session_start();
		if(isset($_REQUEST["page_id"]))
		{
			// trazim stranicu samo da bi uzeo njen parent_id
			$pg = $ObjectFactory->createObject("Page",-1);
			$pg->setPageID($_REQUEST["page_id"]);
			$DBBR->nadjiSlogVratiGa($pg);
			$parent_id = $pg->getParentID();
			
			$tr = new TreeMenu();
			$tr->DeleteSubTree($_REQUEST["page_id"]);
			//unistiti sesiju vezanu za trenutnu stranicu koju brisemo!
			unset($_SESSION["pageoffset".$_REQUEST["page_id"]]);
			
			echo "<div class='success'>".getTranslation("PLG_DELETE_SUCCESS")."</div>";
		}
		else echo "<div class='error'>".getTranslation("PLG_CHANGE_FAILED")."</div>";
	}
	else 
	{
		echo "<div class='warning'>". getTranslation("PLG_NORIGHT")."</div>";
	}
?>