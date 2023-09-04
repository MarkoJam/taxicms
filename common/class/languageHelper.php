<?php
	/* CMS Studio 3.0 languageHelper.php */

	class LanguageHelper
	{
		// naziv tabele kojoj pristupamo
		var $table_name;
		// default jezik koji se koristi
		var $default_language;
		// trenutno selektovani jezik koji se koristi
		var $language;
		var $DBBR;
		var $ObjectFactory;

		var $subsite_arr = array(); //array("serbian" => "","english" => "_e","nemacki" => "_de");
		// prvi element u ovom nizu je default jezik
		var $language_arr = array("english" => "","srpski" => "_sr","nemacki" => "_de");
		var $table_exception=array("labels");
		// tabele koje imaju svoje subsite ekvivalente, odnosno koima se dodaju sufiksi. $table_exception je podskup $table_change
		var $table_change=array("con_resource","news","newscategory","newsnewscategory","module","modulecategory","modulemodulecategory","page","plugin","plug_templ","pr_grupaproizvoda","pr_proizvod","pr_proizvodgrupaproiz","	pr_proizvodproizvod","pr_tipproizvoda","pr_veznagrupa","sections","sectionscategory","sectionssectionscategory","labels","sf_plugin_type","	spagelink","staticpage","template","universalplugin");
		var $category_plugins=array("news","module"); //za filter kategorije
		var $html_entities = array('&nbsp;','&lt;','&gt;','&amp;','&cent;','&pound;','&yen;','&euro;','&sect;','&copy;','&reg;','&trade;');
		// niz koji cuva vezu izmedju izbaranog jezika i xml fajlova...
		var $files_arr = array(); 	//array("srpski" => "srp","english" => "eng","nemacki" => "deu");
		var $plugin = array(); 		// array("language","page","news","newsdetails","newsarchive","search","poll");
		var $SubSites = array();

		public $langGlobal = array();
		private static $instance;

		public static function getInstance()
		{
			if(!isset(self::$instance))
			{
				$object= __CLASS__;
				self::$instance=new $object;
			}
			return self::$instance;
		}

		function TestVars()
		{
			echo "\$this->language = ".$this->language ."<br/>";
			echo "\$_SESSION['cookie_language'] = ".$_SESSION['cookie_language'] ."<br/>";
		}

		function __construct() {}

		function Initialize()
		{
			// konstruktor za Language Helper sadrzi parametre za rad sa
			// bazama na razlicitim jezicima + sadrzi parametre koji se
			// ticu rada sa urlrewrite engine-om

			// globalna promenljiva koja govori da li koristimo usluge url rewrite-a
			global $_REQUEST;
			global $_ADMINPAGES;
			global $_AJAXPAGES;

			$this->DBBR = DatabaseBroker::getInstance();
			$this->ObjectFactory = ObjectFactory::getInstance();
			$this->ObjectFactory->ResetFilters();
			//$this->ObjectFactory->AddFilter("is_default = 1");
			$this->SubSites = $this->ObjectFactory->createObjects("SubSite");
			$this->ObjectFactory->ResetFilters();

			foreach ($this->SubSites as $subsite)
			{
				$this->subsite_arr = array_merge($this->subsite_arr, array($subsite->FilePostfix => $subsite->DbPostfix));
				$this->language_arr = array_merge($this->language_arr, array($subsite->Language => $subsite->DbPostfix));
				$this->files_arr 	= array_merge($this->files_arr, array($subsite->Language => $subsite->FilePostfix));
			}
			$this->table_name = "";
			$this->default_language = $this->SubSites[0]->Language;
			$this->default_subsite = $this->SubSites[0]->FilePostfix;
			$this->default_subsiteid = $this->SubSites[0]->SubSiteID;
			if($_ADMINPAGES) {
				$ss = $this->ObjectFactory->createObject("SubSite",$_SESSION['subsiteid']);
				$this->subsite=$ss->getFilePostfix();
				$_SESSION['subsite']=$this->subsite;
				if (isset($_SESSION["ad_cookie_language"])) $this->language = $_SESSION["ad_cookie_language"];
				else {
					if(isset($_COOKIE["ad_cookie_language"])) $this->language = $_COOKIE["ad_cookie_language"];
					else $this->language = $this->default_language;
				}
			}
			else {
				if(isset($_REQUEST["language"])) $this->language = $_REQUEST["language"];
				else if(isset($_REQUEST["lang"])) $this->language = $_REQUEST["lang"];
				else if (isset($_SESSION["cookie_language"])) $this->language = $_SESSION["cookie_language"];
				else if(isset($_COOKIE["cookie_language"])) $this->language = $_COOKIE["cookie_language"];
				else $this->language = $this->default_language;
			}

			// DEO ZA RAD SA URLREWRITE ENGINE-om
			//----------------------------------------------------
			// podesavanje za url rewrite linkove
			//----------------------------------------------------
				$baseUrl = "/";
				// Instanciramo objekt
				$pathVars = new PathVars($baseUrl);

				if(IS_PRODUCTION) $indexStart = 0;
				else $indexStart = 1;

			//----------------------------------------------------
			// podesavanja za jezike
			//----------------------------------------------------
			if(IS_URLREWRITE_ON && !isset($_REQUEST["lang"]) && !$_ADMINPAGES && !$_AJAXPAGES) {
				$this->ObjectFactory->ResetFilters();
				$this->ObjectFactory->AddFilter("file_postfix = '" . $pathVars->fetchByIndex($indexStart) . "'");
				$ss = $this->ObjectFactory->createObjects("SubSite");
				$this->ObjectFactory->Reset();
				if(countObject($ss) > 0) {
					$this->language = $ss[0]->getLanguage();
					$_SESSION['subsite']=  $ss[0]->getFilePostfix();
					$this->subsite=$ss[0]->getFilePostfix();
				}
				else if(!isset($_SESSION['subsite'])) {
					$this->language = "english";
					$_SESSION['subsite']="eng";
					$this->subsite="eng";
				}
				else {
					$this->language = "english";
					$_SESSION['subsite']="eng";
					$this->subsite="eng";
				}

				if(isset($_REQUEST["plugin"]) && isset($_REQUEST["plugin_view"]) && isset($_REQUEST["tid"])) {
					$skipUrlRewritePart =true;
					$isPluginActive = true;
				}
				else $isPluginActive = false;

				if(!$skipUrlRewritePart) {
					// Koja je prva varijabla?
					$indexStartStart=$indexStart;
					for ($i = 0; $i<4 ; $i++) {
					$stop=true;
					$indexStart=$indexStartStart+$i;
					//exit (( $this->GetPluginCode($pathVars->fetchByIndex($indexStart + 1))));
					switch ( $this->GetPluginCode($pathVars->fetchByIndex($indexStart + 1))) {
						case 'link':
						case 'important'  :
							// Pogledamo drugi dio varijable
							if ( $pathVars->fetchByIndex($indexStart + 3) ) $_REQUEST["spage_id"] = $pathVars->fetchByIndex($indexStart + 3);
							$isPluginActive = true;
						break;
						case 'registration':
							$isPluginActive = true;
							$_REQUEST["tid"] = TEMPLATE_REGISTRATION;
							$_REQUEST["mod"] = $this->GetPluginCode($pathVars->fetchByIndex($indexStart + 2));
							if($_REQUEST["mod"]=='activation') $_REQUEST["mod_add"]=$pathVars->fetchByIndex($indexStart + 3);
							if($_REQUEST["mod"]=='password-recovery') $_REQUEST["mod_add"]=$pathVars->fetchByIndex($indexStart + 3);
							$_REQUEST["plugin"] = "login";
							$_REQUEST["plugin_view"] = "registration";
							break;
						case 'adminpage':
							$isPluginActive = true;
							if ( $pathVars->fetchByIndex($indexStart + 3) ) {
								$isPluginActive = true;
								$_REQUEST["adminpage_id"] = $pathVars->fetchByIndex($indexStart + 3);
								$_REQUEST["adminpagename"] = $pathVars->fetchByIndex($indexStart + 2);
							}
							break;
						case 'gallery' :
							if ( $pathVars->fetchByIndex($indexStart + 3)) {
								$isPluginActive = true;
								$_REQUEST["plugin"] = "gallery";
								if($this->GetPluginCode($pathVars->fetchByIndex($indexStart + 3)) == "details") {
									$_REQUEST["plugin_view"] = "gallery_details";
									if (is_numeric($pathVars->fetchByIndex($indexStart + 4))) {
										$_REQUEST["nlid"]=$pathVars->fetchByIndex($indexStart + 4);
										$_REQUEST["access"]='nl';
									}
									else {
										$_REQUEST["nlid"]=0;
										$_REQUEST["access"]=$pathVars->fetchByIndex($indexStart + 4);
									}
									if (is_numeric($pathVars->fetchByIndex($indexStart + 5))) {
										$_REQUEST["uid"]=$pathVars->fetchByIndex($indexStart + 5);
									}
									$_REQUEST["vr_id"] = $pathVars->fetchByIndex($indexStart + 2);
									$_REQUEST["tid"] = TEMPLATE_GALLERY;
									$_REQUEST["gallery_id"] = $pathVars->fetchByIndex($indexStart + 2);
								}
								$this->GetPage('Gallery',$_REQUEST["gallery_id"]);
							}
							break;
						case 'news' :
							if ( $pathVars->fetchByIndex($indexStart + 3)) {
								$isPluginActive = true;
								$_REQUEST["plugin"] = "news";
								if($this->GetPluginCode($pathVars->fetchByIndex($indexStart + 3)) == "details") {
									$_REQUEST["plugin_view"] = "news_details";
									if (is_numeric($pathVars->fetchByIndex($indexStart + 4))) {
										$_REQUEST["nlid"]=$pathVars->fetchByIndex($indexStart + 4);
										$_REQUEST["access"]='nl';
									}
									else {
										$_REQUEST["nlid"]=0;
										$_REQUEST["access"]=$pathVars->fetchByIndex($indexStart + 4);
									}
									if (is_numeric($pathVars->fetchByIndex($indexStart + 5))) {
										$_REQUEST["uid"]=$pathVars->fetchByIndex($indexStart + 5);
									}
									$_REQUEST["vr_id"] = $pathVars->fetchByIndex($indexStart + 2);
									$_REQUEST["tid"] = TEMPLATE_NEWS;
									$_REQUEST["news_id"] = $pathVars->fetchByIndex($indexStart + 2);
								}
								$this->GetPage('News',$_REQUEST["news_id"]);
							}
							break;
						case 'module' :
							if ( $pathVars->fetchByIndex($indexStart + 3)) {
								$isPluginActive = true;
								$_REQUEST["plugin"] = "module";
								if($this->GetPluginCode($pathVars->fetchByIndex($indexStart + 3)) == "details") {
									$_REQUEST["plugin_view"] = "module_details";
									if (is_numeric($pathVars->fetchByIndex($indexStart + 4))) {
										$_REQUEST["nlid"]=$pathVars->fetchByIndex($indexStart + 4);
										$_REQUEST["access"]='nl';
									}
									else {
										$_REQUEST["nlid"]=0;
										$_REQUEST["access"]=$pathVars->fetchByIndex($indexStart + 4);
									}
									if (is_numeric($pathVars->fetchByIndex($indexStart + 5))) {
										$_REQUEST["uid"]=$pathVars->fetchByIndex($indexStart + 5);
									}
									$_REQUEST["vr_id"] = $pathVars->fetchByIndex($indexStart + 2);
									//$_REQUEST["tid"] = TEMPLATE_MODULE;
									$_REQUEST["module_id"] = $pathVars->fetchByIndex($indexStart + 2);
								}
								$this->GetPage('Module',$_REQUEST["module_id"]);
							}
							break;		
						case 'option' :
							if ( $pathVars->fetchByIndex($indexStart + 3)) {
								$isPluginActive = true;
								$_REQUEST["plugin"] = "option";
								if($this->GetPluginCode($pathVars->fetchByIndex($indexStart + 3)) == "details") {
									$_REQUEST["plugin_view"] = "option_details";
									if (is_numeric($pathVars->fetchByIndex($indexStart + 4))) {
										$_REQUEST["nlid"]=$pathVars->fetchByIndex($indexStart + 4);
										$_REQUEST["access"]='nl';
									}
									else {
										$_REQUEST["nlid"]=0;
										$_REQUEST["access"]=$pathVars->fetchByIndex($indexStart + 4);
									}
									if (is_numeric($pathVars->fetchByIndex($indexStart + 5))) {
										$_REQUEST["uid"]=$pathVars->fetchByIndex($indexStart + 5);
									}
									$_REQUEST["vr_id"] = $pathVars->fetchByIndex($indexStart + 2);
									$_REQUEST["tid"] = TEMPLATE_OPTION;
									$_REQUEST["option_id"] = $pathVars->fetchByIndex($indexStart + 2);
								}
								//$this->GetPage('Option',$_REQUEST["option_id"]);
							}
							break;								
						case 'search':
							$isPluginActive = true;
							$_REQUEST["plugin"] = "search";
							$_REQUEST["plugin_view"] = "search_results";

							if (isset($_REQUEST["search_text"])) {
								$st=str_replace(' ','+',$_REQUEST["search_text"]);
								$link_search=ROOT_WEB.$pathVars->fetchByIndex($indexStart)."/".$pathVars->fetchByIndex($indexStart+1)."/".$st;
								header('Location: '. $link_search);
								exit();
							}
							else $_REQUEST["search_text"] = rawurldecode($pathVars->fetchByIndex($indexStart + 2));
							$_REQUEST["search_text"]=str_replace('+',' ',$_REQUEST["search_text"]);
							$_REQUEST["tid"] = TEMPLATE_SEARCH;
							break;
						case 'tag':
							$isPluginActive = true;
							$_REQUEST["plugin"] = "tag";
							$_REQUEST["plugin_view"] = "tag_results";
							$isPluginActive = true;

							$_REQUEST["tag_text"] = rawurldecode($pathVars->fetchByIndex($indexStart + 2));
							$_REQUEST["tid"] = TEMPLATE_TAG;
							break;
						case 'print':
							$isPluginActive = false;
							$_REQUEST["format"] = "print";
							break;
						case 'products':
							if ( $pathVars->fetchByIndex($indexStart + 3) && $pathVars->fetchByIndex($indexStart + 4))
							{
								$isPluginActive = true;
								$_REQUEST["page_id"] = $pathVars->fetchByIndex($indexStart + 2);
								$_REQUEST["proizvodid"] = $pathVars->fetchByIndex($indexStart + 3);
								$_REQUEST["grupaproizvodaid"] = $pathVars->fetchByIndex($indexStart + 4);
								$_REQUEST["plugin"] = "grupaproizvod";
								$_REQUEST["plugin_view"] = "complex_details";
							}
							break;
						case 'promotion':
								/*print_r($pathVars);
								[0] => srp
								[1] => proizvod
								[2[ => 586 - pageid
								[2] => 17206
								[3] => samsung-n8010-galaxy-note-10-1
								http://mobillwood.cmsstudio.info/index.php?plugin=proizvodjac&plugin_view=product_details&page_id=567&proizvodid=17057&&lang=srpski
								*/

								if ($pathVars->fetchByIndex($indexStart + 3))
								{
									$isPluginActive = true;
									$_REQUEST["page_id"] = $pathVars->fetchByIndex($indexStart + 2);
									$_REQUEST["proizvodid"] = $pathVars->fetchByIndex($indexStart + 3);
									$_REQUEST["plugin"] = "proizvodjac";
									$_REQUEST["plugin_view"] = "product_details";
								}
							break;
						case 'registration':
								$isPluginActive = true;
								$_REQUEST["page_id"] = $pathVars->fetchByIndex($indexStart + 2);
								$_REQUEST["tid"] = $pathVars->fetchByIndex($indexStart + 3);
								$_REQUEST["mod"] = $pathVars->fetchByIndex($indexStart + 4);
								$_REQUEST["plugin"] = "login";
								$_REQUEST["plugin_view"] = "registration";

							break;
							case 'order':
								if ($pathVars->fetchByIndex($indexStart + 2)) {
									$isPluginActive = true;
									$_REQUEST["tid"] = TEMPLATE_SHOPPING_CART;
									$_REQUEST["plugin"] = "order";
									$step=$this->GetPluginCode($pathVars->fetchByIndex($indexStart + 2));
									switch ( $step ) {
										case 'basket':
											$_REQUEST["plugin_view"] = "basket";
											$_REQUEST["status"] = $pathVars->fetchByIndex($indexStart + 3);
											break;
										case 'checkout':
											$_REQUEST["plugin_view"] = "checkout";
											break;
										case 'overview':
											$_REQUEST["plugin_view"] = "overview";
											break;
										case 'finish':
											$_REQUEST["plugin_view"] = "finish";
											$_REQUEST["orderid"] = $pathVars->fetchByIndex($indexStart + 3);
											$_REQUEST["status"] =  $pathVars->fetchByIndex($indexStart + 4);
											break;
										case 'back':
											$_REQUEST["plugin_view"] = "back";
											$_REQUEST["orderid"] = $pathVars->fetchByIndex($indexStart + 3);
											break;
									}
								}
								break;
						case 'catalog':
								$isPluginActive = true;
								$_REQUEST["tid"]=5;
								//$_REQUEST["tid"] = $pathVars->fetchByIndex($indexStart + 2);
								$_REQUEST["grupaproizvodaid"] = $pathVars->fetchByIndex($indexStart + 3);
								if (is_numeric($pathVars->fetchByIndex($pathVars->size()-1))) {
									$_REQUEST["pagination"] = $pathVars->fetchByIndex($pathVars->size()-1);
									$cor_pagination=1;
								}
								else {
									$_REQUEST["pagination"] = 1;
									$cor_pagination=0;
								}
								$_REQUEST["plugin"] = "katalogproizvoda";
								$_REQUEST["plugin_view"] = "details";
								for($i = 0; $i < $pathVars->size()-$cor_pagination-$indexStart-1; $i++)
								{
									$currentPath .= $pathVars->fetchByIndex($indexStart+1 + $i). "/";
								}
								$currentPath = substr($currentPath,0,strlen($currentPath)-1);
								$_REQUEST['basicurl']=ROOT_WEB.$pathVars->fetchByIndex($indexStart).'/'.$currentPath;
							break;
						case 'product':
							if ( $pathVars->fetchByIndex($indexStart + 3))
							{
								//$this->Old_to_New_link($pathVars,$indexStart);
								$isPluginActive = true;
								$_REQUEST["plugin"] = "katalogproizvoda";
								$_REQUEST["plugin_view"] = "details";

								$_REQUEST["tid"] = 7;
								$_REQUEST["proizvodid"] = $pathVars->fetchByIndex($indexStart + 2);
								$_REQUEST["vr_id"] = $_REQUEST["proizvodid"] ;
								$_REQUEST["grupaproizvodaid"] = $pathVars->fetchByIndex($indexStart + 3);
								if($pathVars->fetchByIndex($indexStart + 4) == "details")
								{
									if (is_numeric($pathVars->fetchByIndex($indexStart + 7))) {
										$_REQUEST["nlid"]=$pathVars->fetchByIndex($indexStart + 7);
										$_REQUEST["access"]='nl';
									}
									else {
										$_REQUEST["nlid"]=0;
										$_REQUEST["access"]=$pathVars->fetchByIndex($indexStart + 7);
									}
									if (is_numeric($pathVars->fetchByIndex($indexStart + 8))) {
										$_REQUEST["uid"]=$pathVars->fetchByIndex($indexStart + 8);
									}
								}
								if(!isset($_REQUEST["plugin_view"])){$_REQUEST["plugin_view"] = "details";}
							}
							break;
						default:
							if($i<4) $stop=false;
							$isPluginActive = false;
						break;
					}
					if ($stop)	break;
					}
				}

				if(!$isPluginActive) {
					if(IS_PRODUCTION) $indexStart = 0;
					else $indexStart = 1;
					if (isset($_REQUEST["format"]) && $_REQUEST["format"] == "print") $cor_print=1;
					else $cor_print=0;
					$currentPath = "/";
					if (is_numeric($pathVars->fetchByIndex($pathVars->size()-1))) {
						$_REQUEST["pagination"] = $pathVars->fetchByIndex($pathVars->size()-1);
						$cor_pagination=1;
					}
					else {
						$_REQUEST["pagination"] = 1;
						$cor_pagination=0;
					}
					for($i = 0; $i < $pathVars->size()-$cor_print-$cor_pagination-1- $indexStart; $i++)
					{
						$currentPath .= $pathVars->fetchByIndex($indexStart+1 + $i). "/";
					}
					$currentPath = substr($currentPath,0,strlen($currentPath)-1);
					$_REQUEST['basicurl']=ROOT_WEB.$pathVars->fetchByIndex($indexStart).$currentPath;
					$page_filter="header_urlized = " . quote_smart($currentPath) . " AND status_id<4";
					// ovde resavamo stranice
					$this->ObjectFactory->Reset();
					$this->ObjectFactory->AddFilter($page_filter);
					$page = $this->ObjectFactory->createObjects("Page");
					$this->ObjectFactory->Reset();
					if(countObject($page) == 1) {
						$_REQUEST["page_id"] = $page[0]->getPageID();
						$_SESSION["page_id"]=$_REQUEST["page_id"];
						$_REQUEST["tid"] = $page[0]->getTemplateID();
					}
					else {
						if ($pathVars->size()>1) {


							header("HTTP/1.0 404 Not Found");
							include '404.html';
							exit ();
						}
					}
				}
			}

			if(isset($_REQUEST["tid"]) && (!$_ADMINPAGES)) {
				$temp= $this->ObjectFactory->createObject("Template",$_REQUEST["tid"]);
				if (!$temp->getTitle()) $_REQUEST["tid"]=TEMPLATE_STANDARD;
			}

			$xmlConfig = new XMLConfig;
			$lngext=$this->GetFileDesc();
			if ($lngext=='srl') $lngext='srp';
			$xmlConfig->Parse(ROOT_HOME."config/languages/lang_".$lngext.".xml");
			$this->langGlobal =  $this->Transliterate($xmlConfig->get("/global"));
		}
		function getDecimalPoint()
		{
			switch ($this->language) {
				case 'srpski':
				case 'srpskil':
				case 'srpskic':
					return ",";
					break;
				case 'english':
					return ".";
					break;
			}
		}
		function getThousandsSeparator()
		{
			switch ($this->language) {
				case 'srpski':
				case 'srpskil':
				case 'srpskic':
					return ".";
					break;
				case 'english':
					return ",";
					break;
			}
		}
		function makeTranslatedDateArray() {
			$this->translatedDate = array(
					"Monday" => $this->getTranslationGlobal("GLOBAL_DAY_MONDAY"),
					"Tuesday" => $this->getTranslationGlobal("GLOBAL_DAY_TUESDAY"),
					"Wednesday" => $this->getTranslationGlobal("GLOBAL_DAY_WEDNESDAY"),
					"Thursday" => $this->getTranslationGlobal("GLOBAL_DAY_THURSDAY"),
					"Friday" => $this->getTranslationGlobal("GLOBAL_DAY_FRIDAY"),
					"Saturday" => $this->getTranslationGlobal("GLOBAL_DAY_SATURDAY"),
					"Sunday" => $this->getTranslationGlobal("GLOBAL_DAY_SUNDAY"),
					"Mon" => $this->getTranslationGlobal("GLOBAL_DAY_MONDAY_SHORT"),
					"Tue" => $this->getTranslationGlobal("GLOBAL_DAY_TUESDAY_SHORT"),
					"Wed" => $this->getTranslationGlobal("GLOBAL_DAY_WEDNESDAY_SHORT"),
					"Thu" => $this->getTranslationGlobal("GLOBAL_DAY_THURSDAY_SHORT"),
					"Fri" => $this->getTranslationGlobal("GLOBAL_DAY_FRIDAY_SHORT"),
					"Sat" => $this->getTranslationGlobal("GLOBAL_DAY_SATURDAY_SHORT"),
					"Sun" => $this->getTranslationGlobal("GLOBAL_DAY_SUNDAY_SHORT"),
					"January" => $this->getTranslationGlobal("GLOBAL_MONTH_JANUARY"),
					"February" => $this->getTranslationGlobal("GLOBAL_MONTH_FEBRUARY"),
					"March" => $this->getTranslationGlobal("GLOBAL_MONTH_MARCH"),
					"April" => $this->getTranslationGlobal("GLOBAL_MONTH_APRIL"),
					"May" => $this->getTranslationGlobal("GLOBAL_MONTH_MAY"),
					"June" => $this->getTranslationGlobal("GLOBAL_MONTH_JUNE"),
					"July" => $this->getTranslationGlobal("GLOBAL_MONTH_JULY"),
					"August" => $this->getTranslationGlobal("GLOBAL_MONTH_AUGUST"),
					"September" => $this->getTranslationGlobal("GLOBAL_MONTH_SEPTEMBER"),
					"October" =>  $this->getTranslationGlobal("GLOBAL_MONTH_OCTOBER"),
					"November" => $this->getTranslationGlobal("GLOBAL_MONTH_NOVEMBER"),
					"December" => $this->getTranslationGlobal("GLOBAL_MONTH_DECEMBER"),
					"Jan" => $this->getTranslationGlobal("GLOBAL_MONTH_JANUARY_SHORT"),
					"Feb" =>  $this->getTranslationGlobal("GLOBAL_MONTH_FEBRUARY_SHORT"),
					"Mar" => $this->getTranslationGlobal("GLOBAL_MONTH_MARCH_SHORT"),
					"Apr" => $this->getTranslationGlobal("GLOBAL_MONTH_APRIL_SHORT"),
					"May" =>  $this->getTranslationGlobal("GLOBAL_MONTH_MAY_SHORT"),
					"Jun" => $this->getTranslationGlobal("GLOBAL_MONTH_JUNE_SHORT"),
					"Jul" => $this->getTranslationGlobal("GLOBAL_MONTH_JULY_SHORT"),
					"Aug" => $this->getTranslationGlobal("GLOBAL_MONTH_AUGUST_SHORT"),
					"Sep" => $this->getTranslationGlobal("GLOBAL_MONTH_SEPTEMBER_SHORT"),
					"Oct" => $this->getTranslationGlobal("GLOBAL_MONTH_OCTOBER_SHORT"),
					"Nov" =>  $this->getTranslationGlobal("GLOBAL_MONTH_NOVEMBER_SHORT"),
					"Dec" => $this->getTranslationGlobal("GLOBAL_MONTH_DECEMBER_SHORT")
			);
		}
		function getTranslationGlobal($translationId)
		{
			return $this->langGlobal["value"][$translationId];
		}
		function getDateTranslated($timestamp,$format)
		{
			$this->makeTranslatedDateArray();
			if (empty($format)) $format=$this->GetLinkPluginType('lng_format');
			$transDate = new Date($this->translatedDate,$timestamp,0);
			return $transDate->printDate($format);
		}

		function ChangeTableName(& $tbl_name)
		{
			if (in_array($tbl_name,$this->table_change))
				$tbl_name = $tbl_name.$this->subsite_arr[$this->subsite];

		}
		function ChangeTableNameR($tbl_name)
		{
			if (in_array($tbl_name,$this->table_change))
				return $tbl_name = $tbl_name.$this->subsite_arr[$this->subsite];
			else
				return $tbl_name;
		}

		function DefaultLanguage()
		{
			return $this->default_language;
		}

		function CurrentLanguage()
		{
			return $this->language;
		}

		function GetFileDesc()
		{
			return $this->files_arr[$this->CurrentLanguage()];
		}

		//"news", niz iz kojeg se sve vrednosti izvlace...
		function RegisterPluginLanguageFile($array, $smarty)
		{
			if(!empty($array["value"]))
			{
				foreach ($array["value"] as $key => $value) {
					$smarty->assign($key,$value);
				}
			}
		}
		function RegisterGlobalTranslations($smarty)
		{
			$this->RegisterPluginLanguageFile($this->langGlobal, $smarty);
		}
		function GetPrintLink($Link)
		{
			if(IS_URLREWRITE_ON) return $Link->getLinkRewriteUrl();
		}
		function GetLinkPluginType($str)
		{
			$PluginType=$this->ObjectFactory->CreateObject('SfPluginType',$str);
			if ($PluginType->getCode()=='language' && $this->language=='srpskil') $PluginType->setVrednost('srl');
			return $PluginType->getVrednost();
		}
		function Transliterate($subject)
		{
			if($this->language == "srpskil") {
				$subject = $this->CirToLat($subject);
				$subject = str_replace("/srp","/srl",$subject);
				$subject = str_replace("lang=srpski","lang=srpskil",$subject);
				$subject = htmldecode($subject);
			}
			return $subject;
		}
		function TransliterateLatToCir($subject)
		{
			$subject = htmldecode($subject);
			// popravka linkova da bi radili i na srpskoj cirilici
			$subject = str_replace("/srl","/src",$subject);
			preg_match_all('">([^<>]*?)<"', $subject, $tags, PREG_SET_ORDER);

			if(!empty($tags)) {
				foreach($tags as $tag)
				{
					$subject = str_replace($tag[0],$this->LatToCir($tag[0]),$subject);
				}
			}
			else $subject = $this->LatToCir($subject);
			$subject = $this->RevertOriginalSpans($subject);
			return $subject;
		}
		function RevertOriginalSpans($subject)
		{
			// revert conversion for text in <span class='original'></span>
			$pattern_span = '@(<span\s+)(.+?)(\s*/?>(.+?)</span>)@ise';
			$pattern_class = '@(class=(\'|\"))(.+?)(\'|\")@ise';
			$span_tags_orig = array();
			preg_match_all($pattern_span,$subject,$span_tags_orig);

			for($i = 0;$i< count($span_tags_orig[0]); $i++)
			{
				$span_class = array();
				preg_match($pattern_class,$span_tags_orig[0][$i],$span_class);

				if (isset($span_class[3]) && $span_class[3] == "original")
					$subject = str_replace($span_tags_orig[0][$i], $this->CirToLat($span_tags_orig[4][$i]) , $subject);
			}
			return $subject;
		}
		function LatToCir($text)
		{
			$search = array("Š","š","LJ","NJ","DŽ" ,"Lj","Dž","Nj","lj","nj","dž","a","b","c","č","ć","d","đ","e","f","g","h","i","j","k","l","m","n","o","p","r","s","š","t","u","v","z","ž","A","B","C","Č","Ć","D","Đ","E","F","G","H","I","J","K","L","M","N","O","P","R","S","Š","T","U","V","Z","Ž");
			$replace =array("Ш"       ,"ш"       ,"Љ", "Њ", "Џ",  "Љ", "Џ", "Њ", "љ", "њ", "џ", "а","б","ц","ч","ћ","д","ђ","е","ф","г","х","и","ј","к","л","м","н","о","п","р","с","ш","т","у","в","з","ж","А","Б","Ц","Ч","Ћ","Д","Ђ","Е","Ф","Г","Х","И","Ј","К","Л","М","Н","О","П","Р","С","Ш","Т","У","В","З","Ж");

			$text = str_replace($search, $replace, $text);

			// fix html entites
			$search = array("&нбсп;","&qуот;","&бдqуо;","&лдqуо;","&рдqуо;","&лaqуо;","&рaqуо;","&булл;");
			$replace = array("&nbsp;","&quot;","&bdquo;","&ldquo;","&rdquo;","&ldquo;","&rdquo;","&bull;");

			return str_replace($search, $replace, $text);
		}
		function CirToLat($text)
		{
			$search = array("Ш"        ,"ш"       ,"Љ", "Џ", "Њ", "љ", "њ", "џ","х", "а","б","ц","ч","ћ","д","ђ","е","ф","г","и","ј","к","л","м","н","о","п","р","с","ш","т","у","в","з","ж","А","Б","Ц","Ч","Ћ","Д","Ђ","Е","Ф","Г","Х","И","Ј","К","Л","М","Н","О","П","Р","С","Ш","Т","У","В","З","Ж");
			$replace = array("Š","š","Lj","Dž","Nj","lj","nj","dž","h","a","b","c","č","ć","d","đ","e","f","g","i","j","k","l","m","n","o","p","r","s","š","t","u","v","z","ž","A","B","C","Č","Ć","D","Đ","E","F","G","H","I","J","K","L","M","N","O","P","R","S","Š","T","U","V","Z","Ž");

			return str_replace($search, $replace, $text);
		}
		function CirToLatSpec($text)
		{
			$search = array("Ш"        ,"ш"       ,"Љ", "Џ", "Њ", "љ", "њ", "џ","х", "а","б","ц","ч","ћ","д","ђ","е","ф","г","х","и","ј","к","л","м","н","о","п","р","с","ш","т","у","в","з","ж","ы","А","Б","Ц","Ч","Ћ","Д","Ђ","Е","Ф","Г","Х","И","Ј","К","Л","М","Н","О","П","Р","С","Ш","Т","У","В","З","Ж");
			$replace = array("S;","s;","L","D","N","l","n","d","h","a","b","c","c","c","d","d","e","f","g","h","i","j","k","l","m","n","o","p","r","s","s","t","u","v","z","z","i","A","B","C","C","C","D","D","E","F","G","H","I","J","K","L","M","N","O","P","R","S","S","T","U","V","Z","Z");

			return str_replace($search, $replace, $text);
		}
		function CirToLatAsciffy($text)
		{
			switch ($this->CirToLat($this->language)) {
				case 'srpski' :
				case 'srpskil' :
				case 'english' :
					$search = array("Ш"        ,"ш"       ,"Љ", "Џ", "Њ", "љ", "њ", "џ","х","а","б","ц","ч","ћ","д","ђ","е","ф","г","и","ј","к","л","м","н","о","п","р","с","ш","т","у","в","з","ж","А","Б","Ц","Ч","Ћ","Д","Ђ","Е","Ф","Г","Х","И","Ј","К","Л","М","Н","О","П","Р","С","Ш","Т","У","В","З","Ж");
					$replace = array("S","s","Lj","Dz","Nj","lj","nj","dz","h","a","b","c","c","c","d","dj","e","f","g","i","j","k","l","m","n","o","p","r","s","s","t","u","v","z","z","A","B","C","C","C","D","DJ","E","F","G","H","I","J","K","L","M","N","O","P","R","S","S","T","U","V","Z","Z");
					break;
				case 'russian' :
					$search = array ('а','б','в','г','д','е','ё','ж','з','и','й','к','л','м','н','о','п','р','с','т','у','ф','х','ц','ч','ш','щ','ъ','ы','ь','э','ю','я','А','Б','В','Г','Д','Е','Ё','Ж','З','И','Й','К','Л','М','Н','О','П','Р','С','Т','У','Ф','Х','Ц','Ч','Ш','Щ','Ъ','Ы','Ь','Э','Ю','Я');
					$replace = array ('a','b','v','g','d','e','io','zh','z','i','y','k','l','m','n','o','p','r','s','t','u','f','h','ts','ch','sh','sht','a','i','y','e','yu','ya','A','B','V','G','D','E','Io','Zh','Z','I','Y','K','L','M','N','O','P','R','S','T','U','F','H','Ts','Ch','Sh','Sht','A','I','Y','e','Yu','Ya');
					break;
				default:
					break;
			}
			$text = str_replace($search, $replace, $text);
			return str_replace($search, $replace, $text);
		}

		function GetToolTips($subject)
		{
			global $ObjectFactory;
			$tips = $ObjectFactory->createObjects("Lexicon");
			if (count($tips)>0) {
				foreach ($tips as $tip) {
					$str1='TT'.$tip->getLexiconID();
					$str2=$tip->getHtml();
					$subject=str_replace($str1,$str2,$subject);
				}
			}
			return $subject;
		}
		function GetParentsById($memTree, $itemId, & $parents)
		{
			$currentItem = $memTree->FindItemById($itemId);
			if (!$currentItem) $currentItem = $memTree->FindItemById('0');
			$parentItem = $memTree->FindItemById($currentItem->getParentID());
			$parents[] = $currentItem;
			if($parentItem == null) return;
			$this->GetParentsById($memTree, $parentItem->getID(), $parents);
		}
		function GetPluginCode($step)
		{
			$this->ObjectFactory->ResetFilters();
			$this->ObjectFactory->AddFilter("vrednost='".$step."'");
			$PluginTypes=$this->ObjectFactory->CreateObjects('SfPluginType');
			if (countObject($PluginTypes)>0) {
				$PluginType=$PluginTypes[0];
				return$PluginType->getCode();
			}
			else return "";
		}
		function GetPage($class='',$id=null)
		{
			if (isset($_SESSION['page_id']) && $_SESSION['page_id']!=0)
			{
				$_REQUEST["page_id"]=$_SESSION['page_id'];
			}
			else {
				$this->ObjectFactory->Reset();
				eval ("\$this->ObjectFactory->AddFilter('".$class."_id='.\$id);");
				eval ("\$rc=\$this->ObjectFactory->createObjects('".$class."".$class."Category');");
				foreach ($rc as $x) {
					eval("\$cat=\$this->ObjectFactory->createObject('".$class."Category',\$x->get".$class."CategoryID());");
					if ($cat->getStatus()==STATUS_CATEGORY_GLAVNI) break;
				}
				$this->ObjectFactory->Reset();
				eval("\$this->ObjectFactory->AddFilter('filterid='.\$cat->get".$class."CategoryID());");
				$pt=$this->ObjectFactory->createObjects("PluginTemplate");
				$this->ObjectFactory->Reset();
				$this->ObjectFactory->AddFilter("template_id=".$pt[0]->getTemplateID());
				$page = $this->ObjectFactory->createObjects("Page");
				$this->ObjectFactory->Reset();
				if (count($page)>0) $_REQUEST["page_id"]=$page[0]->getPageID();
			}
		}
		function NewUrl($pathVars,$indexStart)
		{
			$links_print_dt = $this->GetPrintLink ( new LinkResourceDetails($this, 'news', $pathVars->fetchByIndex($indexStart + 2),'w',$pathVars->fetchByIndex($indexStart + 6)));
			header('Location: '. $links_print_dt);
		}
	}

	// opsti pristup resavanju problema visejezicnih sajtova

	// - cuvanje podataka u bazi na vise jezika

	// uglavnom reseneno preko domenskih klasa koje ce u zavisnosti od izabranog jezika
	// da gadjaju razlicite tabele u bazi podataka
	// -!!!!NIJE RESEN PROBLEM :postoji i problem rada sa cirilicnim pismom koje se dobija konvertovanjem latinice iz baze
	//

	// - cuvanje stringova koji se pojavljuju na sajtu na vise jezika
	//   ovo se odnosi na dve grupe stringova
	// -- stringovi koji postoje zakucani u .php fajlovima
	// -- stringovi koji su zakucani u .tpl fajlovima
	//     Svi stringovi koji se pojavljuju u php ili tpl fajlovima ce se izvuci u posebnu datoteku.
	//     Korisno bi bilo da svaki od modula/pluginova ima napravljenu zasebnu datoteku sa stringovima
	//     Idealno bi bilo napraviti XML fajl koji bi mogao po zelji da se azurira a u kome bi se nalazili svi
	//     neophodni stringovi. postojala bi jedna specijalna klasa koja bi citala xml fajl i na osnovu toga sama
	//     registrovala smarty promenljive bez izmena u kodu... Potrebno je definisati izgled ovog xml fajla i nacin
	//     njegovog koriscenja.
?>
