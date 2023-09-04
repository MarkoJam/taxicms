<?
	/* CMS Studio 3.0 delete_final.php */

	$_ADMINPAGES = true;
	include_once("../../../config.php");
	
	global $smarty;
	global $auth;
	
	
	if(isset($_REQUEST['proizvodid']) && isset($_REQUEST['vproizvodid']))
	{
		$ObjectFactory->ResetFilters();
		$ObjectFactory->AddFilter("proizvodid = ".$_REQUEST['proizvodid']." AND vproizvodid = ".$_REQUEST['vproizvodid']);
		$prpr = $ObjectFactory->createObjects("PrProizvodProiz");
		$ObjectFactory->ResetFilters();
		foreach ($prpr as $proiz)
		{
			$DBBR->obrisiSlog($proiz);	
		}				
		echo "<div class='success'>".getTranslation("PLG_DELETE_SUCCESS")."</div>";	
	}
	else echo "<div class='error'>".getTranslation("PLG_CHANGE_CONECTED_FAILED")."</div>";
	
?>