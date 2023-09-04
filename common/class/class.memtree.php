<?php

/// napraviti refaktor : bazna klasa je MemTree i Item  a izvedene klase ih nasledjuju i 
/// implementiraju svoje specificne metode za crtanje i custom propertije


class MemTree 
{
	// used as flat structure
	private $ItemsList;

	// used for tree
	private $Items;
	
	private function GetFirstLevelItems()
	{
		$firstLevelItems = array();
		foreach($this->ItemsList as $item)
		{
			if($item->getParentID() == "")
			{
				$firstLevelItems[] = $item;
			}
		}
		
		return $firstLevelItems;
	}
	
	private function PopulateTree()
	{
		$firstLevelItems = $this->GetFirstLevelItems();
		
		foreach($firstLevelItems as $fli)
		{
			$this->Items[] = $fli;
			$fli->setLevel(0);
			$this->AddChildren($fli);
		}
	}
	
	public function DrawTree($treeid = "navigation")
	{
		
		$output = "<ul id='".$treeid."'>\n";		
		foreach($this->Items as $item)
		{
			$param=str_replace('?','',$item->getLink());
			$output .= "<li>\n<a class='menutxt' target='frmContent' data-link='plg_products/grupaproizvoda/index.php' data-param='".$param."'>";
			$output .= $item->getTitle();
			$output .= "</a>";
			$output .= $this->DrawTreeItems($item);
			$output .= "</li>\n";
		}
		$output .= "</ul>\n";

		return $output;
	}
	
	private function DrawTreeItems($item)
	{
		if(count($item->getChildren()) == 0) return;
		
		$output = "<ul>";
		foreach($item->getChildren() as $it)
		{
			$param=str_replace('?','',$it->getLink());
			$output .= "<li>\n<a class='menutxt' target='frmContent' data-link='plg_products/grupaproizvoda/index.php' data-param='".$param."'>";
			$output .= $it->getTitle();
			$output .= "</a>";
			$output .= $this->DrawTreeItems($it);
			$output .= "</li>\n";
		}
		$output .="</ul>";
		return $output;
	}
	
	public function DrawPath($itemId, $selectedItemID)
	{
		$currentItem = $this->FindItemById($itemId);
		
		if($this->HasTreeItemParent($itemId))
		{
			$output = $this->DrawPath($currentItem->getParentID(), $selectedItemID) . " <img src='".ROOT_WEB."images/arrow_path.gif' border='0'> ";
			if($itemId == $selectedItemID)
			{
				$output .= $currentItem->getTitle();
			}
			else
			{
				$output .= "<a href='".$currentItem->getLink()."'>". $currentItem->getTitle() . "</a>";
			}
			
			return $output;
		}
		else 
		{
			return $currentItem->getTitle();
		}
	}
	
	public function GetParentsById($itemId, $parents)
	{
		$currentItem = $this->FindItemById($itemId);
		
		$parentItem = $this->FindItemById($currentItem->getParentID());
		
		$parents[] = $currentItem;

		if($parentItem == null) return;
		
		$this->GetParentsById($parentItem->getID(), $parents);
	}
	
	public function GetItemByParentID($parentId)
	{
		foreach($this->ItemsList as $item)
		{
			if($item->getParentID() == $parentId)
			{
				return $item;
			}
		}
		
		return null;
	}
	
	public function DrawCombobox($comboName = "cmbName", $selectedID = -1, $addDefault = true)
	{
		$output = "<select id='".$comboName."' name='".$comboName."' class='form-control'>\n";		
		if($addDefault)
		{
			$output .= "<option value='-1'> Bez nadredjene grupe </option>";
		}
		
		if(!empty($this->Items))
		{
			foreach($this->Items as $item)
			{
				$selected = "";
				if($item->getID() == $selectedID) $selected = "selected";
				$output .= "<option $selected value='".$item->getID()."'>".$item->getTitle()."</option>";
				$output .= $this->DrawComboboxItems($item, $selectedID);
			}
		}
		$output .= "</select>\n";

		return $output;
	}
	
	private function DrawComboboxItems($item, $selectedID = -1)
	{
		if(count($item->getChildren()) == 0) return;
		
		$minus = str_repeat("-",$item->getLevel()+1);
		$output = "";
		foreach($item->getChildren() as $it)
		{
			$selected = "";
			if($it->getID() == $selectedID) $selected = "selected";
			$output .= "<option $selected value='".$it->getID()."'>".$minus." ".$it->getTitle()."</option>";
			$output .= $this->DrawComboboxItems($it, $selectedID);
		}
		return $output;
	}
	
	private function AddChildren($parentItem)
	{
		$childItems = $this->FindItemsByParentID($parentItem->getID());
		if(count($childItems) == 0) return;
		foreach($childItems as $item)
		{
			$item->setLevel($parentItem->getLevel()+1);
			$parentItem->AddChild($item);
			$this->AddChildren($item);
		}
	}

	public function GetSumCount($itemId)
	{
		$currentItem = $this->FindItemById($itemId);
		
		$sum = $currentItem->getCount();
		
		if($this->HasTreeItemChildren($itemId))
		{
			foreach($currentItem->getChildren() as $child)
			{
				$sum += $this->GetSumCount($child->getID()); 
			}
		}
		
		return $sum;
	}
	
	public function HasTreeItemChildren($itemId)
	{
		if(count($this->FindItemsByParentID($itemId)) == 0 ) return false;
		
		return true;
	} 
	
	public function HasTreeItemParent($itemId)
	{
		if($this->FindItemById($itemId)->getParentID() != "") return true;
		
		return false;
	}
	
	public function FindItemById($itemId)
	{
		foreach($this->ItemsList as $item)
		{
			if($item->getID() == $itemId)
			{
				return $item;
			}
		}
		
		return null;
	}
	
	public function FindItemsByParentID($parentid)
	{
		$foundItems = array();
		foreach($this->ItemsList as $item)
		{
			if($item->getParentID() == $parentid)
			{
				$foundItems[] = $item;
			}
		}

		return $foundItems;
	}
	
	public function FillItems($itemArray)
	{
		$this->ItemsList = array();
		if(count($itemArray) > 0)
		{
			foreach ($itemArray as $ia)
			{
				$memTreeItem = new MemTreeItem();
				$memTreeItem->setItem($ia["id"], $ia["parentid"],$ia["title"], $ia["link"], $ia["image"],$ia["count"],0,$ia["templateid"]);
				$this->ItemsList[] = $memTreeItem;
			}
		}
		
		$this->PopulateTree();
	}
	
	public function GetAllTreeItemIds($itemId)
	{
		$output = $this->GetAllTreeItemIdsInternal($itemId);
		$output = substr($output,0,strlen($output)-1);
		
		return $output;
	}
	
	private function GetAllTreeItemIdsInternal($itemId)
	{
		$currentItem = $this->FindItemById($itemId);
		
		if($this->HasTreeItemChildren($itemId))
		{
			$output = $currentItem->getID() . ",";
			foreach($currentItem->getChildren() as $child)
			{
				$output .= $this->GetAllTreeItemIdsInternal($child->getID());
			}
			
			return $output;
		}
		else 
		{
			return $currentItem->getID().",";
		}
	}
	
	public function GetItems()
	{
		return $this->ItemsList;		
	}
	
	public function DumpItems()
	{
		foreach($this->Items as $item)
		{
			print_r($item);
		}
	}
}
/*
class MemTreePrGrupaProizvodaItem()
{
	
}
*/

class MemTreeItem
{
	private $id;
	private $parentid;
	private $title;
	private $level;
	private $children;
	private $count;
	private $status;

	private $link;
	private $image; 
	private $templateid;
	
	
	function __construct()
	{
		$this->id = -1;
		$this->parentid = -1;
		$this->level = 0;
		$this->title = "";
		$this->link = "";
		$this->image= "";
		$this->count = 0;
		$this->status = 0;		
		$this->children = array();
		$this->templateid = -1;
	}

	function setItem($id, $parentid, $title, $link,$image, $count=0,$level=0,$templateid=-1)
	{
		$this->id = $id;
		$this->parentid = $parentid;
		$this->title = $title;
		$this->link = $link;
		$this->image= $image;
		$this->count = $count;
		$this->status = $status;
		$this->level = $level;
		$this->templateid = $templateid;
	}
	
	function AddChild($memTreeItem)
	{
		$this->children[] = $memTreeItem;
	}
	
	function GetChildren()
	{
		return $this->children;		
	}
	
	function getID()
	{
		return $this->id;
	}
	
	function getParentID()
	{
		return $this->parentid;
	}
	
	function getTitle()
	{
		return $this->title;		
	}
	
	function setTitle($val)
	{
		$this->title = $val;
	}
	
	function getLink()
	{
		return $this->link;
	}
	
	function getImage()
	{
		return $this->image;
	}
	
	function setLink($val)
	{
		$this->link = $val;
	}
	
	function setImage($val)
	{
		$this->image = $val;
	}
	
	function getCount()
	{
		return $this->count;
	}
	
	function setCount($val)
	{
		$this->count = $val;
	}

	function getStatus()
	{
		return $this->status;
	}
	
	function setStatus($val)
	{
		$this->status = $val;
	}
	
	function getLevel()
	{
		return $this->level;
	}
	
	function setLevel($val)
	{
		$this->level = $val;
	}
	
	function getTemplateId()
	{
		return $this->templateid;
	}
	
	function setTemplateId($val)
	{
		$this->templateid = $val;
	}
	
}
/*
$testArray = array(
				array("id" => 10, "parentid" => "", "title" => "Akcija"),
				array("id" => 1, "parentid" => "", "title" => "Katalog"),
				array("id" => 2, "parentid" => 1, "title" => "Grupa proizvoda 1") ,
				array("id" => 5, "parentid" => 1, "title" => "Grupa proizvoda 0") ,
				array("id" => 4, "parentid" => 2, "title" => "Grupa proizvoda 1a") ,
				array("id" => 3, "parentid" => 2, "title" => "Grupa proizvoda 2")
			);

	$tree = new MemTree(); 
	$tree->FillItems($testArray);
	echo $tree->DrawPath();
*/

?>