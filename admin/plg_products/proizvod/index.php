<?

session_start();
	/* CMS Studio 3.0 index.php */
	$_ADMINPAGES = true;
	include_once("../../../config.php");
		
	global $smarty;
	global $auth;
	
	$ObjectFactory = ObjectFactory::getInstance();
	if($auth->isActionAllowed("ACTION_PRODUCT_VIEW"))
	{
		$ap = new AdminTable();
		
		if($CMSSetting->getSettingByID(SETTING_EXCEL_EXPORT_PRODUCTS) == SETTING_TYPE_ON) 
		{
			$ap->ShowExportLinks();
		}
		$ap->SetTitle("Ažuriranje knjiga:");
		$ap->SetOffsetName("offset_prproizvodi");

		manageSort($ObjectFactory);
		
		$cmbKategorija = makeKategorijaFilter($ObjectFactory, $ap);
		$cmbGrupaProizvoda = makeGrupaProizvodaFilter($ObjectFactory, $ap);
		$comboFilterProizvodjac = new ProizvodjacFilter($ObjectFactory,$ap);
		$comboFilterProizvodjac->generateProccessComboBox();
		
		$comboFilterTipProizvoda = new TipProizvodaFilter($ObjectFactory,$ap);
		$comboFilterTipProizvoda->generateProccessComboBox();
		
		$comboFilterStatus = new ProizvodStatusFilter($ObjectFactory,$ap);
		$comboFilterStatus->generateProccessComboBox();

		$filter_array=array('naziv','kratak_opis');
		$ap->SetFilter($inputFilter->createFilter($filter_array));
	
		
		// REFAKTORISATI OVAJ DEO
		
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


		
		// ZAVRSETAK POTREBNOG REFAKTORISANJA
		$ap->SetCountAllRows($DBBR->prebrojSveSlogove($ObjectFactory->createObject("PrProizvod",-1), $ObjectFactory->filters));
		$ObjectFactory->AddLimit($ap->GetRowCount()); 
		//$ObjectFactory->AddOffset($ap->GetOffset());
		$ObjectFactory->AddOffset($_REQUEST['offset']/10);
		$ObjectFactory->ManageSort();
		$objlist = $ObjectFactory->createObjects("PrProizvod",array("SfStatus","PrTipProizvoda","PrGrupaProizvoda"));
		$ap->SetBrowseString($ObjectFactory);
		$ap->SetRecordCount(count($objlist));
		$filter_str = getBrowseString($ObjectFactory);
		$ObjectFactory->ResetFilters(); 
		$ObjectFactory->ResetLimitOffset();
		$ObjectFactory->SetSortBy("naziv");
		$tipoviproizvoda = $ObjectFactory->createObjects("PrTipProizvoda");
		$ObjectFactory->ResetSortBy();

		$header_array=array(
								"<span class='selectall' for='selectall'>".getTranslation("PLG_ALL")."<br /><div class='checkbox checkbox-primary'><input name='selectall' id='selectall' type='checkbox' /><label for='checkbox'></label></div></span>",
								getTranslation("PLG_CHANGE"),
								SortLink::generateLink(getTranslation("PLG_NAME"),"naziv"),
								//SortLink::generateLink(getTranslation("PLG_WEIGHT"),"tezina"),
								SortLink::generateLink(getTranslation("PLG_PRICE"),"cenaamp"),
								SortLink::generateLink(getTranslation("PLG_TYPE"),"tipproizvodaid")."<br/>".$comboFilterTipProizvoda->getComboBox(),
								getTranslation("PLG_GROUP")."<br/>".$cmbGrupaProizvoda,
								SortLink::generateLink(getTranslation("PLG_STATUS"),"status_id")."<br/>".$comboFilterStatus->getComboBox(),
								getTranslation("PLG_GROUP_ADD"),
								getTranslation("PLG_DELETE")
							);	
		$ap->SetHeader($header_array);

		// combobox za tipove proizvoda
		$ShTipProizvoda= new SmartyHtmlSelection("tipproizvoda",$smarty);
		foreach($tipoviproizvoda as $tp)
		{
			$ShTipProizvoda->AddValue($tp->TipProizvodaID);
			$ShTipProizvoda->AddOutput($tp->Naziv);
		}
		$ShTipProizvoda->SmartyAssign();
		
		$grupeproizvoda = $ObjectFactory->createObjects("PrGrupaProizvoda");
		
		if(count($grupeproizvoda) > 0)
		{
			$grpArray = array();
			foreach($grupeproizvoda as $grupaProizvoda)
				 $grpArray[] = $grupaProizvoda->toArrayHierarchy();
			
			$tree = new MemTree(); 
			$tree->FillItems($grpArray);
			$selGrpProiz = isset($_SESSION["grupaproizvodaid_sel"]) ? $_SESSION["grupaproizvodaid_sel"] : -1; 
			$parentgrpCmb = $tree->DrawCombobox("grupaproizvodaid",$selGrpProiz, false);
			$smarty->assign("parentgrpCmb" , $parentgrpCmb);
		}
		
		//za slicice gore-dole
		$html_img_up = "<img border=0 src='../../images/arr_up.gif'>";
		$html_img_down = "<img border=0 src='../../images/arr_down.gif'>";
		$html_img_edit = "<div class='btn btn-white'><i class='fa fa-pencil-square-o'></i></div>";
		$html_img_delete = "<div class='btn btn-white'><i class='fa fa-trash'></i></div>";
		$html_img_add = "<div class='btn btn-white'><i class='fa fa-plus-square-o' ></i></div>";
		
		//ZA SADRZAJ TABELE
		if(count($objlist)>0)
		{
			$array_order=array();
			$j=1;
			foreach($objlist as $odo)
			{
				// za htmlspecialchars na celoj tabeli pr_proizvod		
				/*$tmp_html_page = htmlspecialchars($odo->getOpis() , ENT_QUOTES);
				$tmp_htmlsmall_page = htmlspecialchars($odo->getKratakOpis() , ENT_QUOTES);
				$tmp_header = htmlspecialchars($odo->getNaziv() , ENT_QUOTES);    
				
				// correct letter Š š
				$tmp_html_page = str_replace("&amp;Scaron;","Š",$tmp_html_page);
				$tmp_html_page = str_replace("&amp;scaron;","š",$tmp_html_page);
				
				$tmp_htmlsmall_page = str_replace("&amp;Scaron;","Š",$tmp_htmlsmall_page);
				$tmp_htmlsmall_page = str_replace("&amp;scaron;","š",$tmp_htmlsmall_page);
				
				// snimanje promene unosa
				$odo->setKratakOpis($tmp_htmlsmall_page);
				$odo->setOpis($tmp_html_page);
				$odo->setNaziv($tmp_header);
				$DBBR->promeniSlog($odo);*/

				
				if($auth->isActionAllowed("ACTION_PRODUCT_MODIFY"))
				{
					if (!isset ($_REQUEST['proizvodid'])) $modify_link = "<a class='naziv' href='modify.php?".$odo->getLinkID()."'>".$html_img_edit."</a>";
					else $modify_link = "<a class='naziv' href='modify.php?".$odo->getLinkID()."&bproizvodid=".$_REQUEST['proizvodid']."'>".$html_img_edit."</a>";
				}
				else 
				{
					$modify_link = $html_img_edit;
				}
				
				if($auth->isActionAllowed("ACTION_PRODUCT_DELETE"))
				{
					$delete_link = "<a class='delete' href='delete_final.php?action=delete&".$odo->getLinkID()."'>".$html_img_delete."</a>";
				}
				else 
				{
					$delete_link = $html_img_delete;
				}
				
				if($auth->isActionAllowed("ACTION_PRODUCT_MOVE") )
				{
					$move_up = "<a href='' class='moveuplink'>".$html_img_up."</a>";
					$move_down = "<a href='' class='movedownlink'>".$html_img_down."</a>";
				}
				else 
				{
					$move_up = $html_img_up;
					$move_down = $html_img_down;
				}
				if ($j==1) $move_up = "";

				$derivated_link = "<button type='button' class='derivate' data-id=".$odo->getLinkID()."><i class='fa fa-pencil-square-o'></button>";


				$order_editbox = "<div class='edit-order' id='".$odo->getProizvodID()."'>".$odo->getOrder()."</div>";
				//$weight_editbox = "<div class='edit-tezina' id='".$odo->getProizvodID()."'>".$odo->getTezina()."</div>";
				$price_editbox = "<div class='edit-cena' id='".$odo->getProizvodID()."'>".$odo->getCenaAMP()."</div>";
				$checkbox = "<div class='checkbox checkbox-primary'><input type='checkbox' name='proizvodid[]' value='".$odo->ProizvodID."'/><label for='checkbox'></label></div>";
				$add_to_group = "<div data-link='insert_grupa.php' data-param='".$odo->ProizvodID."' class='dodaj_u_grupu'>".$html_img_add."</div>";		
				$order_class = "class='sectionsid' id='sectionsid_".$odo->getProizvodID()."'";
				array_push($array_order,$order_class);
				$row_array=array ($checkbox,
								  $modify_link ,
								  $odo->getNaziv()."&nbsp;",
								  //$weight_editbox,
								  $price_editbox,
								  $odo->getTipProizvoda()."&nbsp;",
								  $odo->getGrupaProizvoda()."&nbsp;",
								  $odo->SfStatus->Vrednost,
								  $add_to_group,
								  $delete_link	
								 );		
				$ap->AddTableRow($row_array);

				$j=2;
			}
		}
		
		// dodaju se parametri u browse string
		// koji pripadaju filteru i sort-u
		$ap->SetTdTableAttributes(array("width='10px' align='center'","width='40%' align='left'","width='10%'","width='10%'","width='10%'","width='10%'","width='10%'","width='5%' align='center'","width='5%' align='center'" ,"width='5%' align='center'","width='5%' align='center'"));
		$ap->SetTrTableAttributes($array_order);
		
		$ap->RegisterAdminPage($smarty);
		
		$smarty->display('index.tpl');
	}
	else
	{
		// show error message not enough rights
		$smarty->assign("norights_message",getTranslation("PLG_NORIGHT_VIEW"));
		$smarty->display('../../../templates/norights.tpl');
	}
		
	function makeKategorijaFilter($ObjectFactory, $ap)
		{
			if(isset($_REQUEST["kategorijaid"]))
			{
				//desila se promena iz forme potrebno je azurirati sessijsku promenljivu na 0
				$_SESSION["offset_prproizvodi"]=0;
				$ap->SetOffset(0);
				$_SESSION["sess_prkategorijaid"] = $_REQUEST["kategorijaid"];				
			}
	
			if(isset($_SESSION["sess_prkategorijaid"])){
				if($_SESSION["sess_prkategorijaid"] == -1) unset($_SESSION["sess_prkategorijaid"]);
			}
			$proizvod_ids = "";
			if(isset($_REQUEST["kategorijaid"]) && $_REQUEST["kategorijaid"] != -1)
			{
				$kategorija = $ObjectFactory->createObject("PrKategorija",$_REQUEST["kategorijaid"],array("PrProizvod"));
				foreach ($kategorija->PrProizvodList as $proiz) 
				{
					$proizvod_ids .= $proiz->ProizvodID . ",";
				}
				$proizvod_ids = substr($proizvod_ids,0,strlen($proizvod_ids)-1);
				$ObjectFactory->AddFilter("proizvodid IN (".$proizvod_ids.") ");
			}
			else{
			
				if(isset($_SESSION["sess_prkategorijaid"]) && $_SESSION["sess_prkategorijaid"] != -1)
				{
					
					$kategorija = $ObjectFactory->createObject("PrKategorija",	$_SESSION["sess_prkategorijaid"],array("PrProizvod"));
					if(!empty($kategorija->PrProizvodList))
					{
						foreach ($kategorija->PrProizvodList as $proiz) 
						{
							$proizvod_ids .= $proiz->ProizvodID . ",";
						}
						$proizvod_ids = substr($proizvod_ids,0,strlen($proizvod_ids)-1);
						$ObjectFactory->AddFilter("proizvodid IN (".$proizvod_ids.") ");
					}
					else 
					{
						$ObjectFactory->AddFilter(" 1=2 ");
					}
				}
			}
			
			$ObjectFactory1 = new ObjectFactory();
			$kategorije = $ObjectFactory1->createObjects("PrKategorija");
			$cmb_kategorije  = "<select class='form-control' name='kategorijaid' onChange='formTable.submit();'>";
			$cmb_kategorije .="<option value='-1'>".getTranslation("PLG_FILTER_NO")."</option>";
			foreach ($kategorije as $kat)
			{
				$selected = "";
				if(isset($_REQUEST["kategorijaid"]) && $kat->KategorijaID == $_REQUEST["kategorijaid"])
				{
					$selected = "selected";
				}
				else 
				if(isset($_SESSION["sess_prkategorijaid"]) && $kat->KategorijaID == $_SESSION["sess_prkategorijaid"])
				{
					$selected = "selected";
				}
				$cmb_kategorije .= "<option ".$selected." value='".$kat->KategorijaID."'>" .$kat->Naziv . "</option>";
			}
			return $cmb_kategorije .= "</select><input type='hidden' name='kategorija_hit' value='true'>";	
		}
	
		
	function makeGrupaProizvodaFilter($ObjectFactory, $ap)
	{
		// punjenje combo box-a
		$ObjectFactory1 = new ObjectFactory();
		$ObjectFactory1->Reset();
		$ObjectFactory1->SetSortBy("naziv");
		$grupeproizvoda = $ObjectFactory1->createObjects("PrGrupaProizvoda");
		$ObjectFactory1->Reset();
		$cmb_grupeproizvoda  = "<select class='form-control' name='grupaproizvodaid' onChange='formTable.submit();'>";
		$cmb_grupeproizvoda .="<option value='-1'>".getTranslation("PLG_FILTER_NO")."</option>";	
		if(isset($_REQUEST["grupaproizvodaid"]) && $_REQUEST["grupaproizvodaid"]==0)  $selected = "selected";
		else if(isset($_SESSION["sess_prgrupaproizvodaid"]) && $_SESSION["sess_prgrupaproizvodaid"]==0) $selected = "selected";
		else $selected = ""; 
		$cmb_grupeproizvoda .="<option ".$selected." value='0'>".getTranslation("PLG_FILTER_NO_INGROUP")."</option>";		
		foreach ($grupeproizvoda as $kat)
		{
			$selected = "";
			if(isset($_REQUEST["grupaproizvodaid"]) && $kat->getGrupaProizvodaID() == $_REQUEST["grupaproizvodaid"])
			{
				$selected = "selected";
			}
			else if(isset($_SESSION["sess_prgrupaproizvodaid"]) && $kat->getGrupaProizvodaID() == $_SESSION["sess_prgrupaproizvodaid"])
			{
				$selected = "selected";
			}
			$cmb_grupeproizvoda .= "<option ".$selected." value='".$kat->getGrupaProizvodaID()."'>" .$kat->getNaziv() . "</option>";
		}		
		// filtriranje
		if(isset($_REQUEST["grupaproizvodaid"]))
		{
			//desila se promena iz forme potrebno je azurirati sessijsku promenljivu na 0
			$_SESSION["offset_prproizvodi"]=0;
			$ap->SetOffset(0);
			$_SESSION["sess_prgrupaproizvodaid"] = $_REQUEST["grupaproizvodaid"];				
		}
		else if (!isset($_SESSION["sess_prgrupaproizvodaid"])) $_SESSION["sess_prgrupaproizvodaid"] = -1;
			
		$proizvod_ids = "";
		if ($_SESSION["sess_prgrupaproizvodaid"] == 0) {
			$proiz=$ObjectFactory->createObjects("PrProizvod",array("PrGrupaProizvoda"));
			foreach ($proiz as $p) {
				if (count($p->PrGrupaProizvoda)==0) $proizvod_ids .= $p->ProizvodID . ",";
			}
			$proizvod_ids = substr($proizvod_ids,0,strlen($proizvod_ids)-1);
			$ObjectFactory->AddFilter("proizvodid IN (".$proizvod_ids.") ");
		}
		if ($_SESSION["sess_prgrupaproizvodaid"] > 0) {
			
			$grupaproizvoda = $ObjectFactory->createObject("PrGrupaProizvoda",	$_SESSION["sess_prgrupaproizvodaid"],array("PrProizvod"));
			if(!empty($grupaproizvoda->PrProizvodList))
			{
				foreach ($grupaproizvoda->PrProizvodList as $proiz) 
				{
					$proizvod_ids .= $proiz->ProizvodID . ",";
				}
				$proizvod_ids = substr($proizvod_ids,0,strlen($proizvod_ids)-1);
				$ObjectFactory->AddFilter("proizvodid IN (".$proizvod_ids.") ");
			}
		}
			
		return $cmb_grupeproizvoda .= "</select><input type='hidden' name='grupaproizvoda_hit' value='true'>";	
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
	
	function getBrowseString($factory)
	{
		$str = "";
		if(count($factory->filters)!=0)
		{
			foreach ($factory->filters as $f) {
				$f = str_replace("'","",$f);
				$str .= "&".$f;
			}
		}
		return $str;
	}
	
	
	
?>