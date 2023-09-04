<?

/* CMS Studio 3.0 page.php secured */

class User extends OpstiDomenskiObjekat 
{
	public $UserID;
	public $Name;
	public $Surname;
	public $Firm;
	public $PIB;
	public $MatBr;
	public $Place;
	public $Address;
	public $CountryID;
	public $Region;
	public $Postalcode;
	public $Email;
	public $Phone;
	public $IssueNo;
	public $UserName;
	public $Password;
	public $ExpiryDate;
	public $Discount;
	public $UserDescription;
	public $Comment;
	public $ActivationHash;
	
	private $LastLogDate;
	private $LastLogIP;
	
	public $SfUserType; 	// pravno ili fizicko lice
	public $SfUserCategory; // custom kategorizacije potrebne za razne projekte
	public $SfStatus;		// statusi korisnika
	public $SfCountries;		// statusi korisnika
	
	public $SubSiteID;
	public $UserRoles;
	public $UserSubSites;
	public $PrOrder;
	
	//Bussiness PHP Object constructor
	function __construct()
	{
		parent::__construct();
		
		$this->SfUserType = $this->ObjectFactory->createObject("SfUserType",-1);
		$this->SfUserCategory = $this->ObjectFactory->createObject("SfUserCategory",-1);
		$this->SfStatus = $this->ObjectFactory->createObject("SfStatus",-1);
		$this->SfCountries = $this->ObjectFactory->createObject("SfCountries",-1);
		
		$this->UserID =-1;
		$this->Name = "";
		$this->Surname = "";
		$this->Firm = "";
		$this->PIB = "";
		$this->MatBr = "";
		$this->Place ="";
		$this->Address = "";
		$this->Region = "";
		$this->Postalcode = "";
		$this->Email = "";
		$this->Comment = "";
		$this->Phone = "";
		$this->IssueNo = "";
		$this->UserName = "";
		$this->Password = "";
		$this->ExpiryDate = 0;
		$this->Discount = 0;
		$this->UserDescription = "";
		$this->LastLogDate = -1;
		$this->LastLogIP = "";
		$this->ActivationHash = "";
		$this->SfUserType->setUserTypeID(-1);
		$this->SfUserCategory->setUserCategoryID(-1);
		$this->SfStatus->setStatusID(-1);
		$this->SfCountries->setCountryID(-1);
		$this->SubSiteID = -1;
		$this->UserRoles = array();
		$this->UserSubSites = array();
		$this->PrOrder = array();
	}
	
	// fill User from POST
	function User_POST(&$post)
	{
		$this->UserID= isset($post["userid"]) ? $post["userid"] : $this->UserID;
		$this->Name= isset($post["name"]) ? $post["name"] : $this->Name;
		$this->Surname= isset($post["surname"]) ? $post["surname"] : $this->Surname;
		$this->Firm = isset($post["firm"]) ? $post["firm"] : $this->Firm;
		$this->PIB = isset($post["pib"]) ? $post["pib"] : $this->PIB;
		$this->MatBr = isset($post["matbr"]) ? $post["matbr"] : $this->MatBr;
		$this->Place = isset($post["place"]) ? $post["place"] : $this->Place;
		$this->Address = isset($post["address"]) ? $post["address"] : $this->Address;
		$this->Region = isset($post["region"]) ? $post["region"] : $this->Region;		
		$this->Postalcode = isset($post["postalcode"]) ? $post["postalcode"] : $this->Postalcode;
		$this->Email= isset($post["email"]) ? $post["email"] : $this->Email;
		$this->Phone = isset($post["phone"]) ? $post["phone"] : $this->Phone;
		$this->IssueNo= isset($post["issueno"]) ? $post["issueno"] : $this->IssueNo;
		$this->Comment= isset($post["comment"]) ? $post["comment"] : $this->Comment;
		$this->ActivationHash= isset($post["activationhash"]) ? $post["activationhash"] : $this->ActivationHash;
		$this->UserName= isset($post["username"]) ? $post["username"] : $this->UserName;
		$this->Password= isset($post["password"]) ? $post["password"] : $this->Password;
		$this->ExpiryDate = isset($post["expirydate"]) ? $post["expirydate"] : $this->ExpiryDate;
		$this->Discount = isset($post["discount"]) ? $post["discount"] : $this->Discount;
		$this->UserDescription = isset($post["userdescription"]) ? $post["userdescription"] : $this->UserDescription;
		
		$this->SfUserType->setUserTypeID(isset($post["usertypeid"]) ? $post["usertypeid"] : $this->SfUserType->getUserTypeID());
		$this->SfUserCategory->setUserCategoryID(isset($post["usercategoryid"]) ? $post["usercategoryid"] : $this->SfUserCategory->getUserCategoryID());
		$this->SfStatus->setStatusID(isset($post["statusid"]) ? $post["statusid"] : $this->SfStatus->getStatusID());
		$this->SfCountries->setCountryID(isset($post["countryid"]) ? $post["countryid"] : $this->SfCountries->getCountryID());


		$this->SubSiteID = isset($post["subsiteid"]) ? $post["subsiteid"] : $this->SubSiteID;
		$this->UserRoles = array();
		$this->UserSubSites = array();
		$this->PrOrder = array();
	}
	
	// DatabaseBroker functions
	function vratiImenaAtributa() {return "`userid`,`name`,`surname`,`firm`,`pib`,`matbr`,`place`,`address`,`postalcode`,`country_id`,`region`,`email`,`comment`,`phone`,`issueno`,`username`,`password`,`user_type_id`,`user_category_id`,`status_id`,`expirydate`,`discount`,`user_description`,`last_log_date`,`last_log_ip`,`sub_site_id`,`activation_hash`";}
	function vratiImeKlase(){return "user";}
	function vratiVrednostiAtributa(){ return "'','".$this->Name."','".$this->Surname."','".$this->Firm."','".$this->PIB."','".$this->MatBr."','".$this->Place."','".$this->Address."','".$this->Postalcode."','".$this->SfCountries->getCountryID()."','".$this->Region."','".$this->Email."','".$this->Comment."','".$this->Phone."','".$this->IssueNo."','".$this->UserName."','".$this->Password."','".$this->SfUserType->getUserTypeID()."','".$this->SfUserCategory->getUserCategoryID()."','".$this->SfStatus->getStatusID()."','".$this->ExpiryDate."','".$this->Discount."','".$this->UserDescription."','".$this->LastLogDate."','".$this->LastLogIP."','".$this->SubSiteID."','".$this->ActivationHash."'";}
	function postaviVrednostiAtributa(){ return "`name` = '".$this->Name."',`surname` = '".$this->Surname."',`firm` = '".$this->Firm."',`pib` = '".$this->PIB."',`matbr` = '".$this->MatBr."',`place` = '".$this->Place."',`address` = '".$this->Address."',`postalcode` = '".$this->Postalcode."',`country_id` = '".$this->SfCountries->getCountryID()."',`region` = '".$this->Region."',`email` = '".$this->Email."',`comment` = '".$this->Comment."',`phone` = '".$this->Phone."',`issueno` = '".$this->IssueNo."',`username` = '".$this->UserName."',`password` = '".$this->Password."',`user_type_id` = '".$this->SfUserType->getUserTypeID()."',`user_category_id` = '".$this->SfUserCategory->getUserCategoryID()."',`status_id` = '".$this->SfStatus->getStatusID()."',`expirydate` = '".$this->ExpiryDate."',`discount` = '".$this->Discount."',`user_description` = '".$this->UserDescription."',`last_log_date` = '".$this->LastLogDate."',`last_log_ip` = '".$this->LastLogIP."',`sub_site_id` = '".$this->SubSiteID."',`activation_hash` = '".$this->ActivationHash."'";}
	function nazivVezeKaRoditelju(){ return "user";}
	function vratiUslovZaNadjiSlog(){ return "userid=".$this->UserID;}
	function vratiUslovZaSortiranje(){ return " firm, name ";}
	function vratiUslovZaNadjiSlogF(){ return "userid=".$this->UserID;}
	function vratiUslovZaNadjiSlogove(){ return "1=";}
	function postaviID($id){ $this->UserID = $id;}
	function napuni($result_row){
		$this->UserID = $result_row->userid;
		$this->Name = $result_row->name;
		$this->Surname = $result_row->surname;
		$this->Firm = $result_row->firm;
		$this->PIB = $result_row->pib;
		$this->MatBr = $result_row->matbr;
		$this->Place = $result_row->place;
		$this->Address = $result_row->address;
		$this->Postalcode = $result_row->postalcode;
		$this->SfCountries->setCountryID($result_row->country_id);
		$this->Region = $result_row->region;		
		$this->Email = $result_row->email;
		$this->Comment = $result_row->comment;
		$this->Phone = $result_row->phone;
		$this->IssueNo = $result_row->issueno;
		$this->UserName = $result_row->username;
		$this->Password = $result_row->password;
		$this->SfUserType->setUserTypeID($result_row->user_type_id);
		$this->SfUserCategory->setUserCategoryID($result_row->user_category_id);
		$this->SfStatus->setStatusID($result_row->status_id);
		$this->ExpiryDate = $result_row->expirydate;
		$this->Discount= $result_row->discount;
		$this->UserDescription = $result_row->user_description;
		$this->LastLogDate= $result_row->last_log_date;
		$this->LastLogIP= $result_row->last_log_ip;
		$this->SubSiteID= $result_row->sub_site_id;
		$this->ActivationHash= $result_row->activation_hash;
	}
	function napuniNiz($result_set, &$al)
	{
		if(count($result_set)>0)
		{
			foreach($result_set as $result_row){
				$usr = $this->ObjectFactory->createObject("User",-1);
				$usr->UserID = $result_row->userid;
				$usr->Name = $result_row->name;
				$usr->Surname = $result_row->surname;
				$usr->Firm = $result_row->firm;
				$usr->PIB = $result_row->pib;
				$usr->MatBr = $result_row->matbr;
				$usr->Place = $result_row->place;
				$usr->Address = $result_row->address;
				$usr->SfCountries->setCountryID($result_row->country_id);				
				$usr->Postalcode = $result_row->postalcode;
				$usr->Region = $result_row->region;				
				$usr->Email = $result_row->email;
				$usr->Comment = $result_row->comment;
				$usr->Phone = $result_row->phone;
				$usr->IssueNo = $result_row->issueno;
				$usr->UserName = $result_row->username;
				$usr->Password = $result_row->password;
				$usr->SfUserType->setUserTypeID($result_row->user_type_id);
				$usr->SfUserCategory->setUserCategoryID($result_row->user_category_id);
				$usr->SfStatus->setStatusID($result_row->status_id);
				$usr->ExpiryDate = $result_row->expirydate;
				$usr->Discount = $result_row->discount;
				$usr->UserDescription = $result_row->user_description;
				$usr->setLastLogDate($result_row->last_log_date);
				$usr->setLastLogIP($result_row->last_log_ip);
				$usr->SubSiteID= $result_row->sub_site_id;
				$usr->ActivationHash= $result_row->activation_hash;
				array_push($al, $usr);
			}
		}
	}
	
	function vratiImeVezneTabele($relation_class_name,& $vezna_klasa, & $uslov_join){
		switch ($relation_class_name){
			case "userrole":
				$vezna_klasa = "useruserrole";
				$uslov_join = "IJ1.userroleid = IJ2.userroleid";
				break;
			default: $vezna_klasa = "";
				break;
		}
	}
	
	function napuniVisePovezi($result_set, $relation_name){
		switch ($relation_name)
		{
			case "userrole":
				if(count($result_set)>0)
				foreach($result_set as $db_res)
				{
					$usrr = $this->ObjectFactory->createObject("UserRole",-1);
					$usrr->napuni($db_res);
					array_push($this->UserRoles,$usrr);
				}
				break;
			case "usersubsite":
				if(count($result_set)>0)
				{
					foreach($result_set as $db_res)
					{
						$usrs= $this->ObjectFactory->createObject("UserSubSite",-1);
						$usrs->napuni($db_res);
						array_push($this->UserSubSites,$usrs);
					}
				}
				break;
			case "prorder":
				if(count($result_set)>0)
				{
					foreach($result_set as $db_res)
					{
						$usrs= $this->ObjectFactory->createObject("PrOrder",-1);
						$usrs->napuni($db_res);
						array_push($this->PrOrder,$usrs);
					}
				}
				break;
			case "sfcountries":
					if(count($result_set)>0) $this->SfCountries->napuni($result_set);
				break;				
			case "sfstatus":
					if(count($result_set)>0) $this->SfStatus->napuni($result_set);
				break;
			case "sfusertype":
					if(count($result_set)>0) $this->SfUserType->napuni($result_set);
				break;
			case "sfusercategory":
					if(count($result_set)>0) $this->SfUserCategory->napuni($result_set);
				break;
			default: break;
		}
	}
	
	function toArray()
	{
		$arr = array();
		$arr = array_merge($arr, array("userid" => $this->getUserID()));
		$arr = array_merge($arr, array("name" => $this->getName()));
		$arr = array_merge($arr, array("surname" => $this->getSurname()));
		$arr = array_merge($arr, array("firm" => $this->getFirm()));
		$arr = array_merge($arr, array("pib" => $this->getPIB()));
		$arr = array_merge($arr, array("matbr" => $this->getMatBr()));
		$arr = array_merge($arr, array("place" => $this->getPlace()));
		$arr = array_merge($arr, array("address" => $this->getAddress()));
		$arr = array_merge($arr, array("postalcode" => $this->getPostalcode()));
		$arr = array_merge($arr, array("countryid" => $this->SfCountries->getCountryID()));				
		$arr = array_merge($arr, array("region" => $this->getRegion()));		
		$arr = array_merge($arr, array("email" => $this->getEmail()));
		$arr = array_merge($arr, array("comment" => $this->getComment()));
		$arr = array_merge($arr, array("phone" => $this->getPhone()));
		$arr = array_merge($arr, array("issueno" => $this->getIssueNo()));
		$arr = array_merge($arr, array("username" => $this->getUserName()));
		$arr = array_merge($arr, array("password" => $this->getPassword()));
		$arr = array_merge($arr, array("usertypeid" => $this->SfUserType->getUserTypeID()));
		$arr = array_merge($arr, array("usercategoryid" => $this->SfUserCategory->getUserCategoryID()));
		$arr = array_merge($arr, array("statusid" => $this->SfStatus->getStatusID()));
		$arr = array_merge($arr, array("expirydate" => $this->getExpiryDateFormated()));
		$arr = array_merge($arr, array("discount" => $this->getDiscount()));
		$arr = array_merge($arr, array("userdescription" => $this->getUserDescription()));
		$arr = array_merge($arr, array("lastlogdate" => $this->getLastLogDate()));
		$arr = array_merge($arr, array("lastlogip" => $this->getLastLogIP()));
		$arr = array_merge($arr, array("subsiteid" => $this->getSubSiteID()));
		$arr = array_merge($arr, array("activationhash" => $this->getActivationHash()));
		return $arr;
	}
	
	// get metode ispravi ako ima nesto!!!
	function getUserID()
	{
		return $this->UserID;
	}
	function getName()
	{
		return $this->Name;
	}
	function getSurname()
	{
		return $this->Surname;
	}
	function getFirm()
	{
		return $this->Firm;
	}
	function getPIB()
	{
		return $this->PIB;
	}
	function getMatBr()
	{
		return $this->MatBr;
	}
	function getPlace()
	{
		return $this->Place;
	}
	function getAddress()
	{
		return $this->Address;
	}
	function getPostalcode()
	{
		return $this->Postalcode;
	}
	function getRegion()
	{
		return $this->Region;
	}	
	function getEmail()
	{
		return $this->Email;
	}
	function getComment()
	{
		return $this->Comment;
	}
	function getPhone()
	{
		return $this->Phone;
	}
	function getIssueNo()
	{
		return $this->IssueNo;
	}
	function getUserName()
	{
		return $this->UserName;
	}
	function getPassword()
	{
		return $this->Password;
	}
	
	function getSubSiteID()
	{
		return $this->SubSiteID;
	}
	function getUserRoles()
	{
		return $this->UserRoles;
	}
	
	function getUserSubSites()
	{
		return $this->UserSubSites;
	}
	
	function getExpiryDate()
	{
		return $this->ExpiryDate;
	}
	function getExpiryDateFormated()
	{
		return $this->LanguageHelper->Transliterate($this->LanguageHelper->getDateTranslated($this->getExpiryDate(),"d. F Y."));
	}	
	function getDiscount()
	{
		return $this->Discount;
	}
	function getUserDescription()
	{
		return $this->UserDescription;
	}
	function getLastLogDate()
	{
		return $this->LastLogDate;
	}
	function getLastLogIP()
	{
		return $this->LastLogIP;
	}
	function getActivationHash()
	{
		return $this->ActivationHash;
	}
	// set metode ispravi ako ima nesto!!!
	function setUserID($val)
	{
		$this->UserID= $val;
	}
	function setName($val)
	{
		$this->Name= $val;
	}
	function setSurname($val)
	{
		$this->Surname= $val;
	}
	function setFirm($val)
	{
		$this->Firm = $val;
	}
	function setPIB($val)
	{
		$this->PIB = $val;
	}
	function setMatBr($val)
	{
		$this->MatBr = $val;
	}
	function setPlace($val)
	{
		$this->Place = $val;
	}
	function setAddress($val)
	{
		$this->Address = $val;
	}
	function setPostalcode($val)
	{
		$this->Postalcode = $val;
	}
	function setCountryID($val)
	{
		$this->CountryID = $val;
	}		
	function setRegion($val)
	{
		$this->Region = $val;
	}	
	function setEmail($val)
	{
		$this->Email= $val;
	}
	function setComment($val)
	{
		$this->Comment= $val;
	}
	function setPhone($val)
	{
		$this->Phone = $val;
	}
	function setIssueNo($val)
	{
		$this->IssueNo = $val;
	}
	function setUserName($val)
	{
		$this->UserName= $val;
	}
	function setPassword($val)
	{
		$this->Password= $val;
	}
	function setExpiryDate($val)
	{
		$this->ExpiryDate = $val;
	}
	function setDiscount($val)
	{
		$this->Discount = $val;
	}
	function setUserDescription($val)
	{
		$this->UserDescription = $val;
	}
	function setLastLogDate($val)
	{
		$this->LastLogDate = $val;
	}
	function setLastLogIP($val)
	{
		$this->LastLogIP = $val;
	}
	function setSubSiteID($val)
	{
		$this->SubSiteID = $val;
	}
	function setSubSites($val)
	{
		$this->UserSubSites = $val;
	}
	function setActivationHash($val)
	{
		$this->ActivationHash = $val;
	}
	function getLinkID()
	{
		return 'userid='.$this->UserID;
	}
}
	
class UserUserRole extends OpstiDomenskiObjekat 
{
	public $UserID;
	public $UserRoleID;
	
	//Bussiness PHP Object constructor
	function __construct()
	{
		parent::__construct();
		
		$this->UserID = 0;
		$this->UserRoleID = 0;
	}
	
	// fill UserUserRole from POST
	function UserUserRole_POST(&$post)
	{
		$this->UserID= isset($post["userid"]) ? $post["userid"] : $this->UserID;
		$this->UserRoleID= isset($post["userroleid"]) ? $post["userroleid"] : $this->UserRoleID;
	}
	
	// DatabaseBroker functions
	function vratiImenaAtributa() {return "`userid`,`userroleid`";}
	function vratiImeKlase(){return "useruserrole";}
	function vratiVrednostiAtributa(){ return "'".$this->UserID."','".$this->UserRoleID."'";}
	function postaviVrednostiAtributa(){ return "`userroleid` = '".$this->UserRoleID."'";}
	function nazivVezeKaRoditelju(){ return "useruserrole";}
	function vratiUslovZaNadjiSlog(){ return "userid=".$this->UserID. " AND userroleid=".$this->UserRoleID;}
	function vratiUslovZaSortiranje(){ return "userid";}
	function vratiUslovZaNadjiSlogF(){ return "userid=".$this->UserID;}
	function vratiUslovZaNadjiSlogove(){ return "1=";}
	function postaviID($id){ $this->UserID = $id;}
	function napuni($result_row)
	{
		$this->UserID = $result_row->userid;
		$this->UserRoleID = $result_row->userroleid;
	}
	
	function napuniNiz($result_set, &$al)
	{
		if(count($result_set)>0)
			foreach($result_set as $result_row)
			{
				$uuroles = $this->ObjectFactory->createObject("UserUserRole",-1);
				$uuroles->UserID = $result_row->userid;
				$uuroles->UserRoleID = $result_row->userroleid;
				array_push($al, $uuroles);
			}
	}
	
	function vratiImeVezneTabele($relation_class_name,& $vezna_klasa, & $uslov_join){}
	function napuniVisePovezi($result_set, $relation_name){}
		
	function toArray()
	{
		$arr = array();
		$arr = array_merge($arr, array("userid" => $this->getUserID()));
		$arr = array_merge($arr, array("userroleid" => $this->getUserRoleID()));
		return $arr;
	}
	
	// get metode ispravi ako ima nesto!!!
	function getUserID()
	{
		return $this->UserID;
	}
	function getUserRoleID()
	{
		return $this->UserRoleID;
	}
	
	// set metode ispravi ako ima nesto!!!
	function setUserID($val)
	{
		$this->UserID= $val;
	}
	function setUserRoleID($val)
	{
		$this->UserRoleID= $val;
	}
	function getLinkID()
	{
		return 'userroleid='.$this->UserRoleID.'&userid='.$this->UserID;
	}
}
	
class UserRole extends OpstiDomenskiObjekat 
{
	public $UserRoleID;
	public $Role;
	public $Description;
	public $User;
	
	//Bussiness PHP Object constructor
	function __construct()
	{
		parent::__construct();
		$this->User = array();
	
		$this->UserRoleID = -1;
		$this->Role = "";
		$this->Description = "";
	}
	
	// fill UserRole from POST
	function UserRole_POST(&$post)
	{
		$this->User = array();
	
		$this->UserRoleID= isset($post["userroleid"]) ? $post["userroleid"] : $this->UserRoleID;
		$this->Role = isset($post["role"]) ? $post["role"] : $this->Role;
		$this->Description= isset($post["description"]) ? $post["description"] : $this->Description;
	}
	
	// DatabaseBroker functions
	function vratiImenaAtributa() {return "`userroleid`,`role`,`description`";}
	function vratiImeKlase(){return "userrole";}
	function vratiVrednostiAtributa(){ return "'','".$this->Description."','".$this->Role."'";}
	function postaviVrednostiAtributa(){ return "`description` = '".$this->Description."',`role` = '".$this->Role."'";}
	function nazivVezeKaRoditelju(){ return "userrole";}
	function vratiUslovZaNadjiSlog(){ return "userroleid=".$this->UserRoleID;}
	function vratiUslovZaSortiranje(){ return "";}
	function vratiUslovZaNadjiSlogF(){ return "userroleid=".$this->UserRoleID;}
	function vratiUslovZaNadjiSlogove(){ return "1=";}
	function postaviID($id){ $this->UserRoleID = $id;}
	function napuni($result_row){
		$this->UserRoleID = $result_row->userroleid;
		$this->Role = $result_row->role;
		$this->Description = $result_row->description;
	}
	function napuniNiz($result_set, &$al)
	{
		if(count($result_set)>0)
		{
			foreach($result_set as $result_row)
			{
				$urole = $this->ObjectFactory->createObject("UserRole",-1);
				$urole->UserRoleID = $result_row->userroleid;
				$urole->Role = $result_row->role;
				$urole->Description = $result_row->description;
				array_push($al, $urole);
			}
		}
	}
	function vratiImeVezneTabele($relation_class_name,& $vezna_klasa, & $uslov_join){
		switch ($relation_class_name){
			case "user":
				$vezna_klasa = "useruserrole";
				$uslov_join = "IJ1.userid = IJ2.userid";
				break;
			default: $vezna_klasa = "";
				break;
		}
	}
	function napuniVisePovezi($result_set, $relation_name){
		switch ($relation_name){
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
		$arr = array_merge($arr, array("userroleid" => $this->getUserRoleID()));
		$arr = array_merge($arr, array("description" => $this->getDescription()));
		$arr = array_merge($arr, array("role" => $this->getRole()));
		return $arr;
	}
	
	// get metode ispravi ako ima nesto!!!
	function getUserRoleID()
	{
		return $this->UserRoleID;
	}
	function getDescription()
	{
		return $this->Description;
	}
	function getRole()
	{
		return $this->Role;
	}
	
	function getUser()
	{
		return $this->User;
	}
	// set metode ispravi ako ima nesto!!!
	function setUserRoleID($val)
	{
		$this->UserRoleID= $val;
	}
	
	function setDescription($val)
	{
		$this->Description= $val;
	}
	function setRole($val)
	{
		$this->Role = $val;
	}
	function setUser($val)
	{
		$this->User= $val;
	}
	function getLinkID()
	{
		return 'userroleid='.$this->UserRoleID;
	}
}
	
class UserSubSite extends OpstiDomenskiObjekat
{
	public $UserID;
	public $SubSiteID;
	public $Status;
	public $ExpiryDate;
	
	// PHP Bussines Object constructor
	function __construct()
	{
		parent::__construct();
		
		$this->UserID = -1;
		$this->SubSiteID = -1;
		$this->Status = "";
		$this->ExpiryDate = 0;
	}
	
	// PHP Bussines Object overloaded constructor
	function UserSubSite_POST($post)
	{
		$this->UserID = isset($post["userid"]) ? $post["userid"] : $this->UserID;
		$this->SubSiteID = isset($post["subsiteid"]) ? $post["subsiteid"] : $this->SubSiteID;
		$this->Status = isset($post["status"]) ? $post["status"] : $this->Status;
		$this->ExpiryDate = isset($post["expirydate"]) ? $post["expirydate"] : $this->ExpiryDate;
	}
	
	// Function vratiImenaAtributa
	function vratiImenaAtributa() {
		return "`userid`,`sub_site_id`,`status`,`expiry_date`";
	}
	// Function vratiImeKlase
	function vratiImeKlase(){return "usersubsite";}
	
	//Function vratiVrednostAtributa
	function vratiVrednostiAtributa(){ return $this->quote_smart($this->UserID).",".$this->quote_smart($this->SubSiteID).",".$this->quote_smart($this->Status).",".$this->quote_smart($this->ExpiryDate);}
	
	//Function postaviVrednostiAtributa
	function postaviVrednostiAtributa(){ return "`userid`=".$this->quote_smart($this->UserID).",`sub_site_id`=".$this->quote_smart($this->SubSiteID).",`status`=".$this->quote_smart($this->Status).",`expiry_date`=".$this->quote_smart($this->ExpiryDate);}
	
	//Function nazivVezeKaRoditelju
	function nazivVezeKaRoditelju(){ return "usersubsite";}
	
	//Function vratiUslovZaNadjiSlog
	function vratiUslovZaNadjiSlog(){ return "userid=".$this->quote_smart($this->UserID)." AND sub_site_id=".$this->quote_smart($this->SubSiteID);}
	
	//Function vratiUslovZaSortiranje
	function vratiUslovZaSortiranje(){ return "sub_site_id";}
	
	//Function vratiUslovZaNadjiSlogF
	function vratiUslovZaNadjiSlogF(){ return "userid=".$this->quote_smart($this->UserID);}
	
	//Function vratiUslovZaNadjiSlogove
	function vratiUslovZaNadjiSlogove(){ return "1=";}
	
	//Function postaviID
	function postaviID($id){ $this->UserID = $this->quote_smart($id);}
	
	//Function napuni 
	function napuni($result_row)
	{
		$this->UserID = $result_row->userid;
		$this->SubSiteID = $result_row->sub_site_id;
		$this->Status = $result_row->status;
		$this->ExpiryDate = $result_row->expiry_date;
	}
	
	function napuniNiz($result_set, &$al){
	if(count($result_set)>0)
		foreach($result_set as $result_row){
			$odo = $this->ObjectFactory->createObject("UserSubSite",-1);
			$odo->UserID = $result_row->userid;
			$odo->SubSiteID = $result_row->sub_site_id;
			$odo->Status = $result_row->status;
			$odo->ExpiryDate = $result_row->expiry_date;
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
		$arr = array_merge($arr, array("userid" => $this->getUserID()));
		$arr = array_merge($arr, array("subsiteid" => $this->getSubSiteID()));
		$arr = array_merge($arr, array("status" => $this->getStatus()));
		$arr = array_merge($arr, array("expirydate" => $this->getExpiryDate()));
		return $arr;
	}

	function getUserID()
	{
		return $this->UserID;
	}
	function getSubSiteID()
	{
		return $this->SubSiteID;
	}
	function getStatus()
	{
		return $this->Status;
	}
	function getExpiryDate()
	{
		return $this->ExpiryDate;
	}
	
	function setUserID($val)
	{
		$this->UserID = $val;
	}
	function setSubSiteID($val)
	{
		$this->SubSiteID = $val;
	}
	function setStatus($val)
	{
		$this->Status = $val;
	}
	function setExpiryDate($val)
	{
		$this->ExpiryDate = $val;
	}
	
	function getLinkID()
	{
		return 'userid='.$this->UserID.'&subsiteid='.$this->SubSiteID;
	}
}

class UserLogHistory extends OpstiDomenskiObjekat
{
	private $UserLogID;
	private $LastLogDate;
	private $LastLogIP;
	public $User;	
	
	//Bussiness PHP Object constructor	 
	function __construct()
	{
		parent::__construct();
		
		$this->User = $this->ObjectFactory->createObject("User",-1); 
		$this->UserLogID = 0;
		$this->User->UserID = -1;
		$this->LastLogDate = 0;
		$this->LastLogIP = "";
		
		$this->TableName= "user_log_history";
		$this->LanguageHelper->ChangeTableName($this->TableName);
	}
	
	// PHP Bussines Object overloaded constructor
	function UserLogHistory_POST($post)
	{
		$this->User = new User();
		$this->setUserLogID(isset($post["userlogid"]) ? $post["userlogid"] : $this->getUserLogID());
		$this->User->setUserID(isset($post["userid"]) ? $post["userid"] : $this->User->getUserID());
		$this->setLastLogDate(isset($post["lastlogdate"]) ? $post["lastlogdate"] : $this->getLastLogDate());
		$this->setLastLogIP(isset($post["lastlogip"]) ? $post["lastlogip"] : $this->getLastLogIP());
	}
	
	// Function vratiImenaAtributa
	function vratiImenaAtributa() {
		return "`user_log_id`,`user_id`,`last_log_date`,`last_log_ip`";
	}
	// Function vratiImeKlase
	function vratiImeKlase(){return $this->TableName;}
	
	//Function vratiVrednostAtributa
	function vratiVrednostiAtributa(){ return "'',".$this->quote_smart($this->User->getUserID()).",".$this->quote_smart($this->getLastLogDate()).",".$this->quote_smart($this->getLastLogIP());}
	
	//Function postaviVrednostiAtributa
	function postaviVrednostiAtributa(){ return "`user_id`=".$this->quote_smart($this->User->getUserID()).",`last_log_date`=".$this->quote_smart($this->getLastLogDate()).",`last_log_ip`=".$this->quote_smart($this->getLastLogIP());}
	
	//Function nazivVezeKaRoditelju
	function nazivVezeKaRoditelju(){ return "userloghistory";}
	
	//Function vratiUslovZaNadjiSlog
	function vratiUslovZaNadjiSlog(){ return "user_log_id=".$this->quote_smart($this->getUserLogID());}
	
	//Function vratiUslovZaSortiranje
	function vratiUslovZaSortiranje(){ return "user_log_id";}
	
	//Function vratiUslovZaNadjiSlogF
	function vratiUslovZaNadjiSlogF(){ return "user_log_id=".$this->quote_smart($this->getUserLogID());}
	
	//Function vratiUslovZaNadjiSlogove
	function vratiUslovZaNadjiSlogove(){ return "1=";}
	
	//Function postaviID
	function postaviID($id){ $this->setUserLogID($this->quote_smart($id));}
	
	//Function napuni 
	function napuni($result_row)
	{
		$this->UserLogID = $result_row->user_log_id;
		$this->User->UserID = $result_row->user_id;
		$this->LastLogDate = $result_row->last_log_date;
		$this->LastLogIP = $result_row->last_log_ip;
	}
	
	function napuniNiz($result_set, &$al){
	if(count($result_set)>0)
		foreach($result_set as $result_row){
			$odo = new UserLogHistory();
			$odo->setUserLogID($result_row->user_log_id);
			$odo->User->setUserID($result_row->user_id);
			$odo->setLastLogDate($result_row->last_log_date);
			$odo->setLastLogIP($result_row->last_log_ip);
			array_push($al, $odo);
		}
	}
	
	// Function napuniVisePovezi
	function napuniVisePovezi($result_set, $relation_name)
	{
		switch ($relation_name)
		{
			case "user":
				if(count($result_set)>0) $this->User->napuni($result_set);
				break;
			default: break;
		}
	}
	
	function toArray()
	{
		$arr = array();
			$arr = array_merge($arr, array("userlogid" => $this->getUserLogID()));
			$arr = array_merge($arr, array("userid" => $this->getUserID()));
			$arr = array_merge($arr, array("lastlogdate" => $this->getLastLogDate()));
			$arr = array_merge($arr, array("lastlogdateformated" => $this->getLastLogDateFormated()));
			$arr = array_merge($arr, array("lastlogip" => $this->getLastLogIP()));
		return $arr;
	}

	function getUserLogID()
	{
		return $this->UserLogID;
	}
	function getUserID()
	{
		return $this->User->UserID;
	}
	function getLastLogDate()
	{
		return $this->LastLogDate;
	}
	function getLastLogDateFormated()
	{
		return date("d-m-Y H:i",$this->LastLogDate);
	}
	
	function getLastLogIP()
	{
		return $this->LastLogIP;
	}
	
	function setUserLogID($val)
	{
		$this->UserLogID = $val;
	}
	function setUserID($val)
	{
		$this->User->UserID = $val;
	}
	function setLastLogDate($val)
	{
		$this->LastLogDate = $val;
	}
	function setLastLogIP($val)
	{
		$this->LastLogIP = $val;
	}
	
	function getLinkID()
	{
		return 'userlogid='.$this->UserLogID;
	}
}

?>