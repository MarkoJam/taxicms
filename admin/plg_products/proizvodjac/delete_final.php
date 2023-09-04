<?
	/* CMS Studio 3.0 delete_final.php */
	
	$_ADMINPAGES = true;
	include_once("../../../config.php");
	
	global $smarty;
	global $auth;
	
	$ObjectFactory = ObjectFactory::getInstance();
	
	if($auth->isActionAllowed("ACTION_PRODUCTDELETE"))
	{
		if(isset($_REQUEST["proizvodjacid"]))
		{
			$proizvodjac = $ObjectFactory->createObject("PrProizvodjac",$_REQUEST["proizvodjacid"]);
			
			// nadji sve proizvode kod kojih treba azurirati proizvodjaca koji se brise
			$ObjectFactory->AddFilter("proizvodjacid=".$_REQUEST["proizvodjacid"]);
			$proizvodi = $ObjectFactory->createObjects("PrProizvod");
			$ObjectFactory->ResetFilters();
			
			foreach ($proizvodi as $proiz) 
			{
				$proiz->setPrProizvodjac(-1);
				$DBBR->promeniSlog($proiz);
			}
	
			$DBBR->obrisiSlog($proizvodjac);
					
			echo "<div class='success'>".getTranslation("PLG_DELETE_SUCCESS")."</div>";
		}
		else echo "<div class='error'>".getTranslation("PLG_CHANGE_FAILED")."</div>";
	}
	else echo "<div class='warning'>". getTranslation("PLG_NORIGHT")."</div>";
		
?>