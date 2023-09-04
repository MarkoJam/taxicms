<?
	/* CMS Studio 3.0 index.php */
	$_ADMINPAGES = true;

	include_once("../../../config.php");

	global $smarty;
	global $auth;

	if($auth->isActionAllowed("ACTION_OPTION_VIEW"))
	{
		// kreiram administracionu tabelu
		$ap = new AdminTable();
		$ap->SetTitle("Promena vesti:");

		//$comboOptionCategory = new OptionCategoryFilter($ObjectFactory,$ap);
		//$comboOptionCategory->generateProccessComboBox();

		//$comboOptionCategory = makeOptionCategoryFilter($ObjectFactory, $ap);
		//$comboOptionCategory->generateProccessComboBox();

		$comboOptionStatus = new OptionStatusFilter($ObjectFactory,$ap);
		$comboOptionStatus->generateProccessComboBox();		
		$comboOptionModule = new OptionModuleFilter($ObjectFactory,$ap);
		$comboOptionModule->generateProccessComboBox();

		$filter_array=array('header','shorthtml');
		$ap->SetFilter($inputFilter->createFilter($filter_array));

		$ap->SetHeader(array(
							"<span class='promeni'>".getTranslation("PLG_CHANGE")."</span>",
							SortLink::generateLink(getTranslation("PLG_NAME"),"header"),
							SortLink::generateLink(getTranslation("PLG_STATUS"),"status_id")."<br/>".$comboOptionStatus->getComboBox(),
							SortLink::generateLink(getTranslation("PLG_MODULES"),"module_id")."<br/>".$comboOptionModule->getComboBox(),
							SortLink::generateLink(getTranslation("PLG_DATE"),"date"),
							getTranslation("PLG_DELETE")
		));
		$ap->SetOffsetName("offset_option");
		$ap->SetCountAllRows($DBBR->prebrojSveSlogove($ObjectFactory->createObject("Option",-1) , $ObjectFactory->filters));

		$ObjectFactory->AddLimit($ap->GetRowCount());
		$ObjectFactory->AddOffset($ap->GetOffset());
		$ObjectFactory->ManageSort();

		//$ObjectFactory->setDebugOn();
		$objlist = $ObjectFactory->createObjects("Option",array("OptionCategory","SfStatus","Module"));

		$ap->SetBrowseString($ObjectFactory);

		$ObjectFactory->ResetFilters();
		$ObjectFactory->ResetLimitOffset();

		//za slicice gore-dole
		$html_img_edit = "<div class='btn btn-white'><i class='fa fa-pencil-square-o'></i></div>";
		$html_img_delete = "<div class='btn btn-white'><i class='fa fa-trash'></i></div>";
		$html_img_copy = "<i class='fa fa-clone' aria-hidden='true'></i>";

		$ap->SetRecordCount(count($objlist));

		//ZA SADRZAJ TABELE
		if(!empty($objlist))
		{
			if (isset($_SESSION["sess_optioncategoryid"]) && ($_SESSION["sess_optioncategoryid"] != -1) && (!isset($_REQUEST["sortby"])))
			{
				foreach($objlist as $nw)
				{
					$nid=$nw->getOptionID();
					$ncid=$_SESSION["sess_optioncategoryid"];
					$ObjectFactory->Reset();
					$ObjectFactory->AddFilter("option_id = " . $nid. " AND option_category_id = " .$ncid);
					$nc = $ObjectFactory->createObjects("OptionOptionCategory");
					$ObjectFactory->Reset();
					foreach($nc as $option)
					{
						$nw->Order=$option->getOptionOptionCategoryOrder();
					}
				}
				usort($objlist,function($first,$second){
					return $first->Order > $second->Order;
				});
			}
			foreach($objlist as $nw)
			{
				$option_type_title = "";
				if($nw->getOptionType()->getOptionTypeID() == "-1") $option_type_title = getTranslation("PLG_NONE");
				else $option_type_title = $nw->getOptionType()->getTitle();

				if($auth->isActionAllowed("ACTION_OPTION_MODIFY"))
				{
					$modify_link = "<a class='naziv' href='modify.php?option_id=".$nw->getOptionID()."'>".$html_img_edit."</a>";
				}
				else
				{
					$modify_link = $html_img_edit;
				}

				if($auth->isActionAllowed("ACTION_OPTION_DELETE"))
				{
					$delete_link = "<a href='delete_final.php?option_id=".$nw->getOptionID()."' >".$html_img_delete."</a>";
				}
				else
				{
					$delete_link = $html_img_delete;
				}
				$ap->AddTableRow(
						  array(
								$modify_link,
								$nw->getHeader() ."&nbsp;",
								$nw->SfStatus->getVrednost()."&nbsp;",
								$nw->Module->getHeader()."&nbsp;",
								date("d-M-Y",$nw->getDate()),
								$delete_link));
			}
		}
		$ap->RegisterAdminPage($smarty);

		$smarty->display('index.tpl');
	}
	else
	{
		// show error message not enough rights
		$smarty->assign("norights_message",getTranslation("PLG_OPTION_NORIGHT_VIEW"));
		$smarty->display('../../templates/norights.tpl');
	}

	function makeOptionCategoryFilter($ObjectFactory, $ap)
	{
		// combo box
		$ObjectFactory1 = new ObjectFactory();
		$kategorije = $ObjectFactory1->createObjects("OptionCategory");
		$cmb_kategorije  = "<select class='form-control' name='optioncategoryid' onChange='formTable.submit();'>";
		$cmb_kategorije .="<option value='-1'>".getTranslation("PLG_FILTER_NO")."</option>";
		foreach ($kategorije as $kat)
		{
			$selected = "";
			if(isset($_REQUEST["optioncategoryid"]) && $kat->getOptionCategoryID() == $_REQUEST["optioncategoryid"])
			{
				$selected = "selected";
			}
			else
			{
				if(isset($_SESSION["sess_optioncategoryid"]) && $kat->getOptionCategoryID() == $_SESSION["sess_optioncategoryid"])
				{
					$selected = "selected";
				}
			}

			$cmb_kategorije .= "<option ".$selected." value='".$kat->getOptionCategoryID()."'>" .$kat->getTitle() . "</option>";
		}
		// filteri
		if(isset($_REQUEST["optioncategoryid"]))
		{
			//desila se promena iz forme potrebno je azurirati sessijsku promenljivu na 0
			$_SESSION["offset_option"]=0;
			$ap->SetOffset(0);
			$_SESSION["sess_optioncategoryid"] = $_REQUEST["optioncategoryid"];
		}

		if(isset($_SESSION["sess_optioncategoryid"]))
		{
			if($_SESSION["sess_optioncategoryid"] == -1) unset($_SESSION["sess_optioncategoryid"]);
		}

		$option_ids = "";
		if(isset($_REQUEST["optioncategoryid"]) && $_REQUEST["optioncategoryid"] != -1)
		{
			$kategorija = $ObjectFactory->createObject("OptionCategory",$_REQUEST["optioncategoryid"], array("Option")," * ");
			foreach ($kategorija->Option as $nw)
			{
				$option_ids .= $nw->getOptionID(). ",";
			}
			$option_ids = substr($option_ids,0,strlen($option_ids)-1);
			$ObjectFactory->AddFilter("option_id IN (".$option_ids.") ");
		}
		else
		{
			if(isset($_SESSION["sess_optioncategoryid"]) && $_SESSION["sess_optioncategoryid"] != -1)
			{

				$kategorija = $ObjectFactory->createObject("OptionCategory",	$_SESSION["sess_optioncategoryid"],array("Option"));
				if(!empty($kategorija->Option))
				{
					foreach ($kategorija->Option as $nw)
					{
						$option_ids .= $nw->getOptionID(). ",";
					}
					$option_ids = substr($option_ids,0,strlen($option_ids)-1);
					$ObjectFactory->AddFilter("option_id IN (".$option_ids.") ");
				}
				else
				{
					$ObjectFactory->AddFilter(" 1=2 ");
				}
			}
		}

		return $cmb_kategorije .= "</select><input type='hidden' name='kategorija_hit' value='true'>";
	}

?>
