<?
	/* CMS Studio 3.0 modify_final.php */

	$_ADMINPAGES = true;
	include_once("../../../config.php");
	
	global $smarty;
	global $auth;
	
	if($auth->isActionAllowed("ACTION_SPAGE_MODIFY"))
	{			
		//insertovanje praznog sloga, umesto insert_pre.php
		if ($_REQUEST['mode']=='insert') 
		{
			require ("insert_pre.php");
			$obj = $ObjectFactory->createObject("StaticPage");
			$colid=$DBBR->vratiPoslednjiID($obj);
			$col=$colid[0];
			$id=$colid[1];
			$_REQUEST[$col]=$_POST[$col]=$id;
		}
		if(isset($_REQUEST["spage_id"]))
		{
			$tmp_html_page = $new = htmlspecialchars($_POST["rtel"] , ENT_QUOTES);
			
			// correct letter Š š
			$tmp_html_page = str_replace("&amp;Scaron;","Š",$tmp_html_page);
			$tmp_html_page = str_replace("&amp;scaron;","š",$tmp_html_page);
			
			$spg = $ObjectFactory->createObject("StaticPage",-1);
			$spg->setSPageID($_POST["spage_id"]);
			$spg->getTemplate()->TemplateID = $_POST["template_id"];
			$spg->setHtml( $tmp_html_page );
			$spg->SfStatus->StatusID = $_POST["status_id"];
			$spg->setHeader( $_POST["header"]);
			$spg->SfPageType->SetPageTypeID($_POST["typeid"]);
			$spg->setOrder($_POST["order"]);
			
			//izmena u slucaju da je html polje prazno tada stranicu tretiramo kao kategoriju
			//if(strlen($spg->Html) == 0 && $spg->SfPageType->TipStranicaID == "stranica") $spg->SfPageType->ID = "kategorija";
			
			if($spg->SfPageType->GetPageTypeID() == PAGE_TYPE_LINK)
			{
				//ukoliko dodajemo link moramo ispitati target i promeniti i taj slog u tabeli
				$spagelink = $ObjectFactory->createObject("StaticPageLink",-1);
				$spagelink->SPageID = $spg->getSPageID();
				$spagelink->Target = $_POST["target"];
				
				$DBBR->promeniSlog($spagelink);
			}
			$DBBR->promeniSlog($spg);
			
			echo "<div class='success'>".getTranslation("PLG_CHANGE_SUCCESS")."</div>";
		}
		else echo "<div class='error'>".getTranslation("PLG_CHANGE_FAILED")."</div>";
		
	}
	else echo "<div class='warning'>".getTranslation("PLG_NORIGHT")."</div>";
	
?>