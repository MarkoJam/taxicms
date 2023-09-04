<?
	/* CMS Studio 3.0 modify.php */
	
	$_ADMINPAGES = true;
	include_once("../../../config.php");
		
	global $smarty;
	global $auth;
	
	$ObjectFactory = ObjectFactory::getInstance();
	if($auth->isActionAllowed("ACTION_PRODUCT_GROUPPRODUCT_MODIFY"))
	{
		if($_REQUEST["mode"]=='insert') $_REQUEST["grupaproizvodaid"]=-1;						
		if(isset($_REQUEST["grupaproizvodaid"]))
		{
			$grupaProizvodaId = $_REQUEST["grupaproizvodaid"];			
			$ObjectFactory->Reset();
			$ObjectFactory->SetSortBy("proizvodgrupaproiz_order");
			//$ObjectFactory->SetDebugOn();
			$grupaproizvoda = $ObjectFactory->createObject("PrGrupaProizvoda",$grupaProizvodaId,array("PrProizvod"));
			// deo za insertovanje novog sloga
			if(($_REQUEST["mode"])=='insert')
			{	
				$smarty->assign("mode", 'insert');
				$parent_group=$_REQUEST['parentid'];
			}	
			else 
			{	
				$smarty->assign("mode", 'edit');
				$parent_group=$grupaproizvoda->getParentID();
			}	
			if(isset($_REQUEST["active"])) $smarty->assign("active", 3);			
			else $smarty->assign("active", 1);			

			$ObjectFactory->Reset();
			$smarty->assign($grupaproizvoda->toArray());

			// da li je grupa proizvoda ima proizvode i nije kit grupa
			$ObjectFactory->Reset();
			$ObjectFactory->AddFilter("grupaproizvodaid = " . $grupaProizvodaId);
			$products = $ObjectFactory->createObjects("PrProizvodGrupaProiz");
			$ObjectFactory->Reset();			
			if (count($products)>0) $haveproducts=true;
			else $haveproducts=false;
			$grp = $ObjectFactory->createObject("PrGrupaProizvoda",$grupaProizvodaId);
			if ($grp->getKitGroup()==1) $haveproducts=false;


			// Template
			$ObjectFactory->Reset();
			//$ObjectFactory->SetDebugOn();
			$templates = $ObjectFactory->createObjects("Template");
			//$ObjectFactory->SetDebugOff();
			$ObjectFactory->Reset();
				
			// Assign Template to smarty
			$shTemplate = new SmartyHtmlSelection("template",$smarty);
			$shTemplate->AddOutput("Bez izmene templejta");$shTemplate->AddValue(5);
			foreach ($templates as $t) 
			{
				$shTemplate->AddOutput($t->getTitle());
				$shTemplate->AddValue($t->getTemplateID());
			}
			$shTemplate->AddSelected($grupaproizvoda->Template->getTemplateID());
			$shTemplate->SmartyAssign();
			
			// Parent groups
			$ObjectFactory->Reset();
			$ObjectFactory->AddFilter("grupaproizvodaid <> " . $grupaProizvodaId);
			$parentGrp = $ObjectFactory->createObjects("PrGrupaProizvoda");
			//$ObjectFactory->SetDebugOff();
			$ObjectFactory->Reset();
			
			// Assign Parent groups to smarty
			if(count($parentGrp) > 0)
			{
				$grpArray = array();
				foreach($parentGrp as $grupaProizvoda)
					$grpArray[] = $grupaProizvoda->toArrayHierarchy();
				$tree = new MemTree(); 
				$tree->FillItems($grpArray);
				$parentgrpCmb = $tree->DrawCombobox("parentid",$parent_group);
				$smarty->assign("parentgrpCmb" , $parentgrpCmb);
			}
			
			// Status grupe proizvoda
			$ObjectFactory->Reset();
			$ObjectFactory->AddFilter("tip_status_id = " . STATUS_TIP_PRODUCTGROUP);
			$statuses = $ObjectFactory->createObjects("SfStatus");
			$ObjectFactory->Reset();
			
			// Assign Status to smarty
			$shStatus = new SmartyHtmlSelection("status",$smarty);
			foreach ($statuses as $s) 
			{
				$shStatus->AddOutput($s->Vrednost);
				$shStatus->AddValue($s->StatusID);
			}
			$shStatus->AddSelected($grupaproizvoda->SfStatus->getStatusID());
			$shStatus->SmartyAssign();
			
			// Status proizvoda
			$ObjectFactory->Reset();
			$ObjectFactory->AddFilter("tip_status_id = " . STATUS_TIP_PRODUCT);
			$statusiProizvoda = $ObjectFactory->createObjects("SfStatus");
			$ObjectFactory->Reset();
			
			//ZA HEDER TABELE
			$ap = new AdminTable();
			
			$ap->SetOffsetName("grupaproizproizvodioffset_".$grupaproizvoda->getGrupaProizvodaID());
			
			$ap->SetHeader(
							array(
								getTranslation("PLG_NAME"),
								getTranslation("PLG_STATUS"),
								getTranslation("PLG_DELETE"),
								getTranslation("PLG_ORDER")
								));
			
			$ap->SetCountAllRows(count($grupaproizvoda->PrProizvodList));
			$ap->AddBrowseString("grupaproizvodaid=".$grupaproizvoda->getGrupaProizvodaID());
			$ap->SetRecordCount(count($grupaproizvoda->PrProizvodList));
			$ap->SetRowCount(10000);
			
			//za slicice gore-dole
			$html_img_up = "<img border=0 src='images/arr_up.gif'>";
			$html_img_down = "<img border=0 src='images/arr_down.gif'>";
			$html_img_delete = "<div class='btn btn-white'><i class='fa fa-minus-square-o'></i></div>";
			$filter_str = "";

			// diskonti za kategorije user-a
			if ($haveproducts)	{
				$ObjectFactory->Reset();
				$cats = $ObjectFactory->createObjects("SfUserCategory");
				$ObjectFactory->Reset();
				foreach ($cats as $cat) 
				{
					$cat_array = $cat->toArray();
					$upit ="SELECT `discount` FROM `ucategorygrupaproiz` WHERE `usercategoryid`=".$cat->ID." and `grupaproizvodaid`=".$_REQUEST["grupaproizvodaid"]."";
					$result_row = $DBBR->con->get_row($upit);
					$disvalue=$result_row->discount;
					$cat_array = array_merge($cat_array, array("disvalue" => $disvalue));
					$cat_all[] = $cat_array;
				}
				$smarty->assign("cats_all",$cat_all);
			} 
			$smarty->assign("haveproducts",$haveproducts);

			$array_order=array();

			$j=1;
			foreach($grupaproizvoda->PrProizvodList as $proiz)
			{
				if($auth->isActionAllowed("ACTION_PRODUCT_PRODUCTGROUP_MOVE"))
				{
					$move_up = "<a href='javascript:void(0)' class='moveuplink'>".$html_img_up."</a>";
					$move_down = "<a href='javascript:void(0)' class='movedownlink'>".$html_img_down."</a>";
				}
				else 
				{
					$move_up = $html_img_up;
					$move_down = $html_img_down;
				}
				if ($j==1) $move_up = "";

				$order_class = "class='sectionsid' id='sectionsid_".$proiz->getProizvodID()."'";
				array_push($array_order,$order_class);

				$ObjectFactory->Reset();
				$ObjectFactory->AddFilter("proizvodid = " . $proiz->ProizvodID . " AND grupaproizvodaid = " . $grupaproizvoda->getGrupaProizvodaID());
				$proizgrpproiz = $ObjectFactory->createObjects("PrProizvodGrupaProiz");
				$ObjectFactory->Reset();
				foreach($proizgrpproiz as $gp)
				{
					$order=$gp->getOrder();
				}
				
				if ($grupaproizvoda->getKitGroup()==1) 
					$naziv="<a id='tnaziv' class='naziv' href='../proizvod/modify.php?grpproizbackid=".$grupaproizvoda->getGrupaProizvodaID()."&proizvodid=".$proiz->ProizvodID."'>".$proiz->getNaziv()." - ".$gp->getKitNum()."</a>";
				else 	
					$naziv="<a id='tnaziv' class='naziv' href='../proizvod/modify.php?grpproizbackid=".$grupaproizvoda->getGrupaProizvodaID()."&proizvodid=".$proiz->ProizvodID."'>".$proiz->getNaziv()."</a>";
				$ap->AddTableRow(
							array(
								$naziv,
								GetVrednostStatusa($proiz->SfStatus->getStatusID(), $statusiProizvoda),
								"<a href='#' class='obrisi-proizvod' tag='".$grupaproizvoda->getGrupaProizvodaID()."-".$proiz->ProizvodID."'>".$html_img_delete."</a>",
							//	$move_up,
							//	$move_down,
								$order
								)
							);
				$j=2;
			}
			$ap->SetTrTableAttributes($array_order);
			$ap->RegisterAdminPage($smarty);
			if(count($grupaproizvoda->PrProizvodList) != 0)
			{
				$smarty->assign("table_not_empty", "true");
			}
		}

		$smarty->assign("grupaid",$grupaproizvoda->getGrupaProizvodaID());
		$smarty->display('modify.tpl');
	}
	else
	{
		// show error message not enough rights
		$smarty->assign("norights_message",getTranslation("PLG_NORIGHT"));
		$smarty->display('../../../templates/norights.tpl');
	}
	
	function GetVrednostStatusa($statusid, $statusi)
	{
		foreach($statusi as $status)
		{
			if($status->getStatusID() == $statusid) return $status->getVrednost();
		}
		
		return "";
	}

?>