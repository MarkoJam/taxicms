<?

/* CMS Studio 3.0 universal.php */

// klasa UniversalPlugin cuva podatke o univerzalnim plginovima koje mozemo koristiti za razne namene!
class UniversalPlugin extends OpstiDomenskiObjekat 
{
	public $UniversalPluginID;
	public $Header;
	public $Html;

	//Bussiness PHP Object constructor
	function __construct()
	{
		parent::__construct();
		
		$this->UniversalPluginID = -1;
		$this->Header = ""; 
		$this->Html = "";
		
		$this->TableName = "universalplugin";
		$this->LanguageHelper->ChangeTableName($this->TableName);
	}
	
	// fill UniversalPlugin from POST
	function UniversalPlugin_POST(&$post)
	{
		$this->UniversalPluginID= isset($post["universalpluginid"]) ? $post["universalpluginid"] : $this->UniversalPluginID;
		$this->Header= isset($post["header"]) ? $post["header"] : $this->Header;
		$this->Html= isset($post["html"]) ? $post["html"] : $this->Html;
	}
	
	// DatabaseBroker functions
	function vratiImenaAtributa() {return "`universalpluginid`,`header`,`html`";}
	function vratiImeKlase(){return $this->TableName;}
	function vratiVrednostiAtributa(){ return "'',".$this->quote_smart($this->Header).",".$this->quote_smart($this->Html);}
	function postaviVrednostiAtributa(){ return "`header` = ".$this->quote_smart($this->Header).",`html` = ".$this->quote_smart($this->Html);}
	function nazivVezeKaRoditelju(){ return "universalplugin";}
	function vratiUslovZaNadjiSlog(){ return "universalpluginid=".$this->quote_smart($this->UniversalPluginID);}
	function vratiUslovZaSortiranje(){ return "universalpluginid";}
	function vratiUslovZaNadjiSlogF(){ return "universalpluginid=".$this->quote_smart($this->UniversalPluginID);}
	function vratiUslovZaNadjiSlogove(){ return "1=";}
	function postaviID($id){ $this->UniversalPluginID = $id;}
	function napuni($result_row){
		$this->UniversalPluginID = $result_row->universalpluginid;
		$this->Header = $result_row->header;
		$this->Html = $result_row->html;
	}
	function napuniNiz($result_set, &$al){
		if(count($result_set)>0)
			foreach($result_set as $result_row){
				$uplg = $this->ObjectFactory->createObject("UniversalPlugin",-1);
				$uplg->UniversalPluginID = $result_row->universalpluginid;
				$uplg->Header = $result_row->header;
				$uplg->Html = $result_row->html;
				array_push($al, $uplg);
			}
	}
	
	function toArray()
	{
		$arr = array();
			$arr = array_merge($arr, array("universalpluginid" => $this->getUniversalPluginID()));
			$arr = array_merge($arr, array("header" => $this->getHeader()));
			$arr = array_merge($arr, array("html" => htmldecode($this->Html)));
		return $arr;
	}
	
	// get metode ispravi ako ima nesto!!!
	function getUniversalPluginID()
	{
		return $this->UniversalPluginID;
	}
	function getHeader()
	{
		return $this->Header;
	}
	function getHtml()
	{
		return $this->Html;
	}
	// set metode ispravi ako ima nesto!!!
	function setUniversalPluginID($val)
	{
		$this->UniversalPluginID= $val;
	}
	function setHeader($val)
	{
		//$this->Header= $val;
		return $this->LanguageHelper->Transliterate($this->Header);
	}
	function setHtml($val)
	{
		//$this->Html= $val;
		return $this->LanguageHelper->Transliterate($this->Html);		
	}
	function getLinkID()
	{
		return 'universalpluginid='.$this->UniversalPluginID;
	}
		
	// za podesavanje plugin-a
	function vratiIDKategorijeZaPlugin(){
		return $this->UniversalPluginID;
	}
		
	function vratiNazivKategorijeZaPlugin(){
		return $this->Header;
	}
	
	function postaviIDKategorijeZaPlugin($id){
		$this->UniversalPluginID = $id;
	}

}
?>