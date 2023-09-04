<?  
	/* CMS Studio 3.0 insert_pre.php */
	
	$_ADMINPAGES = true;
	include_once("../../../config.php");

	global $smarty;
	global $auth;
	
	if($auth->isActionAllowed("ACTION_USERGROUPACTIONS_CREATE"))
	{
		$useraction = $ObjectFactory->createObject("AdminUserAction", -1);
		$DBBR->kreirajSlog($useraction);
	}

?>