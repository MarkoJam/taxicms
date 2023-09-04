<?  
	/* CMS Studio 3.0 insert_ncateg_pre.php */
	
	//skript koji se poziva neposredno pre unosa elemenata kategorije vesti	
	$_ADMINPAGES = true;
	include_once("../../../config.php");
	
	global $smarty;
	global $auth;
	global $LanguageArray;
	
	if($auth->isActionAllowed("ACTION_NEWS_CATEGORY_CREATE"))
	{
		$nc = $ObjectFactory->createObject("NewsCategory",-1);
		$nc->Title = $LanguageArray["value"]["PLG_NEWS_CATEGORY_INSERT_NEW"];
		$nc->MessageNum = 10;
		$nc->Status = "online";
		$DBBR->kreirajSlog($nc); //ovde se vrati objekat sa popunjenim Id-jem
	}

?>