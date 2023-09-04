<?
	/* CMS Studio 4.1 delete_product_from_group.php */
	
	$_ADMINPAGES = true;
	include_once("../../../config.php");
	//include_once("../../../common/managers/ProductManager.php");
	
	global $smarty;
	global $auth;
	
	$ObjectFactory = ObjectFactory::getInstance();
	
	if($auth->isActionAllowed("ACTION_PRODUCT_GROUPPRODUCT_DELETE"))
	{
		if(isset($_REQUEST["obrisiParams"]))
		{
			$obrisiParams = $_REQUEST["obrisiParams"];
			$obrisiParamsArr = explode('-',$obrisiParams);
			
			$grupaProizvodaID = $obrisiParamsArr[0];
			$proizvodID = $obrisiParamsArr[1];
			
			$proizvodgrupaproiz = $ObjectFactory->createObject("PrProizvodGrupaProiz",-1);
			$proizvodgrupaproiz->ProizvodID = $proizvodID;
			$proizvodgrupaproiz->GrupaProizvodaID = $grupaProizvodaID;
			$DBBR->obrisiSlog($proizvodgrupaproiz);
			echo "<div class='success'>".getTranslation("PLG_DELETE_SUCCESS")."</div>";
		}
		else echo "<div class='error'>".getTranslation("PLG_CHANGE_FAILED")."</div>";
	}
	else echo "<div class='warning'>". getTranslation("PLG_NORIGHT")."</div>";

?>