<?
	// select box za stranice
	function recPerPage($smarty) {
		if(isset($_REQUEST["records_per_page"]) && is_numeric($_REQUEST["records_per_page"]))
		{
			$resPerPage = $_REQUEST["records_per_page"];
			$_SESSION["records_per_page_prproizvod"] = $resPerPage;
		}
		else if(isset($_SESSION["records_per_page_prproizvod"]) && is_numeric($_SESSION["records_per_page_prproizvod"]))
		{
			$resPerPage = $_SESSION["records_per_page_prproizvod"];
		}
		else
		{
			$resPerPage = 20;
		}

		$recordsPerPage = array(20,40,60,80,100,200);
		$shRecordsPerPage = new SmartyHtmlSelection("recordsPerPage",$smarty);
		foreach ($recordsPerPage as $num)
		{
			$shRecordsPerPage->AddOutput($num);
			$shRecordsPerPage->AddValue($num);
		}

		$shRecordsPerPage->AddSelected($resPerPage);
		$shRecordsPerPage->SmartyAssign();

		return $resPerPage;
	}	
	
	function hp_link($id,$plugin)
	{
		global $DBBR;
		global $lh;
		$html_img_hp = "<div class='btn btn-white'><i class='fa fa-home'></i></div>";
		$html_img_tasks = "<div class='btn btn-white'><i class='fa fa-tasks'></i></div>";
		$current_language = $lh->CurrentLanguage();
		$home_pageT='home_page';
		$lh->ChangeTableName($home_pageT);
		
		$sql="SELECT count('res_id') as count FROM ".$home_pageT." WHERE `plugin`='".$plugin."'  AND `id`=".$id;
		$result_set = $DBBR->con->get_results($sql);
		if ($result_set[0]->count>0) $hp_exist=true;
		else $hp_exist=false;
		if ($hp_exist) $hp_link = $html_img_hp;
		else $hp_link = "<a href='../../hp.php?id=".$id."&plugin=".$plugin."' >".$html_img_tasks."</a>";
		return $hp_link;
	}	
	function view_link($id,$plugin,$header)
	{
		global $DBBR;
		global $lh;
		$html_img_view = "<div class='btn btn-white'><i class='fa fa-eye'></i></div>";
		$links_print = $lh->GetPrintLink ( new LinkResourceDetails($lh, $plugin, $id,'w',$header));
		return $view_link = "<a id='zip' target='_blank' href='".$links_print."'>".$html_img_view."</a>";
	}

?>
