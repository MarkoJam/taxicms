<?
	$_ADMINPAGES = true;	
	include_once("../../../config.php");
	
	global $smarty;
	global $auth;
	global $LanguageArray;

	$ObjectFactory = ObjectFactory::getInstance();
	
	//kreiram novu listu objekata PrProizvod
	$objlist = $ObjectFactory->createObjects("PrProizvod",array("SfStatus","PrTipProizvoda","PrKategorija","PrProizvodjac"));
	
	$workbook = new Spreadsheet_Excel_Writer();
	$workbook->setVersion(8);

	$workbook->send('export-excel.xls');
	$worksheet =& $workbook->addWorksheet('Proizvodi');
	$worksheet->setInputEncoding('UTF-8');
	
	// sel column width
	$worksheet->setColumn(0,4,25);
	
	$format_bold_bootomline =& $workbook->addFormat();
	$format_bold_bootomline->setBold();
	$format_bold_bootomline->setBottom(1);
	
	$worksheet->write(0, 0, getTranslation("PLG_NAME"), $format_bold_bootomline);
	$worksheet->write(0, 1, getTranslation("PLG_TYPE"), $format_bold_bootomline);
	$worksheet->write(0, 2, getTranslation("PLG_MANUFACTURER"), $format_bold_bootomline);
	$worksheet->write(0, 3, getTranslation("PLG_CATEGORY"), $format_bold_bootomline);
	$worksheet->write(0, 4, getTranslation("PLG_STATUS"), $format_bold_bootomline);

	if(count($objlist)>0)
	{
		$cnt = 0;
		foreach ($objlist as $odo) 
		{
			$cnt++;
			$worksheet->write($cnt, 0, $odo->getNaziv());
			$worksheet->write($cnt, 1, $odo->getPrTipProizvoda());
			$worksheet->write($cnt, 2, $odo->getPrProizvodjac());
			$worksheet->write($cnt, 3, $odo->getPrKategorija());
			$worksheet->write($cnt, 4, $odo->SfStatus->getVrednost());
		}
	}					
	else
	{
		$worksheet->write(1,0,"No data");
	}
	
	$workbook->close();
?>