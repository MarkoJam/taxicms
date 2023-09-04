<?php

/* CMS Studio 3.0 subsite.php secured */
//include_once("class/interfejsi.php");

class SubSite extends OpstiDomenskiObjekat
{
	public $SfStatus;
	public $Name;
	public $Language;
	public $Country;
	public $Description;
	public $FilePostfix;
	public $DbPostfix;
	public $Picture;
	public $SSOrder;
	public $IsDefault;
	
	public $User;
	
	// PHP Bussines Object constructor
	function __construct()
	{
		parent::__construct();		
		$this->SfStatus = $this->ObjectFactory->createObject("SfStatus",-1);

		$this->Name = "";
		$this->Language = "";
		$this->Country = "";
		$this->Description = "";		
		$this->FilePostfix = "";
		$this->DbPostfix = "";
		$this->Picture = "";
		$this->IsDefault = 0;
		$this->SSOrder = 0;
		
		$this->User= array();
		$this->TableName= "subsite";
		$this->LanguageHelper->ChangeTableName($this->TableName);	
	}
	
	// PHP Bussines Object overloaded constructor
	function SubSite_POST($post)
	{
    	$this->SfStatus = $this->ObjectFactory->createObject("SfStatus",-1);
		$this->Name = isset($post["name"]) ? $post["name"] : $this->Name;
		$this->Language = isset($post["language"]) ? $post["language"] : $this->Language;
		$this->Country = isset($post["country"]) ? $post["country"] : $this->Country;
		$this->Description = isset($post["description"]) ? $post["description"] : $this->Description;		
		$this->FilePostfix = isset($post["filepostfix"]) ? $post["filepostfix"] : $this->FilePostfix;
		$this->DbPostfix = isset($post["dbpostfix"]) ? $post["dbpostfix"] : $this->DbPostfix;
		$this->SfStatus->setStatusID(isset($post["statusid"])? $post["statusid"] : $this->SfStatus->getStatusID());
		$this->IsDefault= isset($post["isdefault"]) ? $post["isdefault"] : $this->IsDefault;
		$this->SSOrder= isset($post["ssorder"]) ? $post["ssorder"] : $this->SSOrder;
		$this->setPicture(isset($post["picture"]) ? $post["picture"] : $this->getPicture());
		
		$this->User= array();
	}
	
	// Function vratiImenaAtributa
	function vratiImenaAtributa() {
		return "`sub_site_id`,`name`,`language`,`country`,`description`,`file_postfix`,`db_postfix`,`picture`,`status_id`,`ss_order`,`is_default`";
	}
	// Function vratiImeKlase
	function vratiImeKlase(){return "subsite";}
	
	//Function vratiVrednostAtributa
	function vratiVrednostiAtributa(){ return "'',".$this->quote_smart($this->Name).",".$this->quote_smart($this->Language).",".$this->quote_smart($this->Country).",".$this->quote_smart($this->Description).",".$this->quote_smart($this->FilePostfix).",".$this->quote_smart($this->DbPostfix).",".$this->quote_smart($this->Picture).",
	". $this->quote_smart($this->SfStatus->getStatusID()) .",". $this->quote_smart($this->SSOrder) .",".$this->quote_smart($this->IsDefault);}
	
	//Function postaviVrednostiAtributa
	function postaviVrednostiAtributa(){ return "`name`=".$this->quote_smart($this->Name).",`language`=".$this->quote_smart($this->Language).",
	`country`=".$this->quote_smart($this->Country).",`description`=".$this->quote_smart($this->Description).",`file_postfix`=".$this->quote_smart($this->FilePostfix).",`db_postfix`=".$this->quote_smart($this->DbPostfix).",
	`picture`=".$this->quote_smart($this->Picture).",`ss_order`=".$this->quote_smart($this->SSOrder).",`status_id` =".$this->quote_smart($this->SfStatus->getStatusID()).",`is_default`=".$this->quote_smart($this->IsDefault);}
	
	//Function nazivVezeKaRoditelju
	function nazivVezeKaRoditelju(){ return "subsite";}
	
	//Function vratiUslovZaNadjiSlog
	function vratiUslovZaNadjiSlog(){ return "sub_site_id=".$this->quote_smart($this->SubSiteID);}
	
	//Function vratiUslovZaSortiranje
	function vratiUslovZaSortiranje(){ return "ss_order";}
	
	//Function vratiUslovZaNadjiSlogF
	function vratiUslovZaNadjiSlogF(){ return "subsite_id=".$this->quote_smart($this->SubSiteID);}
	
	//Function vratiFulltextIndekse
	function vratiFulltextIndekse(){ return  "name";} //definisemo polja nad kojima je postavljem fulltext index
	
	
	//Function vratiUslovZaNadjiSlogove
	function vratiUslovZaNadjiSlogove(){ return "1=";}
	
	//Function postaviID
	function postaviID($id){ $this->SubSiteID = $this->quote_smart($id);}
	
	//Function napuni 
	function napuni($result_row)
	{
		$this->SubSiteID = $result_row->sub_site_id;
		$this->Name = $result_row->name;
		$this->Language = $result_row->language;
		$this->Country = $result_row->country;
		$this->Description = $result_row->description;
		$this->FilePostfix = $result_row->file_postfix;
		$this->DbPostfix = $result_row->db_postfix;
		$this->Picture = $result_row->picture;
		$this->SSOrder = $result_row->ss_order;
		$this->SfStatus->setStatusID($result_row->status_id);
		$this->IsDefault= $result_row->is_default;
	}
	
	function napuniNiz($result_set, &$al){
	if(count($result_set)>0)
		foreach($result_set as $result_row){
			$odo = $this->ObjectFactory->createObject("SubSite",-1);
			$odo->SubSiteID = $result_row->sub_site_id;
			$odo->Name = $result_row->name;
			$odo->Language = $result_row->language;
			$odo->Country = $result_row->country;			
			$odo->Description = $result_row->description;						
			$odo->FilePostfix = $result_row->file_postfix;
			$odo->DbPostfix = $result_row->db_postfix;
			$odo->Picture = $result_row->picture;
			$odo->SSOrder = $result_row->ss_order;
			$odo->SfStatus->setStatusID($result_row->status_id);
			$odo->IsDefault= $result_row->is_default;
			array_push($al, $odo);
		}
	}
	

	
	// Function napuniVisePovezi
	function napuniVisePovezi($result_set, $relation_name)
	{	
		switch ($relation_name)
		{
			case "sfstatus":
				if (count($result_set) > 0) { $this->SfStatus->napuni($result_set); }
				break;	
			case "user":
				if(count($result_set)>0)
				foreach($result_set as $db_res){
					$usr = $this->ObjectFactory->createObject("User",-1);
					$usr->napuni($db_res);
					array_push($this->User,$usr);}
				break;

				
			default: break;
		}
	}
	
	function toArray()
	{
		$arr = array();
		$arr = array_merge($arr, array("subsiteid" => $this->getSubSiteID()));
		$arr = array_merge($arr, array("name" => $this->getName()));
		$arr = array_merge($arr, array("language" => $this->getLanguage()));
		$arr = array_merge($arr, array("country" => $this->getCountry()));
		$arr = array_merge($arr, array("description" => $this->getDescription()));		
		$arr = array_merge($arr, array("filepostfix" => $this->getFilePostfix()));
		$arr = array_merge($arr, array("dbpostfix" => $this->getDbPostfix()));
		$arr = array_merge($arr, array("picture" => $this->getPicture()));
		$arr = array_merge($arr, array("ssorder" => $this->getSSOrder()));
		$arr = array_merge($arr, array("status_id" => $this->getStatusID()));
		$arr = array_merge($arr, array("isdefault" => $this->getIsDefault()));
		return $arr;
	}

	function getSubSiteID()
	{
		return $this->SubSiteID;
	}
	function getName()
	{
		return $this->Name;
	}
	function getLanguage()
	{
		return $this->Language;
	}
	function getCountry()
	{
		return $this->Country;
	}	
	function getDescription()
	{
		return $this->Description;
	}
	function getFilePostfix()
	{
		return $this->FilePostfix;
	}
	function getDbPostfix()
	{
		return $this->DbPostfix;
	}
	function getPicture()
	{
		return $this->Picture;
	}
	function getSSOrder()
	{
		return $this->SSOrder;
	}
	function getStatusID()
	{
		return $this->SfStatus->StatusID;
	}
	function getIsDefault()
	{
		return $this->IsDefault;
	}
	function setSubSiteID($val)
	{
		$this->SubSiteID = $val;
	}
	function setName($val)
	{
		$this->Name = $val;
	}
	function setLanguage($val)
	{
		$this->Language = $val;
	}
	function setCountry($val)
	{
		$this->Country = $val;
	}
	function setDescription($val)
	{
		$this->Description = $val;
	}
	function setFilePostfix($val)
	{
		$this->FilePostfix = str_replace(" ","-",$val);
	}
	function setDbPostfix($val)
	{
		$this->DbPostfix = str_replace(" ","_",$val);
	}
	function setPicture($val)
	{
		$this->Picture = $val;
	}
	function setSSOrder($val)
	{
		$this->SSOrder = $val;
	}
	function getSfStatus()
	{
		return $this->SfStatus;
	}
	function setStatusID($val)
	{
		$this->SfStatus->StatusID = $val;
	}	
	function setIsDefault($val)
	{
		$this->IsDefault = $val;
	}
	
	function getLinkID()
	{
		return 'subsiteid='.$this->SubSiteID;
	}
	
// podesavanje za pluginove
	function vratiIDKategorijeZaPlugin(){
		
		return $this->SubSiteID;
	}
		
	function vratiNazivKategorijeZaPlugin(){
		return $this->Name;
	}
	
	function postaviIDKategorijeZaPlugin($id){
		$this->SubSiteID = $id;
	}
}

?>