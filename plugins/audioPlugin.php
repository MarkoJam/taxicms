<?

include_once ("../config.php");
global $smarty;
global $ObjectFactory;

if ($_REQUEST['type']=='menu')
{	
	//$audio = new Audio();
	$audio_menu=playMenu($_REQUEST['id'],$ObjectFactory,$DBBR);
	if ($audio_menu) echo json_encode($audio_menu);
	else echo "ERROR";
}
if ($_REQUEST['type']=='default')
{	
	$audio_default=playDefault($_REQUEST['id'],$ObjectFactory,$DBBR);
	if ($audio_default) echo json_encode($audio_default);
	else echo "ERROR";
}
if ($_REQUEST['type']=='content')
{	
	//$audio = new Audio();
	$audio_content=playPageContent($_REQUEST['page_id'],$ObjectFactory,$DBBR);
	if ($audio_content) echo $audio_content;
	else 
	{
		$pg = $ObjectFactory->createObject("Page", $_REQUEST["page_id"]);
		echo 'tts/'.(strip_tags($pg->getHtml()));
	}	
}
if ($_REQUEST['type']=='detail')
{	
	//$audio = new Audio();
	$audio_detail=playDetail($_REQUEST['news_id'],$ObjectFactory,$DBBR);
	if ($audio_detail) echo $audio_detail;
	else 
	{
		$nw = $ObjectFactory->createObject("News", $_REQUEST["news_id"]);
		echo 'tts/'.(strip_tags($nw->getHtml()));
	}	
}
if ($_REQUEST['type']=='check_ap') 	echo $_SESSION['ap']=$_REQUEST['ap'];
if ($_REQUEST['type']=='check_vr') 	echo $_SESSION['vr']=$_REQUEST['vr'];


	function playPageContent($id,$ObjectFactory,$DBBR)
	{
		$upit ="SELECT `filename` as fn FROM audio WHERE class='page' AND field='audio_content' AND `id` = ".$id  ;
		$result_row = $DBBR->con->get_results($upit);
		if (count($result_row)>0) return $result_row[0]->fn;
		else return false;
	}

	function playDetail($id,$ObjectFactory,$DBBR)
	{
		$upit ="SELECT `filename` as fn FROM audio WHERE class='news' AND field='audio_content' AND `id` = ".$id  ;
		$result_row = $DBBR->con->get_results($upit);
		if (count($result_row)>0) return $result_row[0]->fn;
		else return false;
	}
	
	function playMenu($parentID,$ObjectFactory,$DBBR)
	{
		
		$ObjectFactory->AddSort('page_order');
		$ObjectFactory->AddFilter("parent_id = ".$parentID." AND status_id = " . STATUS_PAGE_AKTIVAN);
		$pages = $ObjectFactory->createObjects("Page");
		if (count($pages)>0)
		{	
			$audio_menu=array();
			foreach ($pages as $page)
			{
				$id = $page->getPageID();
				$upit ="SELECT `filename` as fn FROM audio WHERE class='page' AND field='title' AND `id` = ".$id  ;
				$result_row = $DBBR->con->get_results($upit);		
				if (count($result_row)>0) $audio_menu[]=$result_row[0]->fn;	
				else $audio_menu[]='tts/'.$page->getHeader();
			}
			return $audio_menu;	
		}
		else return false;
	}
	
	function playDefault($categoryID,$ObjectFactory,$DBBR)
	{
		$nc = $ObjectFactory->createObject("NewsCategory", $categoryID);
		$num=$nc->getMessageNum();
		$ObjectFactory->AddSort('news_newscategory_order');
		$ObjectFactory->AddFilter("news_category_id = ".$categoryID);
		$News = $ObjectFactory->createObjects("NewsNewsCategory");
		if (count($News)>0)
		{	
			$i=0;
			$audio_default=array();
			foreach ($News as $news)
			{
				$id = $news->getNewsID();
				$nw = $ObjectFactory->createObject("News", $id);
				if ($nw->SfStatus->StatusID == STATUS_NEWS_AKTIVAN)
				{	
					$upit ="SELECT `filename` as fn FROM audio WHERE class='news' AND field='title' AND `id` = ".$id  ;
					$result_row = $DBBR->con->get_results($upit);		
					if (count($result_row)>0) $audio_default[]=$result_row[0]->fn;	
					else $audio_default[]='tts/'.$nw->getHeader();
				}
				$i++;
				if ($i==$num) break;
			}
			return $audio_default;	
		}
		else return false;
	}
?>