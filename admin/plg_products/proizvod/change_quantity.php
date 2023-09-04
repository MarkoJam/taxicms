<?
	/* CMS Studio 3.0 delete_final.php */

	$_ADMINPAGES = true;
	include_once("../../../config.php");
	
	global $smarty;
	global $auth;
	
	
	if(isset($_REQUEST['proizvodid']) && isset($_REQUEST['vproizvodid']))
	{
		$ObjectFactory->ResetFilters();
		$ObjectFactory->AddFilter("proizvodid = ".$_REQUEST['proizvodid']." AND vproizvodid = ".$_REQUEST['vproizvodid']);
		$prpr = $ObjectFactory->createObjects("PrProizvodProiz");
		$ObjectFactory->ResetFilters();
		foreach ($prpr as $proiz)
		{			
			$proiz->setKolicina($_REQUEST['kolicina']);
			$proizvod = $ObjectFactory->createObject("PrProizvod",$_REQUEST['vproizvodid']);
			echo $proizvod->getCenaA();
			$DBBR->promeniSlog($proiz);	
		}				
		//echo "<div class='success'>".getTranslation("PLG_CHANGE_SUCCESS")."</div>";	
	}
	//else echo "<div class='error'>".getTranslation("PLG_CHANGE_FAILED")."</div>";
	
?>