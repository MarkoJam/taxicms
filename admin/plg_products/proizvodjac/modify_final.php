<?
	/* CMS Studio 3.0 modify_final.php */
	
	$_ADMINPAGES = true;
	include_once("../../../config.php");
	
	global $smarty;
	global $auth;

	$ObjectFactory = ObjectFactory::getInstance();
	
	if($auth->isActionAllowed("ACTION_PRODUCTMODIFY"))
	{
		//insertovanje praznog sloga, umesto insert_pre.php
		if ($_REQUEST['mode']=='insert') require ("insert_pre.php");
		if(isset($_REQUEST["proizvodjacid"]))
		{
			$proizvodjac = $ObjectFactory->createObject("PrProizvodjac",$_REQUEST["proizvodjacid"]);
			$proizvodjac->PrProizvodjac_POST($_POST);
			$DBBR->promeniSlog($proizvodjac);
			echo "<div class='success'>".getTranslation("PLG_CHANGE_SUCCESS")."</div>";
		}
		else echo "<div class='error'>".getTranslation("PLG_CHANGE_FAILED")."</div>";
		
	}
	else echo "<div class='warning'>".getTranslation("PLG_NORIGHT")."</div>";
		
?>
