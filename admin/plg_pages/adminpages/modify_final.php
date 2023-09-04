<?
	/* CMS Studio 3.0 modify_final.php */

	$_ADMINPAGES = true;
	include_once("../../../config.php");
	
	global $smarty;
	global $auth;
	
	if($auth->isActionAllowed("ACTION_ADMIN_MODIFY"))
	{
		//insertovanje praznog sloga, umesto insert_pre.php
		if ($_REQUEST['mode']=='insert') 
		{
			require ("insert_pre.php");
			$obj = $ObjectFactory->createObject("AdminPage");
			$colid=$DBBR->vratiPoslednjiID($obj);
			$col=$colid[0];
			$id=$colid[1];
			$_REQUEST[$col]=$_POST[$col]=$id;
		}		
		if(isset($_REQUEST["adminpage_id"]))
		{	
			$tmp_html_page = $new = htmlspecialchars($_POST["rtel"] , ENT_QUOTES);
			$tmp_header = htmlspecialchars($_POST["header"] , ENT_QUOTES);
			
			// correct letter Š š
			$tmp_html_page = str_replace("&amp;Scaron;","Š",$tmp_html_page);
			$tmp_html_page = str_replace("&amp;scaron;","š",$tmp_html_page);
			
			//dohvati staru admin stranicu
			$apg = $ObjectFactory->createObject("AdminPage",-1);
			$apg->AdminPageID = $_POST["adminpage_id"];
			$apg->AdminPageName	= $_POST["adminpagename"];
			$apg->Template->TemplateID = $_POST["template_id"];
			$apg->Html = $tmp_html_page ;
			$apg->Header = $tmp_header;

			$DBBR->promeniSlog($apg);

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