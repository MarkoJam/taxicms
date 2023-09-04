<?
	include_once("plugins/pagePlugin.php");
	
	class linksCategoryPlugin extends pagePlugin 
	{
		private $LinksCategoryID;
		private $LinksCategory;
		
		function __construct()
		{
			parent::__construct();
			
			$this->ObjectFactory->ResetFilters();
		}
		
		function setFilterID($filterid)
		{
			$this->LinksCategoryID = $filterid;
		}
		
		function showDefault()
		{	
			if($this->LinksCategoryID != "" && $this->LinksCategoryID != -1)
			{
				$this->ObjectFactory->Reset();
				$this->LinksCategory = $this->ObjectFactory->createObject("LinksCategory",$this->LinksCategoryID);
				$link_category = $this->LinksCategory->CategoryName;
				
				$this->ObjectFactory->AddFilter("linkscategoryid=".$this->LinksCategoryID);
			}
			else 
			{
				$link_category = $this->getTranslation("PLG_LINK_CATEGORY_NAME");
			}
			
			$links_arr = $this->ObjectFactory->createObjects("Links");
			$this->ObjectFactory->Reset();
						
			$links_ids = array(); $links_titles =  array(); $links_urls = array();
			
			if(count($links_arr)>0)
			{
				foreach ($links_arr as $ln) 
				{
					$links_ids[] = $ln->LinksID;
					$links_names[] = $ln->LinksName;
							
					if(substr($ln->LinksUrl,0,7) != "http://")
					{
						$links_urls[] = "http://".$ln->LinksUrl;	
					}
					else $links_urls[] = $ln->LinksUrl;
				}	
			}
			
			$this->smarty->assign("link_ids",$links_ids);
			$this->smarty->assign("link_names",$links_names);
			$this->smarty->assign("link_urls",$links_urls);
			$this->smarty->assign("link_category",$link_category);
			
			$this->smarty->assign("plg_linkscategory_defalut","true");
		}
	}
?>
