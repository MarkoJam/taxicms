<?
	include_once("../../config.php");
	
	unset($_SESSION["logeduserid"]);
	unset($_SESSION["loged"]);
	unset($_SESSION["subsiteid"]);
	
	unset($_SESSION[$lang]["korpa"]);
	unset($_SESSION["kol"]);
	unset($_SESSION["basket_order_type"]);
	$_SESSION[$lang]["korpa"] = array();

	$backUrl = "";
	
	if(isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] != ""){
	  	$backUrl = "?".$_SERVER['QUERY_STRING'];
	}
	$login_link=ROOT_WEB . $lh->GetLinkPluginType("language")."/login";
	
	header("Location: ". $login_link);


?>