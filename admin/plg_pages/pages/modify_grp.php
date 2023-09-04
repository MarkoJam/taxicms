<?
	/* CMS Studio 3.0 modify_grp.php */

	$_ADMINPAGES = true;
	include_once("../../../config.php");

	global $smarty;
	global $auth;
	global $LanguageArray;

	$ObjectFactory = ObjectFactory::getInstance();

	if($auth->isActionAllowed("ACTION_PAGE_MODIFY"))
	{
		if(isset($_REQUEST["reload"]))
		{
			$smarty->assign("reload","true");
			$smarty->assign("page_id_left",$_REQUEST["page_id"]);
		}

		if(isset($_REQUEST["parent_id"])) $_REQUEST["page_id"]=-1;
		if(isset($_REQUEST["page_id"]))
		{
			$upit ="SELECT * FROM audio WHERE class='page' AND `id` = ".$_REQUEST["page_id"] ;
			$result_row = $DBBR->con->get_results($upit);
			foreach ($result_row as $file)
			{
				if ($file->field == 'title')  $title =  "../audio_content/".$file->filename;
				if ($file->field == 'audio_content') $content = "../audio_content/".$file->filename;
			}
			$smarty->assign("audio_title", $title);
			$smarty->assign("audio_content", $content);


			//punjenje i/ili postavljanje kategorijeid iz/u sesije
			$_SESSION["page_id"] = $_REQUEST["page_id"];

			$pg = $ObjectFactory->createObject("Page", $_REQUEST["page_id"], array("SfPageType"));
			// deo za insertovanje novog sloga
			if(isset($_REQUEST["parent_id"]))
			{
				$pg->setParentID($_REQUEST["parent_id"]);
				$typeid = $_REQUEST["pagetypeid"];
				$smarty->assign("mode", 'insert');
			}
			else
			{
				$smarty->assign("mode", 'edit');
				$typeid = $pg->SfPageType->GetPageTypeID();
			}
			$page_id = $pg->getPageID();

			$shorthtml = html_entity_decode ($pg->getShortHtml());
			$html = html_entity_decode ($pg->getHtml());
			//$html = $pg->getHtmlUnchanged();
			$keywords = $pg->getKeywords();
			$description = $pg->getDescription();
			$navigationType = $pg->getNavigationType();
			//$createdby=$pg->getCreatedBy();
			//$createddate=$pg->getCreatedDate();
			//$smarty->assign("editor",$editor);

			$header = $pg->getHeader();
			$subHeader = $pg->getSubHeader();
			$parent_id = $pg->getParentID();
			$order = $pg->getOrder();

			// punjenje kombo boxa sa Template-ima
			$templates = $ObjectFactory->createObjects("Template");

			$tmpl_values = array();
			$tmpl_output  = array();
			$tmpl_selected = array();

			foreach($templates as $tm)
			{
				array_push($tmpl_values,$tm->getTemplateID());
				array_push($tmpl_output,$tm->getTitle());
			}

			array_push($tmpl_selected,$pg->getTemplate()->TemplateID);

			$smarty->assign("tmpl_values", $tmpl_values);
			$smarty->assign("tmpl_output", $tmpl_output);
			$smarty->assign("tmpl_selected", $tmpl_selected);

			// statusi
			// page type
			$ObjectFactory->AddFilter(" tip_status_id = " . STATUS_TIP_PAGE);
			$statusi = $ObjectFactory->createObjects("SfStatus");

			$shStatus = new SmartyHtmlSelection("status",$smarty);
			foreach ($statusi as $s)
			{
				$shStatus->AddOutput($s->getVrednost());
				$shStatus->AddValue($s->getStatusID());
			}
			$shStatus->AddSelected($pg->SfStatus->getStatusID());
			$shStatus->SmartyAssign();
			$ObjectFactory->ResetFilters();

			// page frequency
			$ObjectFactory->AddFilter(" tip_status_id = " . STATUS_TIP_FREQ);
			$frequencies = $ObjectFactory->createObjects("SfStatus");

			$shFreq = new SmartyHtmlSelection("freq",$smarty);
			foreach ($frequencies as $f)
			{
				$shFreq->AddOutput($f->getVrednost());
				$shFreq->AddValue($f->getStatusID());
			}
			$shFreq->AddSelected($pg->getFrequency());
			//$shFreq->AddSelected(164);
			$shFreq->SmartyAssign();
			$ObjectFactory->ResetFilters();

			// page priority
			$shPrior = new SmartyHtmlSelection("prior",$smarty);
			for ($x=1; $x<=10; $x++)
			{
				$shPrior->AddOutput($x/10);
				$shPrior->AddValue($x/10);
			}
			$shPrior->AddSelected(number_format($pg->getPriority(),1));
			//$shPrior->AddSelected(0.5);
			$shPrior->SmartyAssign();

			//protection
			$ObjectFactory->ResetFilters();
			$protection= $ObjectFactory->createObjects("SfPageProtection");

			$sfProtection = new SmartyHtmlSelection("pageprotection",$smarty);
			foreach ($protection as $prt)
			{
				$sfProtection->AddOutput($prt->getVrednost());
				$sfProtection->AddValue($prt->getPageProtectionID());
			}
			$sfProtection->AddSelected($pg->SfPageProtection->getPageProtectionID());
			$sfProtection->SmartyAssign();
			$ObjectFactory->ResetFilters();

			// U slucaju dodavanja modula UserRole!!!!
			$userroles = $ObjectFactory->createObjects("UserRole");
			$shUserRole = new SmartyHtmlSelection("userrole",$smarty);
			foreach ($userroles as $ur)
			{
				$shUserRole->AddOutput($ur->Role);
				$shUserRole->AddValue($ur->UserRoleID);
			}
			$shUserRole->AddSelected($pg->getUserRoleID());
			$shUserRole->SmartyAssign();

			// nadredjena stranica
			$ObjectFactory->Reset();
			$ObjectFactory->AddFilter("page_id <> " . $page_id);
			$parentPage = $ObjectFactory->createObjects("Page");
			$ObjectFactory->Reset();

			// Assign Parent groups to smarty
			if(count($parentPage) > 0)
			{
				$pageArray = array();
				foreach($parentPage as $pageP)
					$pageArray[] = $pageP->toArrayHierarchy();

				$tree = new MemTree();
				$tree->FillItems($pageArray);
				$parentPageCmb = $tree->DrawCombobox("parent_id",$pg->getParentID());
				$smarty->assign("parentPageCmb" , $parentPageCmb);
			}

			$smarty->assign("page_id",$page_id);
			$smarty->assign("parent_id",$parent_id);

			$smarty->assign("order",$order);

			$smarty->assign("header", $header);
			$smarty->assign("subheader",$subHeader);
			$smarty->assign("pagetypeid", $typeid);
			$smarty->assign("navigationtype", $navigationType);
			//$smarty->assign("createdby", $createdby);
			//$smarty->assign("createddate", $createddate);

			$smarty->assign("shorthtml", $shorthtml);
			$smarty->assign("html", $html);
			$smarty->assign("keywords", $keywords);
			$smarty->assign("description", $description);
		}
		$modify = new ConnectedObject($ObjectFactory,$DBBR);
		$smarty->assign("img_rows",$modify->ModifyConnectedObject('Page', 'img', $_REQUEST["page_id"]));
		$smarty->assign("doc_rows",$modify->ModifyConnectedObject('Page', 'doc', $_REQUEST["page_id"]));
		$smarty->assign("web_rows",$modify->ModifyConnectedObject('Page', 'web', $_REQUEST["page_id"]));
		$smarty->assign("vid_rows",$modify->ModifyConnectedObject('Page', 'vid', $_REQUEST["page_id"]));

		$smarty->display('modify_grp.tpl');

	}
	else
	{
		// show error message not enough rights
		$smarty->assign("norights_message",$LanguageArray["value"]["PLG_NORIGHT"]);
		$smarty->display('../../templates/norights.tpl');
	}
?>
