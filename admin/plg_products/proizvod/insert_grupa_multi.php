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
		//$grupaProizvodaId = 36;
		$grupa = $ObjectFactory->createObject("PrGrupaProizvoda", $grupaProizvodaId);
		$proizvodiId = $_REQUEST["proizvodid"];
		//$proizvodiId = array(2790);
		$added = 0;
		$kgr=ltrim($grupa->getKitGroup());
		
		foreach($proizvodiId as $proizvodId)
		{
			$pass=1;
			if ($kgr==1)
			{
				$ObjectFactory->Reset();
				$ObjectFactory->AddFilter("proizvodid='".$proizvodId."' AND grupaproizvodaid ='" . $grupaProizvodaId . "'");		
				$pg = $ObjectFactory->createObjects("PrProizvodGrupaProiz");
				$ObjectFactory->Reset();
				if (count($pg)>0)
				{	
					$pgrupa=$pg[0];
					$pgrupa->setKitNum($pgrupa->getKitNum()+1);
					$DBBR->promeniSlog($pgrupa);
					$added++;
					$pass=0;
				}
			}
			if ($pass==1)
			{	
			$proizvodgrupaproiz = $ObjectFactory->createObject("PrProizvodGrupaProiz",-1);
			$proizvodgrupaproiz->GrupaProizvodaID = $grupaProizvodaId;
			$proizvodgrupaproiz->ProizvodID= $proizvodId;
			
			$DBBR->nadjiSlogVratiGa($proizvodgrupaproiz);

			if( $DBBR->con->num_rows == 0 ) 
			{
				$dummy_proizgrpproiz = $ObjectFactory->createObject("PrProizvodGrupaProiz",-1);
				$dummy_proizgrpproiz->GrupaProizvodaID = $grupaProizvodaId;
	
				$proizvodgrupaproiz->Order = $DBBR->vratiMaxPoUslovu($dummy_proizgrpproiz);
				$_SESSION["grupaproizvodaid_sel"] = $grupaProizvodaId;
				
				$proizvodgrupaproiz->GrupaProizvodaID = $grupaProizvodaId;
				$proizvodgrupaproiz->ProizvodID= $proizvodId;
				$DBBR->kreirajSlog($proizvodgrupaproiz);
				
				$added++;
			}
			}
		}
		
		if($added == 0) echo "<div class='error'>".getTranslation("PLG_CHANGE_FAILED")."</div>";
		else echo "<div class='success'>".getTranslation("PLG_CHANGE_SUCCESS")."</div>";
	}
	else echo "<div class='warning'>".getTranslation("PLG_NORIGHT")."</div>";
		
?>