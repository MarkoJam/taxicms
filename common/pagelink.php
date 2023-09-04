<?

/* CMS Studio 3.0 pagelink.php secured */
	
class PageLink extends OpstiDomenskiObjekat 
{
	public $PageID;
	public $Target;
	
	//Bussiness PHP Object constructor
	function __construct()
	{
		parent::__construct();
		
		$this->PageID = -1;
		$this->Target = "";
		
		$this->TableName = "pagelink";
	
		$this->LanguageHelper->ChangeTableName($this->TableName);
	}
	
	// fill PageLink from POST
	function PageLink_POST(&$post)
	{
		$this->PageID = isset($post["pageid"]) ? $post["pageid"] : $this->PageID;
		$this->Target = isset($post["target"]) ? $post["target"] : $this->Target;
	}
	// DatabaseBroker functions
	function vratiImenaAtributa() { return "`page_id`,`target`";}
	function vratiImeKlase(){ return $this->TableName;}
	function vratiVrednostiAtributa(){ return $this->quote_smart($this->PageID).",".$this->quote_smart($this->Target);}
	function postaviVrednostiAtributa(){ return "`target` = ".$this->quote_smart($this->Target);}
	function nazivVezeKaRoditelju(){ return "";}
	function vratiUslovZaNadjiSlog(){ return "page_id=".$this->quote_smart($this->PageID);}
	function vratiUslovZaSortiranje(){ return "page_id";}
	function vratiUslovZaNadjiSlogF(){ return "page_id=".$this->quote_smart($this->PageID);}
	function vratiUslovZaNadjiSlogove(){ return "1=";}
	function postaviID($id){ $this->PageID = $id;}
	function napuni($result_row){
		$this->PageID = $result_row->page_id;
		$this->Target = $result_row->target;
	}
	
	function napuniNiz($result_set, &$al)
	{
		if(count($result_set)>0)
			foreach($result_set as $result_row)
			{
				$pagelnk = $this->ObjectFactory->createObject("PageLink",-1);
				$pagelnk->PageID = $result_row->page_id;
				$pagelnk->Target = $result_row->target;
				array_push($al, $pagelnk);
			}
	}
	
	function toArray()
	{
		$arr = array();
			$arr = array_merge($arr, array("pageid" => $this->PageID));
			$arr = array_merge($arr, array("target" => $this->Target));
		return $arr;
	}

	function getPageID()
	{
		return $this->PageID;
	}
	function getTarget()
	{
		return $this->Target;
	}
	
	function setPageID($val)
	{
		$this->PageID = $val;
	}
	function setTarget($val)
	{
		$this->Target = $val;
	}
	
	function getLinkID()
	{
		return 'pageid='.$this->PageID;
	}
}
?>