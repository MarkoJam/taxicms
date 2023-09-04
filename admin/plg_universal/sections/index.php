<?
	/* CMS Studio 3.0 index.php */
	$_ADMINPAGES = true;

	include_once("../../../config.php");

	global $smarty;
	global $auth;

	if($auth->isActionAllowed("ACTION_SECTIONS_VIEW"))
	{

		// kreiram administracionu tabelu
		$ap = new AdminTable();
		$ap->SetTitle("Promena vesti:");

		$comboSectionsCategory = makeSectionsCategoryFilter2($ObjectFactory, $ap);
		//$comboSectionsCategory->generateProccessComboBox();

		//$filter_array=array('header','shorthtml');
		//$ap->SetFilter($inputFilter->createFilter($filter_array));
		$ObjectFactory->AddFilter(makeSectionsCategoryFilter1($ObjectFactory, $ap));
		$ap->SetHeader(array(
							getTranslation("PLG_CHANGE"),
							SortLink::generateLink(getTranslation("PLG_NAME"),"header"),
							SortLink::generateLink(getTranslation("PLG_CATEGORY"))."<br/>".$comboSectionsCategory,//.$comboSectionsCategory->getComboBox(),
							SortLink::generateLink(getTranslation("PLG_STATUS"),"status_id")."<br/>",//.$comboSectionsStatus->getComboBox(),
							getTranslation("PLG_DELETE")
		));
		$ap->SetOffsetName("offset_sections");
		$ap->SetCountAllRows($DBBR->prebrojSveSlogove($ObjectFactory->createObject("Sections",-1) , $ObjectFactory->filters));

		$ObjectFactory->AddLimit($ap->GetRowCount());
		$ObjectFactory->AddOffset($ap->GetOffset());
		$ObjectFactory->ManageSort('sections');
		//$ObjectFactory->ManageSort();

		//$ObjectFactory->setDebugOn();
		$objlist = $ObjectFactory->createObjects("Sections",array("SectionsCategory","SfStatus"));

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

			if (isset($_SESSION["sess_sectionscategoryid"]) && ($_SESSION["sess_sectionscategoryid"] != -1) && (!isset($_REQUEST["sortby"])))
			{
				foreach($objlist as $nw)
				{
					$nid=$nw->getSectionsID();
					$ncid=$_SESSION["sess_sectionscategoryid"];
					$ObjectFactory->Reset();
					$ObjectFactory->AddFilter("sections_id = " . $nid. " AND sections_category_id = " .$ncid);
					$nc = $ObjectFactory->createObjects("SectionsSectionsCategory");
					$ObjectFactory->Reset();
					foreach($nc as $sections)
					{
						$nw->Order=$sections->getSectionsSectionsCategoryOrder();
					}
				}
				usort($objlist,function($first,$second){
					return $first->Order > $second->Order;
				});
			}
			foreach($objlist as $nw)
			{
				if($auth->isActionAllowed("ACTION_SECTIONS_MODIFY"))
				{
					$modify_link = "<a class='naziv' href='modify.php?sections_id=".$nw->getSectionsID()."'>".$html_img_edit."</a>";
				}
				else
				{
					$modify_link = $html_img_edit;
				}

				if($auth->isActionAllowed("ACTION_SECTIONS_DELETE"))
				{
					$delete_link = "<a href='delete_final.php?sections_id=".$nw->getSectionsID()."' >".$html_img_delete."</a>";
				}
				else
				{
					$delete_link = $html_img_delete;
				}

				$ap->AddTableRow(
						  array(
								$modify_link,
								$nw->getHeader() ."&nbsp;",
								$nw->getSectionsCategoryPrint() ."&nbsp;",
								$nw->SfStatus->getVrednost()."&nbsp;",
								$delete_link));
			}
		}
		$ap->RegisterAdminPage($smarty);

		$smarty->display('index.tpl');
	}
	else
	{
		// show error message not enough rights
		$smarty->assign("norights_message",getTranslation("PLG_SECTIONS_NORIGHT_VIEW"));
		$smarty->display('../../templates/norights.tpl');
	}

	function makeSectionsCategoryFilter1($ObjectFactory, $ap)
	{
		if(isset($_REQUEST["sectionscategoryid"]))
		{
			//desila se promena iz forme potrebno je azurirati sessijsku promenljivu na 0
			$_SESSION["offset_sections"]=0;
			$ap->SetOffset(0);
			$_SESSION["sess_sectionscategoryid"] = $_REQUEST["sectionscategoryid"];
		}

		if(isset($_SESSION["sess_sectionscategoryid"]))
		{
			if($_SESSION["sess_sectionscategoryid"] == -1) unset($_SESSION["sess_sectionscategoryid"]);
		}

		$sections_ids = "";
		if(isset($_REQUEST["sectionscategoryid"]) && $_REQUEST["sectionscategoryid"] != -1)
		{
			$kategorija = $ObjectFactory->createObject("SectionsCategory",$_REQUEST["sectionscategoryid"], array("Sections")," * ");
			foreach ($kategorija->Sections as $nw)
			{
				$sections_ids .= $nw->getSectionsID(). ",";
			}
			$sections_ids = substr($sections_ids,0,strlen($sections_ids)-1);
			$filters="sections_id IN (".$sections_ids.") ";
			$ObjectFactory->AddFilter("sections_id IN (".$sections_ids.") ");
		}
		else
		{
			if(isset($_SESSION["sess_sectionscategoryid"]) && $_SESSION["sess_sectionscategoryid"] != -1)
			{
				$kategorija = $ObjectFactory->createObject("SectionsCategory",	$_SESSION["sess_sectionscategoryid"],array("Sections"));
				if(!empty($kategorija->Sections))
				{
					foreach ($kategorija->Sections as $nw)
					{
						$sections_ids .= $nw->getSectionsID(). ",";
					}
					$sections_ids = substr($sections_ids,0,strlen($sections_ids)-1);
					$filters="sections_id IN (".$sections_ids.") ";
					$ObjectFactory->AddFilter("sections_id IN (".$sections_ids.") ");
				}
				else
				{

					$filters=" 1=2 ";
					$ObjectFactory->AddFilter(" 1=2 ");
				}
			}
			else {
				$filters=" 1=1 ";
				$ObjectFactory->AddFilter(" 1=1 ");
			}

		}
		return $filters;
	}
	function makeSectionsCategoryFilter2($ObjectFactory, $ap)
	{
		$ObjectFactory1 = new ObjectFactory();
		$kategorije = $ObjectFactory1->createObjects("SectionsCategory");
		$cmb_kategorije  = "<select class='form-control' name='sectionscategoryid' onChange='formTable.submit();'>";
		$cmb_kategorije .="<option value='-1'>".getTranslation("PLG_FILTER_NO")."</option>";
		foreach ($kategorije as $kat)
		{
			$selected = "";
			if(isset($_REQUEST["sectionscategoryid"]) && $kat->getSectionsCategoryID() == $_REQUEST["sectionscategoryid"])
			{
				$selected = "selected";
			}
			else
			{
				if(isset($_SESSION["sess_sectionscategoryid"]) && $kat->getSectionsCategoryID() == $_SESSION["sess_sectionscategoryid"])
				{
					$selected = "selected";
				}
			}

			$cmb_kategorije .= "<option ".$selected." value='".$kat->getSectionsCategoryID()."'>" .$kat->getTitle() . "</option>";
		}
		return $cmb_kategorije .= "</select><input type='hidden' name='kategorija_hit' value='true'>";
	}

?>
