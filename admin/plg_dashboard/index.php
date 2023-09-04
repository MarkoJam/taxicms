<? 
	/* CMS Studio 3.0 index.php */
	$_ADMINPAGES = true;
	
	include_once("../../config.php");

	global $smarty;
	global $auth;

/*News
Aktivnost News – Broj objavljenih vesti/mesec

Useri
Aktivnost Usera – Broj logovanja/mesec

Newsletter
Aktivnost Newsletter – Broj newslettera/mesec, Broj poslatih usera/mesec

Proizvodi
Aktivnost Shopa – Broj narudzbi/mesec, Iznos narudzbi/mesec*/

	
	$t1=time()-365*24*3600;
	$t2=time()-31*24*3600;
	
	// izbor perioda za prikaz na grafikonu
	$sql="SELECT MIN(`time`) as min FROM `visits` " ;
	$min1=$DBBR->con->get_results($sql);	
	$sql="SELECT MIN(`date`) as min FROM `pr_order` " ;
	$min2=$DBBR->con->get_results($sql);
	$min=max($min1[0]->min,$min2[0]->min);
	$days = (time()-$min)/(3600*24);	
	if ($days>350)  $timeperiod="month"; // za 12 meseci unazad
	elseif ($days>84) $timeperiod="week";	// za 12 nedelja unazad
	else $timeperiod="dayofyear"; // za 12 dana unazad
	switch ($timeperiod) {
		case "dayofyear":
			$t3=time()-12*24*3600;
			$t4=time();
			$ti=24*3600;
			$filter="z";
			$smarty->assign('lab_period', getTranslation("PLG_DAYS"));
			break;
		case "week":
			$day=date('w',time());
			$t3=time()-($day)*24*3600-12*7*24*3600;
			$t4=time()-($day)*24*3600;	
			$ti=7*24*3600;
			$filter="W";
			$smarty->assign('lab_period', getTranslation("PLG_WEEKS"));			
			break;
		case "month":
			
			$t3=strtotime(date("n", time())."/2/".date("Y", time()))-365*24*3600;
			$t4=strtotime(date("n", time())."/1/".date("Y", time()));
			$ti=31*24*3600;
			$filter="n";
			$smarty->assign('lab_period', getTranslation("PLG_MONTHS"));						
			break;
		default:	
			break;
	}
	
	$ObjectFactory->filters=array('date>'.$t1, 'status_id='.STATUS_NEWS_AKTIVAN );
	$news_count= $DBBR->prebrojSveSlogove($ObjectFactory->createObject("News",-1),$ObjectFactory->filters);	
	$smarty->assign('news_count',$news_count);
		
	$ObjectFactory->filters=array('last_log_date>'.$t1);
	$alog_count= $DBBR->prebrojSveSlogove($ObjectFactory->createObject("AdminUserLogHistory",-1),$ObjectFactory->filters);	
	$smarty->assign('alog_count',$alog_count);

	$ObjectFactory->filters=array('last_log_date>'.$t2);
	$log_count= $DBBR->prebrojSveSlogove($ObjectFactory->createObject("UserLogHistory",-1),$ObjectFactory->filters);	
	$smarty->assign('log_count',$log_count);
	
	$sql="SELECT COUNT(`visit_id`) as cnt FROM `visits` WHERE  `time`>".$t1." AND resource_id=0 AND newsletter_id=0";

	$visit_count=$DBBR->con->get_results($sql);
	$visit_count=$visit_count[0]->cnt;
	$smarty->assign('visit_count',$visit_count);		
	
	
	$time=$t3;
	$periods="[";
	for ($j = 1; $j <= 12; $j++) {
		$fil_period=date($filter,$time);
		if ($j>1) $periods.=",";
		if ($j>1) $visits_array.=",";
		if ($j>1) $order_array.=",";
		if ($timeperiod=='month') $periods.="'".(date("n",$time)."-".date("Y",$time))."'";
		else $periods.="'".(date("d",$time).".".date("n",$time).".".date("Y",$time))."'";
		
		$visits_array.="[";
		$visits_array.="'".$j."'";
		$visits_array.=",";
		
		$sql1="SELECT `time`,".strtoupper($timeperiod)."(FROM_UNIXTIME(`time`)) as period, Year(FROM_UNIXTIME(`time`)) as year,
		COUNT(`visit_id`) as visits FROM `visits` 
		WHERE  `time`>".$t3." AND `time`<".$t4." AND resource_id=0
		AND ".strtoupper($timeperiod)."(FROM_UNIXTIME(`time`))=".$fil_period."
		GROUP BY ".strtoupper($timeperiod)."(FROM_UNIXTIME(`time`)) ";	
		
		$visits_sum=$DBBR->con->get_results($sql1);
		if ($visits_sum[0]->visits) $visits_hit=$visits_sum[0]->visits;
		else $visits_hit=0;
		$visits_array.=$visits_hit;
		$visits_array.="]";
		
		$order_array.="[";
		$order_array.="'".$j."'";
		$order_array.=",";
		
		$sql2="SELECT `date`,".strtoupper($timeperiod)."(FROM_UNIXTIME(`date`)) as period, Year(FROM_UNIXTIME(`date`)) as year, SUM(`quantity`*`price`) as sum FROM `pr_order`,`pr_orderitem`  
		WHERE  `date`>".$t3." AND `date`<".$t4." AND pr_order.orderid=pr_orderitem.orderid AND pr_orderitem.proizvodid>0
		AND ".strtoupper($timeperiod)."(FROM_UNIXTIME(`date`))=".$fil_period."		
		GROUP BY ".strtoupper($timeperiod)."(FROM_UNIXTIME(`date`)) ";	
		$order_sum=$DBBR->con->get_results($sql2);
		if ($order_sum[0]->sum) $order_hit=$order_sum[0]->sum;
		else $order_hit=0;
		$order_array.=$order_hit;
		$order_array.="]";
		
		$time+=$ti;
	}	
	$periods.="]";	
	
	
	$ObjectFactory->ResetFilters();
	$ObjectFactory->AddFilter("status = 1");			
	$resources = $ObjectFactory->createObjects("SfResource");
	$ObjectFactory->ResetFilters();

	// select box za Resurse
	$shres = new SmartyHtmlSelection("resources",$smarty);
	foreach($resources as $res)
	{
		$shres->AddValue($res->getCode());
		$shres->AddOutput($res->getVrednost());				
	}
	$shres->SmartyAssign();
	
	
	
	$smarty->assign('visits_sum_period',$visits_array);
	$smarty->assign('periods',$periods);

	$smarty->display('index.tpl');		
?>