<?
	include_once("plugins/pagePlugin.php");
	include_once("common/class/validation.class.php");
	
	class loginanketaPlugin extends pagePlugin 
	{
		private $SmartyData = array();
		
		function setFilterID(){}
		
		function showDefault()
		{
			$this->processRegistrationDetails();
			$this->smarty->assign("plg_login_css", "true");
			
			$this->SmartyPluginBlock->setData($this->SmartyData);
			$this->SmartyPluginBlock->setPosition($this->Position);
			$this->SmartyPluginBlock->setName("plg_loginanketa_default");
			
			return $this->SmartyPluginBlock->toArray();
		}
		
		function showDetails()
		{
			// details for new user registration
			if(isset($_REQUEST["plugin_view"]) && $_REQUEST["plugin_view"] == "registration")
			{
				$this->processRegistrationDetails();
			}
			
			// details mode
			$this->smarty->assign("plg_login_details", "true");
			$this->smarty->assign("plg_login_css", "true");
		}
		
		function processRegistrationDetails()
		{
			// registration mode
			$this->SetPluginLanguage("login");
			
			$this->smarty->assign("backUrl", $_SERVER['QUERY_STRING']);
	
			$validation = new Validation();

			$rules['name']			= "trim|required";
			$rules['surname']		= "trim|required";
			$rules['firm']			= "trim|required";	
			$rules['phone']			= "trim|required";
			$rules['email']			= "trim|required|valid_email";
	
			$validation->set_rules($rules);
	
			$fields['name']			= 'Ime';
			$fields['surname']		= 'Prezime';
			$fields['firm']			= 'Predškolska ustanova';
			$fields['phone']		= 'Telefon';
			$fields['email']		= 'Email adresa';
			
			$validation->set_fields($fields);
			
			$is_Valid = true;
			
			if($validation->run() == FALSE) $is_Valid = false;

			//echo "---1 ".$is_Valid;
			
			if($this->usernameExists($validation->username)) $is_Valid = false;
			
			//echo "---2 ".$is_Valid;
			
			if($validation->password != $validation->passwordrep) $is_Valid = false;
			
			//echo "---3 ".$is_Valid;
			
			if(!$is_Valid)
			{
				foreach ($fields as $field => $value)
				{
					if($validation->$field != "")
					{
						$this->smarty->assign($field, $validation->$field);
					}
						
					$error_field = $field.'_error';
					$error_message_field = $field.'_error_message';
					
					if($validation->$error_field != "")
					{
						$this->smarty->assign($error_field , "error");
						$this->smarty->assign($error_message_field, "true");
					}
				}
				
				if($validation->password != $validation->passwordrep)
				{
					$this->smarty->assign("password_error" , "error");
					$this->smarty->assign("password_error_message_dup", "true");
				}
				
				if($this->usernameExists($validation->username))
				{
					$this->smarty->assign("username_error" , "error");
					$this->smarty->assign("username_error_message_dup", "true");
				}
			}
			else
			{
				$user = $this->ObjectFactory->createObject("User",-1);
				
				$user->Name					= $validation->name;
				$user->Surname				= $validation->surname;
				$user->Firm					= $validation->firm;
				$user->Phone				= $validation->phone;
				$user->Email				= $validation->email;
				
		        $user->Language = $this->LanguageHelper->CurrentLanguage();
				$user->SfStatus->setStatusID(STATUS_USER_AKTIVAN);
				$user->SfUserCategory->setUserCategoryID(USER_CATEGORY_ANKETA);
				
		        $DBBR = DatabaseBroker::getInstance();
		        //$DBBR->SetDebugOn();
				$DBBR->kreirajSlog($user);
				
				$useruserrole = $this->ObjectFactory->createObject("UserUserRole",-1);
				$useruserrole->UserID = $user->UserID;
				$useruserrole->UserRoleID = 17;
				
				$DBBR->kreirajSlog($useruserrole);
				
				$phpmail = new PHPMailer();
				
				switch($this->CMSSetting->getSettingByID(REGISTERMAIL_SENDER_TYPE))
				{
					case SENDER_TYPE_SMTP:
						$phpmail->IsSMTP();
						$phpmail->Host = $this->CMSSetting->getSettingByID(REGISTERMAIL_HOST_NAME);
						break;
					case SENDER_TYPE_MAIL:
						$phpmail->IsMail();
						break;
					default:
						break;
				}
				
				$phpmail->From = $this->CMSSetting->getSettingByID(REGISTERMAIL_MAIL_EMAIL);
				$phpmail->FromName = $this->CMSSetting->getSettingByID(REGISTERMAIL_MAIL_NAME);
				$phpmail->IsHTML(true);
					
				$phpmail->AddAddress($this->CMSSetting->getSettingByID(REGISTERMAIL_MAIL),$this->CMSSetting->getSettingByID(REGISTERMAIL_MAIL));
				$phpmail->Subject = $this->CMSSetting->getSettingByID(REGISTERMAIL_MAIL_SUBJECT);
		
				$message  =  "Prijavio se novi posetilac za anketu ". $user->Name . " " .$user->Surname . " , proverite u administraciji njegov status." . "\n";
				$message .=  "Predskolska ustanova posetioca: " . $user->Firm . "\n";
				$message .=  "Email posetioca: " . $user->Email . "\n";
				$message .=  "Telefon posetioca: " . $user->Phone . "\n";
		   		
				$phpmail->Body = $message;
				$phpmail->Send();
				
				unset($phpmail);
				
				// automatski logujem korisnika i saljem ga na stranicu za anketu
				
				$_SESSION["loged"] = "Yes";
				$_SESSION["logeduserid"] = $user->UserID;
				
				header("Location: ../../index.php?page_id=378");
			}			
		}
		
		function usernameExists($str)
		{
			if($str == "") return FALSE;
			$this->ObjectFactory->ResetFilters();
			$users = $this->ObjectFactory->createObjects("User");
			if(count($users) > 0)
			{
				foreach($users as $u)
				{
					if($str == $u->UserName) 
					{
						return TRUE;
					}
				}
			}
			return FALSE;
		}
}
?>