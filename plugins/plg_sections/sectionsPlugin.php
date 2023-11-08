<?
	include_once("plugins/pagePlugin.php");
	
	class sectionsPlugin extends pagePlugin 
	{
		// id kategorije vesti
		private $SectionsCategoryID = -1;
		// kategorija vesti
		private $SectionsCategory;
		// niz svih objekata vesti
		private $Sections;
		
		function __construct()
		{
			parent::__construct();
			
			$this->ObjectFactory->ResetFilters();
		}
		
		function setFilterID($filterid)
		{
			if (isset($filterid)) $this->SectionsCategoryID = $filterid;		
			else $this->SectionsCategoryID=-1;	
		}
		
		function showDefault()
		{		
			$this->SetPluginLanguage("sections");
			
			$sections_all = array();
			$sections_array = array();
			
			if($this->SectionsCategoryID != -1) 
			{
				$this->ObjectFactory->ResetFilters();
				$this->SectionsCategory = $this->ObjectFactory->createObject("SectionsCategory",$this->SectionsCategoryID);
				$this->ObjectFactory->ResetFilters();
			}
			
			// based on filter in plugin try to prepare filter
			$this->ObjectFactory->Reset();
			$this->Sections = $this->ObjectFactory->createObjects("Sections", array("SfStatus","SectionsCategory"));
			$this->ObjectFactory->ResetFilters();

			$this->ObjectFactory->ResetFilters();
			$sections_category_all = $this->ObjectFactory->createObjects("SectionsCategory");
			$this->ObjectFactory->ResetFilters();
			
			$sections_category_all_smarty = array();
			foreach($sections_category_all as $sections_category)
			{
				$sections_category_all_smarty[] = $sections_category->toArray();
			}
			
			$cnt = 0;
			if(!empty($this->Sections))

			foreach ($this->Sections as $sections)
			{

				// provrevamo da li se vest nalazi u kategoriji vesti plugina
				if($this->IsSectionsInSectionsCategory($sections) && $sections->SfStatus->StatusID == STATUS_SECTIONS_AKTIVAN)
				{
					$nid=$sections->getSectionsID();
					$this->ObjectFactory->Reset();
					$this->ObjectFactory->AddFilter("sections_id = " . $nid. " AND sections_category_id = " .$this->SectionsCategoryID);
					$nc = $this->ObjectFactory->createObjects("SectionsSectionsCategory");
					$this->ObjectFactory->Reset();
					foreach($nc as $sel_sections)
					{
						$sections->Order=$sel_sections->getSectionsSectionsCategoryOrder();
					}					
					$html = $sections->getShortHtmlUnchanged();
					$html = htmldecode($html);
					$this->GenerateThumbs->PrepareThumbs($html);

					if(IS_URLREWRITE_ON)
						$html = str_replace('src="files/Image','<img src="'.ROOT_WEB."files/Image", $html);
					
					$sections->setShortHtml($html);
					
					$html = $sections->getHtmlUnchanged();
					$html = htmldecode($html);
					$this->GenerateThumbs->PrepareThumbs($html);

					if(IS_URLREWRITE_ON)
						$html = str_replace('src="files/Image','<img src="'.ROOT_WEB."files/Image", $html);
					
					$sections->setHtml($html);					

					$sections_array = $sections->toArray();
					
					//slike vezane
					$sql="SELECT * FROM `con_resource` WHERE `plugin`='Sections' AND `id`=".$nid." AND `obj`='img' ORDER by `res_id`";
					$result_set = $this->DatabaseBroker->con->get_results($sql);
					$img=array();
					foreach ($result_set as $result) {
						$img[]=$result->url;
					}
					//random video
					$video_rnd="/files/tutorials/WIS_Calendar.webm";
					$files = glob("files/tutorials/*.webm");
					shuffle($files);
					$sections_array = array_merge($sections_array, array("images" => $img));	
					$sections_array = array_merge($sections_array, array("order" => $sections->Order));																				
					$sections_array = array_merge($sections_array, array("video_rnd" => $files[0]));

					$sections_all[] = $sections_array;
					$cnt++;
				}
			}
			usort($sections_all,function($first,$second){
					return $first['order'] > $second['order'];
			});
			if($this->SectionsCategoryID != -1) {
				if ($cnt>$this->SectionsCategory->MessageNum) $cnt=$this->SectionsCategory->MessageNum;
				$result = array();
				for($i = 0; $i < $cnt; $i++){
				  $result[] =$sections_all[$i];
				}
				$sections_all=$result;
			}
			$smartyData = array(
						"sections_all" => $sections_all,
						"sections_category_all" => $sections_category_all_smarty,
						) ;
			
			$this->SmartyPluginBlock->setData($smartyData);
			$this->SmartyPluginBlock->setPosition($this->Position);
			$this->SmartyPluginBlock->setName("plg_sections_default");
			
			return $this->SmartyPluginBlock->toArray();	
		}
		
		function IsSectionsInSectionsCategory($sections)
		{
			if ($this->SectionsCategoryID==-1) return true;
			if($sections->SectionsCategory != null)
			{
				foreach($sections->SectionsCategory as $nwc)
				{
					if($nwc != null)
					{
						if($nwc->getSectionsCategoryID() == $this->SectionsCategoryID) return true;
					}
				}
				return false;
			}
			return true;
		}
		
		function showDetails()
		{}
	}
?>