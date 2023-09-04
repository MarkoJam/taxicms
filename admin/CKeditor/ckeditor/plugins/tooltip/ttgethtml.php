<?php 

	$_ADMINPAGES = true;
	include_once("../../../../../config.php");
	
	global $smarty;
	global $auth;
	
	if (isset($_POST['id'])) {
		$id=$_POST['id'];
		$LanguageHelper = LanguageHelper::getInstance();	
		$ObjectFactory = ObjectFactory::getInstance();
		$tip = $ObjectFactory->createObject("Lexicon",$id);
		//echo htmldecode($tip->getHtml());
		echo strip_tags(htmldecode($tip->getHtml()));
	}
?>