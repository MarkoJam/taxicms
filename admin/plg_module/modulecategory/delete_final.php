<?
	/* CMS Studio 3.0 delete_final.php */

	//brise citavu kategoriju sa svim povezanim karakteristikama
	$_ADMINPAGES = true;
	include_once("../../../config.php");

	global $smarty;
	global $auth;
	
	//security check if user has rights for delete
	if($auth->isActionAllowed("ACTION_MODULE_CATEGORY_DELETE"))
	{
		if(isset($_REQUEST["modulecategoryid"]))
		{
			$nws = $ObjectFactory->createObject("ModuleCategory",-1);
			$nws->ModuleCategoryID = $_REQUEST["modulecategoryid"];
			
			// potrebno je promenitu u svim vestima kategorije koju brisem modulecategoryid na -1
			$module = $ObjectFactory->createObject("Module",-1);
			$arr_module = array();
			$DBBR->vratiSveSlogove($module,$arr_module,"*","AND modulecategoryid=".$_REQUEST["modulecategoryid"]);
			foreach ($arr_module as $nw) 
			{
				$nw->ModuleCategory->ModuleCategoryID = -1;
				$DBBR->promeniSlog($nw);
			}
			$ObjectFactory->AddFilter("file_name='module'");
			$ObjectFactory->AddFilter("filterid=".$nw->ModuleCategory->ModuleCategoryID);
			
			$pluginTemplates = $ObjectFactory->createObjects("PluginTemplate");
			$ObjectFactory->ResetFilters();			
			foreach ($pluginTemplates as $pt) 
			{
				$pt->FilterID = -1;
				$DBBR->promeniSlog($pt);
			}
			
			$DBBR->obrisiSlog($nws);
			echo "<div class='success'>".getTranslation("PLG_DELETE_SUCCESS")."</div>";
		}
		else echo "<div class='error'>".getTranslation("PLG_CHANGE_FAILED")."</div>";
	}
	else echo "<div class='warning'>". getTranslation("PLG_NORIGHT")."</div>";
?>