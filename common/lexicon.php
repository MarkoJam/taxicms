<?

/* CMS Studio 3.0 lexicon.php */

// klasa Lexicon cuva podatke o univerzalnim plginovima koje mozemo koristiti za razne namene!
class Lexicon extends OpstiDomenskiObjekat 
{
	public $LexiconID;
	public $Header;
	public $Html;

	//Bussiness PHP Object constructor
	function __construct()
	{
		parent::__construct();
		
		$this->LexiconID = -1;
		$this->Header = ""; 
		$this->Html = "";
		
		$this->TableName = "lexicon";
		$this->LanguageHelper->ChangeTableName($this->TableName);
	}
	
	// fill Lexicon from POST
	function Lexicon_POST(&$post)
	{
		$this->LexiconID= isset($post["lexiconid"]) ? $post["lexiconid"] : $this->LexiconID;
		$this->Header= isset($post["header"]) ? $post["header"] : $this->Header;
		$this->Html= isset($post["html"]) ? $post["html"] : $this->Html;
	}
	
	// DatabaseBroker functions
	function vratiImenaAtributa() {return "`lexiconid`,`header`,`html`";}
	function vratiImeKlase(){return $this->TableName;}
	function vratiVrednostiAtributa(){ return "'',".$this->quote_smart($this->Header).",".$this->quote_smart($this->Html);}
	function postaviVrednostiAtributa(){ return "`header` = ".$this->quote_smart($this->Header).",`html` = ".$this->quote_smart($this->Html);}
	function nazivVezeKaRoditelju(){ return "lexicon";}
	function vratiUslovZaNadjiSlog(){ return "lexiconid=".$this->quote_smart($this->LexiconID);}
	function vratiUslovZaSortiranje(){ return "lexiconid";}
	function vratiUslovZaNadjiSlogF(){ return "lexiconid=".$this->quote_smart($this->LexiconID);}
	function vratiUslovZaNadjiSlogove(){ return "1=";}
	function postaviID($id){ $this->LexiconID = $id;}
	function napuni($result_row){
		$this->LexiconID = $result_row->lexiconid;
		$this->Header = $result_row->header;
		$this->Html = $result_row->html;
	}
	function napuniNiz($result_set, &$al){
		if(count($result_set)>0)
			foreach($result_set as $result_row){
				$uplg = $this->ObjectFactory->createObject("Lexicon",-1);
				$uplg->LexiconID = $result_row->lexiconid;
				$uplg->Header = $result_row->header;
				$uplg->Html = $result_row->html;
				array_push($al, $uplg);
			}
	}
	
	function toArray()
	{
		$arr = array();
			$arr = array_merge($arr, array("lexiconid" => $this->getLexiconID()));
			$arr = array_merge($arr, array("header" => $this->getHeader()));
			$arr = array_merge($arr, array("html" => htmldecode($this->Html)));
		return $arr;
	}
	
	// get metode ispravi ako ima nesto!!!
	function getLexiconID()
	{
		return $this->LexiconID;
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
	function setLexiconID($val)
	{
		$this->LexiconID= $val;
	}
	function setHeader($val)
	{
		return $this->LanguageHelper->Transliterate($this->Header);
	}
	function setHtml($val)
	{
		return $this->LanguageHelper->Transliterate($this->Html);		
	}
	function getLinkID()
	{
		return 'lexiconid='.$this->LexiconID;
	}
		


}
?>