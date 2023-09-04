<?

	class OpstiDomenskiObjekat implements Countable //bazna klasa
	{
	    private $DbStatus;

	    protected $TableName;
	    protected $LanguageHelper;
		protected $ObjectFactory;
		private $count = 0;
		public function count() {
			return ++$this->count;
		}

		// Base Class Constructor
		function __construct()
		{
			// set default values for properties
			$this->DbStatus = "";
			$this->TableName = "";

			// set reference to static LanguageHelper class
			$this->LanguageHelper = LanguageHelper::getInstance();
			// set reference to static LanguageHelper class
			$this->ObjectFactory = ObjectFactory::getInstance();
			$this->array_exclude=array('array_exclude','TableName','LanguageHelper','ObjectFactory','count');

		}

		//rad sa parametrima za automatsko generisanje upita
		function vratiImenaAtributa(){ return "";}
	    function vratiVrednostiAtributa(){ return "";}
	    function postaviVrednostiAtributa(){ return "";}
	    function vratiImeKlase(){ return "";}
	    function vratiUslovZaNadjiSlog(){ return "";}
	    function vratiUslovZaNadjiSlogove(){ return "";}
	    function vratiAtributPretrazivanja(){ return "";}
		function vratiFulltextIndekse(){ return "";}
		function vratiAtributZaMax(){ return "";}
		function poveziSaJednim(){ return; }
		function poveziSaVise(){ return;}
		function vratiImeVezneTabele(){ return "";}

		function toArray()
		{
			$arr = array();
			$obj_vars = get_object_vars($this);
			foreach ($obj_vars as $name => $value)
			{
				if (!in_array($name,$this->array_exclude)) {
					$val = "";
					eval("\$val = \$this->get".$name."();");
		    		$arr = array_merge($arr, array(strtolower($name) => $val));
				}
			}
			return $arr;
		}

		//funkcije za rad sa plugin-ovima
		function vratiIDKategorijeZaPlugin(){}
		function vratiNazivKategorijeZaPlugin(){}
		function postaviIDKategorijeZaPlugin(){}

		function napuni($result_row){}
	    function napuniNiz($result_set, &$al){}
	    function quote_smart($value, $force_quotes = false)
		{
			/*if (get_magic_quotes_gpc())
			{
				$value = stripslashes($value);
			}*/
			if (!is_numeric($value) || $force_quotes)
			{
				global $db;
				//$db = new ezSQL_mysql;
				//$value = "'" . mysql_real_escape_string($value) . "'";
				$value = "'" . mysqli_real_escape_string($db->links,$value) . "'";
			}
			if($value == -1)
			{
				$value = "NULL";
			}
			return $value;
		}
		function getDbStatus(){ return $this->DbStatus;}
	}

	class OpstiDomenskiObjekatList extends ArrayObject
	{
		public function Add($odo)
		{
			$this->append($odo);
		}
	}
?>
