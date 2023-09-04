<?
	/* CMS Studio 3.0 modify.php *///

	$_ADMINPAGES = true;
	include_once("../../../config.php");
		
	global $smarty;
	global $auth;
	

		if(isset($_REQUEST["invoiceid"]))
		{

			$invoice = $ObjectFactory->createObject("PrInvoice",$_REQUEST["invoiceid"]);
			$smarty->assign('invoice',$invoice->toArray());
			$user = $ObjectFactory->createObject("User",$invoice->getUserID());
			$smarty->assign('user',$user->toArray());
			
			
			$item_arr=array();
			$ObjectFactory->Reset();
			$ObjectFactory->AddFilter("invoiceid = " . $_REQUEST["invoiceid"]);			
			$items = $ObjectFactory->createObjects("PrInvoiceItem");
			$ObjectFactory->Reset();	
			foreach($items as $item)
			{
				$item_arr[]=$item->toArray();
			}		
			$smarty->assign('items',$item_arr);
			
			
			$smarty->display('invoice.tpl');
		}	


?>