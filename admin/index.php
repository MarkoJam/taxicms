<? 
	//ova stranica direktno poziva fset.tpl template

	$_ADMINPAGES = true;	
	include_once("../config.php");
	
	global $smarty;
	global $auth;
	$smarty->assign("ROOT_HOME",ROOT_HOME);
	$smarty->assign("ROOT_WEB",ROOT_WEB);
	
	
	$adminUserActions = $ObjectFactory->createObjects("AdminUserAction",array("Plugin"));	
	$plugins_array=array();		
	foreach ($adminUserActions as $adminUserAction)
	{
		if(!(strpos($adminUserAction->ActionCode,"_VIEW") === FALSE))
		{
			// Filter only VIEW actions
			if($adminUserAction->Plugin->Active == "true")
			{
				$plugins_array[]=$adminUserAction->Plugin->FileName;
				if($auth->isActionAllowed($adminUserAction->ActionCode)) $smarty->assign("plg_".$adminUserAction->Plugin->FileName,"true");
				if($adminUserAction->ActionCode == "ACTION_PRODUCT_GROUPPRODUCT_VIEWVIEW")
				{
					$showGrpProizNavigation = TRUE;
				}
			}
		}
	}
	// preuzimanje za meni
	$file = file("menu.txt");
	$admin_tree="";
	$ch=true;
	$enabled=true;
	$i=0;
	$sngl=false;
	foreach($file as $row)
	{ 
		if (strlen(rtrim($row))>0)
		{	
			$row=explode(" ",$row);
			if (in_array(rtrim($row[0]),$plugins_array)) $enabled=true;
			//else $enabled=false; //Selektovani svi pluginovi kada je zakomentarisano		
			if ($enabled)
			{			
				if (strlen(rtrim($file[$i-1]))==0 && strlen(rtrim($file[$i+1]))==0 && $i>0 ) $sngl=true;			
				$folder="plg_".rtrim($row[1]);
				$title=rtrim($row[2]);
				$icon="fa ".rtrim($row[3]);
				$class=$row[0];
				$param=rtrim($row[4]);
				if (strlen(rtrim($param))>0) 
				{	
					$arr=explode('=',$param);
					$plugin=$arr[0];
					$id="id='".$plugin."'";
				}	
				else $id="";
				// iskljuceno jer je activan dashboard
				//if (!isset($act)) $act="class='active'";
				//else $act="";
				$act="";
				
				$title_array=explode(",",$title);
				$title=getTranslation($title_array[0]);
				if ($title_array[1]) $title.="/".getTranslation($title_array[1]);
				if ($ch && !$sngl) 
				{
					$open=true;
					$admin_tree.=			
						"<li ".$act.">
						<a ".$id." data-folder='".$folder."' data-param='".$param."' data-class='".$class."' >
						<i class='".$icon."'></i> 
						<span class='nav-label'>".$title."</span> 
						<span class='fa arrow'></span>
						</a>
						<ul class='nav nav-second-level collapse'>";
				}		
				$admin_tree.=	
					"<li ".$act.">
					<a ".$id." data-folder='".$folder."' data-param='".$param."'>";
				if ($sngl) $admin_tree.="<i class='".$icon."'></i>";
				$admin_tree.=		
					"<span class='nav-label'>".$title."</span></a>
					</li>";
				$ch=false;
			}
		}
		else
		{
			$ch=true;	
			if ($open) $admin_tree.="</ul>";
			if ($open) $admin_tree.="</li>";
			$open=false;			
			$sngl=false;
		}	
		$i++;
	}	
	$smarty->assign("admin_tree",$admin_tree);

	
	$lh = LanguageHelper::getInstance();
	$tr = new TreeMenu();
	
	if($showGrpProizNavigation)
	{
		$grupeProizvoda = $ObjectFactory->createObjects("PrGrupaProizvoda",array(),"grupaproizvodaid, parentid, naziv");
		$grpArray = array();
		foreach($grupeProizvoda as $grupaProizvoda)
			$grpArray[] = $grupaProizvoda->toArrayHierarchy();		
		$tree = new MemTree(); 
		$tree->FillItems($grpArray);
		$grpProizvodTree = $tree->DrawTree("navigation");
		
		$smarty->assign("grpNavigation", $grpProizvodTree);
		$smarty->assign("showGrpNavigation", "true");
	}
	$lh = LanguageHelper::getInstance();
	$tree = new Tree();
	// new navigation
	$smarty->assign("horizontalNavigation",$tree->get_adminmenu_list(-1,0,"horizontal"));
	$smarty->assign("verticalNavigation"  ,$tree->get_adminmenu_list(-1,0,"vertical"));
	
	if($auth->isActionAllowed("ACTION_VIEW"))
	{
		$smarty->assign("plg_page","true");
	}
	foreach ($MessageArray['value'] as $key => $msg)
	{
		$msg_id[]=$key;
		$msg_txt[]=$msg;
	}
	$smarty->assign("msg_id",$msg_id);
	$smarty->assign("msg_txt",$msg_txt);
	
	$smarty->display('index.tpl');
?>