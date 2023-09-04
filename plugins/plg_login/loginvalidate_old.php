<?
	include_once('../../config.php');
	
	// if the sessions are not set ... we set them :)
	if(!isset($_SESSION['loged'])) $_SESSION['loged'] = 'No';
	if(!isset($_SESSION['logeduserid'])) $_SESSION['logeduserid'] = '';
	$message = "";
	if(isset($_REQUEST["password"]) && isset($_REQUEST["username"]))
	{
		$username = quote_smart($_REQUEST["username"]);
		$password = md5($_REQUEST["password"]);
		
		$upit = "SELECT userid,name,surname FROM user WHERE username=$username AND password='$password' AND status_id= ".STATUS_USER_AKTIVAN." AND expirydate >= " . time();
		$result_row = $DBBR->con->get_row($upit);
		if($DBBR->con->num_rows == 1)
		{
			$userID = $result_row->userid;
			$_SESSION["loged"] = "Yes";
			$_SESSION["logeduserid"] = $userID;
			
			// Ovde idu novi kod za update last_log_date last_log_ip adresa
			$upit_log_info = "UPDATE user SET last_log_date= ".time().", last_log_ip = '".getenv("REMOTE_ADDR")."' WHERE userid = ".$userID;
			$result_row = $DBBR->con->get_row($upit_log_info);
			
			UpdateUserLogHistory($userID);
		}
		else
		{
			
			$upit = "SELECT userid FROM user WHERE username='$username' AND password='$password' AND status_id=".STATUS_USER_AKTIVAN;
			$result_row = $DBBR->con->get_row($upit);
				
			if($DBBR->con->num_rows != 0)
			{
				$upit1 = "UPDATE user SET status_id= ".STATUS_USER_NEAKTIVAN." WHERE userid = ".$result_row->userid;
				$result_row = $DBBR->con->get_row($upit1);
			}
			//header('Location: ../../index.php?adminpagename=forbidden&message=error');
			$login_link=ROOT_WEB . $lh->GetLinkPluginType("language")."/login";
			header("Location: ". $login_link);
			exit();
		}
	}
	else 
	{
		$message = "error";
		//header('Location: ../../index.php?adminpagename=forbidden&message=error');
		$login_link=ROOT_WEB . $lh->GetLinkPluginType("language")."/login";
		header("Location: ". $login_link);
		exit();
	}
	
	$backUrl = $_REQUEST["backurl"];
	$backUrl = "message=". $message."&".$backUrl;
	
	// standard message after login - the old way
	//header('Location: ../../index.php?adminpagename=log_success&'.$backUrl);
	
	// new info user page after login - the new way
	
	//link za edit !!!
	$registrationLink= new LinkRegistration($lh,0, TEMPLATE_REGISTRATION, 4 );
	$link = $lh->GetPrintLink($registrationLink);	
	header('Location: '.$link);
	
	//header('Location: ../../index.php?plugin=login&plugin_view=viewuserinfo&tid='.TEMPLATE_REGISTRATION.'&'.$backUrl);
	exit();

	
	function UpdateUserLogHistory($userID)
	{
		global $DBBR;
		global $ObjectFactory;
		
		//echo $query_logid_tokeep = "SELECT user_log_id FROM `user_log_history` WHERE user_id = ".$userID ." ORDER BY LAST_LOG_DATE DESC LIMIT 0,4";
		$result_rows = $DBBR->con->get_results($query_logid_tokeep);
		$log_id_tokeep = "";
		foreach ($result_rows as $row) 
		{
			$log_id_tokeep .= $row->user_log_id. ",";
		}
		$log_id_tokeep = substr($log_id_tokeep,0,strlen($log_id_tokeep)-1);
		
		// delete all but last 4 rows in log table
		$query_delete = "DELETE FROM user_log_history WHERE 1=1 AND user_log_id NOT IN (".$log_id_tokeep.")";
		$query_result = $DBBR->con->query($query_delete);
		
		// insert into log history table
		$user_log_history = $ObjectFactory->createObject("UserLogHistory",-1);
		$user_log_history->setUserID($userID);
		$user_log_history->setLastLogDate(time());
		$user_log_history->setLastLogIP(getenv("REMOTE_ADDR"));
		
		$DBBR->kreirajSlog($user_log_history);
	}
?>