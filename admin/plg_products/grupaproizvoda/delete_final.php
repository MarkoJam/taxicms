<?
	/* CMS Studio 3.0 delete_final.php */
	
	$_ADMINPAGES = true;
	include_once("../../../config.php");
	include_once("../../../common/managers/ProductManager.php");
	
	global $smarty;
	global $auth;
	
	$productManager = new ProductManager();
	
	if($auth->isActionAllowed("ACTION_PRODUCT_GROUPPRODUCT_DELETE"))
	{
		if(isset($_REQUEST["grupaproizvodaid"]) && !isset($_REQUEST["proizvodid"]))
		{
			$cf = new CommonFilter();
			$cf->Reset();
			
			$grupaProizvodaID = $_REQUEST["grupaproizvodaid"];
			$grupeproizvoda = $ObjectFactory->createObjects("PrGrupaProizvoda");
			
			$parentItemId = -1;
			// Assign Parent groups to smarty
			if(count($grupeproizvoda) > 0)
			{
				$grpArray = array();
				foreach($grupeproizvoda as $grupaProizvoda)
					 $grpArray[] = $grupaProizvoda->toArrayHierarchy();
				
				$tree = new MemTree(); 
				$tree->FillItems($grpArray);
				
				$parentItemId = $tree->FindItemById($grupaProizvodaID)->getParentID();
			}
			
			$childItemsIds = $tree->GetAllTreeItemIds($grupaProizvodaID);
			
			$cf->Reset();
			$cf->AddFilter("grupaproizvodaid", $childItemsIds , "IN" );
			$productManager->DeletePrGrupaProizvoda($cf);
			
			echo "<div class='success'>".getTranslation("PLG_DELETE_SUCCESS")."</div>";
		}
		else echo "<div class='error'>".getTranslation("PLG_CHANGE_FAILED")."</div>";
	}
	else echo "<div class='warning'>". getTranslation("PLG_NORIGHT")."</div>";
?>