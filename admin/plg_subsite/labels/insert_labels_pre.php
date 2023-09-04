<?  
	/* CMS Studio 3.0 insert_pre.php */	

	$_ADMINPAGES = true;	
	include_once("../../config.php");
	
	global $smarty;
	global $auth;

	if($auth->isActionAllowed("ACTION_LABELS_CREATE"))
	{
		$poll = $ObjectFactory->createObject("Labels",-1);
		
		$poll->Header = getTranslation("PLG_INSERT");
		$poll->Description = getTranslation("PLG_INSERT");
		$poll->SfStatus->setStatusID(STATUS_LABELS_NEKATIVAN);
		$DBBR->kreirajSlog($poll); 

		header("Location: modify_poll.php?pollid=".$poll->PollID);
		exit();
	}
	else 
	{
		// show error message not enough rights
		$smarty->assign("norights_message",getTranslation("PLG_NORIGHT"));
		$smarty->display('../../templates/norights.tpl');
	}

?>