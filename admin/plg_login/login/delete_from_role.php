<?
	/* CMS Studio 3.0 modify_final.php */
	
	$_ADMINPAGES = true;
	include_once("../../../config.php");
	
	global $smarty;
	global $auth;
	

	$useruserrole = $ObjectFactory->createObject("UserUserRole",-1);
	$useruserrole->UserID = $_REQUEST["userid"];
	$useruserrole->UserRoleID = $_REQUEST["userroleid"];

	// zapamti selektovanu user rolu za kasnije		
	if(!isset($_SESSION["sel_userroleid"]))
	{
		$_SESSION["sel_userroleid"] = -1;
	}
	
	$_SESSION["sel_userroleid"] = $_REQUEST["userroleid"];
	
	$DBBR->nadjiSlogVratiGa($useruserrole);
	if( $DBBR->con->num_rows == 1 ) 
	{
		$useruserrole->UserID = $_REQUEST["userid"];
		$useruserrole->UserRoleID = $_REQUEST["userroleid"];
		
		$DBBR->obrisiSlog($useruserrole);
		echo "<div class='success'>".getTranslation("PLG_SELECTION_ROLE_DELETE")."</div>";
	} 
	else echo  "<div class='error'>".getTranslation("PLG_SELECTION_ROLE_DELETE_FAILED")."</div>";
	
	
?>