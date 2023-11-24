<?
	include_once("plugins/pagePlugin.php");

	class navigLinksPlugin extends pagePlugin
	{
		function __construct()
		{
			parent::__construct();

			$this->ObjectFactory->ResetFilters();
		}

		function showDefault()
		{
			if(isset($_REQUEST["page_id"]) && $_REQUEST["page_id"] != "")
			{
				$pageid = $_REQUEST["page_id"];
			}
			else $pageid = 0 ;

			$this->ObjectFactory->ResetFilters();
			$cpage = $this->ObjectFactory->createObject("Page",$this->quote_smart($pageid));
			$ppage = $this->ObjectFactory->createObject("Page",$cpage->getParentID());
			$this->ObjectFactory->ResetFilters();
			// I varijanta svu decu
			$this->ObjectFactory->ResetFilters();
			$this->ObjectFactory->AddFilter("parent_id=".$cpage->getPageID());
			$this->ObjectFactory->AddFilter("status_id <> ".STATUS_PAGE_NEAKTIVAN);
			$this->ObjectFactory->AddFilter("type_id <>".PAGE_TYPE_CATEGORY);

			$header = $cpage->getHeader();

			$pages = $this->ObjectFactory->createObjects("Page");
			$this->ObjectFactory->ResetFilters();

			$header_arr = array();
			$pageid_arr = array();
			$links_arr = array();
			// samo ako nema vise dece onda se vratimo i kupimo bracu
			if(count($pages) == 0)
			{
				$header_arr[] = $ppage->getHeader()." All";
				$pageid_arr[] = $ppage->getPageID();
				$linkaddnav =  new LinkAdditionalNavigation($this->LanguageHelper,$ppage->getPageID(),$ppage->getHeaderUnchanged(),$this->HierarchicalTree->path_to_url($ppage->getPageID()));
				$links_arr[] = $this->LanguageHelper->getPrintLink($linkaddnav);
				
				// II varijanta svu bracu
				$this->ObjectFactory->ResetFilters();
				$this->ObjectFactory->AddFilter("parent_id=".$cpage->getParentID());
				$this->ObjectFactory->AddFilter("status_id <> ".STATUS_PAGE_NEAKTIVAN);
				$this->ObjectFactory->AddFilter("type_id <>".PAGE_TYPE_CATEGORY);
				$pages = $this->ObjectFactory->createObjects("Page");
				$this->ObjectFactory->ResetFilters();
				$header = $ppage->getHeader();
			}

			if(count($pages)>0)
			{				
				foreach ($pages as $page)
				{
					$header_arr[] = $page->getHeader();
					$pageid_arr[] = $page->getPageID();
					$linkaddnav =  new LinkAdditionalNavigation($this->LanguageHelper,$page->getPageID(),$page->getHeaderUnchanged(),$this->HierarchicalTree->path_to_url($page->getPageID()));
					$links_arr[] = $this->LanguageHelper->getPrintLink($linkaddnav);
				}
			}

			$smartyData = array(
									"page_header" => $header,
									"page_headers" => $header_arr,
									"page_ids" => $pageid_arr,
									"links_arr" => $links_arr,
									"current_pageid" => $_REQUEST['page_id'],
									);

			$this->SmartyPluginBlock->setData($smartyData);
			$this->SmartyPluginBlock->setPosition($this->Position);
			$this->SmartyPluginBlock->setName("plg_naviglinks_default");

			return $this->SmartyPluginBlock->toArray();

		}

		function showDetails()
		{
			// nothing to show
		}
	}

?>
