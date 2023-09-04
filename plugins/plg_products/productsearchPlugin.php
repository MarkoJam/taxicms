<?
	include_once("productsPlugin.php");
	include_once("productSearch.php");
	
	class productsearchPlugin extends productsPlugin 
	{
		private $productSearch;	
		private $SmartyData = array();
		
		function __construct()
		{
			parent::__construct();
			$this->productSearch = new ProductSearch($this->smarty);
		}
		
		function showDefault()
		{
			$this->SetPluginLanguage("product");
			$this->handleEvents();
			
			$this->productSearch->proccessState();
			
			$this->SmartyPluginBlock->setData($this->SmartyData);
			$this->SmartyPluginBlock->setPosition($this->Position);
			$this->SmartyPluginBlock->setName("plg_productsearch_default");
			
			return $this->SmartyPluginBlock->toArray();
		}
		
		function showDetails()
		{
			if(isset($_REQUEST["event"]) || !(isset($_REQUEST["standardpretraga"]) || isset($_REQUEST["naziv"])) && $this->productSearch->TipProizvoda != -1 || $this->productSearch->Proizvodjac != -1 || $this->productSearch->Karakteristika != -1 || $this->productSearch->Vrednost != "")
			{
				$querySearch = $this->productSearch->currentState->getQuery();
				$totalProductCount = $this->productSearch->currentState->getTotalProizvodCount();
				
				$this->renderProducts($querySearch, $totalProductCount, "");
			}
			
			$this->smarty->assign("plg_productsearch_details", "true");
		}
		
		function deselectAll()
		{
			$this->productSearch->setState($this->productSearch->StartState);
			$this->productSearch->setProizvodjac(-1);
			$this->productSearch->setTipProizvoda(-1);
			$this->productSearch->setKarakteristika(-1);
			$this->productSearch->setVrednost("");
			
			$this->productSearch->smarty->assign("vrednost_disable",'disabled="disabled"');	
			$this->productSearch->smarty->assign("karakt_disable",'disabled="disabled"');
		}
		
		
		function handleEvents()
		{
			if(isset($_REQUEST["event"]))
			{
				unset($_SESSION["SmartyPaginate"]['default']);
				$_GET["offset"] = 0;
				
				switch($_REQUEST["event"])
				{
					case "event_tipproizvoda":
							if($_REQUEST["tipproizvodaid"] == -1)
							{
								$this->productSearch->deselectTipProizvoda();
							}
							else $this->productSearch->selectTipProizvoda();
						break;
					case "event_proizvodjac":
							if($_REQUEST["proizvodjacid"] == -1)
							{
								$this->productSearch->deselectProizvodjac();
							}
							else $this->productSearch->selectProizvodjac();
						break;
					case "event_kategorija":
						if($_REQUEST["kategorijaid"] == -1)
						{
							$this->productSearch->deselectKategorijaProizvoda();
						}
						else $this->productSearch->selectKategorijaProizvoda();
					break;
					case "event_karakteristika":
							if($_REQUEST["karakteristikaid"] == -1)
							{
								$this->productSearch->deselectKarakteristika();
							}
							else $this->productSearch->selectKarakteristika();
						break;
					case "event_vrednost":
							if($_REQUEST["vrednost"] == "")
							{
								$this->productSearch->deselectVrednost();
							}
							else $this->productSearch->selectVrednost();
						break;
					default: break;
				}
			}
		}
		
		
		function renderProducts($queryProizvodi, $totalCount, $addToUrl)
		{
			$paginate_url = "?plugin=productsearch&plugin_view=product_details&".$this->getPageLink().$queryStringFromState;
			
			$paginateHelper = new PaginateHelper($paginate_url);
			$this->PrepareProductByPageCombo();
			$this->SetProductPluginLanguage();
			
			$paginateHelper->setLimit($this->GetProductsByPage());
			$paginateHelper->setTotal($totalCount);
			
			$limitAndOffset = "";
			
			if($paginateHelper->GetPaginateLimit() > 0 && $paginateHelper->GetPaginateOffset() > 0) {
				// ukoliko imamo i limit i offset
				$limitAndOffset = " LIMIT ".$paginateHelper->GetPaginateOffset().",".$paginateHelper->GetPaginateLimit();
			} else if($paginateHelper->GetPaginateLimit() > 0) {
				// ukoliko imamo samo limit
				$limitAndOffset = " LIMIT ".$paginateHelper->GetPaginateLimit();
			}
			
			$queryProizvodi .= $limitAndOffset;
			$proizvodDummy = $this->ObjectFactory->createObject("PrProizvod", -1);
			$results_proiz = $this->ObjectFactory->DBBR->con->get_results($queryProizvodi);
			
			$proizvodi = array();
			$proizvodDummy->napuniNiz($results_proiz,$proizvodi);
			
			// paginacija proizvoda
			$this->ProccessSmartyPaginate($paginateHelper->GetPaginateLimit(), $paginateHelper->GetPaginateOffset());
			
			// priprema proizvoda za smarty
			$proizvodi_all = $this->ProizvodiToArray($proizvodi, "productsearch", $queryStringFromState);

			$smartyData = array(
								"proizvodi_all" => $proizvodi_all,
								"paginate" => $paginateHelper->toArray(),//$this->SmartyPaginateToArray(),
								"offsetName" => "default",//$this->getPosition(),
								"PATH" => $tipproizvoda->Naziv,
								"PHP_SELF" =>	$_SERVER["PHP_SELF"]."?".$_SERVER["QUERY_STRING"],
								"PAGE_LINK" => $this->getPageLink(),
								"BACK_URL" => $_SERVER['QUERY_STRING'],
								"PARENT_TITLE" 	=> $tipproizvoda->Naziv,
								"MASTER_TITLE" => $this->getTranslation("PLG_PRODUCT_TITLE")." - ".$tipproizvoda->Naziv,
								);
			
			$this->smarty->assign(array("searchdata" => $smartyData));
			$this->smarty->assign("plg_productsearch_details" , "true");
			
			if(isset($_REQUEST["proizvodid"]))
			{
				$this->smarty->assign("plg_product_details","true");
				$this->smarty->assign($this->ProizvodDetailToArray());
			}
		}
	}

?>