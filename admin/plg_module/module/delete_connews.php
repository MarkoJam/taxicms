<?
	/* CMS Studio 3.0 delete_final.php */

	$_ADMINPAGES = true;
	include_once("../../../config.php");
	
	global $smarty;
	global $auth;
	
	
	if(isset($_REQUEST['module_id']) && isset($_REQUEST['conmodule_id']))
	{
		$ObjectFactory->ResetFilters();
		$ObjectFactory->AddFilter(" module_id = " .$_REQUEST['module_id']. " AND conmodule_id = ".$_REQUEST['conmodule_id']);
		$modulemodule = $ObjectFactory->createObjects("ModuleModule");
		$ObjectFactory->ResetFilters();
		foreach ($modulemodule as $module)
		{
			$DBBR->obrisiSlog($module);	
			
		}				
		echo "<div class='success'>".getTranslation("PLG_DELETE_SUCCESS")."</div>";	
	}
	else echo "<div class='error'>".getTranslation("PLG_CHANGE_CONECTED_FAILED")."</div>";
	
?>