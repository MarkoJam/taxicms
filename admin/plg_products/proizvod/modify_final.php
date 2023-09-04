<?
	/* CMS Studio 3.0 modify_final.php */
	
	$_ADMINPAGES = true;
	include_once("../../../config.php");
	
	global $smarty;
	global $auth;

	$ObjectFactory = ObjectFactory::getInstance();
	
	if($auth->isActionAllowed("ACTION_PRODUCT_MODIFY"))
	{
		//insertovanje praznog sloga, umesto insert_pre.php
		if ($_REQUEST['mode']=='insert') 
		{
			echo "<div class='success'>okk</div>";

			require ("insert_pre.php");
			$obj = $ObjectFactory->createObject("PrProizvod");
			$colid=$DBBR->vratiPoslednjiID($obj);
			$col=$colid[0];
			$id=$colid[1];
			$_REQUEST[$col]=$_POST[$col]=$id;
		}			
		if(isset($_REQUEST["proizvodid"]))
		{
			$proiz = $ObjectFactory->createObject("PrProizvod",-1);
			$proiz->PrProizvod_POST($_POST);
			
			$proiz->Datum = time();//mktime($_REQUEST["dateHours"],$_REQUEST["dateMinutes"],0,$_REQUEST["dateMonth"],$_REQUEST["dateDay"],$_REQUEST["dateYear"]);

			$tmp_html_page = htmlspecialchars($_POST["opis"] , ENT_QUOTES);
			$tmp_htmlsmall_page = htmlspecialchars($_POST["kratak_opis"] , ENT_QUOTES);
			$tmp_header = htmlspecialchars($_POST["naziv"] , ENT_QUOTES);    
			
			// correct letter Š š
			$tmp_html_page = str_replace("&amp;Scaron;","Š",$tmp_html_page);
			$tmp_html_page = str_replace("&amp;scaron;","š",$tmp_html_page);
			
			$tmp_htmlsmall_page = str_replace("&amp;Scaron;","Š",$tmp_htmlsmall_page);
			$tmp_htmlsmall_page = str_replace("&amp;scaron;","š",$tmp_htmlsmall_page);
			
			// snimanje promene unosa
			$proiz->setKratakOpis($tmp_htmlsmall_page);
			$proiz->setOpis($tmp_html_page);
			$proiz->setNaziv($tmp_header);

			
			if ($_REQUEST["cenaa"]==0) $proiz->CenaA=$_REQUEST["cenaamp"];
			if ($_REQUEST["cenab"]==0) $proiz->CenaB=$_REQUEST["cenabmp"];
			if ($_REQUEST["cenaamp"]==0) $proiz->CenaAMP=$_REQUEST["cenaa"];
			if ($_REQUEST["cenabmp"]==0) $proiz->CenaBMP=$_REQUEST["cenab"];

			
			if(isset($_REQUEST["kategorijaid"]))
			{
				$kategorijeids = $_POST["kategorijaid"];
				if(count($kategorijeids) > 0)
				{
					//iz vezne tabele brisemo sva pojavljivanja kategorija za dati proizvod
					$proizvodkategorija = $ObjectFactory->createObject("PrProizvodKategorija",-1);
					$proizvodkategorija->ProizvodID = $proiz->ProizvodID;
					$DBBR->obrisiSlogove($proizvodkategorija);
			
					foreach ($kategorijeids as $kategid) {
						$proizvodkategorija->ProizvodID = $proiz->ProizvodID;
						$proizvodkategorija->KategorijaID= $kategid;	
						$DBBR->kreirajSlog($proizvodkategorija);
					}
				}
			}
			else 
			{
				// SHIT KOD
				//iz vezne tabele brisemo sva pojavljivanja kategorija za dati proizvod
				$proizvodkategorija = $ObjectFactory->createObject("PrProizvodKategorija",-1);
				$proizvodkategorija->ProizvodID = $proiz->ProizvodID;
				$DBBR->obrisiSlogove($proizvodkategorija);
			}
			
			if(isset($_REQUEST["grupaproizvodaid"]))
			{
				$grupaproizvodaids = $_POST["grupaproizvodaid"];
				if(count($grupaproizvodaids) > 0)
				{
					//iz vezne tabele brisemo sva pojavljivanja grupe za dati proizvod
					$pvg = $ObjectFactory->createObject("PrVeznaGrupa",$_POST["proizvodid"]);
					$pvg->ProizvodID = $proiz->ProizvodID;
					$DBBR->obrisiSlogove($pvg);
					foreach ($grupaproizvodaids as $gps) 
					{
						$pvg->ProizvodID = $proiz->ProizvodID;
						$pvg->GrupaProizvodaID= $gps;	
						if ($gps>0) $DBBR->kreirajSlog($pvg);
					}
				}
			}
			else 
			{
				// SHIT KOD
				//iz vezne tabele brisemo sva pojavljivanja grupa za dati proizvod
				$pvg = $ObjectFactory->createObject("PrVeznaGrupa",$_POST["proizvodid"]);
				$pvg->ProizvodID = $proiz->ProizvodID;
				$DBBR->obrisiSlogove($pvg);
			}
			
			if(isset($_REQUEST["grupaproizvodaid2"]))
			{
				$grupaproizvodaids2 = $_POST["grupaproizvodaid2"];
				if(count($grupaproizvodaids2) > 0)
				{
					//iz vezne tabele brisemo sva pojavljivanja grupe za dati proizvod
					$pkg = $ObjectFactory->createObject("PrKitGrupa",$_POST["proizvodid"]);
					$pkg->ProizvodID = $proiz->ProizvodID;
					$DBBR->obrisiSlogove($pkg);
					foreach ($grupaproizvodaids2 as $gps) 
					{
						$pkg->ProizvodID = $proiz->ProizvodID;
						$pkg->GrupaProizvodaID= $gps;	
						if ($gps>0) $DBBR->kreirajSlog($pkg);
					}
				}
			}
			else 
			{
				//iz vezne tabele brisemo sva pojavljivanja grupa za dati proizvod
				$pkg = $ObjectFactory->createObject("PrKitGrupa",$_POST["proizvodid"]);
				$pkg->ProizvodID = $proiz->ProizvodID;
				$DBBR->obrisiSlogove($pkg);
			}

			if($proiz->SfStatus->StatusID == STATUS_PROIZVODA_ARHIVIRAN)
			{
				// treba da pokusamo da obrisemo video fajl i sliku sa servera
				@unlink(ROOT_HOME.$proiz->Dokument);
				$proiz->Dokument = "";
				@unlink(ROOT_HOME.$proiz->Slika);
				$proiz->Slika = "";
			}
			//$DBBR->debug = true;
			$DBBR->promeniSlog($proiz);
			$status = "";
			
			
			if(isset($_REQUEST["karakteristika"]))
			{
				// da li uopste imamo dodatnih karakteristika
				if(count($_REQUEST["karakteristika"]) > 0)
				{

				 	foreach ($_REQUEST["karakteristika"] as $key => $value)
					{
						$karakteristikaproizvoda = $ObjectFactory->createObject("PrKarakteristikaProizvoda",-1);
						$karakteristikaproizvoda->ProizvodID = $proiz->ProizvodID;
						$karakteristikaproizvoda->KarakteristikaID = $key;
					
						// trazim da vidim da li postoji karakteristika bazi podataka koju menjam...
						$DBBR->nadjiSlogVratiGa($karakteristikaproizvoda);
					
						if($DBBR->con->num_rows != 0)
						{ // znaci da postoji veza izmedju proizvoda i karakteristike
							$status = "modify";
						}
						else
						{ // veza jos ne postoji izmedju proizvoda i karakteristike
							$status= "add";
						}

						// implementacija potrebnih operacija nad bazom
						switch($status)
						{
							case "add":
								// potrebno je dodati novu vezu u tablu agregacije... ali samo ako je korisnik nesto uneo za vrednost value
								if($value != "") 
								{
									$karakteristikaproizvoda->ProizvodID = $proiz->ProizvodID;
									$karakteristikaproizvoda->KarakteristikaID = $key;
									$karakteristikaproizvoda->Vrednost = $value;
									$DBBR->kreirajSlog($karakteristikaproizvoda);
								}
								break;
							case "modify":
									if($value == "")
									{
										// ako je vrednost slucajno "" obrisi red iz baze jer nam ne treba
										$DBBR->obrisiSlog($karakteristikaproizvoda);
									}
									// poredim da li je doslo do promene vrednosti
									else 
										if($karakteristikaproizvoda->Vrednost != $value)
									{
										// samo u slucaju da je doslo do promene vrednosti radim upadate

										$karakteristikaproizvoda->Vrednost = $value;
										$karakteristikaproizvoda->setKarakteristikaElementID(-1);
										$DBBR->promeniSlog($karakteristikaproizvoda);
									}
									
								break;
							default:
								break;
						}
					}
				}
			}
			
			if(isset($_REQUEST["karakteristikaelementid"]))
			{
				foreach ($_REQUEST["karakteristikaelementid"] as $key => $value)
				{
					$karakteristikaproizvoda = $ObjectFactory->createObject("PrKarakteristikaProizvoda",-1);
					$karakteristikaproizvoda->ProizvodID = $proiz->ProizvodID;
					$karakteristikaproizvoda->KarakteristikaID = $key;
					//$karakteristikaproizvoda->Vrednost = -1;
					//$karakteristikaproizvoda->PrKarakteristikaElement->KarakteristikaElementID = $value;
					
					// trazim da vidim da li postoji karakteristika bazi podataka koju menjam...
					$DBBR->nadjiSlogVratiGa($karakteristikaproizvoda);

					if($DBBR->con->num_rows != 0)
					{ // znaci da postoji veza izmedju proizvoda i karakteristike
						$status = "modify";
					}
					else
					{ // veza jos ne postoji izmedju proizvoda i karakteristike
						$status= "add";
					}

					// implementacija potrebnih operacija nad bazom
					switch($status)
					{
						case "add":
							// potrebno je dodati novu vezu u tablu agregacije... ali samo ako je korisnik nesto uneo za vrednost value
							if($value != "-1") 
							{
								$karakteristikaproizvoda->PrKarakteristikaElement->KarakteristikaElementID = $value;
								$karakteristikaproizvoda->Vrednost = -1;
								$DBBR->kreirajSlog($karakteristikaproizvoda);
							}
							break;
						case "modify":
						
							if($value == "-1")
							{
								// ako je vrednost -1 "bez izbora" obrisi red iz baze jer nam ne treba
							
								$DBBR->obrisiSlog($karakteristikaproizvoda);
								
								
							}
							// poredim da li je doslo do promene vrednosti
							else //if($karakteristikaproizvoda->Vrednost != $value)
							{
								// samo u slucaju da je doslo do promene vrednosti radim upadate
								$karakteristikaproizvoda->Vrednost = -1;
								$karakteristikaproizvoda->PrKarakteristikaElement->KarakteristikaElementID = $value;
								$DBBR->promeniSlog($karakteristikaproizvoda);
							}
							break;
						default:
							break;
					}
				}
			}
			
			if(isset($_REQUEST["grpproizbackid"]) && $_REQUEST["grpproizbackid"] != "" && is_numeric($_REQUEST["grpproizbackid"]))
			{
				$grupaProizvodaId = $_REQUEST["grpproizbackid"];
			}
			$insert = new ConnectedObject($ObjectFactory,$DBBR);
			$insert->InsertConnectedObject('Proizvod', 'img', $_REQUEST["proizvodid"]);
			$insert->InsertConnectedObject('Proizvod', 'vid', $_REQUEST["proizvodid"]);						
			$insert->InsertConnectedObject('Proizvod', 'web', $_REQUEST["proizvodid"]);	
			$insert->InsertConnectedObject('Proizvod', 'doc', $_REQUEST["proizvodid"]);		

			$ObjectFactory->Reset();
			$velicine = $ObjectFactory->createObjects("PrVelicina");
			$ObjectFactory->Reset();
			if(count($velicine) > 0)
			{
				foreach($velicine as $vel)
				{
					$ObjectFactory->Reset();
					$ObjectFactory->AddFilter("proizvodid = " . $_REQUEST['proizvodid'] . " AND velicinaid = " . $vel->getVelicinaID());
					$prvelicine = $ObjectFactory->createObjects("PrProizvodVelicina");
					$ObjectFactory->Reset();		
					$id=$vel->getVelicinaID();
					$bb=0;
					if ($_REQUEST['vel'.$id]=='on') {
						$bb++;
						if(count($prvelicine) == 0) $prvel = $ObjectFactory->createObject("PrProizvodVelicina",-1);
						else $prvel=$prvelicine[0];
						$prvel->setProizvodID($_REQUEST['proizvodid']);
						$prvel->setVelicinaID($vel->getVelicinaID());
						$prvel->setSifra($_REQUEST['sifra'.$id]);
						$prvel->setCenaA($_REQUEST['cenaa'.$id]);
						$prvel->setCenaB($_REQUEST['cenab'.$id]);
						$prvel->setCenaAMP($_REQUEST['cenaamp'.$id]);
						$prvel->setCenaBMP($_REQUEST['cenabmp'.$id]);						
						$prvel->setKolicina($_REQUEST['kolicina'.$id]);							
						if(count($prvelicine) == 0) $DBBR->kreirajSlog($prvel);
						else $DBBR->promeniSlog($prvel);
					}	
					else {
						if(count($prvelicine) > 0) {
							$prvel=$prvelicine[0];
							$DBBR->obrisiSlog($prvel);
						}	
					}	
				}
			}	
			echo "<div class='success'>".getTranslation("PLG_CHANGE_SUCCESS")."</div>";
		}
		else echo "<div class='error'>".getTranslation("PLG_CHANGE_FAILED")."</div>";
	}
	else echo "<div class='warning'>".getTranslation("PLG_NORIGHT")."</div>";
	
	
?>