<?
	/* CMS Studio 3.0 delete_final.php */

	//brise citavu kategoriju sa svim povezanim karakteristikama
	$_ADMINPAGES = true;
	include_once("../../../config.php");

	global $smarty;
	global $auth;
	
	//security check if user has rights for delete
	if($auth->isActionAllowed("ACTION_NEWS_TYPE_DELETE"))
	{
		if(isset($_REQUEST["news_type_id"]))
		{
			$nwTypeId = $_REQUEST["news_type_id"];
			
			$nwType = $ObjectFactory->createObject("NewsType",-1);
			$nwType->setNewsTypeID($_REQUEST["news_type_id"]);
			
			// potrebno je promenitu u svim vestima kategorije koju brisem newstypeid na -1
			//$ObjectFactory->SetDebugOn();
			$news = $ObjectFactory->createObject("News",-1);
			$arr_news = array();
			$DBBR->vratiSveSlogove($news,$arr_news,"*","AND news_type_id=".$_REQUEST["news_type_id"]);
			foreach ($arr_news as $nw) 
			{
				$nw->NewsType->setNewsTypeID(-1);
				$DBBR->promeniSlog($nw);
			}
			$ObjectFactory->AddFilter("file_name='news'");
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