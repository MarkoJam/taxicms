<?
	include_once("plugins/pagePlugin.php");
	
	class slidePlugin extends pagePlugin 
	{
		private $SlideShowID;
		private $SlideShow;
		
		function __construct()
		{
			parent::__construct();
			
			$this->ObjectFactory->ResetFilters();
		}
		
		function setFilterID($filterid)
		{
			$this->SlideShowID = $filterid;
		}
		
		function showDefault()
		{	
			if($this->SlideShowID != "" && $this->SlideShowID != -1)
			{
				$this->ObjectFactory->Reset();
				$this->SlideShow = $this->ObjectFactory->createObject("SlideShow",$this->SlideShowID);				
				$this->ObjectFactory->AddFilter("slideshowid=".$this->SlideShowID);
			}
			
			$slide_arr = $this->ObjectFactory->createObjects("Slide");
			$this->ObjectFactory->Reset();
						
			
			if(count($slide_arr)>0)
			{
				foreach ($slide_arr as $ln) 
				{
					if ($ln->SfStatus->StatusID == STATUS_SLIDE_AKTIVAN)
					{	
						$slide_array = $ln->toArray();
						$slide_all[] = $slide_array;
					}
				}	
			}
			
			$smartyData = array("slide_all" => $slide_all ) ;

			$this->SmartyPluginBlock->setData($smartyData);
			$this->SmartyPluginBlock->setPosition($this->Position);
			$this->SmartyPluginBlock->setName("plg_slideshow_default");
			return $this->SmartyPluginBlock->toArray();				

			
		}
	}
?>