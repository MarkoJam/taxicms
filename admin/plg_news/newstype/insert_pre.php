<?  
	/* CMS Studio 3.0 insert_ncateg_pre.php */
	
	//skript koji se poziva neposredno pre unosa elemenata kategorije vesti	
	$_ADMINPAGES = true;
	include_once("../../../config.php");
	
	global $smarty;
	global $auth;
	global $LanguageArray;
	
	if($auth->isActionAllowed("ACTION_NEWS_TYPE_CREATE"))
	{
		$nwType = $ObjectFactory->createObject("NewsType",-1);
		$nwType->setTitle($LanguageArray["value"]["PLG_NEWS_TYPE_INSERT_NEW"]);
		$nwType->setDescription("Bez opisa");
		$DBBR->kreirajSlog($nwType); //ovde se vrati objekat sa popunjenim Id-jem
	}

?>