<?
	$_ADMINPAGES = true;
	
	include_once("../../../config.php");
	$price2 = $ObjectFactory->createObject("PostPrice",-1);	
	$filters=array();
	$kr=$DBBR->prebrojSveSlogove($price2,$filters);
	

	
	$wt=0;
	$pr=0;
	for ($i = 1; $i <= $kr+1; $i++ )  
	{
		$bi=trim($i);
		$price2 = $ObjectFactory->createObject("PostPrice",$i);
		$price2->Price = $_REQUEST["postprice".$bi];
		if ($i>1) $price2->WeightFrom = $wt;
		else $price2->WeightFrom = 0;
		$price2->WeightTo = $_REQUEST["weightto".$bi];
		if (($price2->WeightFrom<$price2->WeightTo) && ($price2->WeightFrom==$wt) && ($price2->Price>$pr) )
		{
			$wt=$price2->WeightTo;
			$pr=$price2->Price;
			$DBBR->promeniSlog($price2);
			if ((($price2->WeightFrom+$price2->WeightTo)>0) && ($kr<$price2->PriceID) )
			{
				$DBBR->resetAI($price2,$kr);
				$DBBR->kreirajPrSlog($price2);
				$DBBR->promeniSlog($price2);
			}
		}
		elseif (($_REQUEST["weightfrom".$bi]+$_REQUEST["weightto".$bi])==0) 
		{
			$pb=$price2->PriceID;
			for ($i =$pb; $i <= $kr+1; $i++ )  
			{
				$price2 = $ObjectFactory->createObject("PostPrice",$i);
				$DBBR->obrisiSlog($price2);
			}
		}	
	}

	$price = $ObjectFactory->createObject("PrPrice",1);
	$price->PriceID = 1;
	$price->Price = $_REQUEST["price"];
	$DBBR->promeniSlog($price);
	echo "<div class='success'>".getTranslation("PLG_CHANGE_SUCCESS")."</div>";
?>