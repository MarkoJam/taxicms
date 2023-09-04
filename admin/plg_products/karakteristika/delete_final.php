<?
	/* CMS Studio 3.0 delete_final.php */
	
	$_ADMINPAGES = true;
	include_once("../../../config.php");
	
	global $smarty;
	global $auth;
	
	if($auth->isActionAllowed("ACTION_PRODUCT_CHARTYPE_DELETE"))
	{
		if(isset($_REQUEST["karakteristika_vrsta_id"]))
		{
			$prkarakteristikavrsta = $ObjectFactory->createObject("PrKarakteristikaVrsta",$_REQUEST["karakteristika_vrsta_id"]);
			$DBBR->obrisiSlog($prkarakteristikavrsta);
					
			echo "<div class='success'>".getTranslation("PLG_DELETE_SUCCESS")."</div>";
		}
		else echo "<div class='error'>".getTranslation("PLG_CHANGE_FAILED")."</div>";
	}
	else echo "<div class='warning'>". getTranslation("PLG_NORIGHT")."</div>";
?>