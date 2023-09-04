<?
	/* CMS Studio 3.0 modify.php */
	
	$_ADMINPAGES = true;
	include_once("../../../config.php");

	global $smarty;
	global $auth;

	$ObjectFactory = ObjectFactory::getInstance();
	
	if($auth->isActionAllowed("ACTION_PRODUCTTYPE_MODIFY"))
	{
		if(($_REQUEST["mode"])=='insert') $_REQUEST["tipproizvodaid"]=-1;
		if ($_REQUEST['mode']=='insert2') 
		{
			$obj = $ObjectFactory->createObject("PrTipProizvoda");
			$colid=$DBBR->vratiPoslednjiID($obj);
			$col=$colid[0];
			$id=$colid[1];
			$_REQUEST[$col]=$_POST[$col]=$id;
		}		
		if(isset($_REQUEST["tipproizvodaid"]))
		{
			// deo za insertovanje novog sloga
			if(($_REQUEST["mode"])=='insert') $smarty->assign("mode", 'insert');
			else $smarty->assign("mode", 'edit');
			//u slucaju da zelimo samo da menjamo karakteristike trebalo bi da azuriramo promenjena
			// polja kategorije
			if(isset($_REQUEST["modifykarakt"]))
			{
				$tipproizvoda = $ObjectFactory->createObject("PrTipProizvoda",-1);
				$tipproizvoda->PrTipProizvoda_POST($_REQUEST);
				$DBBR->promeniSlog($tipproizvoda);
			}
					
			// factory metoda vraca kreiran objekat i napunjen sa karakteristikama
			$tipproizvoda = $ObjectFactory->createObject("PrTipProizvoda",$_REQUEST["tipproizvodaid"],array("PrKarakteristika"));
			if (isset($_REQUEST['title']) && isset($_REQUEST['description'])) 
			{
				$tipproizvoda->Naziv = $_REQUEST['title'];
				$tipproizvoda->Opis = $_REQUEST['description'];
			}			
			
			$smarty->assign($tipproizvoda->toArray());
			
			// ucitavanje vrsta karakteristka
			$vrsteKarakteristka = $ObjectFactory->createObjects("PrKarakteristikaVrsta");
			
			$shVrsteKarakteristika = new SmartyHtmlSelection("vrstekarakteristika",$smarty);
			foreach ($vrsteKarakteristka as $vk) 
			{
				$shVrsteKarakteristika->AddOutput($vk->getNaziv());
				$shVrsteKarakteristika->AddValue($vk->getKarakteristikaVrstaID());
			}

			$shVrsteKarakteristika->SmartyAssign();
				
			//deo za rad sa karakteristikama kategorije
			//ZA SLICICE GORE-DOLE
			$html_img_up = "<div class='btn btn-white'><i class='fa fa-chevron-up' aria-hidden='true'></i></div>";
			$html_img_down = "<div class='btn btn-white'><i class='fa fa-chevron-down' aria-hidden='true'></i></div>";
			$html_img_delete = "<div class='btn btn-white'><i class='fa fa-minus-square-o' aria-hidden='true'></i></div>";
			
			//ZA HEDER TABELE
			$tbl_header = array(
				getTranslation("PLG_CARACTERISTICS"), 
				getTranslation("PLG_CARACTERISTIC_TYPE"),
				getTranslation("PLG_UP"),
				getTranslation("PLG_DOWN"),
				getTranslation("PLG_DELETE")
			);
			$tbl_content = array();
			
			
			foreach($tipproizvoda->PrKarakteristika as $kar)
			{
				$karakteristikaVrsta = $ObjectFactory->createObject("PrKarakteristikaVrsta", $kar->PrKarakteristikaVrsta->KarakteristikaVrstaID);
				
				if(!isset($_REQUEST["karakteristikaid"]) || $_REQUEST["karakteristikaid"] != $kar->KarakteristikaID){
				$tbl_content = 
					array_merge($tbl_content, array(
									"<a class='naziv'  href=\"javascript:GETLinkPromeni('".$tipproizvoda->TipProizvodaID."','".$kar->KarakteristikaID."');\">".$kar->Naziv."</a>",
									$karakteristikaVrsta->getNaziv(),
									"<a id='move' data-link='move_arrow.php' data-param='direction=up&tipproizvodaid=".$tipproizvoda->TipProizvodaID."&".$kar->getLinkID()."'>".$html_img_up."</a>",
							  		"<a id='move' data-link='move_arrow.php' data-param='direction=down&tipproizvodaid=".$tipproizvoda->TipProizvodaID."&".$kar->getLinkID()."'>".$html_img_down."</a>",
									"<a href=\"javascript:GETLinkObrisi('".$tipproizvoda->TipProizvodaID."','".$kar->KarakteristikaID."');\">".$html_img_delete."</a>"
									));
				}
				else 
				{
					$tbl_content = array_merge($tbl_content, 
						array(
							'<input name="nazivkar" class="form-control" id="nazivkar" type="text" value="'.$kar->Naziv.'">',
							$karakteristikaVrsta->getNaziv(),
							'&nbsp;',
							'&nbsp;',
							"<div name='modifybutt' data-param='".$kar->KarakteristikaID."' id='modifybutt' class='btn btn-primary'><i class='fa fa-check'></i>&nbsp;".getTranslation("PLG_SAVE")."</div>")
							);
				}
			}
			if(count($tipproizvoda->PrKarakteristika) != 0){
				$smarty->assign("tbl_header", $tbl_header);
				$smarty->assign("tbl_content", $tbl_content);
			}
			else 
			{
				$smarty->assign("tbl_content", array(
					getTranslation("PLG_NONE")
					));
			}
		}
		$smarty->assign("tipproizvodaid",$tipproizvoda->TipProizvodaID);
		$smarty->display('modify.tpl');
	}
	else
	{
		// show error message not enough rights
		$smarty->assign("norights_message",getTranslation("PLG_NORIGHT"));
		$smarty->display('../../../templates/norights.tpl');
	}
?>
