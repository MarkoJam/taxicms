<? 

/* CMS Studio 3.0resource.php secured */


// klasa za vezu resa sa drugim resom
class ResRes extends OpstiDomenskiObjekat 
{
	public $ResID;
	public $ConResID;
	public $Order;
	
	//Bussiness PHP Object constructor
	function __construct()
	{
		parent::__construct();
		
		$this->ResID = -1;
		$this->ConResID = -1;
		$this->Order = 0;
			
		$this->TableName = "resres";
		$this->LanguageHelper->ChangeTableName($this->TableName);
	}
	
	// fill PrResGrupaProiz from POST
	function ResRes_POST($post)
	{
		$this->ResID= isset($post["res_id"]) ? $post["res_id"] : $this->ResID;
		$this->ConResID= isset($post["conres_id"]) ? $post["conres_id"] : $this->ConResID;
		$this->Order = isset($post["order"]) ? $post["order"] : $this->Order;
	}
	
	function vratiImenaAtributa() {return "`res_id`,`conres_id`,`order`";}
	function vratiImeKlase(){return $this->TableName;}
	function vratiVrednostiAtributa(){ return 
	$this->quote_smart($this->ResID).",".
	$this->quote_smart($this->ConResID).",".
	$this->quote_smart($this->Order)
	;}
	function postaviVrednostiAtributa(){ return "
	`conresid` = ".$this->quote_smart($this->ConResID).",
	`order` = ".$this->quote_smart($this->Order)
	;}
	function nazivVezeKaRoditelju(){ return "resres";}
	function vratiUslovZaNadjiSlog(){ return "res_id=".$this->quote_smart($this->ResID)." AND conres_id=".$this->quote_smart($this->ConResID);}
	function vratiUslovZaSortiranje(){ return "";}
	function vratiUslovZaNadjiSlogF(){ return "res_id=".$this->quote_smart($this->ResID);}
	function vratiUslovZaNadjiSlogove(){ return "conres_id=".$this->quote_smart($this->ConResID);}
	function postaviID($id){ $this->ResID = $id;}
	function vratiAtributZaMax(){return "`order`";}
	function napuni($result_row){
		$this->ResID = $result_row->resid;
		$this->ConResID = $result_row->conresid;
		$this->Order = $result_row->order;
	}
	function napuniNiz($result_set, &$al){
		if(count($result_set)>0)
			foreach($result_set as $result_row){
				$resres = $this->ObjectFactory->createObject("ResRes",-1);
				$resres->ResID = $result_row->res_id;
				$resres->ConResID = $result_row->conres_id;
				$resres->Order = $result_row->order;
				array_push($al, $resres);
			}
	}
	
	function toArray()
	{
		$arr = array();
			$arr = array_merge($arr, array("resid" => $this->getResID()));
			$arr = array_merge($arr, array("conresid" => $this->getConResID()));
			$arr = array_merge($arr, array("order" => $this->getOrder()));
		return $arr;
	}
	
	
	// get metode
	function getResID()
	{
		return $this->ResID;
	}
	function getConResID()
	{
		return $this->ConResID;
	}
	function getOrder()
	{
		return $this->Order;
	}
	
	// set metode
	function setResID($val)
	{
		$this->ResID= $val;
	}
	function setConResID($val)
	{
		$this->ConResID= $val;
	}
	function setOrder($val)
	{
		$this->Order = $val;
	}
}	

class SfResource extends OpstiDomenskiObjekat
{
	public $ID;
	public $Vrednost;
	public $Code;
	public $Class;
	public $Status;
	
	//Bussiness PHP Object constructor	 
	function __construct()
	{
		parent::__construct();
		
		$this->ID = 0;
		$this->Vrednost = "";
		$this->Code = "";
		$this->Class = "";
		$this->Status = "";
		
		$this->TableName= "sf_resource";
		$this->LanguageHelper->ChangeTableName($this->TableName);
	}
	
	// PHP Bussines Object overloaded constructor
	function SfResource_POST($post)
	{
		$this->ID = isset($post["id"]) ? $post["id"] : $this->ID;
		$this->Vrednost = isset($post["vrednost"]) ? $post["vrednost"] : $this->Vrednost;
		$this->Code = isset($post["code"]) ? $post["code"] : $this->Code;
		$this->Class = isset($post["class"]) ? $post["class"] : $this->Code;
		$this->Status = isset($post["status"]) ? $post["status"] : $this->Code;
	}
	
	// Function vratiImenaAtributa
	function vratiImenaAtributa() {
		return "`id`,`vrednost`,`code`,`class`,`status`";
	}
	// Function vratiImeKlase
	function vratiImeKlase(){return $this->TableName;}
	
	//Function vratiVrednostAtributa
	function vratiVrednostiAtributa(){ return "'',".$this->quote_smart($this->Vrednost).",".$this->quote_smart($this->Code).",".$this->quote_smart($this->Class).",".$this->quote_smart($this->Status);}
	
	//Function postaviVrednostiAtributa
	function postaviVrednostiAtributa(){ return "`vrednost`=".$this->quote_smart($this->Vrednost).",`code`=".$this->quote_smart($this->Code).",`class`=".$this->quote_smart($this->Class).",`status`=".$this->quote_smart($this->Status);}
	
	//Function nazivVezeKaRoditelju
	function nazivVezeKaRoditelju(){ return "sfresource";}
	
	//Function vratiUslovZaNadjiSlog
	function vratiUslovZaNadjiSlog(){ return "id=".$this->quote_smart($this->ID);}
	
	//Function vratiUslovZaSortiranje
	function vratiUslovZaSortiranje(){ return "id";}
	
	//Function vratiUslovZaNadjiSlogF
	function vratiUslovZaNadjiSlogF(){ return "id=".$this->quote_smart($this->ID);}
	
	//Function vratiUslovZaNadjiSlogove
	function vratiUslovZaNadjiSlogove(){ return "1=";}
	
	//Function postaviID
	function postaviID($id){ $this->ID = $this->quote_smart($id);}
	
	//Function napuni 
	function napuni($result_row)
	{
		$this->ID = $result_row->id;
		$this->Vrednost = $result_row->vrednost;
		$this->Code = $result_row->code;
		$this->Class = $result_row->class;
		$this->Status = $result_row->status;
	}
	
	function napuniNiz($result_set, &$al){
	if(count($result_set)>0)
		foreach($result_set as $result_row){
			$odo = $this->ObjectFactory->createObject("SfResource",-1);
			$odo->ID = $result_row->id;
			$odo->Vrednost = $result_row->vrednost;
			$odo->Code = $result_row->code;
			$odo->Class = $result_row->class;
			$odo->Status = $result_row->status;
			array_push($al, $odo);
		}
	}
	
	// Function napuniVisePovezi
	function napuniVisePovezi($result_set, $relation_name)
	{
		switch ($relation_name)
		{
			default: break;
		}
	}
	
	function toArray()
	{
		$arr = array();
		$arr = array_merge($arr, array("id" => $this->getID()));
		$arr = array_merge($arr, array("vrednost" => $this->getVrednost()));
		$arr = array_merge($arr, array("code" => $this->getCode()));
		$arr = array_merge($arr, array("class" => $this->getClass()));
		$arr = array_merge($arr, array("status" => $this->getStatus()));		
		return $arr;
	}

	function getID()
	{
		return $this->ID;
	}
	function getVrednost()
	{
		return $this->Vrednost;
	}
	function getCode()
	{
		return $this->Code;
	}
	function getClass()
	{
		return $this->Class;
	}	
	function getStatus()
	{
		return $this->Status;
	}
	
	function setID($val)
	{
		$this->ID = $val;
	}
	function setVrednost($val)
	{
		$this->Vrednost = $val;
	}
	function setCode($val)
	{
		$this->Code = $val;
	}
	function setClass($val)
	{
		$this->Class = $val;
	}	
	function setStatus($val)
	{
		$this->Status = $val;
	}	
	function getLinkID()
	{
		return 'id='.$this->ID;
	}
}

?>