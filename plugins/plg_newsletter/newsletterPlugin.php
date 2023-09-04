<?
	include_once("plugins/pagePlugin.php");
	
	class newsletterPlugin extends pagePlugin 
	{
		private $Newsletter;
		
		function __construct()
		{
			parent::__construct();
		}
		
		function setFilterID($filterid)
		{
		}
		
		function showDefault()
		{
			$this->SetPluginLanguage("newsletter");
			
			$this->SmartyPluginBlock->setName("plg_newsletter_default");
			$this->SmartyPluginBlock->setPosition($this->Position);
			
			return $this->SmartyPluginBlock->toArray();
		}
		
		function showDetails()
		{
			$this->SetPluginLanguage("newsletter");
			
			if(isset($_REQUEST["plugin_view"]) && $_REQUEST["plugin_view"] == "add_newsletter")
			{
				$valid = true;
				$error_message = array();

				if(!isset($_REQUEST["name"]) || trim($_REQUEST["name"]) == $this->getTranslation("PLG_NEWSLETTER_NAME_MESSAGE"))
				{
					$error_message[] =  $this->getTranslation("PLG_NEWSLETTER_ERROR_NAME_REQUIRED");
				}
				else 
				{
					$this->smarty->assign("NAME_VALUE", $_REQUEST["name"]);
				}
				
//				if(!isset($_REQUEST["surname"]) || trim($_REQUEST["surname"]) == $this->getTranslation("PLG_NEWSLETTER_SURNAME_MESSAGE"))
//				{
//					$error_message[] = $this->getTranslation("PLG_NEWSLETTER_ERROR_SURNAME_REQUIRED");
//				}
//				else 
//				{
//					$this->smarty->assign("SURNAME_VALUE", $_REQUEST["surname"]);
//				}
				 
				if(!isset($_REQUEST["email"])|| trim($_REQUEST["email"]) == $this->getTranslation("PLG_NEWSLETTER_EMAIL_MESSAGE"))
				{
					$error_message[] = $this->getTranslation("PLG_NEWSLETTER_ERROR_EMAIL_REQUIRED");
				}
				else
				{
					$this->smarty->assign("EMAIL_VALUE", $_REQUEST["email"]);
				}
				
				if(isset($_REQUEST["name"])  && isset($_REQUEST["email"]))
				{
					if(!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $_REQUEST["email"]))
					{
						$error_message[] = $this->getTranslation("PLG_NEWSLETTER_ERROR_EMAIL_BADFORMAT");
						$valid = false;
					}
					
					if($valid)
					{
						$this->ObjectFactory->AddFilter("email=".$this->quote_smart($_REQUEST["email"]));
						$users = $this->ObjectFactory->createObjects("User");
						$this->ObjectFactory->ResetFilters();
						if(count($users)>0)
						{
							$error_message[] = $this->getTranslation("PLG_NEWSLETTER_ERROR_EMAIL_EXISTS");
							$valid = false;
						}
					}
				}
				else 
				{
					$valid = false;
				}
				
				if($valid)
				{
					// upis korisnika u bazu podataka
					$user = $this->ObjectFactory->createObject("User",-1);
					$user->Name = $_REQUEST["name"];
//					$user->Surname = $_REQUEST["surname"];
					$user->Email = $_REQUEST["email"];
					$user->UserName = $_REQUEST["email"];
					$user->SfStatus->setStatusID(STATUS_USER_AKTIVAN);
					//$user->SfUserType->setUserTypeID(USER_TYPE_MAILINGLIST_ENTITY);
					$user->SfUserCategory->setUserCategoryID(USER_CATEGORY_MAILINGLIST);
			
					$this->ObjectFactory->DBBR->kreirajSlog($user);
					
					$useruserrole = $this->ObjectFactory->createObject("UserUserRole",-1);
					$useruserrole->UserID = $user->UserID;
					$useruserrole->UserRoleID = 9; // ZAKUCALI za MAILING LISTU
					$this->ObjectFactory->DBBR->kreirajSlog($useruserrole);
					
					$this->ObjectFactory->ResetFilters();				
					$this->ObjectFactory->AddFilter("adminpagename= 'newsletter_signsuccess'");
					/*$this->smarty->assign("NAME_VALUE","");
//					$this->smarty->assign("SURNAME_VALUE","");
					$this->smarty->assign("EMAIL_VALUE","");
					
					$this->smarty->assign("plugin_view","newsletter_sign_success");*/
				}
				else
				{
					$this->ObjectFactory->ResetFilters();					
					$this->ObjectFactory->AddFilter("adminpagename= 'newsletter_signfail'");

					//$this->smarty->assign("error_message",$error_message);
					//$this->smarty->assign("plugin_view","newsletter_sign_fail");
				}
				$adminpages = $this->ObjectFactory->createObjects("AdminPage");
				$this->ObjectFactory->ResetFilters();
				$adminpage = $adminpages[0];
				$linkAdminPage = new LinkAdminPage($this->LanguageHelper, $adminpage->getAdminPageID(), $adminpage->getAdminPageName(), $adminpage->getHeader());
				$linkAdminPagePrint = $this->LanguageHelper->getPrintLink($linkAdminPage);
				header('Location: '. $linkAdminPagePrint);
				exit ();
			}
			
			// details mode
			$this->smarty->assign("plg_newsletter_details", "true");
		}
	}
?>