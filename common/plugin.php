<?

/* CMS Studio 3.0 plugin.php secured*/

class Plugin extends OpstiDomenskiObjekat 
{
	public $PluginID;
	public $Title;
	public $FileName;
	public $ClassName;
	public $TemplateBase;
	public $Active;
	public $SfPluginModule;
	
	// iz vezne tabele
	public $FilterID;
	public $PlgtemID;
	public $Position; 
	
	//Bussiness PHP Object constructor
	function __construct()
	{
		parent::__construct();
		
		$this->SfPluginModule = $this->ObjectFactory->createObject("SfPluginModule",-1); 
		$this->PluginID = -1;
		$this->Title = "";
		$this->FileName = "";
		$this->ClassName = "";
		//$this->Module = "";
		$this->TemplateBase = "admin";
		$this->Active = "false";
		$this->SfPluginModule->ID = -1;
		
		$this->FilterID = -1;
		$this->PlgtemID = -1;
		$this->Position = "";
		$this->TableName = "plugin";
		$this->LanguageHelper->ChangeTableName($this->TableName);
	}
	
	// fill Plugin from POST
	function Plugin_POST(&$post)
	{
		$this->SfPluginModule = $this->ObjectFactory->createObject("SfPluginModule",-1);
		
		$this->PluginID= isset($post["pluginid"]) ? $post["pluginid"] : $this->PluginID;
		$this->Title= isset($post["title"]) ? $post["title"] : $this->Title;
		$this->FileName= isset($post["filename"]) ? $post["filename"] : $this->FileName;
		$this->ClassName= isset($post["classname"]) ? $post["classname"] : $this->ClassName;
		//$this->Module = isset($post["module"]) ? $post["module"] : $this->Module;
		$this->TemplateBase = isset($post["templatebase"]) ? $post["templatebase"] : $this->TemplateBase;
		$this->Active = isset($post["active"]) ? $post["active"] : $this->Active;
		$this->SfPluginModule->ID = isset($post["pluginmoduleid"]) ? $post["pluginmoduleid"] : $this->SfPluginModule->ID;
	}

	// Function vratiImenaAtributa
	function vratiImenaAtributa() {
		return "`plugin_id`,`title`,`file_name`,`classname`,`plugin_module_id`,`template_base`,`active`";
	}
	// Function vratiImeKlase
	function vratiImeKlase(){return $this->TableName;}
	
	//Function vratiVrednostAtributa
	function vratiVrednostiAtributa(){ return "'',".$this->quote_smart($this->Title).",".$this->quote_smart($this->FileName).",".$this->quote_smart($this->ClassName).",".$this->quote_smart($this->SfPluginModule->ID).",".$this->quote_smart($this->TemplateBase).",".$this->quote_smart($this->Active);}
	
	//Function postaviVrednostiAtributa
	function postaviVrednostiAtributa(){ return "`title`=".$this->quote_smart($this->Title).",`file_name`=".$this->quote_smart($this->FileName).",`classname`=".$this->quote_smart($this->ClassName).",`plugin_module_id`=".$this->quote_smart($this->SfPluginModule->ID).",`template_base`=".$this->quote_smart($this->TemplateBase).",`active`=".$this->quote_smart($this->Active);}
	
	//Function nazivVezeKaRoditelju
	function nazivVezeKaRoditelju(){ return "plugin";}
	
	function vratiUslovZaNadjiSlog(){ return "plugin_id=".$this->quote_smart($this->PluginID);}
	
	function vratiUslovZaSortiranje(){ return "active desc, title";}
	
	function vratiUslovZaNadjiSlogF(){ return "plugin_id=".$this->quote_smart($this->PluginID);}
	
	function vratiUslovZaNadjiSlogove(){ return "1=";}
	
	function postaviID($id){ $this->PluginID = $id;}
	
	function napuni($result_row)
	{
		$this->PluginID = $result_row->plugin_id;
		$this->Title = $result_row->title;
		$this->FileName = $result_row->file_name;
		$this->ClassName = $result_row->classname;
		$this->SfPluginModule->ID =$result_row->plugin_module_id;
		$this->TemplateBase = $result_row->template_base;
		$this->Active = $result_row->active;
		@$this->FilterID =$result_row->filterid;
		@$this->PlgtemID =$result_row->plgtem_id;
		@$this->Position =$result_row->position;
	}
	
	function napuniNiz($result_set, &$al)
	{
		if(count($result_set)>0)
		{
			foreach($result_set as $result_row)
			{
				$odo = $this->ObjectFactory->createObject("Plugin",-1);
				$odo->PluginID = $result_row->plugin_id;
				$odo->Title = $result_row->title;
				$odo->FileName = $result_row->file_name;
				$odo->ClassName = $result_row->classname;
				$odo->SfPluginModule->ID = $result_row->plugin_module_id;
				$odo->TemplateBase = $result_row->template_base;
				$odo->Active = $result_row->active;
				@$odo->FilterID = $result_row->filterid;
				@$odo->PlgtemID = $result_row->plgtem_id;
				@$odo->Position = $result_row->position;
				array_push($al, $odo);
			}
		}
	}
	
	function napuniVisePovezi($result_set, $relation_name)
	{
			switch ($relation_name){
					case "sfpluginmodule":
						if(count($result_set)>0) $this->SfPluginModule->napuni($result_set);
						break;
                   default: break;
           }
 	}
	
	function toArray()
	{
		$arr = array();
			$arr = array_merge($arr, array("pluginid" => $this->getPluginID()));
			$arr = array_merge($arr, array("title" => $this->getTitle()));
			$arr = array_merge($arr, array("filename" => $this->getFileName()));
			$arr = array_merge($arr, array("classname" => $this->getClassName()));
			$arr = array_merge($arr, array("pluginmoduleid" => $this->getModule()));
			$arr = array_merge($arr, array("templatebase" => $this->getTemplateBase()));
			$arr = array_merge($arr, array("active" => $this->getActive()));
			$arr = array_merge($arr, array("filterid" => $this->getFilterID()));
			$arr = array_merge($arr, array("position" => $this->getPosition()));
		return $arr;
	}
	
	function getPluginID()
	{
		return $this->PluginID;
	}
	function getTitle()
	{
		return $this->Title;
	}
	function getFileName()
	{
		return $this->FileName;
	}
	function getClassName()
	{
		return $this->ClassName;
	}
	function getModule()
	{
		return $this->SfPluginModule->getVrednost();
	}
	function getTemplateBase()
	{
		switch($this->TemplateBase)
		{
			case "admin": 
				return "Admin";
			case "front": 
				return "Front";
			case "adminfront": 
				return "Admin & Front";
			default : return "Error";
		}
	}
	function getActive()
	{
		if($this->Active == "true") return "Da";
		else return "Ne";
	}
	function getFilterID()
	{
		return $this->FilterID;
	}
	function getPosition()
	{
		return $this->Position;
	}
	function setPluginID($val)
	{
		$this->PluginID = $val;
	}
	function setTitle($val)
	{
		$this->Title = $val;
	}
	function setFileName($val)
	{
		$this->FileName = $val;
	}
	function setClassName($val)
	{
		$this->ClassName = $val;
	}
	function setModule($val)
	{
		$this->Module = $val;
	}
	function setTemplateBase($val)
	{
		$this->TemplateBase = $val;
	}
	function setActive($val)
	{
		$this->Active = $val;
	}
	
	function getLinkID()
	{
		return 'pluginid='.$this->PluginID;
	}
}


?>