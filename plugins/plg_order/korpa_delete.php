<?
	/* CMS Studio 2.0 korpa_edit.php */
	include_once("../../config.php");
	$LanguageHelper = LanguageHelper::getInstance();
	$lang = $LanguageHelper->GetLinkPluginType("language");

	if (isset($_REQUEST["proizvodid"]))
	{
		$pr=$_REQUEST["proizvodid"];
		$_SESSION[$lang]["korpa"][$pr]=0;
		unset($_SESSION[$lang]["korpa"][$pr]);
	}
	// za klasican refresh
	if ($_REQUEST["back"]="yes") header('Location: ' . $_SERVER['HTTP_REFERER']);

	

	//exit ();
	
?>