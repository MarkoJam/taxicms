<?
	/* CMS Studio 3.0 insert_plugin.php */

	$_ADMINPAGES = true;
	include_once("../../../config.php");

	global $smary;
	global $auth;


		//insertovanje praznog sloga, umesto insert_pre.php
		if ($_REQUEST['mode']=='insert') 
		{
			//require ("insert_pre.php");
			$obj = $ObjectFactory->createObject("PrInvoice");
			$id=$DBBR->vratiPoslednjiAI($obj);
			$_REQUEST['invoiceid']=$id;
		}
		if (isset($_REQUEST['invoiceid']) && isset($_REQUEST['proizvodid']))
		{
			$prpr = $ObjectFactory->createObject("PrInvoiceItem",-1);
			$prpr->setProizvodID($_REQUEST['proizvodid']);
			$prpr->setInvoiceID($_REQUEST['invoiceid']);
			$proizvod = $ObjectFactory->createObject("PrProizvod",$_REQUEST['proizvodid']);
			$prpr->setProductCode($proizvod->getSifra());
			$prpr->setProductName($proizvod->getNaziv());			
			
			$prpr->Quantity = 0;
			$DBBR->kreirajSlog($prpr);
			echo $proizvod->getCenaA();			
			//echo "<div class='success'>".getTranslation("PLG_ADD_SUCCESS")."</div>";	
		}
		//else echo "<div class='error'>".getTranslation("PLG_CHANGE_CONECTED_FAILED")."</div>";
									

?>