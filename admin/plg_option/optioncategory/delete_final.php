<?
	/* CMS Studio 3.0 delete_final.php */

	//brise citavu kategoriju sa svim povezanim karakteristikama
	$_ADMINPAGES = true;
	include_once("../../../config.php");

	global $smarty;
	global $auth;
	
	//security check if user has rights for delete
	if($auth->isActionAllowed("ACTION_OPTION_CATEGORY_DELETE"))
	{
		if(isset($_REQUEST["optioncategoryid"]))
		{
			$nws = $ObjectFactory->createObject("OptionCategory",-1);
			$nws->OptionCategoryID = $_REQUEST["optioncategoryid"];
			
			// potrebno je promenitu u svim vestima kategorije koju brisem optioncategoryid na -1
			$option = $ObjectFactory->createObject("Option",-1);
			$arr_option = array();
			$DBBR->vratiSveSlogove($option,$arr_option,"*","AND optioncategoryid=".$_REQUEST["optioncategoryid"]);
			foreach ($arr_option as $nw) 
			{
				$nw->OptionCategory->OptionCategoryID = -1;
				$DBBR->promeniSlog($nw);
			}
			$ObjectFactory->AddFilter("file_name='option'");
			$ObjectFactory->AddFilter("filterid=".$nw->OptionCategory->OptionCategoryID);
			
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