<?
	/* CMS Studio 3.0 index.php */	
	
	$_ADMINPAGES = true;
	include_once("../../../config.php");
		
	global $smarty;
	global $auth;
	
	if(isset($_REQUEST["adminuserid"]) && isset($_REQUEST["password_new"]) && $_REQUEST["password_new"] != "")
	{
		$adminUser = $ObjectFactory->createObject("AdminUser",$_REQUEST["adminuserid"]);
		$adminUser->Password = md5($_REQUEST["password_new"]);
		
		$DBBR->promeniSlog($adminUser);
		
		echo "<div class='success'>".getTranslation("PLG_PASSWORD_CHANGE_SUCCESS")."</div>";
	}
	else echo "<div class='error'>".getTranslation("PLG_PASSWORD_CHANGE_FAILED")."</div>";
	
	
?>