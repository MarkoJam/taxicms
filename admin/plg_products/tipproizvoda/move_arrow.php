<?
	/* CMS Studio 3.0 move.php */
	
	$_ADMINPAGES = true;
	include_once("../../../config.php");

	global $smarty;
	global $auth;

	$ObjectFactory = ObjectFactory::getInstance();
	$LanguageHelper = LanguageHelper::getInstance();
	
	if($auth->isActionAllowed("ACTION_PRODUCTTYPE_MOVE"))
	{
		if(isset($_REQUEST["tipproizvodaid"]) && isset($_REQUEST["direction"]))
		{
			if(!isset($_REQUEST["karakteristikaid"])){
			
				$tipproizvodaid = $_REQUEST["tipproizvodaid"];
				$tipproizvoda = $ObjectFactory->createObject("PrTipProizvoda",-1);
				$tipproizvoda->TipProizvodaID = $tipproizvodaid;
				$DBBR->nadjiSlogVratiGa($tipproizvoda);
				
				$tipproizvoda_table = "pr_tipproizvoda";
				$LanguageHelper->ChangeTableName($tipproizvoda_table);
				
				switch($_REQUEST["direction"])
				{
					case "up":
							$row_new = $DBBR->con->get_row("SELECT * FROM ".$tipproizvoda_table." WHERE `tipproizvoda_order` < " .$tipproizvoda->Order." ORDER BY `tipproizvoda_order` DESC LIMIT 0,1");
							$row_new_count = $DBBR->con->num_rows;
						break;
					case "down":
							$row_new = $DBBR->con->get_row("SELECT * FROM ".$tipproizvoda_table." WHERE `tipproizvoda_order` > " .$tipproizvoda->Order." ORDER BY `tipproizvoda_order` ASC LIMIT 0,1");
							$row_new_count = $DBBR->con->num_rows;
						break;
				}
		
				if($row_new_count != 0)
				{
					$DBBR->con->query("UPDATE ".$tipproizvoda_table." SET `tipproizvoda_order`=".$tipproizvoda->Order." WHERE tipproizvodaid=".$row_new->tipproizvodaid);
					$DBBR->con->query("UPDATE ".$tipproizvoda_table." SET `tipproizvoda_order`=".$row_new->tipproizvoda_order." WHERE   tipproizvodaid=".$tipproizvoda->TipProizvodaID);
				}
			}
			
			if(isset($_REQUEST["karakteristikaid"]))
			{
				$karakteristikaid = $_REQUEST["karakteristikaid"];
				$tipproizvodaid = $_REQUEST["tipproizvodaid"];
				$karakteristika = $ObjectFactory->createObject("PrKarakteristika",-1);
				$karakteristika->PrTipProizvoda->TipProizvodaID = $tipproizvodaid;
				$karakteristika->KarakteristikaID = $karakteristikaid;
				$DBBR->nadjiSlogVratiGa($karakteristika);
				
				$karakteristika_table = "pr_karakteristika";
				$LanguageHelper->ChangeTableName($karakteristika_table);
				
				switch($_REQUEST["direction"])
				{
					case "up":
							$row_new = $DBBR->con->get_row("SELECT * FROM ".$karakteristika_table." WHERE tipproizvodaid=".$karakteristika->PrTipProizvoda->TipProizvodaID." AND `karakteristika_order` < " .$karakteristika->Order." ORDER BY `karakteristika_order` DESC LIMIT 0,1");
							$row_new_count = $DBBR->con->num_rows;
						break;
					case "down":
							$row_new = $DBBR->con->get_row("SELECT * FROM ".$karakteristika_table." WHERE tipproizvodaid=".$karakteristika->PrTipProizvoda->TipProizvodaID." AND `karakteristika_order` > " .$karakteristika->Order." ORDER BY `karakteristika_order` ASC LIMIT 0,1");
							$row_new_count = $DBBR->con->num_rows;
						break;
				}
		
				if($row_new_count != 0)
				{
					$DBBR->con->query("UPDATE ".$karakteristika_table." SET `karakteristika_order`=".$karakteristika->Order." WHERE tipproizvodaid=".$karakteristika->PrTipProizvoda->TipProizvodaID." AND karakteristikaid=".$row_new->karakteristikaid);
					$DBBR->con->query("UPDATE ".$karakteristika_table." SET `karakteristika_order`=".$row_new->karakteristika_order." WHERE tipproizvodaid=".$karakteristika->PrTipProizvoda->TipProizvodaID." AND karakteristikaid=".$karakteristika->KarakteristikaID);
				}
			}
			echo "<div class='success'>". getTranslation("PLG_MOVE_SUCCESS")."</div>";	
		}
		else echo "<div class='error'>". getTranslation("PLG_MOVE_FAILED")."</div>";	

	}
	else echo "<div class='warning'>". getTranslation("PLG_NORIGHT")."</div>";

?>