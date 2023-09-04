<?  
	/* CMS Studio 3.0 insert_pre.php */
	
	$_ADMINPAGES = true;
	include_once("../../../config.php");
		
	global $smarty;
	global $auth;
	
	$ObjectFactory = ObjectFactory::getInstance();
	
	if($auth->isActionAllowed("ACTION_PRODUCTMANUFACTURER_CREATE"))
	{
		$proizvodjac = $ObjectFactory->createObject("PrProizvodjac",-1);
		$_REQUEST["proizvodjacid"]=$DBBR->kreirajSlog($proizvodjac); 
	}

	
?>