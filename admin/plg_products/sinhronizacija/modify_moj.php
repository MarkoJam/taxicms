<?
	/* CMS Studio 3.0 modify_final.php */
	set_time_limit(120);
	$_ADMINPAGES = true;
	include_once("../../../config.php");
	include_once("../../../common/class/PHPExcel.php");


	global $smarty;
	global $auth;
	global $DBBR;

	$executed=0;
	if ($_REQUEST["book"]<>"" && $_REQUEST["sheet"]<>"")
	{
		$ObjectFactory = ObjectFactory::getInstance();
		$excelFile = "../../../".$_REQUEST["book"];
		//$excelFile = "../../../Lager2.xlsx";
		$sheet=$_REQUEST["sheet"];
		$pathInfo = pathinfo($excelFile);
		$type = $pathInfo['extension'] == 'xlsx' ? 'Excel2007' : 'Excel5';

		$objReader = PHPExcel_IOFactory::createReader($type);

		$objPHPExcel = $objReader->load($excelFile);
		foreach ($objPHPExcel->getWorksheetIterator() as $worksheet)
		{
			$sheet=$worksheets[$worksheet->getTitle()] = $worksheet->toArray();
		}
		$i=0;
		foreach ($worksheets[$_REQUEST["sheet"]][0] as $hed)
		{
			$executed=1;
			switch ($hed) {
				case sifra:
					$Ncode=$i;
					break;
				case cene:
					$Npricea=$i;
					$Npriceart=$i;
					break;
				case stanje:
					$Nquantity=$i;
					break;
			}
			$i++;
		}

		$i=0;
		foreach ($worksheets[$_REQUEST["sheet"]] as $row)
		{
			if ($i>0) {
				$sifra=$row[$Ncode];
				if ($sifra!=' ') {
					$price=$row[$Npricea]*1.2;
					// varijanta preko sql upita
					$sql1="UPDATE pr_proizvod SET cenaa = '".$price."', kolicina = '".$row[$Nquantity]."' WHERE 1=1 AND sifra = '".$sifra."'; ";
					if ($row[$Nquantity]==0) $sql2="UPDATE pr_proizvod SET status_id = '54' WHERE 1=1 AND status_id <> '55' AND sifra = '".$sifra."'; ";
					else $sql2="UPDATE pr_proizvod SET status_id = '51' WHERE 1=1 AND status_id <> '55' AND sifra = '".$sifra."'; ";

					$DBBR->con->query($sql1);
					$DBBR->con->query($sql2);

					//varijanta preko object factory
					/*$ObjectFactory->Reset();
					$ObjectFactory->AddFilter("sifra = '" . $sifra ."'");
					$proizvodi = $ObjectFactory->createObjects("PrProizvod");
					$ObjectFactory->Reset();

					// varijanta sa vise proizvoda sa istom sifrom
					foreach ($proizvodi as $proiz) {
						$proiz->setCenaA($row[$Npricea]*1.2);
						//$proiz->setCenaB($row[$Npriceb]);
						$proiz->setCenaAMP($row[$Npriceart]*1.2);
						//$proiz->setCenaBMP($row[$Npricebrt]);
						$proiz->setKolicina($row[$Nquantity]);
						$DBBR->promeniSlog($proiz);
					}*/
				}
			}
			$i++;
		}
		//$DBBR->con->query($sql1);
		//$DBBR->con->query($sql2);

	}

	// azuriranje kit kompleta

	// ucitavanje kit grupa
	$ObjectFactory->Reset();
	//$ObjectFactory->AddFilter("proizvodid=".$_REQUEST["proizvodid"]);
	$kitgrupa = $ObjectFactory->createObjects("PrKitGrupa");
	$ObjectFactory->Reset();
	// ? da li postoje kit grupe
	if(count($kitgrupa) > 0)
	{
		// prolazimo kroz sve kit grupe
		foreach($kitgrupa as $kg)
		{
			$id=$kg->GrupaProizvodaID;
			$prid=$kg->ProizvodID; //koristimo dole, kasnije
			// ucitavanje grupe proizvoda za tekuci kitkomplet proizvod
			$ObjectFactory->Reset();
			$ObjectFactory->AddFilter("grupaproizvodaid=".$id);
			$prgrupa = $ObjectFactory->createObjects("PrProizvodGrupaProiz");
			$ObjectFactory->Reset();

			// ? da li grupa (kit grupa) ima elemente - proizvode
			if(count($prgrupa) > 0)
			{
				$lager="true"; // default 'ima na lageru'
				// prolazimo kroz proizvode u grupi
				$lag_pr=array();
				foreach($prgrupa as $pg)
				{
					$pid=$pg->ProizvodID;
					//ucitavanje tekuceg proizvoda koji je deo tekuceg kitkompleta
					$proiz = $ObjectFactory->createObject("PrProizvod",$pid, array("SfStatus"));
					// ispitivanje lagera - statusa
					if ($proiz->SfStatus->StatusID==STATUS_PROIZVODA_NEMANALAGERU) $lager="false"; // nema na lageru
					//smanjenje lagera proizvoda za proizvode kojih ima vise u kit kompletu
					if ($pg->getKitNum()>$proiz->getKolicina()) $lager="false";
					/*if ($lag_pr[$pid]) $lag_pr[$pid]=$lag_pr[$pid]-1;
					else $lag_pr[$pid]=$proiz->getKolicina()-1;
					// da li ima jos istih proizvoda na lageru
					if ($lag_pr[$pid]<1) $lager="false";*/
				}
			}
			else $lager="false"; //ako je grupa prazna - nema na lageru
			// ucitavanje tekuceg proizvoda koji je u kitkomplet
			$proizvod = $ObjectFactory->createObject("PrProizvod",$prid, array("SfStatus"));//$prid je formiran gore, kod ucitavanja kit grupe
			if ($lager=="false") $proizvod->SfStatus->StatusID=STATUS_PROIZVODA_NEMANALAGERU ; //menjamo status ako je lager false
			else $proizvod->SfStatus->StatusID=STATUS_PROIZVODA_AKTIVAN;
			//azuriranje lagera kitkompleta
			//!!!!!AZURIRAMO SAMO UKOLIKO PROIZVOD (KIT PROIZVOD) NIJE VEC RANIJE, U SINHRONIZACIJI, DOBIO KOLICINU
			if ($proizvod->getKolicina()==0)  $DBBR->promeniSlog($proizvod);
		}
	}
	// azuriranje proizvoda - kopiranje cene
	$ObjectFactory->Reset();
	$proizvod = $ObjectFactory->createObjects("PrProizvod");
	$ObjectFactory->Reset();
	foreach($proizvod as $pr)
	{
		if ($pr->SfStatus->StatusID==STATUS_PROIZVODA_POZOVITE && $pr->getKolicina()>0 && $pr->getCenaA()>0)
			$pr->SfStatus->StatusID=STATUS_PROIZVODA_AKTIVAN;
		$pr->setCenaAMP($pr->getCenaA());
		$pr->setCenaBMP($pr->getCenaB());

		$DBBR->promeniSlog($pr);
	}

	$smarty->assign('executed',$executed);
	$smarty->display('modify.tpl');

?>
