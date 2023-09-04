<?
	class baseManager
	{
		public $ObjectFactory;
		public $DatabaseBroker;

		public function __construct()
		{
			$this->ObjectFactory = ObjectFactory::getInstance();
			$this->DatabaseBroker = DatabaseBroker::getInstance();		
		}
	}
	
?>