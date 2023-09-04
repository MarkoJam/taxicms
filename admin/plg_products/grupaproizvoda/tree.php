<? 

	$_ADMINPAGES = true;
	include_once("../config.php");
		
	global $smarty;
	global $auth;
	
	$lh = LanguageHelper::getInstance();
	$tr = new TreeMenu();
	$grupeProizvoda = $ObjectFactory->createObjects("PrGrupaProizvoda",array(),"grupaproizvodaid, parentid, naziv");
	$grpArray = array();
	foreach($grupeProizvoda as $grupaProizvoda)
		$grpArray[] = $grupaProizvoda->toArrayHierarchy();		
	$tree = new MemTree(); 
	$tree->FillItems($grpArray);
	echo $tree->DrawTree("navigation");
?>