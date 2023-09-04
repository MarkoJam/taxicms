<?
	/* CMS Studio 3.0 modify_cena_final.php */
	
	$_ADMINPAGES = true;
	include_once("../../../config.php");
	
	global $auth;
	
	$ObjectFactory = ObjectFactory::getInstance();
	$LanguageHelper = LanguageHelper::getInstance();
		//print_r($_REQUEST);
	//15700
	if($auth->isActionAllowed("ACTION_PRODUCT_MODIFY"))
	{
		if(isset($_REQUEST["proizvodid"]) && isset($_REQUEST["value"]))
		{
			$proizvodid = $_REQUEST["proizvodid"];
			$cenaamp = $_REQUEST["value"];
			$proiz = $ObjectFactory->createObject("PrProizvod",$proizvodid);
			$proiz->setCenaAMP($cenaamp);
			
			$DBBR->promeniSlog($proiz);
	
			echo $proiz->getCenaAMP();
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