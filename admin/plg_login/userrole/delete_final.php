<?
	/* CMS Studio 3.0 modify_final.php */
		
	$_ADMINPAGES = true;
	include_once("../../../config.php");

	global $smarty;
	global $auth;
	
	if($auth->isActionAllowed("ACTION_LOGIN_DELETE"))
	{
		if(isset($_REQUEST["userroleid"]))
		{
			//brisanje role
			if(!isset($_REQUEST["userid"]))
			{
				$userrole = $ObjectFactory->createObject("UserRole",$_REQUEST["userroleid"]);
				
				//brisanje svih veza sa ovom rolom
				$useruserrole = $ObjectFactory->createObject("UserUserRole");
				$DBBR->obrisiSlogove($useruserrole,"userroleid=".$_REQUEST["userroleid"]);
						
				// brisanje role
				$DBBR->obrisiSlog($userrole);
						
				echo "<div class='success'>".getTranslation("PLG_DELETE_SUCCESS")."</div>";
			}
			
			//izbacivanje usera iz role
			if(isset($_REQUEST["userid"]))
			{
				$useruserrole = $ObjectFactory->createObject("UserUserRole",-1);
				$useruserrole->UserID = $_REQUEST["userid"];
				$useruserrole->UserRoleID = $_REQUEST["userroleid"];
				$DBBR->obrisiSlog($useruserrole);
				
				//update stranica prilikom  brisanja odredjene role
				$page_table = "page";
				$lh->ChangeTableName($page_table);
				$DBBR->con->query("UPDATE ".$page_table." SET userroleid = 1 WHERE userroleid =".$_REQUEST["userroleid"]);
				echo "<div class='success'>".getTranslation("PLG_DELETE_SUCCESS")."</div>";
			}
		}
		else
		{
			echo "<div class='error'>".getTranslation("PLG_CHANGE_FAILED")."</div>";
		}
	}
	else 
	{
		echo "<div class='warning'>". getTranslation("PLG_NORIGHT")."</div>";
	}
?>