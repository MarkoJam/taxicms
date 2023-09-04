<?

/* CMS Studio 3.0 spage.php secured */

class StaticPage extends OpstiDomenskiObjekat 
{
	public $SPageID;
	public $Template;
	private $Level;
	private $Order;
	public $Header;
	public $Html;
	
	public $SfStatus;
	public $SfPageType;
	//Bussiness PHP Object constructor
	function __construct()
	{
		parent::__construct();
		
		$this->SPageID = -1;
		$this->Template =  $this->ObjectFactory->createObject("Template",-1);
		$this->SfStatus = $this->ObjectFactory->createObject("SfStatus",-1);
		$this->SfPageType = $this->ObjectFactory->createObject("SfPageType",-1);
		$this->Level = 0;
		$this->Order = 0;
		$this->Header = "";
		$this->Html = "";
		
		$this->TableName = "staticpage";
		$this->LanguageHelper->ChangeTableName($this->TableName);
	}

	// fill StaticPage from POST
	function StaticPage_POST(&$post)
	{
		$this->Template= $this->ObjectFactory->createObject("Template",-1);
		$this->SfStatus = $this->ObjectFactory->createObject("SfStatus",-1);
		
		$this->SPageID= isset($post["spageid"]) ? $post["spageid"] : $this->SPageID;
		$this->Template->TemplateID = isset($post["templateid"]) ? $post["templateid"] : $this->Template->TemplateID;
		$this->Level = isset($post["level"]) ?$post["level"] : $this->Level;
		$this->Order = isset($post["order"]) ? $post["order"] : $this->Order;
		$this->Header = isset($post["header"]) ? $post["header"] : $this->Header;
		$this->Html = isset($post["html"]) ? $post["html"] : $this->Html;
		$this->SfStatus->StatusID = isset($post["statusid"]) ? $post["statusid"] : $this->SfStatus->StatusID;
		$this->SfPageType->ID = isset($post["typeid"])? $post["typeid"] : $this->SfPageType->ID;
	}
	
	function vratiImenaAtributa() {return "`spage_id`,`template_id`,`level`,`staticpage_order`,`header`,`html`,`type_id`,`status_id`";}
	function vratiImeKlase(){return $this->TableName;}
	function vratiVrednostiAtributa(){ return "'',".$this->quote_smart($this->Template->TemplateID).",".$this->quote_smart($this->Level).",".$this->quote_smart($this->Order).",".$this->quote_smart($this->Header).",".$this->quote_smart($this->Html).",".$this->quote_smart($this->SfPageType->ID).",".$this->quote_smart($this->SfStatus->StatusID);}
	function postaviVrednostiAtributa(){ return "`template_id` = ".$this->quote_smart($this->Template->TemplateID).",`level` = ".$this->quote_smart($this->Level).",`staticpage_order` = ".$this->quote_smart($this->Order).",`header` = ".$this->quote_smart($this->Header).",`html` = ".$this->quote_smart($this->Html).",`type_id` = ".$this->quote_smart($this->SfPageType->ID).",`status_id` = ".$this->quote_smart($this->SfStatus->StatusID);}
	function nazivVezeKaRoditelju(){ return "";}
	function vratiUslovZaNadjiSlog(){ return "spage_id=".$this->quote_smart($this->SPageID);}
	function vratiUslovZaSortiranje(){ return "`staticpage_order`";}
	function vratiUslovZaNadjiSlogF(){ return "spage_id=".$this->quote_smart($this->SPageID);}
	function vratiUslovZaNadjiSlogove(){ return "1";}
	function vratiAtributZaMax(){ return "`staticpage_order`";}
	function postaviID($id){ $this->SPageID = $id;}
	function napuni($result_row)
	{
		$this->SPageID = $result_row->spage_id;
		$this->Template->TemplateID = $result_row->template_id;
		$this->Level = $result_row->level;
		$this->Order = $result_row->staticpage_order;
		$this->Header = $result_row->header;
		$this->Html = $result_row->html;
		$this->SfPageType->ID = $result_row->type_id;
		$this->SfStatus->StatusID = $result_row->status_id;
	}
	
	function napuniNiz($result_set, &$al)
	{
		if(count($result_set)>0)
		{
			foreach($result_set as $result_row)
			{
				$statpg = $this->ObjectFactory->createObject("StaticPage",-1);
				$statpg->SPageID = $result_row->spage_id;
				$statpg->Template->TemplateID = $result_row->template_id;
				$statpg->Level = $result_row->level;
				$statpg->Order = $result_row->staticpage_order;
				$statpg->Header = $result_row->header;
				$statpg->Html = $result_row->html;
				$statpg->SfPageType->ID = $result_row->type_id;
				$statpg->SfStatus->StatusID = $result_row->status_id;
				array_push($al, $statpg);
			}
		}
	}
	
	function napuniVisePovezi($result_set, $relation_name)
	{
		switch ($relation_name){
			case "template":
				if(count($result_set)>0) $this->Template->napuni($result_set);
				break;
			case "sfstatus":
				if(count($result_set)>0) $this->SfStatus->napuni($result_set);
				break;
			case "sfpagetype":
						if(count($result_set)>0) $this->SfPageType->napuni($result_set);
						break;
			default: break;
		}
	}
	
	function toArray()
	{
		$arr = array();
		$arr = array_merge($arr, array("spageid" => $this->getSPageID()));
		$arr = array_merge($arr, array("templateid" => $this->getTemplateID()));
		$arr = array_merge($arr, array("level" => $this->getLevel()));
		$arr = array_merge($arr, array("order" => $this->getOrder()));
		$arr = array_merge($arr, array("header" => $this->getHeader()));
		$arr = array_merge($arr, array("html" => $this->getHtml()));
		$arr = array_merge($arr, array("typeid" => $this->SfPageType->getPageTypeID()));
		$arr = array_merge($arr, array("statusid" => $this->SfStatus->getStatusID()));
		return $arr;
	}
	
	function getSPageID()
	{
		return $this->SPageID;
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
	function getHtmlUnchanged()
	{
		return $this->Html;
	}
	function getHtml()
	{
		return $this->LanguageHelper->Transliterate($this->Html);
	}
	function getSfStatus()
	{
		return $this->SfStatus;		
	}
	function getSfPageType()
	{
		return $this->SfPageType;		
	}
	
	function setSpageID($val)
	{
		$this->SPageID = $val;
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
	function setHtml($val)
	{
		$this->Html = $val;
	}
	
	function getLinkID()
	{
		return 'spageid='.$this->SpageID;
	}
}

?>