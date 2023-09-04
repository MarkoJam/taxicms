<?  
	/* CMS Studio 3.0 insert_pre.php */
		
	$_ADMINPAGES = true;
	include_once("../../../config.php");
	
	global $smarty;
	global $auth;
	
	if($auth->isActionAllowed("ACTION_USERROLE_CREATE"))
	{
		$userrole = $ObjectFactory->createOBject("UserRole",-1);
		$userrole->Role = getTranslation("PLG_INSERT");
		$userrole->Description = getTranslation("PLG_INSERT");
		$DBBR->kreirajSlog($userrole); //ovde se vrati objekat sa popunjenim Id-jem
	}

?>