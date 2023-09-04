<?
	/* CMS Studio 3.0 modify_final.php */
	
	$_ADMINPAGES = true;
	include_once("../../../config.php");
	
	global $smarty;
	global $auth;

	$ObjectFactory = ObjectFactory::getInstance();
	if($auth->isActionAllowed("ACTION_PRODUCT_GROUPPRODUCT_MODIFY"))
	{
		//insertovanje praznog sloga, umesto insert_pre.php
		if ($_REQUEST['mode']=='insert') require ("insert_pre.php");
		if(isset($_REQUEST["grupaproizvodaid"]))
		{
			$grupaproizvoda = $ObjectFactory->createObject("PrGrupaProizvoda",$_REQUEST["grupaproizvodaid"]);
			$grupaproizvoda->PrGrupaProizvoda_POST($_REQUEST);
			if (($_REQUEST['congroup'])=="on") $grupaproizvoda->ConGroup=1;
			else $grupaproizvoda->ConGroup=0;
			if (($_REQUEST['nlgroup'])=="on") $grupaproizvoda->NLGroup=1;
			else $grupaproizvoda->NLGroup=0;
			if (($_REQUEST['kitgroup'])=="on") $grupaproizvoda->KitGroup=1;
			else $grupaproizvoda->KitGroup=0;
		
			$DBBR->promeniSlog($grupaproizvoda);

			// azuriranje korisnickih popusta
			$ObjectFactory->Reset();
			$cats = $ObjectFactory->createObjects("SfUserCategory");
			$ObjectFactory->Reset();
			foreach ($cats as $cat) 
			{
				$id = $cat->ID;
				$name='cat'.$id;
				$upit ="DELETE FROM `ucategorygrupaproiz` WHERE `usercategoryid`=".$id." and `grupaproizvodaid`=".$_REQUEST["grupaproizvodaid"]."";
				$DBBR->con->query($upit);
				
				if ($_REQUEST[$name]>0) {
					$upit ="INSERT INTO `ucategorygrupaproiz`(`usercategoryid`, `grupaproizvodaid`, `discount`) VALUES (".$id.",".$_REQUEST["grupaproizvodaid"].",".$_REQUEST[$name].")";
					$DBBR->con->query($upit);
				}	
			}
			
			// potrebno je obrisati unos iz tabele proizvodgrupaproiz
			if(isset($_REQUEST["deleteproiz"]) && isset($_REQUEST["grupaproizvodaid"]) && isset($_REQUEST["proizvodid"]))
			{
				$proizvodgrupaproiz = $ObjectFactory->createObject("PrProizvodGrupaProiz",-1);
				$proizvodgrupaproiz->ProizvodID = $_REQUEST["proizvodid"];
				$proizvodgrupaproiz->GrupaProizvodaID = $_REQUEST["grupaproizvodaid"];
				$DBBR->obrisiSlog($proizvodgrupaproiz);
				header('Location: modify.php?grupaproizvodaid='.$_REQUEST["grupaproizvodaid"]);
				exit();
			}
			else
			{
				$parantidParam = "";
				if($grupaproizvoda->getParentID() != "" && $grupaproizvoda->getParentID() != -1) 
					$parantidParam = "&parentid=".$grupaproizvoda->getParentID();
				echo "<div class='success'>".getTranslation("PLG_CHANGE_SUCCESS")."</div>";
			}
		}
		else echo "<div class='error'>".getTranslation("PLG_CHANGE_FAILED")."</div>";
	}
	else echo "<div class='warning'>".getTranslation("PLG_NORIGHT")."</div>";
?>