<?  
	/* CMS Studio 3.0 insert_pre.php */

	$_ADMINPAGES = true;	
	include_once("../../../config.php");		

	global $smarty;
	global $auth;
	
	if($auth->isActionAllowed("ACTION_ADMIN_CREATE"))
	{
		$apg = $ObjectFactory->createObject("AdminPage",-1);
		$apg->AdminPageName = "name_id"+time();
		$apg->Header = getTranslation("PLG_INSERT");
		$apg->Html = getTranslation("PLG_INSERT");
		$apg->Template->TemplateID = 1;
		$DBBR->kreirajSlog($apg);
	}

?>