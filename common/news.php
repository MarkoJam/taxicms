<?

/* CMS Studio 3.0 news.php secured */

class NewsCategory extends OpstiDomenskiObjekat
{
	 public $NewsCategoryID;
	 public $Title;
	 public $MessageNum;
	 public $Status;
	 public $News;

	//Bussiness PHP Object constructor
	function __construct()
	{
		parent::__construct();

		$this->NewsCategoryID = -1;
		$this->Title = "";
		$this->MessageNum = 0;
		$this->News = array();

		$this->TableName= "newscategory";
		$this->LanguageHelper->ChangeTableName($this->TableName);
	}

	// fill NewsCategory from POST
	function NewsCategory_POST($post)
	{
		$this->NewsCategoryID = isset($post["newscategoryid"]) ? $post["newscategoryid"] : -1;
		$this->Title = isset($post["title"]) ? $post["title"] : -1;
		$this->MessageNum = isset($post["messagenum"]) ? $post["messagenum"] : -1;
		$this->Status = isset($post["status"]) ? $post["status"] : -1;
		$this->News = array();
	}

	// DatabaseBroker functions
	function vratiImenaAtributa() {return "`newscategoryid`,`title`,`messagenum`,`status`";}
	function vratiImeKlase(){return $this->TableName;}
	function vratiVrednostiAtributa(){ return "'',".$this->quote_smart($this->Title).",".$this->quote_smart($this->MessageNum).",".$this->quote_smart($this->Status);}
	function postaviVrednostiAtributa(){ return "`title` = ".$this->quote_smart($this->Title).",`messagenum` = ".$this->quote_smart($this->MessageNum).",`status` = ".$this->quote_smart($this->Status);}
	function nazivVezeKaRoditelju(){ return "newscategory";}
	function vratiUslovZaNadjiSlog(){ return "newscategoryid=".$this->quote_smart($this->NewsCategoryID);}
	function vratiUslovZaSortiranje(){ return "newscategoryid";}
	function vratiUslovZaNadjiSlogF(){ return "news_category_id=".$this->quote_smart($this->NewsCategoryID);}
	function vratiUslovZaNadjiSlogove(){ return "1=";}
	function postaviID($id){ $this->NewsCategoryID = $id;}
	function napuni($result_row)
	{
		$this->NewsCategoryID = $result_row->newscategoryid;
		$this->Title = $result_row->title;
		$this->MessageNum = $result_row->messagenum;
		$this->Status = $result_row->status;
	}
	function napuniNiz($result_set, &$al){
		if($this->count($result_set)>0)
			foreach($result_set as $result_row){
				$newscateg = $this->ObjectFactory->createObject("NewsCategory",-1);
				$newscateg->NewsCategoryID = $result_row->newscategoryid;
				$newscateg->Title = $result_row->title;
				$newscateg->MessageNum = $result_row->messagenum;
				$newscateg->Status = $result_row->status;
				array_push($al, $newscateg);
			}
	}

	function vratiImeVezneTabele($relation_class_name,& $vezna_klasa, & $uslov_join)
	{
		$news = $this->LanguageHelper->ChangeTableNameR("news");
		$newsNewsCategory = $this->LanguageHelper->ChangeTableNameR("newsnewscategory");

		switch ($relation_class_name)
		{
			case $news:
				$vezna_klasa = $newsNewsCategory;
				$uslov_join = "IJ1.news_id= IJ2.news_id";
				break;
			default: $vezna_klasa = "";
			break;
		}
	}

	function napuniVisePovezi($result_set, $relation_name)
	{
		switch ($relation_name)
		{
			case "news":
				if($this->count($result_set)>0)
				foreach($result_set as $db_res)
				{
					$anews= $this->ObjectFactory->createObject("News",-1);
					$anews->napuni($db_res);
					array_push($this->News,$anews);
				}
			break;
			default: break;
		}
	}

	function toArray()
	{
		$arr = array();
			$arr = array_merge($arr, array("newscategoryid" => $this->getNewsCategoryID()));
			$arr = array_merge($arr, array("title" => $this->getTitle()));
			$arr = array_merge($arr, array("messagenum" => $this->getMessageNum()));
			$arr = array_merge($arr, array("status" => $this->getStatus()));
		return $arr;
	}

	// getter and setter
	function getNewsCategoryID()
	{
		return $this->NewsCategoryID;
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

	function setNewsCategoryID($val)
	{
		$this->NewsCategoryID = $val;
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
		return 'newscategoryid='.$this->Newscategoryid;
	}

	// podesavanje za pluginove
	function vratiIDKategorijeZaPlugin(){

		return $this->NewsCategoryID;
	}

	function vratiNazivKategorijeZaPlugin(){
		return $this->Title;
	}

	function postaviIDKategorijeZaPlugin($id){
		$this->NewsCategoryID = $id;
	}
}

class NewsType extends OpstiDomenskiObjekat
{
	private $NewsTypeID;
	private $Title;
	private $Description;
	private $News;

	//Bussiness PHP Object constructor
	function __construct()
	{
		parent::__construct();

		$this->NewsTypeID = -1;
		$this->Title = "";
		$this->Description = 0;
		$this->News = array();

		$this->TableName= "newstype";
		$this->LanguageHelper->ChangeTableName($this->TableName);
	}

	// fill NewsType from POST
	function NewsType_POST($post)
	{
		$this->NewsTypeID = isset($post["news_type_id"]) ? $post["news_type_id"] : -1;
		$this->Title = isset($post["title"]) ? $post["title"] : -1;
		$this->Description = isset($post["description"]) ? $post["description"] : -1;
		$this->News = array();
	}

	// DatabaseBroker functions
	function vratiImenaAtributa() {
		return "`news_type_id`,`title`,`description`";
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
		return "newstype";
	}
	function vratiUslovZaNadjiSlog(){
		return "news_type_id=".$this->quote_smart($this->NewsTypeID);
	}
	function vratiUslovZaSortiranje(){
		return "news_type_id";
	}
	function vratiUslovZaNadjiSlogF(){
		return "news_type_id=".$this->quote_smart($this->NewsTypeID);
	}
	function vratiUslovZaNadjiSlogove(){
		return "1=";
	}
	function postaviID($id){
		$this->NewsTypeID = $id;
	}
	function napuni($result_row)
	{
		$this->NewsTypeID = $result_row->news_type_id;
		$this->Title = $result_row->title;
		$this->Description = $result_row->description;
	}
	function napuniNiz($result_set, &$al){
		if($this->count($result_set)>0)
			foreach($result_set as $result_row){
			$newscateg = $this->ObjectFactory->createObject("NewsType",-1);
			$newscateg->NewsTypeID = $result_row->news_type_id;
			$newscateg->Title = $result_row->title;
			$newscateg->Description = $result_row->description;
			array_push($al, $newscateg);
		}
	}

	function napuniVisePovezi($result_set, $relation_name)
	{
		switch ($relation_name)
		{
			case "news":
				if($this->count($result_set)>0)
					foreach($result_set as $db_res)
					{
						$anews= $this->ObjectFactory->createObject("News",-1);
						$anews->napuni($db_res);
						array_push($this->News,$anews);
					}
					break;
			default: break;
		}
	}

	function toArray()
	{
		$arr = array();
		$arr = array_merge($arr, array("newstypeid" => $this->getNewsTypeID()));
		$arr = array_merge($arr, array("title" => $this->getTitle()));
		$arr = array_merge($arr, array("description" => $this->getDescription()));
		return $arr;
	}

	// getter and setter
	function getNewsTypeID()
	{
		return $this->NewsTypeID;
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

	function setNewsTypeID($val)
	{
		$this->NewsTypeID = $val;
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
		return 'newstypeid='.$this->NewsTypeID;
	}

	// podesavanje za pluginove
	function vratiIDKategorijeZaPlugin(){

		return $this->NewsTypeID;
	}

	function vratiNazivKategorijeZaPlugin(){
		return $this->Title;
	}

	function postaviIDKategorijeZaPlugin($id){
		$this->NewsTypeID = $id;
	}
}

class News extends OpstiDomenskiObjekat
{
	public $NewsID;
	public $Keywords;
	public $Header;
	private $ShortHtml;
	public $Html;
	private $PublishingDate;
	private $Date;
    private $Duration;
	public $SfStatus;
	public $NewsType;
	public $IsMonthly;

	public $NewsCategory; // array

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

    	$this->NewsID = -1;
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
		$this->NewsType = $this->ObjectFactory->createObject("NewsType",-1);
		$this->NewsType->setNewsTypeID(-1);
		$this->IsMonthly = 0;
		$this->NewsCategory = array();

		$this->TableName= "news";
		$this->LanguageHelper->ChangeTableName($this->TableName);
    }

    // fill News from POST
    function News_POST($post)
    {
    	$this->SfStatus = $this->ObjectFactory->createObject("SfStatus",-1);

    	$this->NewsID = isset($post["news_id"]) ? $post["news_id"] : -1;
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
		$this->NewsType = $this->ObjectFactory->createObject("NewsType",-1);
		$this->NewsType->setNewsTypeID(isset($post["newstypeid"]) ? $post["newstypeid"] : -1);

		$this->NewsCategory = array();
    }

    // DatabaseBroker functions
    function vratiImenaAtributa() {return "`news_id` , `keywords` , `header` , `shorthtml`, `html` ,`publishing_date`, `date`, `duration`,`is_monthly`,`slika`,`slika_thumb`,`place`,`link`, `status_id`,`news_type_id`,`created_by`,`created_date`,`modified_by`,`modified_date`";}
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
		". $this->quote_smart($this->NewsType->getNewsTypeID()).",
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
		`news_type_id` =". $this->quote_smart($this->NewsType->getNewsTypeID()).",
		`created_by` =". $this->quote_smart($this->getCreatedBy()).",
		`created_date` =". $this->quote_smart($this->getCreatedDate()).",
		`modified_by` =". $this->quote_smart($this->getModifiedBy()).",
		`modified_date` =". $this->quote_smart($this->getModifiedDate());
	}
	function nazivVezeKaRoditelju(){ return "news";}
    function vratiAtributPretrazivanja(){ return "news_id"; }
    function vratiUslovZaNadjiSlog(){ return "news_id=" . $this->quote_smart($this->NewsID);}
    function vratiFulltextIndekse(){ return  "header, html, shorthtml";} //definisemo polja nad kojima je postavljem fulltext index
	function vratiUslovZaSortiranje(){ return "date DESC";} //??
	function vratiUslovZaNadjiSlogF(){ return "news_id=" . $this->quote_smart($this->NewsID);}
	function vratiUslovZaNadjiSlogove(){ return "1";}
	function postaviID($id){ $this->NewsID = $id;}
	function toString() {}

	function napuni($result_row)
	{
		$this->NewsID = $result_row->news_id;
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
		$this->NewsType->setNewsTypeID($result_row->news_type_id);
		$this->CreatedBy= $result_row->created_by;
		$this->CreatedDate = $result_row->created_date;
		$this->ModifiedBy = $result_row->modified_by;
		$this->ModifiedDate = $result_row->modified_date;
  	}

	function napuniNiz($result_set, &$al)
	{
		if($this->count($result_set)>0)
			foreach($result_set as $result_row){
				$nw = $this->ObjectFactory->createObject("News",-1);
				$nw->NewsID = $result_row->news_id;
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
				$nw->NewsType->setNewsTypeID($result_row->news_type_id);
				$nw->CreatedBy= $result_row->created_by;
				$nw->CreatedDate = $result_row->created_date;
				$nw->ModifiedBy = $result_row->modified_by;
				$nw->ModifiedDate = $result_row->modified_date;
				array_push($al, $nw);
			}
	}

	function vratiImeVezneTabele($relation_class_name,& $vezna_klasa, & $uslov_join)
	{
		$newsCategory = $this->LanguageHelper->ChangeTableNameR("newscategory");
		$newsNewsCategory = $this->LanguageHelper->ChangeTableNameR("newsnewscategory");

		switch ($relation_class_name)
		{
			case $newsCategory:
				$vezna_klasa = $newsNewsCategory;
				$uslov_join = "IJ1.news_category_id= IJ2.newscategoryid";
				break;
			default: $vezna_klasa = "";
			break;
		}
	}

	function napuniVisePovezi($result_set, $relation_name)
	{
		switch ($relation_name){
			case "newstype":
				if ($this->count($result_set) > 0) { $this->NewsType->napuni($result_set); }
				break;
			case "sfstatus":
				if ($this->count($result_set) > 0) { $this->SfStatus->napuni($result_set); }
				break;
			case "newscategory":
				if($this->count($result_set)>0)
					foreach($result_set as $db_res){
					$newsCategory = $this->ObjectFactory->createObject("NewsCategory",-1);
					$newsCategory->napuni($db_res);
					array_push($this->NewsCategory, $newsCategory);
				}
				break;
			default: break;
		}
	}

	function toArray()
	{
		$arr = array();
			$arr = array_merge($arr, array("newsid" => $this->getNewsID()));
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
			$arr = array_merge($arr, array("newstypeid" => $this->getNewsTypeID()));
			$arr = array_merge($arr, array("newscategoryprint" => $this->getNewsCategoryPrint()));
			$arr = array_merge($arr, array("newscategorylistids" => $this->getNewsCategoryIdsList()));
			$arr = array_merge($arr, array("createdby" => $this->getCreatedBy()));
			$arr = array_merge($arr, array("modifiedby" => $this->getModifiedBy()));
			$arr = array_merge($arr, array("createddate" => $this->LanguageHelper->getDateTranslated($this->getCreatedDate(),"d. F Y.")));
			$arr = array_merge($arr, array("modifieddate" => $this->LanguageHelper->getDateTranslated($this->getModifiedDate(),"d. F Y.")));
		return $arr;
	}

	// getter and setter
	function getNewsID()
	{
		return $this->NewsID;
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
	function getNewsType()
	{
		return $this->NewsType;
	}
	function getNewsTypeID()
	{
		return $this->NewsType->getNewsTypeID();
	}

	function getNewsCategoryPrint($all=false)
	{
		$output = "";
		if($this->NewsCategory != null)
		{
			foreach($this->NewsCategory as $nwc)
			{
				if (!$all && $nwc->getStatus()==STATUS_CATEGORY_GLAVNI) $output .= $nwc->getTitle() . ", ";
				else if ($all) $output .= $nwc->getTitle() . ", ";
			}
		}

		return substr($output, 0, strlen($output)-2);
	}

	function getNewsCategoryIdsList()
	{
		$newsCategoryList = "";

		if($this->count($this->NewsCategory) >0)
		{
			foreach($this->NewsCategory as $nc)
			{
				if ($nc->getStatus()==STATUS_CATEGORY_GLAVNI) $newsCategoryList .= $nc->getNewsCategoryID() . ",";
			}
		}
		$nc=substr($newsCategoryList, 0, strlen($newsCategoryList)-1)."<br>";
		return $nc;
	}

	function getNewsCategory()
	{
		return $this->NewsCategory;
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
	function setNewsID($val)
	{
		$this->NewsID = $val;
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
	function setNewsTypeID($val)
	{
		$this->NewsType->setNewsTypeID($val);
	}

	function setNewsCategory($val)
	{
		$this->NewsCategory = $val;
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
		return 'newsid='.$this->NewsID;
	}
}

// klasa PrNewsGrupaProiz cuva veze izmedju newsa i grupe newsa
class NewsNewsCategory extends OpstiDomenskiObjekat
{
	private $NewsID;
	private $NewsCategoryID;
	private $NewsNewsCategoryOrder;

	//Bussiness PHP Object constructor
	function __construct()
	{
		parent::__construct();

		$this->NewsID = -1;
		$this->NewsCategoryID = -1;
		$this->NewsNewsCategoryOrder = 0;
		$this->TableName = "newsnewscategory";
		$this->LanguageHelper->ChangeTableName($this->TableName);
	}

	// fill NewsNewsCategory from POST
	function NewsNewsCategory_POST($post)
	{
		$this->NewsID = isset($post["newsid"]) ? $post["newsid"] : $this->NewsID;
		$this->NewsCategoryID = isset($post["newscategoryid"]) ? $post["newscategoryid"] : $this->NewsCategoryID;
		$this->NewsNewsCategoryOrder = isset($post["newsnewscategoryorder"]) ? $post["newsnewscategoryorder"] : $this->NewsNewsCategoryOrder;
	}

	function vratiImenaAtributa() {
		return "`news_id`,`news_category_id`,`news_newscategory_order`";
	}
	function vratiImeKlase(){
		return $this->TableName;
	}
	function vratiVrednostiAtributa(){
		return $this->quote_smart($this->NewsID).",".$this->quote_smart($this->NewsCategoryID).",".$this->quote_smart($this->NewsNewsCategoryOrder);
	}
	function postaviVrednostiAtributa(){
		return "`news_category_id` = ".$this->quote_smart($this->NewsCategoryID).",`news_newscategory_order` = ".$this->quote_smart($this->NewsNewsCategoryOrder);
	}
	function nazivVezeKaRoditelju(){
		return "news";
	}
	function vratiUslovZaNadjiSlog(){
		return "news_id=".$this->quote_smart($this->NewsID)." AND news_category_id=".$this->quote_smart($this->NewsCategoryID);
	}
	function vratiUslovZaSortiranje(){
		return "news_newscategory_order desc";
	}
	function vratiUslovZaNadjiSlogF(){
		return "news_id=".$this->quote_smart($this->NewsID);
	}
	function vratiUslovZaNadjiSlogove(){
		return "news_id=".$this->quote_smart($this->NewsID);
	}
	function postaviID($id){
		$this->NewsID = $id;
	}
	function vratiAtributZaMax(){
		return "`news_newscategory_order`";
	}
	function napuni($result_row){
		$this->NewsID = $result_row->news_id;
		$this->NewsCategoryID = $result_row->news_category_id;
		$this->NewsNewsCategoryOrder = $result_row->news_newscategory_order;
	}
	function napuniNiz($result_set, &$al){
		if($this->count($result_set)>0)
			foreach($result_set as $result_row){
			$newsCateg= $this->ObjectFactory->createObject("NewsNewsCategory",-1);
			$newsCateg->NewsID = $result_row->news_id;
			$newsCateg->NewsCategoryID = $result_row->news_category_id;
			$newsCateg->NewsNewsCategoryOrder = $result_row->news_newscategory_order;
			array_push($al, $newsCateg);
		}
	}
	function toArray()
	{
		$arr = array();
		$arr = array_merge($arr, array("newsid" => $this->getNewsID()));
		$arr = array_merge($arr, array("newscategoryid" => $this->getNewsCategoryID()));
		$arr = array_merge($arr, array("newsnewscategoryorder" => $this->getNewsNewsCategoryOrder()));
		return $arr;
	}

	// get metode
	function getNewsID()
	{
		return $this->NewsID;
	}
	function getNewsCategoryID()
	{
		return $this->NewsCategoryID;
	}
	function getNewsNewsCategoryOrder()
	{
		return $this->NewsNewsCategoryOrder;
	}
	// set metode
	function setNewsID($val)
	{
		$this->NewsID= $val;
	}
	function setNewsCategoryID($val)
	{
		$this->NewsCategoryID = $val;
	}
	function setNewsNewsCategoryOrder($val)
	{
		$this->NewsNewsCategoryOrder = $val;
	}
	function getLinkID()
	{
		return 'newsid='.$this->NewsID;
	}

}


?>
