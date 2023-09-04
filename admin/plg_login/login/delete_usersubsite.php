<?
	/* CMS Studio 3.0 delete_usersubsite.php */

	$_ADMINPAGES = true;
	include_once("../../../config.php");
	
	global $smarty;
	global $auth;

	$usersubsite = $ObjectFactory->createObject("UserSubSite",-1);
	
	$usersubsite->UserID = $_REQUEST["userid"];
	$usersubsite->SubSiteID = $_REQUEST["subsiteid"];
	
	@$DBBR->obrisiSlog($usersubsite);
	
	header("Location: modify.php?userid=".$_REQUEST["userid"]);
	
?>