<?
	/* CMS Studio 2.0 korpa_edit.php */
	include_once("../../config.php");
	$lh = LanguageHelper::getInstance();
	$lang = $lh->GetLinkPluginType("language");
	$kpGrupaProizvodaTree = new KpGrupaProizvodaTree ();
	//$kpGrupaProizvodaTree->setPageId ( $getPageID () );
	$kpGrupaProizvodaTree->setLanguageHelper ( $LanguageHelper );


	if (isset($_REQUEST["proizvodid"])) {
		$pr=$_REQUEST["proizvodid"];
		$_SESSION[$lang]["korpa"][$pr]=0;
		unset($_SESSION[$lang]["korpa"][$pr]);
	}
	
	if(isset($_SESSION[$lang]["korpa"]) && count($_SESSION[$lang]["korpa"])!= 0) {

			$tezina = 0;
			$ukupna_cena = 0;
			$proizvodi_array = array();
			$postarine_array = array();
			foreach($_SESSION[$lang]["korpa"] as $p => $kolicina)
			{
				$pid=explode('-',$p);
				$p=$pid[0];
				$proiz = $ObjectFactory->createObject("PrProizvod",$p);
				$kurs =  $ObjectFactory->createObject("PrKurs",1);
				$proiz->setKurs ( $kurs->Kurs );
				$usertip = GetUserType();
				if ($usertip==1) {
					$proiz->setCenaA($proiz->getCenaAMP());
					$proiz->setCenaB($proiz->getCenaBMP());	
				}	
				else {	
					$proiz->setCenaA($proiz->getCenaA());
					$proiz->setCenaB($proiz->getCenaB());
				}
				$proiz->setKolicinaBasket($kolicina);
				

										
				//$popustuser=$GetPopust($proiz->getProizvodID(),$gpid);
				//$proiz->setPopust($popustuser);
				//$usertip = $GetUserType();
				//if ($usertip==1) $popustuser=0;
				//$fullPrice=$proiz->getCenaA();
				//$proiz->CenaA = $proiz->CenaA * (1-$popustuser/100);	
				
				//sifra bazicnog proizvoda
				$ObjectFactory->Reset();
				$ObjectFactory->AddFilter("vrsta=2 AND vproizvodid = ".$proiz->getProizvodID());		
				$bproizvodi = $ObjectFactory->createObjects("PrProizvodProiz");
				$ObjectFactory->Reset();
				if (count($bproizvodi)==1) {
					$proizvod2 = $ObjectFactory->createObject("PrProizvod",$bproizvodi[0]->getProizvodID());
					$bproizvodnaziv = $proizvod2->getNaziv();
					$bpid=$bproizvodi[0]->getProizvodID();
				}	

				// grupa proizvoda id
				$ObjectFactory->AddFilter("proizvodid = " . $bpid);
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
				
				$link = new LinkKpProductDetails ( $lh,$kpGrupaProizvodaTree, $proiz->getProizvodID(), $gpID, $bproizvodnaziv."-".$proiz->getNaziv(), null);
				$proiz->SetLink ( $lh->GetPrintLink ( $link ) );
				$proiz_arr=$proiz->toArray();

				$proiz_arr = array_merge($proiz_arr, array("bproizvodnaziv" => $bproizvodnaziv));
				$proiz_arr = array_merge($proiz_arr, array("punacena" => $fullPrice));
				
				//vadjenje velicine iz zbirne sifre
				//$pid=explode('-',$p);
				$size=$pid[1];
				$proiz_arr = array_merge($proiz_arr, array("velicina" => $size));
				
				
				$proizvodi_array[] = $proiz_arr;
				$ukupna_cena += $proiz->getMedjuzbirBasket();
				$tezina += $proiz->getTezina()*$kolicina;
			}
			//postarina
			/*$price =  $ObjectFactory->createObject("PrPrice",1);
			$limit=$price->getPrice();
			$price2 =  $ObjectFactory->createObjects("PostPrice");	
			$postarina=0;
			if ($ukupna_cena<$limit) {
				foreach($price2 as $pprice )
				{
					if (($pprice->getWeightFrom()<=$tezina) && ($pprice->getWeightTo()>$tezina)) $postarina=$pprice->getPrice()	;	
				}
			}*/	

			$postarina=10; //probno, dok se ne uvede shipping	
			
			global $smarty;
			// countries for shipping
			$countries = $ObjectFactory->createObjects("SfCountries");
			$shCountry = new SmartyHtmlSelection("country",$smarty);
				$shCountry ->AddOutput('Choose country');
				$shCountry ->AddValue(-1);			
			foreach ($countries as $c) 
			{
				$shCountry ->AddOutput($c->getCountryName());
				$shCountry ->AddValue($c->getCountryID());
			}
			/*if(isset($_SESSION['loged']) && $_SESSION['loged'] = "Yes" && isset($_SESSION['logeduserid']) && $_SESSION['logeduserid'] != "") $cid=$user->SfCountries->getCountryID();
			else $cid=-1;*/
			$cid=$_REQUEST['cid'];
			$shCountry->AddSelected($cid);
			$shCountry->SmartyAssign();
			$ObjectFactory->ResetFilters();	
			
			
			// link za editovanje korpe
			$linkBasketEdit = new LinkBasketEdit($lh);
			$basket_edit_link = $lh->GetPrintLink($linkBasketEdit);
			
			// link za pregled korpe pre checkouta - overview
			// link za editovanje korpe
			$linkBasketEdit = new LinkBasketEdit($lh);
			$basket_edit_link = $lh->GetPrintLink($linkBasketEdit);
			
			// link za pregled korpe pre checkouta - overview
			$linkShipment = new LinkShipment($lh, 2);
			$shipment_link = $lh->GetPrintLink($linkShipment);
			
			$user = $ObjectFactory->createObject("User",$_SESSION["logeduserid"],array('SfUserCategory'));				
			$catid = $user->SfUserCategory->getUserCategoryID(); 		

			//fiksiran order type
			$order_type=3; //placanje karticom

			$smarty->assign("basket_edit_link", $basket_edit_link);
			$smarty->assign("shipment_link", $shipment_link);
			$smarty->assign("proizvodi_basket", $proizvodi_array);
			$smarty->assign("ukupna_cena",$ukupna_cena);
			$smarty->assign("tezina",$tezina);
			$smarty->assign("limit",$limit);
			$smarty->assign("postarina",$postarina);
			$smarty->assign("usercat",$catid);
			$smarty->assign("usertip",$usertip);
			$smarty->assign("order_type",$order_type);
			$smarty->assign("empty_basket","false");
			$smarty->assign("message",$_REQUEST['message']);
	
	}
	else $smarty->assign("empty_basket","true");

	ob_start();
	$smarty->display("../../templates/order_basket.tpl");

	$output = ob_get_contents();
	ob_end_clean();
	
	echo $output;
	
	
	function GetUserType()
	{
		global $ObjectFactory;
		// default tip user-a koji ide svim user-ima koji nisu ulogovani
		$usertip = 1;
		// tip korisnika koji se cita iz logovanog korisnika
		if(isset($_SESSION["logeduserid"]))
		{
			$userid = $_SESSION["logeduserid"];
			$user = $ObjectFactory->createObject("User", $userid);
			$usertip = $user->SfUserType->getUserTypeID();
		}
		return $usertip;
	}
	
	function GetGP($pid)
	{
		global $ObjectFactory;
		// grupa proizvoda id
		$ObjectFactory->AddFilter("proizvodid = " . $pid);
		$proizGP = $ObjectFactory->createObjects ( "PrProizvodGrupaProiz");
		$ObjectFactory->ResetFilters();
		foreach ( $proizGP as $pgp ) 
		{
			$gpID=$pgp->getGrupaProizvodaID();
			$grupaProizvoda = $ObjectFactory->createObject ( "PrGrupaProizvoda", $gpID);
			if ($grupaProizvoda->getParentID()>0) $gpid=$pgp->getGrupaProizvodaID();
		}
		return $gpid;
	}	
?>