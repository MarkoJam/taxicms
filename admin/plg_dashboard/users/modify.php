<?
	/* CMS Studio 3.0 modify.php */
	
	$_ADMINPAGES = true;
	include_once("../../../config.php");
		
	global $smarty;
	global $auth;
	
	$ObjectFactory = ObjectFactory::getInstance();
			
	$uid=$_REQUEST['userid']; 	
	$nlid=$_REQUEST['newsletterid'];
	$start=$_REQUEST['start'];
	$end=$_REQUEST['end'];
	
	$text="<script>function modify_plugin(){}</script>";
	//zaglavlje
	$text.=" <div id='content'>";
	$user = $ObjectFactory->createObject('User',$uid);
	$text.="<h2>".$user->Name." ".$user->Surname."</h2>"; 

		
	$text.=visit_plugin('proizvod','PrProizvod','PLG_ADMIN_MENU_PRODUCT',$DBBR,$ObjectFactory,$uid,$nlid,$start,$end) ;			
	$text.=visit_plugin('news','News','PLG_ADMIN_MENU_NEWS',$DBBR,$ObjectFactory,$uid,$nlid,$start,$end) ;	
	$text.=visit_plugin('event','Event','PLG_ADMIN_MENU_EVENTS',$DBBR,$ObjectFactory,$uid,$nlid,$start,$end) ;	
	$text.=visit_plugin('persons','Persons','PLG_ADMIN_MENU_PERSONS',$DBBR,$ObjectFactory,$uid,$nlid,$start,$end) ;	
	$text.=visit_plugin('project','Project','PLG_ADMIN_MENU_PROJECT',$DBBR,$ObjectFactory,$uid,$nlid,$start,$end) ;	

	
	$text.="<div class='title-action right-btn'><div class='btn btn-default close-modal'><i class='fa fa-times'></i> ".getTranslation("PLG_CLOSE")."</div></div></div>";
	
	echo $text;
	
	
		
	function visit_plugin($plugin,$class, $title,$DBBR,$ObjectFactory,$uid,$nlid,$start,$end) {
		$sql="SELECT `resource_id` as id, count(`resource_id`) as broj   FROM `visits` WHERE `user_id`=".$uid." AND plugin='".$plugin."' AND resource_id>0";
		$sql.=" AND `time` >";
		$sql.=$start;
		$sql.=" AND `time` <";
		$sql.=$end;
		//if ($nlid>-1) $sql.=(" AND `newsletter_id`=".$nlid);	
		$sql.=" group by `id` order by `broj` desc";
		$results = $DBBR->con->get_results($sql);
		if (count($results)>0) {
			$text="<h2>".getTranslation($title)." - Seen posts</h2>";	
			$text.="<div class='table-responsive'><table id='normal'  class='table table-striped table-bordered table-hover dataTables-example dataTable'>";
			$text.="<tr><th>".getTranslation('PLG_NAME')."</th><th>".getTranslation("PLG_COUNT_VIEW")."</th>";						
			foreach($results as $res)
			{
				$obj = $ObjectFactory->createObject($class,$res->id);
				
				$text.="<tr><td>";
				if ($plugin=='proizvod') $text.=$obj->getNaziv();
				else $text.=$obj->getHeader();

				$text.="</td><td style='width:100px'>".$res->broj."</td></tr>";	
			}				
			$text.="</table></div>";
		}
		//$text=$sql;
		return $text;
	}
		
?>