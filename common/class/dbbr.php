<?
	/* CMS Studio 3.0 dbbr.php */

include_once("ezsql/ez_sql_core.php");
//include_once("ezsql/mysql/ez_sql_mysql.php");
include_once("ezsql/mysqli/ez_sql_mysqli.php"); //za php7.0

class DatabaseBrokerException extends Exception 
{
	
	public function __construct()
	{
		
	}
}

class DatabaseBroker
{
	public $con;   //database connection
	private $debug;
	
	public $table_exception=array("labels","newscategory","newstype","event_category");	
	
    private static $instance;
	    
    public static function getInstance()
	{
		if(!isset(self::$instance))
		{
			$object= __CLASS__;
			self::$instance=new $object;
		}
		
		return self::$instance;
	}
	
	public static function isOnline()
	{
		$con = new ezSQL_mysql(EZSQL_DB_USER, EZSQL_DB_PASSWORD, EZSQL_DB_NAME, EZSQL_DB_HOST);
		return $con->quick_connect(EZSQL_DB_USER, EZSQL_DB_PASSWORD, EZSQL_DB_NAME, EZSQL_DB_HOST);
	}
		
	function __construct()
	{
		//global $db;
		$this->con = new ezSQL_mysql(EZSQL_DB_USER,EZSQL_DB_PASSWORD,EZSQL_DB_NAME,EZSQL_DB_HOST);
		$this->debug =false;
		//echo "go";
		$this->con->query("SET SESSION sql_mode = ''");		
		$this->con->query("SET collation_connection = utf8_general_ci");
		$this->con->query("SET NAMES utf8");
	}
	
	function makeEx($tab)
	{
		$exc=false;
		$upit_ss="SELECT `language` from subsite WHERE `sub_site_id`='".$_SESSION["subsiteid"]."'";
		$result_set = $this->con->get_results($upit_ss);
		$dbp = $result_set[0]->language;
		$lng=explode("(",$dbp);
		$dbp="_".strtolower(substr($lng[1],0,-1));
		foreach ($this->table_exception as $tbl_name)
		{
			if ($tbl_name.$dbp==$tab) $exc=true;
		}	
		if ($dbp=='') $exc=false;
		return $exc;
	}
	
	function makeIncl($tab)
	{
		$inc=false;
		foreach ($this->table_exception as $tbl_name)
		{
			if ($tbl_name==$tab) $inc=true;
		}
		$upit_ss="SELECT `language` from document_language";
		$result_set = $this->con->get_results($upit_ss);
		foreach ($result_set as $lng)
		{	$lng=explode("(",$lng);
			$lng="_".strtolower(substr($lng[1],0,-1));
		}	
		$this->lng_array=$result_set;
		return $inc;
	}	
	
	function languages()
	{
		$upit_ss="SELECT `language` from document_language";
		$result_set = $this->con->get_results($upit_ss);
		$languages=array();
		foreach ($result_set as $lng)
		{	
			$lng=explode("(",$lng->language);
			$lng=strtolower(substr($lng[1],0,-1));
			array_push($languages, $lng);
		}	
		return $languages;
	}

	function kreirajPrSlog(&$odo)  //kreiraj prazan slog
	{
		try
		{
			$upit ="INSERT INTO ".$odo->vratiImeKlase()."  VALUES ();";
			$this->con->query($upit);
			if ($this->debug) { $this->con->debug();}
			$odo->postaviId($this->con->insert_id);
		}
		catch (Exception $ex)
		{
			throw new DatabaseBrokerException();
		}
	}

	function kreirajSlog(&$odo)
	{
		try
		{
			$upit ="INSERT INTO " . $odo->vratiImeKlase()  . " (" . $odo->vratiImenaAtributa() . ") VALUES (" . $odo->vratiVrednostiAtributa() . ")";
			//exit ($upit);
			$this->con->query($upit);
			if ($this->debug) { $this->con->debug();}
			$odo->postaviId($this->con->insert_id);
		}
		catch (Exception $ex)
		{
			throw new DatabaseBrokerException();
		}
		return $this->con->insert_id;		
	}

	function obrisiSlog($odo)
	{
		try
		{
			$upit ="DELETE FROM " . $odo->vratiImeKlase() . " WHERE " . $odo->vratiUslovZaNadjiSlog();
			$this->con->query($upit);
			if ($this->debug) { $this->con->debug();}
		}
		catch (Exception $ex)
		{
			throw new DatabaseBrokerException();
		}
	}

	
	function obrisiSlogove($odo, $filter="")
	{
		try
		{
			if($filter == "") $filter = $odo->vratiUslovZaNadjiSlogove();
			
			$upit ="DELETE FROM " . $odo->vratiImeKlase() . " WHERE " . $filter;
			//exit ($upit);
			$this->con->query($upit);
			if ($this->debug) { $this->con->debug();}
		}
		catch (Exception $ex)
		{
			throw new DatabaseBrokerException();
		}
	}
	function resetAI($odo,$max)
	{
		try
		{
			
			$upit ="ALTER TABLE ".$odo->vratiImeKlase()." AUTO_INCREMENT =".$max."";
			$this->con->query($upit);
			if ($this->debug) { $this->con->debug();}
		}
		catch (Exception $ex)
		{
			throw new DatabaseBrokerException();
		}
	}
	function promeniSlog($odo)
	{
		try
		{
			$upit="UPDATE ".$odo->vratiImeKlase()." SET ". $odo->postaviVrednostiAtributa(). " WHERE " .$odo->vratiUslovZaNadjiSlog();
			//echo "<div class='success'>".$upit."</div>";

			$this->con->query($upit);
			if ($this->debug) { $this->con->debug();}
		}
		catch (Exception $ex)
		{
			throw new DatabaseBrokerException();
		}
	}
	
	function nadjiSlogVratiGa(&$odo, $sel_attribs ="*")
	{
		try
		{
			$upit ="SELECT ".$sel_attribs. " FROM ".$odo->vratiImeKlase()." WHERE ".$odo->vratiUslovZaNadjiSlog();
			$check="DESCRIBE `".$odo->vratiImeKlase()."`";
			if ($this->con->query($check)) $result_row = $this->con->get_row($upit);
			else $result_row = $this->get_xml($upit);
			
			if ($this->debug) { $this->con->debug();}
			if($this->con->num_rows != 0) 
			{
				$odo->DbStatus = "Found";
				$odo->napuni($result_row);
			}
			else $odo->DbStatus = "NotFound";
		}
		catch (Exception $ex)
		{
			throw new DatabaseBrokerException();
		}
	}
	function prebrojSveSlogove(&$odo, $filter_arr)
	{
		try
		{
			$filters = "";
			foreach ($filter_arr as $f)
			{
				$filters .= " AND ".$f;
			}
			
			$upit = "SELECT count(*) as cnt FROM ".$odo->vratiImeKlase()." WHERE 1=1 " .$filters;
			
			$check="DESCRIBE `".$odo->vratiImeKlase()."`";
			if ($this->con->query($check)) $result_set = $this->con->get_results($upit);
			else $result_set = $this->get_xml($upit);
	
			
			if ($this->debug) { $this->con->debug();}
			return $result_set[0]->cnt;
		}
		catch (Exception $ex)
		{
			throw new DatabaseBrokerException();
		}
	}
	function vratiSveSlogove(&$odo, &$al, $sel_attribs ="*", $filter="", $sort="" ,$limit=0, $offset=0)
	{	
		try
		

		{
			$SORTBY = "";
			if($sort != "")
			{
				$SORTBY = " ORDER BY " .$sort;
			}
			else if($odo->vratiUslovZaSortiranje() != "")
			{
				$SORTBY= " ORDER BY " .$odo->vratiUslovZaSortiranje();
			}
			
	
			
			$upit = "SELECT ".$sel_attribs." FROM ".$odo->vratiImeKlase() ." WHERE 1=1 " .$filter . $SORTBY;
	
	
			if($limit > 0 && $offset > 0) {
				// ukoliko imamo i limit i offset
				$limit= " LIMIT ".$offset.",".$limit;
				$upit = $upit. $limit;
			} else if($limit > 0) {
				// ukoliko imamo samo limit
				$limit= " LIMIT ".$limit;
				$upit = $upit. $limit;
			}
			$check="DESCRIBE `".$odo->vratiImeKlase()."`";
			if ($this->con->query($check)) $result_set = $this->con->get_results($upit);
			else $result_set = $this->get_xml($upit);
						
			if ($this->debug) { $this->con->debug();}

			
			$odo->napuniNiz($result_set, $al);
		}
		catch (Exception $ex)
		{
			throw new DatabaseBrokerException();
		}
	}

	
	function pronadjiSlogoveFulltext(&$odo, &$al, $srch)
	{
		try
		{
			$upit = "SELECT  * , MATCH (". $odo->vratiFulltextIndekse() ." ) AGAINST ( ". $srch ." IN BOOLEAN MODE) AS relevance FROM ".$odo->vratiImeKlase()." WHERE  MATCH (". $odo->vratiFulltextIndekse() .") AGAINST (  ".$srch." IN BOOLEAN MODE)";
			$check="DESCRIBE `".$odo->vratiImeKlase()."`";
			if ($this->con->query($check)) $result_set = $this->con->get_results($upit);
			else $result_set = $this->get_xml($upit);
			
			if ($this->debug) { $this->con->debug();}
			$odo->napuniNiz($result_set, $al);
		}
		catch (Exception $ex)
		{
			throw new DatabaseBrokerException();
		}
	}
	
	function poveziSaJednim(&$odo, &$odo1)
	{
		try
		{
			$upit ="SELECT * FROM ". $odo1->vratiImeKlase() ." WHERE ".$odo1->vratiUslovZaNadjiSlog();
			$check="DESCRIBE `".$odo1->vratiImeKlase()."`";
			if ($this->con->query($check)) $result_row = $this->con->get_row($upit);
			else $result_row = $this->get_xml($upit);

			if ($this->debug) { $this->con->debug();}
			
			if(!empty($result_row))
			{
				$odo->napuniVisePovezi($result_row, $odo1->nazivVezeKaRoditelju());
			}
		}
		catch (Exception $ex)
		{
			throw new DatabaseBrokerException();
		}
	}
	
	// sluzi za regulisanje veza 1-M i M-M 
	function poveziSaVise(&$odo, &$odo1, $sel_attribs ="*", $filter="", $sort="" ,$limit=0, $offset=0)
	{
		try
		{
			if($filter == "") $filter = $odo->vratiUslovZaNadjiSlogF();
			if($sort != ""){
				$SORTBY = $sort;
			} else {
				$SORTBY = $odo1->vratiUslovZaSortiranje();
			}

			$vezna_klasa = ""; $uslov_join ="";
			$odo->vratiImeVezneTabele($odo1->vratiImeKlase(),$vezna_klasa,$uslov_join);
			if($vezna_klasa != "")
			{
				if($SORTBY != "") { $SORTBY = " ORDER BY " . $SORTBY;}
				// preko ovog upita direktno povezujem dve tabele sa njihovom veznom tabelom
				$upit = "SELECT ".$sel_attribs." FROM ".$vezna_klasa." as IJ1 INNER JOIN ".$odo1->vratiImeKlase()." as IJ2  WHERE ".$uslov_join	." AND ".$filter . $SORTBY;
			}
			else 
				// preko ovog upita dobijamo vise podredjenih objekata i uspostavljamo vezu sa njima u memoriji
				$upit ="SELECT ".$sel_attribs." FROM ".$odo1->vratiImeKlase()." WHERE ".$filter. " ORDER BY ". $SORTBY;
			
			//ukoliko imamo samo limit
			if($limit > 0 && $offset ==0) {
				$limit= " LIMIT ".$limit;
				$upit = $upit. $limit;
			}
			//ukoliko imamo i limit i offset
			if($limit > 0 && $offset > 0) {
				$limit= " LIMIT ".$offset.",".$limit;
				$upit = $upit. $limit;	
			}
			//print_r($odo);
			$check1="DESCRIBE `".$odo1->vratiImeKlase()."`";
			if ($this->con->query($check1)) $result_set = $this->con->get_results($upit);
			else $result_set = $this->get_xml($upit);
			
			if ($this->debug) { $this->con->debug();}
			$odo->napuniVisePovezi($result_set, $odo1->nazivVezeKaRoditelju());
		}
		catch (Exception $ex)
		{
			throw new DatabaseBrokerException();
		}
	}
	
	function vratiMaxPoUslovu($odo)
	{
		try
		{
			$upit = "SELECT MAX(".$odo->vratiAtributZaMax().") as max FROM ".$odo->vratiImeKlase()." WHERE ".$odo->vratiUslovZaNadjiSlogove();
			$check="DESCRIBE `".$odo->vratiImeKlase()."`";
			if ($this->con->query($check)) $result_row = $this->con->get_row($upit);
			else $result_row = $this->get_xml($upit);

			if ($this->debug) { $this->con->debug();}
			return $result_row->max + 1;
		}
		catch (Exception $ex)
		{
			throw new DatabaseBrokerException();
		}
	}

	function vratiPoslednjiID($odo)
	{
		try
		{
			$upit = "SHOW columns FROM `".$odo->vratiImeKlase()."`  WHERE extra like '%auto_increment%'";
			$col =$this->con->get_var($upit);
			if ($this->debug) { $this->con->debug();}
			$sql2="SELECT max(`".$col."`) as maks FROM (".$odo->vratiImeKlase().") ";
			$id=$this->con->get_results($sql2);
			if ($this->debug) { $this->con->debug();}
			$id=$id[0]->maks;
			$colid=array($col,$id);
			return $colid;
		}
		catch (Exception $ex)
		{
			throw new DatabaseBrokerException();
		}
	}
	
	function zapisPostoji(&$odo)
	{
		try
		{
			$upit ="SELECT * FROM ".$odo->vratiImeKlase()." WHERE ".$odo->vratiUslovZaNadjiSlog();
			$check="DESCRIBE `".$odo->vratiImeKlase()."`";
			if ($this->con->query($check)) $result_row = $this->con->get_row($upit);
			else $result_row = $this->get_xml($upit);
						
			if ($this->debug) { $this->con->debug();}
			if($this->con->num_rows == 0) return false;
			else return true;
		}
		catch (Exception $ex)
		{
			throw new DatabaseBrokerException();
		}
	}
	
	function getConnection()
	{
		return $this->con;	
	}
	
	function SetDebugOn()
	{
		$this->debug = true;
	}
	
	
	function SetDebugOff()
	{
		$this->debug = false;
	}
	
	function Debug()
	{
		$this->con->debug();
	}
	
	
	function get_xml($query)
	{
		$file = simplexml_load_file(ROOT_WEB2.'xmlmake.php?query='.$query);
		$cnt=count($file);
		for ($i = 1; $i<=$cnt; $i++) {

			eval("\$arr = \$file->item".$i.";");
			$rowx[$i]=new stdClass;
			foreach ($arr as $row) {
				foreach ($row as $key=>$field) {
					$field = str_replace('','',$field);
					eval("\$rowx[$i]->\$key=\$field;");
				}
				$niz[$i-1]=$rowx[$i];
			}	
		}
		return $niz;
	}		
} //kraj database brokera

?>