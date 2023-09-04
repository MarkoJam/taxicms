<?
	/* CMS Studio 3.0 delete_final.php */
	
	$_ADMINPAGES = true;
	include_once("../../../config.php");
	include_once("../../../common/managers/ProductManager.php");
	
	global $smarty;
	global $auth;
	
	$productManager = new ProductManager();
	
	if($auth->isActionAllowed("ACTION_PRODUCT_GROUPPRODUCT_DELETE"))
	{
		if(isset($_REQUEST["proizvodid"]) && is_numeric($_REQUEST["proizvodid"]))
		{
			$cf = new CommonFilter();
			$cf->AddFilter("proizvodid", $_REQUEST["proizvodid"]);
			$productManager->DeleteProizvod($cf);
			
			echo "<div class='success'>".getTranslation("PLG_DELETE_SUCCESS")."</div>";
		}	
		else echo "<div class='error'>".getTranslation("PLG_CHANGE_FAILED")."</div>";
	}
	else echo "<div class='warning'>". getTranslation("PLG_NORIGHT")."</div>";
?>