<?
	/* CMS Studio 3.0 modify_cena_final.php */
	
	$_ADMINPAGES = true;
	include_once("../../../config.php");
	
	global $auth;
	
	$ObjectFactory = ObjectFactory::getInstance();
	$LanguageHelper = LanguageHelper::getInstance();
	if($auth->isActionAllowed("ACTION_PRODUCT_MODIFY"))
	{
		if(isset($_REQUEST["proizvodid"]) && isset($_REQUEST["value"]))
		{
			$proizvodid = $_REQUEST["proizvodid"];
			$tezina = $_REQUEST["value"];
			$proiz = $ObjectFactory->createObject("PrProizvod",$proizvodid);
			$proiz->setTezina($tezina);
			
			$DBBR->promeniSlog($proiz);
	
			echo $proiz->getTezina();
			return;
		}
		else
		{
			echo "Greska!";
			return;
		}
	}
	else
	{
		echo "Greska!";
		return;
	}	
?>