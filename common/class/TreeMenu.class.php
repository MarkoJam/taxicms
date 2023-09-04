<?php
//za rad sa bazom podataka...
include_once("dbbr.php");
class Tree {

	var $con;
	var $page_table; //cuva informaciju o kojoj se tabeli sa stranicama radi...
	var $pagelink_table;
	var $index_page;
	var $debug;

	var $current_page_id;

	function setCurrentPageId($page_id)
	{
		$this->current_page_id = $page_id;
	}

	function __construct($odo = ""){
		$db = DatabaseBroker::getInstance();
		$this->con = $db->getConnection();
		$this->debug = false;
		$lh = LanguageHelper::getInstance();

		$this->index_page = "index.php";
		if($odo instanceof StaticPage)
		{
			$this->page_table = "staticpage";
			$this->pagelink_table = "staticpagelink";
		}
		else
		{
			$this->page_table = "page";
			$this->pagelink_table = "pagelink";
		}
		$lh->ChangeTableName($this->page_table);
		//$lh->ChangeTableName( & $this->index_page);
		$lh->ChangeTableName($this->pagelink_table);
	}

	//funkcije za regulisanje order-a nodova-----------------------------
	function max_order($parent)
	{
		$row = $this->con->get_row('SELECT MAX(`page_order`) as max FROM '.$this->page_table.' WHERE parent_id='.$parent.' ;');
		return $row->max;
	}
	function lower_order_nodeid($node)
	{
		//nadji red ciji order uzimamo za kriterijum
		$row = $this->con->get_row('SELECT `page_order`, page_id , parent_id FROM '.$this->page_table.' WHERE page_id='.$node);
		if ($this->debug) { $this->con->debug();}
		//nadji sve redove koji zadovoljavaju zadati kriterijum
		$result = $this->con->get_results('SELECT * FROM '.$this->page_table.' WHERE parent_id='.$row->parent_id.' AND `page_order` < '.$row->page_order. ' ORDER BY `page_order` DESC');
		if ($this->debug) { $this->con->debug();}
		if ($this->con->num_rows == 0) return -1; //nema takvog cvora - sa manjim id-jem
		return $result[0]->page_id;
	}
	function higher_order_nodeid($node)
	{
		//nadji red ciji order uzimamo za kriterijum
		$row = $this->con->get_row('SELECT `page_order`, page_id,parent_id FROM '.$this->page_table.' WHERE page_id='.$node);
		if ($this->debug) { $this->con->debug();}
		//nadji sve redove koji zadovoljavaju zadati kriterijum
		$result = $this->con->get_results('SELECT * FROM '.$this->page_table.' WHERE parent_id='.$row->parent_id.' AND `page_order` > '.$row->page_order. ' ORDER BY `page_order` ASC');
		if ($this->debug) { $this->con->debug();}
		if ($this->con->num_rows == 0) return -1; //nema takvog cvora - sa manjim id-jem
		return $result[0]->page_id;
	}

	function lower_order_nodeid_static($node)
	{
		//nadji red ciji order uzimamo za kriterijum
		$row = $this->con->get_row('SELECT `staticpage_order`, spage_id FROM '.$this->page_table.' WHERE spage_id='.$node);
		if ($this->debug) { $this->con->debug();}
		//nadji sve redove koji zadovoljavaju zadati kriterijum
		$result = $this->con->get_results('SELECT * FROM '.$this->page_table.' WHERE `staticpage_order` < '.$row->staticpage_order. ' ORDER BY `staticpage_order` DESC');
		if ($this->debug) { $this->con->debug();}
		if ($this->con->num_rows == 0) return -1; //nema takvog cvora - sa manjim id-jem
		return $result[0]->spage_id;
	}
	function higher_order_nodeid_static($node)
	{
		//nadji red ciji order uzimamo za kriterijum
		$row = $this->con->get_row('SELECT `staticpage_order`, spage_id  FROM '.$this->page_table.' WHERE spage_id='.$node);
		if ($this->debug) { $this->con->debug();}
		//nadji sve redove koji zadovoljavaju zadati kriterijum
		$result = $this->con->get_results('SELECT * FROM '.$this->page_table.' WHERE `staticpage_order` > '.$row->staticpage_order. ' ORDER BY `staticpage_order` ASC');
		if ($this->debug) { $this->con->debug();}
		if ($this->con->num_rows == 0) return -1; //nema takvog cvora - sa manjim id-jem
		return $result[0]->spage_id;
	}
	//kraj funkcija za order nodova-----------------------------

	function draw_menu($menu,$parent, $level,$str)
	{
		global $db;
		$result = $this->con->get_results('SELECT * FROM '.$this->page_table.' WHERE parent_id='.$parent.' ORDER BY `page_order` ASC ;');
		if ($this->debug) { $this->con->debug();}
		$i = 1;
		foreach($result as $row){

			$result_advanced = $this->con->get_results('SELECT * FROM '.$this->page_table.' WHERE parent_id='.$row->page_id.' ORDER BY `page_order` ASC ;');
			if ($this->debug) { $this->con->debug();}
			$num_rows1 = $this->con->num_rows;

			$cnt = $this->count_children_online($row->page_id);

			if($row->status_id == STATUS_PAGE_AKTIVAN)
			{
				if($row->type_id == PAGE_TYPE_PAGE || $row->type_id == PAGE_TYPE_CATEGORY)
				{
					$header = URLencode(htmlentities($row->header,ENT_QUOTES));
					if($row->html != "") $link = $this->index_page."?page_id=".$row->page_id;
					else $link = "";
				}
				else $link = $row->html;

				echo $menu. $str . "_".$i. ' = new Array("'.$row->header.'","'.$link.'", BaseHref+"navigacija/pozadinasub.gif",'.$cnt.','.$this->menu_height($row->header,0).','.$this->menu_lenght_sub($row->page_id,60).',"","","","","","",-1,-1,-1,"left","");';
			}
			if ($num_rows1 != 0 ) {
				$tmpstr = $str."_".$i;
				$this->draw_menu($menu,$row->page_id, $level+1,$tmpstr);
			}
			if($row->status_id == STATUS_PAGE_AKTIVAN) $i++;
		}
	}

	function get_menu_items($parent, $level,$arr) {
		global $db;
		$lh = LanguageHelper::getInstance();
		$result = $this->con->get_results('SELECT page_id, header, type_id ,status_id, html FROM '.$this->page_table.' WHERE parent_id='.$parent.' ORDER BY `page_order` ASC ;');
		if ($this->debug) { $this->con->debug();}
		//$i = 1;
		if($this->con->num_rows != 0) {
			foreach($result as $row){

				$result_advanced = $this->con->get_results('SELECT count(*) FROM '.$this->page_table.' WHERE parent_id='.$row->page_id.' ORDER BY `page_order` ASC ;');
				if ($this->debug) { $this->con->debug();}
				$num_rows1 = $this->con->num_rows;

				$target = "_self";
				if($row->status_id == STATUS_PAGE_AKTIVAN) {
					if($row->type_id == PAGE_TYPE_PAGE || $row->type_id == PAGE_TYPE_CATEGORY) {
						$header = URLencode(htmlentities($row->header,ENT_QUOTES));
						//if($row->type != "kategorija") $link = $this->index_page."?page_id=".$row->page_id;
						if($row->type_id != PAGE_TYPE_CATEGORY) {
							//$link = $this->index_page."?page_id=".$row->page_id;
							$linkPgn = new LinkPage($lh,$row->page_id,$row->header);
							$link = $lh->GetPrintLink($linkPgn);
						}
						else
						{
							$link = "#";
						}
					} else {
						$link = $row->html;
						$res_get_target = $this->con->get_row('SELECT * FROM '.$this->pagelink_table. ' WHERE page_id='.$row->page_id);
						$target = $res_get_target->target;
					}
					array_push($arr["header"], str_repeat(" ",$level).$row->header);
					array_push($arr["link"],$link);
					array_push($arr["target"],$target);
					array_push($arr["typeid"],$row->type_id);
				}
				if ($num_rows1 != 0 && $row->status_id == STATUS_PAGE_AKTIVAN) {
					@$this->get_menu_items($row->page_id, $level+1, $arr);
				}
			}
		  }
	}
	function delete_children($parent, $level) {
		$row1 = $this->con->get_row('SELECT page_id, type_id FROM '.$this->page_table.' WHERE page_id='.$parent);
	  	if ($this->debug) { $this->con->debug();}
	  	$result_advanced = $this->con->get_results('SELECT page_id, type_id FROM '.$this->page_table.' WHERE parent_id='.$row1->page_id);
		if ($this->debug) { $this->con->debug();}
		if($this->con->num_rows != 0){
			foreach($result_advanced as $row){
					$this->delete_children($row->page_id, $level+1);
			}
		}
			$del1 = $this->con->query("DELETE FROM ".$this->page_table." WHERE page_id=".$row1->page_id);
			if ($this->debug) { $this->con->debug();}
			if($row1->type_id == PAGE_TYPE_LINK) {
				//echo "DELETE FROM ".$this->pagelink_table." WHERE page_id=".$row1->page_id;
				$del2 = $this->con->query("DELETE FROM ".$this->pagelink_table." WHERE page_id=".$row1->page_id);
				if ($this->debug) { $this->con->debug();}
				}
	}//end function
	//ovde sam nesto menjao...
	//vraca za zadati cvor citavu putanju, do tog cvora
	function get_path($nodeid,$cnt) {
	   $result = $this->con->get_row('SELECT page_id, navigation_type, parent_id, header, sub_header, html, type_id FROM '.$this->page_table.' WHERE page_id ='.$nodeid);
	   if ($this->debug) { $this->con->debug();}
	   //$this->con->debug();
	   $path = array();
	   if($this->con->num_rows != 0 )
	   {
	   	if ($result->page_id != 0 && $result->parent_id != "")
	   	{
	   		//echo $result->navigation_type;
			global $lh;
			$path[$cnt]["header"] = $lh->Transliterate($result->header);
			//$path[$cnt]["subheader"] = $result->sub_header;
			$path[$cnt]["page_id"] = $nodeid;
			//$path[$cnt]["html"] = $result->html;
			$path[$cnt]["type_id"] = $result->type_id;
			$cnt++;
			$path = array_merge($this->get_path($result->parent_id,$cnt), $path);
	   	}
	   }
		 return $path;
	}

	// za zadati cvor vraca true ukoliko taj cvor ima decu ili false ako cvor nema dece
	function has_children($nodeid){
		$result = $this->con->get_results("SELECT * FROM ".$this->page_table." WHERE parent_id=".$nodeid.";");
		if ($this->debug) { $this->con->debug();}

		if ($this->con->num_rows == 0)
		{
			return false;
		} else {
			return true;
		}
	}

	//prikazuje svu decu zadatog cvora do n-tog nivoa (stampa sa echo - NEKORISNO!!!)
	function display_children($nodeid, $level) {
		$result = $this->con->get_results('SELECT page_id, header FROM '.$this->page_table.' WHERE parent_id="'.$nodeid.'" ORDER BY `page_order`;');
		if ($this->debug) { $this->con->debug();}
		foreach($result as $row){
			$result_advanced = $this->con->get_results('SELECT page_id, header FROM '.$this->page_table.' WHERE parent_id ="'.$row->page_id.'";');
			if ($this->debug) { $this->con->debug();}
			echo str_repeat('-',$level) . $row->header. "<br>\n";
			if ($this->con->num_rows != 0) {
				$this->display_children($row->page_id, $level+1);
			}
		}
	}

	//prikazuje svu decu zadatog cvora do n-tog nivoa (koristim f-ju za sitemap)
	function display_children_list($nodeid, $level) {
		$lh = LanguageHelper::getInstance();
		$result = $this->con->get_results('SELECT page_id, html, type_id, status_id, header FROM '.$this->page_table.' WHERE status_id<>'.STATUS_PAGE_NEVIDLJIVA.' AND  parent_id='.$nodeid.' ORDER BY `page_order`;');
		if ($this->debug) { $this->con->debug();}
		if(count($result) != 0){
		echo "<ul>";
		foreach($result as $row){
			$result_advanced = $this->con->get_results('SELECT page_id FROM '.$this->page_table.' WHERE status_id <>'. STATUS_PAGE_NEVIDLJIVA.' AND parent_id ='.$row->page_id.';');
			$rownum = $this->con->num_rows;
			$target = "_self";
			if($row->status_id <> STATUS_PAGE_NEVIDLJIVA) {
				if($row->type_id == PAGE_TYPE_PAGE || $row->type_id == PAGE_TYPE_CATEGORY) {
					$linkPgn = new LinkPage($lh,$row->page_id,$row->header, $this->path_to_url($row->page_id));
					$link = $lh->GetPrintLink($linkPgn);
					echo "<li><a href=".$link. ">". $lh->Transliterate($row->header). "</a></li>";
				} else {
					$link = $row->html;

					$upit3 = 'SELECT * FROM '.$this->pagelink_table. ' WHERE page_id='.$row->page_id;
					$res_get_target = $this->con->get_row($upit3);
					if($res_get_target != null)
						$target = $res_get_target->target;
					else
						$target = "_self";
					echo "<li><a href='http://".$link."' target='".$target."'>". $lh->Transliterate($row->header). "</a></li>";
				}
			}

			if ($rownum != 0) {
				$this->display_children_list($row->page_id, $level+1);
			}
		}
		echo "</ul>";
	}
}
	function get_adminmenu_list($nodeid, $level, $navigationType)
	{
		ob_start();
		$this->display_adminmenu_list($nodeid, $level, $navigationType);
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}

	//prikazuje svu decu zadatog cvora do n-tog nivoa (koristim f-ju za glavni meni sajta)
	function display_adminmenu_list($nodeid, $level, $navigationType=null)
	{
		$lh = LanguageHelper::getInstance();
		$liClass = "";

		if($level == 0)
			$liClass = "class='jstree-open'";

		if($nodeid == -1) $nodeid = 'IS NULL';
		else $nodeid = '='.$nodeid;

		if($navigationType != "")
			$navigationTypeWhere = " AND navigation_type = " . quote_smart($navigationType) . " ";
		$result = $this->con->get_results('SELECT page_id, html, type_id , status_id, header, sub_header FROM '.$this->page_table.' WHERE 1=1 AND parent_id '.$nodeid.$navigationTypeWhere.' ORDER BY `page_order`;');
		// should we debug sql
		if ($this->debug) $this->con->debug();

		if(count($result) != 0)
		{
			if($level != 0)
				echo "<ul class='sub-menu'>\n";

			foreach($result as $row)
			{
				$result_advanced = $this->con->get_results('SELECT page_id FROM '.$this->page_table.' WHERE 1=1 AND  parent_id ='.$row->page_id.';');
				$cnt_children = $this->con->num_rows;

				$printHeader = $row->header;
				$header = $row->header;
				$printSubHeader = $row->sub_header;

				$header_full = $printHeader;
				if($printSubHeader != "")
				{
					// $header_full .= "<span>" . $printSubHeader . "</span>";
				}

				$target = "_self";
				$ps=$row->type_id;
				$rw=str_replace("http:"," ",ROOT_WEB);
					switch ( $ps )
					{
						case 1  :
							$liData ="data-jstree='{\"icon\":\"".$rw."img/icons/page.png\"}'";
						break;
						case 2  :
							$liData ="data-jstree='{\"icon\":\"".$rw."img/icons/link.png\"}'";
						break;
						case 3  :
							$liData ="data-jstree='{\"icon\":\"".$rw."img/icons/folder.png\"}'";
						break;
					}
				//if($row->type_id == PAGE_TYPE_PAGE || $row->type_id == PAGE_TYPE_CATEGORY)
				//{

					$link = "plg_pages/pages/index.php";
					$param = "page_id=". $row->page_id;
				echo "\t\t<li $liClass $liData  ><a data-link='".$link."' data-param='".$param."' target='frmContent'>". $header_full."</a>\n";
				/*} else {

					$link = $row->html;
					$upit3 = 'SELECT * FROM '.$this->pagelink_table. ' WHERE page_id='.$row->page_id;
					$res_get_target = $this->con->get_row($upit3);

					if($res_get_target != null)
						 $target = $res_get_target->target;
					else
						$target = "_self";

					echo "\t\t<li $liClass $liData><a href='http://".$link."' target='".$target."'>". $header. "</a>\n";
				}*/
				if ($cnt_children == 0)
				{
					echo "</li>\n";
				}
				else
				{
					$this->display_adminmenu_list($row->page_id, $level+1, $navigationType);
					echo "</ul></li>";
				}
				$liClass = '';
			}
		}
	}

	//prikazuje svu decu zadatog cvora do n-tog nivoa (koristim f-ju za glavni meni sajta)
	function display_menu_list($nodeid, $header, $level, $navigationType="")
	{
		$lh = LanguageHelper::getInstance();

		$liClass = "";

		if($level == 0)
			$liClass = "class='first'";

		if($nodeid == -1) $parentQuery = 'IS NULL';
		else $parentQuery = '='.$nodeid;

		if($navigationType != "")
			$navigationTypeWhere = " AND navigation_type = " . quote_smart($navigationType) . " ";

		if($level == 0 && $nodeid == -1)
		{
			$first_page = $this->con->get_results('SELECT page_id, html, type_id , status_id, header, sub_header FROM '.$this->page_table.' WHERE status_id= '.STATUS_PAGE_AKTIVAN.' AND parent_id '.$parentQuery.$navigationTypeWhere.' ORDER BY `page_order`;');
			$result = $this->con->get_results('SELECT page_id, html, type_id , status_id, header, sub_header FROM '.$this->page_table.' WHERE status_id= '.STATUS_PAGE_AKTIVAN.' AND parent_id ='.$first_page[0]->page_id.' ORDER BY `page_order`;');
		}
		else
		{
			$result = $this->con->get_results('SELECT page_id, html, type_id , status_id, header, sub_header FROM '.$this->page_table.' WHERE status_id= '.STATUS_PAGE_AKTIVAN.' AND parent_id '.$parentQuery.$navigationTypeWhere.' ORDER BY `page_order`;');
		}
		// should we debug sql
		if ($this->debug) $this->con->debug();

		if(count($result) != 0)
		{
			$i=-1;

			if($level == 1){
				echo "<ul class='dropdown-menu' aria-labelledby='navbarDropdown'>\n";
			//	echo "<li class='header-menu'>".$header."</li>\n";
			}
			if($level > 1) {
					echo "<ul class='submenu dropdown-menu'>\n";
			//		echo "<li class='header-menu'>".$header."</li>\n";

					}
			foreach($result as $row)
			{
				$i = $i + 1;
				// podesavanje selektovanog elementa
				if($this->current_page_id == $row->page_id)
					$selected = "active";
				else
					$selected = "";


				$result_advanced = $this->con->get_results('SELECT page_id FROM '.$this->page_table.' WHERE status_id='.STATUS_PAGE_AKTIVAN.' AND  parent_id ='.$row->page_id.';');
				$cnt_children = $this->con->num_rows;
				$printHeader = $lh->Transliterate($row->header);
				$header = $row->header;
				//$printSubHeader = $lh->Transliterate($row->sub_header);

				$header_full = $printHeader;
				//if($printSubHeader != "")
				//{
					// $header_full .= "<span>" . $printSubHeader . "</span>";
				//}

				if ($cnt_children == 0) {
					if($level == 0) {
						$dropdown = 'nav-link';
						$navlink = 'nav-item';
						$toogle = '';
						$close = '';
					}
					else
					{
						$dropdown = 'dropdown-item';
						$navlink = '';
						$toogle = '';
						$close = '';
					}
				}
				else
				{
					if($level == 0){
						$dropdown = 'nav-link dropdown-toggle';
						$navlink = 'nav-item dropdown';
						$toogle = 'dropdown';
						$close = 'outside';
						$id = 'navbarDropdown';
					}
					if($level > 0){
						$dropdown = 'dropdown-item dropdown-toggle';
						$navlink = 'dropend';
						$toogle = 'dropdown';
						$close = 'outside';
					}
					if($level == 3){
						$dropdown = 'dropdown-item';
						$navlink = '';
						$toogle = '';
						$close = '';
					}

				}

				$target = "_self";
				if($row->type_id == PAGE_TYPE_PAGE || $row->type_id == PAGE_TYPE_CATEGORY) {

					if($row->type_id == PAGE_TYPE_PAGE){
						$linkPgn = new LinkPage($lh,$row->page_id,$header, $this->path_to_url($row->page_id));
						$link = $lh->GetPrintLink($linkPgn);

						echo "\t\t<li class='$navlink' data-id='$i'><a  class='$selected $dropdown' data-bs-toggle='$toogle' aria-expanded='false' role='button' id='$id' data-bs-auto-close='$close' data-page_id='".$row->page_id."' href='".$link."'>". $header_full. $caret. "</a>\n";
					}
					else
					{
						echo "\t\t<li class='$navlink' data-id='$i'><a  class='$selected $dropdown' data-bs-toggle='$toogle' aria-expanded='false' id='$id' data-bs-auto-close='$close' data-page_id='".$row->page_id."' href='#'>". $header_full. $caret. "</a>\n";
					}
				} else {
					$link = $row->html;
					$upit3 = 'SELECT * FROM '.$this->pagelink_table. ' WHERE page_id='.$row->page_id;
					$res_get_target = $this->con->get_row($upit3);
					if($res_get_target != null)
						$target = $res_get_target->target;
					else $target = "_self";
					echo "\t\t<li class='dropdown'><a class='$selected $dropdown' href='https://".$link."' target='".$target."'>". $lh->Transliterate($header). $caret."</a>\n";
				}
				if ($cnt_children == 0)
				{

					echo "</li>\n";

				}
				else {
					//echo "ulaz";

					$this->display_menu_list($row->page_id, $header, $level+1);
					echo "</ul></li>";
				}
				$liClass = '';

			}
		}
}
	//prikazuje svu decu zadatog cvora do n-tog nivoa (koristim f-ju za sitemap)
	function display_menu_ckeditor($nodeid, $level) {
		$lh = LanguageHelper::getInstance();
		$result = $this->con->get_results('SELECT page_id, html, type_id , status_id, header FROM '.$this->page_table.' WHERE parent_id='.$nodeid.' ORDER BY `page_order`;');
		if ($this->debug) { $this->con->debug();}
		if(count($result) != 0){
		if($level != 0)	echo "";
		foreach($result as $row){
			$result_advanced = $this->con->get_results('SELECT page_id FROM '.$this->page_table.' WHERE  parent_id ='.$row->page_id.';');
			$cnt_children = $this->con->num_rows;
			$target = "_self";
				if($row->type_id == PAGE_TYPE_PAGE || $row->type_id == PAGE_TYPE_CATEGORY)
				{
					if($row->type_id == PAGE_TYPE_PAGE)
					{
						$fullUrl = $this->path_to_url($row->page_id,0);
						$linkPgn = new LinkPage($lh,$row->page_id,$row->header,$fullUrl);
						$link = $lh->GetPrintLink($linkPgn);
						echo "new Array( '".str_repeat('-',$level).$row->header."', '".$link."'),\n";//   "<a href='".$link."'>". $row->header. "</a>";
					}
					else
					{
						echo "new Array( '".str_repeat('-',$level).$row->header."', '#'),\n";
					}
				} else
				{
					$link = $row->html;
					$upit3 = 'SELECT * FROM '.$this->pagelink_table. ' WHERE page_id='.$row->page_id;
					$res_get_target = $this->con->get_row($upit3);
					if($res_get_target != null)
						$target = $res_get_target->target;
					else $target = "_self";
					echo "new Array( '".str_repeat('-',$level).$row->header."', 'http://".$link."'),\n";//"<a href='http://".$link."' target='".$target."'>". $row->header. "</a>";
				}
			if ($cnt_children == 0)
			{
				echo "";
			}
			else {
				//echo "ulaz";
				$this->display_menu_ckeditor($row->page_id, $level+1);
				echo "";
				}
			}
		}
	}

	//vraca niz $arr elemenata stabla stranica - nigde se ne koristi
	function fill_all_children($nodeid, $level,&$arr) {
		$result = $this->con->get_results('SELECT page_id, header FROM '.$this->page_table.' WHERE parent_id="'.$nodeid.'" ORDER BY `page_order`;');
		if ($this->debug) { $this->con->debug();}
		foreach($result as $row){
			$result_advanced = $this->con->get_results('SELECT page_id, header FROM '.$this->page_table.' WHERE parent_id ="'.$row->page_id.'";');
			if ($this->debug) { $this->con->debug();}
			array_push($arr, str_repeat('-',$level) . $row->header. "<br>\n");
			if ($this->con->num_rows != 0) {
				$this->fill_all_children($row->page_id, $level+1,$arr);
			}
		}
	}

	function get_children($nodeid, $level, &$arr)
	{
		$result = $this->con->get_results('SELECT * FROM '.$this->page_table.' WHERE parent_id="'.$nodeid.'" ORDER BY `page_order`;');
		if ($this->debug) { $this->con->debug(); }

		foreach($result as $row)
		{
			$page = new Page();
			$page->napuni($row);

			$arr[] = $page;
		}
	}

	//vraca niz sa svom decom sa prvog nivoa zadatog cvora!!!
	function display_first_children($nodeid, $level)
	{
		if($nodeid != 'NULL') $query = " parent_id = '".$nodeid."' ";
		else $query = " parent_id IS NULL ";

		$full_query = 'SELECT html, status_id, page_id,type_id, header, `page_order` FROM '.$this->page_table.' WHERE 1=1 AND '.$query.' ORDER BY `page_order`;';
		$result = $this->con->get_results($full_query);
		if ($this->debug) { $this->con->debug();}
		$res = array();
		$cnt = 0;
		if($this->con->num_rows != 0)
		{
			foreach($result as $row)
			{
				$res[$cnt]["header"] = $row->header;
				$res[$cnt]["html"]= $row->html;
				$res[$cnt]["page_id"]= $row->page_id;
				$res[$cnt]["order"]= $row->page_order;
				$res[$cnt]["typeid"]= $row->type_id;
				$res[$cnt]["status_id"]= $row->status_id;
				$cnt++;
			}
		}
		return $res;
	}
	//trazi i prikazuje roditelja za trazeni cvor
	function display_parent($nodeid){
		$row = $this->con->get_row("SELECT * FROM ".$this->page_table." WHERE page_id=".$nodeid." ;");
		if ($this->debug) { $this->con->debug();}
		$row1 = $this->con->get_row("SELECT * FROM ".$this->page_table." WHERE page_id=".$row->parent_id." ;");
		if ($this->debug) { $this->con->debug();}
		return $row1->header;
	}
	function display_parentID($nodeid){
		$row = $this->con->get_row("SELECT * FROM ".$this->page_table." WHERE page_id=".$nodeid." ;");
		if ($this->debug) { $this->con->debug();}
		$row1 = $this->con->get_row("SELECT * FROM ".$this->page_table." WHERE page_id=".$row->parent_id." ;");
		if ($this->debug) { $this->con->debug();}
		return $row1->page_id;
	}
	function count_children($nodeid){

		$result = $this->con->get_results("SELECT * FROM ".$this->page_table." WHERE parent_id=".$nodeid." ;");
		if ($this->debug) { $this->con->debug();}
		return $this->con->num_rows;
	}

	function count_children_online($nodeid){

		$result = $this->con->get_results("SELECT * FROM ".$this->page_table." WHERE parent_id=".$nodeid." AND status_id=".STATUS_PAGE_AKTIVAN.";");
		if ($this->debug) { $this->con->debug();}
		return $this->con->num_rows;
	}

	function get_title($nodeid){
		$row = $this->con->get_row('SELECT header FROM '. $this->page_table.' WHERE page_id='.$nodeid.';');
		if ($this->debug) { $this->con->debug();}
		return $row->header;
	}

	function get_node($header){
		$row = $this->con->get_row('SELECT page_id FROM '.$this->page_table.' WHERE header="'.$header.'";');
		if ($this->debug) { $this->con->debug();}
		return $row->page_id;
	}

	//za iscrtavanje razlicitih menija//
	function draw_menu_admin($counter, $nodeid, $level,$str) {
		$result = $this->con->get_results('SELECT page_id, header FROM '.$this->page_table.' WHERE parent_id="'.$nodeid.'" ORDER BY `page_order`;');
		if ($this->debug) { $this->con->debug();}
		$str .=  $counter.",";
		$counter = 0;
		foreach($result as $row){
			$result_advanced = $this->con->get_results('SELECT page_id, header FROM '.$this->page_table.' WHERE parent_id ="'.$row->page_id.'";');
			if ($this->debug) { $this->con->debug();}
			echo str_repeat(' ',4*$level). "TreeMenu.add_option(".$str."\"". $row->header. "\"," . $this->count_children($row->page_id).",\"plg_pages/index.php?page_id=".$row->page_id."\");"."\r\n" ;
			if ($this->con->num_rows != 0) {
				$this->draw_menu_admin($counter,$row->page_id, $level+1,$str);
			}
			$counter++;
		}
	}
	function draw_menu_inner($txtbox){
		$lh = LanguageHelper::getInstance();
		//echo "<strong>"." draw_menu_inner"."</strong>";
		$result = $this->con->get_results('SELECT page_id, parent_id, header FROM '.$this->page_table.' ORDER BY `parent_id`, `page_order`;');
		if ($this->debug) { $this->con->debug();}
		//echo $txtbox;
		$menu = "menu = new dTree('menu','','','".$txtbox."');\n";
		foreach($result as $row){
			$linkPgn = new LinkPage($lh, $row->page_id,$row->header);
			if($row->parent_id == '') $parentid = -1;
			else $parentid = $row->parent_id;
			$menu .= "menu.add(".$row->page_id.",".$parentid.",'".$row->header."','".$lh->GetPrintLink($linkPgn)."','#',true);\n";
		}
		//echo "<strong>".$menu."</strong>";
		$return_value = "<script>".$menu."</script>";
		//echo $return_value;
		return $return_value;
	}

	function draw_menu_innerpage()
	{
		$result = $this->con->get_results('SELECT page_id, parent_id, header FROM '.$this->page_table.' ORDER BY `parent_id`, `page_order`;');
		if ($this->debug) { $this->con->debug();}

		$menu = "menu = new dTree('menu','','');\n";
		foreach($result as $row){
			$menu .= "menu.add(".$row->page_id.",".$row->parent_id.",'".$row->header."','#',true);\n";
		}
		$return_value = "<script>".$menu."</script>";
		return $return_value;
	}

	function menu_lenght($node,$add){
		global $db;
		$pom = 0; $max = 0;
		$result = $this->con->get_results("SELECT header FROM ".$this->page_table." WHERE page_id=".$node );
		if ($this->debug) { $this->con->debug();}

		foreach ($result as $res)
		{
			$pom = 7*strlen($res->header)-20;
			if ( $max  < $pom) $max = $pom;
		}
		return $max+$add;
	}

	function menu_lenght_sub($node,$add){
		//echo "Node ID je: " .$node;
		global $db;
		$pom = 0; $max = 0;
		$result = $this->con->get_results("SELECT * FROM ".$this->page_table." WHERE parent_id=". $this->display_parentID($node) );
		if ($this->debug) { $this->con->debug();}

		foreach ($result as $res)
		{
			$pom = 5*strlen($res->header)-45;
			if ( $max  < $pom) $max = $pom;
		}
		return $max+$add;
	}
	function menu_height($string,$add){
		//$max = 210; // za izracunavanje visine menija
		$exit = 22;

			//$pom = 7*strlen($string);
			//$exit = floor(($pom/$max)*$exit);
			//if($exit < 24) $exit =24;

		return $exit+$add;

	}//za iscrtavanje razlicitih menija//

	function path_to_url($page_id)
	{
		$arr_pages = $this->get_path($page_id,0);
		$path_urls = array();
		for($i=0; $i < count($arr_pages)-1; $i++)
		{
			$path_urls[] = array($arr_pages[$i]["header"],$arr_pages[$i]["subheader"]);
		}
		return $path_urls;
	}
}
class TreeMenu{
	//defult
	var $Indent = 10 ;				// Max indents
	var $Width = 300 ;				// Width for the full menu
	var $NodeWidth = 15 ;			// Indentation size (normally equal to node gfx size)
	var $Style = "menutxt" ;		// text style (defined in the page) for menu texts
	var $Target = "frmContent" ;	// frame/window name for link targets
	var $DBTree;					//obezbedjuje meniju pristup podacima iz baze podataka
	function __construct()
	{
		$this->DBTree = new Tree();
	}

	function SetProperties($indent, $width, $nodewidth, $style, $target)
	{
		$this->Indent = $indent;
		$this->Width =  $width;
		$this->NodeWidth = $nodewidth ;
		$this->Style =  $style;
		$this->Target =  $target;
	}
	function DeleteSubTree($node)
	{
		$this->DBTree->delete_children($node,0);
	}

	/* funkcija koja iscrtava tree menu */
	function PrintScript(){
			$returnVal = "";
			$endl = "\r\n" ;	 //new line
			// This block must generate javascript include and menu inits...
			$returnVal .= '<SCRIPT type="text/javascript" SRC="browser.js"></script>' . $endl ;
			$returnVal .= '<SCRIPT type="text/javascript" SRC="treemenu.js"></script>' . $endl ;
			$returnVal .= '<SCRIPT type="text/javascript">' . $endl ;

			// Echo configuration... after all params have been checked
			if ($this->Style!="") $returnVal .='TreeMenu.set_style("' . $this->Style .'") ;' . $endl ;
			$returnVal .= 'TreeMenu.set_target("' . $this->Target . '") ;' . $endl ;
			$returnVal .= 'TreeMenu.set_indent(' . $this->Indent . ') ;' . $endl ;
			$returnVal .= 'TreeMenu.set_width(' . $this->Width . ',' . $this->NodeWidth . ') ;' . $endl ;
			$returnVal .= 'TreeMenu.set_images("images/menuicon/c_node.gif","images/menuicon/c_node_s.gif","images/menuicon/o_node.gif","images/menuicon/o_node_s.gif","images/menuicon/b_node.gif") ;' . $endl ;

			//ovde se kacim na bazu i uzimam sve potrebne podatke...
			ob_start();
			$brojac_menija = 0;
				//frm_left za glavnu navigaciju kroz stranice
					foreach($this->DBTree->display_first_children('NULL',0) as $menu)
					{
						$returnVal .= "TreeMenu.add_option(\"". $menu["header"]. "\"," . $this->DBTree->count_children($menu["page_id"]).",\"plg_pages/index.php?page_id=".$menu["page_id"]."\");	" .$endl;
						if($this->DBTree->has_children($menu["page_id"]))
							$this->DBTree->draw_menu_admin($brojac_menija, $menu["page_id"], 1, "");
						$brojac_menija++;
					}
			$returnVal .= ob_get_contents();
			ob_end_clean();
			$returnVal .= '</SCRIPT>';
			return $returnVal;
	}
	/* funkcija koja iscrtava javascript poziv funkcije za ispis i startovanje menija */
	function PrintMenu() {
		return '<script type="text/javascript">TreeMenu.print_menu(); menu_action("0","elem0");</script>' ;
	}
}
?>
