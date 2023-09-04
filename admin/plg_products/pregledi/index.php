<?

session_start();
	/* CMS Studio 3.0 index.php */

    //include "loader.php";
	$_ADMINPAGES = true;
	include_once("../../../config.php");

	global $smarty;
	global $auth;

	if($_REQUEST['link'])
	{
		$params=explode('/',$_REQUEST['link']);
		foreach ($params as $p) {
			$p=str_replace("?", "", $p);
			$p=str_replace("index.php", "", $p);
			$pp=explode('=',$p);
			$a=$pp[0];
			$_REQUEST[$a]=$pp[1];
		}
	}
	if (isset($_REQUEST['range'])) $smarty->assign('range',$_REQUEST['range']);

	if (!isset($_REQUEST['offset'])) $_REQUEST['offset']=0;
	$ObjectFactory = ObjectFactory::getInstance();
	if($auth->isActionAllowed("ACTION_PRODUCT_VIEW"))
	{
		$ap = new AdminTable();
		$ap->SetTitle("Ažuriranje knjiga:");
		$ap->SetOffsetName("offset_prproizvodi");


		if(isset($_REQUEST['sortby'])) $_SESSION["sess_sortby"] = $_REQUEST['sortby'];
		else
			if(isset($_SESSION["sess_sortby"])) $_REQUEST['sortby']=$_SESSION["sess_sortby"];
		if(isset($_REQUEST['direction'])) $_SESSION["sess_direction"] = $_REQUEST['direction'];
		else
			if(isset($_SESSION["sess_direction"])) $_REQUEST['direction']=$_SESSION["sess_direction"];

		// combobox za newsletter
		$ObjectFactory->Reset();
		$newsletter = $ObjectFactory->createObjects("Newsletter");
		if ($_REQUEST['newsletterid']) $snl=$_REQUEST['newsletterid'];
		else $snl=-1;
		$ShNL= new SmartyHtmlSelection("newsletter",$smarty);
		$ShNL->AddValue(-1);
		$ShNL->AddOutput("bez filtera");
		foreach($newsletter as $nl)
		{
			$ShNL->AddValue($nl->NewsletterID);
			$ShNL->AddOutput($nl->Header);
		}
		$ShNL->AddSelected($snl);
		$ShNL->SmartyAssign();

		$cmbGrupaProizvoda = makeGrupaProizvodaCombo($ObjectFactory, $ap);
		$comboFilterTipProizvoda = new TipProizvodaFilter($ObjectFactory,$ap);
		$comboFilterTipProizvoda->generateProccessComboBox();
		$comboFilterStatus = new ProizvodStatusFilter($ObjectFactory,$ap);
		$comboFilterStatus->generateProccessComboBox();
		$ObjectFactory->Reset();

		// REFAKTORISATI OVAJ DEO
		if(isset($_REQUEST["records_per_page"]) && is_numeric($_REQUEST["records_per_page"]))
		{
			$productsPerPage = $_REQUEST["records_per_page"];
			$_SESSION["records_per_page_prproizvod"] = $productsPerPage;
		}
		else if(isset($_SESSION["records_per_page_prproizvod"]) && is_numeric($_SESSION["records_per_page_prproizvod"]))
		{
			$productsPerPage = $_SESSION["records_per_page_prproizvod"];
		}
		else $productsPerPage = 20;


		$recordsPerPage = array(20,40,60,80,100,200);
		$shRecordsPerPage = new SmartyHtmlSelection("recordsPerPage",$smarty);
		foreach ($recordsPerPage as $num)
		{
			$shRecordsPerPage->AddOutput($num);
			$shRecordsPerPage->AddValue($num);
		}

		$shRecordsPerPage->AddSelected($productsPerPage);
		$shRecordsPerPage->SmartyAssign();

		$ap->SetRowCount($productsPerPage);
		$ap->SetColCount();

		// ZAVRSETAK POTREBNOG REFAKTORISANJA
		$tipoviproizvoda = $ObjectFactory->createObjects("PrTipProizvoda");

		$ap->SetHeader(array(
								SortLink::generateLink("<span class='promeni'>".getTranslation("PLG_PRODUCT_HEADER_TITLE")."</span>","naziv"),
								SortLink::generateLink(getTranslation("PLG_PRODUCT_HEADER_TYPE"),"tipproizvodaid")."<br/>".$comboFilterTipProizvoda->getComboBox(),
								getTranslation("PLG_PRODUCT_HEADER_PRODUCTGROUP")."<br/>".$cmbGrupaProizvoda,
								SortLink::generateLink(getTranslation("PLG_PRODUCT_HEADER_STATUS"),"status_id")."<br/>".$comboFilterStatus->getComboBox(),
								SortLink::generateLink("Akcija","akcijap"),
								SortLink::generateLink(getTranslation("PLG_PRODUCT_HEADER_COUNT"),"cnt")."<br/>".makeBrojPregledaCombo(),
								SortLink::generateLink("Poručeno","cnt_ord")
		));

		//ZA SADRZAJ TABELE
		$array_order=array();
		if ($_REQUEST['newsletterid'])
		{
			$newsletter = $ObjectFactory->createObject("Newsletter",$_REQUEST['newsletterid']);
			$html=$newsletter->Html;
			$offset = 0;
			$needle1="/uid/";
			$positions1 = array();
			while (($lastPos = strpos($html, $needle1, $offset))!== false) {
				$positions1[] = $lastPos;
				$offset = $lastPos + 1;
			}
			$offset = 0;
			$needle2="/proizvod/";
			$positions2 = array();
			while (($lastPos = strpos($html, $needle2, $offset))!== false) {
				$positions2[] = $lastPos;
				$offset = $lastPos + 1;
			}
			$i=0;
			$prid=array();
			$prid_txt="(";
			foreach ($positions2 as $value) {
				$pid=explode("/",substr($html, $value+10, $positions1[$i]-$value-10));
				$prid[]=$pid[1];
				if ($i>0) $prid_txt.= ",";
				$prid_txt.= ($pid[1]);
				$i+=1;
			}
			$prid_txt.= ")";
		}
		$offset=$_REQUEST['offset']/7;

		// sql za prebrojavanje gledanog za niz za filtriranje
		if (!isset($_REQUEST["brojpregledaid"])) $_REQUEST["brojpregledaid"]=10;
		if ($_REQUEST["brojpregledaid"] > -1)
		{
			$c_sql= "SELECT resource_id, count(`resource_id`) as cnt_proiz FROM `visits` WHERE plugin='product' ";
			if ($_REQUEST['newsletterid'] && $_REQUEST['newsletterid'] != -1)
			{
				$c_sql.=" AND `newsletter_id` = ";
				$c_sql.=$_REQUEST['newsletterid'];
			}
			if ($_REQUEST['start'] && $_REQUEST['end'])
			{
				$start=$_REQUEST['start'];
				$end=$_REQUEST['end'];
			}
			else
			{
				$start=time()-29*24*3600;
				$end=time();
			}
			$c_sql.=" AND `time` >";
			$c_sql.=$start;
			$c_sql.=" AND `time` <";
			$c_sql.=$end;
			$c_sql.=" GROUP BY resource_id ";
			$c_sql.=" ORDER BY cnt_proiz desc";
			$results_c = $DBBR->con->get_results($c_sql);
			$cnt_txt="(";
			$i=0;
			foreach($results_c as $res)
			{
				if ($res->cnt_proiz>$_REQUEST["brojpregledaid"])
				{
					if ($i>0) $cnt_txt.= ",";
					$cnt_txt.= $res->resource_id;
					$i+=1;
				}
			}
			$cnt_txt.=")";
		}

		// unutrasnji filter za vremensko ogranicenje visits-a
		if ($_REQUEST['start'] && $_REQUEST['end'])
		{
			$start=$_REQUEST['start'];
			$end=$_REQUEST['end'];
		}
		else
		{
			$start=time()-29*24*3600;
			$end=time();
		}
		$time_filter.=" AND `time` >";
		$time_filter.=$start;
		$time_filter.=" AND `time` <";
		$time_filter.=$end;

		// unutrasnji filter za vremensko ogranicenje visits-a
		if ($_REQUEST['start'] && $_REQUEST['end'])
		{
			$start=$_REQUEST['start'];
			$end=$_REQUEST['end'];
		}
		else
		{
			$start=time()-29*24*3600;
			$end=time();
		}
		$time2_filter.=" AND `date` >";
		$time2_filter.=$start;
		$time2_filter.=" AND `date` <";
		$time2_filter.=$end;

		// unutrasnji filter za newsletter
		if ($_REQUEST['newsletterid'] && $_REQUEST['newsletterid'] != -1)
		{
			$nl_filter.=" AND `newsletter_id` = ";
			$nl_filter.=$_REQUEST['newsletterid'];
		}

		// filter za pregledane proizvode
		if ($_REQUEST["brojpregledaid"] > -1)
		{
			$f_cnt_sql= " AND proizvodid IN ";
			$f_cnt_sql.= $cnt_txt;
		}
		// filtriranja
		$f_sql="";
		//newsletter
		if ($_REQUEST['newsletterid'] && $_REQUEST["newsletterid"] != -1)
		{
			$f_sql.= " AND proizvodid IN ";
			$f_sql.= $prid_txt;
			$f_cnt_sql="";
		}
		// grupa proizvoda
		$resource_ids = "";
		if(isset($_REQUEST["grupaproizvodaid"]) && $_REQUEST["grupaproizvodaid"] != -1)
		{
			$grupaproizvoda = $ObjectFactory->createObject("PrGrupaProizvoda",$_REQUEST["grupaproizvodaid"],array("PrProizvod"));
			foreach ($grupaproizvoda->PrProizvodList as $proiz)
			{
				$resource_ids .= $proiz->ProizvodID . ",";
			}
			$resource_ids = substr($resource_ids,0,strlen($resource_ids)-1);
			$f_sql.= " AND proizvodid IN (";
			$f_sql.= $resource_ids;
			$f_sql.= ") ";
			$f_cnt_sql="";
		}
		else
		{
			if(isset($_SESSION["sess_prgrupaproizvodaid"]) && $_SESSION["sess_prgrupaproizvodaid"] != -1)
			{
				$grupaproizvoda = $ObjectFactory->createObject("PrGrupaProizvoda",	$_SESSION["sess_prgrupaproizvodaid"],array("PrProizvod"));
				if(!empty($grupaproizvoda->PrProizvodList))
				{
					foreach ($grupaproizvoda->PrProizvodList as $proiz)
					{
						$resource_ids .= $proiz->ProizvodID . ",";
					}
					$resource_ids = substr($resource_ids,0,strlen($resource_ids)-1);
					$f_sql.= " AND proizvodid IN (";
					$f_sql.= $resource_ids;
					$f_sql.= ") ";
				}
			}
		}
		// tip proizvoda
		if ($_REQUEST['tipproizvodaid'] && $_REQUEST['tipproizvodaid'] != -1)
		{
			$f_cnt_sql="";
			$ObjectFactory->Reset();
			$ObjectFactory->AddFilter('tipproizvodaid =' .$_REQUEST['tipproizvodaid']);
			$proizvodi=$ObjectFactory->createObjects('PrProizvod');
			$ObjectFactory->Reset();
			$resource_ids = "";
			if(!empty($proizvodi))
			{
				foreach ($proizvodi as $proiz)
				{
					$resource_ids .= $proiz->ProizvodID . ",";
				}
					$resource_ids = substr($resource_ids,0,strlen($resource_ids)-1);
					$f_sql.= " AND proizvodid IN (";
					$f_sql.= $resource_ids;
					$f_sql.= ") ";
			}
		}

		// status proizvoda
		if ($_REQUEST['statusid'] && $_REQUEST['statusid'] != -1)
		{
			$f_cnt_sql="";
			$ObjectFactory->Reset();
			$ObjectFactory->AddFilter('status_id =' .$_REQUEST['statusid']);
			$proizvodi=$ObjectFactory->createObjects('PrProizvod');
			$ObjectFactory->Reset();
			$resource_ids = "";
			if(!empty($proizvodi))
			{
				foreach ($proizvodi as $proiz)
				{
					$resource_ids .= $proiz->ProizvodID . ",";
				}
					$resource_ids = substr($resource_ids,0,strlen($resource_ids)-1);
					$f_sql.= " AND proizvodid IN (";
					$f_sql.= $resource_ids;
					$f_sql.= ") ";
			}
		}

		// sortiranje
		$s_sql="";

		if ($_REQUEST['sortby']) $order=$_REQUEST['sortby'];
		else $order = "cnt";
		if ($_REQUEST['direction']) $direct = $_REQUEST['direction'];
		else $direct = "desc";
		$s_sql.= " ORDER BY ";
		$s_sql.= $order;
		$s_sql.= " ";
		$s_sql.= $direct;

		// formiranje sql za ukupan broj pregleda
		$sql3= "SELECT count(`resource_id`) as pid FROM `visits`,`pr_proizvod` WHERE pr_proizvod.proizvodid=visits.resource_id AND plugin='product'";
		if ($_REQUEST['start'] && $_REQUEST['end'])
		{
			$start=$_REQUEST['start'];
			$end=$_REQUEST['end'];
		}
		else
		{
			$start=time()-29*24*3600;
			$end=time();
		}
		$sql3.=" AND `time` >";
		$sql3.=$start;
		$sql3.=" AND `time` <";
		$sql3.=$end;
		$sql3.=str_replace('proizvodid','resource_id',$f_sql);
		if (($_REQUEST["newsletterid"]) && ($_REQUEST["newsletterid"]>-1))
		{
			$sql3.=" AND `newsletter_id` = ";
			$sql3.=$_REQUEST["newsletterid"];
		}
		$results_pag = $DBBR->con->get_results($sql3);
		$sum_count=$results_pag[0]->pid;

		//formiranje sql za paginaciju
		$sql="SELECT count(`proizvodid`) as pid ";
		$sql.= " FROM `pr_proizvod` WHERE 1=1 ";
		$sql.= $f_cnt_sql;
		$sql.= $f_sql;
		$results_pag = $DBBR->con->get_results($sql);
		$numpage=$results_pag[0]->pid;

		//formiranje sql za tabelu
		$sql =
			"SELECT `proizvodid` as pid,  `naziv` , `tipproizvodaid`, `status_id`,  SUM(`akcija`) as akcijap, SUM(`hit_count`) as cnt, SUM(`ordered`) as cnt_ord
			FROM (" ;
		$sql.=
			"SELECT  `proizvodid` ,  `naziv` , `tipproizvodaid`, `status_id`, '0' as akcija, '0' as hit_count, '0' as ordered
			FROM  `pr_proizvod` ";
		$sql.= " UNION ALL ";
		$sql.=
			"SELECT  `resource_id` AS proizvodid, '', '' , '', `akcija`,  '1' as hit_count, '0' as ordered
			FROM  `visits` WHERE plugin='product' ";
		$sql.=$time_filter;
		$sql.=$nl_filter;
		$sql.= " UNION ALL ";
		$sql.=
			"SELECT `proizvodid`, '', '' , '', '0' as akcija, '0' as hit_count, '1' as ordered
			FROM `pr_order`, `pr_orderitem` WHERE
			pr_order.orderid=pr_orderitem.orderid AND `proizvodid`>0 ";
		$sql.=$time2_filter;
		$sql.= ")derivedTable ";

		$sql.= " WHERE 1=1 ";
		$sql.= $f_cnt_sql;
		$sql.= $f_sql;
		$sql.= " GROUP BY `pid` ";
		$sql.= $s_sql;
		$sql.= " LIMIT ".$offset.",".$productsPerPage;
		$results_tab = $DBBR->con->get_results($sql);
		$table=array();
		foreach($results_tab as $res)
		{
			$order_class = "class='sectionsid' id='sectionsid_".$res->pid."'";
			array_push($array_order,$order_class);
			$count=$res->cnt;
			if ($res->akcijap>0) $akcija="da";
			else $akcija="ne";
			if ($res->cnt_ord) $count_order=$res->cnt_ord;
			else $count_order=0;
			if ($count>0) $id=$res->pid;
			else $id='0';
			$naziv=$res->naziv;
			if ($naziv=='') $naziv='Izbrisan proizvod id:'.$res->pid;
			if ($id>0) $naziv="<b>".$naziv."</b>";
			$modify_link = "<a class='naziv' href='modify.php?prid=".$id."'>".$naziv."</a>";

			$odo = $ObjectFactory->createObject("PrProizvod",$res->pid,array("SfStatus","PrTipProizvoda","PrGrupaProizvoda"));

			$ap->AddTableRow(
							array(
								$modify_link,
								$odo->getTipProizvoda()."&nbsp;",
								$odo->getGrupaProizvoda()."&nbsp;",
								$odo->SfStatus->Vrednost."&nbsp;",
								$akcija."&nbsp;",
								$count."&nbsp;",
								$count_order
							));
		}

		$ap->SetTdTableAttributes(array("width='10%' class='title'","width='10%' class='type'","width='10%' class='group'","width='10%' class='status2'","width='10%' align='center' class='count'", "width='10%' align='center' class='count_order'" ));
		$ap->SetTrTableAttributes($array_order);
		$ap->SetCountAllRows($numpage);
		$ap->RegisterAdminPage($smarty);
		$smarty->assign('sum_count',$sum_count);
		$smarty->display('index.tpl');
	}
	else
	{
		// show error message not enough rights
		$smarty->assign("norights_message",getTranslation("PLG_PRODUCT_NORIGHT_VIEW"));
		$smarty->display('../../../templates/norights.tpl');
	}


	function makeGrupaProizvodaCombo($ObjectFactory, $ap)
	{
		//  formiranje combo box-a
		$ObjectFactory1 = new ObjectFactory();
		$ObjectFactory1->Reset();
		$ObjectFactory1->SetSortBy("naziv");
		$grupeproizvoda = $ObjectFactory1->createObjects("PrGrupaProizvoda");
		$ObjectFactory1->Reset();
		$cmb_grupeproizvoda  = "<select name='grupaproizvodaid' class='form-control' onChange='formTable.submit();'>";
		$cmb_grupeproizvoda .="<option value='-1'>bez filtera</option>";
		foreach ($grupeproizvoda as $kat)
		{
			$selected = "";
			if(isset($_REQUEST["grupaproizvodaid"]) && $kat->getGrupaProizvodaID() == $_REQUEST["grupaproizvodaid"])
			{
				$selected = "selected";
			}
			else if(isset($_SESSION["sess_prgrupaproizvodaid"]) && $kat->getGrupaProizvodaID() == $_SESSION["sess_prgrupaproizvodaid"])
			{
				$selected = "selected";
			}
			$cmb_grupeproizvoda .= "<option ".$selected." value='".$kat->getGrupaProizvodaID()."'>" .$kat->getNaziv() . "</option>";
		}
		return $cmb_grupeproizvoda .= "</select><input type='hidden' name='grupaproizvoda_hit' value='true'>";
	}

	function makeBrojPregledaCombo()
	{
		if (!($_REQUEST["grupaproizvodaid"]>-1) && !($_REQUEST["tipproizvodaid"]>-1) && !($_REQUEST["newsletterid"]>-1))
		{
			//  formiranje combo box-a
			$cmb_brojpregleda  = "<select name='brojpregledaid' class='form-control' onChange='formTable.submit();'>";
			$brojproizvoda=array(10,1,0);
			foreach ($brojproizvoda as $bp)
			{
				$selected = "";
				if($_REQUEST["brojpregledaid"]>-1 && $bp == $_REQUEST["brojpregledaid"])
				{
					$selected = "selected";
				}
				else if(isset($_SESSION["sess_prbrojpregledaid"]) && $bp == $_SESSION["sess_prbrojpregledaid"])
				{
					$selected = "selected";
				}
				$cmb_brojpregleda .= "<option ".$selected." value='".$bp."'>Više od " .$bp. "</option>";
			}
			if ($_REQUEST["brojpregledaid"]==-1) $selected = "selected";
			else $selected="";
			$cmb_brojpregleda .="<option ".$selected." value='-1'>svi</option>";
			return $cmb_brojpregleda .= "</select><input type='hidden' name='brojpregleda_hit' value='true'>";
		}
	}





?>
