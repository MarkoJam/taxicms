<?
	/* CMS Studio 3.0 index.php */
	$_ADMINPAGES = true;

	include_once("../../../config.php");

	global $smarty;
	global $auth;

	if($auth->isActionAllowed("ACTION_MODULE_VIEW"))
	{
		// kreiram administracionu tabelu
		$ap = new AdminTable();
		$ap->SetTitle("Promena vesti:");

		//$comboModuleCategory = new ModuleCategoryFilter($ObjectFactory,$ap);
		//$comboModuleCategory->generateProccessComboBox();

		$comboModuleCategory = makeModuleCategoryFilter($ObjectFactory, $ap);
		//$comboModuleCategory->generateProccessComboBox();

		$comboModuleStatus = new ModuleStatusFilter($ObjectFactory,$ap);
		$comboModuleStatus->generateProccessComboBox();

		$filter_array=array('header','shorthtml');
		$ap->SetFilter($inputFilter->createFilter($filter_array));

		$ap->SetHeader(array(
							"<span class='promeni'>".getTranslation("PLG_CHANGE")."</span>",
							SortLink::generateLink(getTranslation("PLG_NAME"),"header"),
							SortLink::generateLink(getTranslation("PLG_CATEGORY"))."<br/>".$comboModuleCategory,//.$comboModuleCategory->getComboBox(),
							SortLink::generateLink(getTranslation("PLG_STATUS"),"status_id")."<br/>".$comboModuleStatus->getComboBox(),
							SortLink::generateLink(getTranslation("PLG_DATE"),"date"),
							getTranslation("PLG_HP"),
							getTranslation("PLG_VIEW"),
							getTranslation("PLG_DELETE")
		));
		$ap->SetOffsetName("offset_module");
		$ap->SetCountAllRows($DBBR->prebrojSveSlogove($ObjectFactory->createObject("Module",-1) , $ObjectFactory->filters));

		$ObjectFactory->AddLimit($ap->GetRowCount());
		$ObjectFactory->AddOffset($ap->GetOffset());
		$ObjectFactory->ManageSort();

		//$ObjectFactory->setDebugOn();
		$objlist = $ObjectFactory->createObjects("Module",array("ModuleCategory","SfStatus"));

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
			if (isset($_SESSION["sess_modulecategoryid"]) && ($_SESSION["sess_modulecategoryid"] != -1) && (!isset($_REQUEST["sortby"])))
			{
				foreach($objlist as $nw)
				{
					$nid=$nw->getModuleID();
					$ncid=$_SESSION["sess_modulecategoryid"];
					$ObjectFactory->Reset();
					$ObjectFactory->AddFilter("module_id = " . $nid. " AND module_category_id = " .$ncid);
					$nc = $ObjectFactory->createObjects("ModuleModuleCategory");
					$ObjectFactory->Reset();
					foreach($nc as $module)
					{
						$nw->Order=$module->getModuleModuleCategoryOrder();
					}
				}
				usort($objlist,function($first,$second){
					return $first->Order > $second->Order;
				});
			}
			foreach($objlist as $nw)
			{
				$module_type_title = "";
				if($nw->getModuleType()->getModuleTypeID() == "-1") $module_type_title = getTranslation("PLG_NONE");
				else $module_type_title = $nw->getModuleType()->getTitle();

				if($auth->isActionAllowed("ACTION_MODULE_MODIFY"))
				{
					$modify_link = "<a class='naziv' href='modify.php?module_id=".$nw->getModuleID()."'>".$html_img_edit."</a>";
				}
				else
				{
					$modify_link = $html_img_edit;
				}

				if($auth->isActionAllowed("ACTION_MODULE_DELETE"))
				{
					$delete_link = "<a href='delete_final.php?module_id=".$nw->getModuleID()."' >".$html_img_delete."</a>";
				}
				else
				{
					$delete_link = $html_img_delete;
				}

				$ap->AddTableRow(
						  array(
								$modify_link,
								$nw->getHeader() ."&nbsp;",
								$nw->getModuleCategoryPrint(true) ."&nbsp;",
								$nw->SfStatus->getVrednost()."&nbsp;",
								date("d-M-Y",$nw->getDate()),
								hp_link($nw->getModuleID(),'module'),
								view_link($nw->getModuleID(),'module',$nw->getHeader()),
								$delete_link));
			}
		}
		$ap->RegisterAdminPage($smarty);

		$smarty->display('index.tpl');
	}
	else
	{
		// show error message not enough rights
		$smarty->assign("norights_message",getTranslation("PLG_MODULE_NORIGHT_VIEW"));
		$smarty->display('../../templates/norights.tpl');
	}

	function makeModuleCategoryFilter($ObjectFactory, $ap)
	{
		// combo box
		$ObjectFactory1 = new ObjectFactory();
		$kategorije = $ObjectFactory1->createObjects("ModuleCategory");
		$cmb_kategorije  = "<select class='form-control' name='modulecategoryid' onChange='formTable.submit();'>";
		$cmb_kategorije .="<option value='-1'>".getTranslation("PLG_FILTER_NO")."</option>";
		foreach ($kategorije as $kat)
		{
			$selected = "";
			if(isset($_REQUEST["modulecategoryid"]) && $kat->getModuleCategoryID() == $_REQUEST["modulecategoryid"])
			{
				$selected = "selected";
			}
			else
			{
				if(isset($_SESSION["sess_modulecategoryid"]) && $kat->getModuleCategoryID() == $_SESSION["sess_modulecategoryid"])
				{
					$selected = "selected";
				}
			}

			$cmb_kategorije .= "<option ".$selected." value='".$kat->getModuleCategoryID()."'>" .$kat->getTitle() . "</option>";
		}
		// filteri
		if(isset($_REQUEST["modulecategoryid"]))
		{
			//desila se promena iz forme potrebno je azurirati sessijsku promenljivu na 0
			$_SESSION["offset_module"]=0;
			$ap->SetOffset(0);
			$_SESSION["sess_modulecategoryid"] = $_REQUEST["modulecategoryid"];
		}

		if(isset($_SESSION["sess_modulecategoryid"]))
		{
			if($_SESSION["sess_modulecategoryid"] == -1) unset($_SESSION["sess_modulecategoryid"]);
		}

		$module_ids = "";
		if(isset($_REQUEST["modulecategoryid"]) && $_REQUEST["modulecategoryid"] != -1)
		{
			$kategorija = $ObjectFactory->createObject("ModuleCategory",$_REQUEST["modulecategoryid"], array("Module")," * ");
			foreach ($kategorija->Module as $nw)
			{
				$module_ids .= $nw->getModuleID(). ",";
			}
			$module_ids = substr($module_ids,0,strlen($module_ids)-1);
			$ObjectFactory->AddFilter("module_id IN (".$module_ids.") ");
		}
		else
		{
			if(isset($_SESSION["sess_modulecategoryid"]) && $_SESSION["sess_modulecategoryid"] != -1)
			{

				$kategorija = $ObjectFactory->createObject("ModuleCategory",	$_SESSION["sess_modulecategoryid"],array("Module"));
				if(!empty($kategorija->Module))
				{
					foreach ($kategorija->Module as $nw)
					{
						$module_ids .= $nw->getModuleID(). ",";
					}
					$module_ids = substr($module_ids,0,strlen($module_ids)-1);
					$ObjectFactory->AddFilter("module_id IN (".$module_ids.") ");
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
