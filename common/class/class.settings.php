<?
	include_once("ezsql/ez_sql_core.php");
	//include_once("ezsql/mysql/ez_sql_mysql.php");
	include_once("ezsql/mysqli/ez_sql_mysqli.php"); //za php7.0
	//include_once("interfejsi.php");
	
	class CMSSettings 
	{
		private $ObjectFactory;
		private $Settings = array();
		private static $instance;
	    
		function __construct()
		{
			
			$this->ObjectFactory = ObjectFactory::getInstance();
			$this->ObjectFactory->Reset();
			$this->Settings = $this->ObjectFactory->createObjects("Setting");
			$this->ObjectFactory->Reset();
		}
		
	    public static function getInstance()
		{
			if(!isset(self::$instance))
			{
				$object= __CLASS__;
				self::$instance=new $object;
			}
			
			return self::$instance;
		}
		
		public function getSettingByName($name)
		{
			foreach ($this->Settings as $setting) 
			{
				if($setting->getName() == $name)
				{
					return $setting->getValue();
				}
			}
		}
		
		public function getSettingByID($name)
		{
			foreach ($this->Settings as $setting) 
			{
				if($setting->getSettingID() == $name)
				{
					return $setting->getValue();
				}
			}
		}
	}
?>