<?

class Setting extends OpstiDomenskiObjekat
{
	private $SettingID;
	private $Name;
	private $Description;
	private $Value;
	private $Order;
	private $PluginModule;
	public $SfSettingCover;
	public $SfSettingGroup;
	public $SfSettingType;
	
	//Bussiness PHP Object constructor	 
	function __construct()
	{
		parent::__construct();
		
		$this->SfPluginModule = $this->ObjectFactory->createObject("SfPluginModule",-1); 
		$this->SfSettingCover = $this->ObjectFactory->createObject("SfSettingCover",-1); 
		$this->SfSettingGroup= $this->ObjectFactory->createObject("SfSettingGroup",-1); 
		$this->SfSettingType = $this->ObjectFactory->createObject("SfSettingType",-1); 
		$this->SettingID = 0;
		$this->Name = "";
		$this->Description = "";
		$this->Value = "";
		$this->Order = 0;
		$this->SfPluginModule->PluginModuleID = -1;
		$this->SfSettingCover->setSettingCoverID(-1);
		$this->SfSettingGroup->setSettingGroupID(-1);
		$this->SfSettingType->setSettingTypeID(-1);
		
		$this->TableName= "sys_setting";
		$this->LanguageHelper->ChangeTableName($this->TableName);
	}
	
	// PHP Bussines Object overloaded constructor
	function SettingID_POST($post)
	{
		$this->SfPluginModule = new SfPluginModule();
		$this->SfSettingCover = new SfSettingCover();
		$this->SfSettingGroup = new SfSettingGroup();
		$this->SfSettingType = new SfSettingType();
		$this->setSettingID(isset($post["settingid"]) ? $post["settingid"] : $this->getSettingID());
		$this->setName(isset($post["name"]) ? $post["name"] : $this->getName());
		$this->setDescription(isset($post["description"]) ? $post["description"] : $this->getDescription());
		$this->setValue(isset($post["value"]) ? $post["value"] : $this->getValue());
		$this->setOrder(isset($post["order"]) ? $post["order"] : $this->getOrder());
		$this->SfPluginModule->setPluginModuleID(isset($post["pluginmoduleid"]) ? $post["pluginmoduleid"] : $this->SfPluginModule->getID());
		$this->SfSettingCover->setSettingCoverID(isset($post["settingcoverid"]) ? $post["settingcoverid"] : $this->SfSettingCover->getSettingCoverID());
		$this->SfSettingGroup->setSettingGroupID(isset($post["settinggroupid"]) ? $post["settinggroupid"] : $this->SfSettingGroup->getSettingGroupID());
		$this->SfSettingType->setSettingTypeID(isset($post["settingtypeid"]) ? $post["settingtypeid"] : $this->SfSettingType->getSettingTypeID());
	}
	
	// Function vratiImenaAtributa
	function vratiImenaAtributa() {
		return "`setting_id`,`name`,`description`,`value`,`order`,`plugin_module_id`,`setting_cover_id`,`setting_group_id`,`setting_type_id`";
	}
	// Function vratiImeKlase
	function vratiImeKlase(){return $this->TableName;}
	
	//Function vratiVrednostAtributa
	function vratiVrednostiAtributa(){ return "'',".$this->quote_smart($this->getName()).",".$this->quote_smart($this->getDescription()).",".$this->quote_smart($this->getValue()).",".$this->quote_smart($this->getOrder()).",".$this->quote_smart($this->SfPluginModule->getID()).",".$this->quote_smart($this->SfSettingCover->getSettingCoverID()).",".$this->quote_smart($this->SfSettingGroup->getSettingGroupID()).",".$this->quote_smart($this->SfSettingType->getSettingTypeID());}
	
	//Function postaviVrednostiAtributa
	function postaviVrednostiAtributa(){ return "`name`=".$this->quote_smart($this->getName()).",`description`=".$this->quote_smart($this->getDescription()).",`value`=".$this->quote_smart($this->getValue()).",`order`=".$this->quote_smart($this->getOrder()).",`plugin_module_id`=".$this->quote_smart($this->SfPluginModule->getID()).",`setting_cover_id`=".$this->quote_smart($this->SfSettingCover->getSettingCoverID()).",`setting_group_id`=".$this->quote_smart($this->SfSettingGroup->getSettingGroupID()).",`setting_type_id`=".$this->quote_smart($this->SfSettingType->getSettingTypeID());}
	
	//Function nazivVezeKaRoditelju
	function nazivVezeKaRoditelju(){ return "settingid";}
	
	//Function vratiUslovZaNadjiSlog
	function vratiUslovZaNadjiSlog(){ return "setting_id=".$this->quote_smart($this->getSettingID());}
	
	//Function vratiUslovZaSortiranje
	function vratiUslovZaSortiranje(){ return "setting_id";}
	
	//Function vratiUslovZaNadjiSlogF
	function vratiUslovZaNadjiSlogF(){ return "setting_id=".$this->quote_smart($this->getSettingID());}
	
	//Function vratiUslovZaNadjiSlogove
	function vratiUslovZaNadjiSlogove(){ return "1=";}
	
	//Function postaviID
	function postaviID($id){ $this->setSettingID($this->quote_smart($id));}
	
	//Function napuni 
	function napuni($result_row)
	{
		$this->SettingID = $result_row->setting_id;
		$this->Name = $result_row->name;
		$this->Description = $result_row->description;
		$this->Value = $result_row->value;
		$this->Order = $result_row->order;
		$this->SfPluginModule->PluginModuleID = $result_row->plugin_module_id;
		$this->SfSettingCover->SettingCoverID = $result_row->setting_cover_id;
		$this->SfSettingGroup->SettingGroupID = $result_row->setting_group_id;
		$this->SfSettingType->SettingTypeID = $result_row->setting_type_id;
	}
	
	function napuniNiz($result_set, &$al){
	if(count($result_set)>0)
		foreach($result_set as $result_row){
			$odo = new Setting();
			$odo->setSettingID($result_row->setting_id);
			$odo->setName($result_row->name);
			$odo->setDescription($result_row->description);
			$odo->setValue($result_row->value);
			$odo->setOrder($result_row->order);
			$odo->SfPluginModule->setID($result_row->plugin_module_id);
			$odo->SfSettingCover->setSettingCoverID($result_row->setting_cover_id);
			$odo->SfSettingGroup->setSettingGroupID($result_row->setting_group_id);
			$odo->SfSettingType->setSettingTypeID($result_row->setting_type_id);
			array_push($al, $odo);
		}
	}
	
	// Function napuniVisePovezi
	function napuniVisePovezi($result_set, $relation_name)
	{
		switch ($relation_name)
		{
			case "sfpluginmodule":
				if(count($result_set)>0) $this->SfPluginModule->napuni($result_set);
				break;
			case "sfsettingcover":
				if(count($result_set)>0) $this->SfSettingCover->napuni($result_set);
				break;
			case "sfsettinggroup":
				if(count($result_set)>0) $this->SfSettingGroup->napuni($result_set);
				break;
			case "sfsettingtype":
				if(count($result_set)>0) $this->SfSettingType->napuni($result_set);
				break;
			default: break;
		}
	}
	
	function toArray()
	{
		$arr = array();
			$arr = array_merge($arr, array("settingid" => $this->getSettingID()));
			$arr = array_merge($arr, array("name" => $this->getName()));
			$arr = array_merge($arr, array("description" => $this->getDescription()));
			$arr = array_merge($arr, array("value" => $this->getValue()));
			$arr = array_merge($arr, array("order" => $this->getOrder()));
			$arr = array_merge($arr, array("pluginmoduleid" => $this->SfPluginModule->getID()));
			$arr = array_merge($arr, array("settingcoverid" => $this->SfSettingCover->getSettingCoverID()));
			$arr = array_merge($arr, array("settinggroupid" => $this->SfSettingGroup->getSettingGroupID()));
			$arr = array_merge($arr, array("settinggroupname" => $this->SfSettingGroup->getValue()));
			$arr = array_merge($arr, array("settingtypeid" => $this->SfSettingType->getSettingTypeID()));
		return $arr;
	}

	function getSettingID()
	{
		return $this->SettingID;
	}
	function getName()
	{
		return $this->Name;
	}
	function getDescription()
	{
		return $this->Description;
	}
	function getValue()
	{
		return $this->Value;
	}
	function getOrder()
	{
		return $this->Order;
	}
	function getID()
	{
		return $this->SfPluginModule->PluginModuleID;
	}
	function getSettingCoverID()
	{
		return $this->SfSettingCover->SettingCoverID;
	}
	function getSettingGroupID()
	{
		return $this->SfSettingGroup->SettingGroupID;
	}
	function getSettingTypeID()
	{
		return $this->SfSettingType->SettingTypeID;
	}
	
	function setSettingID($val)
	{
		$this->SettingID = $val;
	}
	function setName($val)
	{
		$this->Name = $val;
	}
	function setDescription($val)
	{
		$this->Description = $val;
	}
	function setValue($val)
	{
		$this->Value = $val;
	}
	function setOrder($val)
	{
		$this->Order = $val;
	}
	function setPluginModuleID($val)
	{
		$this->SfPluginModule->PluginModuleID = $val;
	}
	function setSettingCoverID($val)
	{
		$this->SfSettingCover->SettingCoverID = $val;
	}
	function setSettingGroupID($val)
	{
		$this->SfSettingGroup->SettingGroupID = $val;
	}
	function setSettingTypeID($val)
	{
		$this->SfSettingType->SettingTypeID = $val;
	}
	
	function getLinkID()
	{
		return 'settingid='.$this->SettingID;
	}
}
?>