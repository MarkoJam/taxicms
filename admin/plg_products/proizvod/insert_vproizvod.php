<?
	/* CMS Studio 3.0 insert_plugin.php */

	$_ADMINPAGES = true;
	include_once("../../../config.php");

	global $smary;
	global $auth;


		//insertovanje praznog sloga, umesto insert_pre.php
		if ($_REQUEST['mode']=='insert') 
		{
			//require ("insert_pre.php");
			$obj = $ObjectFactory->createObject("PrProizvod");
			$colid=$DBBR->vratiPoslednjiID($obj);
			$col=$colid[0];
			$id=$colid[1];
			$_REQUEST[$col]=$_POST[$col]=$id+1;
		}
		if (isset($_REQUEST['proizvodid']) && isset($_REQUEST['vproizvodid']))
		{
			$prpr = $ObjectFactory->createObject("PrProizvodProiz",-1);
			$prpr->VProizvodID = $_REQUEST['vproizvodid'];
			$prpr->ProizvodID = $_REQUEST['proizvodid'];
			$prpr->Kolicina = 0;
			$DBBR->kreirajSlog($prpr);
			$proizvod = $ObjectFactory->createObject("PrProizvod",$_REQUEST['vproizvodid']);
			echo $proizvod->getCenaA();			
			//echo "<div class='success'>".getTranslation("PLG_ADD_SUCCESS")."</div>";	
		}
		//else echo "<div class='error'>".getTranslation("PLG_CHANGE_CONECTED_FAILED")."</div>";
									

?>