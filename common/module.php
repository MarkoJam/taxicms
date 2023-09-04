<?

/* CMS Studio 3.0 module.php secured */

class ModuleCategory extends OpstiDomenskiObjekat
{
	 public $ModuleCategoryID;
	 public $Title;
	 public $MessageNum;
	 public $Status;
	 public $Module;

	//Bussiness PHP Object constructor
	function __construct()
	{
		parent::__construct();

		$this->ModuleCategoryID = -1;
		$this->Title = "";
		$this->MessageNum = 0;
		$this->Module = array();

		$this->TableName= "modulecategory";
		$this->LanguageHelper->ChangeTableName($this->TableName);
	}

	// fill ModuleCategory from POST
	function ModuleCategory_POST($post)
	{
		$this->ModuleCategoryID = isset($post["modulecategoryid"]) ? $post["modulecategoryid"] : -1;
		$this->Title = isset($post["title"]) ? $post["title"] : -1;
		$this->MessageNum = isset($post["messagenum"]) ? $post["messagenum"] : -1;
		$this->Status = isset($post["status"]) ? $post["status"] : -1;
		$this->Module = array();
	}

	// DatabaseBroker functions
	function vratiImenaAtributa() {return "`modulecategoryid`,`title`,`messagenum`,`status`";}
	function vratiImeKlase(){return $this->TableName;}
	function vratiVrednostiAtributa(){ return "'',".$this->quote_smart($this->Title).",".$this->quote_smart($this->MessageNum).",".$this->quote_smart($this->Status);}
	function postaviVrednostiAtributa(){ return "`title` = ".$this->quote_smart($this->Title).",`messagenum` = ".$this->quote_smart($this->MessageNum).",`status` = ".$this->quote_smart($this->Status);}
	function nazivVezeKaRoditelju(){ return "modulecategory";}
	function vratiUslovZaNadjiSlog(){ return "modulecategoryid=".$this->quote_smart($this->ModuleCategoryID);}
	function vratiUslovZaSortiranje(){ return "modulecategoryid";}
	function vratiUslovZaNadjiSlogF(){ return "module_category_id=".$this->quote_smart($this->ModuleCategoryID);}
	function vratiUslovZaNadjiSlogove(){ return "1=";}
	function postaviID($id){ $this->ModuleCategoryID = $id;}
	function napuni($result_row)
	{
		$this->ModuleCategoryID = $result_row->modulecategoryid;
		$this->Title = $result_row->title;
		$this->MessageNum = $result_row->messagenum;
		$this->Status = $result_row->status;
	}
	function napuniNiz($result_set, &$al){
		if($this->count($result_set)>0)
			foreach($result_set as $result_row){
				$modulecateg = $this->ObjectFactory->createObject("ModuleCategory",-1);
				$modulecateg->ModuleCategoryID = $result_row->modulecategoryid;
				$modulecateg->Title = $result_row->title;
				$modulecateg->MessageNum = $result_row->messagenum;
				$modulecateg->Status = $result_row->status;
				array_push($al, $modulecateg);
			}
	}

	function vratiImeVezneTabele($relation_class_name,& $vezna_klasa, & $uslov_join)
	{
		$module = $this->LanguageHelper->ChangeTableNameR("module");
		$moduleModuleCategory = $this->LanguageHelper->ChangeTableNameR("modulemodulecategory");

		switch ($relation_class_name)
		{
			case $module:
				$vezna_klasa = $moduleModuleCategory;
				$uslov_join = "IJ1.module_id= IJ2.module_id";
				break;
			default: $vezna_klasa = "";
			break;
		}
	}

	function napuniVisePovezi($result_set, $relation_name)
	{
		switch ($relation_name)
		{
			case "module":
				if($this->count($result_set)>0)
				foreach($result_set as $db_res)
				{
					$amodule= $this->ObjectFactory->createObject("Module",-1);
					$amodule->napuni($db_res);
					array_push($this->Module,$amodule);
				}
			break;
			default: break;
		}
	}

	function toArray()
	{
		$arr = array();
			$arr = array_merge($arr, array("modulecategoryid" => $this->getModuleCategoryID()));
			$arr = array_merge($arr, array("title" => $this->getTitle()));
			$arr = array_merge($arr, array("messagenum" => $this->getMessageNum()));
			$arr = array_merge($arr, array("status" => $this->getStatus()));
		return $arr;
	}

	// getter and setter
	function getModuleCategoryID()
	{
		return $this->ModuleCategoryID;
	}

	function getTitleUnchanged()
	{
		return $this->Title;
	}
	function getTitle()
	{
		return $this->LanguageHelper->Transliterate($this->Title);
	}
	function getMessageNum()
	{
		return $this->MessageNum;
	}
	function getStatus()
	{
		return $this->Status;
	}

	function setModuleCategoryID($val)
	{
		$this->ModuleCategoryID = $val;
	}
	function setTitle($val)
	{
		$this->Title = $val;
	}
	function setMessageNum($val)
	{
		$this->MessageNum = $val;
	}
	function setStatus($val)
	{
		$this->Status = $val;
	}

	function getLinkID()
	{
		return 'modulecategoryid='.$this->Modulecategoryid;
	}

	// podesavanje za pluginove
	function vratiIDKategorijeZaPlugin(){

		return $this->ModuleCategoryID;
	}

	function vratiNazivKategorijeZaPlugin(){
		return $this->Title;
	}

	function postaviIDKategorijeZaPlugin($id){
		$this->ModuleCategoryID = $id;
	}
}

class ModuleType extends OpstiDomenskiObjekat
{
	private $ModuleTypeID;
	private $Title;
	private $Description;
	private $Module;

	//Bussiness PHP Object constructor
	function __construct()
	{
		parent::__construct();

		$this->ModuleTypeID = -1;
		$this->Title = "";
		$this->Description = 0;
		$this->Module = array();

		$this->TableName= "moduletype";
		$this->LanguageHelper->ChangeTableName($this->TableName);
	}

	// fill ModuleType from POST
	function ModuleType_POST($post)
	{
		$this->ModuleTypeID = isset($post["module_type_id"]) ? $post["module_type_id"] : -1;
		$this->Title = isset($post["title"]) ? $post["title"] : -1;
		$this->Description = isset($post["description"]) ? $post["description"] : -1;
		$this->Module = array();
	}

	// DatabaseBroker functions
	function vratiImenaAtributa() {
		return "`module_type_id`,`title`,`description`";
	}
	function vratiImeKlase(){
		return $this->TableName;
	}
	function vratiVrednostiAtributa(){
		return "'',".$this->quote_smart($this->Title).",".$this->quote_smart($this->Description);
	}
	function postaviVrednostiAtributa(){
		return "`title` = ".$this->quote_smart($this->Title).",`description` = ".$this->quote_smart($this->Description);
	}
	function nazivVezeKaRoditelju(){
		return "moduletype";
	}
	function vratiUslovZaNadjiSlog(){
		return "module_type_id=".$this->quote_smart($this->ModuleTypeID);
	}
	function vratiUslovZaSortiranje(){
		return "module_type_id";
	}
	function vratiUslovZaNadjiSlogF(){
		return "module_type_id=".$this->quote_smart($this->ModuleTypeID);
	}
	function vratiUslovZaNadjiSlogove(){
		return "1=";
	}
	function postaviID($id){
		$this->ModuleTypeID = $id;
	}
	function napuni($result_row)
	{
		$this->ModuleTypeID = $result_row->module_type_id;
		$this->Title = $result_row->title;
		$this->Description = $result_row->description;
	}
	function napuniNiz($result_set, &$al){
		if($this->count($result_set)>0)
			foreach($result_set as $result_row){
			$modulecateg = $this->ObjectFactory->createObject("ModuleType",-1);
			$modulecateg->ModuleTypeID = $result_row->module_type_id;
			$modulecateg->Title = $result_row->title;
			$modulecateg->Description = $result_row->description;
			array_push($al, $modulecateg);
		}
	}

	function napuniVisePovezi($result_set, $relation_name)
	{
		switch ($relation_name)
		{
			case "module":
				if($this->count($result_set)>0)
					foreach($result_set as $db_res)
					{
						$amodule= $this->ObjectFactory->createObject("Module",-1);
						$amodule->napuni($db_res);
						array_push($this->Module,$amodule);
					}
					break;
			default: break;
		}
	}

	function toArray()
	{
		$arr = array();
		$arr = array_merge($arr, array("moduletypeid" => $this->getModuleTypeID()));
		$arr = array_merge($arr, array("title" => $this->getTitle()));
		$arr = array_merge($arr, array("description" => $this->getDescription()));
		return $arr;
	}

	// getter and setter
	function getModuleTypeID()
	{
		return $this->ModuleTypeID;
	}

	function getTitleUnchanged()
	{
		return $this->Title;
	}
	function getTitle()
	{
		return $this->LanguageHelper->Transliterate($this->Title);
	}
	function getDescription()
	{
		return $this->Description;
	}

	function setModuleTypeID($val)
	{
		$this->ModuleTypeID = $val;
	}
	function setTitle($val)
	{
		$this->Title = $val;
	}
	function setDescription($val)
	{
		$this->Description= $val;
	}

	function getLinkID()
	{
		return 'moduletypeid='.$this->ModuleTypeID;
	}

	// podesavanje za pluginove
	function vratiIDKategorijeZaPlugin(){

		return $this->ModuleTypeID;
	}

	function vratiNazivKategorijeZaPlugin(){
		return $this->Title;
	}

	function postaviIDKategorijeZaPlugin($id){
		$this->ModuleTypeID = $id;
	}
}

class Module extends OpstiDomenskiObjekat
{
	public $ModuleID;
	public $Keywords;
	public $Header;
	private $ShortHtml;
	public $Html;
	private $PublishingDate;
	private $Date;
    private $Duration;
	public $SfStatus;
	public $ModuleType;
	public $IsMonthly;

	public $ModuleCategory; // array

    private $Slika;
    private $SlikaThumb;
    private $Place;
    private $Link;

	private $CreatedBy;
	private	$ModifiedBy;
	private $CreatedDate;
	private $ModifiedDate;

	//Bussiness PHP Object constructor
    function __construct()
    {
    	parent::__construct();

    	$this->ModuleID = -1;
		$this->Keywords = "";
		$this->Header = "";
		$this->ShortHtml;
		$this->Html = "";
		$this->PublishingDate = time();
		$this->Date = time();
        $this->Duration = 1;

        $this->Slika = "";
        $this->SlikaThumb = "";
        $this->Place = "";
        $this->Link = "";

		$this->CreatedBy = "";
		$this->ModifiedBy = "";
		$this->CreatedDate = time();
		$this->ModifiedDate = time();

		$this->SfStatus = $this->ObjectFactory->createObject("SfStatus",-1);
		$this->ModuleType = $this->ObjectFactory->createObject("ModuleType",-1);
		$this->ModuleType->setModuleTypeID(-1);
		$this->IsMonthly = 0;
		$this->ModuleCategory = array();

		$this->TableName= "module";
		$this->LanguageHelper->ChangeTableName($this->TableName);
    }

    // fill Module from POST
    function Module_POST($post)
    {
    	$this->SfStatus = $this->ObjectFactory->createObject("SfStatus",-1);

    	$this->ModuleID = isset($post["module_id"]) ? $post["module_id"] : -1;
		$this->Keywords = isset($post["keywords"]) ? $post["keywords"] : "";
		$this->Header = isset($post["header"]) ? $post["header"] : "";
		$this->ShortHtml = isset($post["shorthtml"]) ? $post["shorthtml"] : "";
		$this->Html = isset($post["html"]) ? $post["html"] : "";
		$this->PublishingDate = isset($post["publishingdate"]) ? $post["publishingdate"] :time();
		$this->Date = isset($post["date"]) ? $post["date"] :time();
        $this->Duration = isset($post["duration"]) ? $post["duration"] : 1;
		$this->IsMonthly = isset($post["ismonthly"]) ? ($post["ismonthly"] == "on" ? 1 : 0) : 0;
        $this->Slika = isset($post["slika"]) ? $post["slika"] : "";
        $this->SlikaThumb = isset($post["slikathumb"]) ? $post["slikathumb"] : "";
        $this->Place = isset($post["place"]) ? $post["place"] : "";
        $this->Link = isset($post["link"]) ? $post["link"] : "";

		$this->SfStatus->setStatusID(isset($post["statusid"])? $post["statusid"] : $this->SfStatus->getStatusID());
		$this->ModuleType = $this->ObjectFactory->createObject("ModuleType",-1);
		$this->ModuleType->setModuleTypeID(isset($post["moduletypeid"]) ? $post["moduletypeid"] : -1);

		$this->ModuleCategory = array();
    }

    // DatabaseBroker functions
    function vratiImenaAtributa() {return "`module_id` , `keywords` , `header` , `shorthtml`, `html` ,`publishing_date`, `date`, `duration`,`is_monthly`,`slika`,`slika_thumb`,`place`,`link`, `status_id`,`module_type_id`,`created_by`,`created_date`,`modified_by`,`modified_date`";}
    function vratiImeKlase(){return $this->TableName;}
	function vratiVrednostiAtributa(){
		return
		"'',
		". $this->quote_smart($this->Keywords) . ",
		". $this->quote_smart($this->Header) . ",
		". $this->quote_smart($this->ShortHtml).",
		". $this->quote_smart($this->Html) . ",
		".$this->quote_smart($this->PublishingDate). ",
		".$this->quote_smart($this->Date). ",
		".$this->quote_smart($this->Duration). ",
		".$this->quote_smart($this->IsMonthly) . " ,
		".$this->quote_smart($this->Slika) . " ,
		".$this->quote_smart($this->SlikaThumb) . " ,
		".$this->quote_smart($this->Place) . " ,
		".$this->quote_smart($this->Link) . " ,
		". $this->quote_smart($this->SfStatus->getStatusID()) .",
		". $this->quote_smart($this->ModuleType->getModuleTypeID()).",
		". $this->quote_smart($this->getCreatedBy()).",
		". $this->quote_smart($this->getCreatedDate()).",
		". $this->quote_smart($this->getModifiedBy()).",
		". $this->quote_smart($this->getModifiedDate());
	}
    function postaviVrednostiAtributa(){
		return "
		`keywords` = ".$this->quote_smart($this->Keywords). " ,
		`header` = ".$this->quote_smart($this->Header). " ,
		`shorthtml` = ".$this->quote_smart($this->ShortHtml)." ,
		`html` = ".$this->quote_smart($this->Html).",
		`publishing_date` =". $this->quote_smart($this->PublishingDate).",
		`date` =". $this->quote_smart($this->Date).",
		`duration` =". $this->quote_smart($this->Duration).",
		`is_monthly` =". $this->quote_smart($this->IsMonthly).",
		`slika` =". $this->quote_smart($this->Slika).",
		`slika_thumb` =". $this->quote_smart($this->SlikaThumb).",
		`place` =". $this->quote_smart($this->Place)." ,
		`link` =". $this->quote_smart($this->Link)." ,
		`status_id` =".$this->quote_smart($this->SfStatus->getStatusID()).",
		`module_type_id` =". $this->quote_smart($this->ModuleType->getModuleTypeID()).",
		`created_by` =". $this->quote_smart($this->getCreatedBy()).",
		`created_date` =". $this->quote_smart($this->getCreatedDate()).",
		`modified_by` =". $this->quote_smart($this->getModifiedBy()).",
		`modified_date` =". $this->quote_smart($this->getModifiedDate());
	}
	function nazivVezeKaRoditelju(){ return "module";}
    function vratiAtributPretrazivanja(){ return "module_id"; }
    function vratiUslovZaNadjiSlog(){ return "module_id=" . $this->quote_smart($this->ModuleID);}
    function vratiFulltextIndekse(){ return  "header, html, shorthtml";} //definisemo polja nad kojima je postavljem fulltext index
	function vratiUslovZaSortiranje(){ return "date DESC";} //??
	function vratiUslovZaNadjiSlogF(){ return "module_id=" . $this->quote_smart($this->ModuleID);}
	function vratiUslovZaNadjiSlogove(){ return "1";}
	function postaviID($id){ $this->ModuleID = $id;}
	function toString() {}

	function napuni($result_row)
	{
		$this->ModuleID = $result_row->module_id;
		$this->Keywords = $result_row->keywords;
		$this->Header = $result_row->header;
		$this->ShortHtml= $result_row->shorthtml;
		$this->Html = $result_row->html;
		$this->PublishingDate = $result_row->publishing_date;
		$this->Date = $result_row->date;
        $this->Duration = $result_row->duration;
        $this->IsMonthly = $result_row->is_monthly;
		$this->Slika = $result_row->slika;
		$this->SlikaThumb = $result_row->slika_thumb;
		$this->Place = $result_row->place;
		$this->Link = $result_row->link;
		$this->SfStatus->setStatusID($result_row->status_id);
		$this->ModuleType->setModuleTypeID($result_row->module_type_id);
		$this->CreatedBy= $result_row->created_by;
		$this->CreatedDate = $result_row->created_date;
		$this->ModifiedBy = $result_row->modified_by;
		$this->ModifiedDate = $result_row->modified_date;
  	}

	function napuniNiz($result_set, &$al)
	{
		if($this->count($result_set)>0)
			foreach($result_set as $result_row){
				$nw = $this->ObjectFactory->createObject("Module",-1);
				$nw->ModuleID = $result_row->module_id;
				$nw->Keywords = $result_row->keywords;
				$nw->Header = $result_row->header;
				$nw->ShortHtml= $result_row->shorthtml;
				$nw->Html = $result_row->html;
				$nw->PublishingDate = $result_row->publishing_date;
				$nw->Date = $result_row->date;
                $nw->Duration = $result_row->duration;
                $nw->IsMonthly = $result_row->is_monthly;
				$nw->Slika = $result_row->slika;
				$nw->SlikaThumb = $result_row->slika_thumb;
				$nw->Place = $result_row->place;
				$nw->Link = $result_row->link;
				$nw->SfStatus->setStatusID($result_row->status_id);
				$nw->ModuleType->setModuleTypeID($result_row->module_type_id);
				$nw->CreatedBy= $result_row->created_by;
				$nw->CreatedDate = $result_row->created_date;
				$nw->ModifiedBy = $result_row->modified_by;
				$nw->ModifiedDate = $result_row->modified_date;
				array_push($al, $nw);
			}
	}

	function vratiImeVezneTabele($relation_class_name,& $vezna_klasa, & $uslov_join)
	{
		$moduleCategory = $this->LanguageHelper->ChangeTableNameR("modulecategory");
		$moduleModuleCategory = $this->LanguageHelper->ChangeTableNameR("modulemodulecategory");

		switch ($relation_class_name)
		{
			case $moduleCategory:
				$vezna_klasa = $moduleModuleCategory;
				$uslov_join = "IJ1.module_category_id= IJ2.modulecategoryid";
				break;
			default: $vezna_klasa = "";
			break;
		}
	}

	function napuniVisePovezi($result_set, $relation_name)
	{
		switch ($relation_name){
			case "moduletype":
				if ($this->count($result_set) > 0) { $this->ModuleType->napuni($result_set); }
				break;
			case "sfstatus":
				if ($this->count($result_set) > 0) { $this->SfStatus->napuni($result_set); }
				break;
			case "modulecategory":
				if($this->count($result_set)>0)
					foreach($result_set as $db_res){
					$moduleCategory = $this->ObjectFactory->createObject("ModuleCategory",-1);
					$moduleCategory->napuni($db_res);
					array_push($this->ModuleCategory, $moduleCategory);
				}
				break;
			default: break;
		}
	}

	function toArray()
	{
		$arr = array();
			$arr = array_merge($arr, array("moduleid" => $this->getModuleID()));
			$arr = array_merge($arr, array("keywords" => $this->getKeywords()));
			$arr = array_merge($arr, array("header" => $this->getHeader()));
			$arr = array_merge($arr, array("shorthtml" => $this->getShortHtml()));
			$arr = array_merge($arr, array("html" => $this->getHtml()));
			$arr = array_merge($arr, array("dateorig" => $this->getDate()));
			$arr = array_merge($arr, array("publishingdate" => $this->getDateFormated()));
			$arr = array_merge($arr, array("date" => $this->getDateFormated()));
			$arr = array_merge($arr, array("datehronology" => $this->getDateFormatedHronology()));
			$arr = array_merge($arr, array("dateduration" => $this->getDateFormatedDuration()));
            $arr = array_merge($arr, array("duration" => $this->getDuration()));
            $arr = array_merge($arr, array("ismonthly" => $this->getIsMonthly()));
			$arr = array_merge($arr, array("slika" => $this->getSlika()));
			$arr = array_merge($arr, array("slikathumb" => $this->getSlikaThumb()));
			$arr = array_merge($arr, array("place" => $this->getPlace()));
			$arr = array_merge($arr, array("link" => $this->getLink()));
			$arr = array_merge($arr, array("statusid" => $this->getStatusID()));
			$arr = array_merge($arr, array("moduletypeid" => $this->getModuleTypeID()));
			$arr = array_merge($arr, array("modulecategoryprint" => $this->getModuleCategoryPrint()));
			$arr = array_merge($arr, array("modulecategorylistids" => $this->getModuleCategoryIdsList()));
			$arr = array_merge($arr, array("createdby" => $this->getCreatedBy()));
			$arr = array_merge($arr, array("modifiedby" => $this->getModifiedBy()));
			$arr = array_merge($arr, array("createddate" => $this->LanguageHelper->getDateTranslated($this->getCreatedDate(),"d. F Y.")));
			$arr = array_merge($arr, array("modifieddate" => $this->LanguageHelper->getDateTranslated($this->getModifiedDate(),"d. F Y.")));
		return $arr;
	}

	// getter and setter
	function getModuleID()
	{
		return $this->ModuleID;
	}
	function getKeywords()
	{
		return $this->LanguageHelper->Transliterate($this->Keywords);
	}
	function getHeader()
	{
		return $this->LanguageHelper->Transliterate($this->Header);
	}
	function getHeaderUnchanged()
	{
		return $this->Header;
	}
	function getShortHtmlUnchanged()
	{
		return $this->ShortHtml;
	}
	function getShortHtml()
	{
		return $this->LanguageHelper->Transliterate($this->ShortHtml);
	}
	function getHtmlUnchanged()
	{
		return $this->Html;
	}
	function getHtml()
	{
		return $this->LanguageHelper->Transliterate($this->Html);
	}
	function getPublishingDate()
	{
		return $this->PublishingDate;
	}
	function getDate()
	{
		return $this->Date;
	}
    function getDuration()
	{
		return $this->Duration;
	}
	function getIsMonthly()
	{
		return $this->IsMonthly;
	}
	function getDateFormated()
	{
		return $this->LanguageHelper->Transliterate($this->LanguageHelper->getDateTranslated($this->getDate(),''));
	}
	function getDateFormatedDuration()
	{
		if($this->getDuration() > 1)
		{
			return $this->LanguageHelper->Transliterate($this->LanguageHelper->getDateTranslated($this->getDate(),"d. F - "))." - ".$this->LanguageHelper->Transliterate($this->LanguageHelper->getDateTranslated($this->getDate() + 24*60*60*($this->Duration-1) ,"d. F Y."));
		}

		return $this->getDateFormated();
	}

	function getDateFormatedHronology()
	{
		if($this->getIsMonthly() == 1 && $this->getDuration() > 1)
		{
			return $this->LanguageHelper->Transliterate($this->LanguageHelper->getDateTranslated($this->getDate(),"F Y."))." - ". $this->LanguageHelper->Transliterate($this->LanguageHelper->getDateTranslated(strtotime("+". ($this->Duration-1) ." months", $this->getDate()) ,"F Y."));
		}
		else if($this->getIsMonthly() == 1)
		{
			return $this->LanguageHelper->Transliterate($this->LanguageHelper->getDateTranslated($this->getDate(),"F Y."));
		}

		return $this->LanguageHelper->Transliterate($this->LanguageHelper->getDateTranslated($this->getDate(),"d. F Y."));
	}

	function getSlika()
	{
		return $this->Slika;
	}
	function getSlikaThumb()
	{
		return $this->SlikaThumb;
	}
	function getPlaceUnchanged()
	{
		return $this->Place;
	}

	function getPlace()
	{
		return $this->LanguageHelper->Transliterate($this->Place);
	}
	function getLink()
	{
		return $this->Link;
	}
	function getSfStatus()
	{
		return $this->SfStatus;
	}
	function getStatusID()
	{
		return $this->SfStatus->StatusID;
	}
	function getModuleType()
	{
		return $this->ModuleType;
	}
	function getModuleTypeID()
	{
		return $this->ModuleType->getModuleTypeID();
	}

	function getModuleCategoryPrint($all=false)
	{
		$output = "";
		if($this->ModuleCategory != null)
		{
			foreach($this->ModuleCategory as $nwc)
			{
				if (!$all && $nwc->getStatus()==STATUS_CATEGORY_GLAVNI) $output .= $nwc->getTitle() . ", ";
				else if ($all) $output .= $nwc->getTitle() . ", ";
			}
		}

		return substr($output, 0, strlen($output)-2);
	}

	function getModuleCategoryIdsList()
	{
		$moduleCategoryList = "";

		if($this->count($this->ModuleCategory) >0)
		{
			foreach($this->ModuleCategory as $nc)
			{
				if ($nc->getStatus()==STATUS_CATEGORY_GLAVNI) $moduleCategoryList .= $nc->getModuleCategoryID() . ",";
			}
		}
		$nc=substr($moduleCategoryList, 0, strlen($moduleCategoryList)-1)."<br>";
		return $nc;
	}

	function getModuleCategory()
	{
		return $this->ModuleCategory;
	}

	function getCreatedBy()
	{
		return $this->CreatedBy;
	}
	function getCreatedDate()
	{
		return $this->CreatedDate;
	}
	function getModifiedBy()
	{
		return $this->ModifiedBy;
	}
	function getModifiedDate()
	{
		return $this->ModifiedDate;
	}

	/*--- setter ---*/
	function setModuleID($val)
	{
		$this->ModuleID = $val;
	}
	function setKeywords($val)
	{
		$this->Keywords = $val;
	}
	function setHeader($val)
	{
		$this->Header = $val;
	}
	function setShortHtml($val)
	{
		$this->ShortHtml = $val;
	}
	function setHtml($val)
	{
		$this->Html = $val;
	}
	function setPublishingDate($val)
	{
		$this->PublishingDate = $val;
	}
	function setDate($val)
	{
		$this->Date = $val;
	}
    function setDuration($val)
	{
		$this->Duration = $val;
	}
	function setIsMonthly($val)
	{
		$this->IsMonthly = $val;
	}
	function setSlika($val)
	{
		$this->Slika = $val;
	}
	function setSlikaThumb($val)
	{
		$this->SlikaThumb = $val;
	}
	function setPlace($val)
	{
		$this->Place = $val;
	}
	function setLink($val)
	{
		$this->Link = $val;
	}
	function setStatusID($val)
	{
		$this->SfStatus->StatusID = $val;
	}
	function setModuleTypeID($val)
	{
		$this->ModuleType->setModuleTypeID($val);
	}

	function setModuleCategory($val)
	{
		$this->ModuleCategory = $val;
	}

	function setCreatedBy($val)
	{
		$this->CreatedBy = $val;
	}
	function setCreatedDate($val)
	{
		$this->CreatedDate  = $val;
	}
	function setModifiedBy($val)
	{
		$this->ModifiedBy = $val;
	}
	function setModifiedDate($val)
	{
		$this->ModifiedDate = $val;
	}
	function getLinkID()
	{
		return 'moduleid='.$this->ModuleID;
	}
}

// klasa PrModuleGrupaProiz cuva veze izmedju modulea i grupe modulea
class ModuleModuleCategory extends OpstiDomenskiObjekat
{
	private $ModuleID;
	private $ModuleCategoryID;
	private $ModuleModuleCategoryOrder;

	//Bussiness PHP Object constructor
	function __construct()
	{
		parent::__construct();

		$this->ModuleID = -1;
		$this->ModuleCategoryID = -1;
		$this->ModuleModuleCategoryOrder = 0;
		$this->TableName = "modulemodulecategory";
		$this->LanguageHelper->ChangeTableName($this->TableName);
	}

	// fill ModuleModuleCategory from POST
	function ModuleModuleCategory_POST($post)
	{
		$this->ModuleID = isset($post["moduleid"]) ? $post["moduleid"] : $this->ModuleID;
		$this->ModuleCategoryID = isset($post["modulecategoryid"]) ? $post["modulecategoryid"] : $this->ModuleCategoryID;
		$this->ModuleModuleCategoryOrder = isset($post["modulemodulecategoryorder"]) ? $post["modulemodulecategoryorder"] : $this->ModuleModuleCategoryOrder;
	}

	function vratiImenaAtributa() {
		return "`module_id`,`module_category_id`,`module_modulecategory_order`";
	}
	function vratiImeKlase(){
		return $this->TableName;
	}
	function vratiVrednostiAtributa(){
		return $this->quote_smart($this->ModuleID).",".$this->quote_smart($this->ModuleCategoryID).",".$this->quote_smart($this->ModuleModuleCategoryOrder);
	}
	function postaviVrednostiAtributa(){
		return "`module_category_id` = ".$this->quote_smart($this->ModuleCategoryID).",`module_modulecategory_order` = ".$this->quote_smart($this->ModuleModuleCategoryOrder);
	}
	function nazivVezeKaRoditelju(){
		return "module";
	}
	function vratiUslovZaNadjiSlog(){
		return "module_id=".$this->quote_smart($this->ModuleID)." AND module_category_id=".$this->quote_smart($this->ModuleCategoryID);
	}
	function vratiUslovZaSortiranje(){
		return "module_modulecategory_order desc";
	}
	function vratiUslovZaNadjiSlogF(){
		return "module_id=".$this->quote_smart($this->ModuleID);
	}
	function vratiUslovZaNadjiSlogove(){
		return "module_id=".$this->quote_smart($this->ModuleID);
	}
	function postaviID($id){
		$this->ModuleID = $id;
	}
	function vratiAtributZaMax(){
		return "`module_modulecategory_order`";
	}
	function napuni($result_row){
		$this->ModuleID = $result_row->module_id;
		$this->ModuleCategoryID = $result_row->module_category_id;
		$this->ModuleModuleCategoryOrder = $result_row->module_modulecategory_order;
	}
	function napuniNiz($result_set, &$al){
		if($this->count($result_set)>0)
			foreach($result_set as $result_row){
			$moduleCateg= $this->ObjectFactory->createObject("ModuleModuleCategory",-1);
			$moduleCateg->ModuleID = $result_row->module_id;
			$moduleCateg->ModuleCategoryID = $result_row->module_category_id;
			$moduleCateg->ModuleModuleCategoryOrder = $result_row->module_modulecategory_order;
			array_push($al, $moduleCateg);
		}
	}
	function toArray()
	{
		$arr = array();
		$arr = array_merge($arr, array("moduleid" => $this->getModuleID()));
		$arr = array_merge($arr, array("modulecategoryid" => $this->getModuleCategoryID()));
		$arr = array_merge($arr, array("modulemodulecategoryorder" => $this->getModuleModuleCategoryOrder()));
		return $arr;
	}

	// get metode
	function getModuleID()
	{
		return $this->ModuleID;
	}
	function getModuleCategoryID()
	{
		return $this->ModuleCategoryID;
	}
	function getModuleModuleCategoryOrder()
	{
		return $this->ModuleModuleCategoryOrder;
	}
	// set metode
	function setModuleID($val)
	{
		$this->ModuleID= $val;
	}
	function setModuleCategoryID($val)
	{
		$this->ModuleCategoryID = $val;
	}
	function setModuleModuleCategoryOrder($val)
	{
		$this->ModuleModuleCategoryOrder = $val;
	}
	function getLinkID()
	{
		return 'moduleid='.$this->ModuleID;
	}

}


?>
