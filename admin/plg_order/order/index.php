<?
	/* CMS Studio 3.0 index.php */

	$_ADMINPAGES = true;
	include_once("../../../config.php");	

	global $smarty;
	global $auth;
		
	if($auth->isActionAllowed("ACTION_ORDER_VIEW"))
	{
		$ap = new AdminTable();
		$ap->SetOffsetName("offset_order");
		$ap->SetTitle("Pregled narudžbenica:");
	
		//$cmbStatus = makeStatusFilter($pof);
		$ap->SetCountAllRows($DBBR->prebrojSveSlogove($ObjectFactory->createObject("PrOrder",-1), $ObjectFactory->filters));
		$ap->SetHeader(
						array(
							getTranslation("PLG_CHANGE"),
							SortLink::generateLink(getTranslation("PLG_ORDERNO"),"orderid"),
							SortLink::generateLink(getTranslation("PLG_ORDERNAME"),"name"),
							SortLink::generateLink(getTranslation("PLG_DATE"),"date"),
							SortLink::generateLink(getTranslation("PLG_STATUS"),"status_id"),
							//SortLink::generateLink(getTranslation("PLG_TYPE"),"order_type_id"),
							//getTranslation("PLG_TYPE"),
							getTranslation("PLG_DELETE"))
						);	

		$ObjectFactory->AddLimit($ap->GetRowCount()); 
		$ObjectFactory->AddOffset($ap->GetOffset());
		$ObjectFactory->ManageSort();
		
		//------------KREIRANJE LISTE OBJEKATA---------
		$objlist = $ObjectFactory->createObjects("PrOrder",array("SfStatus"));
		//---------------------------------------------
		
		$ap->SetBrowseString($ObjectFactory);
		$ap->SetRecordCount(count($objlist));

		$html_img_edit = "<div class='btn btn-white'><i class='fa fa-pencil-square-o'></i></div>";
		$html_img_delete = "<div class='btn btn-white'><i class='fa fa-trash'></i></div>";
		
		//ZA SADRZAJ TABELE
		if(!empty($objlist))
		{
			foreach($objlist as $odo)
			{		
				$modify_link = "<a class='naziv' href='modify.php?".$odo->getLinkID()."'>".$html_img_edit."</a>";
				$delete_link = "<a href='delete_final.php?action=delete&".$odo->getLinkID()."'>".$html_img_delete."</a>";
				
				$ap->AddTableRow(
							array(
								$modify_link, 
								$odo->OrderID,
								$odo->Name."&nbsp;".$odo->Surname,
								date("d-M-Y",$odo->Date),
								$odo->SfStatus->getVrednost()."&nbsp;", 
								//$odo->SfOrderType->getVrednost()."&nbsp;", 
								$delete_link));
			}
		}
		$ap->RegisterAdminPage($smarty);
		$smarty->display('index.tpl');
	}
	else
	{
		// show error message not enough rights
		$smarty->assign("norights_message",getTranslation("PLG_POLL_NORIGHT_VIEW"));
		$smarty->display('../../templates/norights.tpl');
	}	
	
	function makeUserFilter(& $pof)
	{
		global $DBBR;
		if(isset($_REQUEST["userid"]) && $_REQUEST["userid"] != -1)
		{
			$pof->AddFilter("userid=".$_REQUEST["userid"]);
		}
		if(isset($_REQUEST["user_hit"]))
		{
			//desila se promena iz forme potrebno je azurirati sessijsku promenljivu na 0
			$_SESSION["offset_order"]=0;
		}
		$lof = new loginFactory($DBBR);
		$users = $lof->createObjects("users");
		$cmb_users  = "<select class='form-control' name='userid' onChange='formTable.submit();'>";
		$cmb_users .="<option value='-1'>".getTranslation("PLG_FILTER_NO")."</option>";
		foreach ($users as $u)
		{
			$selected = "";
			if(isset($_REQUEST["userid"]) && $u->UserID == $_REQUEST["userid"])
			{
				$selected = "selected";
			}
			$cmb_users .= "<option ".$selected." value='".$u->UserID."'>" .$u->Name." ".$u->Surname. "</option>";
		}
		return $cmb_users .= "</select><input type='hidden' name='user_hit' value='true'>";		
		
	}
	
	function makeStatusFilter(& $pof)
	{
		if(isset($_REQUEST["status"]) && $_REQUEST["status"] != -1)
		{
			$pof->AddFilter("`status`='".$_REQUEST["status"]."'");
		}
		
		if(isset($_REQUEST["status_hit"]))
		{
			//desila se promena iz forme potrebno je azurirati sessijsku promenljivu na 0
			$_SESSION["offset_order"]=0;
		}
		
		$proizvodjaci = $pof->createObjects("proizvodjaci");
		$statusi = array("obradjena","neobradjena");
		$cmb_statusi  = "<select class='form-control' name='status' onChange='formTable.submit();'>";
		$cmb_statusi .="<option value='-1'>".getTranslation("PLG_FILTER_NO")."</option>";
		foreach ($statusi as $s)
		{
			$selected = "";
			if(isset($_REQUEST["status"]) && $s == $_REQUEST["status"])
			{
				$selected = "selected";
			}
			$cmb_statusi .= "<option ".$selected." value='".$s."'>" .$s. "</option>";
		}
		return $cmb_statusi .= "</select><input type='hidden' name='status_hit' value='true'>";	
	}
	
	
	function manageSort(& $pof)
	{
		global $dir;
		$sortlink = "";
		if(isset($_REQUEST["sort"]))
		{
			$sort = $_REQUEST["sort"];
			$dir = $_REQUEST["dir"];
			$pof->SetSortBy($sort,$dir);
			$sortlink = "&sort=".$sort."&dir=".$dir;
			if($dir == "asc") $dir = "desc";
			else $dir = "asc";
		}
		else $dir = "asc";
	}
?>