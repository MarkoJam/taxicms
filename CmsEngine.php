<?php

class CmsEngine
{
	private $languageHelper; 	// languageHelper for all localization and smart url processing
	private $generateThumbs; 	// generateThumbs Object for generating thumbnails
	private $ObjectFactory;		// ObjectFactory is used for Object materialization
	private $DatabaseBroker;

	private $languageGlobalArray = array();
	private $xmlConfig;

	private $hierarchicalTree;  // access to tree that holds methods for accessing page hierarchy

	private $smarty;			// smarty Object that renders page
	private $page; 				// current page that is being displayed
	private $page_id;			// current page id
	private $spage_id;			// current static page - id
	private $page_id_link;		// link to current page
	private $debug = false;

	function __construct($smarty)
	{
		$this->languageHelper = LanguageHelper::getInstance();
		$this->languageHelper->Initialize();

		$this->ObjectFactory = ObjectFactory::getInstance();
		$this->DatabaseBroker = DatabaseBroker::getInstance();
		$this->generateThumbs = GenerateThumbs::getInstance();

		$this->hierarchicalTree = new Tree();

		// load only global translations form language xml files
		/*$this->xmlConfig = new XMLConfig;
		$this->xmlConfig->Parse(ROOT_HOME."config/languages/lang_".$this->languageHelper->GetFileDesc().".xml");
		$this->languageGlobalArray = $this->xmlConfig->get("/global");*/

		$this->smarty = $smarty;
		$this->smarty->assign('search_text',$_SESSION['search_text']);
		$link_search=ROOT_WEB. $this->languageHelper->GetLinkPluginType("language")."/search";
		$this->smarty->assign("link_search",$link_search);
		$this->smarty->assign("ROOT_HOME",ROOT_HOME);
		$this->smarty->assign("ROOT_WEB",ROOT_WEB);
		$this->smarty->assign("ROOT_DEMO",ROOT_DEMO);
		$this->smarty->assign("ROOT_HELP",ROOT_HELP);
		$this->smarty->assign("captchakey1",CAPTCHA_KEY_1);
		$this->smarty->assign("captchakey2",CAPTCHA_KEY_2);
	}

	function Start()
	{
		// evidence of login parametars
		$this->ProcessLogEvidence();
		if($this->IsDebugOn()) echo "CMSEngine: Finished Process LogEvidence for ".(time()+microtime()-$xtime). " sec<br>" ;

		// set updates languages settings
		$this->ProcessLanguages();
		if($this->IsDebugOn()) echo "CMSEngine: Finished ProcessLanguages for ".(time()+microtime()-$xtime). " sec<br>" ;

		// reads Url and creates page for display fills $this->page with current page
		$this->CratePageFromUrl();
		if($this->IsDebugOn()) echo "CMSEngine: Finished CratePageFromUrl for ".(time()+microtime()-$xtime). " sec<br>" ;

		// create connected object for display
		$this->PageConnectedObjects();
		if($this->IsDebugOn()) echo "CMSEngine: Finished PageConnectedObjects() for ".(time()+microtime()-$xtime). " sec<br>" ;

		// processes Static Links
		$this->ProcessStaticLinks();
		if($this->IsDebugOn()) echo "CMSEngine: Finished ProcessStaticLinks for ".(time()+microtime()-$xtime). " sec<br>" ;

		// processes Main menu
		$this->ProccessMainMenu();
		if($this->IsDebugOn()) echo "CMSEngine: Finished ProccessMainMenu for ".(time()+microtime()-$xtime). " sec<br>" ;
		$xtime=time()+microtime();
		// processes Path
		$this->ProcessPath();
		if($this->IsDebugOn()) echo "CMSEngine: Finished ProcessPath for ".(time()+microtime()-$xtime). " sec<br>" ;

		// processes Order Status
		$this->ProcessOrderStatus();
		if($this->IsDebugOn()) echo "CMSEngine: Finished ProcessOrderStatus for ".(time()+microtime()-$xtime). " sec<br>" ;

		// find template and load plugins
		$this->ProcessTemplate();

		if($this->IsDebugOn()) echo "CMSEngine: Finished ProcessTemplate for ".(time()+microtime()-$xtime). " sec<br>" ;

		// get last admin logon date -- used for displaying last update date
		$this->ProcessLastAdminLogonDate();
		if($this->IsDebugOn()) echo "CMSEngine: Finished ProcessLastAdminLogonDate for ".(time()+microtime()-$xtime). " sec<br>" ;

		// register global language traslations
		$this->RegisterGlobalTranslations();
		if($this->IsDebugOn()) echo "CMSEngine: Finished RegisterGlobalTranslations for ".(time()+microtime()-$xtime). " sec<br>" ;
		$xtime=time()+microtime();
		// final result is sent to smarty
		$this->RenderDisplay();
		if($this->IsDebugOn()) echo "CMSEngine: Finished RenderDisplay for ".(time()+microtime()-$xtime). " sec<br>" ;
	}

	function ProcessLogEvidence()
	{
		$uslov=false;
		if (isset($_REQUEST["plugin"])) $plugin=$_REQUEST["plugin"];
		if (isset($_REQUEST["nlid"]) && isset($_REQUEST["access"]) && isset($_REQUEST["uid"])) {;
			$nlid=$_REQUEST["nlid"];
			$access=$_REQUEST["access"];
			$uid=$_REQUEST["uid"];
			$uslov=true;
		}
		if ($_REQUEST ["plugin"]=='katalogproizvoda')
		{
			$uslov=true;
			$pid=$_REQUEST ["id"];
			$proiz=$this->ObjectFactory->createObject ( "PrProizvod", $pid);
			$naziv=$proiz->getNaziv();
			if (strlen($naziv)>0) $uslov=true;
			if ($proiz->getCenaB()>0) $akcija=1;
			else $akcija=0;
		}
		if (!isset($_SESSION["visit_start"]) )
		{
			$uslov=true;
			$_SESSION["visit_start"]=true;
			$plugin='general';
			$uid=0;
			$nlid=0;
			$access='';
			$uid=0;
		}
		if ($uslov) {		
			$vreme=time();
			$current_ip=$_SERVER['REMOTE_ADDR'];
			//$current_ip=$_SERVER['REQUEST_URI'];
			$visitor_ip=ip2long(ltrim(rtrim($current_ip)));
			$sql_ip="SELECT * FROM `ip_range`";
			$results_ip = $this->DatabaseBroker->con->get_results($sql_ip);
			foreach($results_ip as $res)
			{
				$start=ip2long(ltrim(rtrim($res->ip_start)));
				$end=ip2long(ltrim(rtrim($res->ip_end)));
				if ($start<=$visitor_ip && $end>=$visitor_ip) $country=$res->country;
			}
			$sql="INSERT INTO `visits`(`plugin`,`resource_id`,`access`,`user_id`,`newsletter_id`, `akcija`, `time`, `ip`, `country` ) VALUES ('".$plugin."','".$_REQUEST["vr_id"]."','".$access."','".$uid."','".$nlid."','','".$vreme."','".$current_ip."','')";
			$results = $this->DatabaseBroker->con->query($sql);
			$sql3="SELECT max(`visit_id`) as maks FROM `visits`";
			$xid=$this->DatabaseBroker->con->get_results($sql3);
			$_SESSION["visit_id"]=$xid[0]->maks;
		}
	}

	function ProcessLanguages()
	{
		$this->ObjectFactory->ResetFilters();
		$this->ObjectFactory->AddFilter("status_id = ".STATUS_SUBSITE_AKTIVAN);
		$language=$this->ObjectFactory->createObjects("SubSite");
		$this->ObjectFactory->ResetFilters();
		foreach ($language as $lang)
		{
			$lang_array = $lang->toArray();
			$lang_all[] = $lang_array;
		}
		$this->smarty->assign("languages",$lang_all);
		$this->smarty->assign("lang",$this->languageHelper->GetLinkPluginType('language'));
		$this->smarty->assign("language",$this->languageHelper->CurrentLanguage());

		switch ($this->languageHelper->CurrentLanguage())
		{
			case "srpski":
				// za url rewrite za link cirilica latinca
				if($_REQUEST['page_id'] != 0) $this->smarty->assign("srLink", str_replace("/srp/", "/srl/", $_SERVER["REQUEST_URI"]));
				else {$this->smarty->assign("srLink", ROOT_WEB."srl/");
				}
				break;
			case "srpskil":
				// za url rewrite za link cirilica latinca
				$this->smarty->assign("srLink", str_replace("/srl/", "/srp/", $_SERVER["REQUEST_URI"]));
				break;
		}
	}

	function CratePageFromUrl()
	{
		// get regular page if page_id is set
		if(isset($_REQUEST["page_id"]))
		{
			if($_REQUEST["page_id"] == 0) $this->smarty->assign("HOME_PAGE","true");
			$page_id = $_REQUEST["page_id"];
			$this->page = $this->ObjectFactory->createObject("Page",$page_id);
			$this->page_id_link = "page_id=".$_REQUEST["page_id"];

			// some pages can be protected, so here we check if page
			// is protected and user has rights to view this page
			$userHasRightsToViewPage = true;
			if($this->page->getSfPageProtection()->getPageProtectionID() == PAGE_PROTECTION_ACTIVE)
			{
				$userHasRightsToViewPage = false;

				if(isset($_SESSION["loged"]))
				{
					if($_SESSION['loged'] == "Yes")
					{
						// load user Object form database with all UserRoles
						$user = $this->ObjectFactory->createObject("User", $_SESSION["logeduserid"], array("UserRole"));

						// if page have only standard role then every user have right to see this page
						if($this->page->getUserRoleID() == 1)
						{
							$userHasRightsToViewPage = true;
						}
						else // if that is not the case we must check all roles
						{
							foreach ($user->getUserRoles() as $userrole)
							{
								if($userrole->getUserRoleID() == $this->page->getUserRoleID())
								{
									$userHasRightsToViewPage = true;
									break;
								}
							}
						}
					}
				}
			}

			// if there is not enough rights or if page is not exists  show forbidden adminpage
			if($this->page->DbStatus == "NotFound" || !$userHasRightsToViewPage)
			{
				unset($_REQUEST["page_id"]);
				unset($_REQUEST["spage_id"]);

				$this->page = $this->ObjectFactory->createObject("AdminPage","forbidden");
			}
		}
		else if (isset($_REQUEST["spage_id"]))
		{
			$spage_id = $_REQUEST["spage_id"];
			$this->page = $this->ObjectFactory->createObject("StaticPage",$spage_id);
			$this->page_id_link = "spage_id=".$_REQUEST["spage_id"];
		}
		else if (isset($_REQUEST["adminpage_id"]))
		{
			$adminPageID = $_REQUEST["adminpage_id"];
			$this->page = $this->ObjectFactory->createObject("AdminPage",$adminPageID);
			$this->page_id_link = "adminpageid=".$_REQUEST["adminpage_id"];
		}
		else if (!isset($_REQUEST["page_id"]) && !isset($_REQUEST["spage_id"]) && !isset($_REQUEST["adminpagename"]))
		{
			$this->page = $this->ObjectFactory->createObject("Page",0);
			$this->page_id_link = "page_id=0";
		}
	}

	function PageConnectedObjects() {
		if(isset($_REQUEST["page_id"])) {
			$view = new ConnectedObject($this->ObjectFactory,$this->DatabaseBroker);

			$images_x=explode('#',$view->ViewConnectedObject('Page', 'img', $_REQUEST["page_id"] ));
			$images=array();
			$images_thumb=array();
			$images_title=array();
			foreach ($images_x as $img) {
				if ($img<>"") {
					$images[]=$img;
				//	$GenerateThumbs = GenerateThumbs::getInstance();
				//	$GenerateThumbs->Photo(basename($img),"thumb",dirname($img));
					$images_thumb[]=dirname($img)."/thumb_".basename($img);
				//	$sql_count="SELECT count(*) as cnt FROM `image_data` WHERE `image_url`='".$img."'";
				//	$rs=$this->DatabaseBroker->con->get_results($sql_count);
				//	$cnt=$rs[0]->cnt;
				//	if ($cnt>0)	{
				//		$sql_row="SELECT `title`, `description` FROM `image_data` WHERE `image_url`='".$img."'";
				//		$result_row = $this->DatabaseBroker->con->get_row($sql_row);
				//		$images_title[]=$result_row->title;
				//		$images_alt[]=$result_row->description;
				//	}
				}
			}
			$this->smarty->assign("images",$images);
			$this->smarty->assign("images_thumb",$images_thumb);
			$this->smarty->assign("images_title",$images_title);
			$this->smarty->assign("images_alt",$images_alt);

			$this->smarty->assign("page_img",$view->ViewConnectedObject('Page', 'img', $_REQUEST["page_id"]));
			$this->smarty->assign("page_vid",$view->ViewConnectedObject('Page', 'vid', $_REQUEST["page_id"]));
			$this->smarty->assign("page_web",$view->ViewConnectedObject('Page', 'web', $_REQUEST["page_id"]));
			$this->smarty->assign("page_doc",$view->ViewConnectedObject('Page', 'doc', $_REQUEST["page_id"]));
		}
	}

	function ProcessStaticLinks()
	{
		$staticpages = $this->ObjectFactory->createObjects("StaticPage");

		$staticpages_header = array();
		$staticpages_links = array();
		$staticpages_targets = array();
		$staticpages_class = array();

		foreach($staticpages as $statpg)
		{
		  if($statpg->SfStatus->StatusID == STATUS_PAGE_AKTIVAN)
		  {
			if($statpg->SfPageType->ID== PAGE_TYPE_LINK)
			{
				$querystring = "";
				if($_SERVER['QUERY_STRING'] != "")
					$querystring = "?" . $_SERVER['QUERY_STRING'];

				$currentLink = ROOT_WEB . "index.php" . $querystring;

				$staticpagelink = $this->ObjectFactory->createObject("StaticPageLink",$statpg->SPageID);
				$link = "http://".$statpg->Html;
				$staticpages_links[] = $link;
				htmldecode($statpg->Header);
				$staticpages_header[] = str_replace(">","",$statpg->Header);
				$staticpages_targets[] = $staticpagelink->Target;

				if ($currentLink == $link)
					$staticpages_class[] = "selected";
				else
					$staticpages_class[] = "";

			} else { // this PAGE_TYPE_PAGE

				$linkstatic = new LinkStaticPage($this->languageHelper,$statpg->SPageID,$statpg->Header);
				$link = $this->languageHelper->getPrintLink($linkstatic);
				$staticpages_links[] = $link;
				htmldecode($statpg->Header);
				$staticpages_header[] = str_replace(">","",$statpg->Header);
				$staticpages_targets[] = "_self";

				if (isset($_REQUEST["spage_id"]) && $_REQUEST["spage_id"] == $statpg->SPageID)
					$staticpages_class[] = "selected";
				else
					$staticpages_class[] = "";
			}
		  }
		}

		// send result to smarty
		$this->smarty->assign("staticpages_links",$staticpages_links);
		$this->smarty->assign("staticpages_header",$staticpages_header);
		$this->smarty->assign("staticpages_targets",$staticpages_targets);
		$this->smarty->assign("staticpages_class",$staticpages_class);
	}

	function ProccessMainMenu()
	{
		ob_start();
		$this->hierarchicalTree->setCurrentPageId($this->page_id);
		$this->hierarchicalTree->display_menu_list(-1,0,"horizontal");
		$output = ob_get_contents();
		ob_end_clean();
		htmldecode($output);
		// send result to smarty
		$this->smarty->assign("menu_render_horizontal",$output);

		ob_start();
		$this->hierarchicalTree->SetCurrentPageId($this->page_id);
		$this->hierarchicalTree->display_menu_list(-1,0,"vertical");
		$output_vertical = ob_get_contents();
		ob_end_clean();
		htmldecode($output_vertical);
		// send result to smarty
		$this->smarty->assign("menu_render_vertical",$output_vertical);
	}

	function ProcessPath()
	{
		$sitePath = "";
		$pathSeparator = "";
		$pathurl="";
		if($this->page instanceof Page) {
			$i = 0;
			$array_path = $this->hierarchicalTree->get_path($this->page->getPageID(),0);
			if(count($array_path) > 0) {
				foreach($array_path as $path)
				{
					if($i != -1) {
						if($path["type_id"] == PAGE_TYPE_PAGE) {
							$linkPage = new LinkPage($this->languageHelper,$path["page_id"],$path['header'],$this->hierarchicalTree->path_to_url($path["page_id"]));
							$pathurl=$this->languageHelper->GetPrintLink($linkPage);
							$sitePath .= "<li><a href='". $this->languageHelper->GetPrintLink($linkPage) . "'>"  . $path['header'] .   "</a></li>" .$pathSeparator;
						}
						else $sitePath .= "<li>".$path["header"] ."</li>" . $pathSeparator;
					}
					$i++;
				}
			}
		}
		if(count($array_path) == 1) $sitePath='';
		// send result to smarty
		$this->smarty->assign("pathurl",$pathurl);
		$this->smarty->assign("path", $sitePath);
	}

	function ProcessOrderStatus()
	{
		if(isset($_REQUEST["status"]) && $_REQUEST["status"] == "success") $this->smarty->assign("orderstatus", "finish");
		else $this->smarty->assign("orderstatus", "process");
	}

	function ProcessTemplate()
	{
		// Create new PluginInvoker Object
		$invoker = new pluginInvoker();
		$invoker->SetSmarty($this->smarty);
		$SmartyPluginBlocks = array();

		$this->ObjectFactory->ResetFilters();
		$template = $this->ObjectFactory->createObject("Template", TEMPLATE_UNIVERSAL, array("Plugin"));
		$templatePlugin=$template->Plugin;
		// read template id from current page
		//if (isset($_REQUEST['page_id'])) {
			//$templateID = $this->page->getTemplateID();
			// page template can be overriden by url template id
			if(isset($_REQUEST["tid"]))  $templateID = $_REQUEST["tid"];
			$this->ObjectFactory->ResetFilters();
			$template = $this->ObjectFactory->createObject("Template", $templateID, array("Plugin"));
			$this->smarty->assign("templateid",$template->TemplateID);
			$templatePlugin=array_merge($template->Plugin, $templatePlugin);
		//}
		$this->ObjectFactory->ResetFilters();
		foreach($templatePlugin as $pt)
		{
			$this->ObjectFactory->ResetFilters();
			$sfmodule = $this->ObjectFactory->createObject("SfPluginModule", $pt->SfPluginModule->ID);

			//echo "Module: " . $sfmodule->Code;
			//echo "Plugin fileName: " . $pt->FileName;
			//echo "FilterId: ". $pt->FilterID;
			//echo "Position: ". $pt->Position;
			global $lh;
			// Call plugin default code if plugin exists in template
			$SmartyPluginBlocks[] = $invoker->InvokePluginDefault($sfmodule->Code, $pt->FileName, $pt->FilterID, $pt->Position);

			// Sets smarty variables needed for loading css files
			$this->smarty->assign("plg_".$pt->FileName."_css","true");
		}
		$this->smarty->assign("smartypluginblocks", $SmartyPluginBlocks);


		// Activate processing for plugin details
		if(isset($_REQUEST['plugin']) && isset($_REQUEST['plugin_view']))
		{
			// TODO: potencijalni SQL Injection
			$plugin = $_REQUEST['plugin'];
			$plugin_view = $_REQUEST['plugin_view'];

			$this->smarty->assign("plugin", $plugin);
			$this->smarty->assign("plugin_view", $plugin_view);
			$this->smarty->assign("details_on","true");

			// get plugin for db
			$this->ObjectFactory->Reset();
			$this->ObjectFactory->AddFilter("file_name=".quote_smart($plugin));

			$plugin = $this->ObjectFactory->createObjects("Plugin");
			$this->ObjectFactory->Reset();

			if(count($plugin) == 1)
			{
				// get module for given plugin
				$this->ObjectFactory->Reset();
				$sfmodule = $this->ObjectFactory->createObject("SfPluginModule", $plugin[0]->SfPluginModule->ID);
				$this->ObjectFactory->Reset();

				// start invoking plugin detalis
				$invoker->SetModule($sfmodule->Code);
				$invoker->InvokePluginDetails($plugin[0]->FileName);
			}
		}
		if(!isset($_REQUEST['plugin_view']))
		{
			$header = $this->page->getHeader();
			$html = $this->page->getHtml();
			htmldecode($html);
			$shorthtml = $this->page->getShortHtml();
			htmldecode($shorthtml);
			$this->generateThumbs->PrepareThumbs($html);
			$this->smarty->assign("page_id_link", $this->page_id_link);
			$this->smarty->assign("pagecms","true");
			$this->smarty->assign("shorthtml", htmldecode($shorthtml));
			$this->smarty->assign("html", htmldecode($html));
			$this->smarty->assign("header", $header);

			if($this->page->SfPageType->ID== PAGE_TYPE_PAGE)
				{
					$this->smarty->assign("keywords", $this->page->getKeywords());
					$this->smarty->assign("description", $this->page->getDescription());
				}
		}



	}

	function ProcessLastAdminLogonDate()
	{
		$this->ObjectFactory->ResetLimitOffset();
		$this->ObjectFactory->AddLimit(1);
		//$this->ObjectFactory->SetDebugOn();
		$AdminUserLogHistory = $this->ObjectFactory->createObjects("AdminUserLogHistory");
		//$this->ObjectFactory->SetDebugOff();
		$this->ObjectFactory->ResetLimitOffset();

		if (count($AdminUserLogHistory)>0) $this->smarty->assign("last_logon_date",date("d.m.Y",$AdminUserLogHistory[0]->getLastLogDate()));
	}

	function RegisterGlobalTranslations()
	{
		if(!empty($this->languageGlobalArray["value"]))
		{
			foreach($this->languageGlobalArray["value"] as $key => $value)
			{
				$this->smarty->assign($key , $value);
			}
		}
	}

	function RenderDisplay()
	{

		// generate current date
		$currentDate = time();

		$this->smarty->assign("current_date", $this->languageHelper->getDateTranslated($currentDate,"l, d.m.Y"));

		// if format is set to print show print template
		if(isset($_REQUEST["format"]) && $_REQUEST["format"] == "print")
		{
			$this->smarty->display("print.tpl");
			exit();
		}

		// normal render
		$this->smarty->display("index.tpl");
	}

	function SetDebugOn()
	{
		$this->debug = true;
	}

	function SetDebugOff()
	{
		$this->debug = false;
	}

	function IsDebugOn()
	{
		return $this->debug;
	}

}

?>
