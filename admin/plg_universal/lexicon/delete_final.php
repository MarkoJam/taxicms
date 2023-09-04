<?	
	/* CMS Studio 3.0 delete_final.php */
	
	$_ADMINPAGES = true;
	include_once("../../../config.php");

	global $smarty;
	global $auth;
	
	if($auth->isActionAllowed("ACTION_LEXICON_DELETE"))
	{
		if(isset($_REQUEST["lexiconid"]))
		{
			$lexiconPlugin = $ObjectFactory->createObject("Lexicon",-1);
			$lexiconPlugin->LexiconID = $_REQUEST["lexiconid"];
			$DBBR->obrisiSlog($lexiconPlugin);

			echo "<div class='success'>".getTranslation("PLG_DELETE_SUCCESS")."</div>";
		}
		else echo "<div class='error'>".getTranslation("PLG_CHANGE_FAILED")."</div>";
	}
	else echo "<div class='warning'>". getTranslation("PLG_NORIGHT")."</div>";
?>