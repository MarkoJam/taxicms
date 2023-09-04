<?
	/* CMS Studio 3.0 modify.php */
	
	$_ADMINPAGES = true;
	include_once("../../../config.php");
		
	global $smarty;
	global $auth;
	
	if($auth->isActionAllowed("ACTION_USER_MODIFY"))
	{
		if(($_REQUEST["mode"])=='insert') $_REQUEST["adminusergroupid"]=-1;
		if ($_REQUEST['mode']=='insert2') 
		{
			$obj = $ObjectFactory->createObject("AdminUserGroup");
			$colid=$DBBR->vratiPoslednjiID($obj);
			$col=$colid[0];
			$id=$colid[1];
			$_REQUEST[$col]=$_POST[$col]=$id;
			$_REQUEST["adminusergroupid"]=$id;			
		}			
		if(isset($_REQUEST["adminusergroupid"]))
		{
			// deo za insertovanje novog sloga
			if(($_REQUEST["mode"])=='insert') $smarty->assign("mode", 'insert');
			else $smarty->assign("mode", 'edit');
			
			$usergroup = $ObjectFactory->createObject("AdminUserGroup",$_REQUEST["adminusergroupid"],array("AdminUserAction"));
			if (isset($_REQUEST['title']) && isset($_REQUEST['description'])) 
			{
				$usergroup->Title = $_REQUEST['title'];
				$usergroup->Description = $_REQUEST['description'];
			}
			$smarty->assign($usergroup->toArray());
			
			// punjenje comboboxova za UserActions
			$useraction_arr = $ObjectFactory->createObjects("AdminUserAction",array("Plugin"));

			$shUserAction = new SmartyHtmlSelection("adminuseraction", $smarty);
			if(count($useraction_arr)>0)
			{
				foreach ($useraction_arr as $useraction)
				{
					if($useraction->Plugin->Active == "true")
					{
						$shUserAction->AddOutput($useraction->Title);
						$shUserAction->AddValue($useraction->AdminUserActionID);
					}
				}
			}
			$shUserAction->SmartyAssign();
			
			$admTbl = new AdminTable();
			
			$admTbl->SetTitle("Azuriranje korisničih akcija:");
			$admTbl->SetHeader(array(
									getTranslation("PLG_NAME"),
									getTranslation("PLG_DESCRIPTION"),
									getTranslation("PLG_CODE"),
									getTranslation("PLG_DELETE")
			));
			$admTbl->SetOffsetName("offset_usergroupactionm".$usergroup->AdminUserGroupID);
			
			$admTbl->AddBrowseString("adminusergroupid=".$usergroup->AdminUserGroupID);
			$admTbl->SetCountAllRows(count($usergroup->AdminUserAction));
			
			if(count($usergroup->AdminUserAction))
			{
				$i = 0;
				foreach ($usergroup->AdminUserAction as $useraction)
				{
					if($i >= $admTbl->GetOffset())
					{
					
						$modify_link = "<b>".$useraction->Title. "</b>" ;
						$html_img_delete = "<i class='fa fa-minus-square-o' aria-hidden='true'></i>";
						$delete_link = "<a id='delete-action' data-param=".$useraction->getLinkID()."&adminusergroupid=".$usergroup->AdminUserGroupID."' >".$html_img_delete."</a>";
				
						$admTbl->AddTableRow(array($modify_link, 
							$useraction->Description."&nbsp;",
							$useraction->ActionCode."&nbsp;",
							$delete_link));
					}
					$i++;
				}
			}
			
			$admTbl->RegisterAdminPage($smarty);
		}
		
		$smarty->display('modify.tpl');
	}
	else 
	{
		// show error message not enough rights
		$smarty->assign("norights_message",$LanguageArray["value"]["PLG_NORIGHT"]);
		$smarty->display('../../../templates/norights.tpl');	
	}
?>