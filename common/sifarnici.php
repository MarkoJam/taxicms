<?
/* CMS Studio 3.0 sifarnici.php */

class SifarnikBase extends OpstiDomenskiObjekat
{
	public $ID;
	public $Vrednost;

	// PHP Bussines Object constructor
	function __construct()
	{
		parent::__construct();

		$this->ID = 0;
		$this->Vrednost = "";
	}

	// PHP Bussines Object overloaded constructor
	function SifarnikBase_POST($post)
	{
		$this->ID = isset($post["id"]) ? $post["id"] : $this->ID;
		$this->Vrednost = isset($post["vrednost"]) ? $post["vrednost"] : $this->Vrednost;
	}

	// Function vratiImenaAtributa
	function vratiImenaAtributa() {
		return "`id`,`vrednost`";
	}
	// Function vratiImeKlase
	function vratiImeKlase(){return $this->TableName;}

	//Function vratiVrednostAtributa
	function vratiVrednostiAtributa(){ return "'',".$this->quote_smart($this->Vrednost);}

	//Function postaviVrednostiAtributa
	function postaviVrednostiAtributa(){ return "`vrednost`=".$this->quote_smart($this->Vrednost);}

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
	}

	function napuniNiz($result_set, &$al){
	if(count($result_set)>0)
		foreach($result_set as $result_row){
			eval("\$odo = new ".get_class($this)."();");
			$odo->ID = $result_row->id;
			$odo->Vrednost = $result_row->vrednost;
			array_push($al, $odo);
		}
	}

	// Function napuniVisePovezi
	function napuniVisePovezi($result_set, $relation_name){}

	function toArray()
	{
		$arr = array();
		$arr = array_merge($arr, array("id" => $this->getID()));
		$arr = array_merge($arr, array("vrednost" => $this->getVrednost()));
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

	function setID($val)
	{
		$this->ID = $val;
	}
	function setVrednost($val)
	{
		$this->Vrednost = $val;
	}

	function getLinkID()
	{
		return 'id='.$this->ID;
	}
}

class SfStatus extends OpstiDomenskiObjekat
{
	public $StatusID;
	public $Vrednost;

	public $SfTipStatus;

	// PHP Bussines Object constructor
	function __construct()
	{

		parent::__construct();

		$this->SfTipStatus = $this->ObjectFactory->createObject("SfTipStatus",-1);
		$this->SfTipStatus->TipStatusID = -1;

		$this->StatusID = -1;
		$this->Vrednost = "";

		$this->TableName = "sf_status";
		$this->LanguageHelper->ChangeTableName($this->TableName);
	}

	// PHP Bussines Object overloaded constructor
	function SfStatus_POST($post)
	{
		$this->SfTipStatus = $this->ObjectFactory->createObject("SfTipStatus",-1);

		$this->StatusID = isset($post["statusid"]) ? $post["statusid"] : $this->StatusID;
		$this->Vrednost = isset($post["vrednost"]) ? $post["vrednost"] : $this->Vrednost;
		$this->SfTipStatus->TipStatusID = isset($post["tipstatusid"]) ? $post["tipstatusid"] : $this->SfTipStatus->TipStatusID;
	}

	// Function vratiImenaAtributa
	function vratiImenaAtributa() {
		return "`status_id`,`vrednost`,`tip_status_id`";
	}
	// Function vratiImeKlase
	function vratiImeKlase(){return $this->TableName;}

	//Function vratiVrednostAtributa
	function vratiVrednostiAtributa(){ return "'',".$this->quote_smart($this->Vrednost).",".$this->quote_smart($this->SfTipStatus->TipStatusID);}

	//Function postaviVrednostiAtributa
	function postaviVrednostiAtributa(){ return "`vrednost`=".$this->quote_smart($this->Vrednost)."`tip_status_id`=".$this->quote_smart($this->SfTipStatus->TipStatusID);}

	//Function nazivVezeKaRoditelju
	function nazivVezeKaRoditelju(){ return "sfstatus";}

	//Function vratiUslovZaNadjiSlog
	function vratiUslovZaNadjiSlog(){ return "status_id=".$this->quote_smart($this->StatusID);}

	//Function vratiUslovZaSortiranje
	function vratiUslovZaSortiranje(){ return "status_id";}

	//Function vratiUslovZaNadjiSlogF
	function vratiUslovZaNadjiSlogF(){ return "status_id=".$this->quote_smart($this->StatusID);}

	//Function vratiUslovZaNadjiSlogove
	function vratiUslovZaNadjiSlogove(){ return "1=";}

	//Function postaviID
	function postaviID($id){ $this->StatusID = $this->quote_smart($id);}

	//Function napuni
	function napuni($result_row)
	{
		$this->StatusID = $result_row->status_id;
		$this->Vrednost = $result_row->vrednost;
		$this->SfTipStatus->TipStatusID = $result_row->tip_status_id;
	}

	function napuniNiz($result_set, &$al){
	if(count($result_set)>0)
		foreach($result_set as $result_row){
			$odo = $this->ObjectFactory->createObject("SfStatus",-1);
			$odo->StatusID = $result_row->status_id;
			$odo->Vrednost = $result_row->vrednost;
			$odo->SfTipStatus->TipStatusID = $result_row->tip_status_id;
			array_push($al, $odo);
		}
	}

	// Function napuniVisePovezi
	function napuniVisePovezi($result_set, $relation_name){}

	function toArray()
	{
		$arr = array();
		$arr = array_merge($arr, array("statusid" => $this->getStatusID()));
		$arr = array_merge($arr, array("vrednost" => $this->getVrednost()));
		$arr = array_merge($arr, array("tip_status_id" => $this->getSfTipStatus()));
		return $arr;
	}

	function getStatusID()
	{
		return $this->StatusID;
	}

	function getVrednost()
	{
		return $this->Vrednost;
	}

	function getSfTipStatus()
	{
		return $this->SfTipStatus->TipStatusID;
	}

	function setStatusID($val)
	{
		$this->StatusID = $val;
	}
	function setVrednost($val)
	{
		$this->Vrednost = $val;
	}
	function setSfTipStatus($val)
	{
		$this->SfTipStatus->TipStatusID = $val;
	}

	function getLinkID()
	{
		return 'statusid='.$this->StatusID;
	}
}

class SfTipStatus extends OpstiDomenskiObjekat
{
	public $TipStatusID;
	public $TipStatusa;

	// PHP Bussines Object constructor
	function __construct()
	{
		parent::__construct();

		$this->TipStatusID = 0;
		$this->TipStatusa = "";

		$this->TableName = "sf_status";
		$this->LanguageHelper->ChangeTableName($this->TableName);
	}

	// PHP Bussines Object overloaded constructor
	function SfTipStatus_POST($post)
	{
		$this->TipStatusID = isset($post["tipstatusid"]) ? $post["tipstatusid"] : $this->TipStatusID;
		$this->TipStatusa = isset($post["tipstatusa"]) ? $post["tipstatusa"] : $this->TipStatusa;
	}

	// Function vratiImenaAtributa
	function vratiImenaAtributa() {
		return "`tip_status_id`,`tip_statusa`";
	}
	// Function vratiImeKlase
	function vratiImeKlase(){return $this->TableName;}

	//Function vratiVrednostAtributa
	function vratiVrednostiAtributa(){ return "'',".$this->quote_smart($this->TipStatusa);}

	//Function postaviVrednostiAtributa
	function postaviVrednostiAtributa(){ return "`tip_statusa`=".$this->quote_smart($this->TipStatusa);}

	//Function nazivVezeKaRoditelju
	function nazivVezeKaRoditelju(){ return "tipstatus";}

	//Function vratiUslovZaNadjiSlog
	function vratiUslovZaNadjiSlog(){ return "tip_status_id=".$this->quote_smart($this->TipStatusID);}

	//Function vratiUslovZaSortiranje
	function vratiUslovZaSortiranje(){ return "tip_status_id";}

	//Function vratiUslovZaNadjiSlogF
	function vratiUslovZaNadjiSlogF(){ return "tip_status_id=".$this->quote_smart($this->TipStatusID);}

	//Function vratiUslovZaNadjiSlogove
	function vratiUslovZaNadjiSlogove(){ return "1=";}

	//Function postaviID
	function postaviID($id){ $this->TipStatusID = $this->quote_smart($id);}

	//Function napuni
	function napuni($result_row)
	{
		$this->TipStatusID = $result_row->tip_status_id;
		$this->TipStatusa = $result_row->tip_statusa;
	}

	function napuniNiz($result_set, &$al){
	if(count($result_set)>0)
		foreach($result_set as $result_row){
			$odo = $this->ObjectFactory->createObject("TipStatus",-1);
			$odo->TipStatusID = $result_row->tip_status_id;
			$odo->TipStatusa = $result_row->tip_statusa;
			array_push($al, $odo);
		}
	}

	// Function napuniVisePovezi
	function napuniVisePovezi($result_set, $relation_name){}

	function toArray()
	{
		$arr = array();
		$arr = array_merge($arr, array("tipstatusid" => $this->getTipStatusID()));
		$arr = array_merge($arr, array("tipstatusa" => $this->getTipStatusa()));
		return $arr;
	}

	function getTipStatusID()
	{
		return $this->TipStatusID;
	}
	function getTipStatusa()
	{
		return $this->TipStatusa;
	}

	function setTipStatusID($val)
	{
		$this->TipStatusID = $val;
	}
	function setTipStatusa($val)
	{
		$this->TipStatusa = $val;
	}

	function getLinkID()
	{
		return 'tipstatusid='.$this->TipStatusID;
	}
}

class SfPageType extends SifarnikBase
{
	public $PageTypeID;

	function __construct()
	{
		parent::__construct();

		$this->setPageTypeID(-1);

		$this->TableName = "sf_page_type";
		$this->LanguageHelper->ChangeTableName($this->TableName);
	}

	function nazivVezeKaRoditelju(){ return "sfpagetype";}

	function getPageTypeID()
	{
		return $this->ID;
	}

	function setPageTypeID($var)
	{
		$this->ID = $var;
	}
}

class SfPageProtection extends SifarnikBase
{
	private $PageProtectionID;

	function __construct()
	{
		parent::__construct();

		$this->setPageProtectionID(-1);

		$this->TableName = "sf_page_protection";
		$this->LanguageHelper->ChangeTableName($this->TableName);
	}

	function nazivVezeKaRoditelju(){ return "sfpageprotection";}

	function getPageProtectionID()
	{
		return $this->ID;
	}

	function setPageProtectionID($var)
	{
		$this->ID = $var;
	}
}

class SfPluginModule extends OpstiDomenskiObjekat
{
	public $ID;
	public $Vrednost;
	public $Code;

	//Bussiness PHP Object constructor
	function __construct()
	{
		parent::__construct();

		$this->ID = 0;
		$this->Vrednost = "";
		$this->Code = "";

		$this->TableName= "sf_plugin_module";
		$this->LanguageHelper->ChangeTableName($this->TableName);
	}

	// PHP Bussines Object overloaded constructor
	function SfPluginModule_POST($post)
	{
		$this->ID = isset($post["id"]) ? $post["id"] : $this->ID;
		$this->Vrednost = isset($post["vrednost"]) ? $post["vrednost"] : $this->Vrednost;
		$this->Code = isset($post["code"]) ? $post["code"] : $this->Code;
	}

	// Function vratiImenaAtributa
	function vratiImenaAtributa() {
		return "`id`,`vrednost`,`code`";
	}
	// Function vratiImeKlase
	function vratiImeKlase(){return $this->TableName;}

	//Function vratiVrednostAtributa
	function vratiVrednostiAtributa(){ return "'',".$this->quote_smart($this->Vrednost).",".$this->quote_smart($this->Code);}

	//Function postaviVrednostiAtributa
	function postaviVrednostiAtributa(){ return "`vrednost`=".$this->quote_smart($this->Vrednost).",`code`=".$this->quote_smart($this->Code);}

	//Function nazivVezeKaRoditelju
	function nazivVezeKaRoditelju(){ return "sfpluginmodule";}

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
	}

	function napuniNiz($result_set, &$al){
	if(count($result_set)>0)
		foreach($result_set as $result_row){
			$odo = $this->ObjectFactory->createObject("SfPluginModule",-1);
			$odo->ID = $result_row->id;
			$odo->Vrednost = $result_row->vrednost;
			$odo->Code = $result_row->code;
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

	function getLinkID()
	{
		return 'id='.$this->ID;
	}
}


class SfPluginType extends OpstiDomenskiObjekat
{
	public $ID;
	public $Code;
	public $Vrednost;

	//Bussiness PHP Object constructor
	function __construct()
	{
		parent::__construct();

		$this->ID = 0;
		$this->Code = "";
		$this->Vrednost = "";

		$this->TableName= "sf_plugin_type";
		$this->LanguageHelper->ChangeTableName($this->TableName);
	}

	// PHP Bussines Object overloaded constructor
	function SfPluginModule_POST($post)
	{
		$this->ID = isset($post["id"]) ? $post["id"] : $this->ID;
		$this->Code = isset($post["code"]) ? $post["code"] : $this->Code;
		$this->Vrednost = isset($post["vrednost"]) ? $post["vrednost"] : $this->Vrednost;
	}

	// Function vratiImenaAtributa
	function vratiImenaAtributa() {
		return "`id`,`code`,`vrednost`";
	}
	// Function vratiImeKlase
	function vratiImeKlase(){return $this->TableName;}

	//Function vratiVrednostAtributa
	function vratiVrednostiAtributa(){ return "'',
	".$this->quote_smart($this->Code).",
	".$this->quote_smart($this->Vrednost);}

	//Function postaviVrednostiAtributa
	function postaviVrednostiAtributa(){ return "
	`code`=".$this->quote_smart($this->Code).",
	`vrednost`=".$this->quote_smart($this->Vrednost);}

	//Function nazivVezeKaRoditelju
	function nazivVezeKaRoditelju(){ return "sfplugintype";}

	//Function vratiUslovZaNadjiSlog
	function vratiUslovZaNadjiSlog(){ return "code=".$this->quote_smart($this->Code);}

	//Function vratiUslovZaSortiranje
	function vratiUslovZaSortiranje(){ return "id";}

	//Function vratiUslovZaNadjiSlogF
	function vratiUslovZaNadjiSlogF(){ return "code=".$this->quote_smart($this->Code);}

	//Function vratiUslovZaNadjiSlogove
	function vratiUslovZaNadjiSlogove(){ return "1=";}

	//Function postaviID
	function postaviID($id){ $this->ID = $this->quote_smart($id);}

	//Function napuni
	function napuni($result_row)
	{
		$this->ID = $result_row->id;
		$this->Code = $result_row->code;
		$this->Vrednost = $result_row->vrednost;
	}

	function napuniNiz($result_set, &$al){
	if($this->count($result_set)>0)
		foreach($result_set as $result_row){
			$odo = $this->ObjectFactory->createObject("SfPluginModule",-1);
			$odo->ID = $result_row->id;
			$odo->Code = $result_row->code;
			$odo->Vrednost = $result_row->vrednost;
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
		$arr = array_merge($arr, array("code" => $this->getCode()));
		$arr = array_merge($arr, array("vrednost" => $this->getVrednost()));
		return $arr;
	}

	function getID()
	{
		return $this->ID;
	}
	function getCode()
	{
		return $this->Code;
	}
	function getVrednost()
	{
		return $this->Vrednost;
	}

	function setID($val)
	{
		$this->ID = $val;
	}
	function setCode($val)
	{
		$this->Code = $val;
	}
	function setVrednost($val)
	{
		$this->Vrednost = $val;
	}

	function getLinkID()
	{
		return 'id='.$this->ID;
	}
}



class SfUserType extends SifarnikBase
{
	function __construct()
	{
		parent::__construct();

		$this->setUserTypeID(-1);

		$this->TableName = "sf_user_type";
		$this->LanguageHelper->ChangeTableName($this->TableName);
	}

	function nazivVezeKaRoditelju(){ return "sfusertype";}

	function getUserTypeID()
	{
		return $this->ID;
	}

	function setUserTypeID($var)
	{
		$this->ID = $var;
	}
}

class SfUserCategory extends SifarnikBase
{
	function __construct()
	{
		parent::__construct();

		$this->setUserCategoryID(-1);

		$this->TableName = "sf_user_category";
		$this->LanguageHelper->ChangeTableName($this->TableName);
	}

	function nazivVezeKaRoditelju(){ return "sfusercategory";}

	function getUserCategoryID()
	{
		return $this->ID;
	}

	function setUserCategoryID($var)
	{
		$this->ID = $var;
	}
}


class SfOrderType extends SifarnikBase
{
	public $OrderTypeID;

	function __construct()
	{
		parent::__construct();

		$this->setOrderTypeID(-1);

		$this->TableName = "sf_order_type";
		$this->LanguageHelper->ChangeTableName($this->TableName);
	}

	function nazivVezeKaRoditelju(){ return "sfordertype";}

	function getOrderTypeID()
	{
		return $this->ID;
	}

	function setOrderTypeID($var)
	{
		$this->ID = $var;
	}
}

// class sf_countries
class SfCountries extends OpstiDomenskiObjekat
{
	public $CountryID;
	public $Vrednost;


	// PHP Bussines Object constructor
	function __construct()
	{

		parent::__construct();

		$this->CountryID = -1;
		$this->Vrednost = "";

		$this->TableName = "sf_country";
		$this->LanguageHelper->ChangeTableName($this->TableName);
	}

	// PHP Bussines Object overloaded constructor
	function SfCountries_POST($post)
	{

		$this->CountryID = isset($post["countryid"]) ? $post["countryid"] : $this->CountryID;
		$this->Vrednost = isset($post["vrednost"]) ? $post["vrednost"] : $this->Vrednost;
	}

	// Function vratiImenaAtributa
	function vratiImenaAtributa() {
		return "`country_id`,`vrednost``";
	}
	// Function vratiImeKlase
	function vratiImeKlase(){return $this->TableName;}

	//Function vratiVrednostAtributa
	function vratiVrednostiAtributa(){ return "'',".$this->quote_smart($this->Vrednost);}

	//Function postaviVrednostiAtributa
	function postaviVrednostiAtributa(){ return "`vrednost`=".$this->quote_smart($this->Vrednost);}

	//Function nazivVezeKaRoditelju
	function nazivVezeKaRoditelju(){ return "sfcountries";}

	//Function vratiUslovZaNadjiSlog
	function vratiUslovZaNadjiSlog(){ return "country_id=".$this->quote_smart($this->CountryID);}

	//Function vratiUslovZaSortiranje
	function vratiUslovZaSortiranje(){ return "country_id";}

	//Function vratiUslovZaNadjiSlogF
	function vratiUslovZaNadjiSlogF(){ return "country_id=".$this->quote_smart($this->CountryID);}

	//Function vratiUslovZaNadjiSlogove
	function vratiUslovZaNadjiSlogove(){ return "1=";}

	//Function postaviID
	function postaviID($id){ $this->CountryID = $this->quote_smart($id);}

	//Function napuni
	function napuni($result_row)
	{
		$this->CountryID = $result_row->country_id;
		$this->Vrednost = $result_row->vrednost;
	}

	function napuniNiz($result_set, &$al){
	if(count($result_set)>0)
		foreach($result_set as $result_row){
			$odo = $this->ObjectFactory->createObject("SfCountries",-1);
			$odo->CountryID = $result_row->country_id;
			$odo->Vrednost = $result_row->vrednost;
			array_push($al, $odo);
		}
	}

	// Function napuniVisePovezi
	function napuniVisePovezi($result_set, $relation_name){}

	function toArray()
	{
		$arr = array();
		$arr = array_merge($arr, array("countryid" => $this->getCountryID()));
		$arr = array_merge($arr, array("vrednost" => $this->getVrednost()));
		return $arr;
	}

	function getCountryID()
	{
		return $this->CountryID;
	}

	function getVrednost()
	{
		return $this->Vrednost;
	}

	function setCountryID($val)
	{
		$this->CountryID = $val;
	}
	function setVrednost($val)
	{
		$this->Vrednost = $val;
	}

	function getLinkID()
	{
		return 'countryid='.$this->CountryID;
	}
}
// Settigns Sf classes

class SfSettingCover extends OpstiDomenskiObjekat
{
	private $SettingCoverID;
	private $Value;

	//Bussiness PHP Object constructor
	function __construct()
	{
		parent::__construct();

		$this->SettingCoverID = -1;
		$this->Value = "";

		$this->TableName= "sf_setting_cover";
		$this->LanguageHelper->ChangeTableName($this->TableName);
	}

	// PHP Bussines Object overloaded constructor
	function SfSettingCover_POST($post)
	{
		$this->setSettingCoverID(isset($post["settingcoverid"]) ? $post["settingcoverid"] : $this->getSettingCoverID());
		$this->setValue(isset($post["value"]) ? $post["value"] : $this->getValue());
	}

	// Function vratiImenaAtributa
	function vratiImenaAtributa() {
		return "`setting_cover_id`,`value`";
	}
	// Function vratiImeKlase
	function vratiImeKlase(){return $this->TableName;}

	//Function vratiVrednostAtributa
	function vratiVrednostiAtributa(){ return "'',".$this->quote_smart($this->getValue());}

	//Function postaviVrednostiAtributa
	function postaviVrednostiAtributa(){ return "`value`=".$this->quote_smart($this->getValue());}

	//Function nazivVezeKaRoditelju
	function nazivVezeKaRoditelju(){ return "sfsettingcover";}

	//Function vratiUslovZaNadjiSlog
	function vratiUslovZaNadjiSlog(){ return "setting_cover_id=".$this->quote_smart($this->getSettingCoverID());}

	//Function vratiUslovZaSortiranje
	function vratiUslovZaSortiranje(){ return "setting_cover_id";}

	//Function vratiUslovZaNadjiSlogF
	function vratiUslovZaNadjiSlogF(){ return "setting_cover_id=".$this->quote_smart($this->getSettingCoverID());}

	//Function vratiUslovZaNadjiSlogove
	function vratiUslovZaNadjiSlogove(){ return "1=";}

	//Function postaviID
	function postaviID($id){ $this->setSettingCoverID($this->quote_smart($id));}

	//Function napuni
	function napuni($result_row)
	{
		$this->SettingCoverID = $result_row->setting_cover_id;
		$this->Value = $result_row->value;
	}

	function napuniNiz($result_set, &$al){
	if(count($result_set)>0)
		foreach($result_set as $result_row){
			$odo = new SfSettingCover();
			$odo->setSettingCoverID($result_row->setting_cover_id);
			$odo->setValue($result_row->value);
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
			$arr = array_merge($arr, array("settingcoverid" => $this->getSettingCoverID()));
			$arr = array_merge($arr, array("value" => $this->getValue()));
		return $arr;
	}

	function getSettingCoverID()
	{
		return $this->SettingCoverID;
	}
	function getValue()
	{
		return $this->Value;
	}

	function setSettingCoverID($val)
	{
		$this->SettingCoverID = $val;
	}
	function setValue($val)
	{
		$this->Value = $val;
	}

	function getLinkID()
	{
		return 'settingcoverid='.$this->SettingCoverID;
	}
}

class SfSettingGroup extends OpstiDomenskiObjekat
{
	public $SettingGroupID;
	private $Value;

	//Bussiness PHP Object constructor
	function __construct()
	{
		parent::__construct();

		$this->SettingGroupID = -1;
		$this->Value = "";

		$this->TableName= "sf_setting_group";
		$this->LanguageHelper->ChangeTableName($this->TableName);
	}

	// PHP Bussines Object overloaded constructor
	function SfSettingGroup_POST($post)
	{
		$this->setSettingGroupID(isset($post["settinggroupid"]) ? $post["settinggroupid"] : $this->getSettingGroupID());
		$this->setValue(isset($post["value"]) ? $post["value"] : $this->getValue());
	}

	// Function vratiImenaAtributa
	function vratiImenaAtributa() {
		return "`setting_group_id`,`value`";
	}
	// Function vratiImeKlase
	function vratiImeKlase(){return $this->TableName;}

	//Function vratiVrednostAtributa
	function vratiVrednostiAtributa(){ return "'',".$this->quote_smart($this->getValue());}

	//Function postaviVrednostiAtributa
	function postaviVrednostiAtributa(){ return "`value`=".$this->quote_smart($this->getValue());}

	//Function nazivVezeKaRoditelju
	function nazivVezeKaRoditelju(){ return "sfsettinggroup";}

	//Function vratiUslovZaNadjiSlog
	function vratiUslovZaNadjiSlog(){ return "setting_group_id=".$this->quote_smart($this->getSettingGroupID());}

	//Function vratiUslovZaSortiranje
	function vratiUslovZaSortiranje(){ return "setting_group_id";}

	//Function vratiUslovZaNadjiSlogF
	function vratiUslovZaNadjiSlogF(){ return "setting_group_id=".$this->quote_smart($this->getSettingGroupID());}

	//Function vratiUslovZaNadjiSlogove
	function vratiUslovZaNadjiSlogove(){ return "1=";}

	//Function postaviID
	function postaviID($id){ $this->setSettingGroupID($this->quote_smart($id));}

	//Function napuni
	function napuni($result_row)
	{
		$this->SettingGroupID = $result_row->setting_group_id;
		$this->Value = $result_row->value;
	}

	function napuniNiz($result_set, &$al){
	if(count($result_set)>0)
		foreach($result_set as $result_row){
			$odo = new SfSettingGroup();
			$odo->setSettingGroupID($result_row->setting_group_id);
			$odo->setValue($result_row->value);
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
			$arr = array_merge($arr, array("settinggroupid" => $this->getSettingGroupID()));
			$arr = array_merge($arr, array("value" => $this->getValue()));
		return $arr;
	}

	function getSettingGroupID()
	{
		return $this->SettingGroupID;
	}
	function getValue()
	{
		return $this->Value;
	}

	function setSettingGroupID($val)
	{
		$this->SettingGroupID = $val;
	}
	function setValue($val)
	{
		$this->Value = $val;
	}

	function getLinkID()
	{
		return 'settinggroupid='.$this->SettingGroupID;
	}
}


class SfSettingType extends OpstiDomenskiObjekat
{
	private $SettingTypeID;
	private $Value;

	//Bussiness PHP Object constructor
	function __construct()
	{
		parent::__construct();

		$this->SettingTypeID = 0;
		$this->Value = "";

		$this->TableName= "sf_setting_type";
		$this->LanguageHelper->ChangeTableName($this->TableName);
	}

	// PHP Bussines Object overloaded constructor
	function SfSettingType_POST($post)
	{
		$this->setSettingTypeID(isset($post["settingtypeid"]) ? $post["settingtypeid"] : $this->getSettingTypeID());
		$this->setValue(isset($post["value"]) ? $post["value"] : $this->getValue());
	}

	// Function vratiImenaAtributa
	function vratiImenaAtributa() {
		return "`setting_type_id`,`value`";
	}
	// Function vratiImeKlase
	function vratiImeKlase(){return $this->TableName;}

	//Function vratiVrednostAtributa
	function vratiVrednostiAtributa(){ return "'',".$this->quote_smart($this->getValue());}

	//Function postaviVrednostiAtributa
	function postaviVrednostiAtributa(){ return "`value`=".$this->quote_smart($this->getValue());}

	//Function nazivVezeKaRoditelju
	function nazivVezeKaRoditelju(){ return "sfsettingtype";}

	//Function vratiUslovZaNadjiSlog
	function vratiUslovZaNadjiSlog(){ return "setting_type_id=".$this->quote_smart($this->getSettingTypeID());}

	//Function vratiUslovZaSortiranje
	function vratiUslovZaSortiranje(){ return "setting_type_id";}

	//Function vratiUslovZaNadjiSlogF
	function vratiUslovZaNadjiSlogF(){ return "setting_type_id=".$this->quote_smart($this->getSettingTypeID());}

	//Function vratiUslovZaNadjiSlogove
	function vratiUslovZaNadjiSlogove(){ return "1=";}

	//Function postaviID
	function postaviID($id){ $this->setSettingTypeID($this->quote_smart($id));}

	//Function napuni
	function napuni($result_row)
	{
		$this->SettingTypeID = $result_row->setting_type_id;
		$this->Value = $result_row->value;
	}

	function napuniNiz($result_set, &$al){
	if(count($result_set)>0)
		foreach($result_set as $result_row){
			$odo = new SfSettingType();
			$odo->setSettingTypeID($result_row->setting_type_id);
			$odo->setValue($result_row->value);
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
			$arr = array_merge($arr, array("settingtypeid" => $this->getSettingTypeID()));
			$arr = array_merge($arr, array("value" => $this->getValue()));
		return $arr;
	}

	function getSettingTypeID()
	{
		return $this->SettingTypeID;
	}
	function getValue()
	{
		return $this->Value;
	}

	function setSettingTypeID($val)
	{
		if($val != "")
		{
			$this->SettingTypeID = $val;
		}
		else
		{
			$this->SettingTypeID = -1;
		}
	}
	function setValue($val)
	{
		$this->Value = $val;
	}

	function getLinkID()
	{
		return 'settingtypeid='.$this->SettingTypeID;
	}
}


class SfSettingTypeValues extends OpstiDomenskiObjekat
{
	private $SettingTypeValuesID;
	private $Value;
	private $SettingType;

	//Bussiness PHP Object constructor
	function __construct()
	{
		parent::__construct();

		$this->SfSettingType = $this->ObjectFactory->createObject("SfSettingType",-1);
		$this->setSettingTypeValuesID(-1);
		$this->Value = "";
		$this->SfSettingType->setSettingTypeID(-1);

		$this->TableName= "sf_setting_type_values";
		$this->LanguageHelper->ChangeTableName($this->TableName);
	}

	// PHP Bussines Object overloaded constructor
	function SfSettingTypeValues_POST($post)
	{
		$this->SfSettingType = new SfSettingType();
		$this->setSettingTypeValuesID(isset($post["settingtypevaluesid"]) ? $post["settingtypevaluesid"] : $this->getSettingTypeValuesID());
		$this->setValue(isset($post["value"]) ? $post["value"] : $this->getValue());
		$this->SfSettingType->setSettingTypeID(isset($post["settingtypeid"]) ? $post["settingtypeid"] : $this->SfSettingType->getSettingTypeID());
	}

	// Function vratiImenaAtributa
	function vratiImenaAtributa() {
		return "`setting_type_values_id`,`value`,`setting_type_id`";
	}
	// Function vratiImeKlase
	function vratiImeKlase(){return $this->TableName;}

	//Function vratiVrednostAtributa
	function vratiVrednostiAtributa(){ return "'',".$this->quote_smart($this->getValue()).",".$this->quote_smart($this->SfSettingType->getSettingTypeID());}

	//Function postaviVrednostiAtributa
	function postaviVrednostiAtributa(){ return "`value`=".$this->quote_smart($this->getValue()).",`setting_type_id`=".$this->quote_smart($this->SfSettingType->getSettingTypeID());}

	//Function nazivVezeKaRoditelju
	function nazivVezeKaRoditelju(){ return "sfsettingtypevalues";}

	//Function vratiUslovZaNadjiSlog
	function vratiUslovZaNadjiSlog(){ return "setting_type_values_id=".$this->quote_smart($this->getSettingTypeValuesID());}

	//Function vratiUslovZaSortiranje
	function vratiUslovZaSortiranje(){ return "setting_type_values_id";}

	//Function vratiUslovZaNadjiSlogF
	function vratiUslovZaNadjiSlogF(){ return "setting_type_values_id=".$this->quote_smart($this->getSettingTypeValuesID());}

	//Function vratiUslovZaNadjiSlogove
	function vratiUslovZaNadjiSlogove(){ return "1=";}

	//Function postaviID
	function postaviID($id){ $this->setSettingTypeValuesID($this->quote_smart($id));}

	//Function napuni
	function napuni($result_row)
	{
		$this->SettingTypeValuesID = $result_row->setting_type_values_id;
		$this->Value = $result_row->value;
		$this->SfSettingType->SettingTypeID = $result_row->setting_type_id;
	}

	function napuniNiz($result_set, &$al){
	if(count($result_set)>0)
		foreach($result_set as $result_row)
		{
			$odo = new SfSettingTypeValues();
			$odo->setSettingTypeValuesID($result_row->setting_type_values_id);
			$odo->setValue($result_row->value);
			$odo->SfSettingType->setSettingTypeID($result_row->setting_type_id);
			array_push($al, $odo);
		}
	}

	// Function napuniVisePovezi
	function napuniVisePovezi($result_set, $relation_name)
	{
		switch ($relation_name)
		{
			case "sfsettingtype":
				if(count($result_set)>0) $this->SfSettingType->napuni($result_set);
				break;
			default: break;
		}
	}

	function toArray()
	{
		$arr = array();
			$arr = array_merge($arr, array("settingtypevaluesid" => $this->getSettingTypeValuesID()));
			$arr = array_merge($arr, array("value" => $this->getValue()));
			$arr = array_merge($arr, array("settingtypeid" => $this->getSfSettingType->SettingTypeID()));
		return $arr;
	}

	function getSettingTypeValuesID()
	{
		return $this->SettingTypeValuesID;
	}
	function getValue()
	{
		return $this->Value;
	}
	function getSettingTypeID()
	{
		return $this->SfSettingType->SettingTypeID;
	}

	function setSettingTypeValuesID($val)
	{
		$this->SettingTypeValuesID = $val;
	}
	function setValue($val)
	{
		$this->Value = $val;
	}
	function setSettingTypeID($val)
	{
		$this->SfSettingType->SettingTypeID = $val;
	}

	function getLinkID()
	{
		return 'settingtypevaluesid='.$this->SettingTypeValuesID;
	}
}



?>
