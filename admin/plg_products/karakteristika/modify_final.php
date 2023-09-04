<?
	/* CMS Studio 3.0 modify_final.php */
	
	$_ADMINPAGES = true;
	include_once("../../../config.php");

	global $smarty;
	global $auth;

	if($auth->isActionAllowed("ACTION_PRODUCT_CHARTYPE_MODIFY"))
	{
		//insertovanje praznog sloga, umesto insert_pre.php
		if ($_REQUEST['mode']=='insert') require ("insert_pre.php");
		if(isset($_REQUEST["karakteristika_vrsta_id"]))
		{			
			$karaktVrstaID = $_REQUEST["karakteristika_vrsta_id"];
			
			$prkarakteristikavrsta = $ObjectFactory->createObject("PrKarakteristikaVrsta",$_REQUEST["karakteristika_vrsta_id"]);
			$prkarakteristikavrsta->PrKarakteristikaVrsta_POST($_REQUEST);
			
			$DBBR->promeniSlog($prkarakteristikavrsta);
			
			if(isset($_REQUEST["action_add"]) || isset($_REQUEST["action_delete"]) || isset($_REQUEST["action_modify"]))
			{
				if(isset($_REQUEST["action_add"]) && isset($_REQUEST["elementvrednost_add"]) && $_REQUEST["elementvrednost_add"] != "")
				{
					$element = $ObjectFactory->createObject("PrKarakteristikaElement",-1);
					$element->Vrednost = $_REQUEST["elementvrednost_add"];
					$element->PrKarakteristikaVrsta->KarakteristikaVrstaID = $karaktVrstaID;
					
					$DBBR->kreirajSlog($element);
					
					echo "<div class='success'>".getTranslation("PLG_CHANGE_SUCCESS")."</div>";
				}
				
				if(isset($_REQUEST["action_modify"]) && isset($_REQUEST["karakteristikaelementid"]))
				{
					$element = $ObjectFactory->createObject("PrKarakteristikaElement",$_REQUEST["karakteristikaelementid"]);
					$element->Vrednost = $_REQUEST["elementvrednost_mod"];
					
					$DBBR->promeniSlog($element);
					
					echo "<div class='success'>".getTranslation("PLG_CHANGE_SUCCESS")."</div>";
				}
				
				if(isset($_REQUEST["action_delete"]) && isset($_REQUEST["karakteristikaelementid"]))
				{
					$element = $ObjectFactory->createObject("PrKarakteristikaElement",$_REQUEST["karakteristikaelementid"]);
					$DBBR->obrisiSlog($element);
					
					echo "<div class='success'>".getTranslation("PLG_CHANGE_SUCCESS")."</div>";
				}	
			}
			echo "<div class='success'>".getTranslation("PLG_CHANGE_SUCCESS")."</div>";
		}
		else echo "<div class='error'>".getTranslation("PLG_CHANGE_FAILED")."</div>";
	}
	else echo "<div class='warning'>".getTranslation("PLG_NORIGHT")."</div>";
?>