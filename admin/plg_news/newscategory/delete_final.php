<?
	/* CMS Studio 3.0 delete_final.php */

	//brise citavu kategoriju sa svim povezanim karakteristikama
	$_ADMINPAGES = true;
	include_once("../../../config.php");

	global $smarty;
	global $auth;
	
	//security check if user has rights for delete
	if($auth->isActionAllowed("ACTION_NEWS_CATEGORY_DELETE"))
	{
		if(isset($_REQUEST["newscategoryid"]))
		{
			$nws = $ObjectFactory->createObject("NewsCategory",-1);
			$nws->NewsCategoryID = $_REQUEST["newscategoryid"];
			
			// potrebno je promenitu u svim vestima kategorije koju brisem newscategoryid na -1
			$news = $ObjectFactory->createObject("News",-1);
			$arr_news = array();
			$DBBR->vratiSveSlogove($news,$arr_news,"*","AND newscategoryid=".$_REQUEST["newscategoryid"]);
			foreach ($arr_news as $nw) 
			{
				$nw->NewsCategory->NewsCategoryID = -1;
				$DBBR->promeniSlog($nw);
			}
			$ObjectFactory->AddFilter("file_name='news'");
			$ObjectFactory->AddFilter("filterid=".$nw->NewsCategory->NewsCategoryID);
			
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