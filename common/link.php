<?
	// interfejs za linkove
	class Link
	{
		var $lh;
		var $addstring;

		function getLinkUrlRewrite(){}
		function getLinkNormal(){}
		function getLanguageParam()
		{
			if($this->lh->CurrentLanguage() != "")
			{
				return "&lang=". $this->lh->CurrentLanguage();
			}

			return "";
		}

		function asciify($str)
	    {
			$str = str_replace("č","c",$str); $str = str_replace("Č","C",$str);
			$str = str_replace("ć","c",$str); $str = str_replace("Ć","C",$str);
			$str = str_replace("š","s",$str); $str = str_replace("Š","S",$str);
			$str = str_replace("ž","z",$str); $str = str_replace("Ž","Z",$str);
			$str = str_replace("đ","dj",$str); $str = str_replace("Đ","Dj",$str);

			return $str;

	    }
	    function urlize($val,$sh=null)
	    {
			global $lh;
			$val = $lh->CirToLatAsciffy($val);
			$val = strtolower($this->asciify(trim($val)));
			$val = iconv('UTF-8', 'ASCII//TRANSLIT', $val);
			$val = str_replace('"', '', $val);
			$val = str_replace('&quot', '', $val);
	        $val = str_replace('&', 'i', $val);
	        $val = str_replace(' ', '-', $val);
			$val = str_replace('"', '', $val);
	        $val = str_replace("'", '', $val);
			$val = str_replace("’", '', $val);
	        $val = preg_replace('/[^a-z0-9]+/', '-', $val);
	        $val = preg_replace('/^[^a-z0-9]+/', '', $val);
	        $val = preg_replace('/[^a-z0-9]+$/', '', $val);

			if ($val=="" and $sh<>"") {
				global $DBBR;
				global $ObjectFactory;
				if (is_numeric($sh)) {
					$page=$ObjectFactory->createObject('Page',$sh);
					$val=$this->urlize($page->getSubHeader(),'');
				}
				else $val=$this->urlize($sh,'');

				/*$sql="SELECT `header` FROM `page_e` WHERE `page_id`=".$this->pageid;
				$result_row = $DBBR->con->get_row($sql);
				$result_row->header;
				$val=$this->urlize($result_row->header,'page');	*/
			}
	        return $val;
	    }
	}

	// zamena za pojedinacne linkove resursa za detaljni prikaz
	class LinkResourceDetails extends Link
	{
		var $resource;
		var $rid;
		var $nlid;
		var $uid;
		var $title;

		function __construct(&$lh, $resource, $rid, $nlid, $title)
		{
			$this->lh = $lh;
			$this->res=$resource;
			$this->rid = $rid;
			$this->nlid = $nlid;
			if (is_numeric($nlid)) $this->uid = '*uid*';
			else {
				$this->uid=0;
				if (isset($_SESSION["logeduserid"])) $this->uid=$_SESSION["logeduserid"];
			}
			$this->title = $title;
		}

		function getLinkRewriteUrl()
		{
			return ROOT_WEB . $this->lh->GetLinkPluginType("language").
				   "/".$this->res.
				   "/".$this->rid.
				   "/details".
				   "/".$this->nlid.
				   "/".$this->uid.
				   "/".$this->urlize($this->title).
				   "/";
		}
	}
	class LinkNewsArchive extends Link
	{
		var $newscategoryid;

		function __construct(&$lh, $newscategoryid, $addstring="")
		{
			$this->lh = $lh;
			$this->newscategoryid = $newscategoryid;
			$this->addstring = $addstring;
		}

		function getLinkRewriteUrl()
		{
			return ROOT_WEB . $this->lh->GetLinkPluginType("language").
				   "/".$this->lh->GetLinkPluginType("news").
				   "/".$this->newscategoryid.
				   "/".$this->lh->GetLinkPluginType("newsarchive").
				   "/";
		}

		function getLinkNormal()
		{
			return "index.php?plugin=news&plugin_view=news_archive".$this->getLanguageParam()."&newscategoryid=".$this->newscategoryid;
		}
	}

	class LinkStatistikaDetails extends Link
	{
		var $pageid;
		var $tid;
		var $id;
		var $title;

		function __construct(&$lh, $id, $templateid, $pageid, $title, $addstring="")
		{
			$this->pageid = $pageid;
			$this->lh = $lh;
			$this->id = $id;
			$this->tid = $templateid;
			$this->title = $title;
			$this->addstring = $addstring;
		}

		function getLinkRewriteUrl()
		{
			return ROOT_WEB . $this->lh->GetLinkPluginType("language").
				   "/".$this->lh->GetLinkPluginType("statistika").
				   "/".$this->id.
				   "/".$this->tid.
				   "/".$this->pageid.
				   "/".$this->lh->GetLinkPluginType("statistikadetalji").
				   "/".$this->urlize($this->title).
				   "/";
		}

		function getLinkNormal()
		{
			return "index.php?plugin=news&plugin_view=news_details&"."tid=".$this->tid."&news_id=".$this->newsid . $this->getLanguageParam();
		}
	}



	class LinkEventArchive extends Link
	{
		var $tid;
		var $eventcategoryid;

		function __construct(&$lh, $templateid,$eventcategoryid, $addstring="")
		{
			$this->lh = $lh;
			$this->tid = $templateid;
			$this->eventcategoryid = $eventcategoryid;
			$this->addstring = $addstring;
		}

		function getLinkRewriteUrl()
		{
			return ROOT_WEB . $this->lh->GetLinkPluginType("language").
				   "/".$this->lh->GetLinkPluginType("event").
				   "/1". // ovo je sranje ali boze moj...
				   "/".$this->tid.
				   "/".$this->lh->GetLinkPluginType("eventarchive").
				   "/";
		}

		function getLinkNormal()
		{
			return "index.php?plugin=event&plugin_view=event_archive&tid=".$this->tid. $this->getLanguageParam()."&eventcategoryid=".$this->eventcategoryid;
		}
	}



	class LinkPage extends Link
	{
		var $pageid;
		var $title;
		var $path_array;

		function __construct($lh , $pageid , $title, $path_array=array(), $addstring="")
		{
			$this->lh = $lh;
			$this->pageid = $pageid;
			$this->title = $title;
			$this->path_array = $path_array;
			$this->addstring = $addstring;
		}

		function getLinkRewriteUrl()
		{
			$url_paths = "";
			foreach ($this->path_array as $part_path)
			{
				$url_paths .= "/" .$this->urlize($part_path[0],$part_path[1]);
			}
			return ROOT_WEB . $this->lh->GetLinkPluginType("language").
					$url_paths.
					"/".$this->urlize($this->title,$this->pageid).
					"/";
		}

		function getLinkNormal()
		{
			return "index.php?page_id=".$this->pageid. $this->getLanguageParam();;
		}
	}

	// for navig links plugin
	class LinkAdditionalNavigation extends Link
	{
		var $pageid;
		var $title;
		var $path_array;

		function __construct($lh , $pageid , $title, $path_array=array(), $addstring="")
		{
			$this->lh = $lh;
			$this->pageid = $pageid;
			$this->title = $title;
			$this->path_array = $path_array;
			$this->addstring = $addstring;
		}

		function getLinkRewriteUrl()
		{
			$url_paths = "";
			foreach ($this->path_array as $part_path)
			{
				$url_paths .= "/" .$this->urlize($part_path[0]);
			}

			return  ROOT_WEB . $this->lh->GetLinkPluginType("language").
					$url_paths.
					"/".$this->urlize($this->title).
					"/";
		}

		function getLinkNormal()
		{
			return "index.php?page_id=".$this->pageid. $this->getLanguageParam();;
		}
	}

	class LinkStaticPage extends Link
	{
		var $spageid;
		var $title;

		function __construct($lh , $spageid , $title, $path_array=array(), $addstring="")
		{
			$this->lh = $lh;
			$this->spageid = $spageid;
			$this->title = $title;
			$this->addstring = $addstring;
		}

		function getLinkRewriteUrl()
		{
			return  ROOT_WEB . $this->lh->GetLinkPluginType("language").
					"/".$this->lh->GetLinkPluginType("staticpage").
					"/".$this->urlize($this->title).
					"/".$this->spageid.
					"/";
		}

		function getLinkNormal()
		{
			return "index.php?spage_id=".$this->spageid. $this->getLanguageParam();;
		}
	}

	class LinkAdminPage extends Link
	{
		var $adminpageid;
		var $adminpagename;
		var $title;

		function __construct($lh , $adminpageid, $adminpagename, $title, $addstring="")
		{
			$this->lh = $lh;
			$this->adminpageid = $adminpageid;
			$this->adminpagename = $adminpagename;
			$this->title = $title;
			$this->addstring = $addstring;
		}

		function getLinkRewriteUrl()
		{
			return  ROOT_WEB . $this->lh->GetLinkPluginType("language").
					"/".$this->lh->GetLinkPluginType("adminpage").
					"/".$this->urlize($this->title).
					"/".$this->adminpageid.
					"/".$this->adminpagename.
					"/";
		}

		function getLinkNormal()
		{
			return "index.php?adminpagename=".$this->adminpagename;
		}

	}

	class LinkProductDetails extends Link
	{
		var $pageid;
		var $proizvodid;
		var $productPlugin;
		var $productPluginView;
		var $proizvodNaziv;
		var $offsetParam;
		var $addLink;

		function __construct($lh, $productPlugin,$productPluginView = "product_details", $pageid, $proizvodid, $proizvodNaziv, $offsetParam, $addLink="")
		{
			$this->lh = $lh;
			$this->productPlugin = $productPlugin;
			$this->productPluginView = $productPluginView;
			$this->pageid = $pageid;
			$this->proizvodid = $proizvodid;
			$this->proizvodNaziv = $proizvodNaziv;
			$this->offsetParam = $offsetParam;
			$this->addLink = $addLink;
		}

		function getLinkRewriteUrl()
		{
			return  ROOT_WEB . $this->lh->GetLinkPluginType("language").
					"/".$this->lh->GetLinkPluginType("promocija"). // ???
					"/".$this->pageid.
					"/".$this->proizvodid. // ovo je sranje ali boze moj...
					"/".$this->urlize($this->proizvodNaziv).
					"/";
		}

		function getLinkNormal()
		{
			return "index.php?plugin=".$this->productPlugin."&plugin_view=".$this->productPluginView."&page_id=".$this->pageid."&proizvodid=". $this->proizvodid. "&". $this->offsetParam . $this->addLink. $this->getLanguageParam();
		}
	}

	class LinkProductCategoryDetails extends Link
	{
		var $pageid;
		var $kategorijaid;
		var $productPlugin;
		var $productPluginView;
		var $kategorijaNaziv;
		var $offsetParam;
		var $addLink;

		function __construct($lh, $productPlugin,$productPluginView = "productcategory_details", $pageid, $kategorijaid, $kategorijaNaziv, $offsetParam="offset", $addLink="")
		{
			$this->lh = $lh;
			$this->productPlugin = $productPlugin;
			$this->productPluginView = $productPluginView;
			$this->pageid = $pageid;
			$this->kategorijaid = $kategorijaid;
			$this->kategorijaNaziv = $kategorijaNaziv;
			$this->offsetParam = $offsetParam;
			$this->addLink = $addLink;
		}

		function getLinkRewriteUrl()
		{
			return  ROOT_WEB . $this->lh->GetLinkPluginType("language").
					"/".$this->lh->GetLinkPluginType("proizvod"). // ???
					"/".$this->kategorijaid. // ovo je sranje ali boze moj...
					"/".$this->urlize($this->kategorijaNaziv).
					"/";
		}

		function getLinkNormal()
		{
			return "index.php?plugin=".$this->productPlugin."&plugin_view=".$this->productPluginView."&page_id=".$this->pageid."&kategorijaid=". $this->kategorijaid. "&". $this->offsetParam . $this->addLink. $this->getLanguageParam();
		}
	}

	class LinkCatalogProductDetails extends Link
	{
		var $pageid;
		var $proizvodid;
		var $grupaproizvodaid;

		function __construct($lh, $pageid, $proizvodid, $grupaproizvodaid, $proizvodNaziv, $offsetParam, $addLink="")
		{
			$this->lh = $lh;
			$this->pageid = $pageid;
			$this->proizvodid = $proizvodid;
			$this->grupaproizvodaid = $grupaproizvodaid;
			$this->proizvodNaziv = $proizvodNaziv;
			$this->offsetParam = $offsetParam;
			$this->addLink = $addLink;
		}

		function getLinkRewriteUrl()
		{
			return  ROOT_WEB . $this->lh->GetLinkPluginType("language").
					"/".$this->lh->GetLinkPluginType("proizvodi"). // ???
					"/".$this->pageid.
					"/".$this->proizvodid.
					"/".$this->grupaproizvodaid.
					"/".$this->urlize($this->proizvodNaziv).
					"/";
		}

		function getLinkNormal()
		{
			return "index.php?plugin=grupaproizvod&plugin_view=complex_details&page_id=".$this->pageid."&proizvodid=".$this->proizvodid."&grupaproizvodaid=" . $this->grupaproizvodaid . "&". $this->offsetParam . $this->addLink. $this->getLanguageParam();
		}
	}

	class LinkCatalogGrupaProizvod extends Link
	{
		var $pageid;
		var $grupaproizvodaid;
		var $grupaProizvodaNaziv;

		function __construct($lh, $pageid, $grupaproizvodaid, $grupaProizvodaNaziv)
		{
			$this->lh = $lh;
			$this->pageid = $pageid;
			$this->grupaproizvodaid = $grupaproizvodaid;
			$this->grupaProizvodaNaziv = $grupaProizvodaNaziv;
		}

		function getLinkRewriteUrl()
		{
			return  ROOT_WEB . $this->lh->GetLinkPluginType("language").
					"/".$this->lh->GetLinkPluginType("katalog"). // ???
					"/".$this->pageid.
					"/".$this->grupaproizvodaid.
					"/".$this->urlize($this->grupaProizvodaNaziv).
					"/";
		}

		function getLinkNormal()
		{
			return "index.php?page_id=".$this->pageid."&grupaproizvodaid=".$this->grupaproizvodaid."&plugin=grupaproizvod&plugin_view=complex_details" . $this->getLanguageParam();
		}
	}

	class LinkGrupaTipProizvod extends Link
	{
		var $pageid;
		var $tipproizvodid;
		var $tipproizvodNaziv;

		function __construct($lh, $pageid, $tipproizvodid, $tipproizvodNaziv)
		{
			$this->lh = $lh;
			$this->pageid = $pageid;
			$this->tipproizvodid = $tipproizvodid;
			$this->tipproizvodNaziv = $tipproizvodNaziv;
		}

		function getLinkRewriteUrl()
		{
			// TODO: !!!
			return  ROOT_WEB . $this->lh->GetLinkPluginType("language").
					"/".$this->lh->GetLinkPluginType("proizvod"). // ???
					"/".$this->proizvodid. // ovo je sranje ali boze moj...
					"/".$this->urlize($this->proizvodNaziv).
					"/";
		}

		function getLinkNormal()
		{
			return "index.php?plugin=grupatipproizvod&plugin_view=productgroup_details&page_id=".$this->pageid."&tipproizvodaid=". $this->tipproizvodid. $this->getLanguageParam();
		}
	}

	class LinkGrupaKategorijaProizvod extends Link
	{
		var $pageid;
		var $kategorijaProizvodId;
		var $kategorijaProizvodNaziv;

		function __construct($lh, $pageid, $kategorijaProizvodId, $kategorijaProizvodNaziv)
		{
			$this->lh = $lh;
			$this->pageid = $pageid;
			$this->kategorijaProizvodId = $kategorijaProizvodId;
			$this->kategorijaProizvodNaziv = $kategorijaProizvodNaziv;
		}

		function getLinkRewriteUrl()
		{
			// TODO: !!!
			return  ROOT_WEB . $this->lh->GetLinkPluginType("language").
					"/".$this->lh->GetLinkPluginType("proizvod"). // ???
					"/".$this->proizvodid. // ovo je sranje ali boze moj...
					"/".$this->urlize($this->proizvodNaziv).
					"/";
		}

		function getLinkNormal()
		{
			return "index.php?plugin=kategorijaproizvod&plugin_view=productcategory_detail&page_id=".$this->pageid."&kategorijaid=". $this->kategorijaProizvodId. $this->getLanguageParam();
		}

	}

	// link klase za katalog proizvoda
	class LinkKpGrupaProizvoda extends Link
	{
		var $memTree;
		var $tid;
		var $grupaproizvodaid;
		var $grupaProizvodaNaziv;

		function __construct($lh, $memTree, $tid, $grupaproizvodaid, $grupaProizvodaNaziv)
		{
			$this->lh = $lh;
			$this->memTree = $memTree;
			$this->tid = $tid;
			$this->grupaproizvodaid = $grupaproizvodaid;
			$this->grupaProizvodaNaziv = $grupaProizvodaNaziv;
		}

		function getLinkRewriteUrl()
		{
			$parents = array();
			$this->lh->GetParentsById($this->memTree, $this->grupaproizvodaid, $parents);

			$title_url = "";
			for($i= count($parents)-2; $i >= 0; $i--)
			{
				$title_url .= "/".$this->urlize($parents[$i]->getTitle());
			}

			return  ROOT_WEB . $this->lh->GetLinkPluginType("language").
					"/".$this->lh->GetLinkPluginType("catalog"). // ???
					"/".$this->tid.
					"/".$this->grupaproizvodaid.
					$title_url.
					"/";
		}

		function getLinkNormal()
		{
			$templateParam = "";
			if($this->tid != "")
				$templateParam = "&tid=".$this->tid;

			return "index.php?a=1".$templateParam."&grupaproizvodaid=".$this->grupaproizvodaid."&plugin=katalogproizvoda&plugin_view=details" . $this->getLanguageParam();
		}
	}

	class LinkKpProductDetails extends Link
	{
		var $memTree;
		var $templateid;
		var $proizvodid;
		var $nlid;
		var $uid;
		var $grupaproizvodaid;

		function __construct($lh,$memTree, $proizvodid, $grupaproizvodaid, $nlid, $proizvodNaziv, $offsetParam="", $addLink="")
		{
			$this->lh = $lh;
			$this->memTree = $memTree;
			//$this->templateid = $templateid;
			$this->proizvodid = $proizvodid;
			$this->grupaproizvodaid = $grupaproizvodaid;
			$this->nlid = $nlid;
			if (is_numeric($nlid)) $this->uid = '*uid*';
			else {
				$this->uid=0;
				if (isset($_SESSION["logeduserid"])) $this->uid=$_SESSION["logeduserid"];
			}
			$this->proizvodNaziv = $proizvodNaziv;
			$this->offsetParam = $offsetParam;
			$this->addLink = $addLink;
		}

		function getLinkRewriteUrl()
		{
			$parents = array();
			$this->lh->GetParentsById($this->memTree, $this->grupaproizvodaid, $parents);

			$grupe_proizvoda_url = "";
			for($i= count($parents)-2; $i >= 0; $i--)
			{
				$grupe_proizvoda_url .= "/".$this->urlize($parents[$i]->getTitle());
			}

			global $ObjectFactory;
			return  ROOT_WEB . $this->lh->GetLinkPluginType("language").
					"/".$this->lh->GetLinkPluginType("product"). // Zamenjeno jer koristimo katalog proizvoda
					//"/".$this->templateid.
					"/".$this->proizvodid.
					"/".$this->grupaproizvodaid.
					"/details".
				   "/".$this->nlid.
				   "/".$this->uid.
					$grupe_proizvoda_url.
					"/".$this->urlize($this->proizvodNaziv).
					"/";
		}
	}

	/*class LinkProductBasket extends Link
	{
		var $templateid;

		function __construct($lh, $templateid)
		{
			$this->lh = $lh;
			$this->templateid = $templateid;
		}

		function getLinkRewriteUrl()
		{
			return  ROOT_WEB . $this->lh->GetLinkPluginType("language").
			"/".$this->lh->GetLinkPluginType("basket").
			"/".$this->templateid ;
		}

		function getLinkNormal()
		{
			return "index.php?plugin=order&plugin_view=basket&tid=".$this->templateid. $this->getLanguageParam();
		}
	}
*/
	class LinkProductAddToBasket extends Link
	{
		var $proizvodid;
		var $backurl;

		function __construct($lh, $proizvodid, $backurl)
		{
			$this->lh = $lh;
			$this->proizvodid = $proizvodid;
			$this->backurl = $backurl;
		}

		function getLinkRewriteUrl()
		{
			return  ROOT_WEB . $this->lh->GetLinkPluginType("language").
					"/".$this->lh->GetLinkPluginType("proizvod"). // ???
					"/".$this->proizvodid. // ovo je sranje ali boze moj...
					"/".$this->backurl.
					"/";
		}

		function getLinkNormal()
		{
			return "/index.php?proizvodid=". $this->proizvodid. "backurl=".$this->backurl. $this->getLanguageParam();
		}
	}

	class LinkShoppingCard extends Link
	{
		function __construct($step)
		{
			$this->lh = LanguageHelper::getInstance();
			$this->step = $step;
		}

		function getLinkRewriteUrl()
		{
			return  ROOT_WEB . $this->lh->GetLinkPluginType("language").
			"/".$this->lh->GetLinkPluginType("order").
			"/".$this->lh->GetLinkPluginType($this->step).
			"/";
		}
	}

	class LinkAddOneProductToBasket extends Link
	{
		var $proizvodid;

		function __construct($lh, $proizvodid)
		{
			$this->lh = $lh;
			$this->proizvodid = $proizvodid;
		}

		function getLinkRewriteUrl()
		{
			return "/plugins/plg_order/korpa_add_one.php?proizvodid=". $this->proizvodid. $this->getLanguageParam();
		}

		function getLinkNormal()
		{
			return "/plugins/plg_order/korpa_add_one.php?proizvodid=". $this->proizvodid. $this->getLanguageParam();
		}
	}

	class LinkRegistration extends Link
	{
		var $pageid;
		var $tid;

		function __construct($lh, $pageid, $tid, $unr=null)
		{
			$this->lh = $lh;
			$this->pageid = $pageid;
			$this->tid = $tid;
			$this->unr = $unr;
		}

		function getLinkRewriteUrl()
		{
			return  ROOT_WEB . $this->lh->GetLinkPluginType("language").
			"/".$this->lh->GetLinkPluginType("registracija"). // ???
			"/".$this->pageid.
			"/".$this->tid.
			"/".$this->unr.
			"/";
		}

		function getLinkNormal()
		{
			$templateParam = "";
			if($this->tid != "")
				$templateParam = "&tid=".$this->tid;

			$pageParam = "";
			if($this->pageid != "")
				$pageParam = "&pageid=".$this->pageid;

			return "index.php?". $pageParam . $templateParam."&plugin=login&plugin_view=registration" . $this->getLanguageParam();
		}
	}

	class LinkBasketEdit extends Link
	{
		var $lang;

		function __construct($lh)
		{
			$this->lh = $lh;
		}

		function getLinkRewriteUrl()
		{
			return "/plugins/plg_order/korpa_edit.php?a=1". $this->getLanguageParam();
		}

		function getLinkNormal()
		{
			return "/plugins/plg_order/korpa_edit.php?a=1". $this->getLanguageParam();
		}
	}

	class LinkBasketOverview extends Link
	{
		var $lang;
		var $tid;

		function __construct($lh, $tid)
		{
			$this->lh = $lh;
			$this->tid = $tid;
		}

		function getLinkRewriteUrl()
		{
			return  ROOT_WEB . $this->lh->GetLinkPluginType("language").
			"/".$this->lh->GetLinkPluginType("pregledkorpe"). // ???
			"/".$this->tid.
			"/";
		}

		function getLinkNormal()
		{
			return "/index.php?plugin=order&plugin_view=overview&tid=". $this->tid.  $this->getLanguageParam();
		}
	}

	class LinkShipment extends Link
	{
		var $lang;
		var $tid;

		function __construct($lh, $tid)
		{
			$this->lh = $lh;
			$this->tid = $tid;
		}

		function getLinkRewriteUrl()
		{
			return  ROOT_WEB . $this->lh->GetLinkPluginType("language").
			"/".$this->lh->GetLinkPluginType("shipment"). // ???
			"/".$this->tid.
			"/";
		}

		function getLinkNormal()
		{
			return "/index.php?plugin=order&plugin_view=overview&tid=". $this->tid.  $this->getLanguageParam();
		}
	}


	class LinkBasketCheckOut extends Link
	{
		var $lang;
		var $tid;

		function __construct($lh, $tid)
		{
			$this->lh = $lh;
			$this->tid = $tid;
		}

		function getLinkRewriteUrl()
		{
			return  ROOT_WEB . $this->lh->GetLinkPluginType("language").
			"/".$this->lh->GetLinkPluginType("kasa"). // ???
			"/".$this->tid.
			"/";
		}

		function getLinkNormal()
		{
			return "/plugins/plg_order/order_final.php?tid=".$this->tid .  $this->getLanguageParam();
		}
	}

	class LinkOrderBack extends Link
	{
		var $lang;
		var $tid;

		function __construct($lh, $tid, $orderid)
		{
			$this->lh = $lh;
			$this->tid = $tid;
			$this->orderid = $orderid;
		}

		function getLinkRewriteUrl()
		{
			return  ROOT_WEB . $this->lh->GetLinkPluginType("language").
			"/".$this->lh->GetLinkPluginType("orderback"). // ???
			"/".$this->tid.
			"/".$this->orderid.
			"/";
		}

		function getLinkNormal()
		{
			return "/plugins/plg_order/order_final.php?tid=".$this->tid .  $this->getLanguageParam();
		}
	}



	class LinkLanguage extends Link
	{
		var $lang;

		function __construct($lh, $lang)
		{
			$this->lh = $lh;
			$this->lang = $lang;
		}

		function getLinkRewriteUrl()
		{
			return "/".$this->lh->plugin["language"][$this->lang]."/";
		}

		function getLinkNormal()
		{
			return "/index.php?lang=".$this->lang;
		}

	}
?>
