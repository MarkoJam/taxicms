<?
	include_once("plugins/pagePlugin.php");
	
	class galleryPlugin extends pagePlugin 
	{
		// id kategorije vesti
		private $GalleryCategoryID = -1;
		// kategorija vesti
		private $GalleryCategory;
		// niz svih objekata vesti
		private $Gallery;
		
		function __construct()
		{
			parent::__construct();
			
			$this->ObjectFactory->ResetFilters();
		}
		
		function setFilterID($filterid)
		{
			if (isset($filterid)) $this->GalleryCategoryID = $filterid;		
			else $this->GalleryCategoryID=-1;	
		}
		
		function showDefault()
		{		

			$this->SetPluginLanguage("gallery");
			
			$gallery_all = array();
			$gallery_array = array();
			
			if($this->GalleryCategoryID != -1) 
			{
				$this->ObjectFactory->ResetFilters();
				$this->GalleryCategory = $this->ObjectFactory->createObject("GalleryCategory",$this->GalleryCategoryID);
				$this->ObjectFactory->ResetFilters();
			}
			
			// based on filter in plugin try to prepare filter
			$this->ObjectFactory->Reset();
			$this->Gallery = $this->ObjectFactory->createObjects("Gallery", array("SfStatus","GalleryCategory"));
			$this->ObjectFactory->ResetFilters();

			$this->ObjectFactory->ResetFilters();
			$gallery_category_all = $this->ObjectFactory->createObjects("GalleryCategory");
			$this->ObjectFactory->ResetFilters();
			
			$gallery_category_all_smarty = array();
			foreach($gallery_category_all as $gallery_category)
			{
				$gallery_category_all_smarty[] = $gallery_category->toArray();
			}
			
			$cnt = 0;
			if(!empty($this->Gallery))

			foreach ($this->Gallery as $gallery)
			{
				// provrevamo da li se vest nalazi u kategoriji vesti plugina
				if($this->IsGalleryInGalleryCategory($gallery) && $gallery->SfStatus->StatusID == STATUS_GALLERY_AKTIVAN)
				{
					$nid=$gallery->getGalleryID();
					$this->ObjectFactory->Reset();
					$this->ObjectFactory->AddFilter("gallery_id = " . $nid. " AND gallery_category_id = " .$this->GalleryCategoryID);
					$nc = $this->ObjectFactory->createObjects("GalleryGalleryCategory");
					$this->ObjectFactory->Reset();
					foreach($nc as $sel_gallery)
					{
						$gallery->Order=$sel_gallery->getGalleryGalleryCategoryOrder();
					}					
					$html = $gallery->getHtmlUnchanged();
					$html = htmldecode($html);
					$this->GenerateThumbs->PrepareThumbs($html);

					if(IS_URLREWRITE_ON)
						$html = str_replace('src="files/Image','<img src="'.ROOT_WEB."files/Image", $html);
					
					$gallery->setHtml($html);
					$gallery_array = $gallery->toArray();
	
					$links_print_dt = $this->LanguageHelper->GetPrintLink ( new LinkResourceDetails($this->LanguageHelper, 'gallery', $gallery->getGalleryID(),'w',$gallery->getHeaderUnchanged()));
					$links_print_fb = $this->LanguageHelper->GetPrintLink ( new LinkResourceDetails($this->LanguageHelper, 'gallery', $gallery->getGalleryID(),'fb',$gallery->getHeaderUnchanged()));
					$links_print_in = $this->LanguageHelper->GetPrintLink ( new LinkResourceDetails($this->LanguageHelper, 'gallery', $gallery->getGalleryID(),'in',$gallery->getHeaderUnchanged()));
					
					$gallery_array = array_merge($gallery_array, array("order" => $gallery->Order));										
					$gallery_array = array_merge($gallery_array, array("link_print_dt" => $links_print_dt));
					$gallery_array = array_merge($gallery_array, array("link_print_fb" => $links_print_fb));
					$gallery_array = array_merge($gallery_array, array("link_print_in" => $links_print_in));
										
					$gallery_all[] = $gallery_array;
					$cnt++;
				}
			}
			usort($gallery_all,function($first,$second){
					return $first['order'] > $second['order'];
			});
			if($this->GalleryCategoryID != -1) {
				if ($cnt>$this->GalleryCategory->MessageNum) $cnt=$this->GalleryCategory->MessageNum;
				$result = array();
				for($i = 0; $i < $cnt; $i++){
				  $result[] =$gallery_all[$i];
				}
				$gallery_all=$result;
			}
			$smartyData = array(
						"gallery_all" => $gallery_all,
						"gallery_category_all" => $gallery_category_all_smarty,
						) ;
			
			$this->SmartyPluginBlock->setData($smartyData);
			$this->SmartyPluginBlock->setPosition($this->Position);
			$this->SmartyPluginBlock->setName("plg_gallery_default");
			
			return $this->SmartyPluginBlock->toArray();	
		}
		
		function IsGalleryInGalleryCategory($gallery)
		{
			if ($this->GalleryCategoryID==-1) return true;
			if($gallery->GalleryCategory != null)
			{
				foreach($gallery->GalleryCategory as $nwc)
				{
					if($nwc != null)
					{
						if($nwc->getGalleryCategoryID() == $this->GalleryCategoryID) return true;
					}
				}
				return false;
			}
			return true;
		}
		
		function showDetails()
		{
			$this->SetPluginLanguage("gallery");
			$this->SetPluginLanguage("global");
			
			
			// Pogled za DETALJE VESTI
			if(isset($_REQUEST['gallery_id']) && $_REQUEST['plugin_view'] == "gallery_details")
			{
				$gallery = $this->ObjectFactory->createObject("Gallery",$_REQUEST['gallery_id'],array("SfStatus", "GalleryCategory"));
				
				$html = $gallery->getHtmlUnchanged();
				$html = htmldecode($html);
				
				$this->GenerateThumbs->PrepareThumbs($html);
				
				if(IS_URLREWRITE_ON)
					$html = str_replace('src="files/Image','<img src="'.ROOT_WEB."files/Image", $html);
				
				$gallery->setHtml($html);
				$gallery_array = $gallery->toArray();
				// vezani resursi
				$view = new ConnectedObject($this->ObjectFactory,$this->DatabaseBroker, $this->SetLabels());	

				$images_x=explode('#',$view->ViewConnectedObject('Gallery', 'img', $gallery->getGalleryID()));
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
				
				$gallery_array = array_merge($gallery_array, array(	
					"img_rows" => $view->ViewConnectedObject('Gallery', 'img', $gallery->getGalleryID())));
				$links_print_fb = $this->LanguageHelper->GetPrintLink ( new LinkResourceDetails($this->LanguageHelper, 'gallery', $gallery->getGalleryID(),'fb',$gallery->getHeaderUnchanged()));
				$links_print_in = $this->LanguageHelper->GetPrintLink ( new LinkResourceDetails($this->LanguageHelper, 'gallery', $gallery->getGalleryID(),'in',$gallery->getHeaderUnchanged()));	
				$gallery_array = array_merge($gallery_array, array(
																	"link_print_in" => $links_print_in,
																	"link_print_fb" => $links_print_fb));
																			
				$this->smarty->assign("plg_gallery_details","true");
				$this->smarty->assign("gallery_detail",$gallery_array);
				$this->smarty->assign("MASTER_TITLE",$this->getTranslation("PLG_GALLERY_DETAILS_TITLE"));
			}
		}
	}
?>