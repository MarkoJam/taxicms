<?php 

class Comment extends OpstiDomenskiObjekat
{
	public $CommentID;
	public $FullName;
	public $City;
	public $State;
	public $Title;
	public $Message;
	public $Email;
	public $ResID;
	public $SfStatus;
	public $SfResource;
	public $CreateDate;
	public $CommentOrder;
	
	//Bussiness PHP Object constructor	 
	function __construct()
	{
		parent::__construct();
		
		$this->CommentID = 0;
		$this->FullName = "";
		$this->City = "";
		$this->State = "";
		$this->Title = "";
		$this->Message = "";
		$this->Email = "";
		$this->ResID = 0;		
		$this->SfStatus = $this->ObjectFactory->createObject("SfStatus",-1);
		$this->SfResource = $this->ObjectFactory->createObject("SfResource",-1);		
		$this->CreateDate = 0;
		$this->CommentOrder = 0;
		
		$this->TableName= "comment";
		$this->LanguageHelper->ChangeTableName($this->TableName);
	}
	
	// PHP Bussines Object overloaded constructor
	function Comment_POST($post)
	{
		$this->CommentID = isset($post["commentid"]) ? $post["commentid"] : $this->CommentID;
		$this->FullName = isset($post["fullname"]) ? $post["fullname"] : $this->FullName;
		$this->City = isset($post["city"]) ? $post["city"] : $this->City;
		$this->State = isset($post["state"]) ? $post["state"] : $this->State;
		$this->Title = isset($post["title"]) ? $post["title"] : $this->Title;
		$this->Message = isset($post["message"]) ? $post["message"] : $this->Message;
		$this->Email = isset($post["email"]) ? $post["email"] : $this->Email;
		$this->ResID = isset($post["resid"]) ? $post["resid"] : $this->ResID;
		
		$this->SfStatus->setStatusID(isset($post["statusid"])? $post["statusid"] : $this->SfStatus->getStatusID());
		$this->SfResource->setID(isset($post["resourceid"])? $post["resourceid"] : $this->SfResource->getID());
				
		$this->CreateDate = isset($post["createdate"]) ? $post["createdate"] : $this->CreateDate;
		$this->CommentOrder = isset($post["commentorder"]) ? $post["commentorder"] : $this->CommentOrder;

	}
	
	// Function vratiImenaAtributa
	function vratiImenaAtributa() {
		return "`comment_id`,`full_name`,`city`,`state`,`title`,`message`,`email`,`res_id`,`status_id`,`resource_id`,`create_date`,`comment_order`";
	}
	// Function vratiImeKlase
	function vratiImeKlase(){return $this->TableName;}
	
	//Function vratiVrednostAtributa
	function vratiVrednostiAtributa(){ return "
		'',
		".$this->quote_smart($this->FullName).",
		".$this->quote_smart($this->City).",
		".$this->quote_smart($this->State).",
		".$this->quote_smart($this->Title).",
		".$this->quote_smart($this->Message).",
		".$this->quote_smart($this->Email).",
		".$this->quote_smart($this->ResID).",		
		".$this->quote_smart($this->SfStatus->getStatusID()).",
		".$this->quote_smart($this->SfResource->getID()).",	
		".$this->quote_smart($this->CreateDate).",	
		".$this->quote_smart($this->CommentOrder);}
	
	//Function postaviVrednostiAtributa
	function postaviVrednostiAtributa(){ return 
	"`full_name`=".$this->quote_smart($this->FullName).",
	`city`=".$this->quote_smart($this->City).",
	`state`=".$this->quote_smart($this->State).",
	`title`=".$this->quote_smart($this->Title).",
	`message`=".$this->quote_smart($this->Message).",
	`email`=".$this->quote_smart($this->Email).",
	`res_id`=".$this->quote_smart($this->ResID).",	
	`status_id`=".$this->quote_smart($this->SfStatus->getStatusID()).",	
	`resource_id`=".$this->quote_smart($this->SfResource->getID()).",
	`create_date`=".$this->quote_smart($this->CreateDate).",		
	`comment_order`=".$this->quote_smart($this->CommentOrder);}
	
	//Function nazivVezeKaRoditelju
	function nazivVezeKaRoditelju(){ return "comment";}
	
	//Function vratiUslovZaNadjiSlog
	function vratiUslovZaNadjiSlog(){ return "comment_id=".$this->quote_smart($this->CommentID);}
	
	//Function vratiUslovZaSortiranje
	function vratiUslovZaSortiranje(){ return "create_date desc";}
	
	//Function vratiUslovZaNadjiSlogF
	function vratiUslovZaNadjiSlogF(){ return "comment_id=".$this->quote_smart($this->CommentID);}
	
	//Function vratiUslovZaNadjiSlogove
	function vratiUslovZaNadjiSlogove(){ return "1=";}
	
	//Function postaviID
	function postaviID($id){ $this->CommentID = $this->quote_smart($id);}
	
	//Function napuni 
	function napuni($result_row)
	{
		$this->CommentID = $result_row->comment_id;
		$this->FullName = $result_row->full_name;
		$this->City = $result_row->city;
		$this->State = $result_row->state;
		$this->Title = $result_row->title;
		$this->Message = $result_row->message;
		$this->Email = $result_row->email;
		$this->ResID = $result_row->res_id;		
		$this->SfStatus->setStatusID($result_row->status_id);		
		$this->SfResource->setID($result_row->resource_id);				
		$this->CreateDate = $result_row->create_date;
		$this->CommentOrder = $result_row->comment_order;		
	}
	
	function napuniNiz($result_set, &$al){
	if(count($result_set)>0)
		foreach($result_set as $result_row){
			$odo = new Comment();
			$odo->CommentID = $result_row->comment_id;
			$odo->FullName = $result_row->full_name;
			$odo->City = $result_row->city;
			$odo->State = $result_row->state;
			$odo->Title = $result_row->title;
			$odo->Message = $result_row->message;
			$odo->Email = $result_row->email;
			$odo->ResID = $result_row->res_id;			
			$odo->SfStatus->setStatusID($result_row->status_id);
			$odo->SfResource->setID($result_row->resource_id);			
			$odo->CreateDate = $result_row->create_date;
			$odo->CommentOrder = $result_row->comment_order;			
			array_push($al, $odo);
		}
	}
	
	function napuniVisePovezi($result_set, $relation_name)
	{
		switch ($relation_name){

			case "sfstatus":					
				if (count($result_set) > 0) { $this->SfStatus->napuni($result_set); }
				break;
			case "sfresource":
				if (count($result_set) > 0) { $this->SfResource->napuni($result_set); }
				break;				
			default: break;
		}
	}
	
	function toArray()
	{
		$arr = array();
			$arr = array_merge($arr, array("commentid" => $this->CommentID));
			$arr = array_merge($arr, array("fullname" => $this->FullName));
			$arr = array_merge($arr, array("city" => $this->City));
			$arr = array_merge($arr, array("state" => $this->State));
			$arr = array_merge($arr, array("title" => $this->Title));
			$arr = array_merge($arr, array("message" => $this->Message));
			$arr = array_merge($arr, array("email" => $this->Email));
			$arr = array_merge($arr, array("resid" => $this->ResID));			
			$arr = array_merge($arr, array("statusid" => $this->getStatusID()));			
			$arr = array_merge($arr, array("resourceid" => $this->getResourceID()));						
			$arr = array_merge($arr, array("createdate" => $this->CreateDate));
			$arr = array_merge($arr, array("commentorder" => $this->CommentOrder));			
			$arr = array_merge($arr, array("printdate" => $this->LanguageHelper->getDateTranslated($this->getCreateDate(),"l, j. F Y.")));
		return $arr;
	}

	function getCommentID()
	{
		return $this->CommentID;
	}
	function getFullName()
	{
		return $this->FullName;
	}
	function getCity()
	{
		return $this->City;
	}
	function getState()
	{
		return $this->State;
	}
	function getTitle()
	{
		return $this->Title;
	}
	function getMessage()
	{
		return $this->Message;
	}
	function getEmail()
	{
		return $this->Email;
	}
	function getResID()
	{
		return $this->ResID;
	}	
	function getSfStatus()
	{
		return $this->SfStatus;
	}
	function getStatusID()
	{
		return $this->SfStatus->StatusID;
	}	
	function getSfResource()
	{
		return $this->SfResource;
	}
	function getResourceID()
	{
		return $this->SfResource->ID;
	}		
	function getCreateDate()
	{
		return $this->CreateDate;
	}
	function getCommentOrder()
	{
		return $this->CommentOrder;
	}	
	
	function setCommentID($val)
	{
		$this->CommentID = $val;
	}
	function setFullName($val)
	{
		$this->FullName = $val;
	}
	function setCity($val)
	{
		$this->City = $val;
	}
	function setState($val)
	{
		$this->State = $val;
	}
	function setTitle($val)
	{
		$this->Title = $val;
	}
	function setMessage($val)
	{
		$this->Message = $val;
	}
	function setEmail($val)
	{
		$this->Email = $val;
	}
	function setResID($val)
	{
		$this->ResID = $val;
	}	
	function setStatusID($val)
	{
		$this->SfStatus->StatusID = $val;
	}	
	function setResourceID($val)
	{
		$this->SfResource->ID = $val;
	}	
	function setCreateDate($val)
	{
		$this->CreateDate = $val;
	}
	function setCommentOrder($val)
	{
		$this->CommentOrder = $val;
	}	
	function getLinkID()
	{
		return 'commentid='.$this->CommentID;
	}
}

?>