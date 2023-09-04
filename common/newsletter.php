<? 

/* CMS Studio 3.0 newsletter.php secured */

class Newsletter extends OpstiDomenskiObjekat
{
    public $NewsletterID;
	public $Header;
	public $Html;
    public $Date;
	public $TotalForSend;
	public $EmbeddImage;
	public $SfStatus;
	public $UserRole;
	
    //konstruktor za Kategoriju
    function __construct()
    {
		parent::__construct();
		
		$this->UserRole = $this->ObjectFactory->createObject("UserRole",-1);
		$this->SfStatus = $this->ObjectFactory->createObject("SfStatus",-1);

		$this->NewsletterID = -1;
		$this->Header = "";
		$this->Html = "";
		$this->Date = time();
		$this->TotalForSend = "";
		$this->EmbeddImage = 0;
		$this->SfStatus->setStatusID(-1);
		
		$this->TableName = "newsletter";
		$this->LanguageHelper->ChangeTableName($this->TableName);
    }
	
    function Newsletter_POST(&$post)
    {
    	$this->UserRole = $this->ObjectFactory->createObject("UserRole",-1);
		$this->SfStatus = $this->ObjectFactory->createObject("SfStatus",-1);
		
		$this->NewsletterID = isset($post["newsletterid"]) ? $post["newsletterid"] : $this->NewsletterID;
		$this->Header = isset($post["header"]) ? $post["header"] : $this->Header;
		$this->Html = isset($post["html"]) ? $post["html"] : $this->Html;
		$this->Date = isset($post["date"]) ? $post["date"] : $this->Date;
		$this->EmbeddImage = isset($post["embeddimage"]) ? $post["embeddimage"] : $this->EmbeddImage;
		$this->SfStatus->setStatus(isset($post["statusid"]) ? $post["statusid"] : $this->SfStatus->getStatusID());
		$this->UserRole->setUserRoleID(isset($post["userroleid"]) ? $post["userroleid"] : $this->UserRole->getUserRoleID());
    }
    
    function vratiImenaAtributa() {return "`newsletter_id` , `header` , `html` ,`date`,`total_for_send`,`embedd_image`,`status_id`,`userroleid`";}
    function vratiImeKlase(){return $this->TableName;}
	function vratiVrednostiAtributa(){ return "'',". $this->quote_smart($this->Header) . ",". $this->quote_smart($this->Html) . ",".$this->quote_smart($this->Date). ",".$this->quote_smart($this->TotalForSend). ",".$this->quote_smart($this->EmbeddImage) . " , ". $this->quote_smart($this->SfStatus->getStatusID())." , ". $this->quote_smart($this->UserRole->UserRoleID) ; }
    function postaviVrednostiAtributa()
    { 
		return "`header` = ".$this->quote_smart($this->Header). " , `html` = ".$this->quote_smart($this->Html).",`date` = ".$this->quote_smart($this->Date).",`total_for_send` = ".$this->quote_smart($this->TotalForSend).",`embedd_image` = ".$this->quote_smart($this->EmbeddImage)." ,`status_id` =".$this->quote_smart($this->SfStatus->getStatusID())." ,`userroleid` =".$this->quote_smart($this->UserRole->UserRoleID);
	}
	function nazivVezeKaRoditelju(){ return "newsletter";}
    function vratiAtributPretrazivanja(){ return "newsletter_id"; }
    function vratiUslovZaNadjiSlog(){ return "newsletter_id=" . $this->quote_smart($this->NewsletterID);}
    function vratiFulltextIndekse(){ return  "header, html";} //definisemo polja nad kojima je postavljem fulltext index
	function vratiUslovZaSortiranje(){ return "date DESC";} 
	function vratiUslovZaNadjiSlogF(){ return "newsletter_id=" . $this->quote_smart($this->NewsletterID);}
	function vratiUslovZaNadjiSlogove(){ return "1";}
	function postaviID($id){ $this->NewsletterID = $id;}
	function toString() {}
	
	function napuni($result_row)
	{
		$this->NewsletterID = $result_row->newsletter_id;
		$this->Header = $result_row->header;
		$this->Html = $result_row->html;
		$this->Date = $result_row->date;
		$this->TotalForSend = $result_row->total_for_send;
		$this->EmbeddImage = $result_row->embedd_image;
		$this->SfStatus->setStatusID($result_row->status_id);
		$this->UserRole->UserRoleID= $result_row->userroleid;
  	}

	function napuniNiz($result_set, &$al)
	{
		if(count($result_set)>0)
			foreach($result_set as $result_row){
				$nw = $this->ObjectFactory->createObject("Newsletter",-1);
				$nw->NewsletterID = $result_row->newsletter_id;
				$nw->Header = $result_row->header;
				$nw->Html = $result_row->html;
				$nw->Date = $result_row->date;
				$nw->TotalForSend = $result_row->total_for_send;
				$nw->EmbeddImage = $result_row->embedd_image;				
				$nw->SfStatus->setStatusID($result_row->status_id);
				$nw->UserRole->UserRoleID= $result_row->userroleid;
				array_push($al, $nw);
			}
	}
	
	function napuniVisePovezi($result_set, $relation_name)
	{
		switch ($relation_name)
		{
			case "userrole":
				if(count($result_set)>0) $this->UserRole->napuni($result_set);
			break;
			case "sfstatus":
				if(count($result_set)>0) $this->SfStatus->napuni($result_set);
			break;
			
			default: break;
		}
	}
	
	function toArray()
	{
		$arr = array();
			$arr = array_merge($arr, array("newsletterid" => $this->getNewsletterID()));
			$arr = array_merge($arr, array("header" => $this->getHeader()));
			$arr = array_merge($arr, array("html" => $this->getHtml()));
			$arr = array_merge($arr, array("date" => $this->getDate()));
			$arr = array_merge($arr, array("totalforsend" => $this->getTotalForSend()));
			$arr = array_merge($arr, array("embeddimage" => $this->getEmbeddImage()));
			$arr = array_merge($arr, array("statusid" => $this->SfStatus->getStatusID()));
			$arr = array_merge($arr, array("userroleid" => $this->getUserRoleID()));
		return $arr;
	}
	
	// getter and setter
	function getNewsletterID()
	{
		return $this->NewsletterID;
	}
	function getHeader()
	{
		return $this->Header;
	}
	function getHtml()
	{
		return $this->Html;
	}
	function getDate()
	{
		return $this->Date;
	}
	
	function getTotalForSend()
	{
		return $this->TotalForSend;
	}
	
	function getEmbeddImage()
	{
		return $this->EmbeddImage == 1 ? true : false ;
	}
	
	function getUserRoleID()
	{
		return $this->UserRole->UserRoleID;
	}
	
	function setNewsletterID($val)
	{
		$this->NewsletterID = $val;
	}
	function setHeader($val)
	{
		$this->Header = $val;
	}
	function setHtml($val)
	{
		$this->Html = $val;
	}
	function setDate($val)
	{
		$this->Date = $val;
	}
	
	function setTotalForSend($val)
	{
		$this->TotalForSend = $val;
	}
		
	function setEmbeddImage($val)
	{
		$this->EmbeddImage = $val;
	}
		
	function setUserroleid($val)
	{
		$this->Userroleid = $val;
	}
	function getLinkID()
	{
		return 'newsletterid='.$this->NewsletterID;
	}
}

class NewsletterBatch extends OpstiDomenskiObjekat
{
	private $NewsletterBatchID;
	private $SendTime;
	private $Status;
	
	public $Newsletter;
	public $User;
		
	//Bussiness PHP Object constructor	 
	function __construct()
	{
		parent::__construct();
		
		$this->Newsletter = $this->ObjectFactory->createObject("Newsletter",-1); 
		$this->User = $this->ObjectFactory->createObject("User",-1);
		 
		$this->NewsletterBatchID = 0;
		$this->Newsletter->NewsletterID = -1;
		$this->User->UserID = -1;
		$this->SendTime = 0;
		$this->Status = 0;
		
		$this->TableName= "newsletter_batch";
		$this->LanguageHelper->ChangeTableName($this->TableName);
	}
	
	// PHP Bussines Object overloaded constructor
	function NewsletterBatch_POST($post)
	{
		$this->Newsletter = new Newsletter();
		$this->User = new User();
		$this->setNewsletterBatchID(isset($post["newsletterbatchid"]) ? $post["newsletterbatchid"] : $this->getNewsletterBatchID());
		$this->Newsletter->setNewsletterID(isset($post["newsletterid"]) ? $post["newsletterid"] : $this->Newsletter->getNewsletterID());
		$this->User->setUserID(isset($post["userid"]) ? $post["userid"] : $this->User->getUserID());
		$this->setSendTime(isset($post["sendtime"]) ? $post["sendtime"] : $this->getSendTime());
		$this->setStatus(isset($post["status"]) ? $post["status"] : $this->getStatus());
	}
	
	// Function vratiImenaAtributa
	function vratiImenaAtributa() {
		return "`newsletter_batch_id`,`newsletter_id`,`user_id`,`send_time`,`status`";
	}
	// Function vratiImeKlase
	function vratiImeKlase(){return $this->TableName;}
	
	//Function vratiVrednostAtributa
	function vratiVrednostiAtributa(){ return "'',".$this->quote_smart($this->Newsletter->getNewsletterID()).",".$this->quote_smart($this->User->getUserID()).",".$this->quote_smart($this->getSendTime()).",".$this->quote_smart($this->getStatus());}
	
	//Function postaviVrednostiAtributa
	function postaviVrednostiAtributa(){ return "`newsletter_id`=".$this->quote_smart($this->Newsletter->getNewsletterID()).",`user_id`=".$this->quote_smart($this->User->getUserID()).",`send_time`=".$this->quote_smart($this->getSendTime()).",`status`=".$this->quote_smart($this->getStatus());}
	
	//Function nazivVezeKaRoditelju
	function nazivVezeKaRoditelju(){ return "newsletterbatch";}
	
	//Function vratiUslovZaNadjiSlog
	function vratiUslovZaNadjiSlog(){ return "newsletter_batch_id=".$this->quote_smart($this->getNewsletterBatchID());}
	
	//Function vratiUslovZaSortiranje
	function vratiUslovZaSortiranje(){ return "newsletter_batch_id";}
	
	//Function vratiUslovZaNadjiSlogF
	function vratiUslovZaNadjiSlogF(){ return "newsletter_batch_id=".$this->quote_smart($this->getNewsletterBatchID());}
	
	//Function vratiUslovZaNadjiSlogove
	function vratiUslovZaNadjiSlogove(){ return "1=";}
	
	//Function postaviID
	function postaviID($id){ $this->setNewsletterBatchID($this->quote_smart($id));}
	
	//Function napuni 
	function napuni($result_row)
	{
		$this->NewsletterBatchID = $result_row->newsletter_batch_id;
		$this->Newsletter->NewsletterID = $result_row->newsletter_id;
		$this->User->UserID = $result_row->user_id;
		$this->SendTime = $result_row->send_time;
		$this->Status = $result_row->status;
	}
	
	function napuniNiz($result_set, &$al){
	if(count($result_set)>0)
		foreach($result_set as $result_row){
			$odo = new NewsletterBatch();
			$odo->setNewsletterBatchID($result_row->newsletter_batch_id);
			$odo->Newsletter->setNewsletterID($result_row->newsletter_id);
			$odo->User->setUserID($result_row->user_id);
			$odo->setSendTime($result_row->send_time);
			$odo->setStatus($result_row->status);
			array_push($al, $odo);
		}
	}
	
	// Function napuniVisePovezi
	function napuniVisePovezi($result_set, $relation_name)
	{
		switch ($relation_name)
		{
			case "newsletter":
				if(count($result_set)>0) $this->Newsletter->napuni($result_set);
				break;
			case "user":
				if(count($result_set)>0) $this->User->napuni($result_set);
				break;
			default: break;
		}
	}
	
	function toArray()
	{
		$arr = array();
			$arr = array_merge($arr, array("newsletterbatchid" => $this->getNewsletterBatchID()));
			$arr = array_merge($arr, array("newsletterid" => $this->getNewsletterID()));
			$arr = array_merge($arr, array("userid" => $this->getUserID()));
			$arr = array_merge($arr, array("sendtime" => $this->getSendTime()));
			$arr = array_merge($arr, array("status" => $this->getStatus()));
		return $arr;
	}

	function getNewsletterBatchID()
	{
		return $this->NewsletterBatchID;
	}
	function getNewsletterID()
	{
		return $this->Newsletter->NewsletterID;
	}
	function getUserID()
	{
		return $this->User->UserID;
	}
	function getSendTime()
	{
		return $this->SendTime;
	}
	function getStatus()
	{
		return $this->Status;
	}
	
	function setNewsletterBatchID($val)
	{
		$this->NewsletterBatchID = $val;
	}
	function setNewsletterID($val)
	{
		$this->Newsletter->NewsletterID = $val;
	}
	function setUserID($val)
	{
		$this->User->UserID = $val;
	}
	function setSendTime($val)
	{
		$this->SendTime = $val;
	}
	function setStatus($val)
	{
		$this->Status = $val;
	}
	
	function getLinkID()
	{
		return 'newsletterbatchid='.$this->NewsletterBatchID;
	}
}

?>