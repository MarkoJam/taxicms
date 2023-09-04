<?
	$_AJAXPAGES = true;

	include_once("../../config.php");
	include_once("../../common/functions/ajax.php");
	ResetFilters();
	$GenerateThumbs = GenerateThumbs::getInstance();
	$lh->makeTranslatedDateArray();
	$news_all = array();
	$news_array = array();
	$current_language = $lh->CurrentLanguage();
	$newsT='news';
	$newscategoryT='newscategory';
	$newsnewscategoryT='newsnewscategory';
	$lh->ChangeTableName($newsT);
	$lh->ChangeTableName($newscategoryT);
	$lh->ChangeTableName($newsnewscategoryT);
	if (!isset($_REQUEST['category_id'])) $_REQUEST['category_id']=$_REQUEST['main_category_id'];
	if (!isset($_REQUEST['years'])) $_REQUEST['years']=-1;
	//else $_REQUEST['months']=-1;
	if (!isset($_REQUEST['months']) || ($_REQUEST['filter'])=='years') $_REQUEST['months']=-1;

	$term=$lh->LatToCir($_REQUEST['term']);
	if (!isset($_REQUEST['term'])) $_REQUEST['term']='';

	if ($_REQUEST['category_id']<>-1) {
		$order=$newsnewscategoryT.".news_newscategory_order";
		$NewsCategory = $ObjectFactory->createObject("NewsCategory",$_REQUEST['category_id']);
		$limit=$NewsCategory->MessageNum;
	}
	else {
		$order=$newsT.".date DESC";
		$limit=12;
	}
	if (!isset($_REQUEST['offset'])) $_REQUEST['offset']=0;
	$upit="SELECT
		".$newsT.".news_id,".$newsT.".date,".$newscategoryT.".title,".$newscategoryT.".newscategoryid

		FROM ".$newscategoryT.",".$newsnewscategoryT.",".$newsT." WHERE

			`status`=".STATUS_CATEGORY_GLAVNI." and `status_id`=".STATUS_NEWS_AKTIVAN." and `publishing_date` < " . time()." and ";

	if ($_REQUEST['category_id']<>-1)
		$upit.=$newscategoryT.".newscategoryid=".$_REQUEST['category_id']." and ";
	if ($_REQUEST['years']<>-1)
		$upit.="YEAR(FROM_UNIXTIME(date))=".$_REQUEST['years']." and ";
	if ($_REQUEST['months']<>-1)
		$upit.="MONTH(FROM_UNIXTIME(date))=".$_REQUEST['months']." and ";
	if ($term!='')
		$upit.="(
			header like ('%".$term."%') or
			shorthtml like ('%".$term."%') or
			html like ('%".$term."%')
		) and ";
	$upit.="newscategoryid=news_category_id and
			".$newsnewscategoryT.".news_id=".$newsT.".news_id
			group by ".$newsnewscategoryT.".news_id ";
	$News = $DBBR->con->get_results($upit);
	// izbornici
	foreach ($News as $n)
	{
		$years[]=date('Y',$n->date);
		$months[]=array('m'=>date('m',$n->date),'F'=>($lh->translatedDate[date('F',$n->date)]));
		$categories[]=array('id'=>$n->newscategoryid,'title'=>$lh->Transliterate($n->title));
	}
	$years=array_unique($years);
	$months=array_unique($months, SORT_REGULAR);
	$categories=array_unique($categories, SORT_REGULAR);
	arsort($years);
	usort($months,function($first,$second){return $first['m'] > $second['m'];});
	usort($categories,function($first,$second){return $first['title'] > $second['title'];});
	$years=array_values($years);

	// PAGINACIJA
	$count=countObject($News);
	$upit.="order by ".$order."
			limit ".$limit."
			offset ".$_REQUEST['offset'];
	$News = $DBBR->con->get_results($upit);

	foreach ($News as $n)
	{
		$news = $ObjectFactory->createObject("News",$n->news_id,array('NewsCategory'));
		$html = $news->getShortHtmlUnchanged();
		$html = htmldecode($html);
		$html=bolduj_ispis($html, trim($term));
		$GenerateThumbs->PrepareThumbs($html);
		$news->setShortHtml($html);
		$news_array = $news->toArray();
		$content = (strip_tags($html));
		$html_clean = preg_replace ("/&#?[a-z0-9]+;/i"," ", $content );// dodat ociscen html unos za post na linkedin
		$html_clean = preg_replace('/\s+/', ' ', trim($html_clean)); // izbacivanje novog reda zbog popup prozora
		$html_clean = str_replace("'","", $html_clean);
		$news_array = array_merge($news_array, array("html_clean" => $html_clean));

		$links_print_dt = $lh->GetPrintLink ( new LinkResourceDetails($lh, 'news', $news->getNewsID(),'w',$news->getHeaderUnchanged()));
		$links_print_fb = $lh->GetPrintLink ( new LinkResourceDetails($lh, 'news', $news->getNewsID(),'fb',$news->getHeaderUnchanged()));
		$links_print_in = $lh->GetPrintLink ( new LinkResourceDetails($lh, 'news', $news->getNewsID(),'in',$news->getHeaderUnchanged()));

		$news_array = array_merge($news_array, array("link_print_dt" => $links_print_dt));
		$news_array = array_merge($news_array, array("link_print_fb" => $links_print_fb));
		$news_array = array_merge($news_array, array("link_print_in" => $links_print_in));

		$news_all[] = $news_array;
	}
	// zadrzavanje $_REQUEST['filter'] kod paginacije
	if (!isset($_REQUEST['filter']) || empty($_REQUEST['filter'])) $_REQUEST['filter']=$_SESSION['filter'];
	else $_SESSION['filter']=$_REQUEST['filter'];
	// zadrzavanje prethodnog filtera
	switch ($_REQUEST['filter']) {
		case 'category_id':
			$categories=$_SESSION['categories'];
			break;
		case 'years':
			$years=$_SESSION['years'];
			break;
		case 'months':
			$years=$_SESSION['years'];
			$months=$_SESSION['months'];
			break;
		/*case 'terms':
			$categories=$_SESSION['categories'];
			$years=$_SESSION['years'];
			$months=$_SESSION['months'];
			break;*/
	}
	$_SESSION['categories']=$categories;
	$_SESSION['years']=$years;
	$_SESSION['months']=$months;


	$data = array(
		"news_all" => $news_all,
		//"title" =>$title,
		"categoryid" =>$_REQUEST['category_id'],
		"pagination" =>	pagination($count,$limit),
		"years" => $years,
		"months" => $months,
		"categories" => $categories
	);
	$smarty->assign("data",$data);
	ob_start();
	$smarty->display('../../templates/news_default.tpl');
	$data = ob_get_contents();
	ob_end_clean();
	echo $data;


?>
