<?
	/* CMS Studio 3.0 modify.php */
	$_ADMINPAGES = true;
	
	include_once("../../config.php");
		
	global $smarty;
	global $auth;

	$title='Probni naziv';
	$description="Probni opis";
	
	$sql_count="SELECT count(*) as cnt FROM `image_data` WHERE `image_url`='".$_REQUEST['image_url']."'";
	$rs=$DBBR->con->get_results($sql_count);
	$cnt=$rs[0]->cnt;
	if ($cnt>0)	{
		$sql_row="SELECT `title`, `description` FROM `image_data` WHERE `image_url`='".$_REQUEST['image_url']."'";
		$result_row = $DBBR->con->get_row($sql_row);	
		$new_arr=array();
		$new_arr['title']=$result_row->title;
		$new_arr['description']=$result_row->description ;		
		
	}
	$new_arr['url']=$_REQUEST['image_url'];
	echo json_encode($new_arr);
	

	
?>