<? 
	/* CMS Studio 3.0 insert_pre.php */
	$_ADMINPAGES = true;
	
	include_once("../../../config.php");
		
	global $smarty;
	global $auth;

	if($auth->isActionAllowed("ACTION_MODULE_CREATE"))
	{
		$nw = $ObjectFactory->createObject("Module",-1);
		$nw->setHeader(getTranslation("PLG_MODULE_INSERT_NEW_MODULE"));
		$nw->setShortHtml("<p>".getTranslation("PLG_MODULE_INSERT_MODULESHORT_CONTENT")."</p>");
		$nw->setHtml("<p>".getTranslation("PLG_MODULE_INSERT_MODULE_CONTENT")."</p>");
		$nw->setDate(time());
		$nw->setPublishingDate(time());
		$nw->setDuration(1);
		$nw->setStatusID(STATUS_MODULE_NEAKTIVAN);
		$nw->setModuleTypeID(0);
		$nw->setCreatedBy($auth->getAdminFullName());
		$nw->setCreatedDate(time());
		$nw->setModifiedBy($auth->getAdminFullName());
		$nw->setModifiedDate(time());
		$DBBR->kreirajSlog($nw);
	}

	
	
?>