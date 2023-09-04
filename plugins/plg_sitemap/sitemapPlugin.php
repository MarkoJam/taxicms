<?
	include_once("plugins/pagePlugin.php");
	
	class sitemapPlugin extends pagePlugin 
	{
		function __construct()
		{
			parent::__construct();
		}
		
		function showDefault()
		{
			$this->SetPluginLanguage("sitemap");
			
			ob_start();

			$tree = new Tree();
			$tree->display_children_list(0,0);
	
			$sitemap_all = ob_get_contents();
			ob_end_clean(); 
			
			$sitemapData = array( "sitemap_all" => $sitemap_all );
			
			$this->SmartyPluginBlock->setData($sitemapData);
			$this->SmartyPluginBlock->setPosition($this->Position);
			$this->SmartyPluginBlock->setName("plg_sitemap_default");
			
			return $this->SmartyPluginBlock->toArray();	
		}
		
		function showDetails()
		{
			// no detail view
		}
	}
		
	?>