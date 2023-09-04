<?php
header('Content-Type: application/javascript');
	$_ADMINPAGES = true;
	include_once("../../../../../config.php");

	global $smarty;
	global $auth;
	echo "var InternPagesSelectBox = new Array(";
	$LanguageHelper = LanguageHelper::getInstance();
	$ObjectFactory = ObjectFactory::getInstance();
	ob_start();
	$hierarchicalTree = new Tree();
	$hierarchicalTree->display_menu_ckeditor(0,0);
	$output = ob_get_contents();
	ob_end_clean();

	$output = substr($output, 0, strlen($output)-2);

	echo $output;
	echo ");";
?>
