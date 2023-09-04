<?
	/* CMS Studio 3.0 add_usersubsite.php */

	$_ADMINPAGES = true;
	include_once("../../../config.php");
	
	global $smarty;
	global $auth;

	$expirydate= $_REQUEST["expirydate"];
	
	$expirydate_arr = explode("/",$expirydate);
	
	$expirytime = time(); 
	
	if(count($expirydate_arr) == 3)
	{
		$expirytime = mktime(0,0,0,$expirydate_arr[0],$expirydate_arr[1],$expirydate_arr[2]);
	}
	
	$usersubsite = $ObjectFactory->crateObject("UserSubSite",-1);

	$usersubsite->UserID = $_REQUEST["userid"];
	$usersubsite->SubSiteID = $_REQUEST["subsiteid_add"];
	$usersubsite->Status = $_REQUEST["status"];
	$usersubsite->ExpiryDate= $expirytime;
	
	@$DBBR->kreirajSlog($usersubsite);
	
	header("Location: modify.php?userid=".$_REQUEST["userid"]);
	
?>