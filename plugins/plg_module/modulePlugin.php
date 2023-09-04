<?
	include_once("plugins/pagePlugin.php");
	
	class modulePlugin extends pagePlugin 
	{
		// id kategorije vesti
		private $ModuleCategoryID = -1;
		// kategorija vesti
		private $ModuleCategory;
		// niz svih objekata vesti
		private $Module;
		
		function __construct()
		{
			parent::__construct();
			
			$this->ObjectFactory->ResetFilters();
		}
		
		function setFilterID($filterid)
		{
			if (isset($filterid)) $this->ModuleCategoryID = $filterid;		
			else $this->ModuleCategoryID=-1;	
		}
		
		function showDefault()
		{		

			$this->SetPluginLanguage("module");
			
			$module_all = array();
			$module_array = array();


			$this->ObjectFactory->ResetFilters();
			$this->ModuleCategory = $this->ObjectFactory->createObject("ModuleCategory",$this->ModuleCategoryID);
			$this->ObjectFactory->ResetFilters();

			
			// based on filter in plugin try to prepare filter
			$this->ObjectFactory->Reset();
			if(isset($this->ModuleCategoryID) && $this->ModuleCategoryID != -1)
			{	
				$kategorija = $this->ObjectFactory->createObject("ModuleCategory",$this->ModuleCategoryID, array("Module")," * ");
				foreach ($kategorija->Module as $nw)
				{
					$module_ids .= $nw->getModuleID(). ",";
				}
				$module_ids = substr($module_ids,0,strlen($module_ids)-1);
				$this->ObjectFactory->AddFilter("module_id IN (".$module_ids.") ");
			}	
			$this->ObjectFactory->AddFilter("status_id =" . STATUS_MODULE_AKTIVAN);
			$this->Module = $this->ObjectFactory->createObjects("Module",array('ModuleCategory'));
			$this->ObjectFactory->ResetFilters();

			$this->ObjectFactory->ResetFilters();
			$module_category_all = $this->ObjectFactory->createObjects("ModuleCategory");
			$this->ObjectFactory->ResetFilters();
			$module_category_all_smarty = array();
			foreach($module_category_all as $module_category)
			{
				$module_cat=$module_category->toArray();

				$cid= $module_category->getModuleCategoryID();
				$this->ObjectFactory->ResetFilters();
				$this->ObjectFactory->AddFilter("module_category_id =" . $cid);
				$cmodule = $this->ObjectFactory->createObjects("ModuleModuleCategory");
				$this->ObjectFactory->ResetFilters();				
				if (count ($cmodule)>0) {
					$modulec_array=array();
					foreach($cmodule as $cn) {
						$nid=$cn->getModuleID();
						$modulefc = $this->ObjectFactory->createObject("Module",$nid);
						$x_array['moduleid']=$nid;
						$x_array['header']=$modulefc->getHeader();
						//link
						$x_array['link'] = $this->LanguageHelper->GetPrintLink ( new LinkResourceDetails($this->LanguageHelper, 'module', $nid,'w',$modulefc->getHeaderUnchanged()));
						$modulec_array[]=$x_array;
					}
					$module_cat = array_merge($module_cat, array("module" => $modulec_array));										
				}
				$module_category_all_smarty[] = $module_cat;	
			}
			$cnt = 0;
			if(!empty($this->Module))

			foreach ($this->Module as $module)
			{
				$nid=$module->getModuleID();
				$this->ObjectFactory->Reset();
				$this->ObjectFactory->AddFilter("module_id = " . $nid. " AND module_category_id = " .$this->ModuleCategoryID);
				$nc = $this->ObjectFactory->createObjects("ModuleModuleCategory");
				$this->ObjectFactory->Reset();
				foreach($nc as $sel_module)
				{
					$module->Order=$sel_module->getModuleModuleCategoryOrder();
				}					
				$html = $module->getShortHtmlUnchanged();
				$html = htmldecode($html);
				$this->GenerateThumbs->PrepareThumbs($html);

				if(IS_URLREWRITE_ON)
					$html = str_replace('src="files/Image','<img src="'.ROOT_WEB."files/Image", $html);
				
				$module->setShortHtml($html);
				$module_array = $module->toArray();
				

				if(strlen($module->getHtml()) == 0) {
					$links_print_dt = "#";
					$links_print_fb = "#";
					$links_print_in = "#";
				}	
				else
				{		
					$content = (strip_tags($html));
					$html_clean = preg_replace ("/&#?[a-z0-9]+;/i"," ", $content );// dodat ociscen html unos za post na linkedin
					$html_clean = preg_replace('/\s+/', ' ', trim($html_clean)); // izbacivanje novog reda zbog popup prozora
					$html_clean = str_replace("'","", $html_clean); 
					$module_array = array_merge($module_array, array("html_clean" => $html_clean));
			
					$links_print_dt = $this->LanguageHelper->GetPrintLink ( new LinkResourceDetails($this->LanguageHelper, 'module', $module->getModuleID(),'w',$module->getHeaderUnchanged()));
					$links_print_fb = $this->LanguageHelper->GetPrintLink ( new LinkResourceDetails($this->LanguageHelper, 'module', $module->getModuleID(),'fb',$module->getHeaderUnchanged()));
					$links_print_in = $this->LanguageHelper->GetPrintLink ( new LinkResourceDetails($this->LanguageHelper, 'module', $module->getModuleID(),'in',$module->getHeaderUnchanged()));
				}
				$module_array = array_merge($module_array, array("order" => $module->Order));										
				$module_array = array_merge($module_array, array("link_print_dt" => $links_print_dt));
				$module_array = array_merge($module_array, array("link_print_fb" => $links_print_fb));
				$module_array = array_merge($module_array, array("link_print_in" => $links_print_in));
									
				$module_all[] = $module_array;
				
				$cnt++;

			//if($this->ModuleCategoryID != -1 && $cnt >= $this->ModuleCategory->MessageNum) break;
			}
			usort($module_all,function($first,$second){
					return $first['order'] > $second['order'];
			});
			if($this->ModuleCategoryID != -1) {
				if ($cnt>$this->ModuleCategory->MessageNum) $cnt=$this->ModuleCategory->MessageNum;
				$result = array();
				for($i = 0; $i < $cnt; $i++){
				  $result[] =$module_all[$i];
				}
				$module_all=$result;
			}
			if($this->ModuleCategoryID != -1) $title=$this->ModuleCategory->getTitle();
			else $title="";	

			$smartyData = array(
						"module_all" => $module_all,
						//"link_module_archive" => $this->LanguageHelper->GetPrintLink(new LinkModuleArchive($this->LanguageHelper, $this->ModuleCategoryID)),
						"module_category_all" => $module_category_all_smarty,
						"title" =>$title,
						"plugin" =>'module',
						"categoryid" =>$this->ModuleCategory->getModuleCategoryID()
						) ;
			
			$this->SmartyPluginBlock->setData($smartyData);
			$this->SmartyPluginBlock->setPosition($this->Position);
			$this->SmartyPluginBlock->setName("plg_module_default");
			
			return $this->SmartyPluginBlock->toArray();	
		}
		
		function IsModuleInModuleCategory($module)
		{
			if ($this->ModuleCategoryID==-1) return true;
			if($module->ModuleCategory != null)
			{
				foreach($module->ModuleCategory as $nwc)
				{
					if($nwc != null)
					{
						if($nwc->getModuleCategoryID() == $this->ModuleCategoryID) return true;
					}
				}
				return false;
			}
			return false;
		}
		
		function showDetails()
		{
			$this->SetPluginLanguage("module");
			$this->SetPluginLanguage("global");
			
			// Pogled za DETALJE VESTI
			if(isset($_REQUEST['module_id']) && $_REQUEST['plugin_view'] == "module_details")
			{
				$module = $this->ObjectFactory->createObject("Module",$_REQUEST['module_id'],array("SfStatus", "ModuleCategory"));
				
				$html = $module->getHtmlUnchanged();
				$html = htmldecode($html);
				
				$this->GenerateThumbs->PrepareThumbs($html);
				
				if(IS_URLREWRITE_ON)
					$html = str_replace('src="files/Image','<img src="'.ROOT_WEB."files/Image", $html);
				
				$module->setHtml($html);
				$module_array = $module->toArray();
				
				// vezani resursi
				$view = new ConnectedObject($this->ObjectFactory,$this->DatabaseBroker, $this->SetLabels());		
				
				$images_x=explode('#',$view->ViewConnectedObject('Module', 'img', $module->getModuleID()));
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

				$module_array = array_merge($module_array, array(	
					"img_rows" => $view->ViewConnectedObject('Module', 'img', $module->getModuleID()),
					"vid_rows" => $view->ViewConnectedObject('Module', 'vid', $module->getModuleID()),
					"web_rows" => $view->ViewConnectedObject('Module', 'web', $module->getModuleID()),			
					"doc_rows" => $view->ViewConnectedObject('Module', 'doc', $module->getModuleID())));
				$links_print_fb = $this->LanguageHelper->GetPrintLink ( new LinkResourceDetails($this->LanguageHelper, 'module', $module->getModuleID(),'fb',$module->getHeaderUnchanged()));
				$links_print_in = $this->LanguageHelper->GetPrintLink ( new LinkResourceDetails($this->LanguageHelper, 'module', $module->getModuleID(),'in',$module->getHeaderUnchanged()));	
				$module_array = array_merge($module_array, array(
																	"link_print_in" => $links_print_in,
																	"link_print_fb" => $links_print_fb));
				$conres_all=$this->showConResource('Module',10);
				$this->smarty->assign("plg_module_details","true");
				$this->smarty->assign("module_detail",$module_array);
				$this->smarty->assign("conmodule",$conres_all);				
				$this->smarty->assign("MASTER_TITLE",$this->getTranslation("PLG_MODULE_DETAILS_TITLE"));
						
			}

		}
}
?>