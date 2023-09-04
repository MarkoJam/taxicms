<? 
	/* CMS Studio 3.0 index.php */
	$_ADMINPAGES = true;
	
	include_once("../../../config.php");

	global $smarty;
	global $auth;

	$plugin=$_REQUEST['plugin'];
	$id=rtrim($_REQUEST['plugin'])."_id";
	$post_date='date';
	
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
		if ($j>1) $uploads_array.=",";
		if ($timeperiod=='month') $periods.="'".(date("n",$time)."-".date("Y",$time))."'";
		else $periods.="'".(date("d",$time).".".date("n",$time).".".date("Y",$time))."'";
		
		$uploads_array.="[";
		$uploads_array.="'".$j."'";
		$uploads_array.=",";
		
		$sql1="SELECT `".$post_date."`,".strtoupper($timeperiod)."(FROM_UNIXTIME(`".$post_date."`)) as period, Year(FROM_UNIXTIME(`".$post_date."`)) as year,
		COUNT(`".$id."`) as uploads FROM `".$table."` 
		WHERE  `".$post_date."`>".$t3." AND `".$post_date."`<".$t4." 
		AND ".strtoupper($timeperiod)."(FROM_UNIXTIME(`".$post_date."`))=".$fil_period."
		GROUP BY ".strtoupper($timeperiod)."(FROM_UNIXTIME(`".$post_date."`)) ";	
		
		$uploads_sum=$DBBR->con->get_results($sql1);
		if ($uploads_sum[0]->uploads) $uploads_hit=$uploads_sum[0]->uploads;
		else $uploads_hit=0;
		$uploads_array.=$uploads_hit;
		$uploads_array.="]";
		
		
		$time+=$ti;
	}	
	$periods.="]";	
	
	$smarty->assign('uploads_sum_period',$uploads_array);
	$smarty->assign('periods',$periods);
	
	

	if (file_exists('templates/index.tpl')) $smarty->display('index.tpl');
	else $smarty->display('../../../templates/index1.tpl');
		
?>