<?
	/* CMS Studio 3.0 modify_final.php */
	
	$_ADMINPAGES = true;
	include_once("../../../config.php");
	
	global $smarty;
	global $auth;

	$ObjectFactory = ObjectFactory::getInstance();
	if($_REQUEST["executed"]==1) echo "<div class='success'>".getTranslation("PLG_CHANGE_SUCCESS")."</div>";
	else echo "<div class='error'>".getTranslation("PLG_CHANGE_FAILED")."</div>";
	
?>