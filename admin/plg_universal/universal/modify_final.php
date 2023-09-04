<?	
	/* CMS Studio 3.0 modify_final.php */
	
	$_ADMINPAGES = true;
	include_once("../../../config.php");
	
	global $smarty;
	global $auth;

	if($auth->isActionAllowed("ACTION_UNIVERSAL_MODIFY"))
	{
		//insertovanje praznog sloga, umesto insert_pre.php
		if ($_REQUEST['mode']=='insert') 
		{
			require ("insert_pre.php");
			$obj = $ObjectFactory->createObject("UniversalPlugin");
			$colid=$DBBR->vratiPoslednjiID($obj);
			$col=$colid[0];
			$id=$colid[1];
			$_REQUEST[$col]=$_POST[$col]=$id;
		}
		if(isset($_REQUEST["universalpluginid"]))
		{
			$universalPlugin = $ObjectFactory->createObject("UniversalPlugin",-1);
			$universalPlugin->UniversalPlugin_POST($_POST);
			$tmp_html_page = htmlspecialchars($_POST["rtel"] , ENT_QUOTES);
			$universalPlugin->Html = $tmp_html_page;
			$DBBR->promeniSlog($universalPlugin);
			
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
