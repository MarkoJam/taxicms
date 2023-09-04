<?
	$_ADMINPAGES = true;
	include_once("../../../config.php");
	
	global $smarty;
	global $auth;

	$ObjectFactory = ObjectFactory::getInstance();	
	if($auth->isActionAllowed("ACTION_PRODUCTTYPE_MODIFY"))
	{

		//insertovanje praznog sloga, umesto insert_pre.php
		if ($_REQUEST['mode']=='insert') require ("insert_pre.php");
		if(isset($_REQUEST["tipproizvodaid"]))
		{
			$tipproizvoda = $ObjectFactory->createObject("PrTipProizvoda",$_REQUEST["tipproizvodaid"]);
			$tipproizvoda->PrTipProizvoda_POST($_REQUEST);
			
			$DBBR->promeniSlog($tipproizvoda);
		
			if(isset($_REQUEST["addbutt"]) )
			{	
				if(isset($_REQUEST["addbutt"]))
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
					
				}

				if(isset($_REQUEST["karakteristikaid"]))
				{
					$karakteristika = $ObjectFactory->createObject("PrKarakteristika",$_REQUEST["karakteristikaid"]);
					if($karakteristika->getKarakteristikaVrstaID() == "")
					{
						$karakteristika->setKarakteristikaVrstaID(-1);
					}
					$karakteristika->Naziv = $_REQUEST["nazivkar"];
					$DBBR->promeniSlog($karakteristika);
				}
			}
			echo "<div class='success'>".getTranslation("PLG_CHANGE_SUCCESS")."</div>";
		}
		else echo "<div class='error'>".getTranslation("PLG_CHANGE_FAILED")."</div>";		
	}
	else echo "<div class='warning'>".getTranslation("PLG_NORIGHT")."</div>";
?>