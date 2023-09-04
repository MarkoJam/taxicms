<?
	/* CMS Studio 3.0 modify_final.php */
	
	$_ADMINPAGES = true;
	include_once("../../../config.php");

	global $smarty;
	global $auth;

	if($auth->isActionAllowed("ACTION_ADMINISTRATOR_MODIFY"))
	{
		//insertovanje praznog sloga, umesto insert_pre.php
		if ($_REQUEST['mode']=='insert') 
		{
			require ("insert_pre.php");
			$obj = $ObjectFactory->createObject("AdminUser");
			$colid=$DBBR->vratiPoslednjiID($obj);
			$col=$colid[0];
			$id=$colid[1];
			$_REQUEST[$col]=$_POST[$col]=$id;
			$_REQUEST["adminuserid"]=$_REQUEST[$col];//ujednacavanje parametra i naziva polja
			
		}		
		if(isset($_REQUEST["adminuserid"]))
		{
			
			$tmpuser = $ObjectFactory->createObject("AdminUser",$_REQUEST["adminuserid"]);
			$admin = $ObjectFactory->createObject("AdminUser",-1);
			$admin->AdminUser_POST($_REQUEST);
			//$admin->ExpiryDate = mktime (0,0,0,$_POST["month"],$_POST["day"],$_POST["year"]);
			$admin->Password = $tmpuser->Password;
			if(isset($_REQUEST["password_new"])) $admin->Password = md5($_REQUEST["password_new"]);
			$DBBR->promeniSlog($admin);
			
			echo "<div class='success'>".getTranslation("PLG_CHANGE_SUCCESS")."</div>";
		}
		else echo "<div class='error'>".getTranslation("PLG_CHANGE_FAILED")."</div>";
	}
	else echo "<div class='warning'>".getTranslation("PLG_NORIGHT")."</div>";
	
?>