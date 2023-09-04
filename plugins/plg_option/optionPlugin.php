<?
	include_once("plugins/pagePlugin.php");
	
	class optionPlugin extends pagePlugin 
	{
		// id kategorije vesti
		private $OptionCategoryID = -1;
		// kategorija vesti
		private $OptionCategory;
		// niz svih objekata vesti
		private $Option;
		
		function __construct()
		{
			parent::__construct();
			
			$this->ObjectFactory->ResetFilters();
		}
		
		function setFilterID($filterid)
		{
			if (isset($filterid)) $this->OptionCategoryID = $filterid;		
			else $this->OptionCategoryID=-1;	
		}
		
		function showDefault()
		{		
			$this->SetPluginLanguage("option");
			
			$option_all = array();
			$option_array = array();
			
			$this->ObjectFactory->ResetFilters();
			$this->OptionCategory = $this->ObjectFactory->createObject("OptionCategory",$this->OptionCategoryID);
			$this->ObjectFactory->ResetFilters();

			// based on filter in plugin try to prepare filter
			$this->ObjectFactory->Reset();
			if(isset($this->OptionCategoryID) && $this->OptionCategoryID != -1)
			{	
				$kategorija = $this->ObjectFactory->createObject("OptionCategory",$this->OptionCategoryID, array("Option")," * ");
				foreach ($kategorija->Option as $nw)
				{
					$option_ids .= $nw->getOptionID(). ",";
				}
				$option_ids = substr($option_ids,0,strlen($option_ids)-1);
				$this->ObjectFactory->AddFilter("option_id IN (".$option_ids.") ");
			}	
			$this->ObjectFactory->AddFilter("status_id =" . STATUS_OPTION_AKTIVAN);
			$this->Option = $this->ObjectFactory->createObjects("Option",array('OptionCategory'));
			$this->ObjectFactory->ResetFilters();

			$this->ObjectFactory->ResetFilters();
			$option_category_all = $this->ObjectFactory->createObjects("OptionCategory");
			$this->ObjectFactory->ResetFilters();
			$option_category_all_smarty = array();
			foreach($option_category_all as $option_category)
			{
				$option_cat=$option_category->toArray();

				$cid= $option_category->getOptionCategoryID();
				$this->ObjectFactory->ResetFilters();
				$this->ObjectFactory->AddFilter("option_category_id =" . $cid);
				$coption = $this->ObjectFactory->createObjects("OptionOptionCategory");
				$this->ObjectFactory->ResetFilters();				
				if (count ($coption)>0) {
					$optionc_array=array();
					foreach($coption as $cn) {
						$nid=$cn->getOptionID();
						$optionfc = $this->ObjectFactory->createObject("Option",$nid);
						$x_array['optionid']=$nid;
						$x_array['header']=$optionfc->getHeader();
						//link
						$x_array['link'] = $this->LanguageHelper->GetPrintLink ( new LinkResourceDetails($this->LanguageHelper, 'option', $nid,'w',$optionfc->getHeaderUnchanged()));
						$optionc_array[]=$x_array;
					}
					$option_cat = array_merge($option_cat, array("option" => $optionc_array));										
				}
				$option_category_all_smarty[] = $option_cat;	
			}
			$cnt = 0;
			if(!empty($this->Option))

			foreach ($this->Option as $option)
			{
				$nid=$option->getOptionID();
				$this->ObjectFactory->Reset();
				$this->ObjectFactory->AddFilter("option_id = " . $nid. " AND option_category_id = " .$this->OptionCategoryID);
				$nc = $this->ObjectFactory->createObjects("OptionOptionCategory");
				$this->ObjectFactory->Reset();
				foreach($nc as $sel_option)
				{
					$option->Order=$sel_option->getOptionOptionCategoryOrder();
				}					
				$html = $option->getShortHtmlUnchanged();
				$html = htmldecode($html);
				$this->GenerateThumbs->PrepareThumbs($html);

				if(IS_URLREWRITE_ON)
					$html = str_replace('src="files/Image','<img src="'.ROOT_WEB."files/Image", $html);
				
				$option->setShortHtml($html);
				$option_array = $option->toArray();
				$content = (strip_tags($html));
				$html_clean = preg_replace ("/&#?[a-z0-9]+;/i"," ", $content );// dodat ociscen html unos za post na linkedin
				$html_clean = preg_replace('/\s+/', ' ', trim($html_clean)); // izbacivanje novog reda zbog popup prozora
				$html_clean = str_replace("'","", $html_clean); 
				$option_array = array_merge($option_array, array("html_clean" => $html_clean));
		
				$links_print_dt = $this->LanguageHelper->GetPrintLink ( new LinkResourceDetails($this->LanguageHelper, 'option', $option->getOptionID(),'w',$option->getHeaderUnchanged()));
				$links_print_fb = $this->LanguageHelper->GetPrintLink ( new LinkResourceDetails($this->LanguageHelper, 'option', $option->getOptionID(),'fb',$option->getHeaderUnchanged()));
				$links_print_in = $this->LanguageHelper->GetPrintLink ( new LinkResourceDetails($this->LanguageHelper, 'option', $option->getOptionID(),'in',$option->getHeaderUnchanged()));
				
				$option_array = array_merge($option_array, array("order" => $option->Order));										
				$option_array = array_merge($option_array, array("link_print_dt" => $links_print_dt));
				$option_array = array_merge($option_array, array("link_print_fb" => $links_print_fb));
				$option_array = array_merge($option_array, array("link_print_in" => $links_print_in));
									
				$option_all[] = $option_array;
				
				$cnt++;

			//if($this->OptionCategoryID != -1 && $cnt >= $this->OptionCategory->MessageNum) break;
			}
			usort($option_all,function($first,$second){
					return $first['order'] > $second['order'];
			});
			if($this->OptionCategoryID != -1) {
				if ($cnt>$this->OptionCategory->MessageNum) $cnt=$this->OptionCategory->MessageNum;
				$result = array();
				for($i = 0; $i < $cnt; $i++){
				  $result[] =$option_all[$i];
				}
				$option_all=$result;
			}
			if($this->OptionCategoryID != -1) $title=$this->OptionCategory->getTitle();
			else $title="";	

			$smartyData = array(
						"option_all" => $option_all,
						//"link_option_archive" => $this->LanguageHelper->GetPrintLink(new LinkOptionArchive($this->LanguageHelper, $this->OptionCategoryID)),
						"option_category_all" => $option_category_all_smarty,
						"title" =>$title,
						"plugin" =>'option',
						"categoryid" =>$this->OptionCategory->getOptionCategoryID()
						) ;
			
			$this->SmartyPluginBlock->setData($smartyData);
			$this->SmartyPluginBlock->setPosition($this->Position);
			$this->SmartyPluginBlock->setName("plg_option_default");
			
			return $this->SmartyPluginBlock->toArray();	
		}
		
		function IsOptionInOptionCategory($option)
		{
			if ($this->OptionCategoryID==-1) return true;
			if($option->OptionCategory != null)
			{
				foreach($option->OptionCategory as $nwc)
				{
					if($nwc != null)
					{
						if($nwc->getOptionCategoryID() == $this->OptionCategoryID) return true;
					}
				}
				return false;
			}
			return false;
		}
		
		function showDetails()
		{
			$this->SetPluginLanguage("option");
			$this->SetPluginLanguage("global");
			
			// Pogled za DETALJE VESTI
			if(isset($_REQUEST['option_id']) && $_REQUEST['plugin_view'] == "option_details")
			{
				$option = $this->ObjectFactory->createObject("Option",$_REQUEST['option_id'],array("SfStatus", "OptionCategory"));
				
				$html = $option->getHtmlUnchanged();
				$html = htmldecode($html);
				
				$this->GenerateThumbs->PrepareThumbs($html);
				
				if(IS_URLREWRITE_ON)
					$html = str_replace('src="files/Image','<img src="'.ROOT_WEB."files/Image", $html);
				
				$option->setHtml($html);
				$option_array = $option->toArray();
				
				// vezani resursi
				$view = new ConnectedObject($this->ObjectFactory,$this->DatabaseBroker, $this->SetLabels());		
				
				$images_x=explode('#',$view->ViewConnectedObject('Option', 'img', $option->getOptionID()));
				$images=array();
				$images_thumb=array();
				foreach ($images_x as $img) {
					if ($img<>"") {
					$images[]=$img;	
					$this->GenerateThumbs->Photo(basename($img),"thumb",dirname($img));
					$images_thumb[]=dirname($img)."/thumb_".basename($img);
					}
				}	
				$this->smarty->assign("images",$images);				
				$this->smarty->assign("images_thumb",$images_thumb);

				$option_array = array_merge($option_array, array(	
					"img_rows" => $view->ViewConnectedObject('Option', 'img', $option->getOptionID()),
					"vid_rows" => $view->ViewConnectedObject('Option', 'vid', $option->getOptionID()),
					"web_rows" => $view->ViewConnectedObject('Option', 'web', $option->getOptionID()),			
					"doc_rows" => $view->ViewConnectedObject('Option', 'doc', $option->getOptionID())));
				$links_print_fb = $this->LanguageHelper->GetPrintLink ( new LinkResourceDetails($this->LanguageHelper, 'option', $option->getOptionID(),'fb',$option->getHeaderUnchanged()));
				$links_print_in = $this->LanguageHelper->GetPrintLink ( new LinkResourceDetails($this->LanguageHelper, 'option', $option->getOptionID(),'in',$option->getHeaderUnchanged()));	
				$option_array = array_merge($option_array, array(
																	"link_print_in" => $links_print_in,
																	"link_print_fb" => $links_print_fb));
				$conres_all=$this->showConResource('Option',10);
				$this->smarty->assign("plg_option_details","true");
				$this->smarty->assign("option_detail",$option_array);
				$this->smarty->assign("conoption",$conres_all);				
				$this->smarty->assign("MASTER_TITLE",$this->getTranslation("PLG_OPTION_DETAILS_TITLE"));
						
			}

		}
}
?>