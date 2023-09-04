<?
	/* CMS Studio 3.0 delete_final.php */

	//brise citavu kategoriju sa svim povezanim karakteristikama
	$_ADMINPAGES = true;
	include_once("../../../config.php");

	global $smarty;
	global $auth;
	
	//security check if user has rights for delete
	if($auth->isActionAllowed("ACTION_MODULE_TYPE_DELETE"))
	{
		if(isset($_REQUEST["module_type_id"]))
		{
			$nwTypeId = $_REQUEST["module_type_id"];
			
			$nwType = $ObjectFactory->createObject("ModuleType",-1);
			$nwType->setModuleTypeID($_REQUEST["module_type_id"]);
			
			// potrebno je promenitu u svim vestima kategorije koju brisem moduletypeid na -1
			//$ObjectFactory->SetDebugOn();
			$module = $ObjectFactory->createObject("Module",-1);
			$arr_module = array();
			$DBBR->vratiSveSlogove($module,$arr_module,"*","AND module_type_id=".$_REQUEST["module_type_id"]);
			foreach ($arr_module as $nw) 
			{
				$nw->ModuleType->setModuleTypeID(-1);
				$DBBR->promeniSlog($nw);
			}
			$ObjectFactory->AddFilter("file_name='module'");
			$ObjectFactory->AddFilter("filterid=".$nwTypeId);
			
			$pluginTemplates = $ObjectFactory->createObjects("PluginTemplate");
			$ObjectFactory->ResetFilters();			
			foreach ($pluginTemplates as $pt) 
			{
				$pt->FilterID = -1;
				$DBBR->promeniSlog($pt);
			}
			
			$DBBR->obrisiSlog($nwType);
			echo "<div class='success'>".getTranslation("PLG_DELETE_SUCCESS")."</div>";
		}
		else echo "<div class='error'>".getTranslation("PLG_CHANGE_FAILED")."</div>";
	}
	else echo "<div class='warning'>". getTranslation("PLG_NORIGHT")."</div>";
?>