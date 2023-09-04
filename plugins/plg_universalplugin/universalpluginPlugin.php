<?
	include_once("plugins/pagePlugin.php");
	
	class universalpluginPlugin extends pagePlugin 
	{
		private $generateThumbs; 	// generateThumbs object for generating thumbnails
		
		private $UniversalPlugin;
		public $UniversalPluginID;
		
		function __construct()
		{
			parent::__construct();
			
			$this->generateThumbs = GenerateThumbs::getInstance();
		}
		
		function setFilterID($filterid)
		{
			$this->UniversalPluginID = $filterid;
		}
		
		function showDefault()
		{
			// za slide efect
			$this->ObjectFactory->Reset();
			$this->ObjectFactory->AddFilter("name='SLIDE_EFFECT'" );
			$set = $this->ObjectFactory->createObjects("Setting");
			$this->ObjectFactory->Reset();
			if (count($set)>0) $vlid=$set[0]->getValue();	
			$this->ObjectFactory->Reset();
			$this->ObjectFactory->AddFilter("setting_type_values_id = ".$vlid. " AND setting_type_id=3" );
			$set1 = $this->ObjectFactory->createObjects("SfSettingTypeValues");
			$this->ObjectFactory->Reset();
			if (count($set1)>0) {$val= $set1[0]->getValue();
				$this->smarty->assign("slide_effect",$val);
			}
			
			$this->SetPluginLanguage("universal");
			$this->SetPluginLanguage("global");
			if($this->UniversalPluginID != "")
			{
				$this->UniversalPlugin = $this->ObjectFactory->createObject("UniversalPlugin",$this->UniversalPluginID);
				$this->ObjectFactory->ResetFilters();
				
				$html = $this->UniversalPlugin->getHtml();
				htmldecode($html);
				$this->generateThumbs->PrepareThumbs($html);
				$this->UniversalPlugin->setHtml($html);
				
				$this->SmartyPluginBlock->setData($this->UniversalPlugin->toArray());
			}
			else 
			{
				$this->SmartyPluginBlock->setData(array("header" => "ERROR", "html" => "Greška u podešavanju modula"));
			}

			$this->SmartyPluginBlock->setPosition($this->Position);
			$this->SmartyPluginBlock->setName("plg_universalplugin_default");
			
			return $this->SmartyPluginBlock->toArray();
		}
		
		function showDetails()
		{
			// no detail view
		}
	}
		
	?>