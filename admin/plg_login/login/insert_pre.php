<?  
	/* CMS Studio 3.0 insert_pre.php */	//

	$_ADMINPAGES = true;	
	include_once("../../../config.php");
	
	global $smarty;
	global $auth;

	if($auth->isActionAllowed("ACTION_LOGIN_CREATE"))
	{
		$user = $ObjectFactory->createObject("User",-1);
		$user->Name = getTranslation("PLG_INSERT");
		$user->Surname = getTranslation("PLG_INSERT");
		$user->Email = getTranslation("PLG_INSERT");
		$user->UserName = getTranslation("PLG_INSERT");
		$user->Password = "";
		$user->Comment = "";
		$user->ExpiryDate = 1893456000;
		$user->SfUserCategory->setUserCategoryID(USER_CATEGORY_A);
		$user->SfUserType->setUserTypeID(USER_TYPE_PRIVATE_ENTITY);
		$user->SfStatus->setStatusID(STATUS_USER_NEAKTIVAN);
		$user->SfUserCategory->setUserCategoryID(USER_CATEGORY_MYUSERS);
		$DBBR->kreirajSlog($user);
	}


?>