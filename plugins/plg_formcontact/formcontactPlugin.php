<?
	include_once("plugins/pagePlugin.php");

	class formcontactPlugin extends pagePlugin
	{
		function __construct()
		{
			parent::__construct();
			$this->ObjectFactory->ResetFilters();
		}

		function showDefault()
		{
			$this->SetPluginLanguage("comment");
			if (CAPTCHA_KEY_3 != '') $this->smarty->assign("dkey3",CAPTCHA_KEY_3);
			$smartyData = array();
			$this->SmartyPluginBlock->setData($smartyData);
			$this->SmartyPluginBlock->setPosition($this->Position);
			$this->SmartyPluginBlock->setName("plg_formcontact_default");
			return $this->SmartyPluginBlock->toArray();
			//$this->smarty->assign("plg_formcontact_default","true");
		}

		function showDetails()
		{}

	}

?>
