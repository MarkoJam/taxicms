<?
	/* CMS Studio 2.0 index.php */
	$_ADMINPAGES = true;
	include_once("../../../config.php");
	
	global $smarty;
	global $auth;	
	$postarine_array = array();
	$ObjectFactory = ObjectFactory::getInstance();
	$price = $ObjectFactory->createObject("PostPrice",1);
	$DBBR = DatabaseBroker::getInstance();
	$DBBR->vratiSveSlogove($price,$postarine_array);
	$smarty->display('index_header.tpl');	
	$kr=-1;
	foreach($postarine_array as $kr => $postid )
		{
		$bkr=trim($kr+1);	
		$price = $ObjectFactory->createObject("PostPrice",$kr+1);
		$smarty->assign("npp","postprice".$bkr);
		$smarty->assign("wf","weightfrom".$bkr);
		$smarty->assign("wt","weightto".$bkr);
		$smarty->assign("pi","postid".$bkr);
		$smarty->assign("postprice",$price->Price);
		$smarty->assign("weightfrom",$price->WeightFrom);
		$smarty->assign("weightto",$price->WeightTo);
		$smarty->assign("priceid",$price->PriceID);
		$smarty->assign("kr",$kr);	
		if(isset($_REQUEST["message"])) $smarty->assign("message",$_REQUEST["message"]);
		$smarty->display('index_detail.tpl');	
		}
		
		$bkr=trim($kr+2);	
		$price = $ObjectFactory->createObject("PostPrice",$kr+2);
		$smarty->assign("npp","postprice".$bkr);
		$smarty->assign("wf","weightfrom".$bkr);
		$smarty->assign("wt","weightto".$bkr);
		$smarty->assign("pi","postid".$bkr);
		$smarty->assign("postprice",0);
		$smarty->assign("weightfrom",0);
		$smarty->assign("weightto",0);
		$smarty->assign("priceid",$kr+2);
		if(isset($_REQUEST["message"])) $smarty->assign("message",$_REQUEST["message"]);
		
		$price3 = $ObjectFactory->createObject("PrPrice",1);
		$smarty->assign("price",$price3->Price);
		$smarty->assign("priceid2",$price3->PriceID);
		if(isset($_REQUEST["message"])) $smarty->assign("message",$_REQUEST["message"]);
		
		$smarty->display('index_footer.tpl');

	
	
	
?>