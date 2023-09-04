<? 
	/* CMS Studio 3.0 index.php */
	$_ADMINPAGES = true;
	
	include_once("../../config.php");

	global $smarty;
	global $auth;
	
	$admin = $ObjectFactory->createObject("AdminUser",$_SESSION["adminuserid"],array('AdminUserGroup','SubSite'));
	$smarty->assign($admin->toArray());
	$smarty->assign('group',$admin->AdminUserGroup->Title);
	$smarty->assign('subsite',$admin->SubSite->Name);
	if ($admin->SubSite->SubSiteID=-1) $smarty->assign('subsite',getTranslation("PLG_ALLSUBSITES"));
	$smarty->display('index.tpl');	


	
?>