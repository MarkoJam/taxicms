<? 
	$_ADMINPAGES = true;
	include_once("../config.php");
		
	global $smarty;
	global $auth;

	$lh = LanguageHelper::getInstance();
	$tree = new Tree();
	echo  "<ul>".$tree->get_adminmenu_list(-1,0,"horizontal")."</ul>";
?>