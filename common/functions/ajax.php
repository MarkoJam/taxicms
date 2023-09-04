<?
	session_start();	
	if ($_SESSION['details']) {
		$_REQUEST['offset']=$_SESSION['offset'];
		$_SESSION['details']=false;
	}	
	else $_SESSION['offset']=$_REQUEST['offset'];
	if (!isset($_REQUEST['offset'])) $_REQUEST['offset']=0;
	$smarty->assign("ROOT_WEB",ROOT_WEB);
	$smarty->assign("language",$lh->CurrentLanguage());
	$ObjectFactory->Reset();
	$ObjectFactory->AddFilter("language = '" . $_REQUEST['language'] . "'");
	$ss = $ObjectFactory->createObjects("SubSite");
	$ObjectFactory->Reset();
	$lh->subsite=$ss[0]->getFilePostfix();

	SetLabels();
	
	function SetLabels()
	{
		global $ObjectFactory;
		global $smarty;
		global $lh;
		
		$LanguageArrayInternal = array();
		$ObjectFactory->ResetFilters();
		$labels = $ObjectFactory->createObjects("Labels");
		foreach ($labels as $lab)
		{
			if ($lab->getTranslate()=="") $lab->setTranslate($lab->getContent());
			$smarty->assign($lab->getName(), $lab->getTranslate());
			$LanguageArrayInternal['value'][$lab->getName()]=$lh->Transliterate($lab->getTranslate());
		}
		RegisterPluginLanguage($LanguageArrayInternal);
		$LanguageArray=AddToBigLanguageArray($LanguageArrayInternal);
		return $LanguageArray;
	}

	function RegisterPluginLanguage($LanguageArrayInternal)
	{
		global $smarty;
		if(count($LanguageArrayInternal["value"])> 0)
		{
			foreach ($LanguageArrayInternal["value"] as $key => $value)
			{
				$smarty->assign($key,$value);
			}
		}
	}

	function AddToBigLanguageArray($LanguageArrayInternal)
	{
		$LanguageArray='';
		if(count($LanguageArrayInternal["value"])> 0)
		{
			foreach ($LanguageArrayInternal["value"] as $key => $value)
			{
				if(!isKeyExists($key,$LanguageArray))
				{
					$LanguageArray["value"] = array_merge($LanguageArray["value"], array($key => $value));
				}
			}
			$LanguageArray=$LanguageArrayInternal;
		}
		return $LanguageArray;
	}

	function isKeyExists($key_test,$LanguageArray)
	{
		if (gettype($LanguageArray)!='string') {
			if(count($LanguageArray["value"])> 0)
			{
				foreach ($LanguageArray["value"] as $key => $value)
				{
					if($key_test == $key) return true;
				}
			}
			return false;
		}
		return true;
	}

	function pagination($count,$limit)
	{
		if ($limit>0) {
			global $smarty;
			$pageno=(number_format($count/$limit+0.5,0));
			$current_page=$_REQUEST['offset']/$limit+1;
			$lres=$_REQUEST['offset']+$limit;
			if ($lres>$count) $lres=$count;
			$smarty->assign('fres',$_REQUEST['offset']+1);
			$smarty->assign('lres',$lres);
			$current_page2=$current_page;
			if ($current_page<4) $current_page2=3;
			if ($current_page>$pageno-4) $current_page2=$pageno-2;
			for ($i = 0; $i <= $count-1; $i=$i+$limit) {
				$pn++;
				if ($pn>$current_page2-3 && $pn<$current_page2+3) {
					$arr=array('page'=>$pn,'offset'=>$i);
					$pages_arr[]=$arr;
				}		
			}
			$smarty->assign('count',$count);
			$smarty->assign('pages_no',$pageno);
			$smarty->assign('current_page',$current_page);
			if (count($pages_arr)>1) {

				$smarty->assign('pages_arr',$pages_arr);
				$smarty->assign('pages_limit',($limit));			
				if ($current_page>2) $smarty->assign('first',true);
				$smarty->assign('first_offset',0);
				$last_offset=($i-$limit);
				$smarty->assign('last_offset',$last_offset);			
				if ($current_page<$pageno-1) $smarty->assign('last',true);
				if (($_REQUEST['offset']-$limit)>-1) $smarty->assign('previous',true);
				$smarty->assign('previous_offset',($_REQUEST['offset']-$limit));
				if (($_REQUEST['offset']+$limit)<$count+1) $smarty->assign('next',true);
				$smarty->assign('next_offset',($_REQUEST['offset']+$limit));
			}
			ob_start();
			$smarty->display('../../templates/paginationNews.tpl');
			$data = ob_get_contents();
			ob_end_clean();
			return $data;
		}
	}

	function link_ids($plugin,&$tmp,&$page,$filter=null) {
		global $ObjectFactory;
		$ObjectFactory->Reset();
		$ObjectFactory->AddFilter("file_name='".$plugin."' AND position='standard'");
		$template = $ObjectFactory->createObjects("PluginTemplate");
		$ObjectFactory->Reset();
		$i=0;
		$tmp=array();
		foreach ($template as $template)
		{
			$i++;
			$tmp[$i]=$template->getTemplateID();
		}
		for ($j=1; $j<$i+1; $j++) {
			$ObjectFactory->Reset();
			$ObjectFactory->AddFilter("template_id=" . $tmp[$j]);
			$pages = $ObjectFactory->createObjects("Page");
			$ObjectFactory->Reset();
			foreach ($pages as $page)
			{
				$page=$page->getPageID();

				if ($page<>0) break;
				$ObjectFactory->Reset();
			}
			if ($page<>0) break;
		}
		$tmp=$tmp[$j];
	}

	function make_array($class,$classname,$resourceid,$resourcetitle,$filterclass,$filterid) {
		global $DBBR;
		global $lh;
		$res_array = $class->toArray();

		// vezani resursi
		$view = new ConnectedObject($ObjectFactory,$DBBR, SetLabels());
		$res_array = array_merge($res_array, array(
			"img_rows" => $view->ViewConnectedObject($classname, 'img', $resourceid),
			"vid_rows" => $view->ViewConnectedObject($classname, 'vid', $resourceid),
			"web_rows" => $view->ViewConnectedObject($classname, 'web', $resourceid),
			"wb2_rows" => $view->ViewConnectedObject($classname, 'wb2', $resourceid),
			"doc_rows" => $view->ViewConnectedObject($classname, 'doc', $resourceid),
			"dc2_rows" => $view->ViewConnectedObject($classname, 'dc2', $resourceid))
		);
		$tmp=0;
		$page=0;
		if (count($filterclass)>0) link_ids(strtolower($classname), $tmp, $page, $filterid); //id templejta i  stranice za link
		else link_ids(strtolower($classname), $tmp, $page);
		
		
		
		if ($classname=='News' && $class->getPDID()!=0) {
			$links_print_dt = $lh->GetPrintLink(new LinkResourceDetails($lh,  strtolower($class->getPDClass()), $class->getPDID(), 'w',$class->getHeaderUnchanged()));
			$links_print_in = $lh->GetPrintLink(new LinkResourceDetails($lh,  strtolower($class->getPDClass()), $class->getPDID(), 'ln',$class->getHeaderUnchanged()));
			$links_print_fb = $lh->GetPrintLink(new LinkResourceDetails($lh,  strtolower($class->getPDClass()), $class->getPDID(), 'fb',$class->getHeaderUnchanged()));		
		}	
		else {	
			$links_print_dt = $lh->GetPrintLink(new LinkResourceDetails($lh, strtolower($classname), $resourceid,'w',$resourcetitle));
			$links_print_ln = $lh->GetPrintLink(new LinkResourceDetails($lh, strtolower($classname), $resourceid,'ln',$resourcetitle));
			$links_print_fb = $lh->GetPrintLink(new LinkResourceDetails($lh, strtolower($classname), $resourceid,'fb',$resourcetitle));
		}

		$content = (strip_tags($html));
		$html_clean = preg_replace("/&#?[a-z0-9]+-;/i"," ", $content );// dodat ociscen html unos za post na linkedin
		$html_clean = preg_replace('/\s+/', ' ', trim($html_clean)); // izbacivanje novog reda zbog popup prozora
		$html_clean = str_replace("'","", $html_clean);
		$html_clean = str_replace("`","", $html_clean);
		$html_clean = str_replace("%","", $html_clean);
		$html_clean = str_replace('"','', $html_clean);
		$html_clean = substr($html_clean,0,230).'...';

		$res_array = array_merge($res_array, array(
													"link_print_dt" => $links_print_dt,
													"link_print_in" => $links_print_in,
													"link_print_fb" => $links_print_fb,
													"html_clean" => $html_clean)
		);
		return $res_array;
	}

	function ResetFilters()
	{
		if ($_REQUEST['reset']==1) {
			$_REQUEST['category_id']=$_REQUEST['main_category_id'];
			$_REQUEST['term']='';
			$_REQUEST['years']=-1;
			$_REQUEST['months']=-1;
		}					
	}
	
	function bolduj_ispis($sadrzaj,$keyword)
	{
		$sadrzaj=" ".$sadrzaj;
		if (strlen($keyword)>2) $sadrzaj = preg_replace("'[^[:alpha:]]".$keyword."[^[:alpha:]]'si","<strong> ".$keyword." </strong>",$sadrzaj);
		$sadrzaj=ltrim($sadrzaj);
		return $sadrzaj;
	}
?>
