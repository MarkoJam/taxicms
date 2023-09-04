<?php
header('Content-Type: application/javascript');
	$_ADMINPAGES = true;
	include_once("../../../../../config.php");

	global $smarty;
	global $auth;
	echo "var TTSelectBox = new Array(";
	$LanguageHelper = LanguageHelper::getInstance();
	$ObjectFactory = ObjectFactory::getInstance();
	ob_start();
	$ObjectFactory->ResetFilters();
	$tips = $ObjectFactory->createObjects("Lexicon");
	$ObjectFactory->ResetFilters();
	if (countObject($tips)>0) {
		foreach ($tips as $tip) {
			echo "new Array( '".$tip->getHeader()."', '".$tip->getLexiconID()."'),\n";
		}
	}
	$output = ob_get_contents();
	ob_end_clean();

	$output = substr($output, 0, strlen($output)-2);

	echo $output;
	echo ");";
?>
