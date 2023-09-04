<?  
	/* CMS Studio 3.0 insert_pre.php */
	
	$_ADMINPAGES = true;	
	include_once("../../../config.php");

	global $smarty;
	global $auth;
	
	if ($auth->isActionAllowed("ACTION_UNIVERSAL_CREATE")) 
	{
		$universalPlugin = $ObjectFactory->createObject("UniversalPlugin",-1);
		$universalPlugin->setHeader(getTranslation("PLG_UNIVERSAL_INSERT_HEADER"));
		$universalPlugin->setHtml("<p>".getTranslation("PLG_UNIVERSAL_INSERT_NEW_CONTENT")."</p>");
		$DBBR->kreirajSlog($universalPlugin); 
	}

?>