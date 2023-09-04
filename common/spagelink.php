<?

/* CMS Studio 3.0 spagelink.php secured */

class StaticPageLink extends OpstiDomenskiObjekat 
{
	public $SPageID;
	public $Target;
	
	function __construct()
	{
		parent::__construct();
		
		$this->SPageID = 0;
		$this->Target = "";
		
		$this->TableName = "spagelink";
		$this->LanguageHelper->ChangeTableName($this->TableName);
	}
	
	// fill StaticPageLink from POST
	function StaticPageLink_POST(&$post)
	{
		$this->SPageID = isset($post["spageid"]) ? $post["spageid"] : $this->SPageID;
		$this->Target = isset($post["target"]) ? $post["target"] : $this->Target;
	}
	
	// DatabaseBroker functions
	function vratiImenaAtributa() { return "`spage_id`,`target`";}
	function vratiImeKlase(){ return $this->TableName;}
	function vratiVrednostiAtributa(){ return $this->quote_smart($this->SPageID).",".$this->quote_smart($this->Target);}
	function postaviVrednostiAtributa(){ return "`target` = ".$this->quote_smart($this->Target);}
	function nazivVezeKaRoditelju(){ return "";}
	function vratiUslovZaNadjiSlog(){ return "spage_id=".$this->quote_smart($this->SPageID);}
	function vratiUslovZaSortiranje(){ return "spage_id";}
	function vratiUslovZaNadjiSlogF(){ return "spage_id=".$this->quote_smart($this->SPageID);}
	function vratiUslovZaNadjiSlogove(){ return "1=";}
	function postaviID($id){ $this->SPageID = $id;}
	function napuni($result_row)
	{
		$this->SPageID = $result_row->spage_id;
		$this->Target = $result_row->target;
	}
	
	function napuniNiz($result_set, &$al)
	{
		if(count($result_set)>0)
		{
			foreach($result_set as $result_row)
			{
				$spagelnk = $this->ObjectFactory->createObject("StaticPageLink",-1);
				$spagelnk->SPageID = $result_row->spage_id;
				$spagelnk->Target = $result_row->target;
				array_push($al, $spagelnk);
			}
		}
	}
	
	function toArray()
	{
		$arr = array();
		$arr = array_merge($arr, array("spageid" => $this->getSpageID()));
		$arr = array_merge($arr, array("target" => $this->getTarget()));
		return $arr;
	}

	function getSpageID()
	{
		return $this->SpageID;
	}
	function getTarget()
	{
		return $this->Target;
	}
	
	function setSpageID($val)
	{
		$this->SpageID = $val;
	}
	function setTarget($val)
	{
		$this->Target = $val;
	}
	
	function getLinkID()
	{
		return 'spageid='.$this->SpageID;
	}
}
?>