<?php 
	include_once("../../config.php");
		
	$DatabaseBroker = DatabaseBroker::getInstance();
	$ObjectFactory = ObjectFactory::getInstance();
	$LanguageHelper = LanguageHelper::getInstance();
	$KpGrupaProizvodaTree = new KpGrupaProizvodaTree ($LanguageHelper);
		
	$smarty = new Smarty();
	$smarty->compile_check = true;
	$smarty->debugging = false;
	
	$smarty->compile_dir = ROOT_HOME ."templates_c";
	
	$xmlConfig = new XMLConfig;
	$xmlConfig->Parse(ROOT_HOME."config/languages/lang_".$LanguageHelper->GetFileDesc().".xml");
	
	$LanguageArrayInternal = $xmlConfig->get("/product");
	if(count($LanguageArrayInternal["value"])> 0)
	{
		foreach ($LanguageArrayInternal["value"] as $key => $value)
		{
			$smarty->assign($key,$value);
		}
	}
	
	$grupaProizvodaId = $_REQUEST["grupaproizvodaid"];
	$proizvodjacSql = "";
	
	if(isset($_REQUEST["filters"]))
	{
		// status
		if(isset($_REQUEST["filters"]["status"]))
		{
			$statusSql = " AND p.status_id IN (";
			$statuses = $_REQUEST["filters"]["status"];
			foreach($statuses as $statusid => $value)
			{
				$statusSql .= quote_smart($statusid) . ",";
			}
			
			$statusSql = substr($statusSql,0, strlen($statusSql) -1) . ")";
		}
		
		// proizvodjac
		if(isset($_REQUEST["filters"]["proizvodjac"]))
		{
			$proizvodjacSql = " AND p.proizvodjacid IN (" ;
			$proizvodjaci = $_REQUEST["filters"]["proizvodjac"];
			foreach ($proizvodjaci as $proizvodjacId => $value)
			{
				$proizvodjacSql .= quote_smart($proizvodjacId) . ",";
			}
			
			$proizvodjacSql = substr($proizvodjacSql, 0, strlen($proizvodjacSql) - 1) . ")";
		}
		
		$karakteristikaSqlarray = array (); //vise upita za razlicite vrste karakteristika
		if(isset($_REQUEST["filters"]["karakteristika"]))
		{
			$karakteristikaSql = " AND kp1.karakteristika_element_id IN (";
			$karakteristike = $_REQUEST["filters"]["karakteristika"];
			$i=0;
			$begin=0;
			foreach($karakteristike as $karakteristikaId => $value)
			{
				$parts = explode("-",$karakteristikaId);
				if ($begin==0) {$sst=$_REQUEST["subtitle".$parts[0]]; $begin=1;}
				if ($sst<>($_REQUEST["subtitle".$parts[0]]))
				{
					$karakteristikaSql = substr($karakteristikaSql, 0, strlen($karakteristikaSql)-1). ")";	
					$karakteristikaSqlarray[$i]=$karakteristikaSql;
					$karakteristikaSql = " AND kp1.karakteristika_element_id IN (";	
					$i=$i+1;
				}
				$karakteristikaSql .= quote_smart($parts[0]). ",";
				$sst=$_REQUEST["subtitle".$parts[0]];		
			}
			$karakteristikaSql = substr($karakteristikaSql, 0, strlen($karakteristikaSql)-1). ")";
			$karakteristikaSqlarray[$i]=$karakteristikaSql;
		}
		
		if(isset($_REQUEST["filters"]["karakteristika-free"]))
		{
			$karakteristikeFreeSql = " AND (";
			$karakteristikeFree = $_REQUEST["filters"]["karakteristika-free"];
			foreach($karakteristikeFree as $karakteristikaFreeId => $value )
			{
				$parts = explode("-",$karakteristikaFreeId);
				$karakteristikeFreeSql .= " (kp1.karakteristikaid = " .quote_smart($parts[0]) . " AND kp1.vrednost = " . quote_smart($value) .") OR ";
			}
			
			$karakteristikeFreeSql = substr($karakteristikeFreeSql, 0, strlen($karakteristikeFreeSql)-4) . ")";
		}
	}
	
	$cenaOd = 0;
	$cenaDo = 100000000;
	if(isset($_REQUEST["cenaod"]) || isset($_REQUEST["cenado"]))
	{
		if(isset($_REQUEST["cenaod"])&& is_numeric($_REQUEST["cenaod"]))
		{
			$cenaOd = $_REQUEST["cenaod"];
		}
		
		if(isset($_REQUEST["cenado"])&& is_numeric($_REQUEST["cenado"]))
		{
			$cenaDo = $_REQUEST["cenado"];
		}
	}
	
	$grupaProizvoda = $ObjectFactory->createObject("PrGrupaProizvoda", $grupaProizvodaId);
	
	$query = " SELECT ".
				 " distinct p.* ". 
			 " FROM pr_proizvod p " . 
			 " LEFT JOIN pr_proizvodgrupaproiz pgp ON p.proizvodid = pgp.proizvodid " .
			 " LEFT JOIN pr_karakteristikaproizvoda kp1 ON kp1.proizvodid = p.proizvodid " .  
			 " WHERE 1=1 ". 
			 " AND pgp.grupaproizvodaid = " . quote_smart($grupaProizvodaId).
			 " AND " . 
				" CASE ".
					" WHEN p.	cenab = 0 THEN p.cenaa BETWEEN " . quote_smart($cenaOd) . " AND " . quote_smart($cenaDo) . 
					" ELSE p.cenab BETWEEN " . quote_smart($cenaOd) . " AND " . quote_smart($cenaDo) . " END ";
	
	if($proizvodjacSql != "") 
		$query .= $proizvodjacSql;
		
	if($statusSql != "") 
		$query .= $statusSql;
	
	$cnt=count($karakteristikaSqlarray);
	if ($cnt>0)
	{
		$query_array=array();
		$results = array();
		$proizvodi=array();
		$proizvodi = $ObjectFactory->createObjects("PrProizvod");
		foreach($karakteristikaSqlarray as $karakteristikaSql)
		{
			if($karakteristikaSql != "") $query_array[$i] = $query.$karakteristikaSql;
			if($karakteristikeFreeSql != "") $query_array[$i] .= $karakteristikeFreeSql; 
			$results = $DatabaseBroker->con->get_results($query_array[$i]);
			$pr = $ObjectFactory->createObject("PrProizvod", -1);			
			$proizvodi2 = array ();
			$pr->napuniNiz( $results, $proizvodi2 );
			$proizvodi3 = array ();
			$pr3 = array ();
			foreach($proizvodi2 as $pr2)
			{
				foreach($proizvodi as $pr1)
				{
					if ($pr1->getProizvodID()==$pr2->getProizvodID())  
					{
						$pr3 = $pr1->toArray();
						$proizvodi3[] = $pr1;
					}	
				}	
			}
			$proizvodi=$proizvodi3;
		}	
	}
	else 
	{	
		if($karakteristikeFreeSql != "")
		$query .= $karakteristikeFreeSql; 
		$results = $DatabaseBroker->con->get_results($query);
		$pr = $ObjectFactory->createObject("PrProizvod", -1);
		$proizvodi = array ();
		$pr->napuniNiz( $results, $proizvodi );	
	}
	$proizvodi_smarty = array();
	foreach($proizvodi as $proizvod)
	{	
		$link = new LinkKpProductDetails ( $LanguageHelper,$KpGrupaProizvodaTree, $
		->getTemplateID(), $proizvod->getProizvodID(), $grupaProizvoda->getGrupaProizvodaID(), 'w', $proizvod->getNaziv());
		$proizvod->SetLink ( $LanguageHelper->GetPrintLink ( $link ) );

		// definisanje linkova za dodavanja jednog proizvoda u korpu
		$linkAddOneProductToBasket = new LinkAddOneProductToBasket($lh, $proizvod->getProizvodID());
		$linkAddOne = $lh->GetPrintLink($linkAddOneProductToBasket);
		$proizvod->setAddOneLink($linkAddOne);

		$proizvodi_smarty[] = $proizvod->toArray();
	}
	
	$smarty->assign("status", $status);
	$smarty->assign("proizvodi",$proizvodi_smarty);
	$smarty->assign("ROOT_WEB", ROOT_WEB);
	$smarty->display(ROOT_HOME . "templates/products/productcatalog_ajax.tpl");
?>