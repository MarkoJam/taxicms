<?
	/* CMS Studio 3.0 index.php */	//
	
	$_ADMINPAGES = true;
	include_once("../../../config.php");
		
	global $smarty;
	global $auth;

	$ObjectFactory = ObjectFactory::getInstance();
	
	if($auth->isActionAllowed("ACTION_LOGIN_VIEW"))
	{
		$ap = new AdminTable();
		$ap->SetTitle(getTranslation("PLG_MAINTITLE"));
		$ap->SetOffsetName("offset_users");
		
		if($CMSSetting->getSettingByID(SETTING_EXCEL_EXPORT_USERS) == SETTING_TYPE_ON) 
		{
			$ap->ShowExportLinks();
		}
		
		$adminuserid = $auth->getAdminUserId();
		$adminUser = $ObjectFactory->createObject("AdminUser",$adminuserid);
		$cmbSubSite = ""; 		
		
		$loginFilterBox = new LoginFilterBox($smarty);
		$loginFilterBox->Init();

		$comboFilterUserStatus = new UserStatusFilter($ObjectFactory,$ap);
		$comboFilterUserStatus->generateProccessComboBox();
		
		$comboFilterUserType = new UserTypeFilter($ObjectFactory,$ap);
		$comboFilterUserType->generateProccessComboBox();
		
		$comboFilterUserCategory= new UserCategoryFilter($ObjectFactory,$ap);
		$comboFilterUserCategory->generateProccessComboBox();
		
		$cmbUserRole = makeUserRoleFilter($ObjectFactory, $ap);
		
		//broj redova na stranici
		if(isset($_REQUEST["records_per_page"]) && is_numeric($_REQUEST["records_per_page"]))
		{
			$productsPerPage = $_REQUEST["records_per_page"];
			$_SESSION["records_per_page_prproizvod"] = $productsPerPage;
		}
		else if(isset($_SESSION["records_per_page_prproizvod"]) && is_numeric($_SESSION["records_per_page_prproizvod"]))
		{
			$productsPerPage = $_SESSION["records_per_page_prproizvod"];
		}
		else
		{
			$productsPerPage = 20; 
		}

		$recordsPerPage = array(20,40,60,80,100,200);
		$shRecordsPerPage = new SmartyHtmlSelection("recordsPerPage",$smarty);
		foreach ($recordsPerPage as $num) 
		{
			$shRecordsPerPage->AddOutput($num);
			$shRecordsPerPage->AddValue($num);
		}
		
		$shRecordsPerPage->AddSelected($productsPerPage);
		$shRecordsPerPage->SmartyAssign();
			
		$ap->SetRowCount($productsPerPage);
		$ap->SetColCount();
		
		
		$ap->SetHeader(
						array(	
								"<span class='selectall' for='selectall'>".getTranslation("PLG_ALL")."<br /><div class='checkbox checkbox-primary'><input name='selectall' id='selectall' type='checkbox' /><label for='checkbox'></label></div></span>",		
								SortLink::generateLink(getTranslation("PLG_NAME"),"name"),
								SortLink::generateLink(getTranslation("PLG_EMAIL"),"email"),
								SortLink::generateLink(getTranslation("PLG_STATUS"),"status_id")."<br/>".$comboFilterUserStatus->getComboBox(),
								SortLink::generateLink(getTranslation("PLG_TYPE"),"user_type_id")."<br/>".$comboFilterUserType->getComboBox(),
								SortLink::generateLink(getTranslation("PLG_CATEGORY"),"user_category_id")."<br/>".$comboFilterUserCategory->getComboBox(),
								getTranslation("PLG_ROLES")."<br/>".$cmbUserRole,
								getTranslation("PLG_ROLE_ADD"),
								getTranslation("PLG_ROLE_DELETE"),
								getTranslation("PLG_DELETE"))
								);

		$ap->SetCountAllRows($DBBR->prebrojSveSlogove($ObjectFactory->createObject("User",-1), $ObjectFactory->filters));
	
		$ObjectFactory->AddLimit($ap->GetRowCount()); 
		$ObjectFactory->AddOffset($ap->GetOffset());
		$ObjectFactory->ManageSort();
		
		$ap->SetBrowseString($ObjectFactory);
		
		if($loginFilterBox->HasFilters())
		{
			$ObjectFactory->AddFilter($loginFilterBox->GetFilters());
		}

		$ap->SetCountAllRows($DBBR->prebrojSveSlogove($ObjectFactory->createObject("User",-1), $ObjectFactory->filters));
		
		$objlist = $ObjectFactory->createObjects("User",array("SfStatus","SfUserType","SfUserCategory","UserRole"));
		
		$ObjectFactory->ResetFilters();
		$ObjectFactory->ResetLimitOffset();
		
		// U slucaju dodavanja modula UserRole!!!!
		$shUserRole = new SmartyHtmlSelection("userrole",$smarty);
		$userroles = $ObjectFactory->createObjects("UserRole");
		foreach ($userroles as $ur) 
		{
			if($ur->UserRoleID != 1)
			{
				$shUserRole->AddOutput($ur->Role);
				$shUserRole->AddValue($ur->UserRoleID);
			}
		}
		if(isset($_SESSION["sel_userroleid"]))
		{
			$shUserRole->AddSelected($_SESSION["sel_userroleid"]);
		}
		$shUserRole->SmartyAssign();
		
		$html_img_edit = "<div class='btn btn-white'><i class='fa fa-pencil-square-o'></i></div>";
		$html_img_delete = "<div class='btn btn-white'><i class='fa fa-trash'></i></div>";
		$html_img_delete_role = "<div class='btn btn-white'><i class='fa fa-minus-square-o'></i></div>";
		$html_img_add = "<div class='btn btn-white'><i class='fa fa-plus-square-o' aria-hidden='true'></i></div>";
		
		//ZA SADRZAJ TABELE
		if(count($objlist)>0)
		{
			foreach($objlist as $odo)
			{
				if($auth->isActionAllowed("ACTION_LOGIN_MODIFY"))
				{
					$modify_link = "<a class='naziv' href='modify.php?".$odo->getLinkID()."'>".$html_img_edit."</a>".$odo->Name." ".$odo->Surname;
				}
				else
				{
					$modify_link = $odo->Name.' '.$odo->Surname;
				}
				
				if($auth->isActionAllowed("ACTION_LOGIN_DELETE"))
				{
					$delete_link = "<a href='delete_final.php?action=delete&".$odo->getLinkID()."'>".$html_img_delete."</a>";
				}
				else
				{
					$delete_link = $html_img_delete;
				}
				
				if($auth->isActionAllowed("ACTION_LOGIN_ADDTOROLE"))
				{
					$add_to_role = "<div class='dodaj_u_rolu' data-param='".$odo->UserID."' data-link='add_to_role.php'>".$html_img_add."</div>";
					$delete_role_link = "<div class='izbrisi_iz_role' data-param='".$odo->UserID."' data-link='delete_from_role.php'>".$html_img_delete_role."</div>";
				}
				else
				{
					$add_to_role = $html_img_add;
					$delete_role_link = $html_img_delete_role;
				}
				
				$checkbox = "<div class='checkbox checkbox-primary'><input type='checkbox' name='userid[]' value='".$odo->UserID."'/><label for='checkbox'></label></div>";
				
				// format userrole
				$rolesPrint = "";
				foreach($odo->UserRoles as $userRole)
				{
					$rolesPrint .= ($userRole->Role . ",");
				}
				
				$rolesPrint = substr($rolesPrint, 0, strlen($rolesPrint)-1);
				
				$ap->AddTableRow(
									array(	
											$checkbox,
											$modify_link,
										//	$odo->Firm."&nbsp;", 
										//	$odo->Place."&nbsp;",
											$odo->Email."&nbsp;",
											$odo->SfStatus->getVrednost()."&nbsp;",
											$odo->SfUserType->getVrednost()."&nbsp;",
											$odo->SfUserCategory->getVrednost()."&nbsp;",
											$rolesPrint,
											$add_to_role,
											$delete_role_link,
											$delete_link
										)
						 		);
			}
		}
		// koji pripadaju filteru i sort-u
		$ap->SetTdTableAttributes(array("width='10px' align='center'","width='40%' align='left'","width='10%'","width='10%'","width='10%'","width='10%'","width='10%'","width='5%' align='center'","width='5%' align='center'" ,"width='5%' align='center'","width='5%' align='center'"));
		$ap->SetTrTableAttributes($array_order);
		$ap->RegisterAdminPage($smarty);
		
		
		if(isset($_REQUEST["insertrole"]))
		{
			$smarty->assign("insertrole",$_REQUEST["insertrole"]);
		}
		
		$smarty->display('index.tpl');
	}
	else
	{
		// show error message not enough rights
		$smarty->assign("norights_message",getTranslation("PLG_NORIGHT_VIEW"));
		$smarty->display('../../../templates/norights.tpl');
	}
	
	
	function makeUserFilter(& $pof, $subsiteid)
	{
		global $DBBR;
		global $ap;
		global $ObjectFactory;
		
		if(isset($_REQUEST["user_hit"]))
		{
			//desila se promena iz forme potrebno je azurirati sessijsku promenljivu na 0
			$_SESSION["offset_userstat"]=0;
			$ap->SetOffset(0);

			$_SESSION["sess_useridstat"] = $_REQUEST["userid"];				
		}

		if(isset($_SESSION["sess_useridstat"])){
			if($_SESSION["sess_useridstat"] == -1) unset($_SESSION["sess_useridstat"]);
		}

		if(isset($_REQUEST["userid"]) && $_REQUEST["userid"] != -1)
		{
			$pof->AddFilter("userid=".$_REQUEST["userid"]);
		}
		else{
		
			if(isset($_SESSION["sess_useridstat"]) && $_SESSION["sess_useridstat"] != -1)
			{
				$pof->AddFilter("userid=".$_SESSION["sess_useridstat"]);	
			}
		}
		
		if($subsiteid != -1)
		{
			$ObjectFactory->AddFilter("sub_site_id=".$subsiteid);
		}
		$users = $ObjectFactory->createObjects("User");
		$cmb_users  = "<select class='form-control' name='userid' onChange='formTable.submit();'>";
		$cmb_users .="<option value='-1'>".getTranslation("PLG_FILTER_NO")."</option>";
		foreach ($users as $u)
		{
			$selected = "";
			if(isset($_REQUEST["userid"]) && $u->UserID == $_REQUEST["userid"])
			{
				$selected = "selected";
			}
			else 
			if(isset($_SESSION["sess_useridstat"]) && $u->UserID == $_SESSION["sess_useridstat"])
			{
				$selected = "selected";
			}
			$cmb_users .= "<option ".$selected." value='".$u->UserID."'>" .$u->Firm." ".$u->Place. " ".$u->PIB. "</option>";
		
		}
		return $cmb_users .= "</select><input type='hidden' name='user_hit' value='true'>";			
	}
	
	function makeSubSiteFilter(& $pof)
	{
		global $DBBR;
		global $ap;
		global $ObjectFactory;
		
		if(isset($_REQUEST["subsite_hit"]))
		{
			//desila se promena iz forme potrebno je azurirati sessijsku promenljivu na 0
			$_SESSION["offset_subsitestat"]=0;
			$ap->SetOffset(0);

			$_SESSION["sess_subsiteidlogin"] = $_REQUEST["subsiteid"];				
		}

		if(isset($_SESSION["sess_subsiteidlogin"])){
			if($_SESSION["sess_subsiteidlogin"] == -1) unset($_SESSION["sess_subsiteidlogin"]);
		}

		if(isset($_REQUEST["subsiteid"]) && $_REQUEST["subsiteid"] != -1)
		{
			$pof->AddFilter("sub_site_id=".$_REQUEST["subsiteid"]);
		}
		else{
		
			if(isset($_SESSION["sess_subsiteidlogin"]) && $_SESSION["sess_subsiteidlogin"] != -1)
			{
				$pof->AddFilter("sub_site_id=".$_SESSION["sess_subsiteidlogin"]);	
			}
		}
		
		$subsites = $ObjectFactory->createObjects("SubSite");
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
			if(isset($_SESSION["sess_subsiteidlogin"]) && $u->SubSiteID == $_SESSION["sess_subsiteidlogin"])
			{
				$selected = "selected";
			}
			
			$cmb_subsites .= "<option ".$selected." value='".$u->SubSiteID."'>" .$u->Name. "</option>";
		
		}
		return $cmb_subsites .= "</select><input type='hidden' name='subsite_hit' value='true'>";			
	}	
	
	function makeUserRoleFilter($ObjectFactory, $ap)
	{
		if(isset($_REQUEST["userroleid2"]))
		{
			//desila se promena iz forme potrebno je azurirati sessijsku promenljivu na 0
			$_SESSION["offset_userrole"]=0;
			$ap->SetOffset(0);
			$_SESSION["sess_userroleid2"] = $_REQUEST["userroleid2"];				
		}
		if(isset($_SESSION["sess_userroleid2"])){
			if($_SESSION["sess_userroleid2"] == -1) unset($_SESSION["sess_userroleid2"]);
		}
		
		$user_ids = "";
		if(isset($_REQUEST["userroleid2"]) && $_REQUEST["userroleid2"] != -1)
		{
			$userrole = $ObjectFactory->createObject("UserRole",$_REQUEST["userroleid2"],array("User"));
			foreach ($userrole->User as $user) 
			{
				$user_ids .= $user->UserID . ",";
			}
			$user_ids = substr($user_ids,0,strlen($user_ids)-1);
			$ObjectFactory->AddFilter("userid IN (".$user_ids.") ");
		}
		else{
		
			if(isset($_SESSION["sess_userroleid2"]) && $_SESSION["sess_userroleid2"] != -1)
			{
				$userrole = $ObjectFactory->createObject("UserRole",$_SESSION["sess_userroleid2"],array("User"));
				if(!empty($userrole->User))
				{
					foreach ($userrole->User as $user) 
					{
						$user_ids .= $user->UserID . ",";
					}
					$user_ids = substr($user_ids,0,strlen($user_ids)-1);
					$ObjectFactory->AddFilter("userid IN (".$user_ids.") ");
				}
				else 
				{
					$ObjectFactory->AddFilter(" 1=2 ");
				}
			}
		}
		
		$ObjectFactory1 = new ObjectFactory();
		$ObjectFactory1->Reset();
		$ObjectFactory1->SetSortBy("role");
		$userrole = $ObjectFactory1->createObjects("UserRole");
		$ObjectFactory1->Reset();
		$cmb_userrole  = "<select class='form-control' name='userroleid2' onChange='formTable.submit();'>";
		$cmb_userrole .="<option value='-1'>".getTranslation("PLG_FILTER_NO")."</option>";
		foreach ($userrole as $kat)
		{
			$selected = "";
			if(isset($_REQUEST["userroleid2"]) && $kat->getUserRoleID() == $_REQUEST["userroleid2"])
			{
				$selected = "selected";
			}
			else if(isset($_SESSION["sess_userroleid2"]) && $kat->getUserRoleID() == $_SESSION["sess_userroleid2"])
			{
				$selected = "selected";
			}
			$cmb_userrole .= "<option ".$selected." value='".$kat->getUserRoleID()."'>" .$kat->getRole() . "</option>";
		}
		return $cmb_userrole .= "</select><input type='hidden' name='userrole_hit' value='true'>";	
	}		
?>