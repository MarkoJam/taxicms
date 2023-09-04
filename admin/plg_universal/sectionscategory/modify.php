<?
	/* CMS Studio 3.0 modfify_ncateg.php */

	$_ADMINPAGES = true;
	include_once("../../../config.php");
		
	global $smarty;
	global $auth;
	
	if($auth->isActionAllowed("ACTION_SECTIONS_CATEGORY_MODIFY"))
	{
		if(isset($_REQUEST["mode"])) $_REQUEST["sectionscategoryid"]=-1;
		if(isset($_REQUEST["sectionscategoryid"]))
		{
			//punjenje i/ili postavljanje kategorijeid iz/u sesije
			$_SESSION["sectionscategoryid"] = $_REQUEST["sectionscategoryid"];
			
			$nc = $ObjectFactory->createObject("SectionsCategory",$_REQUEST["sectionscategoryid"]);
			// deo za insertovanje novog sloga
			if(isset($_REQUEST["mode"])) $smarty->assign("mode", 'insert');
			else $smarty->assign("mode", 'edit');			
			$nazivKategorije = $nc->Title;
			$brojVestiKategorije = $nc->MessageNum;
			
			$smarty->assign("sectionscategoryid",$nc->SectionsCategoryID);
			$smarty->assign("nazivkategorije",$nazivKategorije);
			$smarty->assign("brojVestiKategorije",$brojVestiKategorije);
			
			$smarty->display('modify.tpl');
		}
	}
	else 
	{
		// show error message not enough rights
		$smarty->assign("norights_message",$LanguageArray["value"]["PLG_NORIGHT"]);
		$smarty->display('../../../templates/norights.tpl');
	}
?>