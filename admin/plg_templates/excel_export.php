<?
	$_ADMINPAGES = true;	
	include_once("../../config.php");
	
	global $smarty;
	global $auth;
	global $LanguageArray;

	$ObjectFactory = ObjectFactory::getInstance();
	
	//kreiram novu listu objekata Page
	$objlist = $ObjectFactory->createObjects("Template", array("SfStatus","SfPageType","SfPageProtection","Template"));
	
	$workbook = new Spreadsheet_Excel_Writer();
	$workbook->setVersion(8);

	$workbook->send('export-excel.xls');
	$worksheet =& $workbook->addWorksheet('Template');
	$worksheet->setInputEncoding('UTF-8');
	
	// sel column width
	$worksheet->setColumn(0,4,25);
	
	$format_bold_bootomline =& $workbook->addFormat();
	$format_bold_bootomline->setBold();
	$format_bold_bootomline->setBottom(1);
	
	$worksheet->write(0, 0, getTranslation("PLG_NAME"), $format_bold_bootomline);
	$worksheet->write(0, 1, getTranslation("PLG_DESCRIPTION"), $format_bold_bootomline);

	if(count($objlist)>0)
	{
		$cnt = 0;
		foreach ($objlist as $odo) 
		{
			$cnt++;
			$worksheet->write($cnt, 0, $odo->Title);
			$worksheet->write($cnt, 1, $odo->Description);
		}
	}					
	else
	{
		$worksheet->write(1,0,"No data");
	}
	
	$workbook->close();
?>