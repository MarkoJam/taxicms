<?
	/* CMS Studio 3.0 delete_final.php */

	$_ADMINPAGES = true;
	include_once("../config.php");
	
	global $smarty;
	global $auth;
	
	
	if(isset($_REQUEST['res_id']) && isset($_REQUEST['conres_id']))
	{
		$ObjectFactory->ResetFilters();
		$ObjectFactory->AddFilter(" res_id = " .$_REQUEST['res_id']. " AND conres_id = ".$_REQUEST['conres_id']);
		$resres = $ObjectFactory->createObjects("ResRes");
		$ObjectFactory->ResetFilters();
		foreach ($resres as $res)
		{
			$DBBR->obrisiSlog($res);	
			
		}				
		echo "<div class='success'>".getTranslation("PLG_DELETE_SUCCESS")."</div>";	
	}
	else echo "<div class='error'>".getTranslation("PLG_CHANGE_CONECTED_FAILED")."</div>";
	
?>