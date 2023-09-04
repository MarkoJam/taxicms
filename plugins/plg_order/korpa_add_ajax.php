<?
	/* CMS Studio 2.0 korpa_add_one.php */

	include_once("../../config.php");

	$LanguageHelper = LanguageHelper::getInstance();
	
	$lang = $LanguageHelper->GetLinkPluginType("language");
	
	$kpGrupaProizvodaTree = new KpGrupaProizvodaTree ();
	//$kpGrupaProizvodaTree->setPageId ( $this->getPageID () );
	$kpGrupaProizvodaTree->setLanguageHelper ( $LanguageHelper );
	

	$postoji = false;

	$flg_postoji = false;

	// dodavanje velicine u sifru proizvoda ako velicina postoji
	if (isset($_POST["size"])) $pr = $_REQUEST["proizvodid"]."-".$_POST["size"];
	else $pr = $_REQUEST["proizvodid"];
	if (isset($_POST["kolicina"])) $kol= $_POST["kolicina"];
	else $kol=1;
	
	if(isset($_SESSION[$lang]["korpa"]) && count($_SESSION[$lang]["korpa"])>0)
	{
		$basketCount = 0;
		foreach($_SESSION[$lang]["korpa"] as $proiz => $kolicina)
		{
			if($proiz == $pr){
				$flg_postoji = true;
				break;
			}
			$basketCount = $basketCount + $kolicina;
		}
	}
	if($flg_postoji)$_SESSION[$lang]["korpa"][$pr] = $kolicina + $kol;
	else $_SESSION[$lang]["korpa"][$pr]= $kol;
	$basketCount = $basketCount + $kol;


	$linkProdcutBasket = new LinkProductBasket($LanguageHelper, TEMPLATE_SHOPPING_CART);
	$basketLink = $LanguageHelper->getPrintLink($linkProdcutBasket);

	$basketCount=0;
	foreach($_SESSION[$lang]["korpa"] as $p => $kolicina)
	{
		$proiz = $ObjectFactory->createObject("PrProizvod",$p);

		$proiz->setKolicinaBasket($kolicina);
		$basketCount = $basketCount + $kolicina;
		$ObjectFactory->AddFilter("proizvodid = " . $proiz->getProizvodID());
		$proizGP = $ObjectFactory->createObjects ( "PrProizvodGrupaProiz");
		$ObjectFactory->ResetFilters();
		foreach ( $proizGP as $pgp ) 
		{
			$gpID=$pgp->getGrupaProizvodaID();
			$grupaProizvoda = $ObjectFactory->createObject ( "PrGrupaProizvoda", $gpID);
			// Sledeci blok uzima TemplateID i ID Grupe proizvoda samo ako je grupa proizvoda u drugom nivou tj. dete.
			// Tada je parentID veci od nule. Tako dobijamo pravu grupu proizvoda a ne izvedenu grupu npr. "katalog", "izdvajamo iz ponude" i sl.
			if ($grupaProizvoda->getParentID()>0) $tid=$grupaProizvoda->getTemplateID();
			if ($grupaProizvoda->getParentID()>0) $gpid=$pgp->getGrupaProizvodaID();
			// kraj bloka
		}

		$link = new LinkKpProductDetails ( $lh,$kpGrupaProizvodaTree, $tid, $proiz->getProizvodID(), $gpid, 'w', $proiz->getNaziv());
		$proiz->SetLink ( $lh->GetPrintLink ( $link ) );
		
		$proiz_arr = $proiz->toArray();
		
		//sifra bazicnog proizvoda
		$ObjectFactory->Reset();
		$ObjectFactory->AddFilter("vrsta=2 AND vproizvodid = ".$proiz->getProizvodID());		
		$bproizvodi = $ObjectFactory->createObjects("PrProizvodProiz");
		$ObjectFactory->Reset();
		if (count($bproizvodi)==1) {
			$proizvod2 = $ObjectFactory->createObject("PrProizvod",$bproizvodi[0]->getProizvodID());
			$bproizvodnaziv = $proizvod2->getNaziv();
		}
		$proiz_arr = array_merge($proiz_arr, array("bproizvodnaziv" => $bproizvodnaziv));

		//vadjenje velicine iz zbirne sifre
		$pid=explode('-',$p);
		$size=$pid[1];
		$proiz_arr = array_merge($proiz_arr, array("velicina" => $size));
		
		$ukupna_cena += $proiz->getMedjuzbirBasket();
		$proizvodi_array[] = $proiz_arr;
	}
	
	

	
	$smarty->assign("proizvodi_basket", $proizvodi_array);
	$smarty->assign("ukupna_cena",$ukupna_cena);
	$smarty->assign("empty_basket","false");
	
	$smarty->assign("data", array("basketLink" => $basketLink, "basketCount" => $basketCount, "EMPTY" => true));	
	$smarty->assign("orderstatus","process");
	
	ob_start();
	$smarty->display("../../templates/products/productcart_default.tpl");
	$output = ob_get_contents();
	ob_end_clean();
	
	echo $output;
	
?>