<?php
	include_once("productsPlugin.php");
	
	class proizvodjacPlugin extends productsPlugin 
	{
		public $ProizvodjacID;
		
		function __construct()
		{
			parent::__construct();
		}
		
		function setFilterID($filterid)
		{
			$this->ProizvodjacID = $filterid;
		}
		
		function showDefault()
		{
			
			$paginate_url = "?".$this->getPageLink()."&proizvodjacid=".$this->ProizvodjacID;
			$paginate_total = $this->ObjectFactory->DBBR->prebrojSveSlogove($this->ObjectFactory->createObject("PrProizvod",-1), array("proizvodjacid=".$this->ProizvodjacID." AND (status_id=".STATUS_PROIZVODA_AKTIVAN. " OR status_id=". STATUS_PROIZVODA_NEMANALAGERU.")"));
			
			$this->InitSmartyPaginate($paginate_url,$paginate_total);
			
			$this->PrepareProductByPageCombo();
			$this->PrepareProductSortByCombo();
			$this->SetProductPluginLanguage();
						
			$proizvodjac = $this->ObjectFactory->createObject("PrProizvodjac",$this->ProizvodjacID);
			
			$this->ObjectFactory->AddSort($this->GetProductsSortBy());
			$this->ObjectFactory->AddLimit($this->GetProductsByPage());
			$this->ObjectFactory->AddOffset($this->GetSmartyPaginateIndex());
			$this->ObjectFactory->AddFilter("proizvodjacid = " . $proizvodjac->getProizvodjacID());
			$this->ObjectFactory->AddFilter("(status_id=". STATUS_PROIZVODA_AKTIVAN. " OR status_id=". STATUS_PROIZVODA_NEMANALAGERU.")");
			//$this->ObjectFactory->SetDebugOn();
			$proizvodi = $this->ObjectFactory->createObjects("PrProizvod",array("SfStatus"));
			$this->ObjectFactory->ResetFilters();

			//$paginate_limit = $this->GetProductsByPage();
			//$paginate_total = $this->ObjectFactory->DBBR->prebrojSveSlogove($this->ObjectFactory->createObject("PrProizvod",-1), array("proizvodjacid=".$proizvodjac->getProizvodjacID()." AND (status_id=".STATUS_PROIZVODA_AKTIVAN. " OR status_id=". STATUS_PROIZVODA_NEMANALAGERU.")"));
			$proizvodiIds[] = $proizvodi[0]->getProizvodID(); 
			///TO DO : napraviti neku funckiju koja ne prima proizvode vec prima proizvodjaca kad ga vec imam samo jednog!
			$this->PrepareProductManufacturersCombo($proizvodiIds);
			
			// paginacija proizvoda
			$this->ProccessSmartyPaginate($this->GetProductsByPage());
			
			// priprema proizvoda za smarty
			$proizvodi_all = $this->ProizvodiToArray($proizvodi, "proizvodjac");
			
			$smartyData = array(
								"proizvodi_all" => $proizvodi_all,
								"paginate" => $this->SmartyPaginateToArray(),
								"offsetName" => $this->getPosition(),
								"PATH" => $proizvodjac->getNaziv(),
								"PHP_SELF" =>	$_SERVER["PHP_SELF"]."?".$_SERVER["QUERY_STRING"],
								"PAGE_LINK" => $this->getPageLink(),
								"BACK_URL" => $_SERVER['QUERY_STRING'],
								"PARENT_TITLE" 	=> $proizvodjac->getNaziv(),
								"MASTER_TITLE" => $this->getTranslation("PLG_PRODUCT_TITLE")." - ".$proizvodjac->getNaziv(),
								);
			
			$this->SmartyPluginBlock->setData($smartyData);
			$this->SmartyPluginBlock->setPosition($this->getPosition());
			$this->SmartyPluginBlock->setName("plg_proizvodjac_default");
			
			return $this->SmartyPluginBlock->toArray();	
		}
		
		function showDetails()
		{
			$this->smarty->assign("plg_product_details","true");
			$this->smarty->assign($this->ProizvodDetailToArray());
		}
	}

?>