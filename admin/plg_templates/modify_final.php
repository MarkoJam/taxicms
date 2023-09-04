<?
	/* CMS Studio 3.0 modify_tmpl_final.php */

	$_ADMINPAGES = true;
	include_once("../../config.php");

	global $smary;
	global $auth;

	if($auth->isActionAllowed("ACTION_TEMPLATE_MODIFY"))
	{
		//insertovanje praznog sloga, umesto insert_pre.php
		if ($_REQUEST['mode']=='insert') 
		{
			require ("insert_pre.php");
			$obj = $ObjectFactory->createObject("Template");
			$colid=$DBBR->vratiPoslednjiID($obj);
			$col=$colid[0];
			$id=$colid[1];
			$_REQUEST[$col]=$_POST[$col]=$id;
		}
		if(isset($_REQUEST['template_id']))
		{
			$tmpl = $ObjectFactory->createObject("Template",$_REQUEST['template_id']);
			$tmpl->Template_POST($_REQUEST);
			$DBBR->promeniSlog($tmpl);
			echo "<div class='success'>".getTranslation("PLG_CHANGE_SUCCESS")."</div>";
		}
		else 
		{
			echo "<div class='error'>".getTranslation("PLG_CHANGE_FAILED")."</div>";
		}	
	}
?>