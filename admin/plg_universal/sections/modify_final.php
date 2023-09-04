<? 
	/* CMS Studio 3.0 modify_final.php */
	$_ADMINPAGES = true;
	
	include_once("../../../config.php");
		
	global $smarty;
	global $auth;
		
	if($auth->isActionAllowed("ACTION_SECTIONS_MODIFY"))
	{
		//insertovanje praznog sloga
		if ($_REQUEST['mode']=='insert') 
		{
			require ("insert_pre.php");
			$obj = $ObjectFactory->createObject("Sections");
			$colid=$DBBR->vratiPoslednjiID($obj);
			$col=$colid[0];
			$id=$colid[1];
			$_REQUEST[$col]=$_POST[$col]=$id;
		}
		if(isset($_REQUEST["sections_id"]))
		{
			$nw = $ObjectFactory->createObject("Sections", $_REQUEST["sections_id"]);
			$nw->Sections_POST($_REQUEST);
			

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

			// deo koji puni i odrzava kategorije vesti
			
			if(isset($_REQUEST["sectionscategories"]))
			{				
				if(count($_REQUEST["sectionscategories"]) > 0)
				{
					$ord=array();
					foreach ($_REQUEST["sectionscategories"] as $nwCategoryId) {
						$ObjectFactory->ResetFilters();
						$ObjectFactory->AddFilter("sections_category_id = " .$nwCategoryId. " AND sections_id = ".$_REQUEST["sections_id"] );
						$categ = $ObjectFactory->createObjects("SectionsSectionsCategory");
						$ObjectFactory->ResetFilters();
						if (count($categ)>0) $ord[$nwCategoryId]=$categ[0]->getSectionsSectionsCategoryOrder();	
					}		
					
					//iz vezne tabele brisemo sva pojavljivanja kategorija za datu vest
					$sectionsSectionsCateg = $ObjectFactory->createObject("SectionsSectionsCategory",-1);
					$sectionsSectionsCateg->setSectionsID($nw->getSectionsID());
					$DBBR->obrisiSlogove($sectionsSectionsCateg);
						
					foreach ($_REQUEST["sectionscategories"] as $nwCategoryId) {
						$sectionsSectionsCateg->setSectionsID($nw->getSectionsID());
						$sectionsSectionsCateg->setSectionsCategoryID($nwCategoryId);
						if (isset($ord[$nwCategoryId])) $sectionsSectionsCateg->setSectionsSectionsCategoryOrder($ord[$nwCategoryId]);																		
						$DBBR->kreirajSlog($sectionsSectionsCateg);
						// povecanje order-a za 1
						$ObjectFactory->ResetFilters();
						$ObjectFactory->AddFilter("sections_category_id = " .$nwCategoryId);
						$categ = $ObjectFactory->createObjects("SectionsSectionsCategory");
						$ObjectFactory->ResetFilters();
						foreach ($categ as $cat) {
							$cat->setSectionsSectionsCategoryOrder($cat->getSectionsSectionsCategoryOrder()+1);
							$DBBR->promeniSlog($cat);		
						}							
					}
				}
			}
			else
			{
				//iz vezne tabele brisemo sva pojavljivanja kategorija za datu vest
				$sectionsSectionsCateg = $ObjectFactory->createObject("SectionsSectionsCategory",-1);
				$sectionsSectionsCateg->setSectionsCategoryID($nw->getSectionsID());
				$DBBR->obrisiSlogove($sectionsSectionsCateg);
			}
			
			//$DBBR->SetDebugOn();
			$DBBR->promeniSlog($nw);
			
			$insert = new ConnectedObject($ObjectFactory,$DBBR);
			$insert->InsertConnectedObject('Sections', 'img', $_REQUEST["sections_id"]);
			
			echo "<div class='success'>".getTranslation("PLG_CHANGE_SUCCESS")."</div>";
		}
		else echo "<div class='error'>".getTranslation("PLG_CHANGE_FAILED")."</div>";
	}
	else echo "<div class='warning'>".getTranslation("PLG_NORIGHT")."</div>";
	
?>