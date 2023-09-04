<?
	include_once("plugins/plg_products/productsPlugin.php");
	class grupaproizvodPlugin extends productsPlugin 
	{
		public $GrupaProizvodaID;
		private $GrupaProizvodaTree;
		private $debug = false;
				
		function __construct()
		{
			parent::__construct();	
			$this->GrupaProizvodaTree = new MemTree();
		}
		
		function setFilterID($filterid)
		{
			$this->GrupaProizvodaID = $filterid;
		}
		
		function showDefault()
		{
			$this->FillGrupaProizvodaTree();

			// ako izabrana grupa proizvoda nema ni dece ni roditelja radi se o osnovnoj varijanti prikaza
			// gde se listaju samo proizvodi te grupe proizvoda
			if(!$this->GrupaProizvodaTree->HasTreeItemChildren($this->GrupaProizvodaID))
			{
				return $this->showDefaultSimpleView();
			}
			// ako izabrana grupa proizvoda ima decu ili ako ima roditelja
			// u naprednom rezimu
			if($this->GrupaProizvodaTree->HasTreeItemChildren($this->GrupaProizvodaID))
			{
				return $this->showDefaultComplexView();
			}
		}

		function showDefaultComplexView()
		{
			$this->SetProductPluginLanguage();

			$grupaproizvoda = $this->GrupaProizvodaTree->FindItemById($this->GrupaProizvodaID);

			$podgrupe = $this->GrupaProizvodaTree->FindItemsByParentID($this->GrupaProizvodaID);
			
			$podgrupe_smarty = array();
			foreach ($podgrupe as $podgrupa)
			{
				$templateLink = "";
				if($podgrupa->getTemplateId() != "") $templateLink = "&tid=".$podgrupa->getTemplateId();
				
				$linkCatalogGrupaProizvod= new LinkCatalogGrupaProizvod($this->LanguageHelper,$this->getPageID(),$podgrupa->getID(), $podgrupa->getTitle());
				//$podgrupeLink = $this->LanguageHelper->GetPrintLink($linkCatalogGrupaProizvod);
				
				$podgrupeLink = "index.php?".$this->getPageLink().$templateLink."&grupaproizvodaid=".$podgrupa->getID()."&plugin=grupaproizvod&plugin_view=complex_details";
				$podgrupeSmarty[] = array(
										"naziv" => $podgrupa->getTitle(), 
										"grupaproizvodaid" => $podgrupa->getID(),
										"link" => $podgrupeLink,
										"proizvodcount" => $this->GrupaProizvodaTree->GetSumCount($podgrupa->getID()));
			}
			
			$smartyData = array(
								"grupaproizvoda_view" => "COMPLEX_VIEW",
								"podgrupe" => $podgrupeSmarty,
								"PATH" => $grupaproizvoda->getTitle(),
								"PHP_SELF" =>	$_SERVER["PHP_SELF"]."?".$_SERVER["QUERY_STRING"],
								"PAGE_LINK" => $this->getPageLink(),
								"BACK_URL" => $_SERVER['QUERY_STRING'],
								"PARENT_TITLE" 	=>$grupaproizvoda->getTitle(),
								"MASTER_TITLE" =>$this->getTranslation("PLG_PRODUCT_TITLE")." - ".$grupaproizvoda->getTitle()
								);
			
			$this->SmartyPluginBlock->setData($smartyData);
			$this->SmartyPluginBlock->setPosition($this->getPosition());
			$this->SmartyPluginBlock->setName("plg_grupaproizvod_default");
			
			return $this->SmartyPluginBlock->toArray();
		}
		
		function showDefaultSimpleView()
		{	
			//$paginate_url = "?".$this->getPageLink()."&grupaproizvodaid=".$this->GrupaProizvodaID;	
			$paginate_url = "?".$this->getPageLink();	
			// na osnovu grupe proizvoda i statusa proizvoda izvlacimo sve proizvodjace koji postoje 
			$proizvodjaci = array();
			
			$proizvodjacTable = $this->LanguageHelper->ChangeTableNameR("pr_proizvodjac");
			$proizvodTable = $this->LanguageHelper->ChangeTableNameR("pr_proizvod");
			$proizvodGrupaProizvodaTable = $this->LanguageHelper->ChangeTableNameR("pr_proizvodgrupaproiz");
			
			// dohvatiti sve proizvodjace koji se pojavljuju u ovom tipu proizvoda
			$query = "SELECT distinct p.* FROM $proizvodjacTable p ".
						" LEFT JOIN $proizvodTable pr on pr.proizvodjacid = p.proizvodjacid " .
						" LEFT JOIN $proizvodGrupaProizvodaTable pgp on pgp.proizvodid = pr.proizvodid " .
					" WHERE 1=1 ".
					" AND pgp.grupaproizvodaid = " . $this->GrupaProizvodaID .
					" AND (pr.status_id=". STATUS_PROIZVODA_AKTIVAN. " OR pr.status_id=". STATUS_PROIZVODA_NEMANALAGERU.")";
			
			$result = $this->ObjectFactory->DBBR->con->get_results($query);
			if ($this->debug) { $this->ObjectFactory->DBBR->con->debug();}
			
			$odo = new PrProizvodjac();
			$odo->napuniNiz($result, $proizvodjaci);
			
			$queryCount = "SELECT count(*) as total FROM $proizvodGrupaProizvodaTable WHERE grupaproizvodaid = ". quote_smart($this->GrupaProizvodaID);
			$result = $this->ObjectFactory->DBBR->con->get_row($queryCount);
			if ($this->debug) { $this->ObjectFactory->DBBR->con->debug();}
			
			$this->InitSmartyPaginate($paginate_url,$result->total); // prikazujemo sve proizvode iz grupe proizvoda !!!
			
			$this->PrepareProductByPageCombo();
			$this->PrepareProductSortByCombo();
			$this->InitProductManufacturersCombo();
			$this->AssignManufacturers($proizvodjaci);
			
			$this->SetProductPluginLanguage();
			$this->ObjectFactory->Reset();
			$this->ObjectFactory->SetSortBy("proizvodgrupaproiz_order", "asc");
			$grupaproizvoda = $this->ObjectFactory->createObject("PrGrupaProizvoda",$this->GrupaProizvodaID,array("PrProizvod"));
			$this->ObjectFactory->Reset();
			
			$proizvod_ids = $grupaproizvoda->PrProizvodList->GetProizvodIDs();

			$proizvod_query=""; $proizvod_queryand = "";
			if(strlen($proizvod_ids)> 0)
			{
				$proizvod_query = "proizvodid IN (". $proizvod_ids .")";
				$proizvod_queryand = "proizvodid IN (". $proizvod_ids .") AND";
			}
			else 
			{
				$proizvod_query = "1=2";
				$proizvod_queryand = "1=2 AND";
			}

			$proizvodi = $this->PaginateArray($grupaproizvoda->PrProizvodList, $this->GetProductsByPage(), $this->GetSmartyPaginateIndex());

			$proizvodKategorijaTable = $this->LanguageHelper->ChangeTableNameR("pr_proizvodkategorija");
			$kategorijaTable = $this->LanguageHelper->ChangeTableNameR("pr_kategorija");
			
			// ucitavamo i kategorije za proizvode koji su uhvaceni paginacijom
			foreach($proizvodi as $proizvod)
			{
				$kategorije=array();
				$kategorijeQuery = "SELECT k.* FROM $proizvodKategorijaTable kp LEFT JOIN $kategorijaTable k ON k.kategorijaid = kp.kategorijaid WHERE kp.proizvodid=" . $proizvod->getProizvodID();
				$result = $this->ObjectFactory->DBBR->con->get_results($kategorijeQuery);
				if ($this->debug) { $this->ObjectFactory->DBBR->con->debug();}
			
				$odo = new PrKategorija();
				$odo->napuniNiz($result, $kategorije);
				
				$proizvod->setPrKategorija($kategorije);
				$usertip = $this->GetUserType();
				$this->smarty->assign ( "cenatip", "(vp cena)");
				if ($usertip==1) 
				{	
					$this->smarty->assign ( "cenatip", "(sa PDV-om)");
					$proizvod->CenaA=$proizvod->getCenaAMP();
					$proizvod->CenaB=$proizvod->getCenaBMP();
					$proizvod->CenaAFormatirano=$proizvod->getCenaAMPFormatirano();
					$proizvod->CenaBFormatirano=$proizvod->getCenaBMPFormatirano();
				}	
			}
		
			$proizvod_dummy =$this->ObjectFactory->createObject("PrProizvod",-1); 
			$paginate_limit = $this->GetProductsByPage();
			$paginate_total = $this->ObjectFactory->DBBR->prebrojSveSlogove($proizvod_dummy, array($proizvod_queryand ."  (status_id=".STATUS_PROIZVODA_AKTIVAN. " OR status_id=". STATUS_PROIZVODA_NEMANALAGERU.")"));
			
			// paginacija proizvoda
			$this->ProccessSmartyPaginate($paginate_limit, $paginate_total);

			// priprema proizvoda za smarty
			$proizvodi_all = $this->ProizvodiToArray($proizvodi, "grupaproizvod");


			$smartyData = array(
								"grupaproizvoda_view" => "SIMPLE_VIEW",
								"proizvodi_all" => $proizvodi_all,
								"paginate" => $this->SmartyPaginateToArray(),
								"offsetName" => $this->getPosition(),
								"PATH" => $grupaproizvoda->getNaziv(),
								"PHP_SELF" =>	$_SERVER["PHP_SELF"]."?".$_SERVER["QUERY_STRING"],
								"PAGE_LINK" => $this->getPageLink(),
								"BACK_URL" => $_SERVER['QUERY_STRING'],
								"PARENT_TITLE" 	=>$grupaproizvoda->getNaziv(),
								"MASTER_TITLE" =>$this->getTranslation("PLG_PRODUCT_TITLE")." - ".$grupaproizvoda->getNaziv()
								);
			
			$this->SmartyPluginBlock->setData($smartyData);
			$this->SmartyPluginBlock->setPosition($this->getPosition());
			$this->SmartyPluginBlock->setName("plg_grupaproizvod_default");
			return $this->SmartyPluginBlock->toArray();
		}
		
		function showDetails()
		{
			if(isset($_REQUEST["plugin_view"]) && $_REQUEST["plugin_view"] == "product_details" 
				|| ( 
					(isset($_REQUEST["plugin_view"]) && $_REQUEST["plugin_view"] == "complex_details") && isset($_REQUEST["proizvodid"])
					) 
				)
			{
				$this->showDetailsSimpleView();
			}
			
			if(isset($_REQUEST["plugin_view"]) && $_REQUEST["plugin_view"] == "complex_details")
			{
				$this->showDetailsComplexView();
			}
		}
		
		function showDetailsSimpleView()
		{
			$this->smarty->assign("plg_product_details","true");
			$this->smarty->assign($this->ProizvodDetailToArray());
		}
		
		function showDetailsComplexView()
		{
			if(isset($_REQUEST["grupaproizvodaid"]))
			{
				$this->GrupaProizvodaID = $_REQUEST["grupaproizvodaid"];
				
				$this->FillGrupaProizvodaTree();
				$podgrupe = $this->GrupaProizvodaTree->FindItemsByParentID($this->GrupaProizvodaID);
				
				$podgrupeSmarty = array();
				foreach ($podgrupe as $podgrupa)
				{
					$templateLink = "";
					if($podgrupa->getTemplateId() != "") $templateLink = "&tid=".$podgrupa->getTemplateId();
					
					$linkCatalogGrupaProizvod= new LinkCatalogGrupaProizvod($this->LanguageHelper,$this->getPageID(),$podgrupa->getID(), $podgrupa->getTitle());
				
					$podgrupeLink = "index.php?".$this->getPageLink().$templateLink."&grupaproizvodaid=".$podgrupa->getID()."&plugin=grupaproizvod&plugin_view=complex_details";
				
					$podgrupeSmarty[] = array(
											"naziv" => $podgrupa->getTitle(), 
											"grupaproizvodaid" => $podgrupa->getID(),
											"link" => $podgrupeLink,
											"proizvodcount" => $this->GrupaProizvodaTree->GetSumCount($podgrupa->getID()));
				}
				
				$paginate_url = "?".$this->getPageLink()."&plugin=grupaproizvod&plugin_view=complex_details&grupaproizvodaid=".$this->GrupaProizvodaID;	
				
				$paginateHelper = new PaginateHelper($paginate_url);
				$this->ObjectFactory->SetSortBy("proizvodgrupaproiz_order desc");
				// za definisanu grupu proizvoda ucitavamo sve njene proizvode
				//$this->ObjectFactory->SetDebugOn();
				$grupaproizvoda = $this->ObjectFactory->createObject("PrGrupaProizvoda",$this->GrupaProizvodaID,array("PrProizvod"));
				//$this->ObjectFactory->SetDebugOff();
				$proizvod_query = $grupaproizvoda->PrProizvodList->GetProizvodIDsQueryIN();
				
				$this->PrepareProductByPageCombo();
				$this->PrepareProductSortByCombo();
				$this->PrepareProductManufacturersCombo($grupaproizvoda->PrProizvodList->GetProizvodIDsArray());
				$this->SetProductPluginLanguage();
				
				$filterProizvodjacAnd = "";
				if($this->manufacturerbypage != -1)
				{
					$filterProizvodjacAnd = " AND proizvodjacid = " .$this->manufacturerbypage;	
				}

				$paginateHelper->setLimit($this->GetProductsByPage());
				$paginateHelper->setTotal($this->ObjectFactory->DBBR->prebrojSveSlogove($this->ObjectFactory->createObject("PrProizvod",-1), array($proizvod_query ." AND  (status_id=".STATUS_PROIZVODA_AKTIVAN. " OR status_id=". STATUS_PROIZVODA_NEMANALAGERU." OR status_id=". STATUS_PROIZVODA_MALILAGER.")". $filterProizvodjacAnd)));
				
				// sortiranje se vrsi u baznoj klasi na osnovu izbora iz comboboxa
				$proizvodiSortirani = $this->SortProizvodiByProductSortBy($grupaproizvoda->PrProizvodList);
				$proizvodiSortiraniPoProizvodjacu = $this->FilterPoProizvodjacu($proizvodiSortirani);
				$proizvodi = $this->PaginateArray($proizvodiSortiraniPoProizvodjacu, $paginateHelper->GetPaginateLimit(), $paginateHelper->GetPaginateOffset());
				
				
				$templateLink = ""; 
				if(isset($_REQUEST["tid"]) && is_numeric($_REQUEST["tid"]))	
				{
					$templateLink = "&tid=" . $_REQUEST["tid"];
				}
				
				// priprema proizvoda za smarty
				$proizvodi_all = $this->ProizvodiKatalogToArray($proizvodi, $this->getPageID(), $this->getGrupaProizvodaID());
				
				// change default links
				foreach($this->GrupaProizvodaTree->GetItems() as $item)
				{
					$item->setLink("index.php?".$this->getPageLink()."&grupaproizvodaid=".$item->getID()."&plugin=grupaproizvod&plugin_view=complex_details");
				}
				
				$smartyData = array(
									"grupaproizvoda_view" => "SIMPLE_VIEW",
									"proizvodi_all" => $proizvodi_all,
									"paginate" => $paginateHelper->toArray(),
									"offsetName" => "default",
									"PATH" => $this->GrupaProizvodaTree->DrawPath($this->GrupaProizvodaID,$this->GrupaProizvodaID),
									"PHP_SELF" =>	$_SERVER["PHP_SELF"]."?".$_SERVER["QUERY_STRING"],
									"PAGE_LINK" => $this->getPageLink(),
									"BACK_URL" => $_SERVER['QUERY_STRING'],
									"PARENT_TITLE" 	=>$grupaproizvoda->getNaziv(),
									"MASTER_TITLE" =>$this->getTranslation("PLG_PRODUCT_TITLE")." - ".$grupaproizvoda->getNaziv()
									);

				$this->smarty->assign("header", $grupaproizvoda->getNaziv());
				$this->smarty->assign("podgrupe", $podgrupeSmarty);
				$this->smarty->assign("groupdata" , $smartyData);				
				$this->smarty->assign("plg_grupaproizvoda_details","true");
				$this->smarty->assign("grupaproizvoda_view", "COMPLEX_VIEW");
				
			}
		}
		
		function FillGrupaProizvodaTree()
		{
			$proizvodGrupaProizvodaTable = $this->LanguageHelper->ChangeTableNameR("pr_proizvodgrupaproiz");
			$proizvodTable = $this->LanguageHelper->ChangeTableNameR("pr_proizvod");
			$grupaProizvodaTable = $this->LanguageHelper->ChangeTableNameR("pr_grupaproizvoda");

			$grupaproizvoda = $this->ObjectFactory->createObject("PrGrupaProizvoda", -1);
			
				// sa prebrojavanjem proizvoda u grupi
				/*$query = "SELECT " .
					" grupaproizvodaid, parentid, naziv, templateid, (SELECT COUNT(*) ".
					" FROM $proizvodGrupaProizvodaTable PG LEFT JOIN $proizvodTable P ON P.proizvodid = PG.proizvodid " . 
					" WHERE 1=1 " .
					" AND (P.status_id=". STATUS_PROIZVODA_AKTIVAN. " OR P.status_id=". STATUS_PROIZVODA_NEMANALAGERU.") ".
					" AND PG.grupaproizvodaid = G.grupaproizvodaid) as countproizvodi ".
				    "FROM $grupaProizvodaTable as G WHERE 1=1 ORDER BY parentid, grupaproizvoda_order";*/

				// bez prebrojavanja proizvoda u grupi	
				$query = "SELECT " .
					" grupaproizvodaid, parentid, naziv, templateid,  ".
					" AND PG.grupaproizvodaid = G.grupaproizvodaid) as countproizvodi ".
				    "FROM $grupaProizvodaTable as G WHERE 1=1 ORDER BY parentid, grupaproizvoda_order";	
			$results = $this->DatabaseBroker->con->get_results($query);

			if ($this->debug) { $this->ObjectFactory->DBBR->con->debug();}
			
			$grupeproizvoda = array();
			$grupaproizvoda->napuniNiz($results, $grupeproizvoda);
			
			if(count($grupeproizvoda) > 0)
			{
				$grpArray = array();
				foreach($grupeproizvoda as $grupaProizvoda)
					$query1="SELECT pr_proizvodgrupaproiz.proizvodid  FROM pr_proizvodgrupaproiz, pr_proizvod as P  WHERE 1=1 " . " AND pr_proizvodgrupaproiz.proizvodid=P.proizvodid AND pr_proizvodgrupaproiz.grupaproizvodaid = ".$grupaProizvoda->GrupaProizvodaID." AND (P.status_id=" . STATUS_PROIZVODA_AKTIVAN . " OR P.status_id=" . STATUS_PROIZVODA_NEMANALAGERU . " OR P.status_id = ".STATUS_PROIZVODA_POZOVITE." OR P.status_id = ".STATUS_PROIZVODA_MALILAGER.")";
					$results1 = $this->DatabaseBroker->con->get_results ( $query1 );
					$cnt=count($results1);
					$grupaProizvoda->CountProizvodi=$cnt;	
				
					$grpArray[] = $grupaProizvoda->toArrayHierarchy();
				
				$this->GrupaProizvodaTree->FillItems($grpArray);
			}
		}
		function GetPopust()
		{
			// default popust koji ide generalno svim korisnicima koji nisu ulogovani
			$popust = 0;
			// popust koji se cita iz logovanog korisnika
			if(isset($_SESSION["logeduserid"]))
			{
				$userid = $_SESSION["logeduserid"];
				$user = $this->ObjectFactory->createObject("User", $userid);
				$popust = $user->getDiscount();
			}
			return $popust;
		}
		function GetUserType()
		{
			// default tip user-a koji ide svim user-ima koji nisu ulogovani
			$usertip = 1;
			// tip korisnika koji se cita iz logovanog korisnika
			if(isset($_SESSION["logeduserid"]))
			{
				$userid = $_SESSION["logeduserid"];
				$user = $this->ObjectFactory->createObject("User", $userid);
				$usertip = $user->SfUserType->getUserTypeID();
			}
			return $usertip;
		}
		
		
	}
?>