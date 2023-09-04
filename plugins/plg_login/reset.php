<?

//	include_once("plugins/pagePlugin.php");

	include_once('../../config.php');
			

	
	if(isset($_GET['encrypt']))
	{
        $encrypt = $_GET['encrypt'];
		
		$upit = "SELECT userid FROM user where md5(90*13+userid)='".$encrypt."'";
		$result_row = $DBBR->con->get_row($upit);
		
		if($DBBR->con->num_rows == 1)
		{
			$userID = $result_row->userid;
			//$_SESSION["loged"] = "Yes";
			$_SESSION["logeduserid"] = $userID;
			
			// Ovde idu novi kod za update last_log_date last_log_ip adresa
			$upit_log_info = "UPDATE user SET last_log_date= ".time().", last_log_ip = '".getenv("REMOTE_ADDR")."' WHERE userid = ".$userID;
			$result_row = $DBBR->con->get_row($upit_log_info);
			
			UpdateUserLogHistory($userID);
			$loginSuccess = true;
		}	

        else
        {
			$message = "Account not found !!";
			$backUrl = $_REQUEST["backUrl"];	
        }        
    }
	$registrationLink= new LinkRegistration($lh,0, TEMPLATE_REGISTRATION, 3 );
		$forgot_pass_link = $lh->GetPrintLink($registrationLink);	
	header('Location: '.$forgot_pass_link);

	
	function UpdateUserLogHistory($userID)
	{
		global $DBBR;
		global $ObjectFactory;
		
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
