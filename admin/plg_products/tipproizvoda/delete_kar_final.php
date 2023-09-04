<?
	/* CMS Studio 3.0 delete_kar_final.php */
	
	//brise samo selektovanu karakteristiku kategorije
	$_ADMINPAGES = true;
	include_once("../../../config.php");

	global $smarty;
	global $auth;

	$ObjectFactory = ObjectFactory::getInstance();
	
	if($auth->isActionAllowed("ACTION_PRODUCTTYPE_DELETE"))
	{
		
		if(isset($_REQUEST["karakteristikaid"]))
		{
			//u slucaju da zelimo samo da brisemo karakteristike trebalo bi da azuriramo promenjena
			// polja kategorije
			if(isset($_REQUEST["deletekarakt"]))
			{
				$tipproizvoda = $ObjectFactory->createObject("PrTipProizvoda",-1);
				$tipproizvoda->PrTipProizvoda_POST($_REQUEST);
				$DBBR->promeniSlog($tipproizvoda);
			}
			
			$karakteristika = $ObjectFactory->createObject("PrKarakteristika",-1);
			$karakteristika->KarakteristikaID = $_REQUEST["karakteristikaid"];
			
			// pre nego sto se obrise sama karakteristika moramo obrisati 
			// sve veze koje postoje izmedju te karakteristike i proizvoda
			$karakteristikaproizvoda = $ObjectFactory->createObject("PrKarakteristikaProizvoda",-1);
			$niz_karakteristikaproizvoda = array();
			
			$DBBR->vratiSveSlogove($karakteristikaproizvoda,$niz_karakteristikaproizvoda,"*"," AND ".$karakteristika->getLinkID());
			
			foreach ($niz_karakteristikaproizvoda as $kp ) 
			{
				$DBBR->obrisiSlog($kp);
			}
			
			$DBBR->obrisiSlog($karakteristika);
			echo "<div class='success'>". getTranslation("PLG_DELETE_SUCCESS")."</div>";	
		}
		else echo "<div class='error'>". getTranslation("PLG_CHANGE_FAILED")."</div>";	
		
	}
	else echo "<div class='warning'>". getTranslation("PLG_NORIGHT")."</div>";

?>