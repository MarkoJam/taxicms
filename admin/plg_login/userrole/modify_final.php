<?
	/* CMS Studio 3.0 modify_final.php */
	
	$_ADMINPAGES = true;
	include_once("../../../config.php");
	
	global $smarty;
	global $auth;
	
	if($auth->isActionAllowed("ACTION_LOGIN_MODIFY"))
	{
		//insertovanje praznog sloga, umesto insert_pre.php
		if ($_REQUEST['mode']=='insert') 
		{
			require ("insert_pre.php");
			$obj = $ObjectFactory->createObject("UserRole");
			$colid=$DBBR->vratiPoslednjiID($obj);
			$col=$colid[0];
			$id=$colid[1];
			$_REQUEST[$col]=$_POST[$col]=$id;
		}		
		if(isset($_REQUEST["userroleid"]))
		{
			$userrole = $ObjectFactory->createObject("UserRole",-1);
			$userrole->UserRole_POST($_POST);
			$DBBR->promeniSlog($userrole);
			
			echo "<div class='success'>".getTranslation("PLG_CHANGE_SUCCESS")."</div>";
		}
		else 
		{
			echo "<div class='error'>".getTranslation("PLG_CHANGE_FAILED")."</div>";
		}
	}
	else 
	{
		echo "<div class='warning'>".getTranslation("PLG_NORIGHT")."</div>";
	}
?>