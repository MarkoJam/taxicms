<?
	/* CMS Studio 3.0 modify.php */

	$_ADMINPAGES = true;
	include_once("../../../config.php");

	global $smarty;
	global $auth;

	$ObjectFactory = ObjectFactory::getInstance();

	$prid=$_REQUEST['prid'];
	$nlid=$_REQUEST['newsletterid'];
	$start=$_REQUEST['start'];
	$end=$_REQUEST['end'];

	//zaglavlje
	$text=" <div class='modal-box'  tabindex='-1'   ><table class='table table-striped table-bordered table-hover dataTables-example dataTable'>";
	$text.="<tr><th>Korisnik</th><th>Firma</th><th>Pregleda</th></th><th>Poručeno</th>";

	$sql="SELECT `user_id` as uid, count(`user_id`) as broj  FROM `visits` WHERE `user_id`>0 AND `resource_id`=".$prid." and plugin='product'";
	$sql.=" AND `time` >";
	$sql.=$start;
	$sql.=" AND `time` <";
	$sql.=$end;
	if ($nlid>-1) $sql.=(" AND `newsletter_id`=".$nlid);
	$sql.=" group by `uid` order by `broj` desc";

	$results = $DBBR->con->get_results($sql);
	foreach($results as $res)
	{
		if ($res->uid>0)
		{
			$user = $ObjectFactory->createObject("User",$res->uid);
			// kalkulacija poručenog
			$in_sql=("SELECT sum(`quantity`) as kol FROM `pr_order`, `pr_orderitem` WHERE `userid`=".$res->uid);
			$in_sql.=(" AND `date`>".$start." AND `date`<".$end. " AND pr_order.orderid=pr_orderitem.orderid");
			$in_sql.=(" AND  `proizvodid`=".$prid." GROUP BY `proizvodid`");
			$in_results = $DBBR->con->get_results($in_sql);
			$text.=("<tr><td>".$user->Name." ".$user->Surname."</td><td>".$user->Firm."</td><td>".$res->broj."</td><td>".$in_results[0]->kol."</td></tr>");
		}
	}

	$sql2="SELECT `user_id` as uid, country, count(`user_id`) as broj  FROM `visits` WHERE `user_id`=0 AND `resource_id`=".$prid." and plugin='product'";
	$sql2.=" AND `time` >";
	$sql2.=$start;
	$sql2.=" AND `time` <";
	$sql2.=$end;
	if ($nlid>-1) $sql2.=(" AND `newsletter_id`=".$nlid);
	$sql2.=" group by `country` order by `broj` desc";
	$results2 = $DBBR->con->get_results($sql2);

	foreach($results2 as $res)
	{
		$text.=("<tr><td>Neulogovan korisnik (".$res->country.")</td><td></td><td>".$res->broj."</td><td></td></tr>");
	}
	$text.="</table>";

	$smarty->assign('text',$text);
	$smarty->display('modify.tpl');


?>
