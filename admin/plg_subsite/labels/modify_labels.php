<?
	/* CMS Studio 3.0 modify.php *///

	$_ADMINPAGES = true;
	include_once("../../config.php");
		
	global $smarty;
	global $auth;
	
	if($auth->isActionAllowed("ACTION_LABELS_MODIFY"))
	{
		if(isset($_REQUEST["pollid"]))
		{
			//punjenje i/ili postavljanje kategorijeid iz/u sesije
			
			$_SESSION["pollid"] = $_REQUEST["pollid"];
			
			$pollid = $_REQUEST["pollid"];
			
			if(isset($_REQUEST["modifypitanje"]))
			{
				$poll = $ObjectFactory->createObject("Poll",$pollid);
				$poll->Description = $_REQUEST["description"];
				$poll->Header = $_REQUEST["header"];
				$poll->SfStatus->setStatusID($_REQUEST["statusid"]);
				$DBBR->promeniSlog($poll);
			}
			
			$poll = $ObjectFactory->createObject("Poll", $pollid);
			
			// statusi
			$ObjectFactory->AddFilter(" tip_status_id = " . STATUS_TIP_PAGE);
			$statusi = $ObjectFactory->createObjects("SfStatus");
			
			$shStatus = new SmartyHtmlSelection("status",$smarty);
			foreach ($statusi as $s) 
			{
				$shStatus->AddOutput($s->getVrednost());
				$shStatus->AddValue($s->getStatusID());
			}
			$shStatus->AddSelected($poll->SfStatus->getStatusID());
			$shStatus->SmartyAssign();
			$ObjectFactory->ResetFilters();
					
			//ZA HEDER TABELE
			$ap = new AdminTable();
			$ap->SetRowCount(10);
			$ap->SetOffsetName("pollquestionoffset_".$poll->getPollID());
			
			$ap->SetHeader(
							array(
									getTranslation("PLG_QUESTION"),
									"&nbsp;",
									"&nbsp;",
									"Glasovi",
									getTranslation("DELETE")
							));

			
			$ObjectFactory->AddFilter("pollid=".$poll->getPollID());
			
			$ap->SetCountAllRows($DBBR->prebrojSveSlogove($ObjectFactory->createObject("PollQuestion",-1), $ObjectFactory->filters));
			$ap->SetBrowseString($ObjectFactory);			
			
			$ObjectFactory->AddLimit($ap->GetRowCount()); 
			$ObjectFactory->AddOffset($ap->GetOffset());
			
			$objlist = $ObjectFactory->createObjects("PollQuestion");
			
			if(!empty($objlist))
			{
				foreach($objlist as $pq)
				{
					if(!isset($_REQUEST["pollquestionid"]) || $_REQUEST["pollquestionid"] != $pq->PollQuestionID){
					
					$ap->AddTableRow(
									array(
												"<a class='naziv'  href=\"javascript:GETLinkPromeni('".$pollid."','".$pq->PollQuestionID."');\">".$pq->Title."</a>","&nbsp;",
												$pq->GroupPoll == 1 ? "Odgovor za prvo pitanje" : "Odgovor za drugo pitanje",
												$pq->Votes,
												"<a href=\"javascript:GETLinkObrisi('".$pollid."','".$pq->PollQuestionID."');\"><img border=0 src='../images/delete.gif'></a>",
									)
									);
					}
					else 
					{
										
						$ap->AddTableRow(
							array(
								'<input name="title" type="text" value="'.$pq->Title.'">',
								$pq->GroupPoll == 1 ? "Odgovor za prvo pitanje" : "Odgovor za drugo pitanje",
								'<input type="submit" name="modifybutt" id="modifybutt" value="Potvrdi">',
								'&nbsp;<input name="pollquestionid" type="hidden" value="'.$pq->PollQuestionID.'"><input name="votes" type="hidden" value="'.$pq->Votes.'">'));
					}
				}
			}
			$ap->RegisterAdminPage($smarty);
			
			$smarty->assign("poll",$poll->toArray());
	
		}
	
		//vrsi se popunjavanje svih potrebnih list boksov
		
		$smarty->display('modify_poll.tpl');
	}
	else 
	{
		// show error message not enough rights
		$smarty->assign("norights_message",getTranslation("PLG_NORIGHT"));
		$smarty->display('../../templates/norights.tpl');
	}

?>