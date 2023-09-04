<?
	/* CMS Studio 3.0 delete_final.php */

	$_ADMINPAGES = true;
	include_once("../../../config.php");
	
	global $smarty;
	global $auth;
	
	if($auth->isActionAllowed("ACTION_INVOICE_DELETE"))
	{
		if(isset($_REQUEST["invoiceid"]))
		{
			$invoice = $ObjectFactory->createObject("PrInvoice",$_REQUEST["invoiceid"],"PrInvoiceItem");
			
			foreach ($invoice->PrInvoiceItem as $oi) 
			{
				$DBBR->obrisiSlog($oi);
			}
			$DBBR->obrisiSlog($invoice);
			echo "<div class='success'>".getTranslation("PLG_DELETE_SUCCESS")."</div>";
		}
		else echo "<div class='error'>".getTranslation("PLG_CHANGE_FAILED")."</div>";
	}
	else echo "<div class='warning'>". getTranslation("PLG_NORIGHT")."</div>";
?>