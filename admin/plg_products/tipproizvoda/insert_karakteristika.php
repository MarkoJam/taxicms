<?
	$_ADMINPAGES = true;
	include_once("../../../config.php");
	
	global $smarty;
	global $auth;

	$ObjectFactory = ObjectFactory::getInstance();
	
	if($auth->isActionAllowed("ACTION_PRODUCTTYPE_MODIFY"))
	{
		//insertovanje praznog sloga, umesto insert_pre.php
		if ($_REQUEST['mode']=='insert') 
		{
			require ("insert_pre.php");
			$obj = $ObjectFactory->createObject("PrTipProizvoda");
			$colid=$DBBR->vratiPoslednjiID($obj);
			$col=$colid[0];
			$id=$colid[1];
			$_REQUEST[$col]=$_POST[$col]=$id;
		}		
		if(isset($_REQUEST["karakteristikavrstaid"]))
		{
			
			$karakteristika = $ObjectFactory->createObject("PrKarakteristika",-1);
			$karakteristika->Naziv = $_REQUEST["nazivkarnovo"];
			$karakteristika->PrTipProizvoda->TipProizvodaID = $_REQUEST["tipproizvodaid"];
			if(isset($_REQUEST["karakteristikavrstaid"]) && $_REQUEST["karakteristikavrstaid"] != _TYPE_FREE)
			{
				$karakteristika->setKarakteristikaVrstaID($_REQUEST["karakteristikavrstaid"]);
			}
			else $karakteristika->setKarakteristikaVrstaID(-1);
			
			$dummy_karakteristika = $ObjectFactory->createObject("PrKarakteristika",-1);
			$dummy_karakteristika->PrTipProizvoda->TipProizvodaID = $_REQUEST["tipproizvodaid"];
			
			$karakteristika->Order = $DBBR->vratiMaxPoUslovu($dummy_karakteristika);
			$DBBR->kreirajSlog($karakteristika);
			echo "<div class='success'>".getTranslation("PLG_ADD_SUCCESS")."</div>";
		}
		else echo "<div class='error'>".getTranslation("PLG_CHANGE_FAILED")."</div>";
	}
	else echo "<div class='warning'>".getTranslation("PLG_NORIGHT")."</div>";
?>