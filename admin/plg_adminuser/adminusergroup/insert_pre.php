<?  
	/* CMS Studio 3.0 insert_pre.php */
	
	$_ADMINPAGES = true;
	include_once("../../../config.php");

	global $smarty;
	global $auth;
	
	if($auth->isActionAllowed("ACTION_USERGROUP_CREATE"))
	{
		$usergroup = $ObjectFactory->createObject("AdminUserGroup",-1);
		$usergroup->setTitle(getTranslation("PLG_ADMINUSERGROUP_HEADER_NAME_NEW"));
		$usergroup->setDescription(getTranslation("PLG_ADMINUSERGROUP_HEADER_DESCRIPTION_NEW"));
		$DBBR->kreirajSlog($usergroup); 
	}

?>