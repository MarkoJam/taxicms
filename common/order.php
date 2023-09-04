<?

/* CMS Studio 3.0 order.php secured */

class PrOrder extends OpstiDomenskiObjekat
{
	public $OrderID;
	public $Date;

	public $SfStatus;
	public $SfOrderType;
	public $User;
	public $PrOrderItem;
	public $Amount;
	public $PostPrice;
	public $Company;
	public $Pib;
	public $Name;
	public $Address;
	public $SurName;
	public $PostalCode;
	public $Email;
	public $City;
	public $Phone;
	public $Country;
	public $ShipAddress;
	public $ShipPostalCode;
	public $ShipCity;
	public $ShipCountry;
	public $Note;

	//Bussiness PHP Object constructor
	function __construct()
	{
		parent::__construct();

		$this->User = $this->ObjectFactory->createObject("User",-1);
		$this->SfStatus = $this->ObjectFactory->createObject("SfStatus",-1);
		$this->SfOrderType = $this->ObjectFactory->createObject("SfOrderType",-1);
		$this->PrOrderItem = array();

		$this->OrderID = -1;
		$this->User->UserID = 0;
		$this->Date = time();
		$this->Amount = 0;
		$this->PostPrice = 0;
		$this->Company = "";
		$this->Pib = "";
		$this->Name = "";
		$this->Address = "";
		$this->SurName = "";
		$this->PostalCode = "";
		$this->Email = "";
		$this->City = "";
		$this->Phone = "";
		$this->Country = "";
		$this->ShipAddress = "";
		$this->ShipPostalCode = "";
		$this->ShipCity = "";
		$this->ShipCountry = "";
		$this->SfStatus->setStatusID(-1);
		$this->SfOrderType->setOrderTypeID(-1);
		$this->Note = "";

		$this->TableName = "pr_order";

		$this->LanguageHelper->ChangeTableName($this->TableName);
	}

	// fill PrOrder from POST
	function PrOrder_POST(&$post)
	{
		$this->User = $this->ObjectFactory->createObject("User",-1);
		$this->SfStatus = $this->ObjectFactory->createObject("SfStatus",-1);
		$this->SfOrderType = $this->ObjectFactory->createObject("SfOrderType",-1);
		$this->PrOrderItem = array();

		$this->OrderID = isset($post["orderid"]) ? $post["orderid"] : $this->OrderID;
		$this->Date = isset($post["date"]) ? $post["date"] : $this->Date;
		$this->Amount = isset($post["amount"]) ? $post["amount"] : $this->Amount;
		$this->PostPrice = isset($post["postprice"]) ? $post["postprice"] : $this->PostPrice;
		$this->Company = isset($post["company"]) ? $post["company"] : $this->Company;
		$this->Pib = isset($post["pib"]) ? $post["pib"] : $this->Pib;
		$this->Name = isset($post["name"]) ? $post["name"] : $this->Name;
		$this->Address = isset($post["address"]) ? $post["address"] : $this->Address;
		$this->SurName = isset($post["surname"]) ? $post["surname"] : $this->SurName;
		$this->PostalCode = isset($post["postalcode"]) ? $post["postalcode"] : $this->PostalCode;
		$this->Email = isset($post["email"]) ? $post["email"] : $this->Email;
		$this->City = isset($post["city"]) ? $post["city"] : $this->City;
		$this->Phone = isset($post["phone"]) ? $post["phone"] : $this->Phone;
		$this->Country = isset($post["country"]) ? $post["country"] : $this->Country;
		$this->ShipAddress = isset($post["shipaddress"]) ? $post["shipaddress"] : $this->ShipAddress;
		$this->ShipPostalCode = isset($post["shippostalcode"]) ? $post["shippostalcode"] : $this->ShipPostalCode;
		$this->ShipCity = isset($post["shipcity"]) ? $post["shipcity"] : $this->ShipCity;
		$this->ShipCountry = isset($post["shipcountry"]) ? $post["shipcountry"] : $this->ShipCountry;
		$this->User->UserID = isset($post["user->userid"]) ? $post["user->userid"] : $this->User->UserID;
		$this->SfStatus->setStatusID(isset($post["statusid"]) ? $post["statusid"] : $this->SfStatus->getStatusID());
		$this->SfOrderType->setOrderTypeID(isset($post["ordertypeid"]) ? $post["ordertypeid"] : $this->SfOrderType->getOrderTypeID());
		$this->Note = isset($post["note"]) ? $post["note"] : $this->Note;
	}

	// DatabaseBroker functions
	function vratiImenaAtributa() {return "`orderid`,`userid`,`date`,`amount`,`postprice`,`company`,`pib`,`name`,`address`,`surname`,`postalcode`,`email`,`city`,`phone`,`country`,`shipaddress`,`shippostalcode`,`shipcity`,`shipcountry`,`status_id`,`order_type_id`,`note`";}
	function vratiImeKlase(){return $this->TableName;}
	function vratiVrednostiAtributa(){ return "'',
	".$this->quote_smart($this->User->UserID).",
	".$this->quote_smart($this->Date).",
	".$this->quote_smart($this->Amount).",
	".$this->quote_smart($this->PostPrice).",
	".$this->quote_smart($this->Company).",
	".$this->quote_smart($this->Pib).",
	".$this->quote_smart($this->Name).",
	".$this->quote_smart($this->Address).",
	".$this->quote_smart($this->SurName).",
	".$this->quote_smart($this->PostalCode).",
	".$this->quote_smart($this->Email).",
	".$this->quote_smart($this->City).",
	".$this->quote_smart($this->Phone).",
	".$this->quote_smart($this->Country).",
	".$this->quote_smart($this->ShipAddress).",
	".$this->quote_smart($this->ShipPostalCode).",
	".$this->quote_smart($this->ShipCity).",
	".$this->quote_smart($this->ShipCountry).",
	".$this->quote_smart($this->SfStatus->getStatusID()).",
	".$this->quote_smart($this->SfOrderType->getOrderTypeID()).",
	".$this->quote_smart($this->Note);}
		// promeniti ?
	function postaviVrednostiAtributa(){ return "
	`userid` = ".$this->quote_smart($this->User->UserID).",
	`date` = ".$this->quote_smart($this->Date).",
	`amount` = ".$this->quote_smart($this->Amount).",
	`postprice` = ".$this->quote_smart($this->PostPrice).",
	`company` = ".$this->quote_smart($this->Company).",
	`pib` = ".$this->quote_smart($this->Pib).",
	`name` = ".$this->quote_smart($this->Name).",
	`address` = ".$this->quote_smart($this->Address).",
	`surname` = ".$this->quote_smart($this->SurName).",
	`postalcode` = ".$this->quote_smart($this->PostalCode).",
	`email` = ".$this->quote_smart($this->Email).",
	`city` = ".$this->quote_smart($this->City).",
	`phone` = ".$this->quote_smart($this->Phone).",
	`country` = ".$this->quote_smart($this->Country).",
	`shipaddress` = ".$this->quote_smart($this->ShipAddress).",
	`shippostalcode` = ".$this->quote_smart($this->ShipPostalCode).",
	`shipcity` = ".$this->quote_smart($this->ShipCity).",
	`shipcountry` = ".$this->quote_smart($this->ShipCountry).",
	`status_id` = ".$this->quote_smart($this->SfStatus->getStatusID()).",
	`order_type_id` = ".$this->quote_smart($this->SfOrderType->getOrderTypeID()).",
	`note` = ".$this->quote_smart($this->Note);}
	//
	function nazivVezeKaRoditelju(){ return "prorder";}
	function vratiUslovZaNadjiSlog(){ return "orderid=".$this->quote_smart($this->OrderID);}
	function vratiUslovZaSortiranje(){ return "date DESC";}
	function vratiUslovZaNadjiSlogF(){ return "orderid=".$this->quote_smart($this->OrderID);}
	function vratiUslovZaNadjiSlogove(){ return "1=";}
	function postaviID($id){ $this->OrderID = $id;}
	function napuni($result_row)
	{
		$this->OrderID = $result_row->orderid;
		$this->User->UserID = $result_row->userid;
		$this->Date = $result_row->date;
		$this->Amount = $result_row->amount;
		$this->PostPrice = $result_row->postprice;
		$this->Company = $result_row->company;
		$this->Pib = $result_row->pib;
		$this->Name = $result_row->name;
		$this->Address = $result_row->address;
		$this->SurName = $result_row->surname;
		$this->PostalCode = $result_row->postalcode;
		$this->Email = $result_row->email;
		$this->City = $result_row->city;
		$this->Phone = $result_row->phone;
		$this->Country = $result_row->country;
		$this->ShipAddress = $result_row->shipaddress;
		$this->ShipPostalCode = $result_row->shippostalcode;
		$this->ShipCity = $result_row->shipcity;
		$this->ShipCountry = $result_row->shipcountry;
		$this->SfStatus->setStatusID($result_row->status_id);
		$this->SfOrderType->setOrderTypeID($result_row->order_type_id);
		$this->Note = $result_row->note;
	}
	function napuniNiz($result_set, &$al)
	{
		if(count($result_set)>0)
		{
			foreach($result_set as $result_row){
				$ord = $this->ObjectFactory->createObject("PrOrder",-1);
				$ord->OrderID = $result_row->orderid;
				$ord->User->UserID = $result_row->userid;
				$ord->Date = $result_row->date;
				$ord->Amount = $result_row->amount;
				$ord->PostPrice = $result_row->postprice;
				$ord->Company = $result_row->company;
				$ord->Pib = $result_row->pib;
				$ord->Name = $result_row->name;
				$ord->Address = $result_row->address;
				$ord->SurName = $result_row->surname;
				$ord->PostalCode = $result_row->postalcode;
				$ord->Email = $result_row->email;
				$ord->City = $result_row->city;
				$ord->Phone = $result_row->phone;
				$ord->Country = $result_row->country;
				$ord->ShipAddress = $result_row->shipaddress;
				$ord->ShipPostalCode = $result_row->shippostalcode;
				$ord->ShipCity = $result_row->shipcity;
				$ord->ShipCountry = $result_row->shipcountry;
				$ord->SfStatus->setStatusID($result_row->status_id);
				$ord->SfOrderType->setOrderTypeID($result_row->order_type_id);
				$ord->Note = $result_row->note;
				array_push($al, $ord);
			}
		}
	}
	function napuniVisePovezi($result_set, $relation_name){
		switch ($relation_name){
			case "user":
				if(count($result_set)>0) $this->User->napuni($result_set);
				break;
			case "prorderitem":
				if(count($result_set)>0)
				{
					foreach($result_set as $db_res)
					{
						$orditm = $this->ObjectFactory->createObject("PrOrderItem",-1);
						$orditm->napuni($db_res);
						array_push($this->PrOrderItem,$orditm);
					}
				}
				break;
			case "sfstatus":
				if(count($result_set)>0) $this->SfStatus->napuni($result_set);
				break;
			case "sfordertype":
				if(count($result_set)>0) $this->SfOrderType->napuni($result_set);
				break;
			default: break;
		}
	}

	function toArray()
	{
		$arr = array();
			$arr = array_merge($arr, array("orderid" => $this->getOrderID()));
			$arr = array_merge($arr, array("userid" => $this->getUserID()));
			$arr = array_merge($arr, array("date" => $this->getDate()));
			$arr = array_merge($arr, array("amount" => $this->getAmount()));
			$arr = array_merge($arr, array("postprice" => $this->getPostPrice()));
			$arr = array_merge($arr, array("company" => $this->getCompany()));
			$arr = array_merge($arr, array("pib" => $this->getPib()));
			$arr = array_merge($arr, array("name" => $this->getName()));
			$arr = array_merge($arr, array("address" => $this->getAddress()));
			$arr = array_merge($arr, array("surname" => $this->getSurName()));
			$arr = array_merge($arr, array("postalcode" => $this->getPostalCode()));
			$arr = array_merge($arr, array("email" => $this->getEmail()));
			$arr = array_merge($arr, array("city" => $this->getCity()));
			$arr = array_merge($arr, array("phone" => $this->getPhone()));
			$arr = array_merge($arr, array("country" => $this->getCountry()));
			$arr = array_merge($arr, array("shipaddress" => $this->getShipAddress()));
			$arr = array_merge($arr, array("shippostalcode" => $this->getShipPostalCode()));
			$arr = array_merge($arr, array("shipcity" => $this->getShipCity()));
			$arr = array_merge($arr, array("shipcountry" => $this->getShipCountry()));
			$arr = array_merge($arr, array("orderitems" => $this->getPrOrderItem()));
			$arr = array_merge($arr, array("statusid" => $this->SfStatus->getStatusID()));
			$arr = array_merge($arr, array("ordertypeid" => $this->SfOrderType->getOrderTypeID()));
			$arr = array_merge($arr, array("ordertype" => $this->SfOrderType->getVrednost()));
			$arr = array_merge($arr, array("status" => $this->SfStatus->getVrednost()));
			$arr = array_merge($arr, array("ukupnacena" => $this->getUkupnaCena()));
			$arr = array_merge($arr, array("note" => $this->getNote()));
		return $arr;
	}

	// getter and setter
	function getOrderID()
	{
		return $this->OrderID;
	}
	function getUserID()
	{
		return $this->User->UserID;
	}

	function getUser()
	{
		return $this->User;
	}
	function getDate()
	{
		return $this->Date;
	}
	function getAmount()
	{
		return $this->Amount;
	}
	function getPostPrice()
	{
		return $this->PostPrice;
	}
	function getCompany()
	{
		return $this->Company;
	}
	function getPib()
	{
		return $this->Pib;
	}
	function getName()
	{
		return $this->Name;
	}
	function getAddress()
	{
		return $this->Address;
	}
	function getSurName()
	{
		return $this->SurName;
	}
	function getPostalCode()
	{
		return $this->PostalCode;
	}
	function getEmail()
	{
		return $this->Email;
	}
	function getCity()
	{
		return $this->City;
	}
	function getPhone()
	{
		return $this->Phone;
	}
	function getCountry()
	{
		return $this->Country;
	}
	function getShipAddress()
	{
		return $this->ShipAddress;
	}
	function getShipPostalCode()
	{
		return $this->ShipPostalCode;
	}
	function getShipCity()
	{
		return $this->ShipCity;
	}
	function getShipCountry()
	{
		return $this->ShipCountry;
	}
	function getNote()
	{
		return $this->Note;
	}
	function getUkupnaCena()
	{
		$ukupnaCena = 0;
		foreach ($this->PrOrderItem as $order_item)
		{
			$ukupnaCena += $order_item->getAmount();
		}
		return $ukupnaCena;
	}
	function getPrOrderItem()
	{
		$order_items = array();
		foreach ($this->PrOrderItem as $order_item)
		{
			$order_items[] = $order_item->toArray();
		}
		return $order_items;
	}

	// set metode ispravi ako ima nesto!!!
	function setOrderID($val)
	{
		$this->OrderID= $val;
	}
	function setUserID($val)
	{
		$this->User->UserID= $val;
	}
	function setUser($val)
	{
		$this->User = $val;
	}
	function setDate($val)
	{
		$this->Date= $val;
	}
	function setAmount($val)
	{
		$this->Amount= $val;
	}
	function setPostPrice($val)
	{
		$this->PostPrice= $val;
	}
	function setCompany($val)
	{
		$this->Company= $val;
	}
	function setPib($val)
	{
		$this->Pib= $val;
	}
	function setName($val)
	{
		$this->Name= $val;
	}
	function setAddress($val)
	{
		$this->Address= $val;
	}
	function setSurName($val)
	{
		$this->SurName= $val;
	}
	function setPostalCode($val)
	{
		$this->PostalCode= $val;
	}
	function setEmail($val)
	{
		$this->Email= $val;
	}
	function setCity($val)
	{
		$this->City= $val;
	}
	function setPhone($val)
	{
		$this->Phone= $val;
	}
	function setCountry($val)
	{
		$this->Country= $val;
	}
	function setShipAddress($val)
	{
		$this->ShipAddress= $val;
	}
	function setShipPostalCode($val)
	{
		$this->ShipPostalCode= $val;
	}
	function setShipCity($val)
	{
		$this->ShipCity= $val;
	}
	function setShipCountry($val)
	{
		$this->ShipCountry= $val;
	}
	function setPrOrderItem($val)
	{
		$this->PrOrderItem = $val;
	}
	function getLinkID()
	{
		return 'orderid='.$this->OrderID;
	}
	function setNote($val)
	{
		$this->Note= $val;
	}

	function getPrintOrder()
	{
		$out = "";
		$out .= 	"<tr><td class='pc-fb-font' style='vertical-align: top; padding: 10px 0 0 0; font-family: Fira Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 1.89; letter-spacing: -0.3px; color: #151515;' valign='top'>Order Number: <span style='vertical-align: top; padding: 10px 0 0 0; font-family: Fira Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 700; line-height: 1.89;  color: #151515;'>" . $this->getOrderID() . " </span></td></tr>\r\n";
		$out .= 	"<tr><td class='pc-fb-font' style='vertical-align: top; padding: 0px 0 0 0; font-family: Fira Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 1.89; letter-spacing: -0.3px; color: #151515;' valign='top'>Order Date: <span style='vertical-align: top; padding: 0px 0 0 0; font-family: Fira Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 700; line-height: 1.89;  color: #151515;'>".date("d.m.Y",$this->Date)."</span></td></tr>\r\n";

		$out .= 	" <tr><td class='pc-fb-font' style='vertical-align: top; padding: 10px 15px 10px 0; font-family: Fira Sans, Helvetica, Arial, sans-serif; font-size: 24px; font-weight: 700; line-height: 1.42; letter-spacing: -0.4px; color: #151515;' valign='top'>Order summary</td></tr>\r\n";


		if(!empty($this->PrOrderItem))
		{
			$out .= "<tr><td style='vertical-align: top; ' valign='top'><table width='100%' cellpadding='2' cellspacing='2'>";
			$out .= "<tr>";
			$out .= "<th align='left' style='vertical-align: middle; padding: 5px 15px 5px 0; font-family: Fira Sans, Helvetica, Arial, sans-serif; font-size: 12px; font-weight: 700; line-height: 1.42;  color: #151515; text-transform:uppercase; border-top:1px solid #e0e0e0; border-bottom:1px solid #e0e0e0; text-align:left;' valign='middle' >No.</th>\r\n";
			$out .= "<th align='left' style='vertical-align: middle; padding: 5px 15px 5px 0; font-family: Fira Sans, Helvetica, Arial, sans-serif; font-size: 12px; font-weight: 700; line-height: 1.42;  color: #151515; text-transform:uppercase; border-top:1px solid #e0e0e0; border-bottom:1px solid #e0e0e0; text-align:left;' valign='middle' >Code</th>\r\n";
			$out .= "<th align='left' style='vertical-align: middle; padding: 5px 15px 5px 0; font-family: Fira Sans, Helvetica, Arial, sans-serif; font-size: 12px; font-weight: 700; line-height: 1.42;  color: #151515; text-transform:uppercase; border-top:1px solid #e0e0e0; border-bottom:1px solid #e0e0e0; text-align:left;' valign='middle' >Item</th>\r\n";
			$out .= "<th align='right' style='vertical-align: middle; padding: 5px 15px 5px 0; font-family: Fira Sans, Helvetica, Arial, sans-serif; font-size: 12px; font-weight: 700; line-height: 1.42;  color: #151515; text-transform:uppercase; border-top:1px solid #e0e0e0; border-bottom:1px solid #e0e0e0; text-align:right;' valign='middle' >Price</th>\r\n";
			$out .= "<th align='right' style='vertical-align: middle; padding: 5px 15px 5px 0; font-family: Fira Sans, Helvetica, Arial, sans-serif; font-size: 12px; font-weight: 700; line-height: 1.42;  color: #151515; text-transform:uppercase; border-top:1px solid #e0e0e0; border-bottom:1px solid #e0e0e0; text-align:right;' valign='middle' >Qty</th>\r\n";
			$out .= "<th align='right' width='70px' style='vertical-align: middle; padding: 5px 15px 5px 0; font-family: Fira Sans, Helvetica, Arial, sans-serif; font-size: 12px; font-weight: 700; line-height: 1.42;  color: #151515; text-transform:uppercase; border-top:1px solid #e0e0e0; border-bottom:1px solid #e0e0e0; text-align:right; width:70px;' valign='middle' >Total</th>\r\n";
			$out .= "</tr>\r\n";

			$counter = 1;
			foreach($this->PrOrderItem as $OrderItem)
			{

				if ($OrderItem->getProductName()=='Shipping') {
					$out .= "</table></td></tr>\r\n";
					$out .= "<tr><td style='vertical-align: top; ' valign='top'><table width='100%' cellpadding='2' cellspacing='2'>";
					$out .= "<tr>\r\n";
					$out .= "<td width='50%' style='width:50%;'></td><td width='25%' align='left' style='width:25%; vertical-align: middle; padding: 15px 15px 5px 0; font-family: Fira Sans, Helvetica, Arial, sans-serif; font-size: 12px; font-weight: 400; line-height: 1.42;  color: #151515; text-transform:uppercase;   text-align:left;' valign='middle'>" . $OrderItem->getProductName()."</td>\r\n";
					$out .= "<td width='25%' align='right' style='width:25%; vertical-align: middle; padding: 15px 15px 5px 0; font-family: Fira Sans, Helvetica, Arial, sans-serif; font-size: 12px; font-weight: 400; line-height: 1.42;  color: #151515; text-transform:uppercase;   text-align:right;' valign='middle'>". number_format($OrderItem->getAmount(),2,",", "") ." EUR</td>\r\n";
					$out .= "</tr>\r\n";
				}
				else {
					$out .= "<tr>\r\n";
					$out .= "<td align='left' style='vertical-align: middle; padding: 5px 15px 5px 0; font-family: Fira Sans, Helvetica, Arial, sans-serif; font-size: 12px; font-weight: 400; line-height: 1.42;  color: #151515; text-transform:uppercase;  border-bottom:1px solid #e0e0e0; text-align:left;' valign='middle'>" . $counter++ ."</td>\r\n";
					$out .= "<td align='left' style='vertical-align: middle; padding: 5px 15px 5px 0; font-family: Fira Sans, Helvetica, Arial, sans-serif; font-size: 12px; font-weight: 400; line-height: 1.42;  color: #151515; text-transform:uppercase;  border-bottom:1px solid #e0e0e0; text-align:left;' valign='middle'>" . $OrderItem->getProductCode()."</td>\r\n";
					$out .= "<td align='left' style='vertical-align: middle; padding: 5px 15px 5px 0; font-family: Fira Sans, Helvetica, Arial, sans-serif; font-size: 12px; font-weight: 400; line-height: 1.42;  color: #151515; text-transform:uppercase;  border-bottom:1px solid #e0e0e0; text-align:left;' valign='middle'>" . $OrderItem->getProductName()."</td>\r\n";
					$out .= "<td align='right'  style='vertical-align: middle; padding: 5px 15px 5px 0; font-family: Fira Sans, Helvetica, Arial, sans-serif; font-size: 12px; font-weight: 400; line-height: 1.42;  color: #151515; text-transform:uppercase;  border-bottom:1px solid #e0e0e0; text-align:right;' valign='middle'>" . number_format($OrderItem->getPrice(),2,",", ""). "</td>\r\n";
					$out .= "<td align='right'  style='vertical-align: middle; padding: 5px 15px 5px 0; font-family: Fira Sans, Helvetica, Arial, sans-serif; font-size: 12px; font-weight: 400; line-height: 1.42;  color: #151515; text-transform:uppercase;  border-bottom:1px solid #e0e0e0; text-align:right;' valign='middle'>" . number_format($OrderItem->getQuantity(),0,",", "") ."</td>\r\n";
					$out .= "<td align='right'  style='vertical-align: middle; padding: 5px 15px 5px 0; font-family: Fira Sans, Helvetica, Arial, sans-serif; font-size: 12px; font-weight: 400; line-height: 1.42;  color: #151515; text-transform:uppercase;  border-bottom:1px solid #e0e0e0; text-align:right;' valign='middle'>" . number_format($OrderItem->getAmount(),2,",", "") ." EUR</td>\r\n";
					$out .= "</tr>\r\n";
				}


				$orderitem_proiz_ukupna_cena += $OrderItem->getAmount();
			}

			$out .= "</table></td></tr>\r\n";
			$out .= "<tr><td style='vertical-align: top; ' valign='top'><table width='100%' cellpadding='2' cellspacing='2'>";
			$out .= "<tr>\r\n";
			$out .= "<td width='50%' style='width:50%;'></td><td width='25%' align='left' style='width:25%; vertical-align: middle; padding: 0px 15px 5px 0; font-family: Fira Sans, Helvetica, Arial, sans-serif; font-size: 12px; font-weight: 700; line-height: 1.42;  color: #151515; text-transform:uppercase;   text-align:left;' valign='middle'>Total: </td>\r\n";
			$out .= "<td width='25%' align='right' style='width:25%; vertical-align: middle; padding: 0px 15px 5px 0; font-family: Fira Sans, Helvetica, Arial, sans-serif; font-size: 12px; font-weight: 700; line-height: 1.42;  color: #151515; text-transform:uppercase;   text-align:right;' valign='middle'>". number_format($orderitem_proiz_ukupna_cena,2,",", "") ." EUR</td>\r\n";
			$out .= "</tr>\r\n";
		}

		$out .= "</table></td></tr>\r\n";
		return $out;
	}


}

	// kada se klasa izgenerise dodajte jos vrednosti u oba konstruktora!!!
	// proveriti da li je sve u redu sa get i set funkcijama!!!
	// klasa PrOrderItem cuva stavke narudzbenice

class PrOrderItem extends OpstiDomenskiObjekat
{
	public $OrderItemID;
	public $Quantity;
	public $Price;
	public $Amount;
	public $ProductCode;
	public $ProductName;
	public $PrOrder;
	public $PrProizvod;

	//Bussiness PHP Object constructor
	function __construct()
	{
		parent::__construct();

		$this->PrOrder = $this->ObjectFactory->createObject("PrOrder",-1);
		$this->PrProizvod = $this->ObjectFactory->createObject("PrProizvod",-1);

		$this->OrderItemID = 0;
		$this->PrOrder->OrderID = 0;
		$this->PrProizvod->ProizvodID = 0;
		$this->Quantity = 0;
		$this->Price = 0;
		$this->Amount = 0;
		$this->ProductCode = "";
		$this->ProductName = "";

		$this->TableName = "pr_orderitem";
		$this->LanguageHelper->ChangeTableName($this->TableName);
	}

	// fill PrOrder from POST
	function PrOrderItem_POST(&$post)
	{
		$this->PrOrder = $this->ObjectFactory->createObject("PrOrder",-1);
		$this->PrProizvod = $this->ObjectFactory->createObject("PrProizvod",-1);

		$this->OrderItemID= isset($post["orderitemid"]) ? $post["orderitemid"] : $this->OrderItemID;
		$this->PrOrder->OrderID= isset($post["order->orderid"]) ? $post["order->orderid"] : $this->PrOrder->OrderID;
		$this->PrProizvod->ProizvodID= isset($post["proizvod->proizvodid"]) ? $post["proizvod->proizvodid"] : $this->PrProizvod->ProizvodID;
		$this->Quantity= isset($post["quantity"]) ? $post["quantity"] : $this->Quantity;
		$this->Price= isset($post["price"]) ? $post["price"] : $this->Price;
		$this->Amount= isset($post["amount"]) ? $post["amount"] : $this->Amount;
		$this->ProductCode= isset($post["productcode"]) ? $post["productcode"] : $this->ProductCode;
		$this->ProductName = isset($post["productname"]) ? $post["productname"] : $this->ProductName;
	}

	// DatabaseBroker functions
	function vratiImenaAtributa() {return "`orderitemid`,`orderid`,`proizvodid`,`quantity`,`price`,`amount`,`product_code`,`product_name`";}
	function vratiImeKlase(){return $this->TableName;}
	function vratiVrednostiAtributa(){ return $this->quote_smart($this->OrderItemID).",".$this->quote_smart($this->PrOrder->OrderID).",".$this->quote_smart($this->PrProizvod->ProizvodID).",".$this->quote_smart($this->Quantity).",".$this->quote_smart($this->Price).",".$this->quote_smart($this->Amount).",".$this->quote_smart($this->ProductCode).",".$this->quote_smart($this->ProductName);}
	function postaviVrednostiAtributa(){ return "`orderid` = ".$this->quote_smart($this->PrOrder->OrderID).",`proizvodid` = ".$this->quote_smart($this->PrProizvod->ProizvodID).",`quantity` = ".$this->quote_smart($this->Quantity).",`price` = ".$this->quote_smart($this->Price).",`amount` = ".$this->quote_smart($this->Amount).",`product_code` = ".$this->quote_smart($this->ProductCode).",`product_name` = ".$this->quote_smart($this->ProductName);}
	function nazivVezeKaRoditelju(){ return "prorderitem";}
	function vratiUslovZaNadjiSlog(){ return "orderitemid=".$this->quote_smart($this->OrderItemID)." AND orderid=".$this->quote_smart($this->PrOrder->OrderID);}
	function vratiUslovZaSortiranje(){ return "orderid";}
	function vratiUslovZaNadjiSlogF(){ return "order=".$this->quote_smart($this->PrOrder->OrderID);}
	function vratiUslovZaNadjiSlogove(){ return "1=";}
	function postaviID($id){ $this->OrderItemID = $id;}
	function napuni($result_row){
		$this->OrderItemID = $result_row->orderitemid;
		$this->PrOrder->OrderID = $result_row->orderid;
		$this->PrProizvod->ProizvodID = $result_row->proizvodid;
		$this->Quantity = $result_row->quantity;
		$this->Price = $result_row->price;
		$this->Amount= $result_row->amount;
		$this->ProductCode = $result_row->product_code;
		$this->ProductName = $result_row->product_name;
	}
	function napuniNiz($result_set, &$al){
		if(count($result_set)>0)
			foreach($result_set as $result_row){
				$orditm = $this->ObjectFactory->createObject("PrOrderItem",-1);
				$orditm->OrderItemID = $result_row->orderitemid;
				$orditm->PrOrder->OrderID = $result_row->orderid;
				$orditm->PrProizvod->ProizvodID = $result_row->proizvodid;
				$orditm->Quantity = $result_row->quantity;
				$orditm->Price = $result_row->price;
				$orditm->Amount= $result_row->amount;
				$orditm->ProductCode = $result_row->product_code;
				$orditm->ProductName = $result_row->product_name;
				array_push($al, $orditm);
			}
	}
	function napuniVisePovezi($result_set, $relation_name){
		switch ($relation_name){
			case "prorder":
				if(count($result_set)>0) $this->PrOrder->napuni($result_set);
				break;
			case "prproizvod":
				if(count($result_set)>0) $this->PrProizvod->napuni($result_set);
				break;
			default: break;
		}
	}

	function toArray()
	{
		$arr = array();
			$arr = array_merge($arr, array("orderitemid" => $this->getOrderItemID()));
			$arr = array_merge($arr, array("orderid" => $this->getOrderID()));
			$arr = array_merge($arr, array("proizvodid" => $this->getProizvodID()));
			$arr = array_merge($arr, array("proizvod" => $this->getProizvod()));
			$arr = array_merge($arr, array("quantity" => $this->getQuantity()));
			$arr = array_merge($arr, array("price" => $this->getPrice()));
			$arr = array_merge($arr, array("amount" => $this->getAmount()));
			$arr = array_merge($arr, array("productcode" => $this->getProductCode()));
			$arr = array_merge($arr, array("productname" => $this->getProductName()));
		return $arr;
	}

	// get metode ispravi ako ima nesto!!!
	function getOrderItemID()
	{
		return $this->OrderItemID;
	}
	function getOrderID()
	{
		return $this->PrOrder->OrderID;
	}
	function getProizvodID()
	{
		return $this->PrProizvod->ProizvodID;
	}
	function getProizvod()
	{
		return $this->PrProizvod->toArray();
	}
	function getQuantity()
	{
		return $this->Quantity;
	}
	function getPrice()
	{
		return $this->Price;
	}
	function getAmount()
	{
		return $this->Amount;
	}
	function getProductCode()
	{
		return $this->ProductCode;
	}
	function getProductName()
	{
		return $this->ProductName;
	}

	function setOrderItemID($val)
	{
		$this->OrderItemID= $val;
	}
	function setOrderID($val)
	{
		$this->PrOrder->OrderID= $val;
	}
	function setProizvodID($val)
	{
		$this->PrProizvod->ProizvodID= $val;
	}
	function setQuantity($val)
	{
		$this->Quantity= $val;
	}
	function setPrice($val)
	{
		$this->Price= $val;
	}
	function setAmount($val)
	{
		$this->Amount= $val;
	}
	function setProductCode($val)
	{
		$this->ProductCode = $val;
	}
	function setProductName($val)
	{
		$this->ProductName = $val;
	}

	function getLinkID()
	{
		return 'orderitemid='.$this->OrderItemID;
	}
}
?>
