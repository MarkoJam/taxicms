<?  
	/* CMS Studio 3.1 insert_tmpl_pre.php */
	
	$_ADMINPAGES = true;
	include_once("../../../config.php");

	global $smarty;
	global $auth;
	
	if(isset($_REQUEST['pageid']))
	{
		$tr = new Tree();
		
		$pageId = $_REQUEST['pageid'];
		
		$pg = $ObjectFactory->createObject("Page", $pageId); //array("Template","SfStatus","SfPageProtection","PageType")
			
		$pgCopy = new Page();
		$pgCopy->Page_COPY($pg);
		
		// fix properties
		$pgCopy->setHeader($pgCopy->getHeader() . " - " .getTranslation(PLG_COPY));
		$pgCopy->setOrder($tr->max_order($pg->getParentID()) + 1);
		// fix order number
		$DBBR->kreirajSlog($pgCopy);
		
		echo "<div class='success'>".getTranslation("PLG_COPY_SUCCESS")."</div>";
	}
	
	else echo "<div class='error'>".getTranslation("PLG_COPY_FAILED")."</div>";

?>