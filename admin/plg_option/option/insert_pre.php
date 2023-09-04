<? 
	/* CMS Studio 3.0 insert_pre.php */
	$_ADMINPAGES = true;
	
	include_once("../../../config.php");
		
	global $smarty;
	global $auth;

	if($auth->isActionAllowed("ACTION_OPTION_CREATE"))
	{
		$nw = $ObjectFactory->createObject("Option",-1);
		$nw->setHeader(getTranslation("PLG_OPTION_INSERT_NEW_OPTION"));
		$nw->setShortHtml("<p>".getTranslation("PLG_OPTION_INSERT_OPTIONSHORT_CONTENT")."</p>");
		$nw->setHtml("<p>".getTranslation("PLG_OPTION_INSERT_OPTION_CONTENT")."</p>");
		$nw->setDate(time());
		$nw->setPublishingDate(time());
		$nw->setDuration(1);
		$nw->setStatusID(STATUS_OPTION_NEAKTIVAN);
		$nw->setOptionTypeID(0);
		$nw->setCreatedBy($auth->getAdminFullName());
		$nw->setCreatedDate(time());
		$nw->setModifiedBy($auth->getAdminFullName());
		$nw->setModifiedDate(time());
		$DBBR->kreirajSlog($nw);
	}

	
	
?>