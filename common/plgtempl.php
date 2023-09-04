<?

/* CMS Studio 3.0 plug_templ.php secured */

class PluginTemplate extends OpstiDomenskiObjekat 
{
	public $PlgtemID;
	public $Plugin;
	public $Template;
	public $FileName;
	public $FilterID;
	public $Position;

	//Bussiness PHP Object constructor
	function __construct()
	{
		parent::__construct();
		
		$this->PlgtemID = -1;
		
		$this->Plugin = $this->ObjectFactory->createObject("Plugin",-1);
		$this->Template = $this->ObjectFactory->createObject("Template",-1);
		$this->FileName = "";
		$this->FilterID = -1;
		$this->Position = "standard";
		
		$this->TableName = "plug_templ";
		$this->LanguageHelper->ChangeTableName($this->TableName);
	}
	
	// fill Page from POST
	function PluginTemplate_POST(&$post)
	{
		$this->Plugin = $this->ObjectFactory->createObject("Plugin",-1);
		$this->Template = $this->ObjectFactory->createObject("Template",-1);
		
		$this->PlgtemID = isset($post["plgtemid"]) ? $post["plgtemid"] : $this->PlgtemID;
		$this->Plugin->PluginID = isset($post["pluginid"]) ? $post["pluginid"] : $this->Plugin->PluginID;
		$this->Template->TemplateID = isset($post["templateid"]) ? $post["templateid"] : $this->Template->TemplateID;
		$this->FileName = isset($post["FileName"]) ? $post["FileName"] : $this->FileName;
		$this->FilterID = isset($post["filterid"]) ? $post["filterid"] : $this->FilterID;
		$this->Position = isset($post["position"]) ? $post["position"] : $this->Position;
	}

	// DatabaseBroker functions
	function vratiImenaAtributa() {return "`plgtem_id`,`plugin_id`,`template_id`,`file_name`,`filterid`,`position`";}
	function vratiImeKlase(){return $this->TableName;}
	function vratiVrednostiAtributa(){ return "'',".$this->quote_smart($this->Plugin->PluginID).",".$this->quote_smart($this->Template->TemplateID).",".$this->quote_smart($this->FileName).",".$this->quote_smart($this->FilterID).",".$this->quote_smart($this->Position);}
	function postaviVrednostiAtributa(){ return "`plugin_id` = ".$this->quote_smart($this->Plugin->PluginID).",`template_id` = ".$this->quote_smart($this->Template->TemplateID).",`file_name` = ".$this->quote_smart($this->FileName).",`filterid` = ".$this->quote_smart($this->FilterID).",`position` = ".$this->quote_smart($this->Position);}
	function nazivVezeKaRoditelju(){ return "plugintemplate";}
	function vratiUslovZaNadjiSlog(){ return "plgtem_id=".$this->quote_smart($this->PlgtemID);}
	function vratiUslovZaSortiranje(){ return "plgtem_id";}
	function vratiUslovZaNadjiSlogF(){ return "plgtem_id=".$this->quote_smart($this->PlgtemID);}
	function vratiUslovZaNadjiSlogove(){ return "1=";}
	function postaviID($id){ $this->PlgtemID = $id;}
	
	function napuni($result_row)
	{
		$this->PlgtemID = $result_row->plgtem_id;
		$this->Plugin->PluginID = $result_row->plugin_id;
		$this->Template->TemplateID = $result_row->template_id;
		$this->FileName = $result_row->file_name;
		$this->FilterID = $result_row->filterid;
		$this->Position = $result_row->position;
	}
	
	function napuniNiz($result_set, &$al)
	{
		if(count($result_set)>0)
			foreach($result_set as $result_row)
			{
				$pltm = $this->ObjectFactory->createObject("PluginTemplate",-1);
				$pltm->PlgtemID = $result_row->plgtem_id;
				$pltm->Plugin->PluginID = $result_row->plugin_id;
				$pltm->Template->TemplateID = $result_row->template_id;
				$pltm->FileName = $result_row->file_name;
				$pltm->FilterID = $result_row->filterid;
				$pltm->Position = $result_row->position;
				array_push($al, $pltm);
			}
	}
	function toArray()
	{
		$arr = array();
			$arr = array_merge($arr, array("plgtemid" => $this->getPlgtemID()));
			$arr = array_merge($arr, array("pluginid" => $this->getPluginID()));
			$arr = array_merge($arr, array("templateid" => $this->getTemplateID()));
			$arr = array_merge($arr, array("filename" => $this->getFileName()));
			$arr = array_merge($arr, array("filterid" => $this->getFilterID()));
			$arr = array_merge($arr, array("position" => $this->getPosition()));
		return $arr;
	}

	function getPlgtemID()
	{
		return $this->PlgtemID;
	}
	function getPluginID()
	{
		return $this->Plugin->PluginID;
	}
	function getTemplateID()
	{
		return $this->Template->TemplateID;
	}
	function getFileName()
	{
		return $this->FileName;
	}
	function getFilterID()
	{
		return $this->FilterID;
	}
	function getPosition()
	{
		return $this->Position;
	}
	
	function setPlgtemID($val)
	{
		$this->PlgtemID = $val;
	}
	function setPluginID($val)
	{
		$this->Plugin->PluginID = $val;
	}
	function setTemplateID($val)
	{
		$this->Template->TemplateID = $val;
	}
	function setFileName($val)
	{
		$this->FileName = $val;
	}
	function setFilterID($val)
	{
		$this->FilterID = $val;
	}
	function setPosition($val)
	{
		$this->Position = $val;
	}
	function getLinkID()
	{
		return 'plgtemid='.$this->PlgtemID;
	}
}

?>