<?

/* CMS Studio 3.0 adminpage.php secured */

class AdminUser extends OpstiDomenskiObjekat 
{
	public $AdminUserID;
	public $FullName;
	public $Place;
	public $Address;
	public $Email;
	public $Comment;
	public $Phone;
	public $UserName;
	public $Password;
	public $ExpiryDate;
	
	public $SfStatus;
	public $SubSite;
	public $AdminUserGroup;

	//Bussiness PHP Object constructor	 
	function __construct()
	{
		parent::__construct();
		
		$this->AdminUserGroup = $this->ObjectFactory->createObject("AdminUserGroup",-1);
		$this->SubSite = $this->ObjectFactory->createObject("SubSite",-1);
		$this->SfStatus = $this->ObjectFactory->createObject("SfStatus",-1);
		
		$this->AdminUserID = -1;
		$this->FullName = "";
		$this->Place ="";
		$this->Address = "";
		$this->Email = "";
		$this->Comment = "";
		$this->Phone = "";
		$this->UserName = "";
		$this->Password = "";
		
		$this->ExpiryDate = 0;
	}
	
	// fill AdminUser from POST
	function AdminUser_POST(&$post)
	{
		$this->AdminUserID= isset($post["adminuserid"]) ? $post["adminuserid"] : $this->AdminUserID;
		$this->FullName= isset($post["fullname"]) ? $post["fullname"] : $this->FullName;
		$this->Place = isset($post["place"]) ? $post["place"] : $this->Place;
		$this->Address = isset($post["address"]) ? $post["address"] : $this->Address;
		$this->Email= isset($post["email"]) ? $post["email"] : $this->Email;
		$this->Phone = isset($post["phone"]) ? $post["phone"] : $this->Phone;
		$this->Comment= isset($post["comment"]) ? $post["comment"] : $this->Comment;
		$this->UserName= isset($post["username"]) ? $post["username"] : $this->UserName;
		$this->Password= isset($post["password"]) ? $post["password"] : $this->Password;
		$this->ExpiryDate = isset($post["expirydate"]) ? $post["expirydate"] : $this->ExpiryDate;
		
		$this->AdminUserGroup = $this->ObjectFactory->createObject("AdminUserGroup",-1);
		$this->AdminUserGroup->AdminUserGroupID =  isset($post["adminusergroupid"]) ? $post["adminusergroupid"] : $this->AdminUserGroup->AdminUserGroupID;
		
		$this->SubSite = $this->ObjectFactory->createObject("SubSite",-1);
		$this->SubSite->SubSiteID = isset($post["subsiteid"]) ? $post["subsiteid"] : $this->SubSite->SubSiteID;
		
		$this->SfStatus = $this->ObjectFactory->createObject("SfStatus",-1);
		$this->SfStatus->StatusID = isset($post["statusid"]) ? $post["statusid"] : $this->SfStatus->StatusID;
	}
	
	// DatabaseBroker functions
	function vratiImenaAtributa() {return "`admin_user_id`,`fullname`,`place`,`address`,`email`,`comment`,`phone`,`username`,`password`,`status_id`,`expirydate`,`admin_user_group_id`,`sub_site_id`";}
	function vratiImeKlase(){return "ad_adminuser";}
	function vratiVrednostiAtributa(){ return "'','".$this->FullName."','".$this->Place."','".$this->Address."','".$this->Email."','".$this->Comment."','".$this->Phone."','".$this->UserName."','".$this->Password."','".$this->SfStatus->StatusID."','".$this->ExpiryDate."','".$this->AdminUserGroup->AdminUserGroupID."','".$this->SubSite->SubSiteID."'";}
	function postaviVrednostiAtributa(){ return "`fullname` = '".$this->FullName."',`place` = '".$this->Place."',`address` = '".$this->Address."',`email` = '".$this->Email."',`comment` = '".$this->Comment."',`phone` = '".$this->Phone."',`username` = '".$this->UserName."',`password` = '".$this->Password."',`status_id` = '".$this->SfStatus->StatusID."',`expirydate` = '".$this->ExpiryDate."',`admin_user_group_id` = '".$this->AdminUserGroup->AdminUserGroupID."',`sub_site_id` = '".$this->SubSite->SubSiteID."'";}
	function nazivVezeKaRoditelju(){ return "ad_adminuser";}
	function vratiUslovZaNadjiSlog(){ return "admin_user_id=".$this->AdminUserID;}
	function vratiUslovZaSortiranje(){ return "fullname ";}
	function vratiUslovZaNadjiSlogF(){ return "admin_user_id=".$this->AdminUserID;}
	function vratiUslovZaNadjiSlogove(){ return "1=";}
	function postaviID($id){ $this->AdminUserID = $id;}
	function napuni($result_row)
	{
		$this->AdminUserID = $result_row->admin_user_id;
		$this->FullName = $result_row->fullname;
		$this->Place = $result_row->place;
		$this->Address = $result_row->address;
		$this->Email = $result_row->email;
		$this->Comment = $result_row->comment;
		$this->Phone = $result_row->phone;
		$this->UserName = $result_row->username;
		$this->Password = $result_row->password;
		$this->SfStatus->StatusID = $result_row->status_id;
		$this->ExpiryDate = $result_row->expirydate;
		$this->AdminUserGroup->AdminUserGroupID = $result_row->admin_user_group_id;
		$this->SubSite->SubSiteID = $result_row->sub_site_id;
	}
	function napuniNiz($result_set, &$al)
	{
		if(count($result_set)>0)
		{
			foreach($result_set as $result_row)
			{
				$usr = $this->ObjectFactory->createObject("AdminUser",-1);
				$usr->AdminUserID = $result_row->admin_user_id;
				$usr->FullName = $result_row->fullname;
				$usr->Place = $result_row->place;
				$usr->Address = $result_row->address;
				$usr->Email = $result_row->email;
				$usr->Comment = $result_row->comment;
				$usr->Phone = $result_row->phone;
				$usr->UserName = $result_row->username;
				$usr->Password = $result_row->password;
				$usr->SfStatus->StatusID = $result_row->status_id;
				$usr->ExpiryDate = $result_row->expirydate;
				$usr->AdminUserGroup->AdminUserGroupID = $result_row->admin_user_group_id;
				$usr->SubSite->SubSiteID = $result_row->sub_site_id;
				array_push($al, $usr);
			}
		}
	}
	
	function vratiImeVezneTabele($relation_class_name,& $vezna_klasa, & $uslov_join)
	{
		switch ($relation_class_name)
		{
			default: $vezna_klasa = "";
				break;
		}
	}
	
	function napuniVisePovezi($result_set, $relation_name)
	{
		switch ($relation_name)
		{
			case "ad_adminusergroup":
				if(count($result_set)>0) $this->AdminUserGroup->napuni($result_set);
				break;
			case "subsite":
				if(count($result_set)>0) $this->SubSite->napuni($result_set);
				break;
			case "sfstatus":
				if(count($result_set)>0) $this->SfStatus->napuni($result_set);
				break;
			default: break;
		}
	}
	// get metode ispravi ako ima nesto!!!
	function getAdminUserID()
	{
		return $this->AdminUserID;
	}
	function getFullName()
	{
		return $this->FullName;
	}
	function getPlace()
	{
		return $this->Place;
	}
	function getAddress()
	{
		return $this->Address;
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
	function getUserName()
	{
		return $this->UserName;
	}
	function getPassword()
	{
		return $this->Password;
	}
	function getUserRoles()
	{
		return $this->UserRoles;
	}
	function getAdminUserGroup()
	{
		return $this->AdminUserGroup->AdminUserGroupID;	
	}
	function getSubSite()
	{
		return $this->SubSite->SubSiteID;	
	}
	function getSfStatus()
	{
		return $this->SfStatus->StatusID;
	}
	function getExpiryDate()
	{
		return $this->ExpiryDate;
	}
	
	// set metode ispravi ako ima nesto!!!
	function setAdminUserID($val)
	{
		$this->AdminUserID= $val;
	}
	function setFullName($val)
	{
		$this->FullName= $val;
	}
	function setPlace($val)
	{
		$this->Place = $val;
	}
	function setAddress($val)
	{
		$this->Address = $val;
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
	function setUserName($val)
	{
		$this->UserName= $val;
	}
	function setPassword($val)
	{
		$this->Password= $val;
	}
	function setSfStatus($val)
	{
		$this->SfStatus->StatusID = $val;
	}
	function setExpiryDate($val)
	{
		$this->ExpiryDate = $val;
	}
	
	function setAdminUserGroup($val)
	{
		$this->AdminUserGroup->AdminUserGroupID = $val;	
	}
	function setSubSite($val)
	{
		$this->SubSite->SubSiteID = $val;	
	}
	function getLinkID()
	{
		return 'adminuserid='.$this->AdminUserID;
	}
}
	
class AdminUserGroup extends OpstiDomenskiObjekat
{
	public $AdminUserGroupID;
	public $Title;
	public $Description;
	public $AdminUserAction;
	
	// PHP Bussines Object constructor
	function __construct()
	{
		parent::__construct();
		$this->AdminUserAction = array();
		
		$this->AdminUserGroupID = -1;
		$this->Title = "Nova korisnička grupa";
		$this->Description = "";
	}
	
	// PHP Bussines Object overloaded constructor
	function AdminUserGroup_POST($post)
	{
		$this->AdminUserAction = array();
	
		$this->AdminUserGroupID = isset($post["adminusergroupid"]) ? $post["adminusergroupid"] : $this->AdminUserGroupID;
		$this->Title = isset($post["title"]) ? $post["title"] : $this->Title;
		$this->Description = isset($post["description"]) ? $post["description"] : $this->Description;
	}
	
	// Function vratiImenaAtributa
	function vratiImenaAtributa() {
		return "`admin_user_group_id`,`title`,`description`";
	}
	// Function vratiImeKlase
	function vratiImeKlase(){return "ad_adminusergroup";}
	
	//Function vratiVrednostAtributa
	function vratiVrednostiAtributa(){ return "'',".$this->quote_smart($this->Title).",".$this->quote_smart($this->Description);}
	
	//Function postaviVrednostiAtributa
	function postaviVrednostiAtributa(){ return "`title`=".$this->quote_smart($this->Title).",`description`=".$this->quote_smart($this->Description);}
	
	//Function nazivVezeKaRoditelju
	function nazivVezeKaRoditelju(){ return "ad_adminusergroup";}
	
	//Function vratiUslovZaNadjiSlog
	function vratiUslovZaNadjiSlog(){ return "admin_user_group_id=".$this->quote_smart($this->AdminUserGroupID);}
	
	//Function vratiUslovZaSortiranje
	function vratiUslovZaSortiranje(){ return "title";}
	
	//Function vratiUslovZaNadjiSlogF
	function vratiUslovZaNadjiSlogF(){ return "admin_user_group_id=".$this->quote_smart($this->AdminUserGroupID);}
	
	//Function vratiUslovZaNadjiSlogove
	function vratiUslovZaNadjiSlogove(){ return "1=";}
	
	//Function postaviID
	function postaviID($id){ $this->AdminUserGroupID = $this->quote_smart($id);}
	
	//Function napuni 
	function napuni($result_row)
	{
		$this->AdminUserGroupID = $result_row->admin_user_group_id;
		$this->Title = $result_row->title;
		$this->Description = $result_row->description;
	}
	
	function napuniNiz($result_set, &$al){
	if(count($result_set)>0)
		foreach($result_set as $result_row){
			$odo = $this->ObjectFactory->createObject("AdminUserGroup",-1);
			$odo->AdminUserGroupID = $result_row->admin_user_group_id;
			$odo->Title = $result_row->title;
			$odo->Description = $result_row->description;
			array_push($al, $odo);
		}
	}
	
	function vratiImeVezneTabele($relation_class_name,& $vezna_klasa, & $uslov_join)
	{
		switch ($relation_class_name)
		{
			case "ad_adminuseraction":
				$vezna_klasa = "ad_adminusergroupaction";
				$uslov_join = "IJ1.admin_user_action_id= IJ2.admin_user_action_id";
				break;
		}
	}
	
	// Function napuniVisePovezi
	function napuniVisePovezi($result_set, $relation_name)
	{
		switch ($relation_name)
		{
			case "ad_adminuseraction":
				if(count($result_set)>0)
				foreach($result_set as $db_res)
				{
					$odo = $this->ObjectFactory->createObject("AdminUserAction",-1);
					$odo->napuni($db_res);
					array_push($this->AdminUserAction,$odo);
				}
			break;
			default: break;
		}
	}
	
	function toArray()
	{
		$arr = array();
			$arr = array_merge($arr, array("adminusergroupid" => $this->AdminUserGroupID));
			$arr = array_merge($arr, array("title" => $this->Title));
			$arr = array_merge($arr, array("description" => $this->Description));
		return $arr;
	}
	
	function getAdminUserGroupID()
	{
		return $this->AdminUserGroupID;
	}
	function getTitle()
	{
		return $this->Title;
	}
	function getDescription()
	{
		return $this->Description;
	}
	function setAdminUserGroupID($val)
	{
		$this->AdminUserGroupID = $val;
	}
	function setTitle($val)
	{
		$this->Title = $val;
	}
	function setDescription($val)
	{
		$this->Description = $val;
	}
	function getLinkID()
	{
		return 'adminusergroupid='.$this->AdminUserGroupID;
	}
	}
	
class AdminUserAction extends OpstiDomenskiObjekat
{
	public $AdminUserActionID;
	public $Title;
	public $Description;
	public $ActionCode;
	public $Plugin;
	
	// PHP Bussines Object constructor
	function __construct()
	{
		parent::__construct();
		
		$this->AdminUserActionID = 0;
		$this->Title = "Naziv akcije";
		$this->Description = "Opis akcije";
		$this->ActionCode = "ACTION_";
		$this->Plugin = $this->ObjectFactory->createObject("Plugin",-1);
		$this->Plugin->PluginID = -1;
	}
	
	// PHP Bussines Object overloaded constructor
	function AdminUserAction_POST($post)
	{
		$this->ObjectFactory = ObjectFactory::getInstance();
		$this->AdminUserActionID = isset($post["adminuseractionid"]) ? $post["adminuseractionid"] : $this->AdminUserActionID;
		$this->Title = isset($post["title"]) ? $post["title"] : $this->Title;
		$this->Description = isset($post["description"]) ? $post["description"] : $this->Description;
		$this->ActionCode = isset($post["actioncode"]) ? $post["actioncode"] : $this->ActionCode;
		$this->Plugin =  $this->ObjectFactory->createObject("Plugin",-1);
		$this->Plugin->PluginID = isset($post["pluginid"]) ? $post["pluginid"] : $this->Plugin->PluginID;
	}
	
	// Function vratiImenaAtributa
	function vratiImenaAtributa() {
		return "`admin_user_action_id`,`title`,`description`,`action_code`,`pluginid`";
	}
	// Function vratiImeKlase
	function vratiImeKlase(){return "ad_adminuseraction";}
	
	//Function vratiVrednostAtributa
	function vratiVrednostiAtributa(){ return "'',".$this->quote_smart($this->Title).",".$this->quote_smart($this->Description).",".$this->quote_smart($this->ActionCode).",".$this->quote_smart($this->Plugin->PluginID);}
	
	//Function postaviVrednostiAtributa
	function postaviVrednostiAtributa(){ return "`title`=".$this->quote_smart($this->Title).",`description`=".$this->quote_smart($this->Description).",`action_code`=".$this->quote_smart($this->ActionCode).",`pluginid`=".$this->quote_smart($this->Plugin->PluginID);}
	
	//Function nazivVezeKaRoditelju
	function nazivVezeKaRoditelju(){ return "ad_adminuseraction";}
	
	//Function vratiUslovZaNadjiSlog
	function vratiUslovZaNadjiSlog(){ return "admin_user_action_id=".$this->quote_smart($this->AdminUserActionID);}
	
	//Function vratiUslovZaSortiranje
	function vratiUslovZaSortiranje(){ return "title";}
	
	//Function vratiUslovZaNadjiSlogF
	function vratiUslovZaNadjiSlogF(){ return "admin_user_action_id=".$this->quote_smart($this->AdminUserActionID);}
	
	//Function vratiUslovZaNadjiSlogove
	function vratiUslovZaNadjiSlogove(){ return "1=";}
	
	//Function postaviID
	function postaviID($id){ $this->AdminUserActionID = $this->quote_smart($id);}
	
	//Function napuni 
	function napuni($result_row)
	{
		$this->AdminUserActionID = $result_row->admin_user_action_id;
		$this->Title = $result_row->title;
		$this->Description = $result_row->description;
		$this->ActionCode = $result_row->action_code;
		$this->Plugin->PluginID = $result_row->pluginid;
	}
	
	function napuniNiz($result_set, &$al){
	if(count($result_set)>0)
		foreach($result_set as $result_row){
			$odo = $this->ObjectFactory->createObject("AdminUserAction",-1);
			$odo->AdminUserActionID = $result_row->admin_user_action_id;
			$odo->Title = $result_row->title;
			$odo->Description = $result_row->description;
			$odo->ActionCode = $result_row->action_code;
			$odo->Plugin->PluginID = $result_row->pluginid;
			array_push($al, $odo);
		}
	}
	
	// Function napuniVisePovezi
	function napuniVisePovezi($result_set, $relation_name)
	{
		switch ($relation_name)
		{
			case "plugin":
				if(count($result_set)>0) $this->Plugin->napuni($result_set);
				break;
			
			default: break;
		}
	}
	
	function toArray()
	{
		$arr = array();
			$arr = array_merge($arr, array("adminuseractionid" => $this->AdminUserActionID));
			$arr = array_merge($arr, array("title" => $this->Title));
			$arr = array_merge($arr, array("description" => $this->Description));
			$arr = array_merge($arr, array("actioncode" => $this->ActionCode));
			$arr = array_merge($arr, array("pluginid" => $this->Plugin->PluginID));
		return $arr;
	}
	
	function getAdminUserActionID()
	{
		return $this->AdminUserActionID;
	}
	function getTitle()
	{
		return $this->Title;
	}
	function getDescription()
	{
		return $this->Description;
	}
	function getActionCode()
	{
		return $this->ActionCode;
	}
	function getPluginID()
	{
		return $this->Plugin->PluginID;
	}
	
	function setAdminUserActionID($val)
	{
		$this->AdminUserActionID = $val;
	}
	function setTitle($val)
	{
		$this->Title = $val;
	}
	function setDescription($val)
	{
		$this->Description = $val;
	}
	function setActionCode($val)
	{
		$this->ActionCode = $val;
	}
	function setPluginID($val)
	{
		$this->Plugin->PluginID = $val;
	}
	
	function getLinkID()
	{
		return 'adminuseractionid='.$this->AdminUserActionID;
	}
	}
	
class AdminUserGroupAction extends OpstiDomenskiObjekat
{
	public $AdminUserGroupID;
	public $AdminUserActionID;
	
	// PHP Bussines Object constructor
	function __construct()
	{
		parent::__construct();
		
		$this->AdminUserGroupID = -1;
		$this->AdminUserActionID = -1;
	}
	
	// PHP Bussines Object overloaded constructor
	function AdminUserGroupAction_POST($post)
	{
		$this->ObjectFactory = ObjectFactory::getInstance();
		
		$this->AdminUserGroupID = isset($post["adminusergroupid"]) ? $post["adminusergroupid"] : $this->AdminUserGroupID;
		$this->AdminUserActionID = isset($post["adminuseractionid"]) ? $post["adminuseractionid"] : $this->AdminUserActionID;
	}
	
	// Function vratiImenaAtributa
	function vratiImenaAtributa() {
		return "`admin_user_group_id`,`admin_user_action_id`";
	}
	// Function vratiImeKlase
	function vratiImeKlase(){return "ad_adminusergroupaction";}
	
	//Function vratiVrednostAtributa
	function vratiVrednostiAtributa(){ return $this->quote_smart($this->AdminUserGroupID).",".$this->quote_smart($this->AdminUserActionID);}
	
	//Function postaviVrednostiAtributa
	function postaviVrednostiAtributa(){ return "`admin_user_group_id`=".$this->quote_smart($this->AdminUserGroupID)." , `admin_user_action_id`=".$this->quote_smart($this->AdminUserActionID);}
	
	//Function nazivVezeKaRoditelju
	function nazivVezeKaRoditelju(){ return "ad_adminusergroupaction";}
	
	//Function vratiUslovZaNadjiSlog
	function vratiUslovZaNadjiSlog(){ return "admin_user_action_id=".$this->quote_smart($this->AdminUserActionID). " AND ". "admin_user_group_id=".$this->quote_smart($this->AdminUserGroupID);}
	
	//Function vratiUslovZaSortiranje
	function vratiUslovZaSortiranje(){ return "admin_user_action_id";}
	
	//Function vratiUslovZaNadjiSlogF
	function vratiUslovZaNadjiSlogF(){ return "admin_user_action_id=".$this->quote_smart($this->AdminUserActionID);}
	
	//Function vratiUslovZaNadjiSlogove
	function vratiUslovZaNadjiSlogove(){ return "1=";}
	
	//Function postaviID
	function postaviID($id){ $this->AdminUserGroupID = $this->quote_smart($id);}
	
	//Function napuni 
	function napuni($result_row)
	{
		$this->AdminUserGroupID = $result_row->admin_user_group_id;
		$this->AdminUserActionID = $result_row->admin_user_action_id;
	}
	
	function napuniNiz($result_set, &$al){
	if(count($result_set)>0)
		foreach($result_set as $result_row){
			$odo = $this->ObjectFactory->createObject("AdminUserGroupAction",-1);
			$odo->AdminUserGroupID = $result_row->admin_user_group_id;
			$odo->AdminUserActionID = $result_row->admin_user_action_id;
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
		$arr = array_merge($arr, array("adminusergroupid" => $this->AdminUserGroupID));
		$arr = array_merge($arr, array("adminuseractionid" => $this->AdminUserActionID));
		
		return $arr;
	}
	
	function getAdminUserGroupID()
	{
		return $this->AdminUserGroupID;
	}
	function getAdminUserActionID()
	{
		return $this->AdminUserActionID;
	}
	
	function setAdminUserGroupID($val)
	{
		$this->AdminUserGroupID = $val;
	}
	function setAdminUserActionID($val)
	{
		$this->AdminUserActionID = $val;
	}
	
	function getLinkID()
	{
		return 'adminusergroupid='.$this->AdminUserGroupID;
	}
}

class AdminUserLogHistory extends OpstiDomenskiObjekat
{
	private $AdminUserLogID;
	private $LastLogDate;
	private $LastLogIP;
	public $AdminUser;	
	
	//Bussiness PHP Object constructor	 
	function __construct()
	{
		parent::__construct();
		
		$this->AdminUser = $this->ObjectFactory->createObject("AdminUser",-1); 
		$this->AdminUserLogID = 0;
		$this->AdminUser->AdminUserID = -1;
		$this->LastLogDate = 0;
		$this->LastLogIP = "";
		
		//$this->TableName= "ad_adminuser_log_history";
		//$this->LanguageHelper->ChangeTableName($this->TableName);
	}
	
	// PHP Bussines Object overloaded constructor
	function AdminUserLogHistory_POST($post)
	{
		$this->AdminUser = new AdminUser();
		$this->setAdminUserLogID(isset($post["adminuserlogid"]) ? $post["adminuserlogid"] : $this->getAdminUserLogID());
		$this->AdminUser->setAdminUserID(isset($post["adminuserid"]) ? $post["adminuserid"] : $this->AdminUser->getAdminUserID());
		$this->setLastLogDate(isset($post["lastlogdate"]) ? $post["lastlogdate"] : $this->getLastLogDate());
		$this->setLastLogIP(isset($post["lastlogip"]) ? $post["lastlogip"] : $this->getLastLogIP());
	}
	
	// Function vratiImenaAtributa
	function vratiImenaAtributa() {
		return "`admin_user_log_id`,`admin_user_id`,`last_log_date`,`last_log_ip`";
	}
	// Function vratiImeKlase
	function vratiImeKlase(){return "ad_adminuser_log_history";}
	
	//Function vratiVrednostAtributa
	function vratiVrednostiAtributa(){ return "'',".$this->quote_smart($this->AdminUser->getAdminUserID()).",".$this->quote_smart($this->getLastLogDate()).",".$this->quote_smart($this->getLastLogIP());}
	
	//Function postaviVrednostiAtributa
	function postaviVrednostiAtributa(){ return "`admin_user_id`=".$this->quote_smart($this->AdminUser->getAdminUserID()).",`last_log_date`=".$this->quote_smart($this->getLastLogDate()).",`last_log_ip`=".$this->quote_smart($this->getLastLogIP());}
	
	//Function nazivVezeKaRoditelju
	function nazivVezeKaRoditelju(){ return "adminuserloghistory";}
	
	//Function vratiUslovZaNadjiSlog
	function vratiUslovZaNadjiSlog(){ return "admin_user_log_id=".$this->quote_smart($this->getAdminUserLogID());}
	
	//Function vratiUslovZaSortiranje
	function vratiUslovZaSortiranje(){ return "last_log_date desc";}
	
	//Function vratiUslovZaNadjiSlogF
	function vratiUslovZaNadjiSlogF(){ return "admin_user_log_id=".$this->quote_smart($this->getAdminUserLogID());}
	
	//Function vratiUslovZaNadjiSlogove
	function vratiUslovZaNadjiSlogove(){ return "1=";}
	
	//Function postaviID
	function postaviID($id){ $this->setAdminUserLogID($this->quote_smart($id));}
	
	//Function napuni 
	function napuni($result_row)
	{
		$this->AdminUserLogID = $result_row->admin_user_log_id;
		$this->AdminUser->AdminUserID = $result_row->admin_user_id;
		$this->LastLogDate = $result_row->last_log_date;
		$this->LastLogIP = $result_row->last_log_ip;
	}
	
	function napuniNiz($result_set, &$al){
	if(count($result_set)>0)
		foreach($result_set as $result_row){
			$odo = new AdminUserLogHistory();
			$odo->setAdminUserLogID($result_row->admin_user_log_id);
			$odo->AdminUser->setAdminUserID($result_row->admin_user_id);
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
			case "adminuser":
				if(count($result_set)>0) $this->AdminUser->napuni($result_set);
				break;
			default: break;
		}
	}
	
	function toArray()
	{
		$arr = array();
			$arr = array_merge($arr, array("adminuserlogid" => $this->getAdminUserLogID()));
			$arr = array_merge($arr, array("adminuserid" => $this->getAdminUserID()));
			$arr = array_merge($arr, array("lastlogdate" => $this->getLastLogDate()));
			$arr = array_merge($arr, array("lastlogdateformated" => $this->getLastLogDateFormated()));
			$arr = array_merge($arr, array("lastlogip" => $this->getLastLogIP()));
		return $arr;
	}

	function getAdminUserLogID()
	{
		return $this->AdminUserLogID;
	}
	function getAdminUserID()
	{
		return $this->AdminUser->AdminUserID;
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
	
	function setAdminUserLogID($val)
	{
		$this->AdminUserLogID = $val;
	}
	function setAdminUserID($val)
	{
		$this->AdminUser->AdminUserID = $val;
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
		return 'adminuserlogid='.$this->AdminUserLogID;
	}
}

?>