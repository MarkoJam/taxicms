<? 
	/* CMS Studio 3.0 insert_pre.php */
	$_ADMINPAGES = true;
	
	include_once("../../../config.php");
		
	global $smarty;
	global $auth;

	if($auth->isActionAllowed("ACTION_NEWS_CREATE"))
	{
		$nw = $ObjectFactory->createObject("News",-1);
		$nw->setHeader(getTranslation("PLG_NEWS_INSERT_NEW_NEWS"));
		$nw->setShortHtml("<p>".getTranslation("PLG_NEWS_INSERT_NEWSSHORT_CONTENT")."</p>");
		$nw->setHtml("<p>".getTranslation("PLG_NEWS_INSERT_NEWS_CONTENT")."</p>");
		$nw->setDate(time());
		$nw->setPublishingDate(time());
		$nw->setDuration(1);
		$nw->setStatusID(STATUS_NEWS_NEAKTIVAN);
		$nw->setNewsTypeID(0);
		$nw->setCreatedBy($auth->getAdminFullName());
		$nw->setCreatedDate(time());
		$nw->setModifiedBy($auth->getAdminFullName());
		$nw->setModifiedDate(time());
		$DBBR->kreirajSlog($nw);
	}

	
	
?>