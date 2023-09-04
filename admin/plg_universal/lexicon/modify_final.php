<?	
	/* CMS Studio 3.0 modify_final.php */
	
	$_ADMINPAGES = true;
	include_once("../../../config.php");
	
	global $smarty;
	global $auth;

	if($auth->isActionAllowed("ACTION_LEXICON_MODIFY"))
	{
		//insertovanje praznog sloga, umesto insert_pre.php
		if ($_REQUEST['mode']=='insert') 
		{
			require ("insert_pre.php");
			$obj = $ObjectFactory->createObject("Lexicon");
			$colid=$DBBR->vratiPoslednjiID($obj);
			$col=$colid[0];
			$id=$colid[1];
			$_REQUEST[$col]=$_POST[$col]=$id;
		}
		if(isset($_REQUEST["lexiconid"]))
		{
			$lexiconPlugin = $ObjectFactory->createObject("Lexicon",-1);
			$lexiconPlugin->Lexicon_POST($_POST);
			$tmp_html_page = htmlspecialchars($_POST["rtel"] , ENT_QUOTES);
			$lexiconPlugin->Html = $tmp_html_page;
			$DBBR->promeniSlog($lexiconPlugin);
			
			echo "<div class='success'>".getTranslation("PLG_CHANGE_SUCCESS")."</div>";
		}
		else 
		{
			echo "<div class='error'>".getTranslation("PLG_CHANGE_FAILED")."</div>";
		}
	}
	else
	{
		echo "<div class='warning'>".getTranslation("PLG_NORIGHT")."</div>";
	}
	
?>
