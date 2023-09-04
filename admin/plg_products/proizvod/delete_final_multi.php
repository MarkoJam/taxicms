<?
	/* CMS Studio 3.0 delete_final.php */
	
	$_ADMINPAGES = true;
	include_once("../../../config.php");
	include_once("../../../common/managers/ProductManager.php");
	
	global $smarty;
	global $auth;
	
	$productManager = new ProductManager();
	
	if($auth->isActionAllowed("ACTION_PRODUCT_DELETE"))
	{
		if(isset($_REQUEST["proizvodid"]) && count($_REQUEST["proizvodid"]) > 0 )
		{
			$cf = new CommonFilter();
			$proizvodIds = $_REQUEST["proizvodid"];
			
			foreach($proizvodIds as $proizvodId)
			{
				$cf->Reset();
				$cf->AddFilter("proizvodid", $proizvodId);
				$productManager->DeleteProizvod($cf);
			}
			
			echo "<div class='success'>".getTranslation("PLG_DELETE_SUCCESS")."</div>";
		}	
		else echo "<div class='error'>".getTranslation("PLG_CHANGE_FAILED")."</div>";
	}
	else echo "<div class='warning'>". getTranslation("PLG_NORIGHT")."</div>";
?>