<?
	$_ADMINPAGES = true;	
	include_once("../../config.php");
	
	global $smarty;
	global $auth;
	global $LanguageArray;

	$ObjectFactory = ObjectFactory::getInstance();
	
	//kreiram novu listu objekata Page
	$objlist = $ObjectFactory->createObjects("Plugin", array("SfPluginModule"));
	
	$workbook = new Spreadsheet_Excel_Writer();
	$workbook->setVersion(8);

	$workbook->send('export-excel.xls');
	$worksheet =& $workbook->addWorksheet('Plugin');
	$worksheet->setInputEncoding('UTF-8');
	
	// sel column width
	$worksheet->setColumn(0,4,25);
	
	$format_bold_bootomline =& $workbook->addFormat();
	$format_bold_bootomline->setBold();
	$format_bold_bootomline->setBottom(1);
	
	$worksheet->write(0, 0, getTranslation("PLG_NAME"), $format_bold_bootomline);
	$worksheet->write(0, 1, getTranslation("PLG_FILENAME"), $format_bold_bootomline);
	$worksheet->write(0, 2, getTranslation("PLG_CLASSNAME"), $format_bold_bootomline);
	$worksheet->write(0, 3, getTranslation("PLG_MODULE"), $format_bold_bootomline);
	$worksheet->write(0, 4, getTranslation("PLG_TEMPLATEBASE"), $format_bold_bootomline);
	$worksheet->write(0, 5, getTranslation("PLG_STATUS_ACTIVE"), $format_bold_bootomline);

	if(count($objlist)>0)
	{
		$cnt = 0;
		foreach ($objlist as $odo) 
		{
			$cnt++;
			$worksheet->write($cnt, 0, $odo->getTitle());
			$worksheet->write($cnt, 1, $odo->getFileName());
			$worksheet->write($cnt, 2, $odo->getClassname());
			$worksheet->write($cnt, 3, $odo->getModule());
			$worksheet->write($cnt, 4, $odo->getTemplateBase());
			$worksheet->write($cnt, 5, $odo->getActive());
		}
	}					
	else
	{
		$worksheet->write(1,0,"No data");
	}
	
	$workbook->close();
?>