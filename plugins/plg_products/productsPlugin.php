<?php

	include_once("plugins/pagePlugin.php");

	class productsPlugin extends pagePlugin
	{
		private $PRODUCT_BY_PAGE_DEFAULT = 24;
		private $PRODUCT_SORTBY_DEFAULT = SORTBY_PRODUCT_DEFAULT;
		private $kpGrupaProizvodaTree;


		public $manufacturerbypage = -1;
		public $productsortby = SORTBY_PRODUCT_DEFAULT;
		function __construct()
		{
			parent::__construct();
			$this->kpGrupaProizvodaTree = new KpGrupaProizvodaTree ();
		}

		public function SetProductPluginLanguage()
		{
			$this->SetPluginLanguage("product");
		}

		/*
		 * Vraca GrupaProizvodaID za stranicu na kojoj se nalazimo
		 *
		 * @return int
		 */
		function getGrupaProizvodaID()
		{
			if(isset($_REQUEST["grupaproizvodaid"]))
			{
				return $_REQUEST["grupaproizvodaid"];
			}
			else
			{
				return 0;
			}
		}

		function proccessProizvod(){}

		/*
		 * Vrsi pripremu proizvoda za detaljan prikaz
		 * koristi se kod svih pluginova
		 *
		 * @return void
		 */
		function ProizvodDetailToArray()
		{
			$proizvod_detail = array();

			if(isset($_REQUEST["proizvodid"]))
			{


				$proizvod = $this->ObjectFactory->createObject("PrProizvod",$_REQUEST["proizvodid"],array("PrKarakteristika","SfStatus","PrProizvodjac","PrKategorija","PrProizvodOcena","PrProizvodKomentar"));
				$html = htmldecode($proizvod->getNaziv());
				$proizvod->setNaziv($html);
				$html = htmldecode($proizvod->getKratakOpis());
				$proizvod->setKratakOpis($html);
				$html = htmldecode($proizvod->getOpis());
				$proizvod->setOpis($html);
				$kurs = $this->ObjectFactory->createObject("PrKurs",1);
				$proizvod->setKurs($kurs->Kurs);
				$popust = $this->GetPopust();
				$proizvod->setPopust($popust);
				$usertip = $this->GetUserType();
				if ($usertip==1)
				{
					$proizvod->CenaA=($proizvod->getCenaAMP());
					$proizvod->CenaB=($proizvod->getCenaBMP());
					$proizvod->CenaAFormatirano=($proizvod->getCenaAMPFormatirano());
					$proizvod->CenaBFormatirano=($proizvod->getCenaBMPFormatirano());
				}


				$this->GenerateThumbs->PrepareThumbs($proizvod->Opis);



				$karakteristike_all = array();




				//prolazimo kroz sve dodatne karakteristike za datu kategoriju
				foreach ($proizvod->PrKarakteristika as $kar)
				{
					if ($kar->getKarakteristikaID()==1) $this->GenerateThumbs->PrepareThumbs($kar->Vrednost);
					$karakteristike_all[] = $kar->toArray();
				}

				if(count($proizvod->PrKategorija) > 0){
					$kategorijaLinkovi = "";
					foreach($proizvod->PrKategorija as $kategorija)
					{

						$linkProductCategoryDetails = new LinkProductCategoryDetails($this->LanguageHelper,"kategorijaproizvod","productcategory_details", $this->getPageID(), $kategorija->getKategorijaID(), $kategorija->getNaziv());
						$kategorijaLink = $this->LanguageHelper->GetPrintLink($linkProductCategoryDetails );

						$kategorijaLinkovi .= "<a href='" . $kategorijaLink . "'>" . $kategorija->getNaziv() . "</a>, ";
					}
					$kategorijaLinkovi = substr($kategorijaLinkovi,0,strlen($kategorijaLinkovi)-2);
					$proizvod->setKategorijeLink($kategorijaLinkovi);
				}

				$user_voted = 0;
				if(isset($_SESSION["loged"]) && $_SESSION["loged"] == "Yes" && isset($_SESSION["logeduserid"]))
				{
					$this->ObjectFactory->Reset();
					$this->ObjectFactory->AddFilter("proizvodid=".$proizvod->getProizvodID());
					$this->ObjectFactory->AddFilter("userid=".$_SESSION["logeduserid"]);
					$oceneKorisnika = $this->ObjectFactory->createObjects("PrProizvodOcena");
					$this->ObjectFactory->Reset();

					if(count($oceneKorisnika) > 0) $user_voted =  $oceneKorisnika[0]->getOcena();
				}
				/*$grupe=explode(",",$proizvod->getGrupaProizvoda());
				echo $grupe;
				$this->smarty->assign ( "grupe", $grupe);*/

				// definisanje linkova za dodavanja jednog proizvoda u korpu
				$linkAddOneProductToBasket = new LinkAddOneProductToBasket($this->LanguageHelper, $proizvod->getProizvodID());
				$linkAddOne = $this->LanguageHelper->GetPrintLink($linkAddOneProductToBasket);
				$proizvod->setAddOneLink($linkAddOne);

				$p_array=$proizvod->toArray();
				//prisutnost u ostalim grupama
				$this->ObjectFactory->Reset ();
				$this->ObjectFactory->AddFilter ( "proizvodid=" . $p->getProizvodID () );
				$grupe = $this->ObjectFactory->createObjects ( "PrProizvodGrupaProiz" );
				$this->ObjectFactory->Reset ();
				foreach ($grupe as $grupa)
				{
					$grupa2 = $this->ObjectFactory->createObject("PrGrupaProizvoda",$grupa->getGrupaProizvodaID());
					$naziv=str_replace(' ','_',$grupa2->getNaziv());
					$p_array = array_merge($p_array, array($naziv => TRUE));
				}

				$proizvod_detail = array(
										"proizvod_view" => "true",
										"proizvod_detail" => $p_array(),
										"user_voted" => $user_voted,
										"karakteristike_all" => $karakteristike_all,
										"link_detail" => "index.php?".$this->getPageLink(),
										"BACK_URL" => $_SERVER['QUERY_STRING']
										);
			}

			return $proizvod_detail;
		}
		// setuuje popuste,link,opis za detaljni prikaz, moze se ubaciti jos nesto
function getProductSettings(&$proiz,$kpGrupaProizvodaTree,$grupe=null) {
	$opis = $proiz->getOpis();
	$opis = htmldecode($opis);
	$proiz->setOpis($opis);
	$kopis = $proiz->getKratakOpis();
	$kopis = htmldecode($kopis);
	$proiz->setKratakOpis($kopis);
	$proiz->PrProizvodjac = $this->ObjectFactory->createObject("PrProizvodjac", $proiz->getProizvodjacID());

	$this->GenerateThumbs->PrepareThumbs($proiz->Opis);

	if (!$grupe) $grupe=$proiz->PrGrupaProizvoda;
	foreach ( $grupe as $gp )
	{
		$gpid=0;
		if (!is_null($gp->getParentID()) && $gp->SfStatus->StatusID==STATUS_PRODUCTGROUP_GLAVNA) {
			$gpid=$gp->getGrupaProizvodaID();
			break;
		}
	}
	if(isset($_SESSION["logeduserid"])) {
		$userid = $_SESSION["logeduserid"];
		$user = $this->ObjectFactory->createObject("User", $userid);
		$popust=$user->getDiscount();
		if ($proiz->getPopust()==0) {
			$catid = $user->SfUserCategory->getUserCategoryID();
			$upit ="SELECT `discount` FROM `ucategorygrupaproiz` WHERE `usercategoryid`=".$catid." and `grupaproizvodaid`=".$gpid."";
			$result_row = $this->DatabaseBroker->con->get_row($upit);
			if (count($result_row)>0) {
				$popust=$result_row->discount;
				$proiz->setPopust($popust);
				$proiz->setPopustOpis("Popust za pretplatnike");
			}
		}
	}
	$link = new LinkKpProductDetails ( $this->LanguageHelper,$kpGrupaProizvodaTree, $proiz->getProizvodID(), $gpid, 'w', $proiz->getNaziv(), $this->GetOffsetParam ());
	$proiz->SetLink ( $this->LanguageHelper->GetPrintLink ( $link ) );
}

		/*
		 * pomocna fukcija za spremanje vrednosti promenljivih u bazu
		 * zastita od SQL injection-a
		 *
		 * TODO: sigurno postoji na jos nekom mestu, potrebno refaktorisanje
		 */
		function quote_smart($value)
		{
			if (get_magic_quotes_gpc())
			{
				$value = stripslashes($value);
			}
			if (!is_numeric($value))
			{
				$db = new ezSQL_mysql;
				//$value = "'" . mysql_real_escape_string($value) . "'";
				$value = "'" . mysqli_real_escape_string($db->links,$value) . "'";
			}
			if($value == -1)
			{
				$value = "NULL";
			}
			return $value;
		}

		/*
		 * Regulise kompletno ponasanje paginacije na stranici
		 */
		function InitSmartyPaginate($paginate_url, $total)
		{
			SmartyPaginate::disconnect($this->getPosition());

			// need before connect
			SmartyPaginate::setTotal($total, $this->getPosition());
			SmartyPaginate::setUrlVar("offset".$this->getPosition(), $this->getPosition());

			SmartyPaginate::connect($this->getPosition(), $this->GetOffsetNameIfFristPage("offset".$this->getPosition()));

			SmartyPaginate::setTranslation
			(
				$this->getTranslation("GLOBAL_PREV_TEXT"),
				$this->getTranslation("GLOBAL_NEXT_TEXT"),
				$this->getTranslation("GLOBAL_FIRST_TEXT"),
				$this->getTranslation("GLOBAL_LAST_TEXT"),
				$this->getPosition()
			);

			SmartyPaginate::setUrl($paginate_url, $this->getPosition());

		}

		function GetOffsetNameIfFristPage($offsetName)
		{
			if(!array_key_exists($offsetName, $_GET))
			{
				$arr = array();
				$arr[$offsetName] = 1;
				return $arr;
			}

			return null;
		}

		function ProccessSmartyPaginate($paginate_limit)
		{
			SmartyPaginate::setLimit($paginate_limit, $this->getPosition());
		}

		function SmartyPaginateToArray()
		{
			return SmartyPaginate::toArray("paginate", $this->getPosition());
		}

		function GetSmartyPaginateIndex()
		{
			return SmartyPaginate::getCurrentIndex($this->getPosition());
		}

		function GetOffsetParam()
		{
			$url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

			$var  = parse_url($url, PHP_URL_QUERY);
			$var  = html_entity_decode($var);
			$var  = explode('&', $var);
			$params  = array();

			foreach($var as $val)
			{
				$x = explode('=', $val);
				if(count($x) == 2)
				{
					$params[$x[0]] = $x[1];
				}
			}
			unset($val, $x, $var);

			foreach($params as $param => $value)
			{
				if(strpos($param, "offset".$this->getPosition()) === 0)
					return $param."=".$value;
			}

			return "";
		}

		function ProizvodiToArray($proizvodi, $productPlugin, $productPluginView="product_details", $addLink="")
		{
			$kurs = $this->ObjectFactory->createObject("PrKurs",1);
			$popust = $this->GetPopust();

			$offsetParam = $this->getOffsetParam();
			$proizvodi_all = array();
			if(!empty($proizvodi))
			{
				foreach($proizvodi as $p)
				{
					if($p->SfStatus->StatusID == STATUS_PROIZVODA_AKTIVAN ||
					   $p->SfStatus->StatusID == STATUS_PROIZVODA_NEMANALAGERU ||
					   $p->SfStatus->StatusID == STATUS_PROIZVODA_POZOVITE ||
						$p->SfStatus->StatusID == STATUS_PROIZVODA_MALILAGER
					   )
					{
						$html = htmldecode($p->getNaziv());
						$p->setNaziv($html);
						$html = htmldecode($p->getKratakOpis());
						$p->setKratakOpis($html);
						$html = htmldecode($p->getOpis());
						$p->setOpis($html);
						
						// postavka kursa
						$p->setKurs($kurs->Kurs);
						$p->setPopust($popust);
						$usertip = $this->GetUserType();
						if ($usertip==1)
						{
							$this->smarty->assign ( "cenatip", "(sa PDV-om)");
							$p->CenaA=($p->getCenaAMP());
							$p->CenaB==($p->getCenaBMP());
							$p->CenaAFormatirano=($p->getCenaAMPFormatirano());
							$p->CenaBFormatirano=($p->getCenaBMPFormatirano());
						}
						//prisutnost u ostalim grupama
						$this->ObjectFactory->Reset();
						$this->ObjectFactory->AddFilter("proizvodid = " . $p->getProizvodID()  );
						$pgp = $this->ObjectFactory->createObjects ( "PrProizvodGrupaProiz");
						$this->ObjectFactory->Reset();
						if (count($pgp)>0) {
							foreach($pgp as $pgrupa)
							{
								$grupaProizvoda=$this->ObjectFactory->createObject ( "PrGrupaProizvoda", $pgrupa->getGrupaProizvodaID());
								if ($grupaProizvoda->SfStatus->StatusID==STATUS_PRODUCTGROUP_GLAVNA
									&& !is_null($grupaProizvoda->getTemplateID())
									&& !is_null($grupaProizvoda->getParentID())
									) break;
							}
							$gpid=$grupaProizvoda->getGrupaProizvodaID();
						}
						else {
							$gpid=0;
						}

						// definisanje linkova za dodavanja jednog proizvoda u korpu
						$linkAddOneProductToBasket = new LinkAddOneProductToBasket($this->LanguageHelper, $p->getProizvodID());
						$linkAddOne = $this->LanguageHelper->GetPrintLink($linkAddOneProductToBasket);
						$p->setAddOneLink($linkAddOne);

						$p_array=$p->toArray();
						$link = new LinkKpProductDetails ( $this->LanguageHelper,$this->kpGrupaProizvodaTree,  $p->getProizvodID(), $gpid, 'w', $p_array['bproizvodnaziv']."-".$p->getNaziv(), $this->GetOffsetParam ());
						$p_array['link'] = $this->LanguageHelper->GetPrintLink ( $link ) ;


						//prisutnost u ostalim grupama
						$this->ObjectFactory->Reset ();
						$this->ObjectFactory->AddFilter ( "proizvodid=" . $p->getProizvodID () );
						$grupe = $this->ObjectFactory->createObjects ( "PrProizvodGrupaProiz" );
						$this->ObjectFactory->Reset ();
						foreach ($grupe as $grupa)
						{
							$grupa2 = $this->ObjectFactory->createObject("PrGrupaProizvoda",$grupa->getGrupaProizvodaID());
							$naziv=str_replace(' ','_',$grupa2->getNaziv());
							$p_array = array_merge($p_array, array($naziv => TRUE));
						}

						// vezani resursi
						$view = new ConnectedObject($this->ObjectFactory,$this->DatabaseBroker, $this->SetLabels());

						$images_x=explode('#',$view->ViewConnectedObject('Proizvod', 'img', $p->getProizvodID()));
						$images=array();
						$images_thumb=array();
						$img=$images_x[0];
							if ($img<>"") {
							$images[]=$img;
							$this->GenerateThumbs->Photo(basename($img),"thumb",dirname($img));
							$images_thumb[]=dirname($img)."/thumb_".basename($img);
							}
						$p_array = array_merge($p_array, array('image' => $images[0]));
						$p_array = array_merge($p_array, array('images_thumb' => $images_thumb[0]));

						$proizvodi_all[] = $p_array;
					}

				}
			}

			return $proizvodi_all;
		}

		// samo za proizvode koji su u katalogu proizvoda (grupaproizvoda complex)
		function ProizvodiKatalogToArray($proizvodi, $pageid, $grupaproizvodaid )
		{
			$kurs = $this->ObjectFactory->createObject("PrKurs",1);
			$popust = $this->GetPopust();

			$offsetParam = $this->getOffsetParam();
			$proizvodi_all = array();
			if(!empty($proizvodi))
			{
				foreach($proizvodi as $p)
				{
					if($p->SfStatus->StatusID == STATUS_PROIZVODA_AKTIVAN ||
					   $p->SfStatus->StatusID == STATUS_PROIZVODA_NEMANALAGERU ||
					   $p->SfStatus->StatusID == STATUS_PROIZVODA_POZOVITE ||
						$p->SfStatus->StatusID == STATUS_PROIZVODA_MALILAGER
						)
					{
						// postavka kursa
						$p->setKurs($kurs->Kurs);
						$p->setPopust($popust);
						$usertip = $this->GetUserType();
						$this->smarty->assign ( "cenatip", "(vp cena)");
						if ($usertip==1)
						{
							$this->smarty->assign ( "cenatip", "(sa PDV-om)");
							$p['cenaa']=($p->getCenaAMP());
							$p['cenab']=($p->getCenaBMP());
							$p['cenaaformatirano']=($p->getCenaAMPFormatirano());
							$p['cenabformatirano']=($p->getCenaBMPFormatirano());
						}

						// definisanje linkova za detalje
						$linkProductDetails = new LinkCatalogProductDetails($this->LanguageHelper,$pageid,$p->getProizvodID(), $grupaproizvodaid, $p->getNaziv(), $offsetParam, $addLink);
						$proizvodLink = $this->LanguageHelper->GetPrintLink($linkProductDetails);
						$p->setLink($proizvodLink);

						// definisanje linkova za dodavanja jednog proizvoda u korpu
						$linkAddOneProductToBasket = new LinkAddOneProductToBasket($this->LanguageHelper, $p->getProizvodID());
						$linkAddOne = $this->LanguageHelper->GetPrintLink($linkAddOneProductToBasket);
						$p->setAddOneLink($linkAddOne);

						$proizvodi_all[] = $p->toArray();
					}
				}
			}

			return $proizvodi_all;
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

		/*
		 * Vraca trenutno odabran broj komada za prikaz proizvoda u listi
		 *
		 */
		function GetProductsByPage()
		{
			if(isset($_SESSION["productsbypage"]))
			{
				return $_SESSION["productsbypage"];
			}

			return $this->PRODUCT_BY_PAGE_DEFAULT;
		}

		/*
		 * Vraca trenutno odabran model sortiranja
		 *
		 */
		function GetProductsSortBy()
		{
			$sortby = $this->PRODUCT_SORTBY_DEFAULT;

			if(isset($_SESSION["productsortby"]))
			{
				$sortby = $_SESSION["productsortby"];
			}

			switch($sortby)
			{
				case SORTBY_PRODUCT_DEFAULT:
					return "proizvod_order";

				case SORTBY_PRODUCT_TITLE_ASC:
					return "naziv ASC";
				case SORTBY_PRODUCT_TITLE_DESC:
					return "naziv DESC";
				default:
					return "naziv ASC";
			}
		}

		function SortProizvodiByProductSortBy($proizvodi)
		{
			return "";
		}
		/*
		function SortProizvodiByProductSortBy($proizvodi)
		{
			$sortby = $this->PRODUCT_SORTBY_DEFAULT;

			foreach($proizvodi as $p) $a[] = $p;

			if(isset($_SESSION["productsortby"]))
			{
				$sortby = $_SESSION["productsortby"];
			}

			$cmp_price_asc = function($a, $b)
			{
				if ($a->getCenaA() == $b->getCenaA()) {
			        return 0;
			    }
			    return ($a->getCenaA() < $b->getCenaA()) ? -1 : 1;
			};

			$cmp_price_desc = function ($a, $b)
			{
				if ($a->getCenaA() == $b->getCenaA()) {
			        return 0;
			    }
			    return ($a->getCenaA() < $b->getCenaA()) ? 1 : -1;
			};

			$cmp_title_asc = function ($a, $b)
			{
				return strcmp($a->getNaziv(), $b->getNaziv());
			};

			$cmp_title_desc = function ($a, $b)
			{
				return strcmp($a->getNaziv(), $b->getNaziv()) * (-1);
			};

			switch($sortby)
			{
				case SORTBY_PRODUCT_PRICE_ASC:
					usort($a, $cmp_price_asc);
					break;
				case SORTBY_PRODUCT_PRICE_DESC:
					usort($a, $cmp_price_desc);
					break;
				case SORTBY_PRODUCT_TITLE_ASC:
					usort($a, $cmp_title_asc);
					break;
				case SORTBY_PRODUCT_TITLE_DESC:
					usort($a, $cmp_title_desc);
					break;
				default:
					exit();
			}

			return $a;
		}
		*/

		function FilterPoProizvodjacu($proizvodi)
		{
			$filtriraniProizvodi = array();

			if($this->GetProductManufacturer() != -1)
			{
				foreach($proizvodi as $proizvod)
				{
					if($proizvod->getProizvodjacID() == $this->GetProductManufacturer())
						$filtriraniProizvodi[] = $proizvod;
				}

				return $filtriraniProizvodi;
			}

			return $proizvodi;
		}

		/*
		 * Iscitava trenutnu vrednost broja komada proizvoda za prikaz
		 * u listi i kreira smarty objekat za crtanje na stranici
		 */
		function PrepareProductByPageCombo()
		{
			if(isset($_REQUEST["productsbypage"]) && is_numeric($_REQUEST["productsbypage"]))
			{
				$_SESSION["productsbypage"] = $_REQUEST["productsbypage"];
			}
			$productsbypage = isset($_SESSION["productsbypage"]) ? $_SESSION["productsbypage"] : $this->PRODUCT_BY_PAGE_DEFAULT ;

			$this->generateProductsByPageCombo($productsbypage);
		}

		function PrepareProductSortByCombo()
		{
			$this->InitProductSortByCombo();

			$this->generateProductsSortByCombo($this->productsortby);
		}

		function InitProductSortByCombo()
		{
			if(isset($_REQUEST["productsortby"]) && is_numeric($_REQUEST["productsortby"]))
			{
				$_SESSION["productsortby"] = $_REQUEST["productsortby"];
			}

			$this->productsortby = isset($_SESSION["productsortby"]) ? $_SESSION["productsortby"] : $this->PRODUCT_SORTBY_DEFAULT;
		}

		function PrepareProductManufacturersCombo($productIds)
		{
			$this->InitProductManufacturerCombo();

			$this->generateProductManufacturersCombo($productIds);
		}

		function InitProductManufacturersCombo()
		{
			if(isset($_REQUEST["manufacturerbypage"]) && is_numeric($_REQUEST["manufacturerbypage"]))
			{
				$_SESSION["manufacturerbypage".$this->getPageID()] = $_REQUEST["manufacturerbypage"];
			}
			$this->manufacturerbypage = isset($_SESSION["manufacturerbypage".$this->getPageID()]) ? $_SESSION["manufacturerbypage".$this->getPageID()] : -1;
		}

		function GetProductManufacturer()
		{
			if(isset($_REQUEST["manufacturerbypage"]) && is_numeric($_REQUEST["manufacturerbypage"]))
			{
				return $_REQUEST["manufacturerbypage"];
			}
			else if(isset($_SESSION["manufacturerbypage".$this->getPageID()]) && is_numeric($_SESSION["manufacturerbypage".$this->getPageID()]))
			{
				return $_SESSION["manufacturerbypage".$this->getPageID()];
			}
			else
			{
				return -1;
			}

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
			$cmbProductByPage->AddOutput($this->PRODUCT_BY_PAGE_DEFAULT . " po stranici");	$cmbProductByPage->AddValue($this->PRODUCT_BY_PAGE_DEFAULT);
			$cmbProductByPage->AddOutput($this->PRODUCT_BY_PAGE_DEFAULT * 2 ." po stranici");	$cmbProductByPage->AddValue($this->PRODUCT_BY_PAGE_DEFAULT * 2);
			$cmbProductByPage->AddOutput($this->PRODUCT_BY_PAGE_DEFAULT * 4 ." po stranici");	$cmbProductByPage->AddValue($this->PRODUCT_BY_PAGE_DEFAULT * 4);


			$cmbProductByPage->AddSelected($current_value);
			$cmbProductByPage->SmartyAssign();
		}

		/*
		 * Punjenje combobox-a sa vrednostima za sortiranje proizvoda na stranici
		 *
		 * TODO: potrebna lokalizacija stringova
		 */
		function generateProductsSortByCombo($current_value)
		{
			$cmbProductSortBy = new SmartyHtmlSelection("productsortby",$this->smarty);

			$cmbProductSortBy->AddOutput("Bez sortiranja");	$cmbProductSortBy->AddValue(SORTBY_PRODUCT_DEFAULT);

			$cmbProductSortBy->AddOutput("Nazivu rastuće"); $cmbProductSortBy->AddValue(SORTBY_PRODUCT_TITLE_ASC);
			$cmbProductSortBy->AddOutput("Nazivu opadajuće"); $cmbProductSortBy->AddValue(SORTBY_PRODUCT_TITLE_DESC);

			$cmbProductSortBy->AddSelected($current_value);
			$cmbProductSortBy->SmartyAssign();
		}

		function PaginateArray($full_array, $limit, $offset)
		{
			$paginatedArray = array();
			$i = 0;
			foreach($full_array as $element)
			{
				if($i >= $offset && $i < $offset+$limit)
				{
					$paginatedArray[] = $element;
				}
				$i++;
			}
			return $paginatedArray;
		}


		/*
		 * Punjenje combobox-a proizvodjacima za dati skup proizvoda
		 *
		 */
		function generateProductManufacturersCombo($productIds)
		{
			if(count($productIds) > 0)
			{
				$strProductIds = "";
				foreach($productIds as $pid)
				{
					$strProductIds .= $pid . ",";
				}

				$strProductIds = substr($strProductIds,0,strlen($strProductIds)-1);

				$query = " SELECT DISTINCT PROIZ.proizvodjacid as proizvodjacid FROM ".
						 " pr_proizvodjac as PROIZ " .
						 " LEFT JOIN pr_proizvod as P ON PROIZ.proizvodjacid = P.proizvodjacid ".
						 " WHERE P.proizvodid IN (".$strProductIds.")";

				$results = $this->DatabaseBroker->con->get_results($query);

				if(count($results) > 0)
				{
					$strManufacturerIds = "";
					foreach($results as $result)
					{
						$strManufacturerIds .= $result->proizvodjacid . ",";
					}

					$strManufacturerIds = substr($strManufacturerIds, 0, strlen($strManufacturerIds)-1);

					$this->ObjectFactory->Reset();
					$this->ObjectFactory->AddFilter("proizvodjacid IN (".$strManufacturerIds.")");
					$manufacturers = $this->ObjectFactory->createObjects("PrProizvodjac");
					$this->ObjectFactory->Reset();

					$this->AssignManufacturers($manufacturers);
				}
			}
		}

		function AssignManufacturers($manufacturers)
		{
			$cmbProductManufacturers = new SmartyHtmlSelection("manufacturerbypage", $this->smarty);

			$cmbProductManufacturers->AddOutput("Svi proizvodjaci");
			$cmbProductManufacturers->AddValue(-1);

			foreach($manufacturers as $manufacturer)
			{
				$cmbProductManufacturers->AddOutput($manufacturer->getNaziv());
				$cmbProductManufacturers->AddValue($manufacturer->getProizvodjacID());
			}

			$cmbProductManufacturers->AddSelected($this->manufacturerbypage);
			$cmbProductManufacturers->SmartyAssign();
		}
	}
?>
