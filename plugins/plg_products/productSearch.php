<?

class ProductSearch 
{
	public $StartState;
	public $TipProizvodaState;
	public $ProizvodjacState;
	public $TipProizvodaProizvodjacState;
	public $TipProizvodaKarakteristikaState;
	public $TipProizvodaKarakteristikaVrednostState;
	public $TipProizvodaProizvodjacKarakteristikaVrednostState;
	public $TipProizvodaProizvodjacKarakteristikaState;
	var $NazivProizvodaState;
	// nova stanja za kategoriju proizvoda
	public $KategorijaProizvodaState;
	public $KategorijaProizvodaProizvodjacState;
	public $KategorijaProizvodaTipProizvodaState;
	public $KategorijaProizvodaTipProizvodaProizvodjacState;
		
	// promenljive koje sadrze sesijske vrednosti
	public $TipProizvoda;
	public $Proizvodjac;
	public $Karakteristika;
	public $Vrednost;
	public $NazivProizvoda;
	// nova promenljiva
	public $KategorijaProizvoda;		
	public $currentState;
	public $smarty;
	
	function ProductSearch(&$smarty)
	{
		$this->smarty = & $smarty;
		$this->StartState = new StateStart($this);
		$this->TipProizvodaState = new StateTipProizvoda($this);
		$this->ProizvodjacState = new StateProizvodjac($this);
		$this->TipProizvodaProizvodjacState = new StateTipProizvodaProizvodjac($this);
		$this->TipProizvodaKarakteristikaState = new StateTipProizvodaKarakteristika($this);
		$this->TipProizvodaKarakteristikaVrednostState = new StateTipProizvodaKarakteristikaVrednost($this);
		$this->TipProizvodaProizvodjacKarakteristikaState = new StateTipProizvodaProizvodjacKarakteristika($this);
		$this->TipProizvodaProizvodjacKarakteristikaVrednostState = new StateTipProizvodaProizvodjacKarakteristikaVrednost($this);
		//$this->NazivProizvodaState = new StateNazivProizvoda($this);
		// nova stanja za kategoriju proizvoda
		$this->KategorijaProizvodaState = new StateKategorijaProizvoda($this);
		$this->KategorijaProizvodaProizvodjacState = new StateKategorijaProizvodaProizvodjac($this);
		$this->KategorijaProizvodaTipProizvodaState = new StateKategorijaProizvodaTipProizvoda($this);
		$this->KategorijaProizvodaTipProizvodaProizvodjacState = new StateKategorijaProizvodaTipProizvodaProizvodjac($this);
			
		// u zavisnosti od stanja sessije postavljam startno stanje! ola!
		if(isset($_SESSION["product_search_state"]))
		{	
			eval("\$this->currentState = \$this->".$_SESSION["product_search_state"].";");
			//echo("\$this->currentState = \$this->".$_SESSION["product_search_state"].";");
			
		}
		else 
		{
			$this->currentState = $this->StartState;
			$_SESSION["product_search_state"] = "StartState";
		}
		
		// -1 znaci da nije selektovano! koristicemo to i za deselektovanje!
		if(isset($_SESSION["stateTipProizvoda"]))
		{	
			$this->TipProizvoda = $_SESSION["stateTipProizvoda"];
		}
		else 
		{
			$this->TipProizvoda = -1;
			$_SESSION["stateTipProizvoda"] = -1;
		}
		
		if(isset($_SESSION["stateProizvodjac"]))
		{	
			$this->Proizvodjac = $_SESSION["stateProizvodjac"];
		}
		else 
		{
			$this->Proizvodjac = -1;
			$_SESSION["stateProizvodjac"] = -1;
		}
		
		if(isset($_SESSION["stateKategorijaProizvoda"]))
		{	
			$this->KategorijaProizvoda = $_SESSION["stateKategorijaProizvoda"];
		}
		else 
		{
			$this->KategorijaProizvoda = -1;
			$_SESSION["stateKategorijaProizvoda"] = -1;
		}
		
		if(isset($_SESSION["stateKarakteristika"]))
		{	
			$this->Karakteristika = $_SESSION["stateKarakteristika"];
		}
		else 
		{
			$this->Karakteristika = -1;
			$_SESSION["stateKarakteristika"] = -1;
		}
		// kod vrednosti i naziva se koristi "" umesto -1 jer su to stringovi
		if(isset($_SESSION["stateVrednost"]))
		{	
			$this->Vrednost = $_SESSION["stateVrednost"];
		}
		else
		{ 
			$this->Vrednost = "";
			$_SESSION["stateVrednost"] = "";	
		}
	}
	
	function GenerateQueryStringFromState()
	{
		$queryString = "";
		
		if($this->TipProizvoda != -1) $queryString .= "&tipproizvodaid=".$this->TipProizvoda;
		if($this->Proizvodjac != -1) $queryString .= "&proizvodjacid=".$this->Proizvodjac;
		if($this->KategorijaProizvoda != -1) $queryString .= "&kategorijaid=".$this->KategorijaProizvoda;
		if($this->Karakteristika != -1) $queryString .= "&karakteristikaid=".$this->Karakteristika;
		if($this->Vrednost != "") $queryString .= "&vrednost=".$this->Vrednost;
		
		return $queryString;
	}
	
	function proccessState()
	{
		try
		{
			$this->currentState->proccessState();	
		}
		catch (Exception $ex)
		{
			throw $ex;
		}
	}
	
	function selectTipProizvoda()
	{
		$this->currentState->selectTipProizvoda();
	}
	function deselectTipProizvoda()
	{
		$this->currentState->deselectTipProizvoda();
	}
	function selectProizvodjac()
	{
		$this->currentState->selectProizvodjac();
	}
	function deselectProizvodjac()
	{
		$this->currentState->deselectProizvodjac();
	}
	function selectKarakteristika()
	{
		$this->currentState->selectKarakteristika();
	}
	function selectKategorijaProizvoda()
	{
		$this->currentState->selectKategorijaProizvoda();
	}
	function deselectKategorijaProizvoda()
	{
		$this->currentState->deselectKategorijaProizvoda();
	}
	function deselectKarakteristika()
	{
		$this->currentState->deselectKarakteristika();
	}
	function selectVrednost()
	{
		$this->currentState->selectVrednost();
	}
	function deselectVrednost()
	{
		$this->currentState->deselectVrednost();
	}
	
	function setTipProizvoda($id)
	{
		$this->TipProizvoda = $id;
		$_SESSION["stateTipProizvoda"] = $id;
	}
	
	function setProizvodjac($id)
	{
		$this->Proizvodjac = $id;
		$_SESSION["stateProizvodjac"] = $id;
	}
	function setKategorijaProizvoda($id)
	{
		$this->KategorijaProizvoda = $id;
		$_SESSION["stateKategorijaProizvoda"] = $id;
	}
	function setKarakteristika($id)
	{
		$this->Karakteristika = $id;
		$_SESSION["stateKarakteristika"] = $id;
	}
	
	function setVrednost($value)
	{
		$this->Vrednost = $value;
		$_SESSION["stateVrednost"] = $value;
	}
	
	function setState(&$state)
	{
		eval("\$this->currentState = \$this->".$state->getStateName().";");
		//echo "<br>sadasnji state je ".$this->currentState->getStateName();
		//echo "<br>ovde menjam state!". $state->getStateName();
		$_SESSION["product_search_state"] = $state->getStateName();
		
	}
}	

	// interfejs za klase 
	class State 
	{
		public $productSearch;
		public $objectFactory;
		
		function State($prodsearch)
		{
			$this->productSearch = $prodsearch;
			$this->objectFactory = ObjectFactory::getInstance();
		}
		
		function selectTipProizvoda()
		{
			$this->productSearch->setTipProizvoda($_REQUEST["tipproizvodaid"]);
			$this->productSearch->setKarakteristika(-1);
			$this->productSearch->setVrednost("");
		}
		function deselectTipProizvoda(){}
		function selectProizvodjac()
		{
			$this->productSearch->setProizvodjac($_REQUEST["proizvodjacid"]);
		}
		function deselectProizvodjac(){}
		
		function selectKarakteristika()
		{
			$this->productSearch->setKarakteristika($_REQUEST["karakteristikaid"]);
			$this->productSearch->setVrednost("");
		}
		function deselectKategorijaProizvoda() {}
	
		function selectKategorijaProizvoda()
		{
			$this->productSearch->setKategorijaProizvoda($_REQUEST["kategorijaid"]);
		}
		function deselectKarakteristika(){}
		function selectVrednost()
		{
			$this->productSearch->setVrednost($_REQUEST["vrednost"]);
		}
		function deselectVrednost(){}
		function proccessState(){}
		function getStateName(){}
		function getQuery(){}
		// iskoristiti postojeci getQuery da prebrojimo sve proizvode
		function getTotalProizvodCount()
		{
			$upit = str_replace('*','count(*) as cnt',$this->getQuery());
			$result_set = $this->objectFactory->DBBR->con->get_results($upit);
			return $result_set[0]->cnt;
		}
	}
	
	class StateStart extends State 
	{
		function proccessState()
		{
			// prikaz svih tipova proizvoda
			// dohvatamo sve tipove proizvoda
			
			$this->objectFactory->ResetFilters();
			$this->objectFactory->SetSortBy("naziv");
			$tipoviproizvoda = $this->objectFactory->createObjects("PrTipProizvoda");

			$ShTipProizvoda = new SmartyHtmlSelection("tip",$this->productSearch->smarty);
			foreach ($tipoviproizvoda as $tip)
			{
				$ShTipProizvoda->AddValue($tip->getTipProizvodaID());
				$ShTipProizvoda->AddOutput($tip->getNaziv());
			}
			$ShTipProizvoda->AddSelected($this->productSearch->TipProizvoda);
			$ShTipProizvoda->SmartyAssign();
			
			// prikaz svih proizvodjaca
			$proizvodjaci =  $this->objectFactory->createObjects("PrProizvodjac");
		
			$ShProizvodjaci = new SmartyHtmlSelection("proizvodjac",$this->productSearch->smarty);
			
			foreach ($proizvodjaci as $pr)
			{
				
				$ShProizvodjaci->AddValue($pr->getProizvodjacID());
				$ShProizvodjaci->AddOutput($pr->getNaziv());
			}
			
			$ShProizvodjaci->AddSelected($this->productSearch->Proizvodjac);
			$ShProizvodjaci->SmartyAssign();
			
			$kategorije = $this->objectFactory->createObjects("PrKategorija");
			$ShKategorije = new SmartyHtmlSelection("kategorija",$this->productSearch->smarty);
			foreach ($kategorije as $kat)
			{
				$ShKategorije->AddValue($kat->KategorijaID);
				$ShKategorije->AddOutput($kat->Naziv);
			}
			
			$ShKategorije->AddSelected($this->productSearch->KategorijaProizvoda);
			$ShKategorije->SmartyAssign();
			
			// zalediti karateristike
			$this->productSearch->smarty->assign("karakt_disable",'disabled="disabled"');

			// zalediti vrednosti
			$this->productSearch->smarty->assign("vrednost_disable",'disabled="disabled"');			
		}
		function selectTipProizvoda()
		{
			$this->productSearch->setState($this->productSearch->TipProizvodaState);
			$this->productSearch->setTipProizvoda($_REQUEST["tipproizvodaid"]);
		}
		function selectKategorijaProizvoda()
		{
			$this->productSearch->setState($this->productSearch->KategorijaProizvodaState);
			$this->productSearch->setKategorijaProizvoda($_REQUEST["kategorijaid"]);
		}
		function selectProizvodjac()
		{
			$this->productSearch->setState($this->productSearch->ProizvodjacState);
			$this->productSearch->setProizvodjac($_REQUEST["proizvodjacid"]);
		}
		
		function getQuery()
		{
			return "SELECT * FROM pr_proizvod WHERE 1=2";
		}
		
		function getStateName()
		{
			return "StartState";
		}
	}

	class StateTipProizvoda extends State 
	{
		function proccessState(){
			// prikaz svih tipova proizvoda
			// dohvatamo sve tipove proizvoda
			$this->objectFactory->ResetFilters();
			$this->objectFactory->SetSortBy("naziv");
			$tipoviproizvoda = $this->objectFactory->createObjects("PrTipProizvoda");
		
			$ShTipProizvoda = new SmartyHtmlSelection("tip", $this->productSearch->smarty);
			foreach ($tipoviproizvoda as $tip)
			{
				$ShTipProizvoda->AddValue($tip->getTipProizvodaID());
				$ShTipProizvoda->AddOutput($tip->getNaziv());
			}
			$ShTipProizvoda->AddSelected($this->productSearch->TipProizvoda);
			$ShTipProizvoda->SmartyAssign();
			
			// prikaz svih proizvodjaca koji se nalaze u izabranim tipovima proizvoda
			$proizvodjac = $this->objectFactory->createObject("PrProizvodjac",-1);
			$proizvodjaci = array();
			$upit = " SELECT DISTINCT PD.proizvodjacid, PD.naziv, PD.opis ".
					" FROM pr_proizvod P ".
					" INNER JOIN pr_proizvodjac PD ON P.proizvodjacid = PD.proizvodjacid ".
					" WHERE 1=1  ".
					" AND tipproizvodaid = ". $this->productSearch->TipProizvoda.
					" AND P.status_id <> " .STATUS_PROIZVODA_ARHIVIRAN;
			
			$results = $this->objectFactory->DBBR->con->get_results($upit);
			$proizvodjac->napuniNiz($results,$proizvodjaci);
			
			$ShProizvodjaci = new SmartyHtmlSelection("proizvodjac", $this->productSearch->smarty);
			foreach ($proizvodjaci as $pr)
			{
				$ShProizvodjaci->AddValue($pr->getProizvodjacID());
				$ShProizvodjaci->AddOutput($pr->getNaziv());
			}
			$ShProizvodjaci->AddSelected($this->productSearch->Proizvodjac);
			$ShProizvodjaci->SmartyAssign();
			
			// KATEGORIJE PROIZVODA
			$kategorija = $this->objectFactory->createObject("PrKategorija",-1);
			$kategorije = array();
			$upit = " SELECT DISTINCT K.kategorijaid, K.naziv, K.opis ".
					" FROM pr_proizvodjac PR ".
					" LEFT JOIN pr_proizvod P ON PR.proizvodjacid = P.proizvodjacid ".
					" LEFT JOIN pr_proizvodkategorija PK ON P.proizvodid = PK.proizvodid ".
					" LEFT JOIN pr_kategorija K ON K.kategorijaid = PK.kategorijaid" .
					" WHERE P.tipproizvodaid=". $this->productSearch->TipProizvoda;
			
			$results =  $this->objectFactory->DBBR->con->get_results($upit);
			$kategorija->napuniNiz($results,$kategorije);
			
			$ShKategorije = new SmartyHtmlSelection("kategorija",$this->productSearch->smarty);
			foreach ($kategorije as $kat)
			{
				$ShKategorije->AddValue($kat->KategorijaID);
				$ShKategorije->AddOutput($kat->Naziv);
			}
			
			$ShKategorije->AddSelected($this->productSearch->KategorijaProizvoda);
			$ShKategorije->SmartyAssign();
			
			// zalediti karateristike
			$tipproizvoda = $this->objectFactory->createObject("PrTipProizvoda",$this->productSearch->TipProizvoda,array("PrKarakteristika"));
			
			$ShKarakteristike = new SmartyHtmlSelection("karakteristike",$this->productSearch->smarty);
			foreach ($tipproizvoda->PrKarakteristika as $kar)
			{
				$ShKarakteristike->AddValue($kar->getKarakteristikaID());
				$ShKarakteristike->AddOutput($kar->getNaziv());
			}
			//$ShKarakteristike->AddSelected($this->productSearch->Karakteristika);
			$ShKarakteristike->SmartyAssign();
			
			// zalediti vrednosti
			$this->productSearch->smarty->assign("vrednost_disable",'disabled="disabled"');	
		}

		function deselectTipProizvoda()
		{
			$this->productSearch->setState($this->productSearch->StartState);
			$this->productSearch->setTipProizvoda(-1);
			$this->productSearch->setKarakteristika(-1);
			$this->productSearch->setVrednost("");
		}
		function selectProizvodjac()
		{
			$this->productSearch->setState($this->productSearch->TipProizvodaProizvodjacState);
			$this->productSearch->setProizvodjac($_REQUEST["proizvodjacid"]);
		}
		
		function selectKategorijaProizvoda()
		{
			$this->productSearch->setState($this->productSearch->KategorijaProizvodaState);
			$this->productSearch->setKategorijaProizvoda($_REQUEST["kategorijaid"]);
		}
		
		function selectKarakteristika()
		{
			$this->productSearch->setState($this->productSearch->TipProizvodaKarakteristikaState);
			$this->productSearch->setKarakteristika($_REQUEST["karakteristikaid"]);
		}
		function getQuery()
		{
			return	" SELECT * FROM pr_proizvod ".
					" WHERE 1=1 ".
					" AND tipproizvodaid=".$this->productSearch->TipProizvoda.
					" AND status_id <> " .STATUS_PROIZVODA_ARHIVIRAN;
		}
		
		function getStateName()
		{
			return "TipProizvodaState";
		}
	}
	
	class StateProizvodjac extends State 
	{
		function proccessState(){
			// na osnovu izabranog proizvodjaca 
			// filtriramo samo potrebne tipove proizvoda
			$this->objectFactory->ResetFilters();
			
			$tipoviproizvoda = array();
			$tipproizvoda = $this->objectFactory->createObject("PrTipProizvoda",-1);
			$upit = " SELECT DISTINCT TP.tipproizvodaid, TP.naziv, TP.opis, TP.tipproizvoda_order as `order` ".
					" FROM pr_proizvod P ".
					" INNER JOIN pr_tipproizvoda TP ON P.tipproizvodaid = TP.tipproizvodaid ".
					" WHERE 1=1 ".
					" AND proizvodjacid = ". $this->productSearch->Proizvodjac.
					" AND P.status_id <> " .STATUS_PROIZVODA_ARHIVIRAN .
					" ORDER BY TP.naziv ";
			
			$results = $this->objectFactory->DBBR->con->get_results($upit);
			$tipproizvoda->napuniNiz($results,$tipoviproizvoda);
			
			$ShTipProizvoda = new SmartyHtmlSelection("tip",$this->productSearch->smarty);
			foreach ($tipoviproizvoda as $tip)
			{
				$ShTipProizvoda->AddValue($tip->getTipProizvodaID());
				$ShTipProizvoda->AddOutput($tip->getNaziv());
			}
			$ShTipProizvoda->AddSelected($this->productSearch->TipProizvoda);
			$ShTipProizvoda->SmartyAssign();
			
			// prikaz svih proizvodjaca
			$proizvodjaci = $this->objectFactory->createObjects("PrProizvodjac");
		
			$ShProizvodjaci = new SmartyHtmlSelection("proizvodjac", $this->productSearch->smarty);
			foreach ($proizvodjaci as $pr)
			{
				$ShProizvodjaci->AddValue($pr->getProizvodjacID());
				$ShProizvodjaci->AddOutput($pr->getNaziv());
			}
			$ShProizvodjaci->AddSelected($this->productSearch->Proizvodjac);
			$ShProizvodjaci->SmartyAssign();
			
			// KATEGORIJE PROIZVODA
			$kategorija = $this->objectFactory->createObject("PrKategorija",-1);
			$kategorije = array();
			$upit = " SELECT DISTINCT K.kategorijaid, K.naziv, K.opis ".
					" FROM pr_proizvodjac PR ".
					" LEFT JOIN pr_proizvod P ON PR.proizvodjacid = P.proizvodjacid ".
					" LEFT JOIN pr_proizvodkategorija PK ON P.proizvodid = PK.proizvodid ".
					" LEFT JOIN pr_kategorija K ON K.kategorijaid = PK.kategorijaid" .
					" WHERE P.proizvodjacid=". $this->productSearch->Proizvodjac;
			$results = $this->objectFactory->DBBR->con->get_results($upit);
			$kategorija->napuniNiz($results,$kategorije);
			$ShKategorije = new SmartyHtmlSelection("kategorija",$this->productSearch->smarty);
			foreach ($kategorije as $kat)
			{
				$ShKategorije->AddValue($kat->KategorijaID);
				$ShKategorije->AddOutput($kat->Naziv);
			}
			
			$ShKategorije->AddSelected($this->productSearch->KategorijaProizvoda);
			$ShKategorije->SmartyAssign();
			
			// zalediti karateristike
			$this->productSearch->smarty->assign("karakt_disable",'disabled="disabled"');

			// zalediti vrednosti
			$this->productSearch->smarty->assign("vrednost_disable",'disabled="disabled"');	
		}

		function deselectProizvodjac()
		{
			$this->productSearch->setState($this->productSearch->StartState);
			$this->productSearch->setProizvodjac(-1);
		}
		
		function selectTipProizvoda()
		{
			$this->productSearch->setState($this->productSearch->TipProizvodaProizvodjacState);
			$this->productSearch->setTipProizvoda($_REQUEST["tipproizvodaid"]);
		}
		
		function selectKategorijaProizvoda()
		{
			$this->productSearch->setState($this->productSearch->KategorijaProizvodaState);
			$this->productSearch->setKategorijaProizvoda($_REQUEST["kategorijaid"]);
		}
		
		function getQuery()
		{
			return 	" SELECT * FROM pr_proizvod ".
					" WHERE 1=1 " .
					" AND proizvodjacid=".$this->productSearch->Proizvodjac.
					" AND status_id <> " .STATUS_PROIZVODA_ARHIVIRAN;
		}
		
		function getStateName()
		{
			return "ProizvodjacState";
		}
	}
	
	class StateTipProizvodaProizvodjac extends State 
	{
		function proccessState()
		{
			// na osnovu izabranog proizvodjaca 
			// filtriramo samo potrebne tipove proizvoda
			$tipoviproizvoda = array();
			
			$this->objectFactory->ResetFilters();
			$tipproizvoda = $this->objectFactory->createObject("PrTipProizvoda",-1);
			$upit =	" SELECT DISTINCT TP.tipproizvodaid as tipproizvodaid, TP.naziv as naziv, TP.opis as opis, TP.tipproizvoda_order as `order` ".
					" FROM pr_proizvod P " .
					" INNER JOIN pr_tipproizvoda TP ON P.tipproizvodaid = TP.tipproizvodaid ".
					" WHERE 1=1 " . 
					" AND proizvodjacid = ". $this->productSearch->Proizvodjac.
					" AND P.status_id <> " .STATUS_PROIZVODA_ARHIVIRAN .
					" ORDER BY TP.naziv ";
			
			$results = $this->objectFactory->DBBR->con->get_results($upit);
			$tipproizvoda->napuniNiz($results,$tipoviproizvoda);
			
			$ShTipProizvoda = new SmartyHtmlSelection("tip",$this->productSearch->smarty);
			foreach ($tipoviproizvoda as $tip)
			{
				$ShTipProizvoda->AddValue($tip->getTipProizvodaID());
				$ShTipProizvoda->AddOutput($tip->getNaziv());
			}
			$ShTipProizvoda->AddSelected($this->productSearch->TipProizvoda);
			$ShTipProizvoda->SmartyAssign();
			
			// prikaz svih proizvodjaca koji se nalaze u izabranom tipu proizvoda
			$proizvodjac = $this->objectFactory->createObject("PrProizvodjac",-1);
			$proizvodjaci = array();
			$upit =	" SELECT DISTINCT PD.proizvodjacid, PD.naziv, PD.opis ".
					" FROM pr_proizvod P ".
					" INNER JOIN pr_proizvodjac PD ON P.proizvodjacid = PD.proizvodjacid ".
					" WHERE 1=1 ".
					" AND tipproizvodaid = ". $this->productSearch->TipProizvoda.
					" AND P.status_id <> " .STATUS_PROIZVODA_ARHIVIRAN;
					
			$results = $this->objectFactory->DBBR->con->get_results($upit);
			$proizvodjac->napuniNiz($results,$proizvodjaci);
			
			$ShProizvodjaci = new SmartyHtmlSelection("proizvodjac",$this->productSearch->smarty);
			foreach ($proizvodjaci as $pr)
			{
				$ShProizvodjaci->AddValue($pr->getProizvodjacID());
				$ShProizvodjaci->AddOutput($pr->getNaziv());
			}
			$ShProizvodjaci->AddSelected($this->productSearch->Proizvodjac);
			$ShProizvodjaci->SmartyAssign();
			
			// KATEGORIJE PROIZVODA
			$kategorija = $this->objectFactory->createObject("PrKategorija",-1);
			$kategorije = array();
			
			$upit = " SELECT DISTINCT K.kategorijaid, K.naziv, K.opis ".
					" FROM pr_proizvodjac PR ".
					" LEFT JOIN pr_proizvod P ON PR.proizvodjacid = P.proizvodjacid ".
					" LEFT JOIN pr_proizvodkategorija PK ON P.proizvodid = PK.proizvodid ".
					" LEFT JOIN pr_kategorija K ON K.kategorijaid = PK.kategorijaid" .
					" WHERE P.tipproizvodaid=". $this->productSearch->TipProizvoda .
					" AND P.proizvodjacid=". $this->productSearch->Proizvodjac;
					
			$results = $this->objectFactory->DBBR->con->get_results($upit);
			$kategorija->napuniNiz($results,$kategorije);
			$ShKategorije = new SmartyHtmlSelection("kategorija",$this->productSearch->smarty);
			foreach ($kategorije as $kat)
			{
				$ShKategorije->AddValue($kat->KategorijaID);
				$ShKategorije->AddOutput($kat->Naziv);
			}
			
			$ShKategorije->AddSelected($this->productSearch->KategorijaProizvoda);
			$ShKategorije->SmartyAssign();
			
			// zalediti karateristike
			$tipproizvoda = $this->objectFactory->createObject("PrTipProizvoda",$this->productSearch->TipProizvoda,array("PrKarakteristika"));
			
			$ShKarakteristike = new SmartyHtmlSelection("karakteristike", $this->productSearch->smarty);
			foreach ($tipproizvoda->PrKarakteristika as $kar)
			{
				$ShKarakteristike->AddValue($kar->getKarakteristikaID());
				$ShKarakteristike->AddOutput($kar->getNaziv());
			}
			$ShKarakteristike->AddSelected($this->productSearch->Karakteristika);
			$ShKarakteristike->SmartyAssign();
			
			// zalediti vrednosti
			$this->productSearch->smarty->assign("vrednost_disable",'disabled="disabled"');	
		}
	
		function deselectTipProizvoda()
		{
			$this->productSearch->setState($this->productSearch->ProizvodjacState);
			$this->productSearch->setTipProizvoda(-1);
			$this->productSearch->setKarakteristika(-1);
			$this->productSearch->setVrednost("");
			
		}
		function deselectProizvodjac()
		{
			$this->productSearch->setState($this->productSearch->TipProizvodaState);
			$this->productSearch->setProizvodjac(-1);
		}
		
		function selectKategorijaProizvoda()
		{
			$this->productSearch->setState($this->productSearch->KategorijaProizvodaTipProizvodaProizvodjacState);
			$this->productSearch->setKategorijaProizvoda($_REQUEST["kategorijaid"]);
		}
		
		function selectKarakteristika()
		{
			$this->productSearch->setState($this->productSearch->TipProizvodaProizvodjacKarakteristikaState);
			$this->productSearch->setKarakteristika($_REQUEST["karakteristikaid"]);
		}
		
		function getQuery()
		{
			return	" SELECT * FROM pr_proizvod ".
					" WHERE 1=1 ".
					" AND tipproizvodaid=".$this->productSearch->TipProizvoda . 
					" AND proizvodjacid=".$this->productSearch->Proizvodjac .
					" AND status_id <> " .STATUS_PROIZVODA_ARHIVIRAN;
		}
		
		function getStateName()
		{
			return "TipProizvodaProizvodjacState";
		}
	}

	class StateTipProizvodaKarakteristika extends State 
	{
		function proccessState()
		{
			// prikaz svih tipova proizvoda
			// dohvatamo sve tipove proizvoda
			$this->objectFactory->ResetFilters();
			$this->objectFactory->SetSortBy("naziv");
			$tipoviproizvoda = $this->objectFactory->createObjects("PrTipProizvoda");
		
			$ShTipProizvoda = new SmartyHtmlSelection("tip", $this->productSearch->smarty);
			foreach ($tipoviproizvoda as $tip)
			{
				$ShTipProizvoda->AddValue($tip->getTipProizvodaID());
				$ShTipProizvoda->AddOutput($tip->getNaziv());
			}
			$ShTipProizvoda->AddSelected($this->productSearch->TipProizvoda);
			$ShTipProizvoda->SmartyAssign();
			
			// prikaz svih proizvodjaca koji se nalaze u izabranim tipovima proizvoda
			$proizvodjac = $this->objectFactory->createObject("PrProizvodjac",-1);
			$proizvodjaci = array();
			$upit = " SELECT DISTINCT PD.proizvodjacid, PD.naziv, PD.opis " .
					" FROM pr_proizvod P " .
					" INNER JOIN pr_proizvodjac PD ON P.proizvodjacid = PD.proizvodjacid " .
					" WHERE 1=1 ".
					" AND tipproizvodaid = ". $this->productSearch->TipProizvoda .
					" AND P.status_id <> " .STATUS_PROIZVODA_ARHIVIRAN;
			
			$results = $this->objectFactory->DBBR->con->get_results($upit);
			$proizvodjac->napuniNiz($results,$proizvodjaci);
			
			$ShProizvodjaci = new SmartyHtmlSelection("proizvodjac", $this->productSearch->smarty);
			foreach ($proizvodjaci as $pr)
			{
				$ShProizvodjaci->AddValue($pr->getProizvodjacID());
				$ShProizvodjaci->AddOutput($pr->getNaziv());
			}
			$ShProizvodjaci->AddSelected($this->productSearch->Proizvodjac);
			$ShProizvodjaci->SmartyAssign();
			
			// odlediti karateristike
			$tipproizvoda = $this->objectFactory->createObject("PrTipProizvoda",$this->productSearch->TipProizvoda,array("PrKarakteristika"));
			
			$ShKarakteristike = new SmartyHtmlSelection("karakteristike",$this->productSearch->smarty);
			foreach ($tipproizvoda->PrKarakteristika as $kar)
			{
				$ShKarakteristike->AddValue($kar->getKarakteristikaID());
				$ShKarakteristike->AddOutput($kar->getNaziv());
			}
			$ShKarakteristike->AddSelected($this->productSearch->Karakteristika);
			$ShKarakteristike->SmartyAssign();
			
			// odlediti vrednosti
			$this->objectFactory->AddFilter("karakteristikaid=".$this->productSearch->Karakteristika);
			$vrednosti = $this->objectFactory->createObjects("PrKarakteristikaProizvoda");
			$this->objectFactory->ResetFilters();
			
			$ShVrednosti = new SmartyHtmlSelection("vrednosti", $this->productSearch->smarty);
			foreach ($vrednosti as $v)
			{
				if($v->PrKarakteristikaElement->KarakteristikaElementID != "")
				{
					$karakteristikaElementa = $this->objectFactory->createObject("PrKarakteristikaElement", $v->PrKarakteristikaElement->KarakteristikaElementID);
					if(!(in_array($karakteristikaElementa->getVrednost(), $ShVrednosti->getOutput())))
					{
						$ShVrednosti->AddValue("id|".$karakteristikaElementa->getKarakteristikaElementID());
						$ShVrednosti->AddOutput($karakteristikaElementa->getVrednost());
					}
				}
				else 
				{
					if(!(in_array($v->Vrednost,$ShVrednosti->getOutput())) && $v->Vrednost != "*" && $v->Vrednost != "")
					{
						$ShVrednosti->AddValue($v->getVrednost());
						$ShVrednosti->AddOutput($v->getVrednost());
					}
				}
			}
			$ShVrednosti->SmartyAssign();
		}
		
		function selectProizvodjac()
		{
			$this->productSearch->setState($this->productSearch->TipProizvodaProizvodjacKarakteristikaState);
			$this->productSearch->setProizvodjac($_REQUEST["proizvodjacid"]);
		}
		function selectVrednost()
		{
			$this->productSearch->setState($this->productSearch->TipProizvodaKarakteristikaVrednostState);
			$this->productSearch->setVrednost($_REQUEST["vrednost"]);
		}
		
		function deselectTipProizvoda()
		{
			$this->productSearch->setState($this->productSearch->StartState);
			$this->productSearch->setTipProizvoda(-1);
			$this->productSearch->setKarakteristika(-1);
			$this->productSearch->setVrednost("");
			
		}
		function deselectKarakteristika()
		{
			$this->productSearch->setState($this->productSearch->TipProizvodaState);
			$this->productSearch->setKarakteristika(-1);
			$this->productSearch->setVrednost("");
		}
		function getQuery()
		{
			return	" SELECT * FROM pr_proizvod P ".
					" LEFT JOIN pr_karakteristikaproizvoda KP ON KP.proizvodid = P.proizvodid ".
					" WHERE 1=1 " .
					" AND tipproizvodaid=".$this->productSearch->TipProizvoda . 
					" AND KP.karakteristikaid = ".$this->productSearch->Karakteristika .
					" AND P.status_id <> " .STATUS_PROIZVODA_ARHIVIRAN;
		}
		
		function getStateName()
		{
			return "TipProizvodaKarakteristikaState";
		}
	}
	
	class StateTipProizvodaKarakteristikaVrednost extends State 
	{
		function proccessState(){
			// prikaz svih tipova proizvoda
			// dohvatamo sve tipove proizvoda
			$this->objectFactory->ResetFilters();
			$this->objectFactory->SetSortBy("naziv");
			$tipoviproizvoda = $this->objectFactory->createObjects("PrTipProizvoda");
		
			$ShTipProizvoda = new SmartyHtmlSelection("tip",$this->productSearch->smarty);
			foreach ($tipoviproizvoda as $tip)
			{
				$ShTipProizvoda->AddValue($tip->getTipProizvodaID());
				$ShTipProizvoda->AddOutput($tip->getNaziv());
			}
			$ShTipProizvoda->AddSelected($this->productSearch->TipProizvoda);
			$ShTipProizvoda->SmartyAssign();
			
			// prikaz svih proizvodjaca koji se nalaze u izabranim tipovima proizvoda
			$proizvodjac = $this->objectFactory->createObject("PrProizvodjac",-1);
			$proizvodjaci = array();
			$upit =	" SELECT DISTINCT PD.proizvodjacid, PD.naziv, PD.opis ".
					" FROM pr_proizvod P ".
					" INNER JOIN pr_proizvodjac PD ON P.proizvodjacid = PD.proizvodjacid ".
					" WHERE 1=1 " .
					" AND tipproizvodaid = ". $this->productSearch->TipProizvoda .
					" AND P.status_id <> " .STATUS_PROIZVODA_ARHIVIRAN;
					
			$results = $this->objectFactory->DBBR->con->get_results($upit);
			$proizvodjac->napuniNiz($results,$proizvodjaci);
			
			$ShProizvodjaci = new SmartyHtmlSelection("proizvodjac",$this->productSearch->smarty);
			foreach ($proizvodjaci as $pr)
			{
				$ShProizvodjaci->AddValue($pr->getProizvodjacID());
				$ShProizvodjaci->AddOutput($pr->getNaziv());
			}
			$ShProizvodjaci->AddSelected($this->productSearch->Proizvodjac);
			$ShProizvodjaci->SmartyAssign();
			
			// odlediti karateristike
			$tipproizvoda = $this->objectFactory->createObject("PrTipProizvoda",$this->productSearch->TipProizvoda,array("PrKarakteristika"));
			
			$ShKarakteristike = new SmartyHtmlSelection("karakteristike",$this->productSearch->smarty);
			foreach ($tipproizvoda->PrKarakteristika as $kar)
			{
				$ShKarakteristike->AddValue($kar->getKarakteristikaID());
				$ShKarakteristike->AddOutput($kar->getNaziv());
			}
			$ShKarakteristike->AddSelected($this->productSearch->Karakteristika);
			$ShKarakteristike->SmartyAssign();
			
			// odlediti vrednosti
			$this->objectFactory->ResetFilters();
			$this->objectFactory->AddFilter("karakteristikaid=".$this->productSearch->Karakteristika);
			$vrednosti = $this->objectFactory->createObjects("PrKarakteristikaProizvoda");
			$this->objectFactory->ResetFilters();
			
			$ShVrednosti = new SmartyHtmlSelection("vrednosti", $this->productSearch->smarty);
			foreach ($vrednosti as $v)
			{
				if($v->PrKarakteristikaElement->KarakteristikaElementID != "")
				{
					$karakteristikaElementa = $this->objectFactory->createObject("PrKarakteristikaElement", $v->PrKarakteristikaElement->KarakteristikaElementID);
					if(!(in_array($karakteristikaElementa->getVrednost(), $ShVrednosti->getOutput())))
					{
						$ShVrednosti->AddValue("id|".$karakteristikaElementa->getKarakteristikaElementID());
						$ShVrednosti->AddOutput($karakteristikaElementa->getVrednost());
					}
				}
				else 
				{
					if(!(in_array($v->Vrednost,$ShVrednosti->getOutput())) && $v->Vrednost != "*")
					{
						$ShVrednosti->AddValue($v->getVrednost());
						$ShVrednosti->AddOutput($v->getVrednost());
					}
				}
			}
			$ShVrednosti->AddSelected($this->productSearch->Vrednost);
			$ShVrednosti->SmartyAssign();
			
		}
		
		function selectProizvodjac()
		{
			$this->productSearch->setState($this->productSearch->TipProizvodaProizvodjacKarakteristikaVrednostState);
			$this->productSearch->setProizvodjac($_REQUEST["proizvodjacid"]);
		}
		
		function selectKarakteristika()
		{
			$this->productSearch->setState($this->productSearch->TipProizvodaKarakteristikaState);
			$this->productSearch->setKarakteristika($_REQUEST["karakteristikaid"]);
			$this->productSearch->setVrednost("");
		}
		
		function deselectTipProizvoda()
		{
			$this->productSearch->setState($this->productSearch->StartState);
			$this->productSearch->setTipProizvoda(-1);
			$this->productSearch->setKarakteristika(-1);
			$this->productSearch->setVrednost("");
		}
		
		function deselectKarakteristika()
		{
			$this->productSearch->setState($this->productSearch->TipProizvodaState);
			$this->productSearch->setKarakteristika(-1);
			$this->productSearch->setVrednost("");
		}
		
		function deselectVrednost()
		{
			$this->productSearch->setState($this->productSearch->TipProizvodaKarakteristikaState);
			$this->productSearch->setVrednost("");
		}
		function getQuery()
		{
			// u zavisnosti da li je izabrana vrednost koja je slobodan unos ili vrednost
			// iz vrste karakteristka elemenata
			
			if(strpos($this->productSearch->Vrednost,"id|") === false)
			{
				// upit kada je u pitanju slobodan unos
				
				return	" SELECT * FROM pr_proizvod P " .
						" LEFT JOIN pr_karakteristikaproizvoda KP ON KP.proizvodid = P.proizvodid " .
						" WHERE 1=1 ".
						" AND tipproizvodaid=".$this->productSearch->TipProizvoda . 
						" AND KP.karakteristikaid=".$this->productSearch->Karakteristika. 
						" AND KP.vrednost='".$this->productSearch->Vrednost."'".
						" AND P.status_id <> " .STATUS_PROIZVODA_ARHIVIRAN;
			}
			else 
			{
				// izbor se vrsi preko vrste karateristika elementa
				$karakteristikaElementId = substr($this->productSearch->Vrednost,strpos($this->productSearch->Vrednost,"id|")+3, strlen($this->productSearch->Vrednost));
				
				return	" SELECT * FROM pr_proizvod P " .
						" LEFT JOIN pr_karakteristikaproizvoda KP ON KP.proizvodid = P.proizvodid " .
						" LEFT JOIN pr_karakteristika_element KE ON KP.karakteristika_element_id = KE.karakteristika_element_id".
						" WHERE 1=1 ".
						" AND tipproizvodaid=".$this->productSearch->TipProizvoda . 
						" AND KP.karakteristikaid=".$this->productSearch->Karakteristika. 
						" AND KE.karakteristika_element_id='".$karakteristikaElementId."'".
						" AND P.status_id <> " .STATUS_PROIZVODA_ARHIVIRAN;
			}
		}
		
		function getStateName()
		{
			return "TipProizvodaKarakteristikaVrednostState";
		}
	}
	
	class StateTipProizvodaProizvodjacKarakteristika extends State 
	{
		function proccessState()
		{
			// na osnovu izabranog proizvodjaca 
			// filtriramo samo potrebne tipove proizvoda
			$this->objectFactory->ResetFilters();
			
			$tipoviproizvoda = array();
			$tipproizvoda = $this->objectFactory->createObject("PrTipProizvoda",-1);
			$upit =	" SELECT DISTINCT TP.tipproizvodaid, TP.naziv, TP.opis " .
					" FROM pr_proizvod P ".
					" INNER JOIN pr_tipproizvoda TP ON P.tipproizvodaid = TP.tipproizvodaid " .
					" WHERE 1=1 " .
					" AND proizvodjacid = ". $this->productSearch->Proizvodjac .
					" AND P.status_id <> " .STATUS_PROIZVODA_ARHIVIRAN .
					" ORDER BY TP.naziv ";
					
			$results = $this->objectFactory->DBBR->con->get_results($upit);
			$tipproizvoda->napuniNiz($results,$tipoviproizvoda);
			
			$ShTipProizvoda = new SmartyHtmlSelection("tip", $this->productSearch->smarty);
			foreach ($tipoviproizvoda as $tip)
			{
				$ShTipProizvoda->AddValue($tip->getTipProizvodaID());
				$ShTipProizvoda->AddOutput($tip->getNaziv());
			}
			$ShTipProizvoda->AddSelected($this->productSearch->TipProizvoda);
			$ShTipProizvoda->SmartyAssign();
			
			// prikaz svih proizvodjaca koji se nalaze u izabranom tipu proizvoda
			$proizvodjac = $this->objectFactory->createObject("PrProizvodjac",-1);
			$proizvodjaci = array();
			$upit = " SELECT DISTINCT PD.proizvodjacid, PD.naziv, PD.opis " .
					" FROM pr_proizvod P " .
					" INNER JOIN pr_proizvodjac PD ON P.proizvodjacid = PD.proizvodjacid ".
					" WHERE 1=1 " .
					" AND tipproizvodaid = ". $this->productSearch->TipProizvoda .
					" AND P.status_id <> " .STATUS_PROIZVODA_ARHIVIRAN;
			
			$results = $this->objectFactory->DBBR->con->get_results($upit);
			$proizvodjac->napuniNiz($results,$proizvodjaci);
			
			$ShProizvodjaci = new SmartyHtmlSelection("proizvodjac",$this->productSearch->smarty);
			foreach ($proizvodjaci as $pr)
			{
				$ShProizvodjaci->AddValue($pr->getProizvodjacID());
				$ShProizvodjaci->AddOutput($pr->getNaziv());
			}
			$ShProizvodjaci->AddSelected($this->productSearch->Proizvodjac);
			$ShProizvodjaci->SmartyAssign();
			
			// odlediti karateristike
			$tipproizvoda = $this->objectFactory->createObject("PrTipProizvoda",$this->productSearch->TipProizvoda,array("PrKarakteristika"));
			
			$ShKarakteristike = new SmartyHtmlSelection("karakteristike",$this->productSearch->smarty);
			foreach ($tipproizvoda->PrKarakteristika as $kar)
			{
				$ShKarakteristike->AddValue($kar->getKarakteristikaID());
				$ShKarakteristike->AddOutput($kar->getNaziv());
			}
			$ShKarakteristike->AddSelected($this->productSearch->Karakteristika);
			$ShKarakteristike->SmartyAssign();
			
			// odlediti vrednosti
			$this->objectFactory->ResetFilters();
			$this->objectFactory->AddFilter("karakteristikaid = ". $this->productSearch->Karakteristika);
			$vrednosti = $this->objectFactory->createObjects("PrKarakteristikaProizvoda");
			$this->objectFactory->ResetFilters();
			
			$ShVrednosti = new SmartyHtmlSelection("vrednosti", $this->productSearch->smarty);
			foreach ($vrednosti as $v)
			{
				if($v->PrKarakteristikaElement->KarakteristikaElementID != "")
				{
					$karakteristikaElementa = $this->objectFactory->createObject("PrKarakteristikaElement", $v->PrKarakteristikaElement->KarakteristikaElementID);
					if(!(in_array($karakteristikaElementa->getVrednost(), $ShVrednosti->getOutput())))
					{
						$ShVrednosti->AddValue("id|".$karakteristikaElementa->getKarakteristikaElementID());
						$ShVrednosti->AddOutput($karakteristikaElementa->getVrednost());
					}
				}
				else 
				{
					if(!(in_array($v->Vrednost,$ShVrednosti->getOutput())) && $v->Vrednost != "*")
					{
						$ShVrednosti->AddValue($v->getVrednost());
						$ShVrednosti->AddOutput($v->getVrednost());
					}
				}
			}
			$ShVrednosti->SmartyAssign();
		}
		
		function selectVrednost()
		{
			$this->productSearch->setState($this->productSearch->TipProizvodaProizvodjacKarakteristikaVrednostState);
			$this->productSearch->setVrednost($_REQUEST["vrednost"]);
		}
		function deselectProizvodjac()
		{
			$this->productSearch->setState($this->productSearch->TipProizvodaKarakteristikaState);
			$this->productSearch->setProizvodjac(-1);
		}
		
		function deselectTipProizvoda()
		{
			$this->productSearch->setState($this->productSearch->ProizvodjacState);
			$this->productSearch->setTipProizvoda(-1);
			$this->productSearch->setKarakteristika(-1);
			$this->productSearch->setVrednost("");
		}
		
		function deselectKarakteristika()
		{
			$this->productSearch->setState($this->productSearch->TipProizvodaProizvodjacState);
			$this->productSearch->setKarakteristika(-1);
			$this->productSearch->setVrednost("");
		}
		function getQuery()
		{
			return	" SELECT * FROM pr_proizvod P ".
					" LEFT JOIN pr_karakteristikaproizvoda KP ON KP.proizvodid = P.proizvodid ".
					" WHERE 1=1 ". 
					" AND P.tipproizvodaid=".$this->productSearch->TipProizvoda . 
					" AND P.proizvodjacid=".$this->productSearch->Proizvodjac . 
					" AND KP.karakteristikaid = ".$this->productSearch->Karakteristika.
					" AND P.status_id <> " .STATUS_PROIZVODA_ARHIVIRAN;
		}
		
		function getStateName()
		{
			return "TipProizvodaProizvodjacKarakteristikaState";
		}
	}
	
	class StateTipProizvodaProizvodjacKarakteristikaVrednost extends State 
	{
		function proccessState()
		{
			// na osnovu izabranog proizvodjaca 
			// filtriramo samo potrebne tipove proizvoda

			$this->objectFactory->ResetFilters();
			
			$tipoviproizvoda = array();
			$tipproizvoda = $this->objectFactory->createObject("PrTipProizvoda",-1);
			$upit =	" SELECT DISTINCT TP.tipproizvodaid, TP.naziv, TP.opis " .
					" FROM pr_proizvod P " . 
					" INNER JOIN pr_tipproizvoda TP ON P.tipproizvodaid = TP.tipproizvodaid ".
					" WHERE 1=1 " . 
					" AND proizvodjacid = ". $this->productSearch->Proizvodjac .
					" AND P.status_id <> " .STATUS_PROIZVODA_ARHIVIRAN . 
					" ORDER BY TP.naziv ";

			$results = $this->objectFactory->DBBR->con->get_results($upit);
			$tipproizvoda->napuniNiz($results,$tipoviproizvoda);
			
			$ShTipProizvoda = new SmartyHtmlSelection("tip", $this->productSearch->smarty);
			foreach ($tipoviproizvoda as $tip)
			{
				$ShTipProizvoda->AddValue($tip->getTipProizvodaID());
				$ShTipProizvoda->AddOutput($tip->getNaziv());
			}
			$ShTipProizvoda->AddSelected($this->productSearch->TipProizvoda);
			$ShTipProizvoda->SmartyAssign();
			
			// prikaz svih proizvodjaca koji se nalaze u izabranom tipu proizvoda
			$proizvodjac = $this->objectFactory->createObject("PrProizvodjac",-1);
			$proizvodjaci = array();
			$upit = " SELECT DISTINCT PD.proizvodjacid, PD.naziv, PD.opis ".
					" FROM pr_proizvod P " .
					" INNER JOIN pr_proizvodjac PD ON P.proizvodjacid = PD.proizvodjacid ".
					" WHERE 1=1 " .
					" AND tipproizvodaid = ". $this->productSearch->TipProizvoda .
					" AND P.status_id <> " .STATUS_PROIZVODA_ARHIVIRAN;
					
			$results = $this->objectFactory->DBBR->con->get_results($upit);
			$proizvodjac->napuniNiz($results,$proizvodjaci);
			
			$ShProizvodjaci = new SmartyHtmlSelection("proizvodjac",$this->productSearch->smarty);
			foreach ($proizvodjaci as $pr)
			{
				$ShProizvodjaci->AddValue($pr->getProizvodjacID());
				$ShProizvodjaci->AddOutput($pr->getNaziv());
			}
			$ShProizvodjaci->AddSelected($this->productSearch->Proizvodjac);
			$ShProizvodjaci->SmartyAssign();

			// odlediti karateristike
			$tipproizvoda = $this->objectFactory->createObject("PrTipProizvoda",$this->productSearch->TipProizvoda, array("PrKarakteristika"));
			
			$ShKarakteristike = new SmartyHtmlSelection("karakteristike",$this->productSearch->smarty);
			foreach ($tipproizvoda->PrKarakteristika as $kar)
			{
				$ShKarakteristike->AddValue($kar->getKarakteristikaID());
				$ShKarakteristike->AddOutput($kar->getNaziv());
			}
			$ShKarakteristike->AddSelected($this->productSearch->Karakteristika);
			$ShKarakteristike->SmartyAssign();
			
			// odlediti vrednosti
			$this->objectFactory->ResetFilters();
			$this->objectFactory->AddFilter("karakteristikaid=". $this->productSearch->Karakteristika);
			$vrednosti = $this->objectFactory->createObjects("PrKarakteristikaProizvoda");
			$this->objectFactory->ResetFilters();
			
			$ShVrednosti = new SmartyHtmlSelection("vrednosti", $this->productSearch->smarty);
			foreach ($vrednosti as $v)
			{
				if($v->PrKarakteristikaElement->KarakteristikaElementID != "")
				{
					$karakteristikaElementa = $this->objectFactory->createObject("PrKarakteristikaElement", $v->PrKarakteristikaElement->KarakteristikaElementID);
					if(!(in_array($karakteristikaElementa->getVrednost(), $ShVrednosti->getOutput())))
					{
						$ShVrednosti->AddValue("id|".$karakteristikaElementa->getKarakteristikaElementID());
						$ShVrednosti->AddOutput($karakteristikaElementa->getVrednost());
					}
				}
				else 
				{
					if(!(in_array($v->Vrednost,$ShVrednosti->getOutput())) && $v->Vrednost != "*")
					{
						$ShVrednosti->AddValue($v->getVrednost());
						$ShVrednosti->AddOutput($v->getVrednost());
					}
				}
			}
			$ShVrednosti->AddSelected($this->productSearch->Vrednost);
			$ShVrednosti->SmartyAssign();
		}

		function selectKarakteristika()
		{
			$this->productSearch->setState($this->productSearch->TipProizvodaProizvodjacKarakteristikaState);
			$this->productSearch->setKarakteristika($_REQUEST["karakteristikaid"]);
			$this->productSearch->setVrednost("");
		}
		
		function deselectProizvodjac()
		{
			$this->productSearch->setState($this->productSearch->TipProizvodaKarakteristikaVrednostState);
			$this->productSearch->setProizvodjac(-1);
		}
		
		function deselectTipProizvoda()
		{
			$this->productSearch->setState($this->productSearch->ProizvodjacState);
			$this->productSearch->setTipProizvoda(-1);
			$this->productSearch->setKarakteristika(-1);
			$this->productSearch->setVrednost("");
		}
		
		function deselectKarakteristika()
		{
			$this->productSearch->setState($this->productSearch->TipProizvodaProizvodjacState);
			$this->productSearch->setKarakteristika(-1);
			$this->productSearch->setVrednost("");
		}
		
		function deselectVrednost()
		{
			$this->productSearch->setState($this->productSearch->TipProizvodaProizvodjacKarakteristikaState);
			$this->productSearch->setVrednost("");
		}
		
		function getQuery()
		{
			// u zavisnosti da li je izabrana vrednost koja je slobodan unos ili vrednost
			// iz vrste karakteristka elemenata
			if(strpos($this->productSearch->Vrednost,"id|") === false)
			{
				// upit kada je u pitanju slobodan unos
				return	" SELECT * FROM pr_proizvod P " . 
					" LEFT JOIN pr_karakteristikaproizvoda KP ON KP.proizvodid = P.proizvodid " . 
					" WHERE 1=1 " .
					" AND tipproizvodaid=".$this->productSearch->TipProizvoda . 
					" AND proizvodjacid=".$this->productSearch->Proizvodjac . 
					" AND KP.karakteristikaid = ".$this->productSearch->Karakteristika .
					" AND KP.vrednost='".$this->productSearch->Vrednost."'" .
					" AND P.status_id <> " .STATUS_PROIZVODA_ARHIVIRAN;
			}
			else 
			{
				// izbor se vrsi preko vrste karateristika elementa
				$karakteristikaElementId = substr($this->productSearch->Vrednost,strpos($this->productSearch->Vrednost,"id|")+3,strlen($this->productSearch->Vrednost));
				
				return	" SELECT * FROM pr_proizvod P " .
						" LEFT JOIN pr_karakteristikaproizvoda KP ON KP.proizvodid = P.proizvodid " .
						" LEFT JOIN pr_karakteristika_element KE ON KP.karakteristika_element_id = KE.karakteristika_element_id ".
						" WHERE 1=1 ".
						" AND tipproizvodaid=".$this->productSearch->TipProizvoda . 
						" AND proizvodjacid=".$this->productSearch->Proizvodjac . 
						" AND KP.karakteristikaid=".$this->productSearch->Karakteristika. 
						" AND KE.karakteristika_element_id='".$karakteristikaElementId."'".
						" AND P.status_id <> " .STATUS_PROIZVODA_ARHIVIRAN;
			}
		}
		
		function getStateName()
		{
			return "TipProizvodaProizvodjacKarakteristikaVrednostState";
		}
	}
	
	// nova stanja zajedno sa kategorijom proizvoda
	
	class StateKategorijaProizvoda extends State 
	{
		function proccessState()
		{
			$this->objectFactory->ResetFilters();
			
			// TIPOVI PROIZVODA
			$tipoviproizvoda = array();
			$tipproizvoda = $this->objectFactory->createObject("PrTipProizvoda",-1);
			$upit = " SELECT DISTINCT T.tipproizvodaid, T.naziv, T.opis, T.tipproizvoda_order ".
					" FROM pr_tipproizvoda T ".
					" LEFT JOIN pr_proizvod P ON T.tipproizvodaid= P.tipproizvodaid ".
					" LEFT JOIN pr_proizvodkategorija PK ON P.proizvodid=PK.proizvodid ".
					" LEFT JOIN pr_kategorija K ON K.kategorijaid = PK.kategorijaid ".
					" WHERE K.kategorijaid = ". $this->productSearch->KategorijaProizvoda;
			$results = $this->objectFactory->DBBR->con->get_results($upit);
			$tipproizvoda->napuniNiz($results,$tipoviproizvoda);
			
			$ShTipProizvoda = new SmartyHtmlSelection("tip", $this->productSearch->smarty);
			foreach ($tipoviproizvoda as $tip)
			{
				$ShTipProizvoda->AddValue($tip->TipProizvodaID);
				$ShTipProizvoda->AddOutput($tip->Naziv);
			}
			$ShTipProizvoda->AddSelected($this->productSearch->TipProizvoda);
			$ShTipProizvoda->SmartyAssign();
			
			// PROIZVODJACI
			$proizvodjac = $this->objectFactory->createObject("PrProizvodjac", -1);
			$proizvodjaci = array();
			$upit = " SELECT DISTINCT PR.proizvodjacid, PR.naziv, PR.Opis ".
					" FROM pr_proizvodjac PR ".
					" LEFT JOIN pr_proizvod P ON PR.proizvodjacid = P.proizvodjacid ".
					" LEFT JOIN pr_proizvodkategorija PK ON P.proizvodid = PK.proizvodid ".
					" LEFT JOIN pr_kategorija K ON K.kategorijaid = PK.kategorijaid" .
					" WHERE K.kategorijaid=". $this->productSearch->KategorijaProizvoda;
			$results = $this->objectFactory->DBBR->con->get_results($upit);
			$proizvodjac->napuniNiz($results,$proizvodjaci);
			
			$ShProizvodjaci = new SmartyHtmlSelection("proizvodjac",$this->productSearch->smarty);
			foreach ($proizvodjaci as $pr)
			{
				$ShProizvodjaci->AddValue($pr->ProizvodjacID);
				$ShProizvodjaci->AddOutput($pr->Naziv);
			}
			$ShProizvodjaci->AddSelected($this->productSearch->Proizvodjac);
			$ShProizvodjaci->SmartyAssign();
			
			// KATEGORIJE PROIZVODA
			$kategorije = $this->objectFactory->createObjects("PrKategorija");
			$ShKategorije = new SmartyHtmlSelection("kategorija",$this->productSearch->smarty);
			foreach ($kategorije as $kat)
			{
				$ShKategorije->AddValue($kat->KategorijaID);
				$ShKategorije->AddOutput($kat->Naziv);
			}
			
			$ShKategorije->AddSelected($this->productSearch->KategorijaProizvoda);
			$ShKategorije->SmartyAssign();
		
		}
		
		function selectProizvodjac()
		{
			$this->productSearch->setState($this->productSearch->KategorijaProizvodaProizvodjacState);
			$this->productSearch->setProizvodjac($_REQUEST["proizvodjacid"]);
		}
		function selectTipProizvoda()
		{
			$this->productSearch->setState($this->productSearch->KategorijaProizvodaTipProizvodaState);
			$this->productSearch->setTipProizvoda($_REQUEST["tipproizvodaid"]);
		}
		
		function deselectTipProizvoda()
		{
			$this->productSearch->setState($this->productSearch->KategorijaProizvodaState);
			$this->productSearch->setTipProizvoda(-1);
		}
		
		function deselectKategorijaProizvoda()
		{
			$this->productSearch->setState($this->productSearch->StartState);
			$this->productSearch->setKategorijaProizvoda(-1);
		}
		function getQuery()
		{
			return " SELECT P.* FROM pr_proizvod P ".
				   " LEFT JOIN pr_proizvodkategorija PK ON P.proizvodid = PK.proizvodid ".
				   " LEFT JOIN pr_kategorija K ON K.kategorijaid = PK.kategorijaid ".
				   " WHERE K.kategorijaid =". $this->productSearch->KategorijaProizvoda;
		}
		
		function getStateName()
		{
			return "KategorijaProizvodaState";
		}
	}
	
	class StateKategorijaProizvodaProizvodjac extends State 
	{
		function proccessState()
		{
			$this->objectFactory->ResetFilters();
						
			// TIPOVI PROIZVODA
			$tipoviproizvoda = array();
			$tipproizvoda = $this->objectFactory->createObject("PrTipProizvoda",-1);
			$upit = " SELECT DISTINCT T.tipproizvodaid, T.naziv, T.opis, T.tipproizvoda_order ".
					" FROM pr_tipproizvoda T ".
					" LEFT JOIN pr_proizvod P ON T.tipproizvodaid= P.tipproizvodaid ".
					" LEFT JOIN pr_proizvodkategorija PK ON P.proizvodid=PK.proizvodid ".
					" LEFT JOIN pr_kategorija K ON K.kategorijaid = PK.kategorijaid ".
					" WHERE 1=1 ". 
					" AND K.kategorijaid = ". $this->productSearch->KategorijaProizvoda .
					" AND P.proizvodjacid= ". $this->productSearch->Proizvodjac;
			$results = $this->objectFactory->DBBR->con->get_results($upit);
			$tipproizvoda->napuniNiz($results,$tipoviproizvoda);
			
			$ShTipProizvoda = new SmartyHtmlSelection("tip", $this->productSearch->smarty);
			foreach ($tipoviproizvoda as $tip)
			{
				$ShTipProizvoda->AddValue($tip->TipProizvodaID);
				$ShTipProizvoda->AddOutput($tip->Naziv);
			}
			$ShTipProizvoda->AddSelected($this->productSearch->TipProizvoda);
			$ShTipProizvoda->SmartyAssign();
			
			// PROIZVODJACI
			$proizvodjac = $this->objectFactory->createObject("PrProizvodjac",-1);
			$proizvodjaci = array();
			$upit = " SELECT DISTINCT PR.proizvodjacid, PR.naziv, PR.Opis ".
					" FROM pr_proizvodjac PR ".
					" LEFT JOIN pr_proizvod P ON PR.proizvodjacid = P.proizvodjacid ".
					" LEFT JOIN pr_proizvodkategorija PK ON P.proizvodid = PK.proizvodid ".
					" LEFT JOIN pr_kategorija K ON K.kategorijaid = PK.kategorijaid" .
					" WHERE K.kategorijaid=". $this->productSearch->KategorijaProizvoda;
			$results = $this->objectFactory->DBBR->con->get_results($upit);
			$proizvodjac->napuniNiz($results,$proizvodjaci);
			
			$ShProizvodjaci = new SmartyHtmlSelection("proizvodjac",$this->productSearch->smarty);
			foreach ($proizvodjaci as $pr)
			{
				$ShProizvodjaci->AddValue($pr->ProizvodjacID);
				$ShProizvodjaci->AddOutput($pr->Naziv);
			}
			$ShProizvodjaci->AddSelected($this->productSearch->Proizvodjac);
			$ShProizvodjaci->SmartyAssign();
			
			// KATEGORIJE PROIZVODA
			$kategorija = $this->objectFactory->createObject("PrKategorija",-1);
			$kategorije = array();
			$upit = " SELECT DISTINCT K.kategorijaid, K.naziv, K.opis ".
					" FROM pr_proizvodjac PR ".
					" LEFT JOIN pr_proizvod P ON PR.proizvodjacid = P.proizvodjacid ".
					" LEFT JOIN pr_proizvodkategorija PK ON P.proizvodid = PK.proizvodid ".
					" LEFT JOIN pr_kategorija K ON K.kategorijaid = PK.kategorijaid" .
					" WHERE P.proizvodjacid=". $this->productSearch->Proizvodjac;
			$results = $this->objectFactory->DBBR->con->get_results($upit);
			$kategorija->napuniNiz($results,$kategorije);
			$ShKategorije = new SmartyHtmlSelection("kategorija",$this->productSearch->smarty);
			foreach ($kategorije as $kat)
			{
				$ShKategorije->AddValue($kat->KategorijaID);
				$ShKategorije->AddOutput($kat->Naziv);
			}
			
			$ShKategorije->AddSelected($this->productSearch->KategorijaProizvoda);
			$ShKategorije->SmartyAssign();
		}
		
		function selectTipProizvoda()
		{
			$this->productSearch->setState($this->productSearch->KategorijaProizvodaTipProizvodaProizvodjacState);
			$this->productSearch->setTipProizvoda($_REQUEST["tipproizvodaid"]);
		}
		function deselectProizvodjac()
		{
			$this->productSearch->setState($this->productSearch->KategorijaProizvodaState);
			$this->productSearch->setProizvodjac(-1);
		}
		function deselectKategorijaProizvoda()
		{
			$this->productSearch->setState($this->productSearch->ProizvodjacState);
			$this->productSearch->setKategorijaProizvoda(-1);
		}
		
		function getQuery()
		{
			return " SELECT P.* FROM pr_proizvod P ".
				   " LEFT JOIN pr_proizvodkategorija PK ON P.proizvodid = PK.proizvodid ".
				   " LEFT JOIN pr_kategorija K ON K.kategorijaid = PK.kategorijaid ".
				   " WHERE 1=1 ".
				   " AND K.kategorijaid =". $this->productSearch->KategorijaProizvoda.
				   " AND P.proizvodjacid =". $this->productSearch->Proizvodjac;
		}
		
		function getStateName()
		{
			return "KategorijaProizvodaProizvodjacState";
		}
	}
	class StateKategorijaProizvodaTipProizvoda extends State 
	{
		function proccessState()
		{
			$this->objectFactory->ResetFilters();
						
			// TIPOVI PROIZVODA
			$tipoviproizvoda = array();
			$tipproizvoda = $this->objectFactory->createObject("PrTipProizvoda",-1);
			$upit = " SELECT DISTINCT T.tipproizvodaid, T.naziv, T.opis, T.tipproizvoda_order ".
					" FROM pr_tipproizvoda T ".
					" LEFT JOIN pr_proizvod P ON T.tipproizvodaid= P.tipproizvodaid ".
					" LEFT JOIN pr_proizvodkategorija PK ON P.proizvodid=PK.proizvodid ".
					" LEFT JOIN pr_kategorija K ON K.kategorijaid = PK.kategorijaid ".
					" WHERE 1=1 ". 
					" AND K.kategorijaid = ". $this->productSearch->KategorijaProizvoda;
			
			$results = $this->objectFactory->DBBR->con->get_results($upit);
			$tipproizvoda->napuniNiz($results,$tipoviproizvoda);
			
			$ShTipProizvoda = new SmartyHtmlSelection("tip", $this->productSearch->smarty);
			foreach ($tipoviproizvoda as $tip)
			{
				$ShTipProizvoda->AddValue($tip->TipProizvodaID);
				$ShTipProizvoda->AddOutput($tip->Naziv);
			}
			$ShTipProizvoda->AddSelected($this->productSearch->TipProizvoda);
			$ShTipProizvoda->SmartyAssign();
			
			// PROIZVODJACI
			$proizvodjac = $this->objectFactory->createObject("PrProizvodjac",-1);
			$proizvodjaci = array();
			$upit = " SELECT DISTINCT PR.proizvodjacid, PR.naziv, PR.Opis ".
					" FROM pr_proizvodjac PR ".
					" LEFT JOIN pr_proizvod P ON PR.proizvodjacid = P.proizvodjacid ".
					" LEFT JOIN pr_proizvodkategorija PK ON P.proizvodid = PK.proizvodid ".
					" LEFT JOIN pr_kategorija K ON K.kategorijaid = PK.kategorijaid" .
					" WHERE K.kategorijaid=". $this->productSearch->KategorijaProizvoda;
					" WHERE P.tipproizvodaid=". $this->productSearch->TipProizvoda;
			$results = $this->objectFactory->DBBR->con->get_results($upit);
			$proizvodjac->napuniNiz($results,$proizvodjaci);
			
			$ShProizvodjaci = new SmartyHtmlSelection("proizvodjac",$this->productSearch->smarty);
			foreach ($proizvodjaci as $pr)
			{
				$ShProizvodjaci->AddValue($pr->ProizvodjacID);
				$ShProizvodjaci->AddOutput($pr->Naziv);
			}
			$ShProizvodjaci->AddSelected($this->productSearch->Proizvodjac);
			$ShProizvodjaci->SmartyAssign();
			
			// KATEGORIJE PROIZVODA
			$kategorija = $this->objectFactory->createObject("PrKategorija",-1);
			$kategorije = array();
		 	$upit = " SELECT DISTINCT K.kategorijaid, K.naziv, K.opis ".
					" FROM pr_proizvod P ".
					" LEFT JOIN pr_proizvodkategorija PK ON P.proizvodid = PK.proizvodid ".
					" LEFT JOIN pr_kategorija K ON K.kategorijaid = PK.kategorijaid" .
					" WHERE P.tipproizvodaid=". $this->productSearch->TipProizvoda;
			
		 	$results = $this->objectFactory->DBBR->con->get_results($upit);
			$kategorija->napuniNiz($results,$kategorije);
			$ShKategorije = new SmartyHtmlSelection("kategorija",$this->productSearch->smarty);
			foreach ($kategorije as $kat)
			{
				$ShKategorije->AddValue($kat->KategorijaID);
				$ShKategorije->AddOutput($kat->Naziv);
			}
			
			$ShKategorije->AddSelected($this->productSearch->KategorijaProizvoda);
			$ShKategorije->SmartyAssign();
		}
		
		function deselectTipProizvoda()
		{
			$this->productSearch->setState($this->productSearch->KategorijaProizvodaState);
			$this->productSearch->setTipProizvoda(-1);
		}
		function selectProizvodjac()
		{
			$this->productSearch->setState($this->productSearch->KategorijaProizvodaTipProizvodaProizvodjacState);
			$this->productSearch->setProizvodjac($_REQUEST["proizvodjacid"]);
		}
		function deselectKategorijaProizvoda()
		{
			$this->productSearch->setState($this->productSearch->TipProizvodaState);
			$this->productSearch->setKategorijaProizvoda(-1);
		}

		function getQuery()
		{
			return " SELECT P.* FROM pr_proizvod P ".
				   " LEFT JOIN pr_proizvodkategorija PK ON P.proizvodid = PK.proizvodid ".
				   " LEFT JOIN pr_kategorija K ON K.kategorijaid = PK.kategorijaid ".
				   " WHERE 1=1 ".
				   " AND K.kategorijaid =". $this->productSearch->KategorijaProizvoda.
				   " AND P.tipproizvodaid =". $this->productSearch->TipProizvoda;
		}
		
		function getStateName()
		{
			return "KategorijaProizvodaTipProizvodaState";
		}
	}
	class StateKategorijaProizvodaTipProizvodaProizvodjac extends State 
	{
		function proccessState()
		{
			$this->objectFactory->ResetFilters();
			
			// TIPOVI PROIZVODA
			$tipoviproizvoda = array();
			$tipproizvoda = $this->objectFactory->createObject("PrTipProizvoda",-1);
			$upit = " SELECT DISTINCT T.tipproizvodaid, T.naziv, T.opis, T.tipproizvoda_order ".
					" FROM pr_tipproizvoda T ".
					" LEFT JOIN pr_proizvod P ON T.tipproizvodaid= P.tipproizvodaid ".
					" LEFT JOIN pr_proizvodkategorija PK ON P.proizvodid=PK.proizvodid ".
					" LEFT JOIN pr_kategorija K ON K.kategorijaid = PK.kategorijaid ".
					" WHERE 1=1 ". 
					" AND K.kategorijaid = ". $this->productSearch->KategorijaProizvoda .
					" AND P.proizvodjacid = ". $this->productSearch->Proizvodjac;
			$results = $this->objectFactory->DBBR->con->get_results($upit);
			$tipproizvoda->napuniNiz($results,$tipoviproizvoda);
			
			$ShTipProizvoda = new SmartyHtmlSelection("tip", $this->productSearch->smarty);
			foreach ($tipoviproizvoda as $tip)
			{
				$ShTipProizvoda->AddValue($tip->TipProizvodaID);
				$ShTipProizvoda->AddOutput($tip->Naziv);
			}
			$ShTipProizvoda->AddSelected($this->productSearch->TipProizvoda);
			$ShTipProizvoda->SmartyAssign();
			
			// PROIZVODJACI
			$proizvodjac = $this->objectFactory->createObject("PrProizvodjac",-1);
			$proizvodjaci = array();
			$upit = " SELECT DISTINCT PR.proizvodjacid, PR.naziv, PR.Opis ".
					" FROM pr_proizvodjac PR ".
					" LEFT JOIN pr_proizvod P ON PR.proizvodjacid = P.proizvodjacid ".
					" LEFT JOIN pr_proizvodkategorija PK ON P.proizvodid = PK.proizvodid ".
					" LEFT JOIN pr_kategorija K ON K.kategorijaid = PK.kategorijaid" .
					" WHERE K.kategorijaid=". $this->productSearch->KategorijaProizvoda;
					" AND P.tipproizvodaid=". $this->productSearch->TipProizvoda;
			$results = $this->objectFactory->DBBR->con->get_results($upit);
			$proizvodjac->napuniNiz($results,$proizvodjaci);
			
			$ShProizvodjaci = new SmartyHtmlSelection("proizvodjac",$this->productSearch->smarty);
			foreach ($proizvodjaci as $pr)
			{
				$ShProizvodjaci->AddValue($pr->ProizvodjacID);
				$ShProizvodjaci->AddOutput($pr->Naziv);
			}
			$ShProizvodjaci->AddSelected($this->productSearch->Proizvodjac);
			$ShProizvodjaci->SmartyAssign();
			
			// KATEGORIJE PROIZVODA
			$kategorija = $this->objectFactory->createObject("PrKategorija",-1);
			$kategorije = array();
			$upit = " SELECT DISTINCT K.kategorijaid, K.naziv, K.opis ".
					" FROM pr_proizvodjac PR ".
					" LEFT JOIN pr_proizvod P ON PR.proizvodjacid = P.proizvodjacid ".
					" LEFT JOIN pr_proizvodkategorija PK ON P.proizvodid = PK.proizvodid ".
					" LEFT JOIN pr_kategorija K ON K.kategorijaid = PK.kategorijaid" .
					" WHERE P.tipproizvodaid=". $this->productSearch->TipProizvoda .
					" AND P.proizvodjacid=". $this->productSearch->Proizvodjac;
			$results = $this->objectFactory->DBBR->con->get_results($upit);
			$kategorija->napuniNiz($results,$kategorije);
			$ShKategorije = new SmartyHtmlSelection("kategorija",$this->productSearch->smarty);
			foreach ($kategorije as $kat)
			{
				$ShKategorije->AddValue($kat->KategorijaID);
				$ShKategorije->AddOutput($kat->Naziv);
			}
			
			$ShKategorije->AddSelected($this->productSearch->KategorijaProizvoda);
			$ShKategorije->SmartyAssign();
		}
		function deselectTipProizvoda()
		{
			$this->productSearch->setState($this->productSearch->KategorijaProizvodaProizvodjacState);
			$this->productSearch->setTipProizvoda(-1);
		}
		function deselectProizvodjac()
		{
			$this->productSearch->setState($this->productSearch->KategorijaProizvodaTipProizvodaState);
			$this->productSearch->setProizvodjac(-1);
		}
		function deselectKategorijaProizvoda()
		{
			$this->productSearch->setState($this->productSearch->TipProizvodaProizvodjacState);
			$this->productSearch->setKategorijaProizvoda(-1);
		}
		function getQuery()
		{
			return " SELECT P.* FROM pr_proizvod P ".
				   " LEFT JOIN pr_proizvodkategorija PK ON P.proizvodid = PK.proizvodid ".
				   " LEFT JOIN pr_kategorija K ON K.kategorijaid = PK.kategorijaid ".
				   " WHERE 1=1 ".
				   " AND K.kategorijaid =". $this->productSearch->KategorijaProizvoda.
				   " AND P.tipproizvodaid =". $this->productSearch->TipProizvoda;
				   " AND P.proizvodjacid =". $this->productSearch->Proizvodjac;
		}
		
		function getStateName()
		{
			return "KategorijaProizvodaTipProizvodaProizvodjacState";
		}
	}
?>