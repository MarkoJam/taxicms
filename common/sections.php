<? 

/* CMS Studio 3.0 sections.php secured */

class SectionsCategory extends OpstiDomenskiObjekat 
{
	 public $SectionsCategoryID;
	 public $Title;
	 public $MessageNum;
	 public $Status;
	 public $Sections;
	
	//Bussiness PHP Object constructor	 
	function __construct()
	{
		parent::__construct();
		
		$this->SectionsCategoryID = -1;
		$this->Title = "";
		$this->MessageNum = 0;
		$this->Sections = array();
		
		$this->TableName= "sectionscategory";
		$this->LanguageHelper->ChangeTableName($this->TableName);
	}
	
	// fill SectionsCategory from POST
	function SectionsCategory_POST($post)
	{
		$this->SectionsCategoryID = isset($post["sectionscategoryid"]) ? $post["sectionscategoryid"] : -1;
		$this->Title = isset($post["title"]) ? $post["title"] : -1;
		$this->MessageNum = isset($post["messagenum"]) ? $post["messagenum"] : -1;
		$this->Status = isset($post["status"]) ? $post["status"] : -1;
		$this->Sections = array();
	}
	
	// DatabaseBroker functions
	function vratiImenaAtributa() {return "`sectionscategoryid`,`title`,`messagenum`,`status`";}
	function vratiImeKlase(){return $this->TableName;}
	function vratiVrednostiAtributa(){ return "'',".$this->quote_smart($this->Title).",".$this->quote_smart($this->MessageNum).",".$this->quote_smart($this->Status);}
	function postaviVrednostiAtributa(){ return "`title` = ".$this->quote_smart($this->Title).",`messagenum` = ".$this->quote_smart($this->MessageNum).",`status` = ".$this->quote_smart($this->Status);}
	function nazivVezeKaRoditelju(){ return "sectionscategory";}
	function vratiUslovZaNadjiSlog(){ return "sectionscategoryid=".$this->quote_smart($this->SectionsCategoryID);}
	function vratiUslovZaSortiranje(){ return "sectionscategoryid";}
	function vratiUslovZaNadjiSlogF(){ return "sections_category_id=".$this->quote_smart($this->SectionsCategoryID);}
	function vratiUslovZaNadjiSlogove(){ return "1=";}
	function postaviID($id){ $this->SectionsCategoryID = $id;}
	function napuni($result_row)
	{
		$this->SectionsCategoryID = $result_row->sectionscategoryid;
		$this->Title = $result_row->title;
		$this->MessageNum = $result_row->messagenum;
		$this->Status = $result_row->status;
	}
	function napuniNiz($result_set, &$al){
		if(count($result_set)>0)
			foreach($result_set as $result_row){
				$sectionscateg = $this->ObjectFactory->createObject("SectionsCategory",-1);
				$sectionscateg->SectionsCategoryID = $result_row->sectionscategoryid;
				$sectionscateg->Title = $result_row->title;
				$sectionscateg->MessageNum = $result_row->messagenum;
				$sectionscateg->Status = $result_row->status;
				array_push($al, $sectionscateg);
			}
	}
	
	function vratiImeVezneTabele($relation_class_name,& $vezna_klasa, & $uslov_join)
	{
		$sections = $this->LanguageHelper->ChangeTableNameR("sections");
		$sectionsSectionsCategory = $this->LanguageHelper->ChangeTableNameR("sectionssectionscategory");
	
		switch ($relation_class_name)
		{
			case $sections:
				$vezna_klasa = $sectionsSectionsCategory;
				$uslov_join = "IJ1.sections_id= IJ2.sections_id";
				break;
			default: $vezna_klasa = "";
			break;
		}
	}
	
	function napuniVisePovezi($result_set, $relation_name)
	{
		switch ($relation_name)
		{
			case "sections":
				if(count($result_set)>0)
				foreach($result_set as $db_res)
				{
					$asections= $this->ObjectFactory->createObject("Sections",-1);
					$asections->napuni($db_res);
					array_push($this->Sections,$asections);
				}
			break;
			default: break;
		}
	}

	function toArray()
	{
		$arr = array();
			$arr = array_merge($arr, array("sectionscategoryid" => $this->getSectionsCategoryID()));
			$arr = array_merge($arr, array("title" => $this->getTitle()));
			$arr = array_merge($arr, array("messagenum" => $this->getMessageNum()));
			$arr = array_merge($arr, array("status" => $this->getStatus()));
		return $arr;
	}
	
	// getter and setter
	function getSectionsCategoryID()
	{
		return $this->SectionsCategoryID;
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
	
	function setSectionsCategoryID($val)
	{
		$this->SectionsCategoryID = $val;
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
		return 'sectionscategoryid='.$this->Sectionscategoryid;
	}
	
	// podesavanje za pluginove
	function vratiIDKategorijeZaPlugin(){
		
		return $this->SectionsCategoryID;
	}
		
	function vratiNazivKategorijeZaPlugin(){
		return $this->Title;
	}
	
	function postaviIDKategorijeZaPlugin($id){
		$this->SectionsCategoryID = $id;
	}
}

class Sections extends OpstiDomenskiObjekat
{
	public $SectionsID;
	public $Header;
	public $ShortHtml;
	public $Html;
	public $SectionLink;	
	public $SfStatus;
	
	public $SectionsCategory; // array
	
    private $Slika;
    private $SlikaThumb;
    
	private $CreatedBy;
	private	$ModifiedBy;
	private $CreatedDate;
	private $ModifiedDate;
	
	//Bussiness PHP Object constructor	 
    function __construct()
    {
    	parent::__construct();
    	
    	$this->SectionsID = -1;
		$this->Header = "";
		$this->ShortHtml;
		$this->Html = "";
		$this->SectionLink = "";
        
        $this->Slika = "";
        $this->SlikaThumb = "";
        
		$this->CreatedBy = "";
		$this->ModifiedBy = "";
		$this->CreatedDate = time();
		$this->ModifiedDate = time();
		
		$this->SfStatus = $this->ObjectFactory->createObject("SfStatus",-1);
		$this->SectionsCategory = array();
		
		$this->TableName= "sections";
		$this->LanguageHelper->ChangeTableName($this->TableName);
    }
	
    // fill Sections from POST
    function Sections_POST($post)
    {
    	$this->SfStatus = $this->ObjectFactory->createObject("SfStatus",-1);
    	
    	$this->SectionsID = isset($post["sections_id"]) ? $post["sections_id"] : -1;
		$this->Header = isset($post["header"]) ? $post["header"] : "";
		$this->ShortHtml = isset($post["shorthtml"]) ? $post["shorthtml"] : "";
		$this->Html = isset($post["html"]) ? $post["html"] : "";
		$this->SectionLink = isset($post["section_link"]) ? $post["section_link"] : "";		
        $this->Slika = isset($post["slika"]) ? $post["slika"] : "";
        $this->SlikaThumb = isset($post["slikathumb"]) ? $post["slikathumb"] : "";
        
		$this->SfStatus->setStatusID(isset($post["statusid"])? $post["statusid"] : $this->SfStatus->getStatusID());		
		$this->SectionsCategory = array();
    }
    
    // DatabaseBroker functions
    function vratiImenaAtributa() {return "`sections_id` , `header` , `shorthtml`, `html` , `section_link`,`slika`,`slika_thumb`,`status_id`,`created_by`,`created_date`,`modified_by`,`modified_date`";}
    function vratiImeKlase(){return $this->TableName;}
	function vratiVrednostiAtributa(){ return "'',". $this->quote_smart($this->Header) . ",". $this->quote_smart($this->ShortHtml).",". $this->quote_smart($this->Html) . ",". $this->quote_smart($this->SectionLink) . ",	".$this->quote_smart($this->Slika) . " , ".$this->quote_smart($this->SlikaThumb) . " ,". $this->quote_smart($this->SfStatus->getStatusID()) .",". $this->quote_smart($this->getCreatedBy()).", ". $this->quote_smart($this->getCreatedDate()).", ". $this->quote_smart($this->getModifiedBy()).", ". $this->quote_smart($this->getModifiedDate()); }
    function postaviVrednostiAtributa(){ return "`header` = ".$this->quote_smart($this->Header). " , `shorthtml` = ".$this->quote_smart($this->ShortHtml)." , `html` = ".$this->quote_smart($this->Html).",`section_link` = ".$this->quote_smart($this->SectionLink).",`slika` =". $this->quote_smart($this->Slika).",`slika_thumb` =". $this->quote_smart($this->SlikaThumb).",`status_id` =".$this->quote_smart($this->SfStatus->getStatusID()).",`created_by` =". $this->quote_smart($this->getCreatedBy()).",`created_date` =". $this->quote_smart($this->getCreatedDate()).",`modified_by` =". $this->quote_smart($this->getModifiedBy()).",`modified_date` =". $this->quote_smart($this->getModifiedDate()); }
	function nazivVezeKaRoditelju(){ return "sections";}
    function vratiAtributPretrazivanja(){ return "sections_id"; }
    function vratiUslovZaNadjiSlog(){ return "sections_id=" . $this->quote_smart($this->SectionsID);}
    function vratiFulltextIndekse(){ return  "header, html, shorthtml";} //definisemo polja nad kojima je postavljem fulltext index
	function vratiUslovZaSortiranje(){ return "created_date DESC";} //??
	function vratiUslovZaNadjiSlogF(){ return "sections_id=" . $this->quote_smart($this->SectionsID);}
	function vratiUslovZaNadjiSlogove(){ return "1";}
	function postaviID($id){ $this->SectionsID = $id;}
	function toString() {}
	
	function napuni($result_row)
	{
		$this->SectionsID = $result_row->sections_id;
		$this->Header = $result_row->header;
		$this->ShortHtml= $result_row->shorthtml;
		$this->Html = $result_row->html;
		$this->SectionLink = $result_row->section_link;		
		$this->Slika = $result_row->slika;
		$this->SlikaThumb = $result_row->slika_thumb;
		$this->SfStatus->setStatusID($result_row->status_id);
		$this->CreatedBy= $result_row->created_by;
		$this->CreatedDate = $result_row->created_date;
		$this->ModifiedBy = $result_row->modified_by;
		$this->ModifiedDate = $result_row->modified_date;
  	}

	function napuniNiz($result_set, &$al)
	{
		if(count($result_set)>0)
			foreach($result_set as $result_row){
				$nw = $this->ObjectFactory->createObject("Sections",-1);
				$nw->SectionsID = $result_row->sections_id;
				$nw->Header = $result_row->header;
				$nw->ShortHtml= $result_row->shorthtml;
				$nw->Html = $result_row->html;
				$nw->SectionLink = $result_row->section_link;				
				$nw->Slika = $result_row->slika;
				$nw->SlikaThumb = $result_row->slika_thumb;
				$nw->SfStatus->setStatusID($result_row->status_id);
				$nw->CreatedBy= $result_row->created_by;
				$nw->CreatedDate = $result_row->created_date;
				$nw->ModifiedBy = $result_row->modified_by;
				$nw->ModifiedDate = $result_row->modified_date;
				array_push($al, $nw);
			}
	}
	
	function vratiImeVezneTabele($relation_class_name,& $vezna_klasa, & $uslov_join)
	{
		$sectionsCategory = $this->LanguageHelper->ChangeTableNameR("sectionscategory");
		$sectionsSectionsCategory = $this->LanguageHelper->ChangeTableNameR("sectionssectionscategory");
	
		switch ($relation_class_name)
		{
			case $sectionsCategory:
				$vezna_klasa = $sectionsSectionsCategory;
				$uslov_join = "IJ1.sections_category_id= IJ2.sectionscategoryid";
				break;
			default: $vezna_klasa = "";
			break;
		}
	}
	
	function napuniVisePovezi($result_set, $relation_name)
	{
		switch ($relation_name){
			case "sfstatus":
				if (count($result_set) > 0) { $this->SfStatus->napuni($result_set); }
				break;
			case "sectionscategory":
				if(count($result_set)>0)
					foreach($result_set as $db_res){
					$sectionsCategory = $this->ObjectFactory->createObject("SectionsCategory",-1);
					$sectionsCategory->napuni($db_res);
					array_push($this->SectionsCategory, $sectionsCategory);
				}
				break;
			default: break;
		}
	}
	
	function toArray()
	{
		$arr = array();
			$arr = array_merge($arr, array("sectionsid" => $this->getSectionsID()));
			$arr = array_merge($arr, array("header" => $this->getHeader()));
			$arr = array_merge($arr, array("shorthtml" => $this->getShortHtml()));
			$arr = array_merge($arr, array("html" => $this->getHtml()));
			$arr = array_merge($arr, array("sectionlink" => $this->getSectionLink()));			
			$arr = array_merge($arr, array("slika" => $this->getSlika()));
			$arr = array_merge($arr, array("slikathumb" => $this->getSlikaThumb()));
			$arr = array_merge($arr, array("statusid" => $this->getStatusID()));
			$arr = array_merge($arr, array("sectionscategoryprint" => $this->getSectionsCategoryPrint()));
			$arr = array_merge($arr, array("createdby" => $this->getCreatedBy()));
			$arr = array_merge($arr, array("modifiedby" => $this->getModifiedBy()));
			$arr = array_merge($arr, array("createddate" => $this->LanguageHelper->getDateTranslated($this->getCreatedDate(),"d. F Y.")));
			$arr = array_merge($arr, array("modifieddate" => $this->LanguageHelper->getDateTranslated($this->getModifiedDate(),"d. F Y.")));
		return $arr;
	}
	
	// getter and setter
	function getSectionsID()
	{
		return $this->SectionsID;
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
	function getSectionLink()
	{
		return $this->SectionLink;
	}		
	function getSlika()
	{
		return $this->Slika;
	}
	function getSlikaThumb()
	{
		return $this->SlikaThumb;
	}
	function getSfStatus()
	{
		return $this->SfStatus;
	}
	function getStatusID()
	{
		return $this->SfStatus->StatusID;
	}
	function getSectionsCategoryPrint()
	{
		$output = "";
		if($this->SectionsCategory != null)
		{
			foreach($this->SectionsCategory as $nwc)
			{
				$output .= $nwc->getTitle() . ", ";
			}
		}
		
		return substr($output, 0, strlen($output)-2);
	}
	
	function getSectionsCategory()
	{
		return $this->SectionsCategory;		
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
	function setSectionsID($val)
	{
		$this->SectionsID = $val;
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
	function setSectionLink($val)
	{
		$this->SectionLink = $val;
	}	
	function setSlika($val)
	{
		$this->Slika = $val;
	}
	function setSlikaThumb($val)
	{
		$this->SlikaThumb = $val;
	}
	function setStatusID($val)
	{
		$this->SfStatus->StatusID = $val;
	}
	function setSectionsCategory($val)
	{
		$this->SectionsCategory = $val;
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
		return 'sectionsid='.$this->SectionsID;
	}
}

// klasa PrSectionsGrupaProiz cuva veze izmedju sectionsa i grupe sectionsa
class SectionsSectionsCategory extends OpstiDomenskiObjekat
{
	private $SectionsID;
	private $SectionsCategoryID;
	private $SectionsSectionsCategoryOrder;

	//Bussiness PHP Object constructor
	function __construct()
	{
		parent::__construct();

		$this->SectionsID = -1;
		$this->SectionsCategoryID = -1;
		$this->SectionsSectionsCategoryOrder = 0;
		$this->TableName = "sectionssectionscategory";
		$this->LanguageHelper->ChangeTableName($this->TableName);
	}

	// fill SectionsSectionsCategory from POST
	function SectionsSectionsCategory_POST($post)
	{
		$this->SectionsID = isset($post["sectionsid"]) ? $post["sectionsid"] : $this->SectionsID;
		$this->SectionsCategoryID = isset($post["sectionscategoryid"]) ? $post["sectionscategoryid"] : $this->SectionsCategoryID;
		$this->SectionsSectionsCategoryOrder = isset($post["sectionssectionscategoryorder"]) ? $post["sectionssectionscategoryorder"] : $this->SectionsSectionsCategoryOrder;
	}

	function vratiImenaAtributa() {
		return "`sections_id`,`sections_category_id`,`sections_sectionscategory_order`";
	}
	function vratiImeKlase(){
		return $this->TableName;
	}
	function vratiVrednostiAtributa(){
		return $this->quote_smart($this->SectionsID).",".$this->quote_smart($this->SectionsCategoryID).",".$this->quote_smart($this->SectionsSectionsCategoryOrder);
	}
	function postaviVrednostiAtributa(){
		return "`sections_category_id` = ".$this->quote_smart($this->SectionsCategoryID).",`sections_sectionscategory_order` = ".$this->quote_smart($this->SectionsSectionsCategoryOrder);
	}
	function nazivVezeKaRoditelju(){
		return "sections";
	}
	function vratiUslovZaNadjiSlog(){
		return "sections_id=".$this->quote_smart($this->SectionsID)." AND sections_category_id=".$this->quote_smart($this->SectionsCategoryID);
	}
	function vratiUslovZaSortiranje(){
		return "sections_sectionscategory_order desc";
	}
	function vratiUslovZaNadjiSlogF(){
		return "sections_id=".$this->quote_smart($this->SectionsID);
	}
	function vratiUslovZaNadjiSlogove(){
		return "sections_id=".$this->quote_smart($this->SectionsID);
	}
	function postaviID($id){
		$this->SectionsID = $id;
	}
	function vratiAtributZaMax(){
		return "`sections_sectionscategory_order`";
	}
	function napuni($result_row){
		$this->SectionsID = $result_row->sections_id;
		$this->SectionsCategoryID = $result_row->sections_category_id;
		$this->SectionsSectionsCategoryOrder = $result_row->sections_sectionscategory_order;
	}
	function napuniNiz($result_set, &$al){
		if(count($result_set)>0)
			foreach($result_set as $result_row){
			$sectionsCateg= $this->ObjectFactory->createObject("SectionsSectionsCategory",-1);
			$sectionsCateg->SectionsID = $result_row->sections_id;
			$sectionsCateg->SectionsCategoryID = $result_row->sections_category_id;
			$sectionsCateg->SectionsSectionsCategoryOrder = $result_row->sections_sectionscategory_order;
			array_push($al, $sectionsCateg);
		}
	}
	function toArray()
	{
		$arr = array();
		$arr = array_merge($arr, array("sectionsid" => $this->getSectionsID()));
		$arr = array_merge($arr, array("sectionscategoryid" => $this->getSectionsCategoryID()));
		$arr = array_merge($arr, array("sectionssectionscategoryorder" => $this->getSectionsSectionsCategoryOrder()));
		return $arr;
	}

	// get metode
	function getSectionsID()
	{
		return $this->SectionsID;
	}
	function getSectionsCategoryID()
	{
		return $this->SectionsCategoryID;
	}
	function getSectionsSectionsCategoryOrder()
	{
		return $this->SectionsSectionsCategoryOrder;
	}
	// set metode
	function setSectionsID($val)
	{
		$this->SectionsID= $val;
	}
	function setSectionsCategoryID($val)
	{
		$this->SectionsCategoryID = $val;
	}
	function setSectionsSectionsCategoryOrder($val)
	{
		$this->SectionsSectionsCategoryOrder = $val;
	}
	function getLinkID()
	{
		return 'sectionsid='.$this->SectionsID;
	}

}

	


?>