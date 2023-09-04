<?
	/* CMS Studio 2.0 index.php */
	$_ADMINPAGES = true;
	include_once("../../../config.php");
	
	global $smarty;
	global $auth;	
	
	$kurs = $ObjectFactory->createObject("PrKurs",1);

	$smarty->assign("kurs",$kurs->Kurs);
	$smarty->assign("kursid",$kurs->KursID);
	if(isset($_REQUEST["message"])) $smarty->assign("message",$_REQUEST["message"]);
	
	$smarty->display('index.tpl');	
	
?>