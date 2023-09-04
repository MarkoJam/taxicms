<?
	/* CMS Studio 3.0 modify.php */
	
	$_ADMINPAGES = true;
	include_once("../../../config.php");
		
	global $smarty;
	global $auth;
	
	$ObjectFactory = ObjectFactory::getInstance();
			
	// velicine
	$ObjectFactory->ResetFilters();
	$velicine= $ObjectFactory->createObjects("PrVelicina");
	$ObjectFactory->ResetFilters();
	foreach($velicine as $vel)
	{
		$ObjectFactory->AddFilter("proizvodid = " . $_REQUEST['proizvodid'] . " AND velicinaid = " . $vel->getVelicinaID());
		$prvelicine = $ObjectFactory->createObjects("PrProizvodVelicina");
		$ObjectFactory->Reset();	
		if(count($prvelicine) > 0) $exist=true;
		else $exist = false;
		$velic=$vel->toArray();	
		if(count($prvelicine) > 0) $prvelicine=$prvelicine[0]->toArray();
		else $prvelicine=array();
		$velic = array_merge($velic, array("exist" => $exist), array("prvelicine" => $prvelicine));				
		$vel_arr[]=$velic;			
	}
	$smarty->assign("velicine",$vel_arr);
	
		
	if($auth->isActionAllowed("ACTION_PROJECT_MODIFY"))
	{
		if(isset($_REQUEST["mode"])) $_REQUEST["proizvodid"]=-1;				
		if(isset($_REQUEST["proizvodid"]))
		{
			// dohvatanje svih podataka o proizvodu
			$proiz = $ObjectFactory->createObject("PrProizvod", $_REQUEST["proizvodid"],array("SfStatus","SfCountries","PrKarakteristika","PrTipProizvoda"));

			// deo za insertovanje novog sloga
			if(isset($_REQUEST["mode"])) 
			{	
				$smarty->assign("mode", 'insert');
				$smarty->assign("tipproizvodaid",$_REQUEST['tipproizvodaid']);
				$tpid=$_REQUEST['tipproizvodaid'];
			}	
			else 
			{	
				$smarty->assign("mode", 'edit');
				$smarty->assign("tipproizvodaid",$proiz->PrTipProizvoda->TipProizvodaID);
				$tpid=$proiz->PrTipProizvoda->TipProizvodaID; 
			}	
			$tip = $ObjectFactory->createObject("PrTipProizvoda",$tpid);
			$smarty->assign("tipproizvodanaziv",$tip->Naziv);
			
			// kreiram drop down listu sa svim proizvodjacima
			$proizvodjaci = $ObjectFactory->createObjects("PrProizvodjac");
			
			$shProizvodjaci= new SmartyHtmlSelection("proizvodj",$smarty);
			if(count($proizvodjaci) > 0)
			{
				foreach($proizvodjaci as $proizvodj)
				{
					$shProizvodjaci->AddValue($proizvodj->getProizvodjacID());
					$shProizvodjaci->AddOutput($proizvodj->getNaziv());
					
					if($proiz->PrProizvodjac->getProizvodjacID() == $proizvodj->getProizvodjacID())
					{
						$shProizvodjaci->AddSelected($proizvodj->getProizvodjacID());							
					}
				}
			}
			$shProizvodjaci->SmartyAssign();

			// kreiram listu sa vezanim proizvodima
			$vproizid_all = array();
			$vproiz_all = array();
			$delete_button = array();
			$ObjectFactory->ResetFilters();
			$ObjectFactory->AddFilter("proizvodid = " . $_REQUEST["proizvodid"]);
			$prpr = $ObjectFactory->createObjects("PrProizvodProiz");
			$ObjectFactory->ResetFilters();
			
			$ap = new AdminTable();
			$ap->SetHeader(
						array(
							getTranslation("PLG_CODE")."/".getTranslation("PLG_NAME"),
							getTranslation("PLG_QUANTITY"),
							getTranslation("PLG_PRICE"),
							getTranslation("PLG_VALUE")."<br><input id='suma' type='text' value='0'>",
							getTranslation("PLG_DELETE")
				)
			);			
			
			$ap->SetOffsetName("offset_templtplgid");
			$ap->SetCountAllRows(count($prpr));	
			$ap->SetRowCount(count($prpr)+1);

			$html_img_delete = "<div class='btn btn-white'><i class='fa fa-minus-square-o'></i></div>";
			
			
			foreach($prpr as $pr)
			{
				$proiz_main=$ObjectFactory->createObject("PrProizvod",$pr->getVProizvodID());
				$modify_plugin = $proiz_main->getSifra()." ".$proiz_main->getNaziv();
				$quantity_plugin="<input data-param='proizvodid=".$pr->getProizvodID()."&vproizvodid=".$pr->getVProizvodID()."' name='kolicina' id='kolicina' type='text' value='".$pr->getKolicina()."'>";
				$price_plugin="<p id='cena'>".$proiz_main->getCenaA()."</p>";
				$value_plugin="<input name='vrednost' id='vrednost' type='text' value='".$proiz_main->getCenaA() * $pr->getKolicina()."' disabled>";				
				$delete_plugin = "<a id='delete_vproizvod' data-param='proizvodid=".$pr->getProizvodID()."&vproizvodid=".$pr->getVProizvodID()."'>".$html_img_delete."</a>";

				$ap->AddTableRow(
					array(	$modify_plugin , 
							$quantity_plugin ,	
							$price_plugin ,
							$value_plugin ,
							$delete_plugin));
			}
			// kreiram drop down listu sa svim proizvodima za vezu
			$ObjectFactory->AddSort("sifra");
			$ObjectFactory->AddFilter("status_id = " . STATUS_PROIZVODA_AKTIVAN);
			$vproizvodi = $ObjectFactory->createObjects("PrProizvod");
			$ObjectFactory->Reset();			
			$vproizvodi_select="<div id='input_name'><select  id='vproizvodid1' name='vproizvodid1' >";
			$vproizvodi_select.="<option value='0'>".getTranslation("PLG_CHOOSE")."</option>";	
			if(count($vproizvodi) > 0)
			{
				foreach($vproizvodi as $vp)
				{
					$vproizvodi_select.="<option value='".$vp->getProizvodID()."'>".$vp->getSifra()."   ".$vp->getNaziv()."</option>";	
				}
			}
			$vproizvodi_select.="</select></div>";			
			
				$ap->AddTableRow(
					array(	$vproizvodi_select, 
							"<input data-param='' style='display:none;' id='kolicina' name='kolicina' type='text' value='0'>" , 
							"<p style='display:none' id='cena'></p>",
							"<input name='vrednost' style='display:none;' id='vrednost' type='text' value='' disabled>",			
							"<a id='delete_vproizvod' style='display:none;' data-param=''>".$html_img_delete."</a>"));							

			$ap->RegisterAdminPage($smarty);
			
			
			
			$kategorije = $ObjectFactory->createObjects("PrKategorija");
			
			// select box za Kategoriju		
			$shkateg = new SmartyHtmlSelection("kategorija",$smarty);
			foreach($kategorije as $k)
			{
				$shkateg->AddValue($k->KategorijaID);
				$shkateg->AddOutput($k->Naziv);
			}
			
			if(count($proiz->PrKategorija) > 0)
			{
				foreach($proiz->PrKategorija as $pk)
				{
					$shkateg->AddSelected($pk->KategorijaID);	
				}
			}
			$shkateg->SmartyAssign();

			// select box za grupe vezanih proizvoda		
			
			$ObjectFactory->Reset();
			$ObjectFactory->AddFilter("congroup=1");	
			$ObjectFactory->SetSortBy("naziv");			
			$vezanegrupe = $ObjectFactory->createObjects("PrGrupaProizvoda");
			$ObjectFactory->Reset();
			
			$shvg = new SmartyHtmlSelection("vezanegrupe",$smarty);
			$shvg->AddValue(0);
			$shvg->AddOutput("Nema vezanih grupa");
			$shvg->AddSelected(0);	
			foreach($vezanegrupe as $vg)
			{
				$shvg->AddValue($vg->GrupaProizvodaID);
				$shvg->AddOutput($vg->Naziv);
			}
			$ObjectFactory->Reset();
			$ObjectFactory->AddFilter("proizvodid=".$_REQUEST["proizvodid"]);		
			$vezanagrupa = $ObjectFactory->createObjects("PrVeznaGrupa");
			$ObjectFactory->Reset();
			if(count($vezanagrupa) > 0)
			{
				foreach($vezanagrupa as $pvg)
				{
					$shvg->AddSelected($pvg->GrupaProizvodaID);	
				}
			}
			$shvg->SmartyAssign();
			
			// select box za grupe vezanih proizvoda	
			$ObjectFactory->Reset();
			$ObjectFactory->AddFilter("kitgroup=1");		
			$ObjectFactory->SetSortBy("naziv");
			$kitgrupe = $ObjectFactory->createObjects("PrGrupaProizvoda");
			$ObjectFactory->Reset();
			
			$shkg = new SmartyHtmlSelection("kitgrupe",$smarty);
			$shkg->AddValue(0);
			$shkg->AddOutput("Nema kit kompleta");
			$shkg->AddSelected(0);	
			foreach($kitgrupe as $kg)
			{
				$shkg->AddValue($kg->GrupaProizvodaID);
				$shkg->AddOutput($kg->Naziv);
			}
			$ObjectFactory->Reset();
			$ObjectFactory->AddFilter("proizvodid=".$_REQUEST["proizvodid"]);		
			$kitgrupa = $ObjectFactory->createObjects("PrKitGrupa");
			$ObjectFactory->Reset();
			if(count($kitgrupa) > 0)
			{
				foreach($kitgrupa as $pkg)
				{
					$shkg->AddSelected($pkg->GrupaProizvodaID);	
				}
			}
			$shkg->SmartyAssign();
			
			// kreiram drop down listu sa svim statusima
			$ObjectFactory->AddFilter("tip_status_id = " . STATUS_TIP_PRODUCT);
			$proizvodStatus = $ObjectFactory->createObjects("SfStatus");
			$ObjectFactory->ResetFilters();
			
			$shproizvodStatus = new SmartyHtmlSelection("status",$smarty);
			foreach($proizvodStatus as $ps)
			{
				$shproizvodStatus->AddValue($ps->StatusID);
				$shproizvodStatus->AddOutput($ps->Vrednost);
				
				if($proiz->SfStatus->StatusID == $ps->StatusID)
				{
					$shproizvodStatus->AddSelected($ps->StatusID);							
				}
			}
			$shproizvodStatus->SmartyAssign();
			
			// kreiram drop down listu sa svim zemljama
			$ObjectFactory->ResetFilters();
			// kreiram drop down listu sa svim countryima
			$proizvodCountry = $ObjectFactory->createObjects("SfCountries");

			$shproizvodCountry = new SmartyHtmlSelection("countries",$smarty);			
			$shproizvodCountry->AddValue(-1);
			$shproizvodCountry->AddOutput(getTranslation("PLG_CHOOSE"));			
			foreach($proizvodCountry as $ps)
			{


				$shproizvodCountry->AddValue($ps->CountryID);
				$shproizvodCountry->AddOutput($ps->Vrednost);
				
				if($proiz->SfCountries->CountryID == $ps->CountryID)
				{
					$shproizvodCountry->AddSelected($ps->CountryID);							
				}
			}
			$shproizvodCountry->SmartyAssign();			


		
			//registrujem smarty promenljivu za izbor meseca
			$sMonth = new SmartyHtmlSelection("dateMonth", $smarty);
			$cnt = 1;
			//foreach ($months_strings[$language] as $month){
			foreach (range(1,12) as $month){
				$sMonth->AddOutput($month);
				$sMonth->AddValue($cnt);
				$cnt++;
			}
			
			$sMonth->AddSelected(date("n",$proiz->Datum));
			$sMonth->SmartyAssign();
			
			//registrujem smarty promenljivu za izbor dana
			$sDay = new SmartyHtmlSelection("dateDay", $smarty);
			foreach ( range(1,31) as $day){
				$sDay->AddOutput($day);
				$sDay->AddValue($day);
				$cnt++;
			}
			
			$sDay->AddSelected(date("j",$proiz->Datum));
			$sDay->SmartyAssign();
			
			//registrujem smarty promenljivu za izbor godine
			$sYear = new SmartyHtmlSelection("dateYear", $smarty);
			$cnt = 1980;
			foreach (range(1980,2030) as $year){
				$sYear->AddOutput($year);
				$sYear->AddValue($cnt);
				$cnt++;
			}
			
			$sYear->AddSelected(date("Y",$proiz->Datum));
			$sYear->SmartyAssign();
			
			$smarty->assign("dateHours",date("H",$proiz->Datum));
			$smarty->assign("dateMinutes",date("i",$proiz->Datum));
			
			// OSNOVNE KARAKTERISTIKE!!!!
			$smarty->assign($proiz->toArray());		
			
			$smarty->assign("opisCK",$proiz->Opis);
			$smarty->assign("kratak_opisCK",$proiz->KratakOpis);
			
			// DODATNE KARAKTERISTIKE MORAMO DA IZVUCEMO POSEBNO!!!
			$tipproizvoda = $ObjectFactory->createObject("PrTipProizvoda",$tpid,array("PrKarakteristika"));
			$tr_td_karakteristike = "";
			//prolazimo kroz sve dodatne karakteristike za datu kategoriju
			foreach ($tipproizvoda->PrKarakteristika as $kar) 
			{			
				// objekat za cuvanje vrednosti karakteristika
				$karakteristikaproizvoda = $ObjectFactory->createObject("PrKarakteristikaProizvoda",-1);
				$karakteristikaproizvoda->KarakteristikaID = $kar->KarakteristikaID;
				$karakteristikaproizvoda->ProizvodID = $proiz->ProizvodID;
				$DBBR->nadjiSlogVratiGa($karakteristikaproizvoda);

				$tr_td_karakteristike .= "<div class='form-group'><label class='col-sm-2 control-label'>".$kar->Naziv."</label><div class='col-sm-10'>";

				$karVrsta = $ObjectFactory->createObject("PrKarakteristikaVrsta",$kar->PrKarakteristikaVrsta->KarakteristikaVrstaID,array("PrKarakteristikaElement"));

				if (count($karVrsta->PrKarakteristikaElement)==0) {
					// promenljiva cuva trenutnu vrednost karakteristike
					$vrednost = "";
				
					if($karakteristikaproizvoda->Vrednost != "")
					{
						$vrednost = $karakteristikaproizvoda->Vrednost;
					}
					$karakt="karakteristika[".$kar->KarakteristikaID."]";
					if ($kar->getKarakteristikaID()==1) {
						$tr_td_karakteristike .="<textarea  id='".$karakt."' name='karakteristika[".$kar->KarakteristikaID."]' >".$vrednost."</textarea>
							<script type='text/javascript'>
								CKEDITOR.replace( '".$karakt."', { height:'250', width:'700'});
							</script>\n";
					}	
					else $tr_td_karakteristike .= '<input type="text" size="70" name="karakteristika['.$kar->KarakteristikaID.']" class="form-control" value="'.$vrednost.'">';
					
				}
				else 
				{
					$sel_karElementID = "";
					if($karakteristikaproizvoda->PrKarakteristikaElement->KarakteristikaElementID != -1 && $karakteristikaproizvoda->PrKarakteristikaElement->KarakteristikaElementID != "")
					{
						$sel_karElementID = $karakteristikaproizvoda->PrKarakteristikaElement->KarakteristikaElementID;
					}
					$tr_td_karakteristike .= generateKarakteristkaElementVrstaCmb($kar->PrKarakteristikaVrsta->KarakteristikaVrstaID,$sel_karElementID,$kar->KarakteristikaID);
				}
				$tr_td_karakteristike .= "</div></div>";

			}	
			$smarty->assign("tr_td_karakteristike",$tr_td_karakteristike);

			//velicine

			

			
			$modify = new ConnectedObject($ObjectFactory,$DBBR);
			$smarty->assign("img_rows",$modify->ModifyConnectedObject('Proizvod', 'img', $_REQUEST["proizvodid"]));
			$smarty->assign("vid_rows",$modify->ModifyConnectedObject('Proizvod', 'vid', $_REQUEST["proizvodid"]));
			$smarty->assign("web_rows",$modify->ModifyConnectedObject('Proizvod', 'web', $_REQUEST["proizvodid"]));		
			$smarty->assign("doc_rows",$modify->ModifyConnectedObject('Proizvod', 'doc', $_REQUEST["proizvodid"]));

		}
	
		$smarty->display('modify.tpl');
	}
	else
	{
		// show error message not enough rights
		$smarty->assign("norights_message",getTranslation("PLG_NORIGHT"));
		$smarty->display('../../../templates/norights.tpl');
	}
	
	function generateKarakteristkaElementVrstaCmb($karakteristikaVrstaID,$sel_karElementID, $karID)
	{
		global $ObjectFactory;
		
		$karVrsta = $ObjectFactory->createObject("PrKarakteristikaVrsta",$karakteristikaVrstaID,array("PrKarakteristikaElement"));
		$output = "<select name='karakteristikaelementid[".$karID."]' class='form-control'>";
		$output .= "<option value='-1'>Bez Izbora</option>";
		
		foreach ($karVrsta->PrKarakteristikaElement as $element)
		{
			$selected = "";
			if($sel_karElementID == $element->KarakteristikaElementID)
			{
				$selected = " selected ";
			}
			
			$output.= "<option $selected value='".$element->KarakteristikaElementID."'>".$element->Vrednost."</option>";
		}
		$output.="</select>";
		return $output;
	}
	

	
?>