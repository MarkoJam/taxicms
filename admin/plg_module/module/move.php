<?	
	/* CMS Studio 3.0 move.php */		

	$_ADMINPAGES = true;
	include_once("../../../config.php");		
	
	global $smarty;	
	global $auth;		
	
	$ObjectFactory = ObjectFactory::getInstance();	
	$LanguageHelper = LanguageHelper::getInstance();		
	
	
	$id_array=$_REQUEST["sectionsid"];	
	$ncid=$_REQUEST["ncid"];	
	$cnt_array=count($id_array);	
	$ncIdQuery = " AND module_category_id = " . $ncid;
	if($auth->isActionAllowed("ACTION_MODULE_MODIFY"))
	{
		for ($i = 0; $i <$cnt_array; $i++) 
		{	
			$ObjectFactory->Reset();
			$ObjectFactory->AddFilter("module_id = " . $id_array[$i]. $ncIdQuery);
			$nc = $ObjectFactory->createObjects("ModuleModuleCategory");
			$ObjectFactory->Reset();
			foreach($nc as $module)
			{
				$module->setModuleModuleCategoryOrder($i+1);
			}	
			$DBBR->promeniSlog($module);	
		}
	}
	else
	{
		// show error message not enough rights
		$smarty->assign("norights_message",getTranslation("PLG_NORIGHT"));
		$smarty->display('../../../templates/norights.tpl');
	}
?>