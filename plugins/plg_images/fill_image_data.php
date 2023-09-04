<?
	/* CMS Studio 3.0 modify.php */
	
	include_once("../../config.php");
	//$_REQUEST['src']='http://localhost/test//images/blogs/n1-1.jpg';
	$img=str_replace(ROOT_WEB,'',$_REQUEST['src']);		
	$sql_count="SELECT count(*) as cnt FROM `image_data` WHERE `image_url`='".$img."'";
	$rs=$DBBR->con->get_results($sql_count);
	$cnt=$rs[0]->cnt;
	if ($cnt>0)	{
		$sql_row="SELECT `title`, `description` FROM `image_data` WHERE `image_url`='".$img."'";
		$result_row = $DBBR->con->get_row($sql_row);			
		echo $data_arr=$_REQUEST['index']."/".$result_row->title."/".$result_row->description;
	}
	else echo $data_arr=$_REQUEST['index']."/";

	
?>