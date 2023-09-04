<?
	$_ADMINPAGES = true;
	include_once("../../../config.php");
		
	$kurs = $ObjectFactory->createObject("PrKurs",-1);
	$kurs->KursID = $_REQUEST["kursid"];
	$kurs->Kurs = $_REQUEST["kurs"];

	$DBBR->promeniSlog($kurs);
	echo "<div class='success'>".getTranslation("PLG_CHANGE_SUCCESS")."</div>";

?>