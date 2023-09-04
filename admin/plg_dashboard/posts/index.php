<?
	/* CMS Studio 3.0 index.php */	//
	
	$_ADMINPAGES = true;
	include_once("../../../config.php");
		
	global $smarty;
	global $auth;

	$ObjectFactory = ObjectFactory::getInstance();

	if (isset($_REQUEST['plugin'])) {
		$plugin=$_REQUEST['plugin'];
		$_SESSION['plugin']=$plugin;
	}	
	else $plugin=$_SESSION['plugin'];
	//odrednice post-a
	switch ($plugin) {
		case 'proizvod':
			$table='pr_proizvod';
			$id='pr_proizvod.proizvodid';
			$rid_code="\$rid=\$result->proizvodid;";
			$post_date='datum';
			$class='PrProizvod';
			$rel_class=array("SfStatus","PrTipProizvoda","PrKategorija","PrProizvodjac","PrGrupaProizvoda");
			$action="ACTION_PRODUCT_VIEW";
			$header_plugin_arr=array(
								SortLink::generateLink(getTranslation("PLG_NAME"),"naziv"),
								SortLink::generateLink(getTranslation("PLG_PRICE"),"cenaamp"),
								SortLink::generateLink(getTranslation("PLG_TYPE"),"tipproizvodaid"),
								getTranslation("PLG_GROUP"),
								SortLink::generateLink(getTranslation("PLG_STATUS"),"status_id"));
			$r_id_code="\$r_id=\$odo->getProizvodID();";
			$title_code="\$plugin_title=\$odo->getNaziv();";							
			$row_array_plugin_code="\$row_array_plugin=array (
														\$odo->getCenaAMP(),
														\$odo->getTipProizvoda(),
														\$odo->getGrupaProizvoda(),
														\$odo->SfStatus->getVrednost());";
											
			break;
		case 'news':
			$table='news';
			$id='news.news_id';
			$rid_code="\$rid=\$result->news_id;";
			$post_date='date';
			$class='News';
			$rel_class=array("NewsCategory","SfStatus");
			$action="ACTION_NEWS_VIEW";
			$header_plugin_arr=array(
							SortLink::generateLink(getTranslation("PLG_NAME"),"title"),
							getTranslation("PLG_DATE"),
							getTranslation("PLG_CATEGORY"),
							getTranslation("PLG_STATUS"));
			$r_id_code="\$r_id=\$odo->getNewsID();";
			$title_code="\$plugin_title=\$odo->getHeader();";							
			$row_array_plugin_code="\$row_array_plugin=array (
														date('d-M-Y',\$odo->getDate()),
														\$odo->getNewsCategoryPrint(),
														\$odo->SfStatus->getVrednost());";
											
			break;			
		case 'event':
			$table='event';
			$id='event.event_id';
			$rid_code="\$rid=\$result->event_id;";
			$post_date='date';
			$class='Event';
			$rel_class=array("EventCategory","SfStatus");
			$action="ACTION_EVENT_VIEW";
			$header_plugin_arr=array(
							SortLink::generateLink(getTranslation("PLG_NAME"),"title"),
							getTranslation("PLG_DATE"),
							getTranslation("PLG_CATEGORY"),
							getTranslation("PLG_STATUS"));
			$r_id_code="\$r_id=\$odo->getEventID();";
			$title_code="\$plugin_title=\$odo->getHeader();";							
			$row_array_plugin_code="\$row_array_plugin=array (
														date('d-M-Y',\$odo->getDate()),
														\$odo->getEventCategoryPrint(),
														\$odo->SfStatus->getVrednost());";
											
			break;			
	
		case 'persons':
			$table='persons';
			$id='persons.persons_id';
			$rid_code="\$rid=\$result->persons_id;";
			$post_date='date';
			$class='Persons';
			$rel_class=array("PersonsCategory","SfStatus");
			$action="ACTION_PERSONS_VIEW";
			$header_plugin_arr=array(
							SortLink::generateLink(getTranslation("PLG_NAME"),"title"),
							getTranslation("PLG_DATE"),
							getTranslation("PLG_CATEGORY"),
							getTranslation("PLG_STATUS"));
			$r_id_code="\$r_id=\$odo->getPersonsID();";
			$title_code="\$plugin_title=\$odo->getHeader();";							
			$row_array_plugin_code="\$row_array_plugin=array (
														date('d-M-Y',\$odo->getDate()),
														\$odo->getPersonsCategoryPrint(),
														\$odo->SfStatus->getVrednost());";
											
			break;
		case 'project':
			$table='project';
			$id='project.project_id';
			$rid_code="\$rid=\$result->project_id;";
			$post_date='date';
			$class='Project';
			$rel_class=array("ProjectCategory","SfStatus");
			$action="ACTION_PROJECT_VIEW";
			$header_plugin_arr=array(
							SortLink::generateLink(getTranslation("PLG_NAME"),"title"),
							getTranslation("PLG_DATE"),
							getTranslation("PLG_CATEGORY"),
							getTranslation("PLG_STATUS"));
			$r_id_code="\$r_id=\$odo->getProjectID();";
			$title_code="\$plugin_title=\$odo->getHeader();";							
			$row_array_plugin_code="\$row_array_plugin=array (
														date('d-M-Y',\$odo->getDate()),
														\$odo->getProjectCategoryPrint(),
														\$odo->SfStatus->getVrednost());";
											
			break;	
		case 'genres':
			$table='genres';
			$id='genres.genres_id';
			$rid_code="\$rid=\$result->genres_id;";
			$post_date='date';
			$class='GenRes';
			$rel_class=array("GenResCategory","SfStatus");
			$action="ACTION_GENRES_VIEW";
			$header_plugin_arr=array(
							SortLink::generateLink(getTranslation("PLG_NAME"),"title"),
							getTranslation("PLG_DATE"),
							getTranslation("PLG_CATEGORY"),
							getTranslation("PLG_STATUS"));
			$r_id_code="\$r_id=\$odo->getGenResID();";
			$title_code="\$plugin_title=\$odo->getHeader();";							
			$row_array_plugin_code="\$row_array_plugin=array (
														date('d-M-Y',\$odo->getDate()),
														\$odo->getGenResCategoryPrint(),
														\$odo->SfStatus->getVrednost());";
											
			break;	
		}				
		
	if($auth->isActionAllowed($action))
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
			$offset=$_REQUEST['offset']/8;
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
		$ShNL->AddOutput("no filter");
		foreach($newsletter as $nl)
		{
			$ShNL->AddValue($nl->NewsletterID);
			$ShNL->AddOutput($nl->Header);
		}
		$ShNL->AddSelected($snl);
		$ShNL->SmartyAssign();		
	
			
			
		$ap->SetRowCount($productsPerPage);
		$ap->SetColCount();
		
		$header_arr=array(getTranslation("PLG_VIEWS")." / ".getTranslation("PLG_DETAILS"));				
		$header_arr=array_merge($header_arr,$header_plugin_arr);
		array_push($header_arr,	SortLink::generateLink(getTranslation("PLG_VIEWS")." / ".getTranslation("PLG_COUNT"),"cnt"));										
		$ap->SetHeader($header_arr);			

	
		$ObjectFactory->AddLimit($ap->GetRowCount()); 
		$ObjectFactory->AddOffset($ap->GetOffset());
		$ObjectFactory->ManageSort();
		
		$ap->SetBrowseString($ObjectFactory);
		// newsletter time filter
		if ($_REQUEST['newsletterid'] && $_REQUEST['newsletterid'] != -1) 
		{
			$newsletter = $ObjectFactory->createObject("Newsletter",$_REQUEST['newsletterid'],array('UserRole'));
			if ($newsletter->UserRole->UserRoleID==9) $daynum=1;
			if ($newsletter->UserRole->UserRoleID==10) $daynum=7;
			$time_end=$newsletter->Date;
			$time_start=$time_end-$daynum*24*3600; //daynum dana * 24 sata* 3600 sekundi  
			$nl_time_filter.=$post_date." > ".$time_start." AND ".$post_date." <".$time_end;
			
		}	
		else $nl_time_filter.=" 1";	
		
		
		
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
		else $nl_filter.=" AND `newsletter_id`>0 ";	
		$filter.=$nl_filter;
		//plugin
		$filter.=" AND `plugin` = '".$plugin."'";
		
		$sql="SELECT count(".$id.") as cnt FROM ".$table." WHERE ".$nl_time_filter;
		$result_set = $DBBR->con->get_results($sql);
		$ap->SetCountAllRows($result_set[0]->cnt);		
		
		$sql="SELECT ".$id.",time,count(vf.resource_id) as cnt FROM ".$table."
			LEFT JOIN (SELECT * FROM visits WHERE ".$filter.") as vf
			ON ".$id." = vf.resource_id  
			WHERE ".$nl_time_filter."			
			GROUP BY ".$id." 
			ORDER BY ".$sortby." ".$direction." LIMIT ".$offset.",".$productsPerPage;
		$result_set = $DBBR->con->get_results($sql);
		

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
				eval($rid_code);	
				$odo=$ObjectFactory->createObject($class, $rid, $rel_class);
				eval($r_id_code);
				eval($title_code);
				if ($result->cnt>0) $view_link = "<a class='naziv' data-link='modify.php' data-param='plugin=".$plugin." &plugin_title=".$plugin_title." &id=".$r_id." &start=".$start." &end=".$end." &newsletterid=".$_REQUEST['newsletterid']."'>".$html_img_view."</a>";			
				else $view_link = "";
	
				//select za broj pregleda				
				$row_arr=array($view_link,$plugin_title);
				eval($row_array_plugin_code);
				$row_arr=array_merge ($row_arr,$row_array_plugin);						
				array_push($row_arr,$result->cnt);		
				$ap->AddTableRow($row_arr);					
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