<?
class KpGrupaProizvodaTree extends MemTree {
	private $_objectFactory;
	private $_databaseBroker;
	
	// heper za formiranje linkova
	private $_pageId;
	private $_templateId;
	private $_languageHelper;
	private $_debug = false;
	
	function __construct() 
	{
		if($this->_debug) $this->DebugWriteLine("Constructor");
				
		$this->_objectFactory = ObjectFactory::getInstance ();
		$this->_databaseBroker = DatabaseBroker::getInstance ();
		$this->FillGrupaProizvodaTree ();
	}
	
	public function GetRootGrupaProizvodaId($currentGrupaProizvodaId)
	{
		if($this->_debug) $this->DebugWriteLine("GetRootGrupaProizvodaId");
		
		$current = $this->FindItemById($currentGrupaProizvodaId);

		while($current != null && $current->getParentID() != "")
		{
			$current = $this->FindItemById($current->getParentID());
		}
		return $current;
	}
	
	/*
	 * Vraca menije kataloga
	 */
	public function GetMenuItemById($currentGrupaProizvodaId) 
	{
		if($this->_debug) $this->DebugWriteLine("GetMenuItemById");
		
		// prolazak kroz memorijsko stablo grupa i podrgrupa, izdvajanje samo prva 2 nivoa i 
		// smestanje u array za ispis
		// vadi trenutnu grupu proizvoda i setuje odgovarajuci templateid
		
		$currentGrupaProizvoda = $this->_objectFactory->createObject("PrGrupaProizvoda", $currentGrupaProizvodaId);		
		if($currentGrupaProizvoda->getTemplateID() != "") $this->_templateId = $currentGrupaProizvoda->getTemplateID(); 
		else $this->_templateId = "";
		
		$menuItem = $this->FindItemById ( $currentGrupaProizvodaId );

		$catalogItem = array ();
		
		$linkHelper = new LinkKpGrupaProizvoda ( $this->_languageHelper,$this, $this->_templateId, $menuItem->getId (), $menuItem->getTitle () );
		$catalogItem = array ("title" => $menuItem->getTitle (), "id" => $menuItem->getId (), "link" => $this->_languageHelper->GetPrintLink ( $linkHelper ), "image" => $menuItem->getImage (), "items" => $this->GetSubMenuItemsById ( $menuItem->getId () ) );
		return $catalogItem;
	}
	
	private function GetSubMenuItemsById($parentId) 
	{
		if($this->_debug) $this->DebugWriteLine("GetSubMenuItemsById");
		
		$subCatalogItems = array ();
		$menuItems = $this->FindItemsByParentID ( $parentId );
		//print_r ($menuItems);
		
		if (count ( $menuItems ) > 0) {
			foreach ( $menuItems as $menuItem ) {
				$linkHelper = new LinkKpGrupaProizvoda ( $this->_languageHelper,$this, $menuItem->getTemplateId(), $menuItem->getId (), $menuItem->getTitle () );
				$subCatalogItems [] = array ("title" => $menuItem->getTitle (), "totalcount" => $this->GetSumCount ( $menuItem->getId () ), "count" => $menuItem->getCount (), "id" => $menuItem->getId (), "link" => $this->_languageHelper->GetPrintLink ( $linkHelper ), "image" => $menuItem->getImage (), "items" => $this->GetSubMenuItemsById ( $menuItem->getId () ) );
			}
		}
		
		return $subCatalogItems;
	}
	
	public function GetParentMenuItemById($currentGrupaProizvodaId, $menuItems = array()) 
	{
		if($this->_debug) $this->DebugWriteLine("GetParentMenuItemById");
		if ($currentGrupaProizvodaId == "") return $menuItems;
		
		$currentGrupa = $this->FindItemById ( $currentGrupaProizvodaId );
		$linkHelper = new LinkKpGrupaProizvoda ( $this->_languageHelper,$this, $currentGrupa->getTemplateId(), $currentGrupa->getId (), $currentGrupa->getTitle () );
		$menuItems [] = array ("title" => $currentGrupa->getTitle (), "id" => $currentGrupa->getId (), "link" => $this->_languageHelper->GetPrintLink ( $linkHelper ), "image" => $currentGrupa->getImage (), "level" => $currentGrupa->getLevel () );
		return $this->GetParentMenuItemById ( $currentGrupa->getParentId (), $menuItems );
	}
	
	function GetPath($grupaProizvodaId)
	{
		$parentMenuItem = $this->GetParentMenuItemById($grupaProizvodaId);
		
		return array_reverse($parentMenuItem);
	}
	
	public function setPageId($pageid) {
		$this->_pageId = $pageid;
	}
	public function setLanguageHelper($languageHelper) {
		$this->_languageHelper = $languageHelper;
	}
	
	private function FillGrupaProizvodaTree() {
		$grupeproizvoda = $this->_objectFactory->createObjects ( "PrGrupaProizvoda");
		//echo time()+microtime()."<br>";
		if (count ( $grupeproizvoda ) > 0) {
			$grpArray = array ();
			foreach ( $grupeproizvoda as $grupaProizvoda ) 
			{
				if ($grupaProizvoda->getStatusID()==STATUS_PRODUCTGROUP_GLAVNA OR
					$grupaProizvoda->getStatusID()==STATUS_PRODUCTGROUP_SPOREDNA) 
				{	
					$grpArray [] = $grupaProizvoda->toArrayHierarchy ();
				}			
			}
			$this->FillItems ( $grpArray );
		}
		//echo time()+microtime()."<br>";
	}
	
	private function DebugWriteLine($message)
	{
		echo $message . "<br/>";
	}
}

?>