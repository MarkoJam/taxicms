<? 
	/* CMS Studio 3.0 modify.php */
	$_ADMINPAGES = true;
	
	include_once("../../../config.php");
		
	global $smarty;
	global $auth;
	    	
	if($auth->isActionAllowed("ACTION_SECTIONS_MODIFY"))
	{
		if(($_REQUEST["mode"])=='insert') $_REQUEST["sections_id"]=-1;
		if ($_REQUEST['mode']=='insert2') 
		{
			$obj = $ObjectFactory->createObject("Sections");
			$colid=$DBBR->vratiPoslednjiID($obj);
			$col=$colid[0];
			$id=$colid[1];
			$_REQUEST[$col]=$_POST[$col]=$id;
		}
		if(isset($_REQUEST["sections_id"]))
		{
			$upit ="SELECT * FROM audio WHERE class='sections' AND `id` = ".$_REQUEST["sections_id"] ;
			$result_row = $DBBR->con->get_results($upit);
			foreach ($result_row as $file)
			{
				if ($file->field == 'title')  $title =  "../audio_content/".$file->filename;
				if ($file->field == 'audio_content') $content = "../audio_content/".$file->filename;				
			}
			$smarty->assign("audio_title", $title);			
			$smarty->assign("audio_content", $content);						

			$sections_id = $_REQUEST["sections_id"];
			
			$nw = $ObjectFactory->createObject("Sections",$sections_id, array("SectionsCategory"));
			if (isset($_REQUEST['header'])) $nw->Sections_POST($_POST);
			// deo za insertovanje novog sloga
			if(($_REQUEST["mode"])=='insert') $smarty->assign("mode", 'insert');
			else $smarty->assign("mode", 'edit');
			
			if(isset($_REQUEST["active"])) $smarty->assign("active", 3);			
			else $smarty->assign("active", 1);
			
			//ucitavanje vrednosti iz CKeditora
			if (isset($_REQUEST['cnc']) && $_REQUEST['cnc']==1) {
				$nw->setShortHtml($_REQUEST['rtelsmall']);
				$nw->setHtml($_REQUEST['rtel']);
			}
			$smarty->assign($nw->toArray());
			
			// statusi
			$ObjectFactory->AddFilter(" tip_status_id = " . STATUS_TIP_SECTIONS);
			$statusi = $ObjectFactory->createObjects("SfStatus");
			
			$shStatus = new SmartyHtmlSelection("status",$smarty);
			foreach ($statusi as $s) 
			{
				$shStatus->AddOutput($s->getVrednost());
				$shStatus->AddValue($s->getStatusID());
			}
			$shStatus->AddSelected($nw->SfStatus->getStatusID());
			$shStatus->SmartyAssign();
			$ObjectFactory->ResetFilters();
						
			// priprema kategorija vesti
			
			$sectionsCategories = $ObjectFactory->createObjects("SectionsCategory");
							
			// select box za Kategoriju
			$shkateg = new SmartyHtmlSelection("sectionscategory",$smarty);
			foreach($sectionsCategories as $nwc)
			{			
				$shkateg->AddValue($nwc->getSectionsCategoryID());
				$shkateg->AddOutput($nwc->getTitle());			
			}
			if (isset($_REQUEST['cnc']) && $_REQUEST['cnc']==1) {
				$sectionscategories = explode(',',$_POST["sectionscategories"]);
				foreach($sectionscategories as $kateg)
				{								
					$shkateg->AddSelected($kateg);
				}
			}		
			else {
				if(count($nw->SectionsCategory) > 0)
				{
					foreach($nw->SectionsCategory as $pk)
					{
						$shkateg->AddSelected($pk->getSectionsCategoryID());
					}
				}
			}
			$shkateg->SmartyAssign();
						
			$ObjectFactory->ResetFilters();
			$ObjectFactory->AddFilter("status_id = " . STATUS_SECTIONS_AKTIVAN);			
			$consections = $ObjectFactory->createObjects("Sections");
			$ObjectFactory->ResetFilters();
			
			$modify = new ConnectedObject($ObjectFactory,$DBBR);
			$smarty->assign("img_rows",$modify->ModifyConnectedObject('Sections', 'img', $_REQUEST["sections_id"]));
			
			$smarty->display('modify.tpl');
		}
	}
	else 
	{
		// show error message not enough rights
		$smarty->assign("norights_message",getTranslation("PLG_NORIGHT"));
		$smarty->display('../../../templates/norights.tpl');
	}

	
?>