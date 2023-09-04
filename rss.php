<?php 

header("Content-Type: application/atom+xml");

include_once("config.php");

$ObjectFactory = ObjectFactory::getInstance();
$LanguageHelper = LanguageHelper::getInstance();

$rss = new RSSFeed();

$rss->setinfo('encoding','utf-8');
$rss->setinfo('title','');
$rss->setinfo('link','');
$rss->setinfo('description','');
$rss->setinfo('language','sr');
$rss->setinfo('copyright','');
$rss->setinfo('webMaster','');
$rss->setinfo('pubDate',date('D, d M Y H:i:s'));
$rss->setinfo('lastbuilddate',date('D, d M Y H:i:s'));

$newscategoryid = 18; // Zakucali smo aktuelnosti!


$news = $ObjectFactory->createObjects("News", array("SfStatus","NewsCategory"));
foreach($news as $nw)
{
	if(IsNewsInNewsCategory($nw) && $nw->SfStatus->getStatusID() == STATUS_NEWS_AKTIVAN)
	{
		$LinkNewsDet = new LinkNewsDetails($LanguageHelper, $nw->getNewsID(), 29 ,$nw->getHeaderUnchanged());
		$links_print = $LanguageHelper->GetPrintLink($LinkNewsDet);
	
		$rss->addcontent(array(
			'title' => $nw->getHeader(),
			'link' =>  $links_print,
			'guid' =>  $links_print,
			'pubdate' => date('D, d M Y H:i:s',$nw->getDate()),
			'content' => $nw->getHtml()
		));
	}
}

$rss->renderfeed();

exit();

function IsNewsInNewsCategory($news)
{
	if($news->NewsCategory != null)
	{
		foreach($news->NewsCategory as $nwc)
		{
			if($nwc != null)
			{
				if($nwc->getNewsCategoryID() == 18) return true;
			}
		}
	}

	return false;
}

?>