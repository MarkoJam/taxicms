<?
	$_ADMINPAGES = true;
	include_once("../../../config.php");
	
	global $smarty;
	global $auth;

	$ObjectFactory = ObjectFactory::getInstance();
	
	if($auth->isActionAllowed("ACTION_PRODUCTTYPE_MODIFY"))
	{
	
		if(isset($_REQUEST["karakteristikaid"]))
		{
			$karakteristika = $ObjectFactory->createObject("PrKarakteristika",$_REQUEST["karakteristikaid"]);
			if($karakteristika->getKarakteristikaVrstaID() == "")
			{
				$karakteristika->setKarakteristikaVrstaID(-1);
			}
			$karakteristika->Naziv = $_REQUEST["nazivkar"];
			$DBBR->promeniSlog($karakteristika);
			echo "<div class='success'>".getTranslation("PLG_CHANGE_SUCCESS")."</div>";
		}
		else echo "<div class='error'>".getTranslation("PLG_CHANGE_FAILED")."</div>";		
	}
	else echo "<div class='warning'>".getTranslation("PLG_NORIGHT_MODIF")."</div>";
?>