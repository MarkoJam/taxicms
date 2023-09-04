<?
	include_once("plugins/pagePlugin.php");
	
	class newsPlugin extends pagePlugin 
	{
		// id kategorije vesti
		private $NewsCategoryID = -1;
		// kategorija vesti
		private $NewsCategory;
		// niz svih objekata vesti
		private $News;
		
		function __construct()
		{
			parent::__construct();
			
			$this->ObjectFactory->ResetFilters();
		}
		
		function setFilterID($filterid)
		{
			if (isset($filterid)) $this->NewsCategoryID = $filterid;		
			else $this->NewsCategoryID=-1;	
		}
		
		function showDefault()
		{		

			$this->SetPluginLanguage("news");
			
			$news_all = array();
			$news_array = array();
			
			if($this->NewsCategoryID != -1) 
			{
				$this->ObjectFactory->ResetFilters();
				$this->NewsCategory = $this->ObjectFactory->createObject("NewsCategory",$this->NewsCategoryID);
				$this->ObjectFactory->ResetFilters();
			}
			
			// based on filter in plugin try to prepare filter
			$this->ObjectFactory->Reset();
			if(isset($this->NewsCategoryID) && $this->NewsCategoryID != -1)
			{	
				$kategorija = $this->ObjectFactory->createObject("NewsCategory",$this->NewsCategoryID, array("News")," * ");
				foreach ($kategorija->News as $nw)
				{
					$news_ids .= $nw->getNewsID(). ",";
				}
				$news_ids = substr($news_ids,0,strlen($news_ids)-1);
				$this->ObjectFactory->AddFilter("news_id IN (".$news_ids.") ");
			}	
			$this->ObjectFactory->AddFilter("status_id =" . STATUS_NEWS_AKTIVAN);
			$this->News = $this->ObjectFactory->createObjects("News",array('NewsCategory'));
			$this->ObjectFactory->ResetFilters();

			$this->ObjectFactory->ResetFilters();
			$news_category_all = $this->ObjectFactory->createObjects("NewsCategory");
			$this->ObjectFactory->ResetFilters();
			$news_category_all_smarty = array();
			foreach($news_category_all as $news_category)
			{
				$news_cat=$news_category->toArray();

				$cid= $news_category->getNewsCategoryID();
				$this->ObjectFactory->ResetFilters();
				$this->ObjectFactory->AddFilter("news_category_id =" . $cid);
				$cnews = $this->ObjectFactory->createObjects("NewsNewsCategory");
				$this->ObjectFactory->ResetFilters();				
				if (count ($cnews)>0) {
					$newsc_array=array();
					foreach($cnews as $cn) {
						$nid=$cn->getNewsID();
						$newsfc = $this->ObjectFactory->createObject("News",$nid);
						$x_array['newsid']=$nid;
						$x_array['header']=$newsfc->getHeader();
						//link
						$x_array['link'] = $this->LanguageHelper->GetPrintLink ( new LinkResourceDetails($this->LanguageHelper, 'news', $nid,'w',$newsfc->getHeaderUnchanged()));
						$newsc_array[]=$x_array;
					}
					$news_cat = array_merge($news_cat, array("news" => $newsc_array));										
				}
				$news_category_all_smarty[] = $news_cat;	
			}
			$cnt = 0;
			if(!empty($this->News))

			foreach ($this->News as $news)
			{
				$nid=$news->getNewsID();
				$this->ObjectFactory->Reset();
				$this->ObjectFactory->AddFilter("news_id = " . $nid. " AND news_category_id = " .$this->NewsCategoryID);
				$nc = $this->ObjectFactory->createObjects("NewsNewsCategory");
				$this->ObjectFactory->Reset();
				foreach($nc as $sel_news)
				{
					$news->Order=$sel_news->getNewsNewsCategoryOrder();
				}					
				$html = $news->getShortHtmlUnchanged();
				$html = htmldecode($html);
				$this->GenerateThumbs->PrepareThumbs($html);

				if(IS_URLREWRITE_ON)
					$html = str_replace('src="files/Image','<img src="'.ROOT_WEB."files/Image", $html);
				
				$news->setShortHtml($html);
				$news_array = $news->toArray();
				

				if(strlen($news->getHtml()) == 0) {
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
					$news_array = array_merge($news_array, array("html_clean" => $html_clean));
			
					$links_print_dt = $this->LanguageHelper->GetPrintLink ( new LinkResourceDetails($this->LanguageHelper, 'news', $news->getNewsID(),'w',$news->getHeaderUnchanged()));
					$links_print_fb = $this->LanguageHelper->GetPrintLink ( new LinkResourceDetails($this->LanguageHelper, 'news', $news->getNewsID(),'fb',$news->getHeaderUnchanged()));
					$links_print_in = $this->LanguageHelper->GetPrintLink ( new LinkResourceDetails($this->LanguageHelper, 'news', $news->getNewsID(),'in',$news->getHeaderUnchanged()));
				}
				$news_array = array_merge($news_array, array("order" => $news->Order));										
				$news_array = array_merge($news_array, array("link_print_dt" => $links_print_dt));
				$news_array = array_merge($news_array, array("link_print_fb" => $links_print_fb));
				$news_array = array_merge($news_array, array("link_print_in" => $links_print_in));
									
				$news_all[] = $news_array;
				
				$cnt++;

			//if($this->NewsCategoryID != -1 && $cnt >= $this->NewsCategory->MessageNum) break;
			}
			usort($news_all,function($first,$second){
					return $first['order'] > $second['order'];
			});
			if($this->NewsCategoryID != -1) {
				if ($cnt>$this->NewsCategory->MessageNum) $cnt=$this->NewsCategory->MessageNum;
				$result = array();
				for($i = 0; $i < $cnt; $i++){
				  $result[] =$news_all[$i];
				}
				$news_all=$result;
			}
			if($this->NewsCategoryID != -1) $title=$this->NewsCategory->getTitle();
			else $title="";	

			$smartyData = array(
						"news_all" => $news_all,
						//"link_news_archive" => $this->LanguageHelper->GetPrintLink(new LinkNewsArchive($this->LanguageHelper, $this->NewsCategoryID)),
						"news_category_all" => $news_category_all_smarty,
						"title" =>$title,
						"plugin" =>'news',
						"categoryid" =>$this->NewsCategory->getNewsCategoryID()
						) ;
			
			$this->SmartyPluginBlock->setData($smartyData);
			$this->SmartyPluginBlock->setPosition($this->Position);
			$this->SmartyPluginBlock->setName("plg_news_default");
			
			return $this->SmartyPluginBlock->toArray();	
		}
		
		function IsNewsInNewsCategory($news)
		{
			if ($this->NewsCategoryID==-1) return true;
			if($news->NewsCategory != null)
			{
				foreach($news->NewsCategory as $nwc)
				{
					if($nwc != null)
					{
						if($nwc->getNewsCategoryID() == $this->NewsCategoryID) return true;
					}
				}
				return false;
			}
			return false;
		}
		
		function showDetails()
		{
			$this->SetPluginLanguage("news");
			$this->SetPluginLanguage("global");
			
			// Pogled za DETALJE VESTI
			if(isset($_REQUEST['news_id']) && $_REQUEST['plugin_view'] == "news_details")
			{
				$news = $this->ObjectFactory->createObject("News",$_REQUEST['news_id'],array("SfStatus", "NewsCategory"));
				
				$html = $news->getHtmlUnchanged();
				$html = htmldecode($html);
				
				$this->GenerateThumbs->PrepareThumbs($html);
				
				if(IS_URLREWRITE_ON)
					$html = str_replace('src="files/Image','<img src="'.ROOT_WEB."files/Image", $html);
				
				$news->setHtml($html);
				$news_array = $news->toArray();
				
				// vezani resursi
				$view = new ConnectedObject($this->ObjectFactory,$this->DatabaseBroker, $this->SetLabels());		
				
				$images_x=explode('#',$view->ViewConnectedObject('News', 'img', $news->getNewsID()));
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

				$news_array = array_merge($news_array, array(	
					"img_rows" => $view->ViewConnectedObject('News', 'img', $news->getNewsID()),
					"vid_rows" => $view->ViewConnectedObject('News', 'vid', $news->getNewsID()),
					"web_rows" => $view->ViewConnectedObject('News', 'web', $news->getNewsID()),			
					"doc_rows" => $view->ViewConnectedObject('News', 'doc', $news->getNewsID())));
				$links_print_fb = $this->LanguageHelper->GetPrintLink ( new LinkResourceDetails($this->LanguageHelper, 'news', $news->getNewsID(),'fb',$news->getHeaderUnchanged()));
				$links_print_in = $this->LanguageHelper->GetPrintLink ( new LinkResourceDetails($this->LanguageHelper, 'news', $news->getNewsID(),'in',$news->getHeaderUnchanged()));	
				$news_array = array_merge($news_array, array(
																	"link_print_in" => $links_print_in,
																	"link_print_fb" => $links_print_fb));
					
				$this->ObjectFactory->ResetFilters();
				$this->ObjectFactory->AddFilter("class = 'News'"  );			
				$resources = $this->ObjectFactory->createObjects("SfResource");
				$this->ObjectFactory->ResetFilters();
				$rid=$resources[0]->getID();
				$rid=$rid.".".$_REQUEST['news_id'];
				
				$this->ObjectFactory->ResetFilters();
				$this->ObjectFactory->AddFilter(" res_id = " . $rid );			
				$resres= $this->ObjectFactory->createObjects("ResRes");
				$this->ObjectFactory->ResetFilters();
				$i=1;				
				foreach ($resres as $nn)													
				{
					$id_arr=explode('.',$nn->getConResID());			
					$connews = $this->ObjectFactory->createObject("News",$id_arr[1]);
					$connews_array = $connews->toArray();
					$links_print_dt = $this->LanguageHelper->GetPrintLink ( new LinkResourceDetails($this->LanguageHelper, 'news', $connews->getNewsID(),'w',$connews->getHeaderUnchanged()));			
					$connews_array = array_merge($connews_array, array("link_print_dt" => $links_print_dt));
					$connews_all[] = $connews_array;
				}
					
				/*$this->ObjectFactory->ResetFilters();
				$this->ObjectFactory->AddFilter("news_id = " . $_REQUEST['news_id'] );			
				$newsnews= $this->ObjectFactory->createObjects("NewsNews");
				$this->ObjectFactory->ResetFilters();													
				foreach ($newsnews as $nn)													
				{
					$connews = $this->ObjectFactory->createObject("News",$nn->getConNewsID());
					$connews_array = $connews->toArray();
					if(strlen($connews->getHtml()) == 0) $links_print_dt = "#";
					else $links_print_dt = $this->LanguageHelper->GetPrintLink ( new LinkResourceDetails($this->LanguageHelper, 'news', $connews->getNewsID(),'w',$connews->getHeaderUnchanged()));			
					$connews_array = array_merge($connews_array, array("link_print_dt" => $links_print_dt));
					$connews_all[] = $connews_array;
				}*/
							
				$this->smarty->assign("plg_news_details","true");
				$this->smarty->assign("news_detail",$news_array);
				$this->smarty->assign("connews",$connews_all);				
				$this->smarty->assign("MASTER_TITLE",$this->getTranslation("PLG_NEWS_DETAILS_TITLE"));
						
			}
			else
			{
				// Pogled za ARHIVU VESTI
				if((isset($_REQUEST['plugin_view'])) && $_REQUEST['plugin_view'] == "news_archive")
				{                  
                    if(isset($_REQUEST["newscategoryid"])) 
                    {
                        $this->NewsCategoryID = $_REQUEST["newscategoryid"];
                        
                        $this->ObjectFactory->ResetFilters();
                        $this->NewsCategory = $this->ObjectFactory->createObject("NewsCategory",$this->NewsCategoryID, array("News"));
                        $this->ObjectFactory->ResetFilters();
                    }
                    
                    
					// priprema za paginaciju			
					//SmartyPaginate::disconnect();
					SmartyPaginate::connect();
		
					SmartyPaginate::setTranslation
					(
						$this->getTranslation("GLOBAL_PREV_TEXT"),
						$this->getTranslation("GLOBAL_NEXT_TEXT"),
						$this->getTranslation("GLOBAL_FIRST_TEXT"),
						$this->getTranslation("GLOBAL_LAST_TEXT"),
						$this->getTranslation("GLOBAL_SHOW_TEXT"),
						$this->getTranslation("GLOBAL_TOTAL_TEXT")
					);
					
					//$this->ObjectFactory->SetDebugOn();
					
					SmartyPaginate::setLimit(10);
					SmartyPaginate::setUrl("");
					
                    /*
					// for limit and offset
					$this->ObjectFactory->AddLimit(10);
					$this->ObjectFactory->AddOffset(SmartyPaginate::getCurrentIndex());

					// based on filter in plugin try to prepare filter
					$this->News = $this->ObjectFactory->createObjects("News");
					$this->ObjectFactory->ResetFilters();
				
					$news = $this->ObjectFactory->createObjects("News", array("NewsCategory"));
					//$this->ObjectFactory->DBBR->debug = true;
					*/
                    $from = SmartyPaginate::getCurrentIndex();
                    $to = SmartyPaginate::getCurrentIndex() + 10;
					SmartyPaginate::setTotal(count($this->NewsCategory->News));
					$news_archive_all = array();
                    $cnt = 0;
					if(!empty($this->NewsCategory->News))
					foreach ($this->NewsCategory->News as $news)
					{
						if($news->SfStatus->StatusID == STATUS_NEWS_AKTIVAN)
						{
                            $cnt++;
                            if($cnt > $from && $cnt <= $to){
                                $news_array = $news->toArray();
                                
								if(strlen($news->getHtml()) == 0) $links_print = "#";
								else
								{		
									$LinkNewsDet = new LinkNewsDetails($this->LanguageHelper, $news->getNewsID(),$news->getHeaderUnchanged());
									$links_print = $this->LanguageHelper->GetPrintLink($LinkNewsDet);
								}
                                $news_array = array_merge($news_array, array("link_print" => $links_print));
                                $news_archive_all[] = $news_array;
                            }
						}
					}
					
					SmartyPaginate::assign($this->smarty);
					$this->smarty->assign("plg_news_details","true");
					$this->smarty->assign("news_archive_all", $news_archive_all);
					
					$this->smarty->assign("MASTER_TITLE",$this->getTranslation("PLG_NEWS_ARCHIVE_TITLE"));
					$this->smarty->assign("PATH",$this->getTranslation("PLG_NEWS_NAMEINPATH_LONG"));
				}
				else 
				{
					$this->smarty->assign("html",$this->getTranslation("PLG_NEWS_ERROR"));
				}
			}
		}
}
?>