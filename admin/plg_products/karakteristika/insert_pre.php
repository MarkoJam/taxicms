<?  
	/* CMS Studio 3.0 insert_pre.php */
	
	$_ADMINPAGES = true;
	include_once("../../../config.php");

	global $smarty;
	global $auth;
	
	if($auth->isActionAllowed("ACTION_PRODUCT_CHARTYPE_CREATE"))
	{	
		$prkarakteristikavrsta = $ObjectFactory->createObject("PrKarakteristikaVrsta",-1);
		$_REQUEST["karakteristika_vrsta_id"]=$DBBR->kreirajSlog($prkarakteristikavrsta); 
	}

?>