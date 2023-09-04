<? 
	include_once("plugins/plg_products/productsPlugin.php");
	include_once("common/class/class.KpGrupaProizvodaTree.php");

	class orderPlugin extends productsPlugin 
	{
		private $kpGrupaProizvodaTree;
		private $grupaProizvodaId;
	
		function __construct()
		{
			parent::__construct ();
			$this->kpGrupaProizvodaTree = new KpGrupaProizvodaTree ();
			$this->kpGrupaProizvodaTree->setPageId ( $this->getPageID () );
			$this->kpGrupaProizvodaTree->setLanguageHelper ( $this->LanguageHelper );
		}

		function setFilterID(){}

		function showDefault()
		{
			$this->SetPluginLanguage("order");
			$this->smarty->assign("plg_order_default","true");	
		}
		
		function showDetails()
		{
			$this->smarty->assign("orderfinish",false);
			$lang = $this->LanguageHelper->GetLinkPluginType("language");			
			if((isset($_SESSION[$lang]["korpa"]) || count($_SESSION[$lang]["korpa"])!= 0)
			 && isset($_POST['order_finish'])) 
			{
				//kreiranje nove narudzbenice
				$order = $this->ObjectFactory->createObject("PrOrder",-1);
				$order->PrOrder_POST($_POST);
				$order->SfStatus->setStatusID(STATUS_ORDER_NEOBRADJENO);
				if (empty($order->getShipAddress())) $order->setShipAddress($order->getAddress());
				if (empty($order->getShipPostalCode())) $order->setShipPostalCode($order->getPostalCode());
				if (empty($order->getShipCity())) $order->setShipCity($order->getCity());
				if (empty($order->getShipCountry())) $order->setShipCountry($order->getCountry());
				$OrderID=$this->DatabaseBroker->kreirajSlog($order);
				$order->PrOrderItem = array();
				$orderitems = array();
				//kreiranje stavki narudzbenice
				foreach ($_SESSION[$lang]["korpa"] as $proizid => $kol)
				{
					$kurs = $this->ObjectFactory->createObject("PrKurs",1);
					$proizvod = $this->ObjectFactory->createObject("PrProizvod", $proizid);
					$proizvod->setKurs ( $kurs->Kurs );
					
					$orderitem = $this->ObjectFactory->createObject("PrOrderItem",-1);
					$orderitem->PrOrder->setOrderID($OrderID);
					$orderitem->PrProizvod->setProizvodID($proizid);
					$orderitem->ProductCode = $proizvod->getSifra();
					$orderitem->Price = $proizvod->getCenaA();
					$orderitem->ProductName = $proizvod->getNaziv();
					$orderitem->Quantity = $kol;
					$orderitem->Amount = $orderitem->Quantity * $orderitem->Price;
					$ukupna_cena += $orderitem->Amount;	
					$DBBR = DatabaseBroker::getInstance();
					$this->DatabaseBroker->kreirajSlog($orderitem);

					// ubaci u order iteme
					$orderitem->PrProizvod = $this->ObjectFactory->createObject("PrProizvod",$proizid);
					$order->PrOrderItem[] = $orderitem;
					$orderitems[] = $orderitem->toArray();
				}
				//dodavanje ukupne cene u narudzbenice
				$orderitem = $this->ObjectFactory->createObject("PrOrderItem",-1);
				$order->Amount=$ukupna_cena;
				$this->DatabaseBroker->promeniSlog($order);	
											
				$this->smarty->assign($order->toArray());
				$this->smarty->assign("orderitems",$orderitems);
				$this->smarty->assign("orderfinish",true);
				
				require('mail.php');	
				unset($_SESSION[$lang]["korpa"]);
			}
		}
	}
?>