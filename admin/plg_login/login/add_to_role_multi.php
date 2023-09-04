<?
	/* CMS Studio 3.0 modify_final.php */
	
	$_ADMINPAGES = true;
	include_once("../../../config.php");
	
	global $smarty;
	global $auth;
	
	if($auth->isActionAllowed("ACTIONADDTOROLE"))
	{
		$userRoleId = $_REQUEST["userroleid"];
		$userIds = $_REQUEST["userid"];
		$added = 0;

		// zapamti selektovanu user rolu za kasnije		
		if(!isset($_SESSION["sel_userroleid"]))
		{
			$_SESSION["sel_userroleid"] = -1;
		}
			
		$_SESSION["sel_userroleid"] = $_REQUEST["userroleid"];
		
		foreach($userIds as $userId)
		{
			$useruserrole = $ObjectFactory->createObject("UserUserRole",-1);
			$useruserrole->UserID = $userId;
			$useruserrole->UserRoleID = $userRoleId;
			
			$DBBR->nadjiSlogVratiGa($useruserrole);
			if( $DBBR->con->num_rows == 0 ) 
			{
				$useruserrole->UserID = $userId;
				$useruserrole->UserRoleID = $userRoleId;
				
				$DBBR->kreirajSlog($useruserrole);
				
				$added++;
			} 
		}
		if($added == 0) echo "<div class='error'>".getTranslation("PLG_SELECTION_ROLE_ADD_FAILED")."</div>";
		else echo "<div class='success'>".getTranslation("PLG_SELECTION_ROLE_ADD")."</div>";

	}
	else echo "<div class='warning'>". getTranslation("PLG_NORIGHT")."</div>";
?>