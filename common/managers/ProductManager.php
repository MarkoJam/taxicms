<? 
	include_once("baseManager.php");
	
	class ProductManager extends baseManager
	{
		public function __construct()
		{
			parent::__construct();			
		}
		
		/**
		 * Returns new empty PrGrupaProizvoda object
		 *
		 * @return PrGrupaProizvoda
		 */
		public function NewPrGrupaProizvoda()
		{
			return $this->ObjectFactory->createObject("PrGrupaProizvoda",-1);
		}
		
		/**
		 * Returns new empty PrProizvodGrupaProiz object
		 *
		 * @return PrProizvodGrupaProiz
		 */
		public function NewPrProizvodGrupaProiz()
		{
			return $this->ObjectFactory->createObject("PrProizvodGrupaProiz",-1);
		}
		
		public function DeleteProizvod($filter)
		{
			try
			{
				// throw Exception if accountid is not supplied
				if(!$filter->FilterHasKey("proizvodid"))
				{
					throw new Exception("proizvodid was not supplied.");
				}
				
				$this->ObjectFactory->Reset();
				
				$proizvod = $this->ObjectFactory->createObject("PrProizvod", $filter->GetFilterValueByKey("proizvodid"));
			
				$arrProizKategorija = array();
				$proizKategorija = $this->ObjectFactory->createObject("PrProizvodKategorija",-1);
				$this->DatabaseBroker->vratiSveSlogove($proizKategorija, $arrProizKategorija ,"*"," AND ".$proizvod->getLinkID());
				
				foreach ($arrProizKategorija as $proizKateg) 
				{
					$this->DatabaseBroker->obrisiSlog($proizKateg);
				}
			
				$arrProizGrupaProizvoda = array();
				$proizGrupaProizvoda =  $this->ObjectFactory->createObject("PrProizvodGrupaProiz",-1);
				$this->DatabaseBroker->vratiSveSlogove($proizGrupaProizvoda, $arrProizGrupaProizvoda, "*", " AND ".$proizvod->getLinkID());
			
				foreach ($arrProizGrupaProizvoda as $proizGrupaProiz) 
				{
					$this->DatabaseBroker->obrisiSlog($proizGrupaProiz);
				}
			
				$this->DatabaseBroker->obrisiSlog($proizvod);

				return true;
			}
			catch (Exception $ex)
			{
				//log_message('error', "ProductManager: GetAllPrGrupaProizvoda() failed during delete. " .$ex->getMessage());
				return false;
			}
		}	
		
		public function GetAllPrGrupaProizvoda($filter)
		{
			//log_message('error', "ProductManager: GetAllPrGrupaProizvoda() function is called");
			
			try
			{
				$this->ObjectFactory->Reset();
				$grupeProizvoda = $this->ObjectFactory->createObjects("PrGrupaProizvoda");
				$this->ObjectFactory->Reset();
			
				return $grupeProizvoda;
			}
			catch (Exception $ex)
			{
				//log_message('error', "ProductManager: GetAllPrGrupaProizvoda() failed during delete. " .$ex->getMessage());
				return false;
			}
		}
		
		
		/**
		 * Deletes PrGrupaProizvoda
		 * 
		 * Delete row from database for given filter object
		 * 
		 * @access public
		 * @param CommonFilter $filter
		 * @return bool
		 */
		public function DeletePrGrupaProizvoda($filter)
		{
			//log_message('error', "ProductManager: PrGrupaProizvoda() function is called");
			
			try
			{
				// throw Exception if accountid is not supplied
				if(!$filter->FilterHasKey("grupaproizvodaid"))
				{
					throw new Exception("grupaproizvodaid was not supplied.");
				}
				
				//TO DO: Modify this part of code to work as Database Transaction
				$grupaproizvoda = $this->NewPrGrupaProizvoda();
				$this->DatabaseBroker->obrisiSlogove($grupaproizvoda, "grupaproizvodaid IN (". $filter->GetFilterValueByKey("grupaproizvodaid") .")");
				
				// Obrisati sve vezne redove izmedju proizvoda i grupeproizvoda
				$proizvodGrupaProiz = $this->NewPrProizvodGrupaProiz();
				$this->DatabaseBroker->obrisiSlogove($proizvodGrupaProiz, "grupaproizvodaid IN (". $filter->GetFilterValueByKey("grupaproizvodaid") .")");
							
				return true;
			}
			catch (Exception $ex)
			{
				//log_message('error', "ProductManager: PrGrupaProizvoda() failed during delete. " .$ex->getMessage());
				return false;
			}
		}
	}		
?>