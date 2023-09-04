<? 
	/* CMS Studio 3.0 index.php */
	$_ADMINPAGES = true;
	include_once("../../config.php");
	include_once("../../common/class/class_mysqldump.php");
	include_once("../../common/class/class_zipfile.php");

	if($auth->isActionAllowed("ACTION_BACKUP_CREATE"))
	{
		$dump = new MySQLDump();
		
		$database_dump = $dump->dumpDatabase(EZSQL_DB_NAME);
		
		$newfile="backup_".date("d-m-Y",time()).".sql";
		$file = fopen ("../backup/".$newfile, "w");
		fwrite($file, $database_dump);
		fclose ($file);  
		
		$createZip = new createZip();  
		
		$fileContents = file_get_contents("../backup/".$newfile);
		$createZip->addFile($fileContents, $newfile);
		
		$fileName = "../backup/archive_".date("d-m-Y",time()).".zip";
		$fd = fopen ($fileName, "wb");
		$out = fwrite ($fd, $createZip->getZippedfile());
		fclose($fd);
		
		@unlink("../backup/".$newfile);
		echo "<div class='success'>".getTranslation("PLG_CHANGE_SUCCESS")."</div>";		
	}
	else echo "<div class='warning'>".getTranslation("PLG_NORIGHT")."</div>";
?>