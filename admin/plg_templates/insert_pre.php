<?  
	/* CMS Studio 3.0 insert_tmpl_pre.php */
	
	$_ADMINPAGES = true;	
	include_once("../../config.php");

	global $smarty;
	global $auth;
	
	if($auth->isActionAllowed("ACTION_TEMPLATES_CREATE"))
	{
		$tmpl = $ObjectFactory->createObject("Template",-1);
		$tmpl->Title = getTranslation("PLG_INSERT");
		$tmpl->Description = getTranslation("PLG_INSERT");
		$DBBR->kreirajSlog($tmpl); //ovde se vrati objekat sa popunjenim $tmpl->TemplateId -jem
	}


?>