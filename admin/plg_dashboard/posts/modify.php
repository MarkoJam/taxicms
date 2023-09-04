<?
	/* CMS Studio 3.0 modify.php */
	
	$_ADMINPAGES = true;
	include_once("../../../config.php");
		
	global $smarty;
	global $auth;
	
	$ObjectFactory = ObjectFactory::getInstance();

	$plugin=$_REQUEST['plugin'];
	$nlid=$_REQUEST['newsletterid'];
	$start=$_REQUEST['start'];
	$end=$_REQUEST['end'];
	$plugin_title=$_REQUEST['plugin_title'];
	
	$text="<script>function modify_plugin(){}</script>";
	//zaglavlje
	$text.=" <div id='content'>";		
	$sql="SELECT `user_id` as id, count(`user_id`) as broj   FROM `visits` WHERE `resource_id`=".$_REQUEST['id']." AND plugin='".$plugin."' AND newsletter_id>0 ";
	$sql.=" AND `time` >";
	$sql.=$start;
	$sql.=" AND `time` <";
	$sql.=$end;
	if ($nlid>-1) $sql.=(" AND `newsletter_id`=".$nlid);	
	$sql.=" group by `id` order by `broj` desc";
	$results = $DBBR->con->get_results($sql);
	if (count($results)>0) {
		$text.="<h2>".$plugin_title." - Users views</h2>";	
		$text.="<div class='table-responsive'><table id='normal'  class='table table-striped table-bordered table-hover dataTables-example dataTable'>";
		$text.="<tr><th>".getTranslation('PLG_NAME')."</th><th>".getTranslation("PLG_COUNT_VIEW")."</th>";						
		foreach($results as $res)
		{
			$obj = $ObjectFactory->createObject('User',$res->id);
			
			$text.="<tr><td>".$obj->getName()." ".$obj->getSurname();
			
			$text.="</td><td style='width:100px'>".$res->broj."</td></tr>";	
		}				
		$text.="</table></div>";
	}
	$text.="<div class='title-action right-btn'><div class='btn btn-default close-modal'><i class='fa fa-times'></i> ".getTranslation("PLG_CLOSE")."</div></div></div>";	
	echo $text;

		
?>