<?
	/* CMS Studio 3.0 delete_final.php */
	
	$_ADMINPAGES = true;
	include_once("../../../config.php");
	
	global $smarty;
	global $auth;
	
	$ObjectFactory = ObjectFactory::getInstance();
	
	if($auth->isActionAllowed("ACTION_PRODUCTTYPE_DELETE"))
	{
		if(isset($_REQUEST["tipproizvodaid"]))
		{
			$tipproizvoda = $ObjectFactory->createObject("PrTipProizvoda",-1);
			$tipproizvoda->PrTipProizvoda_POST($_POST);
		
			$DBBR->promeniSlog($tipproizvoda);
		
			$tipproizvoda = $ObjectFactory->createObject("PrTipProizvoda",$_REQUEST["tipproizvodaid"]);
			
			// ako obrisemo tip proizvoda neophodno je pobrisati
			// sve unose vezane za selektovan tip proizvoda u veznoj tabeli TipProizvodaGrupeTipovaProizvoda
			$tipproizvodagrupatipovaproiz = $ObjectFactory->createObject("PrTipProizvodaGrupaTipovaProiz",-1);
			$niz_tipproizvodagrupatipovaproiz = array();
			$DBBR->vratiSveSlogove($tipproizvodagrupatipovaproiz,$niz_tipproizvodagrupatipovaproiz,"*"," AND ".$tipproizvoda->getLinkID());
			
			foreach ($niz_tipproizvodagrupatipovaproiz as $tippg)
			{
				$DBBR->obrisiSlog($tippg);
			}
			
			$ObjectFactory->ResetFilters();
			$ObjectFactory->ResetLimitOffset();
			$ObjectFactory->AddFilter("tipproizvodaid=".$_REQUEST["tipproizvodaid"]);
			$proizvodi = $ObjectFactory->createObjects("PrProizvod");
	
			foreach ($proizvodi as $p)
			{
				$DBBR->obrisiSlog($p);
			}
			
			$DBBR->obrisiSlog($tipproizvoda);
			
			echo "<div class='success'>".getTranslation("PLG_DELETE_SUCCESS")."</div>";
		}
		else
		{
			echo "<div class='error'>".getTranslation("PLG_CHANGE_FAILED")."</div>";
		}
	}
	else
	{
		echo "<div class='warning'>". getTranslation("PLG_NORIGHT")."</div>";
	}
?>