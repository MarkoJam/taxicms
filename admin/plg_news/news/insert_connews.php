<?
	/* CMS Studio 3.0 insert_plugin.php */

	$_ADMINPAGES = true;
	include_once("../../../config.php");

	global $smary;
	global $auth;


		//insertovanje praznog sloga, umesto insert_pre.php
		if ($_REQUEST['mode']=='insert') 
		{
			require ("insert_pre.php");
			$obj = $ObjectFactory->createObject("News");
			$colid=$DBBR->vratiPoslednjiID($obj);
			$col=$colid[0];
			$id=$colid[1];
			$_REQUEST[$col]=$_POST[$col]=$id;
		}
		if (isset($_REQUEST['news_id']) && isset($_REQUEST['connews_id']) && $_REQUEST['connews_id']>-1)
		{
			$newsnews = $ObjectFactory->createObject("NewsNews",-1);
			$newsnews->ConNewsID = $_REQUEST['connews_id'];
			$newsnews->NewsID = $_REQUEST['news_id'];
			$DBBR->kreirajSlog($newsnews);
			echo "<div class='success'>".getTranslation("PLG_ADD_SUCCESS")."</div>";	
		}
		else echo "<div class='error'>".getTranslation("PLG_CHANGE_FAILED")."</div>";
									

?>