<?
include_once("plugins/pagePlugin.php");

// osnovna klasa za upravljanje citavim katalogom proizvoda
class katalogproizvodaPlugin extends pagePlugin {
	private $PRODUCT_BY_PAGE_DEFAULT = 24;
	private $PRODUCT_SORTBY_DEFAULT = SORTBY_PRODUCT_DEFAULT;

	private $kpGrupaProizvodaTree;

	private $grupaProizvodaId;

	function __construct()
	{
		parent::__construct ();

		$this->kpGrupaProizvodaTree = new KpGrupaProizvodaTree ();
		$this->kpGrupaProizvodaTree->setPageId ( $this->getPageID () );
		$this->kpGrupaProizvodaTree->setLanguageHelper ( $this->LanguageHelper );
		$this->proizvodgrupaproiz='pr_proizvodgrupaproiz';
		$this->grupaproizvoda='pr_grupaproizvoda';
		$this->proizvod='pr_proizvod';
		$this->proizvodjac='pr_proizvodjac';
		$this->karakteristikaproizvoda='pr_karakteristikaproizvoda';
		$this->karakteristika_element='pr_karakteristika_element';
		$this->karakteristika='pr_karakteristika';
		$this->LanguageHelper->ChangeTableName($this->proizvodgrupaproiz);
		$this->LanguageHelper->ChangeTableName($this->grupaproizvoda);
		$this->LanguageHelper->ChangeTableName($this->proizvod);
		$this->LanguageHelper->ChangeTableName($this->proizvodjac);
		$this->LanguageHelper->ChangeTableName($this->karakteristikaproizvoda);
		$this->LanguageHelper->ChangeTableName($this->karakteristika_element);
		$this->LanguageHelper->ChangeTableName($this->karakteristika);
	}

	// filter podesava nivo grupe proizvoda od koje zelimo da krenemo
	// ukoliko nije setovana uzma se
	function setFilterID($filterid) {
		$this->grupaProizvodaId = $filterid;
	}

	public function showDefault()
	{
		$this->SetPluginLanguage("product");
		//if ($this->grupaProizvodaId==0 && isset ( $_REQUEST ["grupaproizvodaid"] )) {
		if (isset ( $_REQUEST ["grupaproizvodaid"] )) {
			// ucitavamo trenutno izabranu grupu proizvoda
			$grupaProizvodaId = $_REQUEST ["grupaproizvodaid"];
		} else {
			if (!isset($this->grupaProizvodaId)) $grupaProizvodaId=0;
			else $grupaProizvodaId = $this->grupaProizvodaId;
		}
		if (isset($_SESSION['gpid']) && $_SESSION['gpid']!=$grupaProizvodaId) {
			$_SESSION['gpid']=$grupaProizvodaId;
			unset ($_SESSION['filter_products']);
			unset ($_SESSION['selected_products']);
			unset ($_SESSION['fields']);
			unset ($_SESSION['count_products']);
		}

		// ucitavamo grupu proizvoda
		$grupaProizvoda = $this->ObjectFactory->createObject ( "PrGrupaProizvoda", $grupaProizvodaId);
		$root = $this->kpGrupaProizvodaTree->GetRootGrupaProizvodaId($grupaProizvoda->getGrupaProizvodaId ());
		$menuItem = $this->kpGrupaProizvodaTree->GetMenuItemById ( $root->getID() );
		// TODO: privremeno uzimamo iteme od parenta ako meni item nema svojih childova kada dodju filteri ovo skidamo
		if($grupaProizvoda->getParentId() != "")
		{
			$menuItemParent = $this->kpGrupaProizvodaTree->GetMenuItemById ( $grupaProizvoda->getParentId() );
		}
		$parentMenuItem = $this->kpGrupaProizvodaTree->GetParentMenuItemById ( $grupaProizvoda->getGrupaProizvodaId () );

		$this->ObjectFactory->Reset();
		if ($grupaProizvoda->getGrupaProizvodaID()!=0) $this->ObjectFactory->AddFilter("grupaproizvodaid=".$grupaProizvoda->getGrupaProizvodaID());
		$pgp = $this->ObjectFactory->createObjects("PrProizvodGrupaProiz");
		$this->ObjectFactory->Reset();
		if(count($pgp) > 0) {
			foreach($pgp as $p)
			{
				$p_ids .=$p->getProizvodID(). ",";
			}
		}
		$p_ids = substr($p_ids,0,strlen($p_ids)-1);
		$filterItems = $this->PrepareFilterItems($grupaProizvoda,$p_ids);
		$this->smarty->assign('p_ids',$p_ids);

		$cpgp=count($pgp);
		$linkHelper = new LinkKpGrupaProizvoda ( $this->LanguageHelper, $this->kpGrupaProizvodaTree, $grupaProizvoda->getTemplateID(), $grupaProizvoda->getGrupaProizvodaID(), $grupaProizvoda->getNaziv() );
		$links_print=$this->LanguageHelper->GetPrintLink ( $linkHelper );
		$current_link=$links_print."?offset".$grupaProizvoda->getGrupaProizvodaID()."=1";

		$grupaProizvoda = $this->ObjectFactory->createObject ( "PrGrupaProizvoda", $grupaProizvodaId );
		$_REQUEST["offset"]=($_REQUEST["pagination"]-1)*$this->GetProductsByPage();
		$pagination=$this->GetPaginationFooter($grupaProizvoda);

		$paginationData = $this->GetProizvodiPaginationData ( $grupaProizvoda );


		$smartyData = array (
								"current_link" => $current_link,
								"menuItem" => $menuItem,
								"menuItemParent" => $menuItemParent,
								"parentItem" => array_reverse ( $parentMenuItem ),
								"grupaProizvodaID" => $grupaProizvodaId,
								"grupaProizvoda" => $grupaProizvoda->toArray (),
								"countProizvodiGrupe" => $cpgp,
								"data" => $grupaProizvoda->toArray (),
								"pathData" => $this->kpGrupaProizvodaTree->GetPath($grupaProizvodaId),
								"paginationData" => $paginationData,
								"pagination" => $pagination,
								"BACK_URL" => $_SERVER['QUERY_STRING'],
								"hasProizvodjacFilter" => $this->HasFilter($filterItems,"proizvodjacid"),
								"hasZemljaFilter" => $this->HasFilter($filterItems,"country_id"),
								"hasKarakteristikeFilter" => $this->HasFilter($filterItems,"karakteristika"),
								"filterItems" => $filterItems
							);
		$this->SmartyPluginBlock->setData ( $smartyData );
		$this->SmartyPluginBlock->setPosition ( $this->Position );
		$this->SmartyPluginBlock->setName ( "plg_katalogproizvoda_default" );
		return $this->SmartyPluginBlock->toArray ();
	}

	private function HasFilter($filterItems, $filtername)
	{
		foreach($filterItems as $filterItem)
		{
			if($filterItem["filtername"] == $filtername) return true;
		}
		return false;
	}



	private function PrepareFilterItems($grupaproizvoda,$p_ids)
	{
		$allFilters = array();

		$queryBasic =
		" WHERE p.proizvodid IN (".$p_ids.")".
		" AND p.status_id = " . STATUS_PROIZVODA_AKTIVAN ;


		$queryProizvodjac =
			"SELECT pr.proizvodjacid as id, pr.naziv as title".
			" FROM ".$this->proizvod." as p, ".$this->proizvodjac." as pr ".
			$queryBasic.
			" AND p.proizvodjacid = pr.proizvodjacid" .
			" GROUP BY pr.proizvodjacid, pr.naziv ";

		$results = $this->DatabaseBroker->con->get_results ( $queryProizvodjac );
		if(count($results) > 0){
			foreach($results as $result)
				$allFilters[] = array("filtername" => 'proizvodjacid', "id" => $result->id, title => $result->title);
		}

		$queryCountry =
		" SELECT  country.country_id as id, country.vrednost as title".
			" FROM ".$this->proizvod." as p, ".$this->proizvodgrupaproiz." as pgp, sf_country as country ".
			$queryBasic.
			" AND p.country_id = country.country_id" .
			" GROUP BY country.country_id, country.vrednost ";
		$results = $this->DatabaseBroker->con->get_results ( $queryCountry );
		if(count($results) > 0){
			foreach($results as $result)
				$allFilters[] = array("filtername" => 'country_id', "id" => $result->id, title => $result->title);
		}

		$queryTipProizvoda = "SELECT  distinct p.tipproizvodaid as tipproizvodaid FROM ".$this->proizvod." as p ". $queryBasic;
		$tipoviProizvodaIds = $this->DatabaseBroker->con->get_results ( $queryTipProizvoda );

		// ako grupa proizvoda sadrzi samo proizvode istog tipa, krecemo u crtanje karakteristika

		if(count($tipoviProizvodaIds) == 1)
		{
			$queryKarakteristike =
				" SELECT " .
					" CASE WHEN kp.karakteristika_element_id is null THEN 'karakteristika-free' ELSE 'karakteristika' END as filtername, " .
					//" CASE WHEN kp.karakteristika_element_id is null THEN kp.karakteristikaid ELSE kp.karakteristika_element_id END as id, " .
					" CASE WHEN kp.karakteristika_element_id is null THEN kp.vrednost ELSE ke.vrednost END AS title , " .
					" kp.karakteristikaid as id, " .
					" kp.karakteristika_element_id as element_id,".
					" k.naziv as subtitle, ".
					" k.karakteristika_vrsta_id as kvi ".
				" FROM ".$this->proizvod." as p ".
					" LEFT JOIN ".$this->karakteristikaproizvoda." as kp ON kp.proizvodid = p.proizvodid " .
					" LEFT JOIN ".$this->karakteristika_element." as ke ON ke.karakteristika_element_id = kp.karakteristika_element_id " .
					" LEFT JOIN ".$this->karakteristika." as k ON k.karakteristikaid = kp.karakteristikaid " .
					$queryBasic .
					" AND kp.karakteristikaid is not null " .
				" GROUP BY " .
					" kp.karakteristikaid, kp.karakteristika_element_id, kp.vrednost, ke.vrednost, k.naziv " .
				" ORDER BY ".
					" kp.karakteristikaid, k.naziv ";
			$results = $this->DatabaseBroker->con->get_results ( $queryKarakteristike );
			if(count($results) > 0){
				foreach($results as $result)
					$allFilters[] = array("filtername" => $result->filtername, "id" => $result->id, "title" => $result->title, "subtitle" => $result->subtitle, "vrsta" => $result->kvi, "elementid" => $result->element_id);
			}
		}
		return $allFilters;
	}

	public function showDetails() {
		$grupaProizvodaId = $_REQUEST ["grupaproizvodaid"];
		// prva dva nivo grupa proizvoda
		$menuItem = $this->kpGrupaProizvodaTree->GetMenuItemById ( $grupaProizvodaId );

		$grupaProizvoda = $this->ObjectFactory->createObject ( "PrGrupaProizvoda", $grupaProizvodaId );

		// priprema combobox-a za sortiranje proizvoda
		$this->PrepareProductSortByCombo ();
		$this->PrepareProductByPageCombo ();
		//paginacija
		$_REQUEST["offset"]=($_REQUEST["pagination"]-1)*$this->GetProductsByPage();
		$pagination=$this->GetPaginationFooter($grupaProizvoda);

		// ucitavanje proizvoda i spremanje paginacije
		$paginationData = $this->GetProizvodiPaginationData ( $grupaProizvoda );
		$page= $this->ObjectFactory->createObject ('Page',$_REQUEST['page_id']);
		$this->smarty->assign ( "pagename", $page->getHeader());

		if (isset ( $_REQUEST ["proizvodid"] )) {
			$proizvodDetail = $this->ProizvodDetailToArray ( $_REQUEST ["proizvodid"] );
			// vezani proizvodi
			$conectedproducts=array();
			$this->ObjectFactory->Reset();
			$this->ObjectFactory->AddFilter("proizvodid=".$_REQUEST["proizvodid"]);
			$vezanagrupa = $this->ObjectFactory->createObjects("PrVeznaGrupa");
			$this->ObjectFactory->Reset();
			if(count($vezanagrupa) > 0)
			{
				foreach($vezanagrupa as $pvg)
				{
					$grp=$pvg->GrupaProizvodaID;
					$this->ObjectFactory->Reset();
					$this->ObjectFactory->AddFilter("grupaproizvodaid=".$grp);
					$gps = $this->ObjectFactory->createObjects("PrProizvodGrupaProiz");
					$this->ObjectFactory->Reset();
					$i=0;
					foreach($gps as $gp)
					{
						if ($_REQUEST ["proizvodid"]<>$gp->getProizvodID()) $conectedproducts[$i]=$this->ProizvodDetailToArray($gp->getProizvodID());
						$i=$i+1;
					}
				}
			}
			$this->smarty->assign ( $proizvodDetail );
			$this->smarty->assign ( "plg_product_details", "true" );
		}

		$smartyData = array(
							"menuItem" => $menuItem,
							"data" => $grupaProizvoda->toArray (),
							"pathData" => $this->kpGrupaProizvodaTree->GetPath($grupaProizvodaId),
							"paginationData" => $paginationData,
							"conectedproducts" => $conectedproducts,
							"BACK_URL" => $_SERVER['QUERY_STRING']
							);

		$this->smarty->assign ( "header", $grupaProizvoda->getNaziv () );
		$this->smarty->assign ( "details", $smartyData );
		$this->smarty->assign ( "plg_katalogproizvoda_details", "true" );
		$this->smarty->assign ( "offsetName", 'default-'.$grupaProizvodaId );
		$this->smarty->assign ( "pagination", $pagination );
	}

	private function GetPaginationFooter($grupaProizvoda)
	{
		$_REQUEST["offset"]=($_REQUEST["pagination"]-1)*$this->GetProductsByPage();
		return $this->pagination($this->GetDbCountResults($grupaProizvoda->getGrupaProizvodaID()),$this->GetProductsByPage() );
	}
	private function GetProizvodiPaginationData($grupaProizvoda)
	{
		global $lh;
		$kp = new KpGrupaProizvodaTree ();

		$this->GetOffsetNameIfFristPage( "offset" . $grupaProizvoda->getGrupaProizvodaID());

		$templateLink = "";
		if($grupaProizvoda->getTemplateID() != "") $templateLink = "&tid=".$grupaProizvoda->getTemplateID();

		//$url = "/?" . $this->getPageLink () . $templateLink. "&plugin=katalogproizvoda&plugin_view=details&grupaproizvodaid=" . $grupaProizvoda->getGrupaProizvodaID();

		$linkHelper = new LinkKpGrupaProizvoda ( $lh, $kp, $grupaProizvoda->getTemplateID(), $grupaProizvoda->getGrupaProizvodaID(), $grupaProizvoda->getNaziv() );
		$url=$lh->GetPrintLink ( $linkHelper );

		$spid = 'default-'.$grupaProizvoda->getGrupaProizvodaID();

		//SmartyPaginate::reset( $spid );
		SmartyPaginate::setTranslation
			(
				$this->getTranslation("GLOBAL_PREV_TEXT"),
				$this->getTranslation("GLOBAL_NEXT_TEXT"),
				$this->getTranslation("GLOBAL_FIRST_TEXT"),
				$this->getTranslation("GLOBAL_LAST_TEXT"),
				$spid
			);

		// set custom url
		SmartyPaginate::setUrl ( $url, $spid );
		SmartyPaginate::setUrlVar ( "offset" . $grupaProizvoda->getGrupaProizvodaID(), $spid );
		// required connect
		SmartyPaginate::connect ( $spid );

		// set items per page
		SmartyPaginate::setTotal($this->GetDbCountResults($grupaProizvoda->getGrupaProizvodaID()), $spid);
		SmartyPaginate::setLimit ( $this->GetProductsByPage(), $spid );

		$db_results = $this->GetDbResults ( $grupaProizvoda->getGrupaProizvodaID() , $_REQUEST["offset"], $this->GetProductsByPage() );
		SmartyPaginate::assign ( $this->smarty, "paginate", $spid );
		$pr = new PrProizvod ();
		$proizvodi = array ();
		$proizvodiSmarty = array ();
		$pr->napuniNiz ( $db_results, $proizvodi );
		//$proizvodiSmarty=$this->ProizvodiToArray($proizvodi);
		$kurs = $this->ObjectFactory->createObject ( "PrKurs", 1 );
		$i=0;
		foreach ( $proizvodi as $proizvod )
		{
			$html = htmldecode($proizvod->getNaziv());
			$proizvod->setNaziv($html);
			$html = htmldecode($proizvod->getKratakOpis());
			$proizvod->setKratakOpis($html);
			$html = htmldecode($proizvod->getOpis());
			$proizvod->setOpis($html);

			//popust
			$popust = $this->GetPopust();
			$proizvod->setPopust($popust);
			if ($grupaProizvoda->getGrupaProizvodaID()==0) {
				//za link detaljnog prikaza
				$this->ObjectFactory->Reset();
				$this->ObjectFactory->AddFilter("proizvodid=".$proizvod->getProizvodID());
				$grupaX = $this->ObjectFactory->createObjects("PrProizvodGrupaProiz");
				$this->ObjectFactory->Reset();
				foreach($grupaX as $gpX)
				{
					$grupaproizvodaX=$this->ObjectFactory->createObject ( "PrGrupaProizvoda", $gpX->getGrupaProizvodaID());
					if ($grupaproizvodaX->SfStatus->StatusID==STATUS_PRODUCTGROUP_GLAVNA
					&& $grupaproizvodaX->getTemplateID()) break;
				}
				$gpid=$grupaproizvodaX->getGrupaProizvodaID();
			}
			else $gpid=$grupaProizvoda->getGrupaProizvodaID();
			//link za detaljni prikaz
			$link = new LinkKpProductDetails ( $this->LanguageHelper,$this->kpGrupaProizvodaTree, $proizvod->getProizvodID(), $gpid, 'w', $proizvod->getNaziv(), $this->GetOffsetParam ());
			$proizvod->SetLink ( $this->LanguageHelper->GetPrintLink ( $link ) );

			// definisanje linkova za dodavanja jednog proizvoda u korpu
			$linkAddOneProductToBasket = new LinkAddOneProductToBasket($this->LanguageHelper, $proizvod->getProizvodID());
			$linkAddOne = $this->LanguageHelper->GetPrintLink($linkAddOneProductToBasket);
			$proizvod->setAddOneLink($linkAddOne);
			$proizvod->PrProizvodjac = $this->ObjectFactory->createObject("PrProizvodjac", $proizvod->getProizvodjacID());
			$proizvod->SfCountries = $this->ObjectFactory->createObject("SfCountries", $proizvod->getCountryID());

			$pr_arr=$proizvod->toArray ();
			
			//prisutnost u ostalim grupama
			$this->ObjectFactory->Reset ();
			$this->ObjectFactory->AddFilter ( "proizvodid=" . $proizvod->getProizvodID () );
			$grupe = $this->ObjectFactory->createObjects ( "PrProizvodGrupaProiz" );
			$this->ObjectFactory->Reset ();
			$grupaP="";
			foreach ($grupe as $grupa)
			{
				$grupa2 = $this->ObjectFactory->createObject("PrGrupaProizvoda",$grupa->getGrupaProizvodaID());
				$grupaP.=$grupa2->getNaziv();
			}
			$pr_arr = array_merge($pr_arr, array("grupa"=>$grupaP));

			// uslovno prebacivanje mp cene u vp ako je user status maloprodajni kupac
			//$this->smarty->assign ( "cenatip", "(vp cena)");

			/*$view = new ConnectedObject($this->ObjectFactory,$this->DatabaseBroker, $this->SetLabels());

			$images_x=explode('#',$view->ViewConnectedObject('Proizvod', 'img', $proizvod->getProizvodID()));
			$images=array();
			$images_thumb=array();
			$img=$images_x[0];
				if ($img<>"") {
				$images[]=$img;
				$this->GenerateThumbs->Photo(basename($img),"thumb",dirname($img));
				$images_thumb[]=dirname($img)."/thumb_".basename($img);
				}
			$pr_arr = array_merge($pr_arr, array('image' => $images[0]));
			$pr_arr = array_merge($pr_arr, array('images_thumb' => $images_thumb[0]));*/

			$proizvodiSmarty[$i] = $pr_arr;
			$i=$i+1;
		}
		return $proizvodiSmarty;

	}
	function GetOffsetNameIfFristPage($offsetName)
	{
		if(!array_key_exists($offsetName, $_GET))
		{
			$_GET[$offsetName] = 1;
		}
	}
	function GetDbResults($grupaProizvodaId, $offset, $limit)
	{
		$limitQuery = " LIMIT " . $offset . "," .$limit ;
		$proizvodiQuery = str_replace ( "#SELECTOR#", "*", $this->GetQueryTemplate($grupaProizvodaId) . $limitQuery);
		$results = $this->DatabaseBroker->con->get_results ( $proizvodiQuery );
		return $results;
	}

	function GetDbCountResults($grupaProizvodaId)
 	{
		$countQuery = str_replace ( "#SELECTOR#", "COUNT(*) as count", $this->GetQueryTemplate($grupaProizvodaId));
		$result = $this->DatabaseBroker->con->get_row ( $countQuery );
		return $result->count;
	}


	function GetQueryTemplate($grupaProizvodaId)
	{
		$this->children[]=$grupaProizvodaId;
		$this->GetChildrenGroups($grupaProizvodaId);
		foreach ($this->children as $id)
		{
			$childrenproductQuery = "SELECT `proizvodid` FROM `".$this->proizvodgrupaproiz."` WHERE `grupaproizvodaid`=".$id. " Order by proizvodgrupaproiz_order"  ;
			$result = $this->DatabaseBroker->con->get_results ( $childrenproductQuery);

			foreach ($result as $id2) {
				$p_ids .= $id2->proizvodid. ",";
			}		
		}
		$p_ids = substr($p_ids,0,strlen($p_ids)-1);

		$baseQuery = " SELECT #SELECTOR# FROM ".$this->proizvod." P ";
		//$baseQuery .= " LEFT JOIN ".$this->proizvodgrupaproiz." PGP ON P.proizvodid = PGP.proizvodid ";

		$whereQuery =  " WHERE 1=1 ";
		if (isset($_SESSION['selected_products']))
			$whereQuery .= " AND P.proizvodid in (".$_SESSION['selected_products'].")  ";
		$whereQuery .= " AND (P.status_id = " . STATUS_PROIZVODA_AKTIVAN . " OR P.status_id = ".STATUS_PROIZVODA_NEMANALAGERU ." OR P.status_id = ". STATUS_PROIZVODA_POZOVITE." OR P.status_id = ".STATUS_PROIZVODA_MALILAGER.")";
		if (isset($_SESSION['search_products']))
			$whereQuery .= " AND P.proizvodid in (".$_SESSION['search_products'].")  ";
		else $whereQuery .= " AND P.proizvodid in (".$p_ids.")";

		$orderQuery = " ORDER BY P.proizvod_order ";
		//$orderQuery = " ORDER BY field(P.proizvodid, ".$p_ids.")";
		/*if($this->GetProductsSortBy () != "")
			$orderQuery = " ORDER BY " . $this->GetProductsSortBy ();*/
		return $baseQuery . $whereQuery . $orderQuery;
	}

	function GetChildrenGroups($gpid) {
		$childrenQuery = "SELECT `grupaproizvodaid` FROM `".$this->grupaproizvoda."` WHERE `parentid`=".$gpid. " Order by grupaproizvoda_order"  ;
		$result = $this->DatabaseBroker->con->get_results ( $childrenQuery);
		foreach ($result as $r) {
			$this->children[]=$r->grupaproizvodaid;
			$this->GetChildrenGroups($r->grupaproizvodaid);
		}
	}
	function GetProductsSortBy() {
		$sortby = $this->PRODUCT_SORTBY_DEFAULT;

		if (isset ( $_SESSION ["productsortby"] )) {
			$sortby = $_SESSION ["productsortby"];
		}

		switch ($sortby) {
			case SORTBY_PRODUCT_PRICE_ASC :
				return "P.cenaa ASC";
			case SORTBY_PRODUCT_PRICE_DESC :
				return "P.cenaa DESC";
			case SORTBY_PRODUCT_TITLE_ASC :
				return "P.naziv ASC";
			case SORTBY_PRODUCT_TITLE_DESC :
				return "P.naziv DESC";
			default :
				return "PGP.proizvodgrupaproiz_order ASC";
		}
	}

	function GetProductsByPage()
	{
		$bypage = $this->PRODUCT_BY_PAGE_DEFAULT;

		if (isset ( $_SESSION ["productsbypage"] )) {
			$bypage = $_SESSION ["productsbypage"];
		}

		return $bypage;
	}

	function ProizvodDetailToArray($pid) {
		$proizvod_detail = array ();
		$proizvod = $this->ObjectFactory->createObject ( "PrProizvod", $pid, array ( "SfStatus", "PrGrupaProizvoda") );
		$kurs = $this->ObjectFactory->createObject ( "PrKurs", 1 );
		$proizvod->setKurs ( $kurs->Kurs );
		$html = htmldecode($proizvod->getNaziv());
		$proizvod->setNaziv($html);
		$html = htmldecode($proizvod->getKratakOpis());
		$proizvod->setKratakOpis($html);
		$html = htmldecode($proizvod->getOpis());
		$proizvod->setOpis($html);
		
		//naziv grup proizvoda
		$this->ObjectFactory->Reset();
		$this->ObjectFactory->AddFilter("proizvodid=".$pid);
		$grupaX = $this->ObjectFactory->createObjects("PrProizvodGrupaProiz");
		$this->ObjectFactory->Reset();
		foreach($grupaX as $gpX)
		{
			$grupaproizvodaX=$this->ObjectFactory->createObject ( "PrGrupaProizvoda", $gpX->getGrupaProizvodaID());
			$grupaNaziv=$grupaproizvodaX->getNaziv();
			$gpid=$grupaproizvodaX->getGrupaProizvodaID();
			if ($grupaproizvodaX->SfStatus->StatusID==STATUS_PRODUCTGROUP_GLAVNA
			&& $grupaproizvodaX->getTemplateID()) break;
		}
		//link za detaljni prikaz
		$link = new LinkKpProductDetails ( $this->LanguageHelper,$this->kpGrupaProizvodaTree, $proizvod->getProizvodID(), $gpid, 'w', $proizvod->getNaziv(), $this->GetOffsetParam ());
		$proizvod->SetLink ( $this->LanguageHelper->GetPrintLink ( $link ) );
		$pr_arr=$proizvod->toArray ();

		// vezani resursi
		$view = new ConnectedObject($this->ObjectFactory,$this->DatabaseBroker, $this->SetLabels());

		$images_x=explode('#',$view->ViewConnectedObject('Proizvod', 'img', $proizvod->getProizvodID()));
		$images=array();
		$images_thumb=array();
		foreach ($images_x as $img) {
			if ($img<>"") {
			$images[]=$img;
			$this->GenerateThumbs->Photo(basename($img),"thumb",dirname($img));
			$images_thumb[]=dirname($img)."/thumb_".basename($img);
			}
		}
		$crid="1.".ltrim($pr_arr['proizvodid']);
		//moduli za proizvod
		$this->ObjectFactory->Reset();
		$this->ObjectFactory->AddFilter("conres_id=".$crid);
		$rr = $this->ObjectFactory->createObjects("ResRes");
		$this->ObjectFactory->Reset();
		foreach ($rr as $res) {
			$resX=explode(".",$res->getResID());
			if ($resX[0]=="7") $modulesX[]=$resX[1];
			if ($resX[0]=="8") $optionsX[]=$resX[1];
		}
		$modules=array();		
		foreach ($modulesX as $m) {
			$module['id']=$m;
			$md = $this->ObjectFactory->createObject("Module",$m);
			$module['title']=$md->getHeader();
			$this->ObjectFactory->Reset();
			$this->ObjectFactory->AddFilter("module_id=".$m);
			$orders = $this->ObjectFactory->createObjects("ModuleModuleCategory");
			$this->ObjectFactory->Reset();
			$module['order']=$orders[0]->getModuleModuleCategoryOrder();
			$module['link'] = $this->LanguageHelper->GetPrintLink ( new LinkResourceDetails($this->LanguageHelper, 'module', $md->getModuleID(),'w',$md->getHeaderUnchanged()));
			$this->ObjectFactory->Reset();
			$this->ObjectFactory->AddFilter("module_id=".$m);
			$opt = $this->ObjectFactory->createObjects("Option");
			$this->ObjectFactory->Reset();
			$options=array();
			foreach ($opt as $o) {
				if (in_array($o->getOptionID(),$optionsX)) {
					$option['id']=$o->getOptionID();
					$option['title']=$o->getHeader();
					$this->ObjectFactory->Reset();
					$this->ObjectFactory->AddFilter("option_id=".$o->getOptionID());
					$orders2 = $this->ObjectFactory->createObjects("OptionOptionCategory");
					$this->ObjectFactory->Reset();			
					$option['order']=$orders2[0]->getOptionOptionCategoryOrder();
					$option['link'] = $this->LanguageHelper->GetPrintLink ( new LinkResourceDetails($this->LanguageHelper, 'option', $o->getOptionID(),'w',$o->getHeaderUnchanged()));
					$options[]=$option;
				}	
			}
			usort($options,function($first,$second){
					return $first['order'] > $second['order'];
			});				
			$module['options']=$options;
			$modules[]=$module;
		}
		usort($modules,function($first,$second){
				return $first['order'] > $second['order'];
		});		
		$pr_arr = array_merge($pr_arr, array("modules" => $modules));

		//print_r($pr_arr);
		//$this->smarty->assign("images",$images);
		//$this->smarty->assign("images_thumb",$images_thumb);
		//$pr_array = array_merge($pr_array, array("img_rows" => $view->ViewConnectedObject('Proizvod', 'img', $proizvod->getProizvodID())));
		$proizvod_detail = array (
			"proizvod_detail" => $pr_arr,
			"images" => $images,
			"images_thumb" => $images_thumb,
			"grupanaziv" => $grupaNaziv,
			"BACK_URL" => $_SERVER ['QUERY_STRING']
		);
		$this->smarty->assign ( "cenatip", "(vp cena)");

		//prisutnost u ostalim grupama
		$this->ObjectFactory->Reset ();
		$this->ObjectFactory->AddFilter ( "proizvodid=" . $proizvod->getProizvodID () );
		$grupe = $this->ObjectFactory->createObjects ( "PrProizvodGrupaProiz" );
		$this->ObjectFactory->Reset ();
		foreach ($grupe as $grupa)
		{
			$grupa2 = $this->ObjectFactory->createObject("PrGrupaProizvoda",$grupa->getGrupaProizvodaID());
			$naziv=str_replace(' ','_',$grupa2->getNaziv());
			$this->smarty->assign($naziv,TRUE);
		}


		return $proizvod_detail;
	}

	/*
	 * Priprema combo boxa za sortiranje
	 */
	function PrepareProductSortByCombo() {
		if (isset ( $_REQUEST ["productsortby"] ) && is_numeric ( $_REQUEST ["productsortby"] )) {
			$_SESSION ["productsortby"] = $_REQUEST ["productsortby"];
		}
		$productsortby = isset ( $_SESSION ["productsortby"] ) ? $_SESSION ["productsortby"] : $this->PRODUCT_SORTBY_DEFAULT;

		$this->generateProductsSortByCombo ( $productsortby );
	}

	/*
	 * Punjenje combobox-a sa vrednostima za sortiranje proizvoda na stranici
	 */
	function generateProductsSortByCombo($current_value) {
		$cmbProductSortBy = new SmartyHtmlSelection ( "productsortby", $this->smarty );

		$cmbProductSortBy->AddOutput ( "Bez sortiranja" );
		$cmbProductSortBy->AddValue ( SORTBY_PRODUCT_DEFAULT);
		$cmbProductSortBy->AddOutput ( "Ceni rastuće" );
		$cmbProductSortBy->AddValue ( SORTBY_PRODUCT_PRICE_ASC );
		$cmbProductSortBy->AddOutput ( "Ceni opadajuće" );
		$cmbProductSortBy->AddValue ( SORTBY_PRODUCT_PRICE_DESC );
		$cmbProductSortBy->AddOutput ( "Nazivu rastuće" );
		$cmbProductSortBy->AddValue ( SORTBY_PRODUCT_TITLE_ASC );
		$cmbProductSortBy->AddOutput ( "Nazivu opadajuće" );
		$cmbProductSortBy->AddValue ( SORTBY_PRODUCT_TITLE_DESC );

		$cmbProductSortBy->AddSelected ( $current_value );
		$cmbProductSortBy->SmartyAssign ();
	}

	/*
	 * Priprema combo boxa za sortiranje
	 */
	function PrepareProductByPageCombo() {
		if (isset ( $_REQUEST ["productsbypage"] ) && is_numeric ( $_REQUEST ["productsbypage"] )) {
			$_SESSION ["productsbypage"] = $_REQUEST ["productsbypage"];
		}
		$productbypage = isset ( $_SESSION ["productsbypage"] ) ? $_SESSION ["productsbypage"] : $this->PRODUCT_BY_PAGE_DEFAULT * 10000;

		$this->generateProductsByPageCombo ( $productbypage );
	}

	/*
	 * Punjenje combobox-a sa vrednostima za izbor broja proizvoda po stranici
	 *
	 * TODO: potrebna lokalizacija stringova
	 */
	function generateProductsByPageCombo($current_value)
	{
		$cmbProductByPage = new SmartyHtmlSelection("productbypage",$this->smarty);

		$cmbProductByPage->AddOutput("Svi proizvodi");	$cmbProductByPage->AddValue($this->PRODUCT_BY_PAGE_DEFAULT * 10000);
		$cmbProductByPage->AddOutput($this->PRODUCT_BY_PAGE_DEFAULT / 100 . " po stranici");	$cmbProductByPage->AddValue($this->PRODUCT_BY_PAGE_DEFAULT / 100);
		$cmbProductByPage->AddOutput($this->PRODUCT_BY_PAGE_DEFAULT / 50 ." po stranici");	$cmbProductByPage->AddValue($this->PRODUCT_BY_PAGE_DEFAULT / 50);
		$cmbProductByPage->AddOutput($this->PRODUCT_BY_PAGE_DEFAULT / 20 ." po stranici");	$cmbProductByPage->AddValue($this->PRODUCT_BY_PAGE_DEFAULT / 20);
		$cmbProductByPage->AddOutput($this->PRODUCT_BY_PAGE_DEFAULT / 10 ." po stranici");	$cmbProductByPage->AddValue($this->PRODUCT_BY_PAGE_DEFAULT / 10);

		$cmbProductByPage->AddSelected($current_value);
		$cmbProductByPage->SmartyAssign();
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
