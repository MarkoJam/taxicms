<?
	/* CMS Studio 3.0 delete_final.php */

	$_ADMINPAGES = true;
	include_once("../../../config.php");
	
	global $smarty;
	global $auth;
	
	
	if(isset($_REQUEST['news_id']) && isset($_REQUEST['connews_id']))
	{
		$ObjectFactory->ResetFilters();
		$ObjectFactory->AddFilter(" news_id = " .$_REQUEST['news_id']. " AND connews_id = ".$_REQUEST['connews_id']);
		$newsnews = $ObjectFactory->createObjects("NewsNews");
		$ObjectFactory->ResetFilters();
		foreach ($newsnews as $news)
		{
			$DBBR->obrisiSlog($news);	
			
		}				
		echo "<div class='success'>".getTranslation("PLG_DELETE_SUCCESS")."</div>";	
	}
	else echo "<div class='error'>".getTranslation("PLG_CHANGE_CONECTED_FAILED")."</div>";
	
?>