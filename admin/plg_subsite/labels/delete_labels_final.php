<?
	/* CMS Studio 3.0 delete_final.php */

	$_ADMINPAGES = true;
	include_once("../../config.php");
	
	global $smarty;
	global $auth;
	
	if($auth->isActionAllowed("ACTION_LABELS_DELETE"))
	{
		if(isset($_REQUEST["id"]))
		{
			$labels= $ObjectFactory->createObject("Labels",$_REQUEST["id"]);
			
	
				$DBBR->obrisiSlog($labels);

			
			//$DBBR->obrisiSlog($id);
			
			header('Location: index.php?statusmessage=delete_success');
			exit();
		}
		else 
		{
			header('Location: index.php?statusmessage=failed');
			exit();
		}
	}
	else
	{
		// show error message not enough rights
		$smarty->assign("norights_message", getTranslation("PLG_NORIGHT"));
		$smarty->display('../../templates/norights.tpl');
	}
?>