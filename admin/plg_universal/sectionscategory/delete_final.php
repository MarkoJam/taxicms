<?
	/* CMS Studio 3.0 delete_final.php */

	//brise citavu kategoriju sa svim povezanim karakteristikama
	$_ADMINPAGES = true;
	include_once("../../../config.php");

	global $smarty;
	global $auth;
	
	//security check if user has rights for delete
	if($auth->isActionAllowed("ACTION_SECTIONS_CATEGORY_DELETE"))
	{
		if(isset($_REQUEST["sectionscategoryid"]))
		{
			$nws = $ObjectFactory->createObject("SectionsCategory",-1);
			$nws->SectionsCategoryID = $_REQUEST["sectionscategoryid"];
			
			// potrebno je promenitu u svim vestima kategorije koju brisem sectionscategoryid na -1
			$sections = $ObjectFactory->createObject("Sections",-1);
			$arr_sections = array();
			$DBBR->vratiSveSlogove($sections,$arr_sections,"*","AND sectionscategoryid=".$_REQUEST["sectionscategoryid"]);
			foreach ($arr_sections as $nw) 
			{
				$nw->SectionsCategory->SectionsCategoryID = -1;
				$DBBR->promeniSlog($nw);
			}
			$ObjectFactory->AddFilter("file_name='sections'");
			$ObjectFactory->AddFilter("filterid=".$nw->SectionsCategory->SectionsCategoryID);
			
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