<?
	$_ADMINPAGES = true;
	include_once("../../../config.php");

	global $smarty;
	global $auth;
	global $LanguageArray;

	$_SESSION['br']=0;

	if($auth->isActionAllowed("ACTION_PAGE_MODIFY"))
	{
		//insertovanje praznog sloga, umesto insert_pre.php
		if ($_REQUEST['mode']=='insert')
		{
			$tr = new Tree();
			$obj = $ObjectFactory->createObject("Page");
			$DBBR->kreirajSlog($obj);
			$colid=$DBBR->vratiPoslednjiID($obj);
			$col=$colid[0];
			$id=$colid[1];
			$_REQUEST[$col]=$_POST[$col]=$id;
			if($_REQUEST["pagetypeid"] == PAGE_TYPE_LINK)
			{
				$pagelink = $ObjectFactory->createObject("PageLink",-1);
				$pagelink->PageID = $id;
				$pagelink->Target = "_self";
				$DBBR->kreirajSlog($pagelink);
			}
		}

		if(isset($_REQUEST["page_id"]))
		{
			$tmp_shorthtml_page = $new = htmlspecialchars($_POST["rtelsmall"] , ENT_QUOTES);
			$tmp_html_page = $new = htmlspecialchars($_POST["rtel"] , ENT_QUOTES);
			$tmp_header = htmlspecialchars($_POST["header"] , ENT_QUOTES);

			// correct letter Š š
			$tmp_shorthtml_page = str_replace("&amp;Scaron;","Š",$tmp_shorthtml_page);
			$tmp_shorthtml_page = str_replace("&amp;scaron;","š",$tmp_shorthtml_page);
			$tmp_html_page = str_replace("&amp;Scaron;","Š",$tmp_html_page);
			$tmp_html_page = str_replace("&amp;scaron;","š",$tmp_html_page);


			$pg = $ObjectFactory->createObject("Page",-1);
			$pg->setPageID($_POST["page_id"]);
			$pg->setParentID($_POST["parent_id"] == "" ? "-1" : $_POST["parent_id"]);
			$pg->getTemplate()->setTemplateID( $_POST["template_id"]);
			$pg->setShortHtml( $tmp_shorthtml_page );
			$pg->setHtml( $tmp_html_page );
			$pg->SfPageProtection->setID($_POST["protection_id"]);
			$pg->setHeader($tmp_header);
			$pg->setSubHeader($_POST["subheader"]);
			$pg->setKeywords($_POST["keywords"]);
			$pg->setDescription($_POST["description"]);
			$pg->setOrder($_POST["order"]);
			$pg->setUserRoleID($_POST["userroleid"]);
			$pg->setNavigationType($_POST["navigationtype"]);

			$pg->setFrequency($_POST["frequency"]);
			$pg->setPriority($_POST["priority"]);
			if ($_POST["createdby"]=="") $pg->setCreatedBy($auth->getAdminFullName());
			else $pg->setCreatedBy($_POST["createdby"]);
			if ($_POST["createddate"]==0) $pg->setCreatedDate(time());
			else $pg->setCreatedDate($_POST["createddate"]);
			$pg->setModifyBy($auth->getAdminFullName());
			$pg->setModifyDate(time());



			$pg->SfStatus->setStatusID ($_POST["statusid"]);
			$pg->SfPageType->SetPageTypeID($_POST["pagetypeid"]);

			//pretvaranje u kategoriju ukoliko je html prazan
			/*if(strlen($pg->getHtml()) == 0 && $pg->SfPageType->GetPageTypeID()== PAGE_TYPE_PAGE && $_REQUEST["mode"]=='edit')
			{
				$pg->SfPageType->SetPageTypeID(PAGE_TYPE_CATEGORY);
			}*/

			if($pg->SfPageType->GetPageTypeID()== PAGE_TYPE_LINK)
			{
				//ukoliko dodajemo link moramo ispitati target i promeniti i taj slog u tabeli
				$pagelink = $ObjectFactory->createObject("PageLink",-1);
				$pagelink->PageID = $pg->getPageID();
				$pagelink->Target = $_POST["target"];

				$DBBR->promeniSlog($pagelink);
			}

			if($pg->SfPageType->GetPageTypeID() == TYPE_PRODUCT)
			{
				$pg->setGrupaProizvodaID($_REQUEST["grupaproizvodaid"]);
			}

			$treeMenu = new Tree();
			$pg->setHeaderUrlized(urlizePath($treeMenu, $pg));
			$pag = $ObjectFactory->createObject("Page",$_REQUEST['page_id']);
			$hu=$pag->getHeaderUrlized();

			$DBBR->promeniSlog($pg);

			// stari parent_id i header uzeti iz hidden polja u kojima su smesteni u tpl-u i uporediti ih sa novima
			if (($_REQUEST['parent_id']<>$_REQUEST['parent_id_old']) || ($_REQUEST['header']<>$_REQUEST['header_old']))
			{
				// za azuriranje header_urlized
				$pg = $ObjectFactory->createObject("Page",$_REQUEST['page_id']);
				$treeMenu = new Tree();
				$pg->setHeaderUrlized(urlizePath($treeMenu, $pg, $hu));
				//sitemap();
			}
			if ($_REQUEST['parent_id']<>$_REQUEST['parent_id_old'] && !empty($_REQUEST['parent_id_old']))
			{
				// za azuriranje redosleda u nivou novog parent_id-a ukoliko je promenjen parent_id
				$pg = $ObjectFactory->createObject("Page",$_REQUEST['page_id']);
				$pg->setOrder($treeMenu->max_order($_REQUEST['parent_id'])+1);
				$DBBR->promeniSlog($pg);
			}


				// za azuriranje u celoj tabeli ukoliko je potrebno
				/*$page = $ObjectFactory->createObjects("Page");
				$ObjectFactory->Reset();
				$ObjectFactory->AddFilter("page_id = " . $_REQUEST['parent_id']);
				$page = $ObjectFactory->createObjects("Page");
				$ObjectFactory->Reset();
				foreach ($page as $pg)
				{
					$treeMenu = new Tree();
					$pg->setHeaderUrlized(urlizePath($treeMenu, $pg));
					$DBBR->promeniSlog($pg);
				}
			*/

			//nalazemo browseru da skoci jedan nivo vise u hijerarhiji
			//ovo je samo da ne bi skocili na roditelja od roditeljske stranice
			if($pg->getParentID() == -1) $page_jump = 0;
			else $page_jump = $pg->getParentID();

			// ukoliko je pritisnuto dugme za pretvaranje u stranicu treba
			// promeniti tip u "stranica" ucitati neku vrednost u html kod
			// i promeniti slog a zatim ucitati stranicu za promeni
			if(isset($_REQUEST["pretvori"]))
			{
				if ($_REQUEST['pretvori']=='stranica') {
					$pg->SfPageType->SetPageTypeID(PAGE_TYPE_PAGE);
					$pg->setHtml("<p>".$LanguageArray["value"]["PLG_INSERT_NEW_CONTENT"]."</p>");
				}
				if ($_REQUEST['pretvori']=='kategorija') {
					$pg->SfPageType->SetPageTypeID(PAGE_TYPE_CATEGORY);
				}
				$DBBR->promeniSlog($pg);
			}
			$insert = new ConnectedObject($ObjectFactory,$DBBR);
			$insert->InsertConnectedObject('Page', 'img', $_REQUEST["page_id"]);
			$insert->InsertConnectedObject('Page', 'doc', $_REQUEST["page_id"]);
			$insert->InsertConnectedObject('Page', 'web', $_REQUEST["page_id"]);
			$insert->InsertConnectedObject('Page', 'vid', $_REQUEST["page_id"]);

			echo "<div class='success'>".getTranslation("PLG_CHANGE_SUCCESS")."</div>";
		}
		else echo "<div class='error'>".getTranslation("PLG_CHANGE_FAILED")."</div>";
	}
	else echo "<div class='warning'>".getTranslation("PLG_NORIGHT")."</div>";

	function urlizePath($treeMenu, $page, $hu=null, $skipList = array())
	{
		global $DBBR;

		$fullUrl = $treeMenu->get_path($page->getPageID(),0);

		$url_paths = "";
		for ($i=0; $i<count($fullUrl); $i++)
		{
			if($i == count($fullUrl)-1)
			{
				$url_paths .= "/". urlize($page->getHeaderUnchanged());
			}
			else
			{
				$url_paths .= "/" .urlize($fullUrl[$i]["header"]);
			}
		}
		$hu_old=$page->getHeaderUrlized();
		if ($hu_old=="") $hu_old=$hu;
		$hu_new=$url_paths;
		$query = "UPDATE ". $page->vratiImeKlase() . " SET header_urlized = '" .$url_paths  . "' WHERE page_id = " . $page->getPageID();
		$DBBR->con->query($query);

		change_url_in_html($hu_old, $hu_new);

		$childrenList = array();
		$treeMenu->get_children($page->getPageID(), 0, $childrenList);
		if(count($childrenList) > 0)
		{
			foreach($childrenList as $child)
			{
				urlizePath($treeMenu,$child);
			}
		}

		return $url_paths;
	}

	function change_url_in_html($hu_old, $hu_new)
	{
		global $DBBR;
		global $ObjectFactory;

		$pages = $ObjectFactory->createObjects("Page");
		foreach ($pages as $pag)
		{
			$pos = strpos($pag->getHtml(), $hu_old);
			if ($pos>0)
			{
				$html2 = str_replace($hu_old, $hu_new, $pag->getHtml());
				$id=$pag->getPageID();
				$query2 = "UPDATE ". $pag->vratiImeKlase() . " SET html = '" .$html2  . "' WHERE page_id = " . $id;
				$DBBR->con->query($query2);
			}
		}
	}
?>
