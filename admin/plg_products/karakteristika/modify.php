<?
	/* CMS Studio 3.0 modify.php */
	
	$_ADMINPAGES = true;
	include_once("../../../config.php");
		
	global $smarty;
	global $auth;

	if($auth->isActionAllowed("ACTION_PRODUCT_CHARTYPE_MODIFY"))
	{
		if(($_REQUEST["mode"])=='insert') $_REQUEST["karakteristika_vrsta_id"]=-1;
		if ($_REQUEST['mode']=='insert2') 
		{
			$obj = $ObjectFactory->createObject("PrKarakteristikaVrsta");
			$colid=$DBBR->vratiPoslednjiID($obj);
			$col=$colid[0];
			$id=$colid[1];
			$_REQUEST[$col]=$_POST[$col]=$id;
		}		
		if(isset($_REQUEST["karakteristika_vrsta_id"]))
		{
			// deo za insertovanje novog sloga
			if(($_REQUEST["mode"])=='insert') $smarty->assign("mode", 'insert');
			else $smarty->assign("mode", 'edit');
			
			
			$admTbl = new AdminTable();
			$admTbl->SetTitle("Ažuriranje vrednosti karakteristika:");
			$admTbl->SetHeader(array(
								getTranslation("PLG_NAME"),
								getTranslation("PLG_CHANGE"),
								getTranslation("PLG_DELETE")
								));
			
			$admTbl->SetOffsetName("offset_karakteristikavr_".$_REQUEST["karakteristika_vrsta_id"]);
			
			$prkarakteristikavrsta = $ObjectFactory->createObject("PrKarakteristikaVrsta",$_REQUEST["karakteristika_vrsta_id"], array("PrKarakteristikaElement"));


			if (isset($_REQUEST['title']) && isset($_REQUEST['description'])) 
			{
				$prkarakteristikavrsta->Naziv = $_REQUEST['title'];
				$prkarakteristikavrsta->Opis = $_REQUEST['description'];
			}
			$ObjectFactory->AddLimit($admTbl->GetRowCount());
			$ObjectFactory->AddOffset($admTbl->GetOffset());
			$ObjectFactory->AddFilter("karakteristika_vrsta_id = " . $_REQUEST["karakteristika_vrsta_id"]);
			
			$prkarakteristikaelementi = $ObjectFactory->createObjects("PrKarakteristikaElement");
			$smarty->assign($prkarakteristikavrsta->toArray());
				
			$admTbl->AddBrowseString("karakteristikavrstaid=".$prkarakteristikavrsta->KarakteristikaVrstaID);
			$admTbl->SetCountAllRows(count($prkarakteristikavrsta->PrKarakteristikaElement));

			//za slicice gore-dole
			$html_img_up = "<img border=0 src='images/arr_up.gif'>";
			$html_img_down = "<img border=0 src='images/arr_down.gif'>";
			$html_img_delete = "<div class='btn btn-white'><i class='fa fa-minus-square-o'></i></div>";
		
			foreach ($prkarakteristikaelementi as $element)
			{
				$valueField  = $element->Vrednost;
				$changeField = "<a id='modifybutt' data-param='".$element->KarakteristikaElementID."'>".getTranslation("PLG_CHANGE")."</a>";
				$deleteField = "<a id='delete-element' data-param='karakteristikavrstaid=".$prkarakteristikavrsta->KarakteristikaVrstaID."&karakteristikaelementid=".$element->KarakteristikaElementID."'>".$html_img_delete."</a>";
				
				if(isset($_REQUEST["karakteristikaelementid"]) && $element->KarakteristikaElementID ==  $_REQUEST["karakteristikaelementid"])
				{
					if(isset($_REQUEST["action"]) && isset($_REQUEST["karakteristika_vrsta_id"]) && $_REQUEST["action"] == "modify")
					{
						$valueField  = '<input name="elementvrednost_mod" id="elementvrednost_mod" class="form-control" type="text" value="'.$element->Vrednost.'">';
						$changeField = "<div name='action_modify' id='action_modify' data-param='".$element->KarakteristikaElementID."' class='btn btn-primary'><i class='fa fa-check'></i>&nbsp;".getTranslation('PLG_SAVE')."</div>";
						$deleteField = '&nbsp;';
					}
				}
				
				$admTbl->AddTableRow(
							array(
								$valueField,
								$changeField,
								$deleteField
								));
			}
			$admTbl->RegisterAdminPage($smarty);
		}
	
		$smarty->display('modify.tpl');
	}
	else 
	{
		// show error message not enough rights
		$smarty->assign("norights_message",getTranslation("PLG_NORIGHT"));
		$smarty->display('../../../templates/norights.tpl');	
	}
?>