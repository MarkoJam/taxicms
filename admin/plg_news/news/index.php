<?
	/* CMS Studio 3.0 index.php */
	$_ADMINPAGES = true;

	include_once("../../../config.php");

	global $smarty;
	global $auth;

	if($auth->isActionAllowed("ACTION_NEWS_VIEW"))
	{
		// kreiram administracionu tabelu
		$ap = new AdminTable();
		$ap->SetTitle("Promena vesti:");

		//$comboNewsCategory = new NewsCategoryFilter($ObjectFactory,$ap);
		//$comboNewsCategory->generateProccessComboBox();

		$comboNewsCategory = makeNewsCategoryFilter($ObjectFactory, $ap);
		//$comboNewsCategory->generateProccessComboBox();

		$comboNewsStatus = new NewsStatusFilter($ObjectFactory,$ap);
		$comboNewsStatus->generateProccessComboBox();

		$filter_array=array('header','shorthtml');
		$ap->SetFilter($inputFilter->createFilter($filter_array));

		$ap->SetHeader(array(
							"<span class='promeni'>".getTranslation("PLG_CHANGE")."</span>",
							SortLink::generateLink(getTranslation("PLG_NAME"),"header"),
							SortLink::generateLink(getTranslation("PLG_CATEGORY"))."<br/>".$comboNewsCategory,//.$comboNewsCategory->getComboBox(),
							SortLink::generateLink(getTranslation("PLG_STATUS"),"status_id")."<br/>".$comboNewsStatus->getComboBox(),
							SortLink::generateLink(getTranslation("PLG_DATE"),"date"),
							getTranslation("PLG_HP"),
							getTranslation("PLG_VIEW"),
							getTranslation("PLG_DELETE")
		));
		$ap->SetOffsetName("offset_news");
		$ap->SetCountAllRows($DBBR->prebrojSveSlogove($ObjectFactory->createObject("News",-1) , $ObjectFactory->filters));

		$ObjectFactory->AddLimit($ap->GetRowCount());
		$ObjectFactory->AddOffset($ap->GetOffset());
		$ObjectFactory->ManageSort();

		//$ObjectFactory->setDebugOn();
		$objlist = $ObjectFactory->createObjects("News",array("NewsCategory","SfStatus"));

		$ap->SetBrowseString($ObjectFactory);

		$ObjectFactory->ResetFilters();
		$ObjectFactory->ResetLimitOffset();

		//za slicice gore-dole
		$html_img_edit = "<div class='btn btn-white'><i class='fa fa-pencil-square-o'></i></div>";
		$html_img_delete = "<div class='btn btn-white'><i class='fa fa-trash'></i></div>";
		$html_img_copy = "<i class='fa fa-clone' aria-hidden='true'></i>";

		$ap->SetRecordCount(count($objlist));

		//ZA SADRZAJ TABELE
		if(!empty($objlist))
		{
			if (isset($_SESSION["sess_newscategoryid"]) && ($_SESSION["sess_newscategoryid"] != -1) && (!isset($_REQUEST["sortby"])))
			{
				foreach($objlist as $nw)
				{
					$nid=$nw->getNewsID();
					$ncid=$_SESSION["sess_newscategoryid"];
					$ObjectFactory->Reset();
					$ObjectFactory->AddFilter("news_id = " . $nid. " AND news_category_id = " .$ncid);
					$nc = $ObjectFactory->createObjects("NewsNewsCategory");
					$ObjectFactory->Reset();
					foreach($nc as $news)
					{
						$nw->Order=$news->getNewsNewsCategoryOrder();
					}
				}
				usort($objlist,function($first,$second){
					return $first->Order > $second->Order;
				});
			}
			foreach($objlist as $nw)
			{
				$news_type_title = "";
				if($nw->getNewsType()->getNewsTypeID() == "-1") $news_type_title = getTranslation("PLG_NONE");
				else $news_type_title = $nw->getNewsType()->getTitle();

				if($auth->isActionAllowed("ACTION_NEWS_MODIFY"))
				{
					$modify_link = "<a class='naziv' href='modify.php?news_id=".$nw->getNewsID()."'>".$html_img_edit."</a>";
				}
				else
				{
					$modify_link = $html_img_edit;
				}

				if($auth->isActionAllowed("ACTION_NEWS_DELETE"))
				{
					$delete_link = "<a href='delete_final.php?news_id=".$nw->getNewsID()."' >".$html_img_delete."</a>";
				}
				else
				{
					$delete_link = $html_img_delete;
				}

				$ap->AddTableRow(
						  array(
								$modify_link,
								$nw->getHeader() ."&nbsp;",
								$nw->getNewsCategoryPrint(true) ."&nbsp;",
								$nw->SfStatus->getVrednost()."&nbsp;",
								date("d-M-Y",$nw->getDate()),
								hp_link($nw->getNewsID(),'news'),
								view_link($nw->getNewsID(),'news',$nw->getHeader()),
								$delete_link));
			}
		}
		$ap->RegisterAdminPage($smarty);

		$smarty->display('index.tpl');
	}
	else
	{
		// show error message not enough rights
		$smarty->assign("norights_message",getTranslation("PLG_NEWS_NORIGHT_VIEW"));
		$smarty->display('../../templates/norights.tpl');
	}

	function makeNewsCategoryFilter($ObjectFactory, $ap)
	{
		// combo box
		$ObjectFactory1 = new ObjectFactory();
		$kategorije = $ObjectFactory1->createObjects("NewsCategory");
		$cmb_kategorije  = "<select class='form-control' name='newscategoryid' onChange='formTable.submit();'>";
		$cmb_kategorije .="<option value='-1'>".getTranslation("PLG_FILTER_NO")."</option>";
		foreach ($kategorije as $kat)
		{
			$selected = "";
			if(isset($_REQUEST["newscategoryid"]) && $kat->getNewsCategoryID() == $_REQUEST["newscategoryid"])
			{
				$selected = "selected";
			}
			else
			{
				if(isset($_SESSION["sess_newscategoryid"]) && $kat->getNewsCategoryID() == $_SESSION["sess_newscategoryid"])
				{
					$selected = "selected";
				}
			}

			$cmb_kategorije .= "<option ".$selected." value='".$kat->getNewsCategoryID()."'>" .$kat->getTitle() . "</option>";
		}
		// filteri
		if(isset($_REQUEST["newscategoryid"]))
		{
			//desila se promena iz forme potrebno je azurirati sessijsku promenljivu na 0
			$_SESSION["offset_news"]=0;
			$ap->SetOffset(0);
			$_SESSION["sess_newscategoryid"] = $_REQUEST["newscategoryid"];
		}

		if(isset($_SESSION["sess_newscategoryid"]))
		{
			if($_SESSION["sess_newscategoryid"] == -1) unset($_SESSION["sess_newscategoryid"]);
		}

		$news_ids = "";
		if(isset($_REQUEST["newscategoryid"]) && $_REQUEST["newscategoryid"] != -1)
		{
			$kategorija = $ObjectFactory->createObject("NewsCategory",$_REQUEST["newscategoryid"], array("News")," * ");
			foreach ($kategorija->News as $nw)
			{
				$news_ids .= $nw->getNewsID(). ",";
			}
			$news_ids = substr($news_ids,0,strlen($news_ids)-1);
			$ObjectFactory->AddFilter("news_id IN (".$news_ids.") ");
		}
		else
		{
			if(isset($_SESSION["sess_newscategoryid"]) && $_SESSION["sess_newscategoryid"] != -1)
			{

				$kategorija = $ObjectFactory->createObject("NewsCategory",	$_SESSION["sess_newscategoryid"],array("News"));
				if(!empty($kategorija->News))
				{
					foreach ($kategorija->News as $nw)
					{
						$news_ids .= $nw->getNewsID(). ",";
					}
					$news_ids = substr($news_ids,0,strlen($news_ids)-1);
					$ObjectFactory->AddFilter("news_id IN (".$news_ids.") ");
				}
				else
				{
					$ObjectFactory->AddFilter(" 1=2 ");
				}
			}
		}

		return $cmb_kategorije .= "</select><input type='hidden' name='kategorija_hit' value='true'>";
	}

?>
