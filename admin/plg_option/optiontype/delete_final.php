<?
	/* CMS Studio 3.0 delete_final.php */

	//brise citavu kategoriju sa svim povezanim karakteristikama
	$_ADMINPAGES = true;
	include_once("../../../config.php");

	global $smarty;
	global $auth;
	
	//security check if user has rights for delete
	if($auth->isActionAllowed("ACTION_OPTION_TYPE_DELETE"))
	{
		if(isset($_REQUEST["option_type_id"]))
		{
			$nwTypeId = $_REQUEST["option_type_id"];
			
			$nwType = $ObjectFactory->createObject("OptionType",-1);
			$nwType->setOptionTypeID($_REQUEST["option_type_id"]);
			
			// potrebno je promenitu u svim vestima kategorije koju brisem optiontypeid na -1
			//$ObjectFactory->SetDebugOn();
			$option = $ObjectFactory->createObject("Option",-1);
			$arr_option = array();
			$DBBR->vratiSveSlogove($option,$arr_option,"*","AND option_type_id=".$_REQUEST["option_type_id"]);
			foreach ($arr_option as $nw) 
			{
				$nw->OptionType->setOptionTypeID(-1);
				$DBBR->promeniSlog($nw);
			}
			$ObjectFactory->AddFilter("file_name='option'");
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