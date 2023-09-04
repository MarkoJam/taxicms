<?
	$_ADMINPAGES = true;
	include_once("../../../config.php");
		
	$popust = $ObjectFactory->createObject("PrPopust",-1);
	$popust->PopustID = $_REQUEST["popustid"];
	$popust->Popust = $_REQUEST["popust"];

	$DBBR->promeniSlog($popust);
	echo "<div class='success'>".getTranslation("PLG_CHANGE_SUCCESS")."</div>";
?>