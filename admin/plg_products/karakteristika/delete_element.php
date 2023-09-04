<?
	/* CMS Studio 3.0 modify_final.php */
	
	$_ADMINPAGES = true;
	include_once("../../../config.php");

	global $smarty;
	global $auth;

	if($auth->isActionAllowed("ACTION_PRODUCT_CHARTYPE_MODIFY"))
	{
		if(isset($_REQUEST["karakteristikaelementid"]))
		{
			$element = $ObjectFactory->createObject("PrKarakteristikaElement",$_REQUEST["karakteristikaelementid"]);
			$DBBR->obrisiSlog($element);
			echo "<div class='success'>".getTranslation("PLG_DELETE_SUCCESS")."</div>";
		}	
		else echo "<div class='error'>".getTranslation("PLG_CHANGE_FAILED")."</div>";
	}
	else echo "<div class='warning'>".getTranslation("PLG_NORIGHT")."</div>";
?>