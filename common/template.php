<?

/* CMS Studio 3.0 template.php secured */

class Template extends OpstiDomenskiObjekat 
{
	public $TemplateID;
	public $Title;
	public $Description;
	public $Plugin;
	public $PluginTemplate;

	//Bussiness PHP Object constructor
	function __construct()
	{
		parent::__construct();
		
		$this->TemplateID = -1;
		$this->Title = "";
		$this->Description = "";
		
		$this->PluginTemplate = array();
		$this->Plugin = array();
		
		$this->TableName = "template";
		$this->LanguageHelper->ChangeTableName($this->TableName);
	}

	// fill Template from POST
	function Template_POST(&$post)
	{
		$this->TemplateID = isset($post["templateid"]) ? $post["templateid"] : $this->TemplateID;
		$this->Title = isset($post["title"]) ? $post["title"] : $this->Title;
		$this->Description = isset($post["description"]) ? $post["description"] : $this->Description;
		
		$this->PluginTemplate = array();
	}
	
	// DatabaseBroker functions
	function vratiImenaAtributa() {return "`template_id`,`title`,`description`";}
	function vratiImeKlase(){return $this->TableName;}
	function vratiVrednostiAtributa(){ return "'',".$this->quote_smart($this->Title).",".$this->quote_smart($this->Description);}
	function postaviVrednostiAtributa(){ return "`title` = ".$this->quote_smart($this->Title).",`description` = ".$this->quote_smart($this->Description);}
	function nazivVezeKaRoditelju(){ return "template";}
	function vratiUslovZaNadjiSlog(){ return "template_id=".$this->quote_smart($this->TemplateID);}
	function vratiUslovZaSortiranje(){ return "template_id";}
	function vratiUslovZaNadjiSlogF(){ return "template_id=".$this->quote_smart($this->TemplateID);}
	function vratiUslovZaNadjiSlogove(){ return "1=";}
	function postaviID($id){ $this->TemplateID = $id;}
	function napuni($result_row){
		$this->TemplateID = $result_row->template_id;
		$this->Title = $result_row->title;
		$this->Description = $result_row->description;
	}
	function napuniNiz($result_set, &$al){
		if(count($result_set)>0)
			foreach($result_set as $result_row){
				$tmpl = $this->ObjectFactory->createObject("Template",-1);
				$tmpl->TemplateID = $result_row->template_id;
				$tmpl->Title = $result_row->title;
				$tmpl->Description = $result_row->description;
				array_push($al, $tmpl);
			}
	}
	
	function vratiImeVezneTabele($relation_class_name,& $vezna_klasa, & $uslov_join)
	{
		$plugin = $this->LanguageHelper->ChangeTableNameR("plugin");
		$plug_templ = $this->LanguageHelper->ChangeTableNameR("plug_templ");
		
		switch ($relation_class_name)
		{
			case $plugin:
				$vezna_klasa = $plug_templ;
				$uslov_join = "IJ1.plugin_id= IJ2.plugin_id";
				break;
		}
	}
	
	function napuniVisePovezi($result_set, $relation_name)
	{
		switch ($relation_name)
		{
			case "plugintemplate":
				if(count($result_set)>0)
				{
					foreach($result_set as $db_res)
					{
						$plgtmpl = $this->ObjectFactory->createObject("PluginTemplate",-1);
						$plgtmpl->napuni($db_res);
						array_push($this->PluginTemplate,$plgtmpl);
					}
				}
			case "plugin":
				if(count($result_set)>0)
				{
					foreach($result_set as $db_res)
					{
						$plg = $this->ObjectFactory->createObject("Plugin",-1);
						$plg->napuni($db_res);
						
						array_push($this->Plugin,$plg);
					}
				}
			break;
			default: break;
		}
	}
	
	//
	function toArray()
	{
		$arr = array();
			$arr = array_merge($arr, array("templateid" => $this->getTemplateID()));
			$arr = array_merge($arr, array("title" => $this->getTitle()));
			$arr = array_merge($arr, array("description" => $this->getDescription()));
		return $arr;
	}
	
	// get and set functions
	public function getTemplateID()
	{
		return $this->TemplateID;
	}
	public function getTitle()
	{
		return $this->Title;
	}
	public function getDescription()
	{
		return $this->Description;
	}
	public function setTemplateID($val)
	{
		$this->TemplateID = $val;
	}
	public function setTitle($val)
	{
		$this->Title = $val;
	}
	public function setDescription($val)
	{
		$this->Description = $val;
	}
	
	public function getLinkID()
	{
		return 'templateid='.$this->TemplateID;
	}
}
?>