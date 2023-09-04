<?
	/* CMS Studio 3.0 modify_final.php */
	
	$_ADMINPAGES = true;
	include_once("../../../config.php");

	global $smarty;
	global $auth;

	if($auth->isActionAllowed("ACTION_INVOICE_MODIFY"))
	{
		//insertovanje praznog sloga, umesto insert_pre.php
		if ($_REQUEST['mode']=='insert') 
		{
			require ("insert_pre.php");
			$obj = $ObjectFactory->createObject("PrInvoice");
			$colid=$DBBR->vratiPoslednjiID($obj);
			$col=$colid[0];
			$id=$colid[1];
			$_REQUEST[$col]=$_POST[$col]=$id;
		}		
		if(isset($_REQUEST["invoiceid"]))
		{
			$invoice = $ObjectFactory->createObject("PrInvoice",$_REQUEST["invoiceid"]);
			$invoice->PrInvoice_POST($_POST);
			$invoice->SfStatus->setStatusID($_REQUEST["statusid"]);
			$invoice->User->setUserID($_REQUEST["userid"]);
			$datum=explode('.',$_REQUEST['datum']);
			if (count($datum)==3) $invoice->setDate(mktime (0,0,0,$datum[1],$datum[0],$datum[2]));
			
			$ObjectFactory->Reset();
			$ObjectFactory->AddFilter("invoiceid = '" . $_REQUEST["invoiceid"]."'");
			$items = $ObjectFactory->createObjects("PrInvoiceItem");
			$ObjectFactory->Reset();
			$suma=0;
			foreach($items as $item) 
			{
				$suma = $suma+$item->getAmount();
			}
			$invoice->setAmount($suma);
			$DBBR->promeniSlog($invoice);
			
			echo "<div class='success'>".getTranslation("PLG_CHANGE_SUCCESS")."</div>";
		}
		else echo "<div class='error'>".getTranslation("PLG_CHANGE_FAILED")."</div>";
	}
	else echo "<div class='warning'>".getTranslation("PLG_NORIGHT")."</div>";
?>