<?  
	/* CMS Studio 3.0 insert_pre.php */	

	$_ADMINPAGES = true;	
	include_once("../../../config.php");
	
	global $smarty;
	global $auth;

	if($auth->isActionAllowed("ACTION_ADMINISTRATOR_CREATE"))
	{
		$admin = $ObjectFactory->createObject("AdminUser",-1);
		$admin->Name = getTranslation("PLG_INSERT");
		$admin->Surname = getTranslation("PLG_INSERT");
		$admin->Email = getTranslation("PLG_INSERT");
		$admin->UserName = getTranslation("PLG_INSERT");
		$admin->Password = "";
		$admin->Comment = "";
		$admin->Kategorija = "A";
		$admin->SfStatus->StatusID = STATUS_ADMINUSER_NEAKTIVAN;
	
		$DBBR->kreirajSlog($admin);
	}

?>