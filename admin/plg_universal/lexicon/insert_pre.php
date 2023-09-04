<?  
	/* CMS Studio 3.0 insert_pre.php */
	
	$_ADMINPAGES = true;	
	include_once("../../../config.php");

	global $smarty;
	global $auth;
	
	if ($auth->isActionAllowed("ACTION_LEXICON_CREATE")) 
	{
		$lexiconPlugin = $ObjectFactory->createObject("Lexicon",-1);
		$lexiconPlugin->setHeader(getTranslation("PLG_LEXICON_INSERT_HEADER"));
		$lexiconPlugin->setHtml("<p>".getTranslation("PLG_LEXICON_INSERT_NEW_CONTENT")."</p>");
		$DBBR->kreirajSlog($lexiconPlugin); 
	}

?>