<? 
	/* CMS Studio 3.0 modify.php */
	$_ADMINPAGES = true;
	
	include_once("../../../config.php");
		
	global $smarty;
	global $auth;
	    	
	if($auth->isActionAllowed("ACTION_MODULE_MODIFY"))
	{
		if(($_REQUEST["mode"])=='insert') $_REQUEST["module_id"]=-1;
		if ($_REQUEST['mode']=='insert2') 
		{
			$obj = $ObjectFactory->createObject("Module");
			$colid=$DBBR->vratiPoslednjiID($obj);
			$col=$colid[0];
			$id=$colid[1];
			$_REQUEST[$col]=$_POST[$col]=$id;
		}
		if(isset($_REQUEST["module_id"]))
		{
			$upit ="SELECT * FROM audio WHERE class='module' AND `id` = ".$_REQUEST["module_id"] ;
			$result_row = $DBBR->con->get_results($upit);
			foreach ($result_row as $file)
			{
				if ($file->field == 'title')  $title =  "../audio_content/".$file->filename;
				if ($file->field == 'audio_content') $content = "../audio_content/".$file->filename;				
			}
			$smarty->assign("audio_title", $title);			
			$smarty->assign("audio_content", $content);						

			$module_id = $_REQUEST["module_id"];
			
			$nw = $ObjectFactory->createObject("Module",$module_id, array("ModuleCategory"));
			if (isset($_REQUEST['header'])) $nw->Module_POST($_POST);
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
			$ObjectFactory->AddFilter(" tip_status_id = " . STATUS_TIP_MODULE);
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
			
			$moduletypes = array();
			
			$nws_values = array(-1);
			$nws_output  = array(getTranslation("PLG_NONE"));
			$nws_selected = array($nw->getModuleType()->getModuleTypeID());
			
			$moduletypes= $ObjectFactory->createObjects("ModuleType");
			
			foreach($moduletypes as $nws)
			{
				array_push($nws_output, $nws->getTitle());
				array_push($nws_values, $nws->getModuleTypeID());
			}
			
			$smarty->assign("nws_values", $nws_values);
			$smarty->assign("nws_output", $nws_output);
			$smarty->assign("nws_selected", $nws_selected);
			
			// priprema kategorija vesti
			
			$moduleCategories = $ObjectFactory->createObjects("ModuleCategory");
				
			// select box za Kategoriju
			$shkateg = new SmartyHtmlSelection("modulecategory",$smarty);
			foreach($moduleCategories as $nwc)
			{
				$shkateg->AddValue($nwc->getModuleCategoryID());
				$shkateg->AddOutput($nwc->getTitle());
			}
			if (isset($_REQUEST['cnc']) && $_REQUEST['cnc']==1) {
				$modulecategories = explode(',',$_POST["modulecategories"]);
				foreach($modulecategories as $kateg)
				{								
					$shkateg->AddSelected($kateg);
				}
			}		
			else {
				if(count($nw->ModuleCategory) > 0)
				{
					foreach($nw->ModuleCategory as $pk)
					{
						$shkateg->AddSelected($pk->getModuleCategoryID());
					}
				}
			}
			$shkateg->SmartyAssign();
			
			// priprema datumskih promenljivih...			
			if (!isset($_REQUEST['datum'])) {
				$datum=date("d.m.Y", $nw->getDate());
				$smarty->assign("datum", $datum);
			}
			else $smarty->assign("datum", $_REQUEST['datum']);
			
			if (!isset($_REQUEST['publishingdate'])) {
				$publishingdatum=date("d.m.Y H:i", $nw->getPublishingDate());
				$smarty->assign("publishingdatum", $publishingdatum);
			}
			else $smarty->assign("publishingdatum", $_REQUEST['publishingdate']);		
				
			
			// vezane vesti
			// priprema potencijalnih vezanih vesti
			
			$ObjectFactory->ResetFilters();
			$ObjectFactory->AddFilter("status = 1"  );			
			$resources= $ObjectFactory->createObjects("SfResource");
			$ObjectFactory->ResetFilters();

			// select box za Module
			$shres = new SmartyHtmlSelection("conres",$smarty);
			$shres->AddValue(-1);
			$shres->AddOutput(getTranslation("PLG_CHOOSE"));	

			foreach($resources as $res) {
				$stcode=strtoupper($res->getCode());
				$classidcode=$res->getClass();
				$titlecode='Header';
				if ($stcode=='PROIZVOD') {
					$stcode='PROIZVODA';
					$classidcode='Proizvod';
					$titlecode='Naziv';
				}	
				eval ("\$stcode=STATUS_".$stcode."_AKTIVAN;");
				$ObjectFactory->ResetFilters();
				$ObjectFactory->AddFilter("status_id = " . $stcode);			
				$conres = $ObjectFactory->createObjects($res->getClass());
				$ObjectFactory->ResetFilters();

				foreach($conres as $rs)
				{
					eval ("\$shres->AddValue(\$res->getID().'.'.\$rs->get".$classidcode."ID());");
					eval ("\$shres->AddOutput(\$res->getVrednost().' / '.\$rs->get".$titlecode."());");
				}			
			}
			$shres->SmartyAssign();

			$ObjectFactory->ResetFilters();
			$ObjectFactory->AddFilter("class = 'Module'"  );			
			$resources = $ObjectFactory->createObjects("SfResource");
			$ObjectFactory->ResetFilters();
			$rid=$resources[0]->getID();
			$rid=$rid.".".$module_id;
			
			$ObjectFactory->ResetFilters();
			$ObjectFactory->AddFilter(" res_id = " . $rid );			
			$resres= $ObjectFactory->createObjects("ResRes");
			$ObjectFactory->ResetFilters();

			$ap = new AdminTable();
			$ap->SetHeader(
						array(
							getTranslation("PLG_NAME"),
							getTranslation("PLG_DELETE")
				)
			);			
			
			$ap->SetOffsetName("offset_templtplgid");
			$ap->SetCountAllRows(countObject($resres));	
			$ap->SetRowCount(countObject($resres));

			$html_img_delete = "<div class='btn btn-white'><i class='fa fa-trash'></i></div>";
			
			foreach($resres as $res)
			{
				$rids=explode('.',$res->getConResID());
				$ress=$ObjectFactory->createObject("SfResource",$rids[0]);
				
				$res_main=$ObjectFactory->createObject($ress->getClass(),$rids[1]);
				if ($ress->getClass()=='PrProizvod') $titlecode=$res_main->getNaziv();	
				else $titlecode=$res_main->getHeader();
				$modify_plugin = $ress->getVrednost()." / ".$titlecode;
				
				$delete_plugin = "<a id='delete_res' data-param='res_id=".$rid."&conres_id=".$res->getConResID()."'>".$html_img_delete."</a>";

				$ap->AddTableRow(
					array(	$modify_plugin , 
							$delete_plugin));
			}
			if(countObject($resres) != 0) $ap->RegisterAdminPage($smarty);
			else $smarty->assign("tbl_content", array(getTranslation("PLG_NONE")));
						
			$modify = new ConnectedObject($ObjectFactory,$DBBR);
			$smarty->assign("img_rows",$modify->ModifyConnectedObject('Module', 'img', $_REQUEST["module_id"]));
			$smarty->assign("vid_rows",$modify->ModifyConnectedObject('Module', 'vid', $_REQUEST["module_id"]));
			$smarty->assign("web_rows",$modify->ModifyConnectedObject('Module', 'web', $_REQUEST["module_id"]));		
			$smarty->assign("doc_rows",$modify->ModifyConnectedObject('Module', 'doc', $_REQUEST["module_id"]));

			
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