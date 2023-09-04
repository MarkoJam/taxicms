<?
	/* CMS Studio 3.0 modify_final.php */
	set_time_limit(120);
	$_ADMINPAGES = true;
	include_once("../../../config.php");
	include_once("../../../common/class/PHPExcel.php");

	
	global $smarty;
	global $DBBR;

	$executed=0;
	if ($_REQUEST["book"]<>"" && $_REQUEST["sheet"]<>"")
	{	
		$ObjectFactory = ObjectFactory::getInstance();
		$excelFile = "../../../".$_REQUEST["book"];
		//$excelFile = "../../../Lager2.xlsx";
		$sheet=$_REQUEST["sheet"];
		$pathInfo = pathinfo($excelFile);
		$type = $pathInfo['extension'] == 'xlsx' ? 'Excel2007' : 'Excel5';

		$objReader = PHPExcel_IOFactory::createReader($type);

		$objPHPExcel = $objReader->load($excelFile);
		foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) 
		{
			$sheet=$worksheets[$worksheet->getTitle()] = $worksheet->toArray();
		}
		$i=0;
		foreach ($worksheets[$_REQUEST["sheet"]][0] as $hed) 
		{
			$executed=1;
			switch ($hed) {
				case sifra:
					$Ncode=$i;
					break;
				case cene:
					$Npricea=$i;
					break;					
			}
			$i++;	
		}	
		
		$i=0;
		
		foreach ($worksheets[$_REQUEST["sheet"]] as $row) 
		{
			if ($i>0) {
				$sifra=$row[$Ncode];
				if (!empty($sifra)) {
					$price=$row[$Npricea];

					$ObjectFactory->AddFilter(" status_id = ".STATUS_SUBSITE_AKTIVAN);
					$objlist = $ObjectFactory->createObjects("SubSite");
					if(count($objlist)>0) {
						foreach($objlist as $odo)
						{
							$dbpf=$odo->getDbPostfix();
							$sql1="UPDATE pr_proizvod".$dbpf." SET cenaa = '".$price."'  WHERE sifra = '".$sifra."'; ";
							$DBBR->con->query($sql1);
						}
					}	
				}
			}
			$i++;
		}
	}	
	$smarty->assign('executed',$executed); 
	$smarty->display('modify.tpl');
	
?>