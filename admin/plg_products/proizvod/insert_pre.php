<?  
	/* CMS Studio 3.0 inser_pre.php */
	
	$_ADMINPAGES = true;
	include_once("../../../config.php");

	global $smarty;
	global $auth;

	$ObjectFactory = ObjectFactory::getInstance();

	if($auth->isActionAllowed("ACTION_PRODUCT_CREATE"))
	{
	
		$proizvod = $ObjectFactory->createObject("PrProizvod",-1);
		
		// default vrednosti 
		$proizvod->setNaziv("Naziv proizvoda");
		$proizvod->setKratakOpis("<p>Opis proizvoda</p>");
		
		//na osnovu izbora tipa proizvoda dodeljujemo mu ID
		$proizvod->PrTipProizvoda->TipProizvodaID = $_REQUEST["tipproizvodaid"];
		$proizvod->SfStatus->setStatusID(STATUS_PROIZVODA_AKTIVAN);
		$maxorder = $DBBR->vratiMaxPoUslovu($proizvod);
		$proizvod->Order = $maxorder;
		$DBBR->kreirajSlog($proizvod); 
	}	
	
?>