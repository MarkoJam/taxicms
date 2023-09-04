<? 
	/* CMS Studio 3.0 index.php */
	$_ADMINPAGES = true;
	
	include_once("../../../config.php");

	global $smarty;
	global $auth;

	$plugin=$_REQUEST['plugin'];
	
	$t1=time()-365*24*3600;
	$t2=time()-31*24*3600;
	
	// izbor perioda za prikaz na grafikonu
	$sql="SELECT MIN(`time`) as min FROM `visits` " ;
	$min=$DBBR->con->get_results($sql);	
	$days = (time()-$min[0])/(3600*24);	
	if ($days>365)  $timeperiod="month"; // za 12 meseci unazad
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
		
	$time=$t3;
	$periods="[";
	for ($j = 1; $j <= 12; $j++) {
		$fil_period=date($filter,$time);
		if ($j>1) $periods.=",";
		if ($j>1) $views_array.=",";
		if ($timeperiod=='month') $periods.="'".(date("n",$time)."-".date("Y",$time))."'";
		else $periods.="'".(date("d",$time).".".date("n",$time).".".date("Y",$time))."'";
		
		$views_array.="[";
		$views_array.="'".$j."'";
		$views_array.=",";
		
		$sql1="SELECT `time`,".strtoupper($timeperiod)."(FROM_UNIXTIME(`time`)) as period, Year(FROM_UNIXTIME(`time`)) as year,
		COUNT(`resource_id`) as views FROM `visits` 
		WHERE  `time`>".$t3." AND `time`<".$t4." 
		AND newsletter_id>0 AND plugin='".$plugin."'
		AND ".strtoupper($timeperiod)."(FROM_UNIXTIME(`time`))=".$fil_period."
		GROUP BY ".strtoupper($timeperiod)."(FROM_UNIXTIME(`time`)) ";	
		
		$views_sum=$DBBR->con->get_results($sql1);
		if ($views_sum[0]->views) $views_hit=$views_sum[0]->views;
		else $views_hit=0;
		$views_array.=$views_hit;
		$views_array.="]";
		
		
		$time+=$ti;
	}	
	$periods.="]";	
	
	$smarty->assign('views_sum_period',$views_array);
	$smarty->assign('periods',$periods);
	
	

	if (file_exists('templates/index.tpl')) $smarty->display('index.tpl');
	else $smarty->display('../../../templates/index1.tpl');
		
?>