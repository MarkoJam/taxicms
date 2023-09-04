<?  
	/* CMS Studio 3.0 insert_grp.php */
	
	$_ADMINPAGES = true;
	include_once("../../../config.php");		

	global $smarty;
	global $auth;
		
	if($auth->isActionAllowed("ACTION_PAGE_CREATE"))
	{			

		if(isset($_REQUEST["page_id"]))
		{
			//pomocu stabla vodimo racuna o dodavanju uredjenja cvorova
			$tr = new Tree();
			
			//znaci da znamo roditeljsku stranicu... 
			$parent_id = $_REQUEST["page_id"];
			
			$pg = $ObjectFactory->createObject("Page",-1);
			$pg->setParentID($parent_id);
			$pg->SfPageType->SetPageTypeID($_REQUEST["pagetypeid"]);
			
			switch ($pg->SfPageType->GetPageTypeID())
			{
				case PAGE_TYPE_PAGE:
					$pg->setHeader(getTranslation("PLG_PAGES_INSERT_NEW_PAGE"));
					$pg->setHtml("<p>".getTranslation("PLG_PAGES_INSERT_NEW_CONTENT")."</p>");
				break;
				case  PAGE_TYPE_LINK:
					$pg->setHeader(getTranslation("PLG_PAGES_INSERT_NEW_LINK"));
					$pg->setHtml(getTranslation("PLG_PAGES_INSERT_NEW_LINK_CONTENT"));
				break;
				case PAGE_TYPE_CATEGORY:
					$pg->setHeader(getTranslation("PLG_PAGES_INSERT_NEW_CATEGORY"));
					$pg->setHtml("");
				case PAGE_TYPE_PRODUCTGROUP:
					$pg->setHeader(getTranslation("PLG_PAGES_INSERT_NEW_PRODUCTGROUP"));
					$pg->setHtml("");
				break;
			}
			$pg->getTemplate()->setTemplateID(1);
			$pg->SfStatus->StatusID = STATUS_PAGE_NEAKTIVAN;
			$pg->SfPageProtection->ID = PAGE_PROTECTION_NOTACTIVE;
			$DBBR->kreirajSlog($pg);
			$pg->setOrder($tr->max_order($parent_id)+1);
			$DBBR->promeniSlog($pg);
			
			// specijalno za stranicu koja cuva link dodajem unos u tabelu page_links
			if($pg->SfPageType->GetPageTypeID() == PAGE_TYPE_LINK) 
			{
				$pagelink = $ObjectFactory->createObject("PageLink",-1);
				$pagelink->PageID = $pg->getPageID();
				$pagelink->Target = "_self";
				$DBBR->kreirajSlog($pagelink);
			}
		}
	}

?>