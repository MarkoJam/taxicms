<?
	/* CMS Studio 3.0 modify.php *///

	$_ADMINPAGES = true;
	include_once("../../../config.php");
		
	global $smarty;
	global $auth;
	
	
	if($auth->isActionAllowed("ACTION_INVOICE_MODIFY"))
	{
		$kurs = $ObjectFactory->createObject("PrKurs",1);
		$smarty->assign("kurs",$kurs->getKurs());
		
		if(isset($_REQUEST["mode"])) $_REQUEST["invoiceid"]=-1;	
		if(isset($_REQUEST["invoiceid"]))
		{
			// deo za insertovanje novog sloga
			if(isset($_REQUEST["mode"])) $smarty->assign("mode", 'insert');
			else $smarty->assign("mode", 'edit');
			
			$invoice = $ObjectFactory->createObject("PrInvoice", $_REQUEST["invoiceid"], array("PrInvoiceItem","User"));
			$smarty->assign($invoice->toArray());
			$smarty->assign($invoice->getUser()->toArray());
			
			// statusi
			$ObjectFactory->AddFilter(" tip_status_id = " . STATUS_TIP_INVOICE);
			$statusi = $ObjectFactory->createObjects("SfStatus");
			$shStatus = new SmartyHtmlSelection("status",$smarty);

			foreach ($statusi as $s) 
			{
				$shStatus->AddOutput($s->getVrednost());
				$shStatus->AddValue($s->getStatusID());
			}
			$shStatus->AddSelected($invoice->SfStatus->getStatusID());
			$shStatus->SmartyAssign();
			$ObjectFactory->ResetFilters();

			// useri
			$ObjectFactory->AddFilter(" pib > 0 ");
			$useri = $ObjectFactory->createObjects("User");
			$shUser= new SmartyHtmlSelection("user",$smarty);
			$shUser->AddOutput(getTranslation('PLG_CHOOSE'));
			$shUser->AddValue(-1);
			foreach ($useri as $u) 
			{
				$shUser->AddOutput($u->getFirm() );
				$shUser->AddValue($u->getUserID());
			}
			$shUser->AddSelected($invoice->getUserID());
			$shUser->SmartyAssign();
			$ObjectFactory->ResetFilters();
			
			$datum=date("d.m.Y", $invoice->getDate());
			$smarty->assign("datum", $datum);

			
			
			// kreiram listu sa vezanim proizvodima
			$vproizid_all = array();
			$vproiz_all = array();
			$delete_button = array();
			$ObjectFactory->ResetFilters();
			$ObjectFactory->AddFilter("invoiceid = " . $_REQUEST["invoiceid"]);
			$prpr = $ObjectFactory->createObjects("PrInvoiceItem");
			$ObjectFactory->ResetFilters();
			
			$ap = new AdminTable();
			$ap->SetHeader(
						array(
							getTranslation("PLG_CODE")."/".getTranslation("PLG_NAME"),
							getTranslation("PLG_QUANTITY"),
							getTranslation("PLG_PRICE"),
							getTranslation("PLG_VALUE")."<br><input id='suma' type='text' value='0' size='17'>",
							getTranslation("PLG_DELETE")
				)
			);			
			
			$ap->SetOffsetName("offset_templtplgid");
			$ap->SetCountAllRows(count($prpr));	
			$ap->SetRowCount(count($prpr)+1);

			$html_img_delete = "<div class='btn btn-white'><i class='fa fa-minus-square-o'></i></div>";
			
			
			foreach($prpr as $pr)
			{
				$proiz_main=$ObjectFactory->createObject("PrProizvod",$pr->getProizvodID());
				$modify_plugin = $pr->getProductCode()." ".$pr->getProductName();
				$quantity_plugin="<input data-param='invoiceid=".$pr->getInvoiceID()."&proizvodid=".$pr->getProizvodID()."' name='kolicina' id='kolicina' type='text' value='".$pr->getQuantity()."'>";
				$price_plugin="<p id='cena'>".$pr->getPrice()."</p>";
				$value_plugin="<input name='vrednost' id='vrednost' type='text' value='".$pr->getAmount()."' disabled>";				
				$delete_plugin = "<a id='delete_vproizvod' data-param='invoiceid=".$pr->getInvoiceID()."&proizvodid=".$pr->getProizvodID()."'>".$html_img_delete."</a>";

				$ap->AddTableRow(
					array(	$modify_plugin , 
							$quantity_plugin ,	
							$price_plugin ,
							$value_plugin ,
							$delete_plugin));
			}
			// kreiram drop down listu sa svim proizvodima za vezu
			$ObjectFactory->AddSort("sifra");
			$ObjectFactory->AddFilter("status_id = " . STATUS_PROIZVODA_AKTIVAN ." AND tipproizvodaid = ". PRODUCT_TYPE_FINISH_PRODUCT );
			$vproizvodi = $ObjectFactory->createObjects("PrProizvod");
			$ObjectFactory->Reset();			
			$vproizvodi_select="<div id='input_name'><select  id='vproizvodid1' name='vproizvodid1' >";
			if(count($vproizvodi) > 0)
			{
				$vproizvodi_select.="<option value='0'>".getTranslation("PLG_CHOOSE")."</option>";	
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
		}
		
		$smarty->display('modify.tpl');
		
	}
	else 
	{
		// show error message not enough rights
		$smarty->assign("norights_message",getTranslation("PLG_NORIGHT"));
		$smarty->display('../../templates/norights.tpl');
	}

?>