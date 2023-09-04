<?

class LinksCategory extends OpstiDomenskiObjekat 
{
	 public $LinksCategoryID;
	 public $CategoryName;
	 public $Links;
	 
	//Bussiness PHP Object constructor
	function __construct()
	{
		parent::__construct();
		
		$this->LinksCategoryID = -1;
		$this->CategoryName = "";
		$this->Links = array();
		$this->TableName = "linkscategory";
		
		// deo koji u zavisnosti od jezika dodaje postfikse na ime tabele
		// potrebno je dodati samo ako zelim da plugin bude vezan za razlicite jezike
		
		$lh = new LanguageHelper();
		$this->LanguageHelper->ChangeTableName($this->TableName);
	}

	function vratiImenaAtributa() {return "`linkscategoryid`,`categoryname`";}
	function vratiImeKlase(){return $this->TableName;}
	function vratiVrednostiAtributa(){ return "'',".$this->quote_smart($this->CategoryName);}
	function postaviVrednostiAtributa(){ return "`categoryname` = ".$this->quote_smart($this->CategoryName);}
	function nazivVezeKaRoditelju(){ return "linkscategory";}
	function vratiUslovZaNadjiSlog(){ return "linkscategoryid=".$this->quote_smart($this->LinksCategoryID);}
	function vratiUslovZaSortiranje(){ return "linkscategoryid";}
	function vratiUslovZaNadjiSlogF(){ return "linkscategoryid=".$this->quote_smart($this->LinksCategoryID);}
	function vratiUslovZaNadjiSlogove(){ return "1=";}
	function postaviID($id){ $this->LinksCategoryID = $id;}
	function napuni($result_row){
		$this->LinksCategoryID = $result_row->linkscategoryid;
		$this->CategoryName = $result_row->categoryname;
	}
	function napuniNiz($result_set, &$al){
		if(count($result_set)>0)
			foreach($result_set as $result_row){
				$linkscateg = $this->ObjectFactory->createObject("LinksCategory",-1);
				$linkscateg->LinksCategoryID = $result_row->linkscategoryid;
				$linkscateg->CategoryName = $result_row->categoryname;
				array_push($al, $linkscateg);
			}
	}
	
	function napuniVisePovezi($result_set, $relation_name)
	{
		switch ($relation_name){
			case "links":
				if(count($result_set)>0)
				foreach($result_set as $db_res)
				{
					$link = $this->ObjectFactory->createObject("Links",-1);
					$link->napuni($db_res);
					array_push($this->Links,$link);
				}
			break;
			default: break;
		}
	}
	
	function toArray()
	{
		$arr = array();
		$arr = array_merge($arr, array("linkscategoryid" => $this->getLinksCategoryID()));
		$arr = array_merge($arr, array("categoryname" => $this->getCategoryName()));
		return $arr;
	}
	
	function getLinksCategoryID()
	{
		return $this->LinksCategoryID;
	}
	function getCategoryName()
	{
		return $this->CategoryName;
	}
	function getLinks()
	{
		return $this->Links;
	}
	function setLinksCategoryID($var)
	{
		$this->LinksCategoryID = $var;
	}
	function setCategoryName($var)
	{
		$this->CategoryName=$var;
	}
	function setLinks($var)
	{
		$this->Links = $var;
	}
	
	function vratiIDKategorijeZaPlugin(){
		
		return $this->LinksCategoryID;
	}
		
	function vratiNazivKategorijeZaPlugin(){
		return $this->CategoryName;
	}
	
	function postaviIDKategorijeZaPlugin($id){
		$this->LinksCategoryID = $id;
	}
	}
	
	
class Links extends OpstiDomenskiObjekat 
{
	public $LinksID;
	public $LinksName;
	public $LinksUrl;
		 
	public $LinksCategory;
		 
	//Bussiness PHP Object constructor
    function __construct()
    {
    	parent::__construct();
    	
		$this->LinksID = -1;
		$this->LinksName = "Naziv Linka";
		$this->LinksUrl = "";
		$this->LinksCategory = $this->ObjectFactory->createObject("LinksCategory", -1);
		
		$this->TableName = "links";
		$this->LanguageHelper->ChangeTableName($this->TableName);	
	}
	
	function Links_POST(&$post)
	{
		$this->LinksCategory = $this->ObjectFactory->createObject("LinksCategory", -1);
		
		$this->LinksID= isset($post["linksid"]) ? $post["linksid"] : $this->LinksID;
		$this->LinksName= isset($post["linksname"]) ? $post["linksname"] : $this->LinksName;
		$this->LinksUrl= isset($post["linksurl"]) ? $post["linksurl"] : $this->LinksUrl;
		$this->LinksCategory->LinksCategoryID = isset($post["linkscategoryid"]) ? $post["linkscategoryid"] : $this->LinksCategory->LinksCategoryID;
		
	}
	function vratiImenaAtributa() {return "`linksid`,`linksname`,`linksurl`,`linkscategoryid`";}
	function vratiImeKlase(){return $this->TableName;}
	function vratiVrednostiAtributa(){ return "'',".$this->quote_smart($this->LinksName).",".$this->quote_smart($this->LinksUrl).",".$this->quote_smart($this->LinksCategory->LinksCategoryID);}
	function postaviVrednostiAtributa(){ return "`linksname` = ".$this->quote_smart($this->LinksName).",`linksurl` = ".$this->quote_smart($this->LinksUrl).",`linkscategoryid` = ".$this->quote_smart($this->LinksCategory->LinksCategoryID);}
	function nazivVezeKaRoditelju(){ return "links";}
	function vratiUslovZaNadjiSlog(){ return "linksid=".$this->quote_smart($this->LinksID);}
	function vratiUslovZaSortiranje(){ return "linksname desc";}
	function vratiUslovZaNadjiSlogF(){ return "linksid=".$this->quote_smart($this->LinksID);}
	function vratiUslovZaNadjiSlogove(){ return "1=";}
	function postaviID($id){ $this->LinksID = $this->quote_smart($id);}
	function napuni($result_row){
		$this->LinksID = $result_row->linksid;
		$this->LinksName = $result_row->linksname;
		$this->LinksUrl = $result_row->linksurl;
		$this->LinksCategory->LinksCategoryID = $result_row->linkscategoryid;
	}
	function napuniNiz($result_set, &$al){
		if(count($result_set)>0)
			foreach($result_set as $result_row){
				$rssf = $this->ObjectFactory->createObject("Links",-1);
				$rssf->LinksID = $result_row->linksid;
				$rssf->LinksName = $result_row->linksname;
				$rssf->LinksUrl = $result_row->linksurl;
				$rssf->LinksCategory->LinksCategoryID = $result_row->linkscategoryid;
				array_push($al, $rssf);
			}
	}
	
	function napuniVisePovezi($result_set, $relation_name)
	{
		switch ($relation_name){
			case "linkscategory":
				$this->LinksCategory->napuni($result_set); 
			break;
			default: break;
		}
	} 
	
	function toArray()
	{
		$arr = array();
			$arr = array_merge($arr, array("linksid" => $this->getLinksID()));
			$arr = array_merge($arr, array("linksname" => $this->getLinksName()));
			$arr = array_merge($arr, array("linksurl" => $this->getLinksUrl()));
			$arr = array_merge($arr, array("linkscategoryid" => $this->getLinksCategory()));
		return $arr;
	}
	
	// get metode ispravi ako ima nesto!!!
	function getLinksID()
	{
		return $this->LinksID;
	}
	function getLinksName()
	{
		return $this->LinksName;
	}
	function getLinksUrl()
	{
		return $this->LinksUrl;
	}
	function getLinksCategory()
	{
		return $this->LinksCategory;
	}
	// set metode ispravi ako ima nesto!!!
	function setLinksID($val)
	{
		$this->LinksID= $val;
	}
	function setLinksName($val)
	{
		$this->LinksName= $val;
	}
	function setLinksUrl($val)
	{
		$this->LinksUrl= $val;
	}
	function setLinksCategory($val)
	{
		$this->LinksCategory = $val;
	}
	function getLinkID()
	{
		return 'linksid='.$this->LinksID;
	}
	/*	
	// za podesavanje plugin-a
	function vratiIDKategorijeZaPlugin(){
		return $this->LinksID;
	}
		
	function vratiNazivKategorijeZaPlugin(){
		return $this->LinksName;
	}
	
	function postaviIDKategorijeZaPlugin($id){
		$this->LinksID = $id;
	}*/
	
}

?>