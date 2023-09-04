<?php 
	
	include_once("plugins/pagePlugin.php");
	include_once("common/class/validation.class.php");
	
	class commentdetailsPlugin extends PagePlugin
	{
		function __construct()
		{
			parent::__construct();
			
			$this->ObjectFactory->ResetFilters();
		}
				
		function showDefault()
		{
			//$this->SetPluginLanguage("event");
			
			$selected_comments = array();
			
			$this->ObjectFactory->AddFilter("is_approved=1");
			$comments = $this->ObjectFactory->createObjects("Comment");
			$this->ObjectFactory->ResetFilters();
			
			$comments_smarty = array();
			
			foreach($comments as $comment)
			{
				$comments_smarty[] = $comment->toArray();
			}
			
			$this->smarty->assign("plg_commentdetails_default","true");
			$this->smarty->assign("approvedComments",$comments_smarty);
		}	
		
	}
?>