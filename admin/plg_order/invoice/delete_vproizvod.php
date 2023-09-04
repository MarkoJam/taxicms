<?
	/* CMS Studio 3.0 delete_final.php */

	$_ADMINPAGES = true;
	include_once("../../../config.php");
	
	global $smarty;
	global $auth;
	
	
	if(isset($_REQUEST['invoiceid']) && isset($_REQUEST['proizvodid']))
	{
		$ObjectFactory->ResetFilters();
		$ObjectFactory->AddFilter("invoiceid = ".$_REQUEST['invoiceid']." AND proizvodid = ".$_REQUEST['proizvodid']);
		$prpr = $ObjectFactory->createObjects("PrInvoiceItem");
		$ObjectFactory->ResetFilters();
		foreach ($prpr as $proiz)
		{
			$DBBR->obrisiSlog($proiz);	
		}				
		echo "<div class='success'>".getTranslation("PLG_DELETE_SUCCESS")."</div>";	
	}
	else echo "<div class='error'>".getTranslation("PLG_CHANGE_CONECTED_FAILED")."</div>";
	
?>