<?  
	/* CMS Studio 3.0 insert_pre.php */

	$_ADMINPAGES = true;	
	include_once("../../../config.php");		

	global $smarty;
	global $auth;
	global $LanguageArray;
	
	$ObjectFactory = ObjectFactory::getInstance();
	
	if($auth->isActionAllowed("ACTION_SPAGE_CREATE"))
	{
		$spg = $ObjectFactory->createObject("StaticPage",-1);
		$spg->SfPageType->SetPageTypeID($_REQUEST["type_id"]);
		
		switch ($spg->SfPageType->GetPageTypeID())
		{
			case PAGE_TYPE_PAGE:
				$spg->setHeader(getTranslation("PLG_SPAGES_INSERT_NEW_PAGE"));
				$spg->setHtml("<p>".getTranslation("PLG_SPAGES_INSERT_NEW_CONTENT")."</p>");
			break;
			case PAGE_TYPE_LINK:
				$spg->setHeader(getTranslation("PLG_SPAGES_INSERT_NEW_LINK"));
				$spg->setHtml("");
			break;
		}
		
		$spg->getTemplate()->TemplateID = 1;
		$spg->SfStatus->StatusID = STATUS_PAGE_NEAKTIVAN;
		$DBBR->kreirajSlog($spg);
		
		//OVO TREBA SREDITI !!! vratiMaxPoUslovu()
		$spg->setOrder($DBBR->vratiMaxPoUslovu($spg));
		$DBBR->promeniSlog($spg);
		
		// specijalno za stranicu koja cuva link dodajem unos u tabelu page_links
		if($spg->SfPageType->GetPageTypeID() == PAGE_TYPE_LINK) 
		{
			$spagelink = $ObjectFactory->createObject("StaticPageLink",-1);
			$spagelink->SPageID = $spg->getSPageID();
			$spagelink->Target = "_self";
			$DBBR->kreirajSlog($spagelink);
		}
	}
?>