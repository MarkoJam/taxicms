<? 
	/* CMS Studio 3.0 delete_final.php */
	$_ADMINPAGES = true;
	
	include_once("../../../config.php");
		
	global $smarty;
	global $auth;
		
	if($auth->isActionAllowed("ACTION_MODULE_DELETE"))
	{
		if(isset($_REQUEST["module_id"]))
		{
			//trazim stranicu samo da bi uzeo njen parent_id
			$nw = $ObjectFactory->createObject("Module",-1);
			$nw->setModuleID($_REQUEST["module_id"]);
			$DBBR->obrisiSlog($nw);
		
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