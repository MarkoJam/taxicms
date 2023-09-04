<?
	$_ADMINPAGES = true;
	include_once("../../../config.php");
		
	$price = $ObjectFactory->createObject("PrPrice",-1);
	$price->PriceID = $_REQUEST["priceid"];
	$price->Price = $_REQUEST["price"];

	$DBBR->promeniSlog($price);
?>