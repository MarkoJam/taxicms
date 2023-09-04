<?
/* CMS Studio 3.0 page.php secured */

class Page extends OpstiDomenskiObjekat
{
    private $PageID;
	private $ParentID;
	private $Level;
	private $Order;
	private $Header;
	private $HeaderUrlized;
	private $SubHeader;
    private $ShortHtml;
    private $Html;
    private $Keywords;
    private $Description;
	private $UserRoleID;
	private $GrupaProizvodaID;
	private $NavigationType;
	private $Frequency;
	private $Priority;
	private $CreatedBy;
	private $CreatedDate;
	private $ModifyBy;
	private $ModifyDate;
	
	public $Template;
	public $SfStatus;
	public $SfPageType;		
	public $SfPageProtection;		
	
	//Bussiness PHP Object constructor
    function __construct()
    {
    	parent::__construct();
    	
        $this->PageID = -1;
        $this->ParentID = -1;
        $this->Template = $this->ObjectFactory->createObject("Template",-1);
        $this->SfStatus = $this->ObjectFactory->createObject("SfStatus",-1);
        $this->SfPageType = $this->ObjectFactory->createObject("SfPageType",-1);
        $this->SfPageProtection = $this->ObjectFactory->createObject("SfPageProtection",-1);
        $this->Level = 0;
		$this->Order =0;
		$this->Header = "";
		$this->HeaderUrlized = "";
		$this->SubHeader = "";
		$this->ShortHtml = "";
		$this->Html = "";
		$this->Keywords = "";
		$this->Description = "";
		//$this->Access = $this->ObjectFactory->createObject("SfStatus",-1);
		$this->UserRoleID= 0;
		$this->GrupaProizvodaID= -1;
		$this->NavigationType = "horizontal";
		$this->Frequency = 164;
		$this->Priority = 0.5;
		$this->CreatedBy= "";
		$this->CreatedDate= 0;
		$this->ModifyBy= "";
		$this->ModifyDate= 0;
		

		
		$this->Pages = array();

		$this->TableName = "page";
		$this->LanguageHelper->ChangeTableName($this->TableName);
    }
	
    // fill Page from POST
    function Page_POST(&$post)
    {
    	$this->Template = $this->ObjectFactory->createObject("Template",-1);
    		
    	$this->PageID = isset($post["pageid"]) ? $post["pageid"] : $this->PageID;
        $this->ParentID = isset($post["parentid"]) ? $post["parentid"] : $this->ParentID;
        $this->Level = isset($post["level"]) ? $post["level"] : $this->Level;
		$this->Order = isset($post["order"]) ? $post["order"] : $this->Order;
		$this->Header = isset($post["header"])? $post["header"] : $this->Header;
		$this->HeaderUrlized = isset($post["headerurlized"])? $post["headerurlized"] : $this->HeaderUrlized;
		$this->SubHeader = isset($post["subheader"])? $post["subheader"] : $this->SubHeader;
		$this->ShortHtml = isset($post["shorthtml"])? $post["shorthtml"] : $this->ShortHtml;
		$this->Html = isset($post["html"])? $post["html"] : $this->Html;
		$this->Keywords = isset($post["keywords"])? $post["keywords"] : $this->Keywords;
		$this->Description = isset($post["description"])? $post["description"] : $this->Description;
		//$this->Access= isset($post["access"])? $post["access"] : $this->Access;
		$this->UserRoleID = isset($post["userroleid"])? $post["userroleid"] : $this->UserRoleID;
		$this->GrupaProizvodaID = isset($post["grupaproizvodaid"])? $post["grupaproizvodaid"] : $this->GrupaProizvodaID;
		$this->NavigationType = isset($post["navigationtype"])? $post["navigationtype"] : $this->NavigationType;
		$this->Frequency = isset($post["frequency"])? $post["frequency"] : $this->Frequency;
		$this->Priority = isset($post["priority"])? $post["priority"] : $this->Priority;
		$this->CreatedBy = isset($post["createdby"])? $post["createdby"] : $this->CreatedBy;
		$this->CreatedDate = isset($post["createddate"])? $post["createddate"] : $this->CreatedDate;
		$this->ModifyBy = isset($post["modifyby"])? $post["modifyby"] : $this->ModifyBy;
		$this->ModifyDate = isset($post["modifydate"])? $post["modifydate"] : $this->ModifyDate;
		
		$this->Template->TemplateID = isset($post["templateid"]) ? $post["templateid"] : $this->Template->TemplateID;		
		$this->SfStatus->StatusID = isset($post["statusid"])? $post["statusid"] : $this->SfStatus->StatusID;
		
		$this->SfPageType->ID = isset($post["pagetypeid"])? $post["pagetypeid"] : $this->SfPageType->ID;
		$this->SfPageProtection->ID = isset($post["pageprotectionid"])? $post["pageprotectionid"] : $this->SfPageProtection->ID;
    }
	
    function Page_COPY($page)
    {
    	$this->Template = $this->ObjectFactory->createObject("Template",-1);
        $this->SfStatus = $this->ObjectFactory->createObject("SfStatus",-1);
        $this->SfPageType = $this->ObjectFactory->createObject("SfPageType",-1);
        $this->SfPageProtection = $this->ObjectFactory->createObject("SfPageProtection",-1);
    	
    	$this->setPageID($page->getPageID());
    	$this->setParentID($page->getParentID());
    	$this->setLevel($page->getLevel());
    	$this->setOrder($page->getOrder());
    	$this->setHeader($page->getHeader());
    	$this->setHeaderUrlized($page->getHeaderUrlized());
    	$this->setSubHeader($page->getSubHeader());
    	$this->setShortHtml($page->getShortHtml());
    	$this->setHtml($page->getHtml());
    	$this->setKeywords($page->getKeywords());
    	$this->setDescription($page->getDescription());
    	//$this->setUserRoleID($page->getUserRoleID());
    	$this->setGrupaProizvodaID($page->getGrupaProizvodaID());
    	$this->setNavigationType($page->getNavigationType());
    	
		$this->setFrequency($page->getFrequency());
		$this->setPriority($page->getPriority());
		$this->setCreatedBy($page->getCreatedBy());
		$this->setCreatedDate($page->getCreatedDate());
		$this->setModifyBy($page->getModifyBy());
		$this->setModifyDate($page->getModifyDate());
			
    	$this->Template->setTemplateID($page->getTemplate()->getTemplateID());
    	$this->SfStatus->setStatusID($page->SfStatus->getStatusID());
    	$this->SfPageType->setID($page->SfPageType->getID());
    	$this->SfPageProtection->setID($page->SfPageProtection->getID());
    }
    
    // DatabaseBroker functions
    function vratiImenaAtributa() {return "`page_id`,`parent_id`,`template_id`,`level`,`page_order`,`header`,`header_urlized`,`sub_header`,`short_html`,`html`,`keywords`,`description`,`type_id`,
		`status_id`,`protection_id`,`userroleid`, `grupaproizvoda_id`,`navigation_type`,
		`frequency`,`priority`,`created_by`,`created_date`,`modify_by`,`modify_date`";}
    function vratiImeKlase(){return $this->TableName;}
    function vratiVrednostiAtributa(){ return "'',".$this->quote_smart($this->ParentID).",
	".$this->quote_smart($this->Template->TemplateID).",
	".$this->quote_smart($this->Level).",
	".$this->quote_smart($this->Order).",
	".$this->quote_smart($this->Header).",
	".$this->quote_smart($this->HeaderUrlized).",
	".$this->quote_smart($this->SubHeader).",
	".$this->quote_smart($this->Html).",
	".$this->quote_smart($this->ShortHtml).",
	".$this->quote_smart($this->Keywords).",
	".$this->quote_smart($this->Description).",
	".$this->quote_smart($this->SfPageType->ID).",
	".$this->quote_smart($this->SfStatus->StatusID).",
	".$this->quote_smart($this->SfPageProtection->ID).",
	". $this->quote_smart($this->UserRoleID).",
	". $this->quote_smart($this->GrupaProizvodaID).",
	". $this->quote_smart($this->NavigationType).",	
	". $this->quote_smart($this->Frequency).",
	". $this->quote_smart($this->Priority).",
	". $this->quote_smart($this->CreatedBy).",
	". $this->quote_smart($this->CreatedDate).",
	". $this->quote_smart($this->ModifyBy).",
	". $this->quote_smart($this->ModifyDate);}
	
	function postaviVrednostiAtributa(){ return "`parent_id` = ".$this->quote_smart($this->ParentID).",
	`template_id` = ".$this->quote_smart($this->Template->TemplateID).",
	`level` = ".$this->quote_smart($this->Level).",
	`page_order` = ".$this->quote_smart($this->Order).",
	`header` = ".$this->quote_smart($this->Header).",
	`header_urlized` = ".$this->quote_smart($this->HeaderUrlized).",
	`sub_header` = ".$this->quote_smart($this->SubHeader).",
	`short_html` = ".$this->quote_smart($this->ShortHtml).",
	`html` = ".$this->quote_smart($this->Html).",
	`keywords` = ".$this->quote_smart($this->Keywords).",
	`description` = ".$this->quote_smart($this->Description).",
	`type_id` = ".$this->quote_smart($this->SfPageType->ID).",
	`status_id` = ".$this->quote_smart($this->SfStatus->StatusID).",
	`protection_id` = ".$this->quote_smart($this->SfPageProtection->ID).",
	`userroleid` = ".$this->quote_smart($this->UserRoleID).",
	`grupaproizvoda_id` = ".$this->quote_smart($this->GrupaProizvodaID).",
	`navigation_type` = ".$this->quote_smart($this->NavigationType).",
	`frequency` = ".$this->quote_smart($this->Frequency).",
	`priority` = ".$this->quote_smart($this->Priority).",
	`created_by` = ".$this->quote_smart($this->CreatedBy).",
	`created_date` = ".$this->quote_smart($this->CreatedDate).",
	`modify_by` = ".$this->quote_smart($this->ModifyBy).",
	`modify_date` = ".$this->quote_smart($this->ModifyDate);}
	
	function nazivVezeKaRoditelju(){ return "pages";}
    function vratiAtributPretrazivanja(){ return "page_id"; }
    function vratiUslovZaNadjiSlog(){ return "page_id=" . $this->quote_smart($this->PageID);}
	function vratiUslovZaSortiranje(){ return "`page_order`";}
	function vratiUslovZaNadjiSlogF(){ return "parent_id=" . $this->quote_smart($this->PageID);}
	function vratiUslovZaNadjiSlogove(){ return "1";}
	function vratiFulltextIndekse(){ return "header , html";} //definisemo polja nad kojima je postavljem fulltext index
	function postaviID($id){ $this->PageID = $id;}
	function toString() {}
	
	function napuni($result_row)
	{
		$this->PageID = $result_row->page_id;
		$this->ParentID = $result_row->parent_id;
		$this->Template->TemplateID = $result_row->template_id;
		$this->Level = $result_row->level;
		$this->Order = $result_row->page_order;
		$this->Header = $result_row->header;
		$this->HeaderUrlized = $result_row->header_urlized;
		$this->SubHeader = $result_row->sub_header;
		$this->ShortHtml = $result_row->short_html;
		$this->Html = $result_row->html;
		$this->Keywords = $result_row->keywords;
		$this->Description = $result_row->description;
		$this->SfPageType->ID = $result_row->type_id;
		$this->SfStatus->StatusID = $result_row->status_id;
		$this->SfPageProtection->ID = $result_row->protection_id;
		$this->UserRoleID= $result_row->userroleid;
		$this->GrupaProizvodaID= $result_row->grupaproizvoda_id;
		$this->NavigationType = $result_row->navigation_type;
		
		$this->Frequency = $result_row->frequency;
		$this->Priority = $result_row->priority;
		$this->CreatedBy = $result_row->created_by;
		$this->CreatedDate = $result_row->created_date;
		$this->ModifyBy = $result_row->modify_by;
		$this->ModifyDate = $result_row->modify_date;
  	}

	function napuniNiz($result_set, &$al)
	{
		if($this->count($result_set)>0)
			foreach($result_set as $result_row){
				$pg = $this->ObjectFactory->createObject("Page",-1);
				$pg->PageID = $result_row->page_id;
				$pg->ParentID = $result_row->parent_id;
				$pg->Template->TemplateID = $result_row->template_id;
				$pg->Level = $result_row->level;
				$pg->Order = $result_row->page_order;
				$pg->Header = $result_row->header;
				$pg->HeaderUrlized = $result_row->header_urlized;
				$pg->SubHeader = $result_row->sub_header;
				$pg->ShortHtml = $result_row->short_html;
				$pg->Html = $result_row->html;
				$pg->Keywords = $result_row->keywords;
				$pg->Description = $result_row->description;
				$pg->SfPageType->ID = $result_row->type_id;
				$pg->SfStatus->StatusID = $result_row->status_id;
				$pg->SfPageProtection->ID = $result_row->protection_id;
				$pg->UserRoleID= $result_row->userroleid;
				$pg->GrupaProizvodaID= $result_row->grupaproizvoda_id;
				$pg->NavigationType= $result_row->navigation_type;
				$pg->Frequency= $result_row->frequency;
				$pg->Priority= $result_row->priority;
				$pg->CreatedBy= $result_row->created_by;
				$pg->CreatedDate= $result_row->created_date;
				$pg->ModifyBy= $result_row->modify_by;
				$pg->ModifyDate= $result_row->modify_date;
				array_push($al, $pg);
			}
	}
	
	function napuniVisePovezi($result_set, $relation_name)
	{
			switch ($relation_name){
					//ubaceno kako bi se ostvarila veza stranice sa njenim podredjenim
					case "pages":
					     if($this->count($result_set)>0)
						 foreach($result_set as $db_res)
                         {
                          	$pg = $this->ObjectFactory->createObject("Page",-1);
							$pg->napuni($db_res);
                          	array_push($this->Pages,$pg);
                         }
                         break;
                    case "template":
						if($this->count($result_set)>0) $this->Template->napuni($result_set);
						break;
					case "sfstatus":
						if($this->count($result_set)>0) $this->SfStatus->napuni($result_set);
						break;
					case "sfpagetype":
						if($this->count($result_set)>0) $this->SfPageType->napuni($result_set);
						break;
					case "sfpageprotection":
						if($this->count($result_set)>0) $this->SfPageProtection->napuni($result_set);
						break;
                   default: break;
           }
  	}
    //kraj funkcija za rad sa database brokerom
    
    function toArray()
	{
		$arr = array();
			$arr = array_merge($arr, array("pageid" => $this->getPageID()));
			$arr = array_merge($arr, array("parentid" => $this->getParentID()));
			$arr = array_merge($arr, array("templateid" => $this->getTemplateID()));
			$arr = array_merge($arr, array("level" => $this->getLevel()));
			$arr = array_merge($arr, array("order" => $this->getOrder()));
			$arr = array_merge($arr, array("header" => $this->getHeader()));
			$arr = array_merge($arr, array("headerurlized" => $this->getHeaderUrlized()));
			$arr = array_merge($arr, array("subheader" => $this->getSubHeader()));
			$arr = array_merge($arr, array("shorthtml" => $this->getShortHtml()));
			$arr = array_merge($arr, array("html" => $this->getHtml()));
			$arr = array_merge($arr, array("keywords" => $this->getKeywords()));
			$arr = array_merge($arr, array("description" => $this->getDescription()));
			$arr = array_merge($arr, array("typeid" => $this->getTypeID()));
			$arr = array_merge($arr, array("statusid" => $this->getStatusID()));
			$arr = array_merge($arr, array("protectionid" => $this->getProtectionID()));
			$arr = array_merge($arr, array("userroleid" => $this->getUserroleid()));
			$arr = array_merge($arr, array("grupaproizvodaid" => $this->GrupaProizvodaID));
			$arr = array_merge($arr, array("navigationtype" => $this->NavigationType));
			$arr = array_merge($arr, array("frequency" => $this->Frequency));
			$arr = array_merge($arr, array("priority" => $this->Priority));
			$arr = array_merge($arr, array("createdby" => $this->CreatedBy));
			$arr = array_merge($arr, array("createddate" => $this->CreatedDate));
			$arr = array_merge($arr, array("modifyby" => $this->ModifyBy));
			$arr = array_merge($arr, array("modifydate" => $this->ModifyDate));
		return $arr;
	}
	
	function toArrayHierarchy()
	{
		$arr = array(
				"id" => $this->getPageID(),
				"parentid" => $this->getParentID(),
				"title" => $this->getHeader(),
				"image" => "",
				"link" => "?pageid=".$this->getPageID(),
				"count" => 0,
				"templateid" => $this->getTemplateID()
		);
		return $arr;
	}
	
	function getPageID()
	{
		return $this->PageID;
	}
	function getParentID()
	{
		return $this->ParentID;
	}
	
	function getTemplate()
	{
		return $this->Template;		
	}
	
	function getTemplateID()
	{
		return $this->Template->getTemplateID();
	}
	function getLevel()
	{
		return $this->Level;
	}
	function getOrder()
	{
		return $this->Order;
	}
	function getHeaderUnchanged()
	{
		return $this->Header;
	}
	function getHeader()
	{
		return $this->LanguageHelper->Transliterate($this->Header);
	}
	function getHeaderUrlized()
	{
		return $this->HeaderUrlized;
	}
	function getSubHeader()
	{
		return $this->LanguageHelper->Transliterate($this->SubHeader);
	}
	function getShortHtmlUnchanged()
	{
		return $this->ShortHtml;
	}
	function getHtmlUnchanged()
	{
		return $this->Html;
	}
	function getShortHtml()
	{
		return $this->LanguageHelper->Transliterate($this->ShortHtml);
	}
	function getHtml()
	{
		return $this->LanguageHelper->Transliterate($this->Html);
	}
	function getKeywords()
	{
		return $this->Keywords;
	}
	function getDescription()
	{
		return $this->Description;
	}
	function getTypeID()
	{
		return $this->SfPageType->ID;
	}
	function getSfStatus()
	{
		return $this->SfStatus;
	}
	function getStatusID()
	{
		return $this->SfStatus->getStatusID();
	}
	function getProtectionID()
	{
		return $this->SfPageProtection->ID;
	}
	function getUserRole()
	{
		return $this->UserRole;
	}
	function getUserRoleID()
	{
		return $this->UserRoleID;
	}
	function getGrupaProizvodaID()
	{
		return $this->GrupaProizvodaID;
	}
	function getNavigationType()
	{
		return $this->NavigationType;
	}
	function getFrequency()
	{
		return $this->Frequency;
	}	
	function getPriority()
	{
		return $this->Priority;
	}	
	function getCreatedBy()
	{
		return $this->CreatedBy;
	}	
	function getCreatedDate()
	{
		return $this->CreatedDate;
	}	
	function getModifyBy()
	{
		return $this->ModifyBy;
	}	
	function getModifyDate()
	{
		return $this->ModifyDate;
	}		
	function getSfPageProtection()
	{
		return $this->SfPageProtection;
	}
	
	function getSfPageType()
	{
		return $this->SfPageType;
	}
	
	function setPageID($val)
	{
		$this->PageID = $val;
	}
	function setParentID($val)
	{
		$this->ParentID = $val;
	}
	function setTemplateID($val)
	{
		$this->Template->TemplateID = $val;
	}
	function setLevel($val)
	{
		$this->Level = $val;
	}
	function setOrder($val)
	{
		$this->Order = $val;
	}
	function setHeader($val)
	{
		$this->Header = $val;
	}
	function setHeaderUrlized($val)
	{
		$this->HeaderUrlized = $val;
	}
	function setSubHeader($val)
	{
		$this->SubHeader = $val;
	}
	function setShortHtml($val)
	{
		$this->ShortHtml = $val;
	}	
	function setHtml($val)
	{
		$this->Html = $val;
	}
	function setKeywords($val)
	{
		$this->Keywords = $val;
	}
	function setDescription($val)
	{
		$this->Description = $val;
	}
	function setTypeID($val)
	{
		$this->SfPageType->ID = $val;
	}
	function setStatusID($val)
	{
		$this->SfStatus->StatusID = $val;
	}
	function setProtectionID($val)
	{
		$this->ProtectionID = $val;
	}
	function setUserRoleID($val)
	{
		$this->UserRoleID = $val;
	}
	function setGrupaProizvodaID($val)
	{
		$this->GrupaProizvodaID = $val;
	}
	function setNavigationType($val)
	{
		$this->NavigationType = $val;
	}
	function setFrequency($val)
	{
		$this->Frequency = $val;
	}
	function setPriority($val)
	{
		$this->Priority = $val;
	}
	function setCreatedBy($val)
	{
		$this->CreatedBy = $val;
	}
	function setCreatedDate($val)
	{
		$this->CreatedDate = $val;
	}
	function setModifyBy($val)
	{
		$this->ModifyBy = $val;
	}
	function setModifyDate($val)
	{
		$this->ModifyDate = $val;
	}		
	function getLinkID()
	{
		return 'pageid='.$this->PageID;
	}
}

?>
