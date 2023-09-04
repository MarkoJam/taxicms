<?
	/* CMS Studio 3.0 modify_final.php */
	$_ADMINPAGES = true;
	
	include_once("../../../config.php");
		
	global $smarty;
	global $auth;
		
	if($auth->isActionAllowed("ACTION_MODULE_MODIFY"))
	{
		//insertovanje praznog sloga
		if ($_REQUEST['mode']=='insert') 
		{
			require ("insert_pre.php");
			$obj = $ObjectFactory->createObject("Module");
			$colid=$DBBR->vratiPoslednjiID($obj);
			$col=$colid[0];
			$id=$colid[1];
			$_REQUEST[$col]=$_POST[$col]=$id;
		}
		if(isset($_REQUEST["module_id"]))
		{
			$nw = $ObjectFactory->createObject("Module", $_REQUEST["module_id"]);
			$nw->Module_POST($_REQUEST);
			

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
			
			if(isset($_REQUEST["modulecategories"]))
			{				
				if(count($_REQUEST["modulecategories"]) > 0)
				{
					$ord=array();
					foreach ($_REQUEST["modulecategories"] as $nwCategoryId) {
						$ObjectFactory->ResetFilters();
						$ObjectFactory->AddFilter("module_category_id = " .$nwCategoryId. " AND module_id = ".$_REQUEST["module_id"] );
						$categ = $ObjectFactory->createObjects("ModuleModuleCategory");
						$ObjectFactory->ResetFilters();
						if (count($categ)>0) $ord[$nwCategoryId]=$categ[0]->getModuleModuleCategoryOrder();	
					}		
					
					//iz vezne tabele brisemo sva pojavljivanja kategorija za datu vest
					$moduleModuleCateg = $ObjectFactory->createObject("ModuleModuleCategory",-1);
					$moduleModuleCateg->setModuleID($nw->getModuleID());
					$DBBR->obrisiSlogove($moduleModuleCateg);
						
					foreach ($_REQUEST["modulecategories"] as $nwCategoryId) {
						$moduleModuleCateg->setModuleID($nw->getModuleID());
						$moduleModuleCateg->setModuleCategoryID($nwCategoryId);
						if (isset($ord[$nwCategoryId])) $moduleModuleCateg->setModuleModuleCategoryOrder($ord[$nwCategoryId]);																		
						$DBBR->kreirajSlog($moduleModuleCateg);
						// povecanje order-a za 1
						$ObjectFactory->ResetFilters();
						$ObjectFactory->AddFilter("module_category_id = " .$nwCategoryId);
						$categ = $ObjectFactory->createObjects("ModuleModuleCategory");
						$ObjectFactory->ResetFilters();
						foreach ($categ as $cat) {
							$cat->setModuleModuleCategoryOrder($cat->getModuleModuleCategoryOrder()+1);
							$DBBR->promeniSlog($cat);		
						}							
					}
				}
			}
			else
			{
				//iz vezne tabele brisemo sva pojavljivanja kategorija za datu vest
				$moduleModuleCateg = $ObjectFactory->createObject("ModuleModuleCategory",-1);
				$moduleModuleCateg->setModuleCategoryID($nw->getModuleID());
				$DBBR->obrisiSlogove($moduleModuleCateg);
			}
			
			//$DBBR->SetDebugOn();
			$DBBR->promeniSlog($nw);
			
			$insert = new ConnectedObject($ObjectFactory,$DBBR);
			$insert->InsertConnectedObject('Module', 'img', $_REQUEST["module_id"]);
			
			echo "<div class='success'>".getTranslation("PLG_CHANGE_SUCCESS")."</div>";
		}
		else echo "<div class='error'>".getTranslation("PLG_CHANGE_FAILED")."</div>";
	}
	else echo "<div class='warning'>".getTranslation("PLG_NORIGHT")."</div>";
	
?>