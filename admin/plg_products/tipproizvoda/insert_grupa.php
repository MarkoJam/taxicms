<?
	/* CMS Studio 3.0 insert_grupa.php*/

	$_ADMINPAGES = true;
	include_once("../../../config.php");

	global $smarty;
	global $auth;

	$ObjectFactory = ObjectFactory::getInstance();
	
	if($auth->isActionAllowed("ACTION_PRODUCTTYPE_ADDGROUP"))
	{
		$tipproizvodagrupatipovaproiz = $ObjectFactory->createObject("PrTipProizvodaGrupaTipovaProiz",-1);
		$tipproizvodagrupatipovaproiz->GrupaTipovaProizvodaID = $_REQUEST["grupatipovaproizvodaid"];
		$tipproizvodagrupatipovaproiz->TipProizvodaID = $_REQUEST["tipproizvodaid"];
			
		$_SESSION["grupatipovaproizvodaid_sel"] = $_REQUEST["grupatipovaproizvodaid"];
		
		$DBBR->nadjiSlogVratiGa($tipproizvodagrupatipovaproiz);
		if( $DBBR->con->num_rows == 0 ) 
		{
			$tipproizvodagrupatipovaproiz->GrupaTipovaProizvodaID = $_REQUEST["grupatipovaproizvodaid"];
			$tipproizvodagrupatipovaproiz->TipProizvodaID= $_REQUEST["tipproizvodaid"];
			$DBBR->kreirajSlog($tipproizvodagrupatipovaproiz);
			$_SESSION["grupatipovaproizvodaid_sel"] = $_REQUEST["grupatipovaproizvodaid"];
			header("Location: index.php?insertgrp=true");
		} 
		else
		{
			header("Location: index.php?insertgrp=false");
		}
	}
	else
	{
		// show error message not enough rights
		$smarty->assign("norights_message",getTranslation("PLG_PRODUCT_TYPE_NORIGHT_CREATE"));
		$smarty->display('../../../templates/norights.tpl');
	}
?>