<?
	/* CMS Studio 3.0 modify_final.php */
	$_ADMINPAGES = true;
	
	include_once("../../../config.php");
		
	global $smarty;
	global $auth;
		
	if($auth->isActionAllowed("ACTION_NEWS_MODIFY"))
	{
		//insertovanje praznog sloga
		if ($_REQUEST['mode']=='insert') 
		{
			require ("insert_pre.php");
			$obj = $ObjectFactory->createObject("News");
			$colid=$DBBR->vratiPoslednjiID($obj);
			$col=$colid[0];
			$id=$colid[1];
			$_REQUEST[$col]=$_POST[$col]=$id;
		}
		if(isset($_REQUEST["news_id"]))
		{
			$nw = $ObjectFactory->createObject("News", $_REQUEST["news_id"]);
			$nw->News_POST($_REQUEST);
			

			$tmp_html_page = htmlspecialchars($_POST["rtel"] , ENT_QUOTES);
			$tmp_htmlsmall_page = htmlspecialchars($_POST["rtelsmall"] , ENT_QUOTES);
			$tmp_header = htmlspecialchars($_POST["header"] , ENT_QUOTES);    
			
			// correct letter Š š
			$tmp_html_page = str_replace("&amp;Scaron;","Š",$tmp_html_page);
			$tmp_html_page = str_replace("&amp;scaron;","š",$tmp_html_page);
			
			$tmp_htmlsmall_page = str_replace("&amp;Scaron;","Š",$tmp_htmlsmall_page);
			$tmp_htmlsmall_page = str_replace("&amp;scaron;","š",$tmp_htmlsmall_page);
			
			// snimanje promene unosa
			$nw->setShortHtml($tmp_htmlsmall_page);
			$nw->setHtml($tmp_html_page);
			$nw->setHeader($tmp_header);
			$nw->setModifiedBy($auth->getAdminFullName());

			$datum=explode('.',$_REQUEST['datum']);
			if (countObject($datum)==3) $nw->setDate(mktime (0,0,0,$datum[1],$datum[0],$datum[2]));
			$publishingdate=explode(' ',$_REQUEST['publishingdate']);
			$publishingdate1=$publishingdate[0];
			$publishingdate2=$publishingdate[1];
			$publishingdateD=explode('.',$publishingdate1);
			$publishingdateT=explode(':',$publishingdate2);
			$nw->setPublishingDate(mktime ($publishingdateT[0],$publishingdateT[1],0,$publishingdateD[1],$publishingdateD[0],$publishingdateD[2]));			

			// deo koji puni i odrzava kategorije vesti
			
			if(isset($_REQUEST["newscategories"]))
			{				
				if(count($_REQUEST["newscategories"]) > 0)
				{
					$ord=array();
					foreach ($_REQUEST["newscategories"] as $nwCategoryId) {
						$ObjectFactory->ResetFilters();
						$ObjectFactory->AddFilter("news_category_id = " .$nwCategoryId. " AND news_id = ".$_REQUEST["news_id"] );
						$categ = $ObjectFactory->createObjects("NewsNewsCategory");
						$ObjectFactory->ResetFilters();
						if (count($categ)>0) $ord[$nwCategoryId]=$categ[0]->getNewsNewsCategoryOrder();	
					}		
					
					//iz vezne tabele brisemo sva pojavljivanja kategorija za datu vest
					$newsNewsCateg = $ObjectFactory->createObject("NewsNewsCategory",-1);
					$newsNewsCateg->setNewsID($nw->getNewsID());
					$DBBR->obrisiSlogove($newsNewsCateg);
						
					foreach ($_REQUEST["newscategories"] as $nwCategoryId) {
						$newsNewsCateg->setNewsID($nw->getNewsID());
						$newsNewsCateg->setNewsCategoryID($nwCategoryId);
						if (isset($ord[$nwCategoryId])) $newsNewsCateg->setNewsNewsCategoryOrder($ord[$nwCategoryId]);																		
						$DBBR->kreirajSlog($newsNewsCateg);
						// povecanje order-a za 1
						$ObjectFactory->ResetFilters();
						$ObjectFactory->AddFilter("news_category_id = " .$nwCategoryId);
						$categ = $ObjectFactory->createObjects("NewsNewsCategory");
						$ObjectFactory->ResetFilters();
						foreach ($categ as $cat) {
							$cat->setNewsNewsCategoryOrder($cat->getNewsNewsCategoryOrder()+1);
							$DBBR->promeniSlog($cat);		
						}							
					}
				}
			}
			else
			{
				//iz vezne tabele brisemo sva pojavljivanja kategorija za datu vest
				$newsNewsCateg = $ObjectFactory->createObject("NewsNewsCategory",-1);
				$newsNewsCateg->setNewsCategoryID($nw->getNewsID());
				$DBBR->obrisiSlogove($newsNewsCateg);
			}
			
			//$DBBR->SetDebugOn();
			$DBBR->promeniSlog($nw);
			
			$insert = new ConnectedObject($ObjectFactory,$DBBR);
			$insert->InsertConnectedObject('News', 'img', $_REQUEST["news_id"]);
			
			echo "<div class='success'>".getTranslation("PLG_CHANGE_SUCCESS")."</div>";
		}
		else echo "<div class='error'>".getTranslation("PLG_CHANGE_FAILED")."</div>";
	}
	else echo "<div class='warning'>".getTranslation("PLG_NORIGHT")."</div>";
	
?>