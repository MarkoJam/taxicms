<?
	/* CMS Studio 3.0 index.php */

	$_ADMINPAGES = true;
	include_once("../../../config.php");

	global $smarty;
	global $auth;

	if($auth->isActionAllowed("ACTION_ADMINISTRATOR_VIEW"))
	{
		$ap = new AdminTable();
		//$ap->ShowExportLinks();
		$ap->SetTitle("Ažuriranje administratora sistema:");
		$ap->SetOffsetName("offset_administrators");

		//$cmbStatus = makeStatusFilter($ObjectFactory);
		//$cmbSubSite = makeSubSiteFilter($ObjectFactory);

		$ap->SetHeader(array(
							"<span class='promeni'>".getTranslation("PLG_CHANGE")."</span>",
							SortLink::generateLink(getTranslation("PLG_USERNAME"),"username"),
							SortLink::generateLink(getTranslation("PLG_FULLNAME"),"fullname"),
							SortLink::generateLink(getTranslation("PLG_STATUS"),"status_id")."<br/>",
							SortLink::generateLink(getTranslation("PLG_GROUP"),"admin_user_group_id"),
							getTranslation("PLG_SUBSITE")."<br/>",
							getTranslation("PLG_DELETE"))
						);

		$ap->SetCountAllRows($DBBR->prebrojSveSlogove($ObjectFactory->createObject("AdminUser",-1), $ObjectFactory->filters));

		$ObjectFactory->AddLimit($ap->GetRowCount());
		$ObjectFactory->AddOffset($ap->GetOffset());
		$ObjectFactory->ManageSort();

		$objlist = $ObjectFactory->createObjects("AdminUser",array("AdminUserGroup","SfStatus","SubSite"));

		$ap->SetBrowseString($ObjectFactory);
		$ObjectFactory->ResetFilters(); $ObjectFactory->ResetLimitOffset();
		$ap->SetRecordCount(count($objlist));

		//za slicice gore-dole
		$html_img_edit = "<div class='btn btn-white'><i class='fa fa-pencil-square-o'></i></div>";
		$html_img_delete = "<div class='btn btn-white'><i class='fa fa-trash'></i></div>";

		//ZA SADRZAJ TABELE
		if(count($objlist)>0)
		{
			foreach($objlist as $odo)
			{
				if($auth->isActionAllowed("ACTION_ADMINISTRATOR_MODIFY"))
				{
					$modify_link = "<a class='naziv' href='modify.php?".$odo->getLinkID()."'>$html_img_edit</a>";
				}
				else
				{
					$modify_link = $html_img_edit;
				}

				if($auth->isActionAllowed("ACTION_ADMINISTRATOR_DELETE"))
				{
					$delete_link = "<a href='delete_final.php?action=delete&".$odo->getLinkID()."'>".$html_img_delete."</a>";
				}
				else
				{
					$delete_link = $html_img_delete;
				}

				$ap->AddTableRow(
									array(
											$modify_link,
											$odo->UserName."&nbsp;",
											$odo->FullName."&nbsp;",
											$odo->SfStatus->Vrednost."&nbsp;",
											$odo->AdminUserGroup->Title."&nbsp;",
											$odo->SubSite->Name."&nbsp;",
											$delete_link
										)
						 		);
			}
		}

		$ap->RegisterAdminPage($smarty);

		$smarty->display('index.tpl');
	}
	else
	{
		// show error message not enough rights
		$smarty->assign("norights_message",getTranslation("PLG_NORIGHT_VIEW"));
		$smarty->display('../../../templates/norights.tpl');
	}
	function makeStatusFilter(& $pof)
	{
		global $DBBR;
		global $ap;
		if(isset($_REQUEST["status"]))
		{
			if($_REQUEST["status"] == -1) unset($_SESSION["sess_status"]);
		}

		if(isset($_REQUEST["status"]) && $_REQUEST["status"] != -1)
		{
			$pof->AddFilter("status='".$_REQUEST["status"]."'");
		}
		else{

			if(isset($_SESSION["sess_status"]) && $_SESSION["sess_status"] != -1)
			{
				$pof->AddFilter("status='".$_SESSION["sess_status"]."'");
			}
		}

		if(isset($_REQUEST["status_hit"]))
		{
			//desila se promena iz forme potrebno je azurirati sessijsku promenljivu na 0
			$_SESSION["offset_administrators"]=0;
			$ap->SetOffset(0);
			if($_REQUEST["status"] != -1)
			{
				$_SESSION["sess_status"] = $_REQUEST["status"];
			}
		}

		//$pof1 = new productFactory($DBBR);
		$statusi = array("aktivan","neaktivan");
		$cmb_statusi  = "<select class='form-control' name='status' onChange='formTable.submit();'>";
		$cmb_statusi .="<option value='-1'>".getTranslation("PLG_FILTER_NO")."</option>";
		foreach ($statusi as $stat)
		{
			$selected = "";
			if(isset($_REQUEST["status"]) && $stat == $_REQUEST["status"])
			{
				$selected = "selected";
			}
			else
			if(isset($_SESSION["sess_status"]) && $stat == $_SESSION["sess_status"])
			{
				$selected = "selected";
			}
			$cmb_statusi .= "<option ".$selected." value='".$stat."'>" .$stat . "</option>";
		}
		return $cmb_statusi .= "</select><input type='hidden' name='status_hit' value='true'>";
	}


	function makeSubSiteFilter(& $pof)
	{
		global $DBBR;
		global $ap;

		if(isset($_REQUEST["subsite_hit"]))
		{
			//desila se promena iz forme potrebno je azurirati sessijsku promenljivu na 0
			$_SESSION["offset_subsitestat"]=0;
			$ap->SetOffset(0);
			$_SESSION["sess_subsiteidadminuser"] = $_REQUEST["subsiteid"];
		}

		if(isset($_SESSION["sess_subsiteidadminuser"])){
			if($_SESSION["sess_subsiteidadminuser"] == -1) unset($_SESSION["sess_subsiteidadminuser"]);
		}

		if(isset($_REQUEST["subsiteid"]) && $_REQUEST["subsiteid"] != -1)
		{
			$pof->AddFilter("sub_site_id=".$_REQUEST["subsiteid"]);
		}
		else{

			if(isset($_SESSION["sess_subsiteidadminuser"]) && $_SESSION["sess_subsiteidadminuser"] != -1)
			{
				$pof->AddFilter("sub_site_id=".$_SESSION["sess_subsiteidadminuser"]);
			}
		}

		$cf = new coreFactory($DBBR);
		$subsites = $cf->createObjects("subsites");
		$cmb_subsites  = "<select class='form-control' name='subsiteid' onChange='formTable.submit();'>";
		$cmb_subsites .="<option value='-1'>".getTranslation("PLG_FILTER_NO")."</option>";
		foreach ($subsites as $u)
		{
			$selected = "";
			if(isset($_REQUEST["subsiteid"]) && $u->SubSiteID == $_REQUEST["subsiteid"])
			{
				$selected = "selected";
			}
			else
			if(isset($_SESSION["sess_subsiteidadminuser"]) && $u->SubSiteID == $_SESSION["sess_subsiteidadminuser"])
			{
				$selected = "selected";
			}

			$cmb_subsites .= "<option ".$selected." value='".$u->SubSiteID."'>" .$u->Name. "</option>";

		}
		return $cmb_subsites .= "</select><input type='hidden' name='subsite_hit' value='true'>";
	}
?>
