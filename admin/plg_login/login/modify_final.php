<?
	/* CMS Studio 3.0 modify_final.php *///
	
	$_ADMINPAGES = true;
	include_once("../../../config.php");

	global $smarty;
	global $auth;
	global $LanguageArray;

	if($auth->isActionAllowed("ACTION_LOGIN_MODIFY"))
	{
		//insertovanje praznog sloga, umesto insert_pre.php
		if ($_REQUEST['mode']=='insert') 
		{
			require ("insert_pre.php");
			$obj = $ObjectFactory->createObject("User");
			$colid=$DBBR->vratiPoslednjiID($obj);
			$col=$colid[0];
			$id=$colid[1];
			$_REQUEST[$col]=$_POST[$col]=$id;
		}		
		if(isset($_REQUEST["userid"]))
		{
			$tmpuser = $ObjectFactory->createObject("User",$_REQUEST["userid"]);
			
			$user = $ObjectFactory->createObject("User",-1);
			$user->User_POST($_POST);
			$user->Password = $tmpuser->Password;
			$user->setLastLogDate($tmpuser->getLastLogDate());
			$user->setLastLogIP($tmpuser->getLastLogIP());
			$datum=explode('.',$_REQUEST['datum']);
			if (count($datum)==3) $user->setExpiryDate(mktime (0,0,0,$datum[1],$datum[0],$datum[2]));

			
			$DBBR->promeniSlog($user);
			
			echo "<div class='success'>".getTranslation("PLG_CHANGE_SUCCESS")."</div>";
		}
		else echo "<div class='error'>".getTranslation("PLG_CHANGE_FAILED")."</div>";	
	}
	else echo "<div class='warning'>".getTranslation("PLG_NORIGHT")."</div>";
	
?>