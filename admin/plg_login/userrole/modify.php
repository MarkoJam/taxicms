<?
	/* CMS Studio 3.0 modify.php */

	$_ADMINPAGES = true;
	include_once("../../../config.php");

	global $smarty;
	global $auth;
	
	if($auth->isActionAllowed("ACTION_LOGIN_MODIFY"))
	{
		if(isset($_REQUEST["mode"])) $_REQUEST["userroleid"]=-1;				
		if(isset($_REQUEST["userroleid"]))			
		{
			// deo za insertovanje novog sloga
			if(isset($_REQUEST["mode"])) $smarty->assign("mode", 'insert');
			else $smarty->assign("mode", 'edit');			
			$userrole= $ObjectFactory->createObject("UserRole",$_REQUEST["userroleid"],array("User"));
			$smarty->assign($userrole->toArray());
			
			// ZA PRIKAZ USER-a U OKVIRU ROLA
			$ap = new AdminTable();

			$objlist = $userrole->User;
			
			$ap->SetTitle("Ažuriranje usera:<br/><br/>");
			$ap->SetHeader(array(
							getTranslation("PLG_NAME"),
							getTranslation("PLG_FIRM"),
							getTranslation("PLG_EMAIL"),
							getTranslation("PLG_DELETE")
			));
			
			$ap->SetOffsetName("offset_userrolem".$_REQUEST["userroleid"]);
			$ap->AddBrowseString("userroleid=".$_REQUEST["userroleid"]);

			$ap->SetCountAllRows(count($objlist));

			$html_img_delete = "<div class='btn btn-white'><i class='fa fa-trash'></i></div>";
		
			//ZA SADRZAJ TABELE
			if(count($objlist) != 0)
			{
				$i = 0;
				foreach($objlist as $odo)
				{
					if($i >= $ap->GetOffset())
					{
					
						$delete_link = "<a id='delete_plugin' data-param='action=delete&".$userrole->getLinkID()."&".$odo->getLinkID()."'>".$html_img_delete."</a>";
						$ap->AddTableRow(array( $odo->Name." ".$odo->Surname.'&nbsp;',$odo->Firm, $odo->Email, $delete_link));

					}
					$i++;
				}
			}
			else
			{
				$ap->AddTableRow( array(
									getTranslation("PLG_NONE")
					));
			}
			$ap->RegisterAdminPage($smarty);
		}
			
		$smarty->display('modify.tpl');
	}
	else 
	{
		// show error message not enough rights
		$smarty->assign("norights_message",getTranslation("PLG_NORIGHT"));
		$smarty->display('../../templates/norights.tpl');	
	}
?>