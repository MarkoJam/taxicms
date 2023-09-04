<?
	/* CMS Studio 3.0 move_grp.php */

	$_ADMINPAGES = true;
	include_once("../../../config.php");
	
	global $smarty;
	global $auth;
	
	if($auth->isActionAllowed("ACTION_SPAGE_MOVE"))
	{
		if(isset($_REQUEST["spage_id"]) && isset($_REQUEST["direction"]))
		{
			$spg = $ObjectFactory->createObject("StaticPage",$_REQUEST["spage_id"]);
			$tr = new Tree($spg);
			
			switch($_REQUEST["direction"])
			{
				case "up":
						$spage_id_switch = $tr->lower_order_nodeid_static($spg->getSPageID());
					break;
				case "down":
						$spage_id_switch = $tr->higher_order_nodeid_static($spg->getSPageID());
					break;
			}
			
			if($spage_id_switch <> -1 )
			{
				// order of the current static page
				$order_tmp = $spg->getOrder();
				$spg_switch = $ObjectFactory->createObject("StaticPage",$spage_id_switch);
				
				$spg->setOrder( $spg_switch->getOrder());
				$DBBR->promeniSlog($spg);
				
				$spg_switch->setOrder($order_tmp);
				$DBBR->promeniSlog($spg_switch);
			}
			
			header("Location: index.php");
		}
	}
	else 
	{
		// show error message not enough rights
		$smarty->assign("norights_message","Nemate prava da pomerate stavke menija. Obratite se administratoru sistema.");
		$smarty->display('../../templates/norights.tpl');
	}
?>