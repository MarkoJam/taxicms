<?
	/* CMS Studio 3.0 delete_final.php */

	$_ADMINPAGES = true;
	include_once("../../../config.php");
	
	global $smarty;
	global $auth;
	
	
	if ($_REQUEST['mode']=='insert') 
	{
		//require ("insert_pre.php");
		$obj = $ObjectFactory->createObject("PrInvoice");
		$id=$DBBR->vratiPoslednjiAI($obj);
		$_REQUEST['proizvodid']=$id;
	}	
	
	if(isset($_REQUEST['invoiceid']) && isset($_REQUEST['proizvodid']))
	{
		$ObjectFactory->ResetFilters();
		$ObjectFactory->AddFilter("invoiceid = ".$_REQUEST['invoiceid']." AND proizvodid = ".$_REQUEST['proizvodid']);
		$prpr = $ObjectFactory->createObjects("PrInvoiceItem");
		$ObjectFactory->ResetFilters();
		foreach ($prpr as $proiz)
		{			
			$proiz->setQuantity($_REQUEST['kolicina']);
			$proizvod = $ObjectFactory->createObject("PrProizvod",$_REQUEST['proizvodid']);
			$proiz->setPrice($proizvod->CenaA());
			$proiz->setAmount($proizvod->getCenaA()*$_REQUEST['kolicina']);
			
			$DBBR->promeniSlog($proiz);	
		}				
		//echo "<div class='success'>".getTranslation("PLG_CHANGE_SUCCESS")."</div>";	
	}
	//else echo "<div class='error'>".getTranslation("PLG_CHANGE_FAILED")."</div>";
	
?>