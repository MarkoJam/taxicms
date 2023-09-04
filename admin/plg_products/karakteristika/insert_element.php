<?
	/* CMS Studio 3.0 modify_final.php */
	
	$_ADMINPAGES = true;
	include_once("../../../config.php");

	global $smarty;
	global $auth;

	if($auth->isActionAllowed("ACTION_PRODUCT_CHARTYPE_MODIFY"))
	{	
		//insertovanje praznog sloga, umesto insert_pre.php
		if ($_REQUEST['mode']=='insert') 
		{
			require ("insert_pre.php");
			$obj = $ObjectFactory->createObject("PrKarakteristikaVrsta");
			$colid=$DBBR->vratiPoslednjiID($obj);
			$col=$colid[0];
			$id=$colid[1];
			$_REQUEST[$col]=$_POST[$col]=$id;
		}
		if(isset($_REQUEST["elementvrednost_add"]))
		{
			$element = $ObjectFactory->createObject("PrKarakteristikaElement",-1);
			$element->Vrednost = $_REQUEST["elementvrednost_add"];
			$element->PrKarakteristikaVrsta->KarakteristikaVrstaID = $_REQUEST["karakteristika_vrsta_id"];
			
			$DBBR->kreirajSlog($element);
			
			echo "<div class='success'>".getTranslation("PLG_ADD_SUCCESS")."</div>";
		}
		else echo "<div class='error'>".getTranslation("PLG_CHANGE_FAILED")."</div>";
		
	}
	else echo "<div class='warning'>".getTranslation("PLG_NORIGHT")."</div>";
	
?>