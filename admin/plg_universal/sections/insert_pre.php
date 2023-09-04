<? 
	/* CMS Studio 3.0 insert_pre.php */
	$_ADMINPAGES = true;
	
	include_once("../../../config.php");
		
	global $smarty;
	global $auth;

	if($auth->isActionAllowed("ACTION_SECTIONS_CREATE"))
	{
		$nw = $ObjectFactory->createObject("Sections",-1);
		$nw->setHeader(getTranslation("PLG_SECTIONS_INSERT_NEW_SECTIONS"));
		$nw->setShortHtml("<p>".getTranslation("PLG_SECTIONS_INSERT_SECTIONSSHORT_CONTENT")."</p>");
		$nw->setHtml("<p>".getTranslation("PLG_SECTIONS_INSERT_SECTIONS_CONTENT")."</p>");
		$nw->setStatusID(STATUS_SECTIONS_NEAKTIVAN);
		$nw->setCreatedBy($auth->getAdminFullName());
		$nw->setCreatedDate(time());
		$nw->setModifiedBy($auth->getAdminFullName());
		$nw->setModifiedDate(time());
		$DBBR->kreirajSlog($nw);
	}

	
	
?>