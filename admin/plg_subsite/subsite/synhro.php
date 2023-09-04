<?
	/* CMS Studio 3.0 index.php */

	$_ADMINPAGES = true;
	include_once("../../../config.php");
	global $smarty;
	global $auth;
	
	$message=getTranslation("PLG_SINHRO_SUCCESS");

	if($auth->isActionAllowed("ACTION_SUBSITE_MODIFY"))
	{	
		set_time_limit ( 1200 );
		//if ($lh->GetFileDesc()<>"srp") {
		// uskladjivanje glavnih tabela i tabela za subsite-ove
		$tables=$lh->table_change;
		$subsite = $ObjectFactory->createObjects("SubSite",array("SfStatus"));
		foreach($subsite as $ss)
		{
			foreach($tables as $tab)
			{
				$dbpr=$ss->GetDbPostfix();
				if ($DBBR->con->query("DESCRIBE ".$tab.$dbpr) && in_array($tab,$lh->table_exception))	
				{
					$sql="SHOW INDEX FROM ".$tab;
					$result_set = $DBBR->con->get_results($sql);
					$index_field=$result_set[0]->Column_name;
					
					$sqla="SELECT ".$index_field." FROM ".$tab;
					$sqlb="SELECT ".$index_field." FROM ".$tab.$dbpr;	
					$array_a=$DBBR->con->get_results($sqla);
					$array_b=$DBBR->con->get_results($sqlb);
					
					foreach ($array_a as $mema)
					{	
						$search=$mema->$index_field;
						$find=false;
						foreach ($array_b as $memb)
						{
							if ($memb->$index_field==$search) $find=true;
						}
						if ($find==false)
						{
							$sqli="INSERT INTO ".$tab.$dbpr." SELECT * FROM ".$tab." WHERE ".$index_field." = ".$search;
							$DBBR->con->query($sqli);
						}	
					}	
					
					foreach ($array_b as $memb)
					{	
						$search=$memb->$index_field;
						$find=false;
						foreach ($array_a as $mema)
						{
							if ($mema->$index_field==$search) $find=true;
						}
						if ($find==false)
						{
							$sqli="DELETE FROM ".$tab.$dbpr." WHERE ".$index_field." = ".$search;
							$DBBR->con->query($sqli);
						}	
					}
				}
				else
				{
					$sqlc="CREATE TABLE ".$tab.$dbpr." LIKE ".$tab;
					$DBBR->con->query($sqlc);
				}	
			}
		}

		//formiranje niza nacionalnih labela iz XML fajla
		$config = new XMLConfig;
		$LanguageArray = array();
		$plg=$config->Parse(ROOT_HOME."config/languages/lang_".$lh->GetFileDesc().".xml");
		$tree = xmldocfile(ROOT_HOME."config/languages/lang_".$lh->GetFileDesc().".xml");
        $root = $tree->root();
        $config->convertXMLToArray($root, $plg);
		$labels_arr=array();
		foreach ($plg as $key=>$p) {
			foreach ($p['value'] as $key2=>$p2) {
				$labels_arr[$key2]=$p2;
			}
		}
		//formiranje niza srpskih labela iz XML fajla
		$plg=$config->Parse(ROOT_HOME."config/languages/lang_srp.xml");
		$tree = xmldocfile(ROOT_HOME."config/languages/lang_srp.xml");
        $root = $tree->root();
        $config->convertXMLToArray($root, $plg);
		$labels_srp_arr=array();
		foreach ($plg as $key=>$p) {
			foreach ($p['value'] as $key2=>$p2) {
				$labels_srp_arr[$key2]=$p2;
			}
		}	
		$plg=$config->Parse(ROOT_HOME."admin/languages/lang_srp.xml");		
		$tree = xmldocfile(ROOT_HOME."admin/languages/lang_srp.xml");
        $root = $tree->root();
        $config->convertXMLToArray($root, $plg);
		//$labels_srp_arr=array();
		foreach ($plg as $key=>$p) {
			foreach ($p['value'] as $key2=>$p2) {
				$labels_srp_arr[$key2]=$p2;
			}
		}		
			
		//ako nije srpska tabela labela
		if ($lh->GetFileDesc()<>"srp") {
			$labels = $ObjectFactory->createObjects("Labels");
			//ako je prazna, puni se sadrzajem srpske tabele
			if (count($labels)==0) {
				$lbn="labels".$lh->subsite_arr[$lh->subsite];
				$sqli="INSERT INTO ".$lbn." SELECT * from labels";
				$DBBR->con->query($sqli);
				$labels = $ObjectFactory->createObjects("Labels");
			}
			//tabele se azurira	nizom labela iz XML-a
			foreach($labels as $lab) {
				$lab->setContent($labels_srp_arr[$lab->Name]);
				$lab->setTranslate($labels_arr[$lab->Name]);
				$DBBR->promeniSlog($lab);
			}

		}	
		// ako je srpska tabela onda se dodaju nove labele iz tpl-ova
		else {
			//dodavanje labela u tabelu iz tpl file-ova
			$nfiles=array();
			$xfiles=array();
			// folder template i subfolder-i
			$dir    = ROOT_HOME . "templates";
			
			//$dir    = ROOT_HOME ;
			
			function search_file($dir, &$nfiles, &$xfiles)
			{
				$files = scandir($dir);
				foreach ($files as $file)
				{
					if (!($file==".." || $file=="."))
					{	
						$file=$dir."/".$file;	
						$xfiles[]=$file;
						$arr=explode(".",$file);
						$ext=$arr[1];
						$ext2=$arr[2];
						if ($ext=="tpl" && $ext2<>'php') $nfiles[]=$file;
						if ($ext=="") search_file($file, $nfiles, $xfiles);
					}
				}
			}
			search_file($dir, $nfiles, $xfiles);
			$scan=array();
			// fajlovi iz administracije zbog punjenja za front administraciju
			$xfiles[]=ROOT_HOME."plugins/input_forms/login/templates/modify.tpl";			
			foreach ($xfiles as $file)	
			{
				//$path = ROOT_WEB."templates/".$file;
				$path=$file;
				$content = file_get_contents($path);
				// $PLG_
				$pattern_smarty_comment = "/PLG_(.*?)}/";
				$smarty_comments = array();
				preg_match_all($pattern_smarty_comment,$content,$smarty_comments);
				foreach ($smarty_comments[0] as $sc)
				{
					$arr=explode(' ',substr($sc,0,-1));
					$sc=$arr[0];
					if ($sc<>' ') $scan[]=$sc;
				}
				// $GLOBAL
				$pattern_smarty_comment = "/GLOBAL_(.*?)}/";
				$smarty_comments = array();
				preg_match_all($pattern_smarty_comment,$content,$smarty_comments);
				foreach ($smarty_comments[0] as $sc)
				{
					$arr=explode(' ',substr($sc,0,-1));
					$sc=$arr[0];
					if ($sc<>' ') $scan[]=$sc;
				}
			}

			//sortiranja i totaliranja niza
			array_multisort ($scan);
			$scan= array_unique ($scan);

			//azuriranje postojece srpske tabele prema nizu iz tpl-ova
			$sqll="SELECT name FROM labels";
			$array_l=$DBBR->con->get_results($sqll);
			foreach ($scan as $sc)
			{
				$find=false;
				foreach ($array_l as $meml)
				{
					//element je pronadjen
					if ($sc==$meml->name) $find=true;
				}	
				// ako element nije pronadjen onda se dodaje sadrzaj clana iz niza	
				if ($find==false)
				{
					$subsite = $ObjectFactory->createObjects("SubSite",array("SfStatus"));
					foreach($subsite as $ss)
					{
						if ($ss->GetFilePostfix()!='srl') {
							$dbpr=$ss->GetDbPostfix();
							if ($labels_srp_arr[$sc]) $sqli2="INSERT INTO labels".$dbpr." (`name`,`content`) VALUES ('".$sc."','".$labels_srp_arr[$sc]."')";
							else $sqli2="INSERT INTO labels".$dbpr." (`name`) VALUES ('".$sc."')";
							$DBBR->con->query($sqli2);
						}
					}
				}	
			}	
		}
	}	
	echo $message;
	
	
?>