<?
	/* CMS Studio 3.0 index.php */	
	
	$_ADMINPAGES = true;
	include_once("../../../config.php");
		
	global $smarty;
	global $auth;
	
	if(isset($_REQUEST["userid"]) && isset($_REQUEST["password_new"]) && $_REQUEST["password_new"] != "")
	{
		$user = $ObjectFactory->createObject("User",$_REQUEST["userid"]);
		
		$user->Password = md5($_REQUEST["password_new"]);
		
		$DBBR->promeniSlog($user);
		echo "<div class='success'>".getTranslation("PLG_CHANGEPASS_SUCCESS")."</div>";
	}
	else echo "<div class='error'>".getTranslation("PLG_CHANGEPASS_FAILED")."</div>";	
?>