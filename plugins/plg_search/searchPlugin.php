<?
	include_once("plugins/plg_products/productsPlugin.php");

	class searchPlugin extends productsPlugin
	{
		private $activePlugins;

		function __construct()
		{
			parent::__construct();
		}

		function showDefault()
		{
			global $lh;
			$this->SetPluginLanguage("search");

			$this->SmartyPluginBlock->setPosition($this->Position);
			//$this->SmartyPluginBlock->setData(); bez podataka

			$link_search=ROOT_WEB. $lh->GetLinkPluginType("language")."/search";
			$this->smarty->assign("link_search",$link_search);
			$this->SmartyPluginBlock->setName("plg_search_default");

			return $this->SmartyPluginBlock->toArray();
		}

		function showDetails()
		{
			$this->SetPluginLanguage("search");

			$this->smarty->assign("keywords" ,$this->LanguageHelper->Transliterate($_REQUEST["search_text"]));
			// get list of active modules
			$this->ObjectFactory->ResetFilters();
			$this->ObjectFactory->ResetLimitOffset();
			$this->ObjectFactory->AddFilter("active='true'");
			$this->activePlugins = $this->ObjectFactory->createObjects("Plugin");
			$this->ObjectFactory->ResetLimitOffset();
			$this->ObjectFactory->ResetFilters();

			// pretraga stranica
			$this->processSearchPage();

			// pretrage resursa
			$this->ObjectFactory->ResetFilters();
			$this->ObjectFactory->AddFilter("status = 1");
			$resources = $this->ObjectFactory->createObjects("SfResource");
			$this->ObjectFactory->ResetFilters();
			$results=array();
			foreach ($resources as $resd) {
				$res=$resd->getClass();
				if ($res<>'PrProizvod') {
					$title='PLG_SEARCH_RESULTS_'.strtoupper($res);
					$res_content=$this->processSearchResource($res);
					$res_array = array("title" => $this->getTranslation($title), "text" => $res_content);
					$res_count+=count($res_content);
					$results[]=$res_array;
				}
			}
			$this->smarty->assign("resources_count" ,$res_count);
			$this->smarty->assign("results" ,$results);


			// pretraga proizvoda
			if($this->IsPluginActive(PLUGIN_TYPE_PRODUCT)) $this->processSearchProducts();

			// prepare for tpl sections
			/*$_SESSION["search_text"]=$_REQUEST["search_text"];

			$this->smarty->assign("MASTER_TITLE",$this->getTranslation("PLG_SEARCH_TITLE"));
			$this->smarty->assign("PATH",$this->getTranslation("PLG_SEARCH_NAMEINPATH_LONG"));*/
		}

		function IsPluginActive($pluginType)
		{
			foreach($this->activePlugins as $plugin)
			{
				if($plugin->getPluginID() == $pluginType) return true;
			}

			return false;
		}

		function processSearchPage()
		{
			if(isset($_REQUEST['search_text'])&& $_REQUEST['plugin_view'] == "search_results" )
			{
				$page = $this->ObjectFactory->createObject("Page",-1);

				$pages_result = array();
				$this->ObjectFactory->DBBR->pronadjiSlogoveFulltext($page,$pages_result,$this->quote_smart($_REQUEST['search_text']));

				//ovde smestam zapise potrebne za iscrtavanje rezultata pretrazivanja
				$page_results_array = array();
				$link_arr_pages = array();

				foreach($pages_result as $page)
				{
					$page_array = array();
					//prikazujem samo stranice koje su online
					if($page->SfStatus->StatusID == STATUS_PAGE_AKTIVAN && $page->SfPageType->ID == PAGE_TYPE_PAGE)
					{
						$page_array = array_merge($page_array, array("id" => $page->getPageID()));
						$page_array = array_merge($page_array, array("header" => $page->getHeader()));
						$page_array = array_merge($page_array, array("html" => $this->formatiraj_ispis($page->getHtml(),trim($_REQUEST['search_text']))));

						$linkPage = new LinkPage($this->LanguageHelper,$page->getPageID(),$page->getHeaderUnchanged(),$this->HierarchicalTree->path_to_url($page->getPageID()));


						$page_array = array_merge($page_array, array("link" => $this->LanguageHelper->GetPrintLink($linkPage)));

						$page_results_array[] = $page_array;
					}
				}

				$this->smarty->assign("plg_search_details","true");
				$this->smarty->assign("page_search","true");
				$this->smarty->assign("page_results",$page_results_array);
			}
		}

		function processSearchProducts()
		{
			if(	isset($_REQUEST['search_text']) && $_REQUEST['plugin_view'] == "search_results" )
			{
				// podesavanje tabele za pretragu
				$proizvodTableName = "pr_proizvod";
				$this->LanguageHelper->ChangeTableName($proizvodTableName);

				// spremanje promenljive za pretragu
				$stringSearchOrig = $_REQUEST["search_text"];
				$searchString = $stringSearchOrig;
				$searchString = $this->quote_smart("%".$searchString."%");

				$query = "SELECT * FROM ".$proizvodTableName." WHERE 1=1 ";
				$query .= " AND (status_id = " . STATUS_PROIZVODA_AKTIVAN . " OR status_id = ".STATUS_PROIZVODA_NEMANALAGERU ." OR status_id = ". STATUS_PROIZVODA_POZOVITE .")";
				$query .= " AND (naziv LIKE ".$searchString." OR opis LIKE ".$searchString." OR sifra LIKE ". $searchString . ")";

				$resultSet = $this->ObjectFactory->DBBR->con->get_results($query);

				//brisanje proizvoda koji nisu svrstani u grupu
				foreach ($resultSet as $k=>$rs) {
					/*$prgr=$this->ObjectFactory->createObject("PrProizvod",$rs->proizvodid,array("PrGrupaProizvoda"));
					$brgr=count($prgr->PrGrupaProizvoda);
					if ($brgr==0) unset($resultSet[$k]);
					else $p_ids .=$rs->proizvodid. ",";*/
					$p_ids .=$rs->proizvodid. ",";
				}
				$p_ids = substr($p_ids,0,strlen($p_ids)-1);
				/*$_SESSION['search_products']=$p_ids;
				$_SESSION['search_text']=$stringSearchOrig;
				if ($stringSearchOrig=="") {
					unset($_SESSION['search_products']);
					unset($_SESSION['search_text']);
				}	*/
				//$link_search_katalog=ROOT_WEB. $this->LanguageHelper->GetLinkPluginType("language")."/katalog/search/".$stringSearchOrig;
				//header("Location: ".$link_search_katalog);

				$proizvodDummy = $this->ObjectFactory->createObject("PrProizvod",-1);
				$proizvodi = array();
				$proizvodDummy->napuniNiz($resultSet, $proizvodi);


				$proizvodi_all = $this->ProizvodiToArray($proizvodi,"search","search_results","&search=all&search_text=".stripslashes($stringSearchOrig));
				$cnt=count($proizvodi_all);
				for($i=0; $i<$cnt; $i++)
				{
					$proizvod = $this->ObjectFactory->createObject("PrProizvod",$proizvodi_all[$i]['proizvodid']);
					$kurs =  $this->ObjectFactory->createObject("PrKurs",1);
					$proizvod->setKurs ( $kurs->Kurs );
					$kurs->Kurs;
					$popust = $this->GetPopust();
					$proizvod->setPopust($popust);
					$usertip = $this->GetUserType();

					$this->smarty->assign ( "cenatip", "(vp cena)");
					if ($usertip==1)
					{
						$proizvodi_all[$i]['cenaa']=($proizvod->getCenaAMP());
						$proizvodi_all[$i]['cenab']=($proizvod->getCenaBMP());
						$proizvodi_all[$i]['cenaaformatirano']=($proizvod->getCenaAMPFormatirano());
						$proizvodi_all[$i]['cenabformatirano']=($proizvod->getCenaBMPFormatirano());
						$this->smarty->assign ( "cenatip", "(sa PDV-om)");
					}
				}

				if(isset($_REQUEST["proizvodid"]))
				{
					$this->smarty->assign("plg_product_details","true");
					$this->smarty->assign($this->ProizvodDetailToArray());
				}

				$this->smarty->assign("plg_search_details","true");
				$this->smarty->assign("product_search","true");
				$this->smarty->assign("BACKURL", $this->makeBackUrl());
				$this->smarty->assign("product_results",$proizvodi_all);
			}
		}

		function processSearchResource($resource)
		{
			if(	isset($_REQUEST['search_text']) && $_REQUEST['plugin_view'] == "search_results")
			{
				eval ("\$status = STATUS_".strtoupper($resource)."_AKTIVAN;");
				$res_link=strtolower($resource);
				$res_smarty_result=$res_link."_results";
				$resObj = $this->ObjectFactory->createObject($resource,-1);

				$res_result = array();
				$this->ObjectFactory->DBBR->pronadjiSlogoveFulltext($resObj,$res_result,$this->quote_smart($_REQUEST['search_text']));

				$res_results_array = array();
				$link_arr_res = array();

				foreach($res_result as $res)
				{
					$res_array = array();
					if($res->SfStatus->getStatusID() == $status)
					{
						$res_array = $res->toArray();
						$res_array["shorthtml"] = $this->formatiraj_ispis($res_array["shorthtml"],trim($_REQUEST['search_text']));
						if($res->getShortHtml() != "" || $res->getHtml() != "")
						{
							eval("\$id = \$res->get".$resource."ID();");
							$links_print_dt = $this->LanguageHelper->GetPrintLink ( new LinkResourceDetails($this->LanguageHelper, $res_link, $id, 'w',$res->getHeaderUnchanged()));
							$res_array = array_merge($res_array, array("link" => $links_print_dt));
						}
						else array_push($link_arr_res,"#");
						$res_results_array[] = $res_array;
					}
				}
				return $res_results_array;
			}
		}

		function makeBackUrl()
		{
			$stringSearchOrig = $_REQUEST["search_text"];
			return $backUrl = $this->getPageLink() ."&plugin=search&plugin_view=search_results&search=all&search_text=".$stringSearchOrig;
		}

		function formatiraj_ispis($sadrzaj,$find){

			global $lh;

			// izvrsiti konverziju teksta iz baze u normalan html kod

			$sadrzaj = preg_replace('{\&gt;}', '>', $sadrzaj);
			$sadrzaj = preg_replace('{\&lt;}', '<', $sadrzaj);
			$sadrzaj = preg_replace('{\&quot;}', "\"", $sadrzaj);
			$sadrzaj = preg_replace('{\&amp;}', '&', $sadrzaj);
			$sadrzaj = preg_replace('{\&#039;}', '\'', $sadrzaj);

			/*-----------------------------------------------
			SLEDI DEO U KOME TREBA FORMATIRATI ISPIS
			1. potreban nam je deo pronadjenog sadrzaja 50
			karaktera ispred i 50 iza, ukoliko toliko postoji,
			a ako ne tada cemo proveriti koliko postoji i
			regulisati taj ispis
			2. zelimo da string koji smo trazili i koji se nalazi u
			$search ispisemo bold (masnim) slovima...
			------------------------------------------------*/
			// 1.--->
			// citav pronadjeni sadrzaj stavljamo u promenljivu
			// koja se bas tako i zove $sadrzaj
			// vrsimo pocetnu obradu:
			$search = array ("'<script[^>]*?>.*?</script>'si", "'<[\/\!]*?[^<>]*?>'si", "'([\r\n])[\s]+'", "'&(quot|#34);'i", "'&(amp|#38);'i", "'&(lt|#60);'i", "'&(gt|#62);'i","'&(nbsp|#160);'i","'&(iexcl|#161);'i","'&(cent|#162);'i","'&(pound|#163);'i");
			$replace = array ("","","\\1","\"","&","<",">"," ",chr(161),chr(162),chr(163),chr(169));
			$sadrzaj= preg_replace ($search, $replace, $sadrzaj);

			//sve kljucne reci iz find-a
			$keywords = explode (" ", $find);

			$firstocc = 0;

			$char_punkt = array (" ","\"",".",",",";","'","-","_","[","]","{","}","(",")","=","+","\\","\/","\n","\t","\r\n","\n\r","\r");
			foreach($keywords as $keyw){
				$firstocc = max($firstocc, strpos(strtolower($sadrzaj)," ".trim(strtolower($keyw))." "));
				foreach($char_punkt as $punkt){
					foreach($char_punkt as $punkt1){
						if($firstocc == 0) $firstocc = max($firstocc, strpos(strtolower($sadrzaj),$punkt.trim(strtolower($keyw)).$punkt1));
						else break;
					}
				}
			}

			// Formatiranje teksta tako da trazeni stringovi budu obojeni u BOLD !LEP KOD!
			// za sve unete kljucne reci

			if ($firstocc < 50){
				// ako je maje od 50 sadrzaj ispisujemo od
				// pocetka pa plus jos 300 karaktera
				$sadrzaj = substr ($sadrzaj, 0 , 300);

				$sadrzaj = $sadrzaj ."...";

			} else {
				// a ako je vece od pedeset tada pisemo 50 ispred
				// i 50 iza trazenog stringa...

				$sadrzaj = substr ($sadrzaj, $firstocc - 50, 300);

				// ovde trazimo gde se nalazi prvi 'space' u nasem rezultatu
				// jer tek od njega pa nadalje zelimo da prikazemo rezultat

				$firstocc = strpos($sadrzaj," ");
				$sadrzaj = substr ($sadrzaj, $firstocc, 300);
				$sadrzaj = "... ".$sadrzaj." ...";

			}
			for($i=0; $i!=count($keywords); $i++) {
				$keywords[$i]=$lh->Transliterate($keywords[$i]);
				$sadrzaj = preg_replace("'[^[:alpha:]]".$keywords[$i]."[^[:alpha:]]'si","<strong> ".$keywords[$i]." </strong>",$sadrzaj);
			} //kraj for-a
			return $sadrzaj;
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
			// default popust koji ide generalno svim korisnicima koji nisu ulogovani
			$usertip = 1;
			// popust koji se cita iz logovanog korisnika
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
