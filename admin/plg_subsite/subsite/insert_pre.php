<?  
	/* CMS Studio 3.0 insert_pre.php */	

	$_ADMINPAGES = true;	
	include_once("../../../config.php");
	
	global $smarty;
	global $auth;

	if($auth->isActionAllowed("ACTION_SUBSITE_CREATE"))
	{
		$ss = $ObjectFactory->createObject("SubSite",-1);
		$ss->SfStatus->StatusID = STATUS_SUBSITE_AKTIVAN;	
		$DBBR->kreirajSlog($ss);

	}

?>