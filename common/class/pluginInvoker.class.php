<?
	class pluginInvoker
	{
		private $FilterID;
		private $FileName;
		private $Module;
		private $Position;
		
		private $smarty;
		
		function __construct()
		{}
		
		function SetSmarty($smarty)
		{
			$this->smarty = $smarty;
		}
		
		function SetModule($module)
		{
			$this->Module = $module;
		}
		
		function InvokePluginDefault($module,$filename,$filterid,$position="")
		{
			$this->FileName = $filename;
			$this->FilterID = $filterid;
			$this->Module = $module;
			$this->Position = $position;
				
			$class_name = $filename."Plugin";
			$this->loadFileIfNeeded($class_name);
			 
			$plginvoker = new $class_name;
			$plginvoker->setSmarty($this->smarty);
			$plginvoker->setFilterID($this->FilterID);
			$plginvoker->setPosition($this->Position);
			return $plginvoker->showDefault();
		}
		
		function loadFileIfNeeded($class_name)
		{
			if(!class_exists($class_name))
			{
				$path = "plugins/plg_".$this->Module."/".$class_name.".php";
				include_once($path);
			}
		}
		
		function InvokePluginDetails($filename)
		{
			$class_name = $filename."Plugin";
			$this->loadFileIfNeeded($class_name);
			
			$plginvoker = new $class_name;
			$plginvoker->setSmarty($this->smarty);
			
			$plginvoker->showDetails();
		}
	}

?>