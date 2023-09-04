<? 
	/* CMS Studio 3.0 insert_pre.php */
	$_ADMINPAGES = true;
	
	include_once("../../../config.php");
		
	global $smarty;
	global $auth;

	if($auth->isActionAllowed("ACTION_INVOICE_CREATE"))
	{
		$inv = $ObjectFactory->createObject("PrInvoice",-1);
		$DBBR->kreirajSlog($inv);
	}

	
	
?>