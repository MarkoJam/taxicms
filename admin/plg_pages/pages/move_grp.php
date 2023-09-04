<?
	/* CMS Studio 3.0 move_grp.php */
	
	$_ADMINPAGES = true;
	include_once("../../../config.php");
	
	global $smarty;
	global $auth;
	global $LanguageArray;
	
	if($auth->isActionAllowed("ACTION_PAGE_MOVE"))
	{
		if(isset($_REQUEST["page_id"]) && isset($_REQUEST["direction"]))
		{
			$tr = new Tree();
			$pg = $ObjectFactory->createObject("Page",$_REQUEST["page_id"]);
			
			switch($_REQUEST["direction"])
			{
				case "up":
						$page_id_switch = $tr->lower_order_nodeid($pg->getPageID());
					break;
				case "down":
						$page_id_switch = $tr->higher_order_nodeid($pg->getPageID());
					break;
			}
			
			if($page_id_switch <> -1 )
			{
				$order_tmp = $pg->getOrder();
				$pg_switch = $ObjectFactory->createObject("Page", $page_id_switch);
				
				$pg->setOrder($pg_switch->getOrder());
				$DBBR->promeniSlog($pg);
				
				$pg_switch->setOrder($order_tmp);
				$DBBR->promeniSlog($pg_switch);
			}
			//header("Location: frm_content.php?reload=1&page_id=".$pg->getParentID());
		}
	}
	else 
	{
		// show error message not enough rights
		$smarty->assign("norights_message",$LanguageArray["value"]["PLG_NORIGHT"]);
		$smarty->display('../../templates/norights.tpl');
	}
?>