<?
	$_ADMINPAGES = true;	
	include_once("../../../config.php");
	
	$workbook = new Spreadsheet_Excel_Writer('test.xls');
	echo "test";
$worksheet =& $workbook->addWorksheet('My first worksheet');
echo "test";
if (PEAR::isError($worksheet)) {
	echo PEAR_Error::getMessage();
}

$workbook->close();
?>