<?
	/* CMS Studio 3.0 modify.php */
	$_ADMINPAGES = true;
	
	include_once("../../config.php");
		
	global $auth;


	$sql_count="SELECT count(*) as cnt FROM `image_data` WHERE `image_url`='".$_REQUEST['image_url']."'";
	$rs=$DBBR->con->get_results($sql_count);
	$cnt=$rs[0]->cnt;
	//echo ltrim($cnt);
	if ($cnt>0)	{
		$sql_update="UPDATE `image_data` SET `title`='".$_REQUEST['title']."',`description`='".$_REQUEST['description']."' WHERE `image_url`='".$_REQUEST['image_url']."'";
		$DBBR->con->query($sql_update);
	}
	else {	
	if (ltrim($_REQUEST['title'])!="" || ltrim($_REQUEST['description'])!="") {
			$sql_insert="INSERT INTO `image_data`(`image_url`, `title`, `description`) VALUES ('".$_REQUEST['image_url']."','".$_REQUEST['title']."','".$_REQUEST['description']."')";
			$DBBR->con->query($sql_insert);
		}
	}
	echo "<div class='success'>".getTranslation("PLG_CHANGE_SUCCESS")."</div>";

		

	
?>