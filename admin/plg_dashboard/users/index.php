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
		//$ap->SetOffset(0);
		
		$ObjectFactory->ResetFilters();
		$subsite = $ObjectFactory->createObject("SubSite", $_SESSION["subsiteid"]);
		
		if($subsite->getIsDefault() == 0) $ObjectFactory->AddFilter("sub_site_id = " . $subsite->getSubSiteID());
		
		$adminuserid = $auth->getAdminUserId();
		$adminUser = $ObjectFactory->createObject("AdminUser",$adminuserid);
		$cmbSubSite = ""; 		
		
		$comboFilterUserStatus = new UserStatusFilter($ObjectFactory,$ap);
		$comboFilterUserStatus->generateProccessComboBox();
				
		$comboFilterUserCategory= new UserCategoryFilter($ObjectFactory,$ap);
		$comboFilterUserCategory->generateProccessComboBox();
		
		
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
		if(isset($_REQUEST["direction"])) {
			$direction=$_REQUEST["direction"];
		}
		else $direction='';
		if(isset($_REQUEST["sortby"])) {
			$sortby=$_REQUEST["sortby"];
		}
		else {
			$sortby='cnt';	
			$direction='desc';
		}
		if (isset($_REQUEST['offset'])) {
			$offset=$_REQUEST['offset']/7;
		}	
		else $offset=0;	
		
			
		$shRecordsPerPage->AddSelected($productsPerPage);
		$shRecordsPerPage->SmartyAssign();
		
		if (isset($_REQUEST['newsletterid'])) $_SESSION['newsletterid']=$_REQUEST['newsletterid'];
		else if (isset($_SESSION['newsletterid'])) $_REQUEST['newsletterid']=$_SESSION['newsletterid'];
		else $_REQUEST['newsletterid']=-1; 
		
		// combobox za newsletter
		$ObjectFactory->Reset();
		$newsletter = $ObjectFactory->createObjects("Newsletter");
		if ($_REQUEST['newsletterid']) $snl=$_REQUEST['newsletterid'];
		else $snl=-1;
		$ShNL= new SmartyHtmlSelection("newsletter",$smarty);
		$ShNL->AddValue(-1);
		$ShNL->AddOutput("no filters");
		foreach($newsletter as $nl)
		{
			$ShNL->AddValue($nl->NewsletterID);
			$ShNL->AddOutput($nl->Header);
		}
		$ShNL->AddSelected($snl);
		$ShNL->SmartyAssign();			
	
			
			
		$ap->SetRowCount($productsPerPage);
		$ap->SetColCount();
		

		$ap->SetHeader(
						array(	
								getTranslation("PLG_VIEWS")." / ".getTranslation("PLG_DETAILS"),
								SortLink::generateLink(getTranslation("PLG_NAME"),"name"),
								SortLink::generateLink(getTranslation("PLG_FIRM"),"firm"),
								SortLink::generateLink(getTranslation("PLG_CATEGORY"),"user_category_id"),
								SortLink::generateLink(getTranslation("PLG_STATUS"),"status_id"),
								getTranslation("PLG_ROLES"),
								SortLink::generateLink(getTranslation("PLG_VIEWS")." / ".getTranslation("PLG_COUNT"),"cnt")
								));

		$ap->SetCountAllRows($DBBR->prebrojSveSlogove($ObjectFactory->createObject("User",-1), $ObjectFactory->filters));
	
		$ObjectFactory->AddLimit($ap->GetRowCount()); 
		$ObjectFactory->AddOffset($ap->GetOffset());
		$ObjectFactory->ManageSort();
		
		$ap->SetBrowseString($ObjectFactory);
		
		
		//$ap->SetCountAllRows($DBBR->prebrojSveSlogove($ObjectFactory->createObject("User",-1), $ObjectFactory->filters));
		
		//filter za prikaz user-a
		// user role
		if (isset($_REQUEST['newsletterid']) && $_REQUEST['newsletterid']>-1) {
			$nl = $ObjectFactory->createObject("Newsletter",$_REQUEST['newsletterid']);
			$roleid=$nl->getUserRoleID();
			$ObjectFactory->Reset();
			$ObjectFactory->AddFilter("userroleid=" . $roleid);
			$roles= $ObjectFactory->createObjects("UserUserRole");
			$ObjectFactory->Reset();
			$roles_filter="(";
			$i=0;
			foreach ($roles as $role) {
				if ($i>0) $roles_filter.= ",";
				$roles_filter.= $role->getUserID();
				$i++;
			}
			$roles_filter.=")";
			$users_filter = 'userid IN '.$roles_filter;
		}
		else $users_filter ="  1";
		
		// unutrasnji filter za vremensko ogranicenje visits-a
		if (isset($_REQUEST['start']) && isset($_REQUEST['end'])) 
		{
			$start=$_REQUEST['start'];
			$end=$_REQUEST['end'];
			$_SESSION['start']=$_REQUEST['start'];
			$_SESSION['end']=$_REQUEST['end'];
		}
		else if (isset($_SESSION['start']) && isset($_SESSION['end'])) 
		{
			$start=$_SESSION['start'];
			$end=$_SESSION['end'];
		}	
		else
		{
			$start=time()-365*24*3600;
			$end=time();
		}
		if (isset($_REQUEST['range'])) $smarty->assign('range',$_REQUEST['range']);
				
		//filteri
		$filter='';
		//vremensko
		$time_filter.=" `time` >";
		$time_filter.=$start;
		$time_filter.=" AND `time` <";
		$time_filter.=$end;
		$filter.=$time_filter;
		
		// newsletter
		if ($_REQUEST['newsletterid'] && $_REQUEST['newsletterid'] != -1) 
		{
			$nl_filter.=" AND `newsletter_id` = ";
			$nl_filter.=$_REQUEST['newsletterid'];
		}	
		else $nl_filter.=" ";	
		$filter.=$nl_filter;
		
		$filter.=" AND resource_id>0 ";  
		
		$sql="SELECT count(userid) as cnt FROM user WHERE ".$users_filter;
		$result_set = $DBBR->con->get_results($sql);
		$ap->SetCountAllRows($result_set[0]->cnt);		
		
		
		$sql="SELECT user.userid,time,count(vf.user_id) as cnt FROM user 
			LEFT JOIN (SELECT * FROM visits WHERE ".$filter.") as vf
			ON user.userid = vf.user_id  
			WHERE ".$users_filter."
			GROUP BY user.userid 
			ORDER BY ".$sortby." ".$direction." LIMIT ".$offset.",".$productsPerPage;
		$result_set = $DBBR->con->get_results($sql);
		
		//$objlist = $ObjectFactory->createObjects("User",array("SfStatus","SfUserType","SfUserCategory","UserRole","SubSite"));

		$ObjectFactory->ResetFilters();
		$ObjectFactory->ResetLimitOffset();
		

		
		$html_img_edit = "<div class='btn btn-white'><i class='fa fa-pencil-square-o'></i></div>";
		$html_img_view = "<div class='btn btn-white'><i class='fa fa-list' aria-hidden='true'></i></div>";
		
		//ZA SADRZAJ TABELE
		if(count($result_set)>0)
		{
			$table_arr=array();
			foreach($result_set as $result)
			{				
				$odo=$ObjectFactory->createObject("User",$result->userid,array("SfStatus","SfUserType","SfUserCategory","UserRole"));

				if ($result->cnt>0) $view_link = "<a class='naziv' data-link='modify.php' data-param='userid=".$odo->getUserID()." &start=".$start." &end=".$end." &newsletterid=".$_REQUEST['newsletterid']."'>".$html_img_view."</a>";			
				else $view_link = "";
	
				
				// format userrole
				$rolesPrint = "";
				foreach($odo->UserRoles as $userRole)
				{
					$rolesPrint .= ($userRole->Role . ",");
				}
				$rolesPrint = substr($rolesPrint, 0, strlen($rolesPrint)-1);
				

				//select za broj pregleda
				
				
				$table_row_arr=array (
										$view_link,
										$odo->Name." ".$odo->Surname,
										$odo->Firm."&nbsp;", 
										$odo->SfUserCategory->getVrednost()."&nbsp;",
										$odo->SfStatus->getVrednost()."&nbsp;",
										$rolesPrint,
										$result->cnt
									);
				$table_arr[]=$table_row_arr;					
			}
			
			// sortiranje po nekom elementu
			
			
			foreach($table_arr as $row)
			{
				$ap->AddTableRow($row);
			}		
		}
		// koji pripadaju filteru i sort-u
		$ap->SetTdTableAttributes(array("width='10px' align='center'","width='40%' align='left'","width='10%'","width='10%'","width='10%'","width='10%'","width='10%'","width='5%' align='center'","width='5%' align='center'" ,"width='5%' align='center'","width='5%' align='center'"));
		$ap->SetTrTableAttributes($array_order);
		$ap->RegisterAdminPage($smarty);
		
		if (file_exists('templates/index.tpl')) $smarty->display('index.tpl');
		else $smarty->display('../../../templates/index1.tpl');

	}
	else
	{
		// show error message not enough rights
		$smarty->assign("norights_message",getTranslation("PLG_NORIGHT"));
		$smarty->display('../../../templates/norights.tpl');
	}
	
	
	
	
?>