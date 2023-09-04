<?
	/* CMS Studio 3.0 modify.php *///

	$_REQUEST['frontadmin'] = true;
	include_once("../../../config.php");
	global $lh;	
		
	$smarty->assign("ROOT_HOME",ROOT_HOME);
	$smarty->assign("ROOT_WEB",ROOT_WEB);
	$smarty->assign("language",$lh->GetLinkPluginLanguage());
	
	if (CAPTCHA_KEY_2 != '') $smarty->assign("dkey",CAPTCHA_KEY_2);
	else $smarty->assign("dkey",'xxxx'); //za probu na local-u
	
	
	$languageHelper = LanguageHelper::getInstance();
	$languageHelper->Initialize();
	$ObjectFactory = ObjectFactory::getInstance();
	$DatabaseBroker = DatabaseBroker::getInstance();
	
	// load only global translations form language xml files
	$xmlConfig = new XMLConfig;
	$xmlConfig->Parse(ROOT_HOME."config/languages/lang_".$languageHelper->GetFileDesc().".xml");
	$languageGlobalArray = $xmlConfig->get("/login");
	if(!empty($languageGlobalArray["value"]))
	{	
		foreach($languageGlobalArray["value"] as $key => $value)
		{
			$smarty->assign($key , $value);
		}
	}

	if($_REQUEST["mode"]=='insert') $_REQUEST["userid"]=-1;				
	// deo za insertovanje novog sloga
	$smarty->assign("mode", $_REQUEST["mode"]);
	
	$user = $ObjectFactory->createObject("User",$_REQUEST["userid"]);
	if($_REQUEST["mode"]=='edit') $smarty->assign($user->toArray());

	$smarty->assign("usertip" , $user->SfUserType->getUserTypeID());
	/* part for user log history */
	$ObjectFactory->SetSortBy("last_log_date","desc");
	$ObjectFactory->AddFilter("user_id = " .$user->getUserID());
	$user_log_history = $ObjectFactory->createObjects("UserLogHistory",$_REQUEST["userid"]);
	$ObjectFactory->ResetFilters();
	$ObjectFactory->ResetSortBy();
	
	if(!empty($user_log_history))
	{
		$user_log_history_data = array();
		foreach ($user_log_history as $usr_log_hist) 
		{
			$user_log_history_data[] = $usr_log_hist->toArray();
		}
		
		$smarty->assign("user_log_history_data",$user_log_history_data);
	}			
	$smarty->display('modify.tpl');
	

?>