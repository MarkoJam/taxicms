<?

/* CMS Studio 3.0 option.php secured */

class OptionCategory extends OpstiDomenskiObjekat
{
	 public $OptionCategoryID;
	 public $Title;
	 public $MessageNum;
	 public $Status;
	 public $Option;

	//Bussiness PHP Object constructor
	function __construct()
	{
		parent::__construct();

		$this->OptionCategoryID = -1;
		$this->Title = "";
		$this->MessageNum = 0;
		$this->Option = array();

		$this->TableName= "menu_optioncategory";
		$this->LanguageHelper->ChangeTableName($this->TableName);
	}

	// fill OptionCategory from POST
	function OptionCategory_POST($post)
	{
		$this->OptionCategoryID = isset($post["optioncategoryid"]) ? $post["optioncategoryid"] : -1;
		$this->Title = isset($post["title"]) ? $post["title"] : -1;
		$this->MessageNum = isset($post["messagenum"]) ? $post["messagenum"] : -1;
		$this->Status = isset($post["status"]) ? $post["status"] : -1;
		$this->Option = array();
	}

	// DatabaseBroker functions
	function vratiImenaAtributa() {return "`optioncategoryid`,`title`,`messagenum`,`status`";}
	function vratiImeKlase(){return $this->TableName;}
	function vratiVrednostiAtributa(){ return "'',".$this->quote_smart($this->Title).",".$this->quote_smart($this->MessageNum).",".$this->quote_smart($this->Status);}
	function postaviVrednostiAtributa(){ return "`title` = ".$this->quote_smart($this->Title).",`messagenum` = ".$this->quote_smart($this->MessageNum).",`status` = ".$this->quote_smart($this->Status);}
	function nazivVezeKaRoditelju(){ return "optioncategory";}
	function vratiUslovZaNadjiSlog(){ return "optioncategoryid=".$this->quote_smart($this->OptionCategoryID);}
	function vratiUslovZaSortiranje(){ return "optioncategoryid";}
	function vratiUslovZaNadjiSlogF(){ return "option_category_id=".$this->quote_smart($this->OptionCategoryID);}
	function vratiUslovZaNadjiSlogove(){ return "1=";}
	function postaviID($id){ $this->OptionCategoryID = $id;}
	function napuni($result_row)
	{
		$this->OptionCategoryID = $result_row->optioncategoryid;
		$this->Title = $result_row->title;
		$this->MessageNum = $result_row->messagenum;
		$this->Status = $result_row->status;
	}
	function napuniNiz($result_set, &$al){
		if($this->count($result_set)>0)
			foreach($result_set as $result_row){
				$optioncateg = $this->ObjectFactory->createObject("OptionCategory",-1);
				$optioncateg->OptionCategoryID = $result_row->optioncategoryid;
				$optioncateg->Title = $result_row->title;
				$optioncateg->MessageNum = $result_row->messagenum;
				$optioncateg->Status = $result_row->status;
				array_push($al, $optioncateg);
			}
	}

	function vratiImeVezneTabele($relation_class_name,& $vezna_klasa, & $uslov_join)
	{
		$option = $this->LanguageHelper->ChangeTableNameR("option");
		$optionOptionCategory = $this->LanguageHelper->ChangeTableNameR("optionoptioncategory");

		switch ($relation_class_name)
		{
			case $option:
				$vezna_klasa = $optionOptionCategory;
				$uslov_join = "IJ1.option_id= IJ2.option_id";
				break;
			default: $vezna_klasa = "";
			break;
		}
	}

	function napuniVisePovezi($result_set, $relation_name)
	{
		switch ($relation_name)
		{
			case "option":
				if($this->count($result_set)>0)
				foreach($result_set as $db_res)
				{
					$aoption= $this->ObjectFactory->createObject("Option",-1);
					$aoption->napuni($db_res);
					array_push($this->Option,$aoption);
				}
			break;
			default: break;
		}
	}

	function toArray()
	{
		$arr = array();
			$arr = array_merge($arr, array("optioncategoryid" => $this->getOptionCategoryID()));
			$arr = array_merge($arr, array("title" => $this->getTitle()));
			$arr = array_merge($arr, array("messagenum" => $this->getMessageNum()));
			$arr = array_merge($arr, array("status" => $this->getStatus()));
		return $arr;
	}

	// getter and setter
	function getOptionCategoryID()
	{
		return $this->OptionCategoryID;
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

	function setOptionCategoryID($val)
	{
		$this->OptionCategoryID = $val;
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
		return 'optioncategoryid='.$this->Optioncategoryid;
	}

	// podesavanje za pluginove
	function vratiIDKategorijeZaPlugin(){

		return $this->OptionCategoryID;
	}

	function vratiNazivKategorijeZaPlugin(){
		return $this->Title;
	}

	function postaviIDKategorijeZaPlugin($id){
		$this->OptionCategoryID = $id;
	}
}

class OptionType extends OpstiDomenskiObjekat
{
	private $OptionTypeID;
	private $Title;
	private $Description;
	private $Option;

	//Bussiness PHP Object constructor
	function __construct()
	{
		parent::__construct();

		$this->OptionTypeID = -1;
		$this->Title = "";
		$this->Description = 0;
		$this->Option = array();

		$this->TableName= "menu_optiontype";
		$this->LanguageHelper->ChangeTableName($this->TableName);
	}

	// fill OptionType from POST
	function OptionType_POST($post)
	{
		$this->OptionTypeID = isset($post["option_type_id"]) ? $post["option_type_id"] : -1;
		$this->Title = isset($post["title"]) ? $post["title"] : -1;
		$this->Description = isset($post["description"]) ? $post["description"] : -1;
		$this->Option = array();
	}

	// DatabaseBroker functions
	function vratiImenaAtributa() {
		return "`option_type_id`,`title`,`description`";
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
		return "optiontype";
	}
	function vratiUslovZaNadjiSlog(){
		return "option_type_id=".$this->quote_smart($this->OptionTypeID);
	}
	function vratiUslovZaSortiranje(){
		return "option_type_id";
	}
	function vratiUslovZaNadjiSlogF(){
		return "option_type_id=".$this->quote_smart($this->OptionTypeID);
	}
	function vratiUslovZaNadjiSlogove(){
		return "1=";
	}
	function postaviID($id){
		$this->OptionTypeID = $id;
	}
	function napuni($result_row)
	{
		$this->OptionTypeID = $result_row->option_type_id;
		$this->Title = $result_row->title;
		$this->Description = $result_row->description;
	}
	function napuniNiz($result_set, &$al){
		if($this->count($result_set)>0)
			foreach($result_set as $result_row){
			$optioncateg = $this->ObjectFactory->createObject("OptionType",-1);
			$optioncateg->OptionTypeID = $result_row->option_type_id;
			$optioncateg->Title = $result_row->title;
			$optioncateg->Description = $result_row->description;
			array_push($al, $optioncateg);
		}
	}

	function napuniVisePovezi($result_set, $relation_name)
	{
		switch ($relation_name)
		{
			case "option":
				if($this->count($result_set)>0)
					foreach($result_set as $db_res)
					{
						$aoption= $this->ObjectFactory->createObject("Option",-1);
						$aoption->napuni($db_res);
						array_push($this->Option,$aoption);
					}
					break;
			default: break;
		}
	}

	function toArray()
	{
		$arr = array();
		$arr = array_merge($arr, array("optiontypeid" => $this->getOptionTypeID()));
		$arr = array_merge($arr, array("title" => $this->getTitle()));
		$arr = array_merge($arr, array("description" => $this->getDescription()));
		return $arr;
	}

	// getter and setter
	function getOptionTypeID()
	{
		return $this->OptionTypeID;
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

	function setOptionTypeID($val)
	{
		$this->OptionTypeID = $val;
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
		return 'optiontypeid='.$this->OptionTypeID;
	}

	// podesavanje za pluginove
	function vratiIDKategorijeZaPlugin(){

		return $this->OptionTypeID;
	}

	function vratiNazivKategorijeZaPlugin(){
		return $this->Title;
	}

	function postaviIDKategorijeZaPlugin($id){
		$this->OptionTypeID = $id;
	}
}

class Option extends OpstiDomenskiObjekat
{
	public $OptionID;
	public $Keywords;
	public $Header;
	private $ShortHtml;
	public $Html;
	private $PublishingDate;
	private $Date;
    private $Duration;
	public $SfStatus;
	public $Module;
	public $OptionType;
	public $IsMonthly;

	public $OptionCategory; // array

    private $Slika;
    private $SlikaThumb;
    private $Price;
    private $Link;

	private $CreatedBy;
	private	$ModifiedBy;
	private $CreatedDate;
	private $ModifiedDate;

	//Bussiness PHP Object constructor
    function __construct()
    {
    	parent::__construct();

    	$this->OptionID = -1;
		$this->Keywords = "";
		$this->Header = "";
		$this->ShortHtml;
		$this->Html = "";
		$this->PublishingDate = time();
		$this->Date = time();
        $this->Duration = 1;

        $this->Slika = "";
        $this->SlikaThumb = "";
        $this->Price = "";
        $this->Link = "";

		$this->CreatedBy = "";
		$this->ModifiedBy = "";
		$this->CreatedDate = time();
		$this->ModifiedDate = time();

		$this->SfStatus = $this->ObjectFactory->createObject("SfStatus",-1);
		$this->Module = $this->ObjectFactory->createObject("Module",-1);
		$this->OptionType = $this->ObjectFactory->createObject("OptionType",-1);
		$this->OptionType->setOptionTypeID(-1);
		$this->IsMonthly = 0;
		$this->OptionCategory = array();

		$this->TableName= "menu_option";
		$this->LanguageHelper->ChangeTableName($this->TableName);
    }

    // fill Option from POST
    function Option_POST($post)
    {
    	$this->SfStatus = $this->ObjectFactory->createObject("SfStatus",-1);
    	$this->Module = $this->ObjectFactory->createObject("Module",-1);

    	$this->OptionID = isset($post["option_id"]) ? $post["option_id"] : -1;
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
        $this->Price = isset($post["price"]) ? $post["price"] : "";
        $this->Link = isset($post["link"]) ? $post["link"] : "";

		$this->SfStatus->setStatusID(isset($post["statusid"])? $post["statusid"] : $this->SfStatus->getStatusID());
		$this->Module->setModuleID(isset($post["moduleid"])? $post["moduleid"] : $this->Module->getModuleID());
		$this->OptionType = $this->ObjectFactory->createObject("OptionType",-1);
		$this->OptionType->setOptionTypeID(isset($post["optiontypeid"]) ? $post["optiontypeid"] : -1);

		$this->OptionCategory = array();
    }

    // DatabaseBroker functions
    function vratiImenaAtributa() {return "`option_id` , `keywords` , `header` , `shorthtml`, `html` ,`publishing_date`, `date`, `duration`,`is_monthly`,`slika`,`slika_thumb`,`price`,`link`, `status_id`,`module_id`,`option_type_id`,`created_by`,`created_date`,`modified_by`,`modified_date`";}
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
		".$this->quote_smart($this->Price) . " ,
		".$this->quote_smart($this->Link) . " ,
		". $this->quote_smart($this->SfStatus->getStatusID()) .",
		". $this->quote_smart($this->Module->getModuleID()) .",
		". $this->quote_smart($this->OptionType->getOptionTypeID()).",
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
		`price` =". $this->quote_smart($this->Price)." ,
		`link` =". $this->quote_smart($this->Link)." ,
		`status_id` =".$this->quote_smart($this->SfStatus->getStatusID()).",
		`module_id` =".$this->quote_smart($this->Module->getModuleID()).",
		`option_type_id` =". $this->quote_smart($this->OptionType->getOptionTypeID()).",
		`created_by` =". $this->quote_smart($this->getCreatedBy()).",
		`created_date` =". $this->quote_smart($this->getCreatedDate()).",
		`modified_by` =". $this->quote_smart($this->getModifiedBy()).",
		`modified_date` =". $this->quote_smart($this->getModifiedDate());
	}
	function nazivVezeKaRoditelju(){ return "option";}
    function vratiAtributPretrazivanja(){ return "option_id"; }
    function vratiUslovZaNadjiSlog(){ return "option_id=" . $this->quote_smart($this->OptionID);}
    function vratiFulltextIndekse(){ return  "header, html, shorthtml";} //definisemo polja nad kojima je postavljem fulltext index
	function vratiUslovZaSortiranje(){ return "date DESC";} //??
	function vratiUslovZaNadjiSlogF(){ return "option_id=" . $this->quote_smart($this->OptionID);}
	function vratiUslovZaNadjiSlogove(){ return "1";}
	function postaviID($id){ $this->OptionID = $id;}
	function toString() {}

	function napuni($result_row)
	{
		$this->OptionID = $result_row->option_id;
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
		$this->Price = $result_row->price;
		$this->Link = $result_row->link;
		$this->SfStatus->setStatusID($result_row->status_id);
		$this->Module->setModuleID($result_row->module_id);
		$this->OptionType->setOptionTypeID($result_row->option_type_id);
		$this->CreatedBy= $result_row->created_by;
		$this->CreatedDate = $result_row->created_date;
		$this->ModifiedBy = $result_row->modified_by;
		$this->ModifiedDate = $result_row->modified_date;
  	}

	function napuniNiz($result_set, &$al)
	{
		if($this->count($result_set)>0)
			foreach($result_set as $result_row){
				$nw = $this->ObjectFactory->createObject("Option",-1);
				$nw->OptionID = $result_row->option_id;
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
				$nw->Price = $result_row->price;
				$nw->Link = $result_row->link;
				$nw->SfStatus->setStatusID($result_row->status_id);
				$nw->Module->setModuleID($result_row->module_id);
				$nw->OptionType->setOptionTypeID($result_row->option_type_id);
				$nw->CreatedBy= $result_row->created_by;
				$nw->CreatedDate = $result_row->created_date;
				$nw->ModifiedBy = $result_row->modified_by;
				$nw->ModifiedDate = $result_row->modified_date;
				array_push($al, $nw);
			}
	}

	function vratiImeVezneTabele($relation_class_name,& $vezna_klasa, & $uslov_join)
	{
		$optionCategory = $this->LanguageHelper->ChangeTableNameR("optioncategory");
		$optionOptionCategory = $this->LanguageHelper->ChangeTableNameR("optionoptioncategory");

		switch ($relation_class_name)
		{
			case $optionCategory:
				$vezna_klasa = $optionOptionCategory;
				$uslov_join = "IJ1.option_category_id= IJ2.optioncategoryid";
				break;
			default: $vezna_klasa = "";
			break;
		}
	}

	function napuniVisePovezi($result_set, $relation_name)
	{
		switch ($relation_name){
			case "optiontype":
				if ($this->count($result_set) > 0) { $this->OptionType->napuni($result_set); }
				break;
			case "sfstatus":
				if ($this->count($result_set) > 0) { $this->SfStatus->napuni($result_set); }
				break;			
			case "module":
				if ($this->count($result_set) > 0) { $this->Module->napuni($result_set); }
				break;
			case "optioncategory":
				if($this->count($result_set)>0)
					foreach($result_set as $db_res){
					$optionCategory = $this->ObjectFactory->createObject("OptionCategory",-1);
					$optionCategory->napuni($db_res);
					array_push($this->OptionCategory, $optionCategory);
				}
				break;
			default: break;
		}
	}

	function toArray()
	{
		$arr = array();
			$arr = array_merge($arr, array("optionid" => $this->getOptionID()));
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
			$arr = array_merge($arr, array("price" => $this->getPrice()));
			$arr = array_merge($arr, array("link" => $this->getLink()));
			$arr = array_merge($arr, array("statusid" => $this->getStatusID()));
			$arr = array_merge($arr, array("moduleid" => $this->getModuleID()));
			$arr = array_merge($arr, array("optiontypeid" => $this->getOptionTypeID()));
			$arr = array_merge($arr, array("optioncategoryprint" => $this->getOptionCategoryPrint()));
			$arr = array_merge($arr, array("optioncategorylistids" => $this->getOptionCategoryIdsList()));
			$arr = array_merge($arr, array("createdby" => $this->getCreatedBy()));
			$arr = array_merge($arr, array("modifiedby" => $this->getModifiedBy()));
			$arr = array_merge($arr, array("createddate" => $this->LanguageHelper->getDateTranslated($this->getCreatedDate(),"d. F Y.")));
			$arr = array_merge($arr, array("modifieddate" => $this->LanguageHelper->getDateTranslated($this->getModifiedDate(),"d. F Y.")));
		return $arr;
	}

	// getter and setter
	function getOptionID()
	{
		return $this->OptionID;
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
	function getPrice()
	{
		return $this->Price;
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
	function getModuleID()
	{
		return $this->Module->ModuleID;
	}
	function getOptionType()
	{
		return $this->OptionType;
	}
	function getOptionTypeID()
	{
		return $this->OptionType->getOptionTypeID();
	}

	function getOptionCategoryPrint($all=false)
	{
		$output = "";
		if($this->OptionCategory != null)
		{
			foreach($this->OptionCategory as $nwc)
			{
				if (!$all && $nwc->getStatus()==STATUS_CATEGORY_GLAVNI) $output .= $nwc->getTitle() . ", ";
				else if ($all) $output .= $nwc->getTitle() . ", ";
			}
		}

		return substr($output, 0, strlen($output)-2);
	}

	function getOptionCategoryIdsList()
	{
		$optionCategoryList = "";

		if($this->count($this->OptionCategory) >0)
		{
			foreach($this->OptionCategory as $nc)
			{
				if ($nc->getStatus()==STATUS_CATEGORY_GLAVNI) $optionCategoryList .= $nc->getOptionCategoryID() . ",";
			}
		}
		$nc=substr($optionCategoryList, 0, strlen($optionCategoryList)-1)."<br>";
		return $nc;
	}

	function getOptionCategory()
	{
		return $this->OptionCategory;
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
	function setOptionID($val)
	{
		$this->OptionID = $val;
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
	function setPrice($val)
	{
		$this->Price = $val;
	}
	function setLink($val)
	{
		$this->Link = $val;
	}
	function setStatusID($val)
	{
		$this->SfStatus->StatusID = $val;
	}	
	function setModuleID($val)
	{
		$this->Module->ModuleID = $val;
	}
	function setOptionTypeID($val)
	{
		$this->OptionType->setOptionTypeID($val);
	}

	function setOptionCategory($val)
	{
		$this->OptionCategory = $val;
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
		return 'optionid='.$this->OptionID;
	}
}

// klasa PrOptionGrupaProiz cuva veze izmedju optiona i grupe optiona
class OptionOptionCategory extends OpstiDomenskiObjekat
{
	private $OptionID;
	private $OptionCategoryID;
	private $OptionOptionCategoryOrder;

	//Bussiness PHP Object constructor
	function __construct()
	{
		parent::__construct();

		$this->OptionID = -1;
		$this->OptionCategoryID = -1;
		$this->OptionOptionCategoryOrder = 0;
		$this->TableName = "menu_optionoptioncategory";
		$this->LanguageHelper->ChangeTableName($this->TableName);
	}

	// fill OptionOptionCategory from POST
	function OptionOptionCategory_POST($post)
	{
		$this->OptionID = isset($post["optionid"]) ? $post["optionid"] : $this->OptionID;
		$this->OptionCategoryID = isset($post["optioncategoryid"]) ? $post["optioncategoryid"] : $this->OptionCategoryID;
		$this->OptionOptionCategoryOrder = isset($post["optionoptioncategoryorder"]) ? $post["optionoptioncategoryorder"] : $this->OptionOptionCategoryOrder;
	}

	function vratiImenaAtributa() {
		return "`option_id`,`option_category_id`,`option_optioncategory_order`";
	}
	function vratiImeKlase(){
		return $this->TableName;
	}
	function vratiVrednostiAtributa(){
		return $this->quote_smart($this->OptionID).",".$this->quote_smart($this->OptionCategoryID).",".$this->quote_smart($this->OptionOptionCategoryOrder);
	}
	function postaviVrednostiAtributa(){
		return "`option_category_id` = ".$this->quote_smart($this->OptionCategoryID).",`option_optioncategory_order` = ".$this->quote_smart($this->OptionOptionCategoryOrder);
	}
	function nazivVezeKaRoditelju(){
		return "option";
	}
	function vratiUslovZaNadjiSlog(){
		return "option_id=".$this->quote_smart($this->OptionID)." AND option_category_id=".$this->quote_smart($this->OptionCategoryID);
	}
	function vratiUslovZaSortiranje(){
		return "option_optioncategory_order desc";
	}
	function vratiUslovZaNadjiSlogF(){
		return "option_id=".$this->quote_smart($this->OptionID);
	}
	function vratiUslovZaNadjiSlogove(){
		return "option_id=".$this->quote_smart($this->OptionID);
	}
	function postaviID($id){
		$this->OptionID = $id;
	}
	function vratiAtributZaMax(){
		return "`option_optioncategory_order`";
	}
	function napuni($result_row){
		$this->OptionID = $result_row->option_id;
		$this->OptionCategoryID = $result_row->option_category_id;
		$this->OptionOptionCategoryOrder = $result_row->option_optioncategory_order;
	}
	function napuniNiz($result_set, &$al){
		if($this->count($result_set)>0)
			foreach($result_set as $result_row){
			$optionCateg= $this->ObjectFactory->createObject("OptionOptionCategory",-1);
			$optionCateg->OptionID = $result_row->option_id;
			$optionCateg->OptionCategoryID = $result_row->option_category_id;
			$optionCateg->OptionOptionCategoryOrder = $result_row->option_optioncategory_order;
			array_push($al, $optionCateg);
		}
	}
	function toArray()
	{
		$arr = array();
		$arr = array_merge($arr, array("optionid" => $this->getOptionID()));
		$arr = array_merge($arr, array("optioncategoryid" => $this->getOptionCategoryID()));
		$arr = array_merge($arr, array("optionoptioncategoryorder" => $this->getOptionOptionCategoryOrder()));
		return $arr;
	}

	// get metode
	function getOptionID()
	{
		return $this->OptionID;
	}
	function getOptionCategoryID()
	{
		return $this->OptionCategoryID;
	}
	function getOptionOptionCategoryOrder()
	{
		return $this->OptionOptionCategoryOrder;
	}
	// set metode
	function setOptionID($val)
	{
		$this->OptionID= $val;
	}
	function setOptionCategoryID($val)
	{
		$this->OptionCategoryID = $val;
	}
	function setOptionOptionCategoryOrder($val)
	{
		$this->OptionOptionCategoryOrder = $val;
	}
	function getLinkID()
	{
		return 'optionid='.$this->OptionID;
	}

}


?>
