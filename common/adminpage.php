<?

/* CMS Studio 3.0 adminpage.php secured */

class AdminPage extends OpstiDomenskiObjekat
{
	public $AdminPageID;
	public $AdminPageName;
	public $Template;
	public $Header;
	public $Html;
	public $ShortHtml;

	//Bussiness PHP Object constructor
	function __construct()
	{
		parent::__construct();

		$this->AdminPageID = -1;
		$this->AdminPageName = "";
		$this->Template = $this->ObjectFactory->createObject("Template",-1);
		$this->Header = "";
		$this->Html = "";
		$this->ShortHtml = "";

		$this->TableName = "adminpage";
		$this->LanguageHelper->ChangeTableName($this->TableName);
	}

	// fill Page from POST
	function AdminPage_POST(&$post)
	{
		$this->Template = $this->ObjectFactory->createObject("Template",-1);

		$this->AdminPageID = isset($post["adminpageid"]) ? $post["adminpageid"] : $this->AdminPageID;
		$this->AdminPageName = isset($post["adminpagename"]) ? $post["adminpagename"] : $this->AdminPageName;
		$this->Template->TemplateID = isset($post["templateid"]) ? $post["templateid"] : $this->Template->TemplateID;
		$this->Header = isset($post["header"]) ? $post["header"] : $this->Header;
		$this->Html = isset($post["html"]) ? $post["html"] : $this->Html;
		$this->ShortHtml = isset($post["shorthtml"]) ? $post["shorthtml"] : $this->ShortHtml;
	}

	// DatabaseBroker functions
	function vratiImenaAtributa() {return "`adminpage_id`,`adminpagename`,`template_id`,`header`,`html`,`shorthtml`";}
	function vratiImeKlase(){return $this->TableName;}
	function vratiVrednostiAtributa(){ return "'',
		".$this->quote_smart($this->AdminPageID).",
		".$this->quote_smart($this->AdminPageName).",
		".$this->quote_smart($this->Template->TemplateID).",
		".$this->quote_smart($this->Header).",
		".$this->quote_smart($this->Html).",
		".$this->quote_smart($this->ShortHtml);}
	function postaviVrednostiAtributa(){ return "`adminpagename` = ".$this->quote_smart($this->AdminPageName).",`template_id` = ".$this->quote_smart($this->Template->TemplateID).",`header` = ".$this->quote_smart($this->Header).",`html` = ".$this->quote_smart($this->Html).",`shorthtml` = ".$this->quote_smart($this->ShortHtml);}
	function nazivVezeKaRoditelju(){ return "";}
	function vratiAtributPretrazivanja(){ return "adminpage_id"; }
	function vratiUslovZaNadjiSlog(){ return "adminpage_id=".$this->quote_smart($this->AdminPageID);}
	function vratiUslovZaSortiranje(){ return "`adminpagename`";}
	function vratiUslovZaNadjiSlogF(){ return "adminpage_id=".$this->quote_smart($this->AdminPageID);}
	function vratiUslovZaNadjiSlogove(){ return "1";}
	function vratiAtributZaMax(){ return "`adminpage_id`";}
	function postaviID($id){ $this->AdminPageID = $id;}
	function napuni($result_row)
	{
		$this->AdminPageID = $result_row->adminpage_id;
		$this->AdminPageName = $result_row->adminpagename;
		$this->Template->TemplateID = $result_row->template_id;
		$this->Header = $result_row->header;
		$this->Html = $result_row->html;
		$this->ShortHtml = $result_row->shorthtml;
	}
	function napuniNiz($result_set, &$al)
	{
		if(count($result_set)>0)
		{
			foreach($result_set as $result_row)
			{
				$adminpg = $this->ObjectFactory->createObject("AdminPage",-1);
				$adminpg->AdminPageID = $result_row->adminpage_id;
				$adminpg->AdminPageName = $result_row->adminpagename;
				$adminpg->Template->TemplateID = $result_row->template_id;
				$adminpg->Header = $result_row->header;
				$adminpg->Html = $result_row->html;
				$adminpg->ShortHtml = $result_row->shorthtml;
				array_push($al, $adminpg);
			}
		}
	}

	function napuniVisePovezi($result_set, $relation_name)
	{
		switch ($relation_name){
			case "template":
				if(count($result_set)>0) $this->Template->napuni($result_set);
				break;
			default: break;
		}
	}

	//
function toArray()
	{
		$arr = array();
			$arr = array_merge($arr, array("adminpageid" => $this->AdminPageID));
			$arr = array_merge($arr, array("adminpagename" => $this->AdminPageName));
			$arr = array_merge($arr, array("templateid" => $this->TemplateID));
			$arr = array_merge($arr, array("header" => $this->Header));
			$arr = array_merge($arr, array("html" => $this->Html));
			$arr = array_merge($arr, array("shorthtml" => $this->ShortHtml));
		return $arr;
	}

	function getAdminPageID()
	{
		return $this->AdminPageID;
	}
	function getAdminPageName()
	{
		return $this->AdminPageName;
	}
	function getTemplate()
	{
		return $this->Template;
	}
	function getTemplateID()
	{
		return $this->Template->TemplateID;
	}
	function getHeader()
	{
		return $this->Header;
	}
	function getHtml()
	{
		return $this->Html;
	}
	function getShortHtml()
	{
		return $this->ShortHtml;
	}
	function setAdminPageID($val)
	{
		$this->AdminPageID = $val;
	}
	function setAdminPageName($val)
	{
		$this->AdminPageName = $val;
	}
	function setTemplateID($val)
	{
		$this->TemplateID = $val;
	}
	function setHeader($val)
	{
		$this->Header = $val;
	}
	function setHtml($val)
	{
		$this->Html = $val;
	}
	function setShortHtml($val)
	{
		$this->ShortHtml = $val;
	}

	function getLinkID()
	{
		return 'adminpageid='.$this->AdminPageID;
	}

}

?>
