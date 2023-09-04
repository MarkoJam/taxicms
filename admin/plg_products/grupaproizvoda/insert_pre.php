<?  
	/* CMS Studio 3.0 insert_pre.php */
	
	$_ADMINPAGES = true;
	include_once("../../../config.php");
		
	global $smarty;
	global $auth;
	
	$ObjectFactory = ObjectFactory::getInstance();
	
	if($auth->isActionAllowed("ACTION_PRODUCT_GROUPPRODUCT_CREATE"))
	{
		$parentid = -1;
		$parentIdQuery = "";
		if(isset($_REQUEST["parentid"]))
		{ 
			$parentid = $_REQUEST["parentid"];
			$parentIdQuery = " AND parentid = ". $parentid;
		}
		else 
		{
			$parentIdQuery = " AND parentid is NULL " ;
		}
		
		$grupaproizvoda = $ObjectFactory->createObject("PrGrupaProizvoda",-1);
		$grupaproizvoda->setParentID($parentid);
		
		$upit = "SELECT MAX(grupaproizvoda_order) as max FROM ".$grupaproizvoda->vratiImeKlase()." WHERE 1=1 " . $parentIdQuery;
		$result_row = $DBBR->con->get_row($upit);
		
		$grupaproizvoda->setGrupaProizvodaOrder($result_row->max + 1);
		$grupaproizvoda->setNaziv("Naziv grupe proizvoda");
		//$grupaproizvoda->setOpis("Opis grupe proizvoda");
		$grupaproizvoda->setTemplateID(-1);
		$grupaproizvoda->setStatusID(STATUS_PRODUCTGROUP_NEAKTIVAN);
		$_REQUEST["grupaproizvodaid"]=$DBBR->kreirajSlog($grupaproizvoda); 
	}
	
?>