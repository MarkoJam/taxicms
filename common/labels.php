<?

/* CMS Studio 3.0 poll.php secured*/

class Labels extends OpstiDomenskiObjekat {
	public $ID;
	public $Plugin;
	public $Name;
	public $Content;
	public $Translate;

	
	//Bussiness PHP Object constructor
	function __construct() {
		parent::__construct ();
		
		
		$this->ID = - 1;
		$this->Name = "";
		$this->Plugin = "";
		$this->Content = "";
		$this->Translate = "";
		
		$this->TableName = "labels";
		$this->LanguageHelper->ChangeTableName ( $this->TableName );
	}
	
	// fill Page from POST
	function Poll_POST(&$post) {
		
		$this->ID = isset ( $post ["id"] ) ? $post ["id"] : $this->ID;
		$this->Name = isset ( $post ["name"] ) ? $post ["name"] : $this->Name;
		$this->Plugin = isset ( $post ["plugin"] ) ? $post ["plugin"] : $this->Plugin;
		$this->Content = isset ( $post ["content"] ) ? $post ["content"] : $this->Content;
		$this->Translate = isset ( $post ["translate"] ) ? $post ["translate"] : $this->Translate;
	}
	
	// DatabaseBroker functions
	function vratiImenaAtributa() {
		return "`id`,`name`,`plugin`,`content`,`translate`";
	}
	function vratiImeKlase() {
		return $this->TableName;
	}
	function vratiVrednostiAtributa() {
		return "''," . $this->quote_smart ( $this->Name ) . "," . $this->quote_smart ( $this->Plugin ) . "," . $this->quote_smart ( $this->Content ) . "," . $this->quote_smart ( $this->Translate ) ;
	}
	function postaviVrednostiAtributa() {
		return "`name` = " . $this->quote_smart ( $this->Name ) . ",`plugin` = " . $this->quote_smart ( $this->Plugin ) . ",`content` = " . $this->quote_smart ( $this->Content ) . ",`translate` = " . $this->quote_smart ( $this->Translate ); 
	}
	function nazivVezeKaRoditelju() {
		return "";
	}
	function vratiUslovZaNadjiSlog() {
		return "id=" . $this->quote_smart ( $this->ID );
	}
	function vratiUslovZaSortiranje() {
		return "content";
	}
	function vratiUslovZaNadjiSlogF() {
		return "id=" . $this->quote_smart ( $this->ID );
	}
	function vratiUslovZaNadjiSlogove() {
		return "1=";
	}
	function postaviID($id) {
		$this->ID = $id;
	}
	function napuni($result_row) {
		$this->ID = $result_row->id;
		$this->Name = $result_row->name;
		$this->Plugin = $result_row->plugin;
		$this->Content = $result_row->content;
		$this->Translate = $result_row->translate;
	}
	function napuniNiz($result_set, &$al) {
		if (count ( $result_set ) > 0) {
			foreach ( $result_set as $result_row ) {
				$ankt = $this->ObjectFactory->createObject ( "Labels", - 1 );
				$ankt->ID = $result_row->id;
				$ankt->Name = $result_row->name;
				$ankt->Plugin = $result_row->plugin;
				$ankt->Content = $result_row->content;
				$ankt->Translate = $result_row->translate;
				array_push ( $al, $ankt );
			}
		}
	}

	function toArray() {
		$arr = array ();
		$arr = array_merge ( $arr, array ("id" => $this->getID () ) );
		$arr = array_merge ( $arr, array ("name" => $this->getName () ) );
		$arr = array_merge ( $arr, array ("plugin" => $this->getPlugin () ) );
		$arr = array_merge ( $arr, array ("content" => $this->getContent () ) );
		$arr = array_merge ( $arr, array ("translate" => $this->getTranslate () ) );
		return $arr;
	}
	
	function vratiIDKategorijeZaPlugin() {
		
		return $this->ID;
	}
	
	function vratiNazivKategorijeZaPlugin() {
		return $this->Plugin;
	}
	function postaviIDKategorijeZaPlugin($id) {
		$this->ID = $id;
	}
	
	function getID() {
		return $this->ID;
	}
	function getName() {
		return $this->Name;
	}
	function getPlugin() {
		return $this->Plugin;
	}
	function getContent() {
		return $this->Content;
	}
	function getTranslate() {
		return $this->Translate;
	}
	function getTranslate1() {
		return $this->Translate1;
	}

	
	function setID($val) {
		$this->ID = $val;
	}
	function setName($val) {
		$this->Name = $val;
	}
	function setPlugin($val) {
		$this->Plugin = $val;
	}
	function setTranslate($val) {
		$this->Translate = $val;
	}
	function setContent($val) {
		$this->Content = $val;
	}
}
?>
