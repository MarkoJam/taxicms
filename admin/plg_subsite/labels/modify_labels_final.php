<?
	/* CMS Studio 3.0 modify_final.php */
	
	$_ADMINPAGES = true;
	include_once("../../config.php");

	global $smarty;
	global $auth;

	if($auth->isActionAllowed("ACTION_LABELS_MODIFY"))
	{
		$poll = $ObjectFactory->createObject("Poll",-1);
		$poll->Poll_POST($_POST);
		$DBBR->promeniSlog($poll);
	
		if(isset($_REQUEST["addbutt"]) || isset($_REQUEST["modifybutt"]) || isset($_REQUEST["modifyfinbutt"]))
		{	
			if(isset($_REQUEST["addbutt"]))
			{
				$pquest = $ObjectFactory->createObject("PollQuestion",-1);
				$pquest->Title = $_REQUEST["titled"];
				$pquest->GroupPoll = $_REQUEST["grouppoll"];
				$pquest->PollID= $_REQUEST["pollid"];
				$DBBR->kreirajSlog($pquest);
	 				
				header('Location: modify_poll.php?pollid='.$poll->PollID);
				exit();
			}
		
			if(isset($_REQUEST["modifybutt"]) || isset($_REQUEST["modifyfinbutt"]))
			{
				if(isset($_REQUEST["pollquestionid"]))
				{
					$pquest = $ObjectFactory->createObject("PollQuestion",-1);
					$pquest->PollQuestionID = $_REQUEST["pollquestionid"];
					$pquest->Title = $_REQUEST["title"];
					$pquest->GroupPoll = $_REQUEST["grouppoll"];
					$pquest->PollID = $_REQUEST["pollid"];
					$pquest->Votes = $_REQUEST["votes"];
					$DBBR->promeniSlog($pquest);
				}
				
				if(isset($_REQUEST["modifybutt"])) header('Location: modify_poll.php?pollid='.$poll->PollID);
				if(isset($_REQUEST["modifyfinbutt"])) header('Location: index.php?statusmessage=modify_success');
				exit();
			}
			
			header('Location: index.php?statusmessage=failed');
		}
	}
	else
	{
		// show error message not enough rights
		$smarty->assign("norights_message",getTranslation("PLG_NORIGHT"));
		$smarty->display('../../templates/norights.tpl');
	}
?>
		