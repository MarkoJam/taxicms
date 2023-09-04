<?
	/* CMS Studio 3.0 insert_grupa.php */
	
	$_ADMINPAGES = true;
	include_once("../../../config.php");

	global $smarty;
	global $auth;
	
	$ObjectFactory = ObjectFactory::getInstance();
	
	if($auth->isActionAllowed("ACTIONADD"))
	{
		$grupaProizvodaId = $_REQUEST["grupaproizvodaid"];
		$grupa = $ObjectFactory->createObject("PrGrupaProizvoda", $grupaProizvodaId);
		
		$proizvodId = $_REQUEST["proizvodid"];
		
		$proizvodgrupaproiz = $ObjectFactory->createObject("PrProizvodGrupaProiz",-1);
		$proizvodgrupaproiz->GrupaProizvodaID = $grupaProizvodaId;
		$proizvodgrupaproiz->ProizvodID= $proizvodId;
		
		$DBBR->nadjiSlogVratiGa($proizvodgrupaproiz);
		
		if( $DBBR->con->num_rows == 0 || $grupa->getKitGroup()==1) 
		{
			$dummy_proizgrpproiz = $ObjectFactory->createObject("PrProizvodGrupaProiz",-1);
			$dummy_proizgrpproiz->GrupaProizvodaID = $grupaProizvodaId;

			$proizvodgrupaproiz->Order = $DBBR->vratiMaxPoUslovu($dummy_proizgrpproiz);
			$_SESSION["grupaproizvodaid_sel"] = $grupaProizvodaId;
			
			$proizvodgrupaproiz->GrupaProizvodaID = $grupaProizvodaId;
			$proizvodgrupaproiz->ProizvodID= $proizvodId;
			$DBBR->kreirajSlog($proizvodgrupaproiz);
			
			echo "<div class='success'>".getTranslation("PLG_SELECTION_ADD_SUCCESS")."</div>";
		}
		else 
			echo "<div class='error'>".getTranslation("PLG_CHANGE_FAILED")."</div>";
	}
	else
	{
		echo "<div class='warning'>".getTranslation("PLG_NORIGHT")."</div>";
	}	
?>