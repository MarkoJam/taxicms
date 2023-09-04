<?
	include_once("plugins/pagePlugin.php");
	include_once(ROOT_HOME."common/class/validation.class.php");
	
	class loginPlugin extends pagePlugin 
	{
		private $SmartyData = array();	
		
		function setFilterID(){}
		
		function showDefault()
		{
			global $lh;
			$this->smarty->assign('lang2',$lh->GetLinkPluginLanguage());
			$this->SetPluginLanguage("login");

			if(isset($_REQUEST["message"]) && $_REQUEST["message"]=="error") $this->SmartyData["message"] = "Login error";
			
			if(isset($_SESSION["loged"])) {	
				if($_SESSION['loged'] == "Yes") { 
					$userlogged = "Yes";
					$user = $this->ObjectFactory->createObject("User",$_SESSION["logeduserid"]);
					$uid=$user->SfCountries->getCountryID();				
					$this->SmartyData["user_name"] = $user->Name; 
					$this->SmartyData["user_namesurname"] = $user->Name. " ". $user->Surname; 
					$this->SmartyData["user_country"] = $user->SfCountries->getCountryName();					
					$this->SmartyData["expiry_date"] = date("d-m-Y",$user->ExpiryDate);
					$this->SmartyData["user_loged"] = "true";				
				}
			}
			else $uid=-1;
			global $smarty;
			// countries
			$countries = $this->ObjectFactory->createObjects("SfCountries");
			$shCountry = new SmartyHtmlSelection("country",$smarty);
				$shCountry ->AddOutput('Choose country');
				$shCountry ->AddValue(-1);			
			foreach ($countries as $c) 
			{
				$shCountry ->AddOutput($c->getCountryName());
				$shCountry ->AddValue($c->getCountryID());
			}
			$shCountry->AddSelected($uid);
			$shCountry->SmartyAssign();
			$this->ObjectFactory->ResetFilters();	
			
			$this->smarty->assign("plg_login_css", "true");

			// link za editovanje korpe
			$registrationLink= new LinkRegistration($this->LanguageHelper,$this->getPageID(), TEMPLATE_REGISTRATION, 0 );
			$registration_link = $this->LanguageHelper->GetPrintLink($registrationLink);	
			$this->SmartyData["registration_link"] = $registration_link;

			$registrationLink= new LinkRegistration($this->LanguageHelper,$this->getPageID(), TEMPLATE_REGISTRATION, 1 );
			$forgot_pass_link = $this->LanguageHelper->GetPrintLink($registrationLink);	
			$this->SmartyData["forgot_pass_link"] = $forgot_pass_link;
			
			$registrationLink= new LinkRegistration($this->LanguageHelper,$this->getPageID(), TEMPLATE_REGISTRATION, 2 );
			$edit_link = $this->LanguageHelper->GetPrintLink($registrationLink);	
			$this->SmartyData["edit_link"] = $edit_link;
			$this->smarty->assign('userid',$_SESSION["logeduserid"]);
						
			$registrationLink= new LinkRegistration($this->LanguageHelper,$this->getPageID(), TEMPLATE_REGISTRATION, 4 );
			$userinfo_link = $this->LanguageHelper->GetPrintLink($registrationLink);	
			$this->SmartyData["userinfo_link"] = $userinfo_link;	
			
			$registrationLink= new LinkRegistration($this->LanguageHelper,$this->getPageID(), TEMPLATE_REGISTRATION, 6 );
			$checkout_link = $this->LanguageHelper->GetPrintLink($registrationLink);	
			$this->SmartyData["checkout_link"] = $checkout_link;	
			
			$linkShipment = new LinkShipment($this->LanguageHelper, TEMPLATE_SHOPPING_CART );
			$shipment_link = $this->LanguageHelper->GetPrintLink($linkShipment);
			$this->SmartyData["shipment_link"] = $shipment_link;	
			
			
			$this->SmartyPluginBlock->setData($this->SmartyData);
			$this->SmartyPluginBlock->setPosition($this->Position);
			$this->SmartyPluginBlock->setName("plg_login_default");
			return $this->SmartyPluginBlock->toArray();
		}
		
		function showDetails()
		{	
			if ($_SESSION["logeduserid"] && $_REQUEST["mod"]>1) {
				$userlog=$_SESSION["logeduserid"];
				$user = $this->ObjectFactory->createObject("User",$userlog);
				$this->smarty->assign($user->toArray());
			}	
			else $userlog=0; 
			if ($_REQUEST["mod"]==3)
			{		
				unset($_SESSION["logeduserid"]);
				unset($_SESSION["loged"]);
			}	
			$this->smarty->assign("mod", $_REQUEST["mod"]);
			switch ($_REQUEST["mod"]){
				case 0: 
				case 2: 
				case 3:
				case 6:
					$this->processRegistrationDetails($userlog);
					break;
				case 1: 
					$this->processForgotPassword();
					break;			
				case 4: 
				case 5:
					$this->processViewUserInfoDetails();
				break;		}	
					
			// details mode
			$this->smarty->assign("plg_login_details", "true");
			$this->smarty->assign("plg_login_css", "true");
		}

		function processForgotPassword()
		{
			if(isset($_POST['email']))
			{
				$this->ObjectFactory->Reset();
				$this->ObjectFactory->AddFilter("email='".$_POST['email']."'");
				$users = $this->ObjectFactory->createObjects("User");
				$this->ObjectFactory->Reset();
				foreach ($users as $user)
				{
					$id=$user->getUserID();
					$name=$user->getName();
					$surname=$user->getSurname();
				}

				if(isset($id))
				{
					$encrypt = md5(90*13+$id);
					$message = "Link to reset your account was sent to your e-mail address";
					$to=$_POST['email'];
					$subject="Reim store - forgoteen password";
					$from = $this->CMSSetting->getSettingByID(USERACTIVATION_MAIL_EMAIL);

						$this->smarty->assign('encrypt',$encrypt);
						$this->smarty->assign('name',$name);
						$this->smarty->assign('surname',$surname);
						ob_start();
						$this->smarty->display("login_mail_header.tpl");
						$this->smarty->display("login_mail_forgotten.tpl");
						$this->smarty->display("login_mail_footer.tpl");
						$body = ob_get_contents();
						ob_end_clean();

			
					$headers = "From: " . strip_tags($from) . "\r\n";
					$headers .= "Reply-To: ". strip_tags($from) . "\r\n";
					$headers .= "MIME-Version: 1.0\r\n";
					$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
				
              
					$whitelist = array('127.0.0.1', "::1");
					if(in_array($_SERVER['REMOTE_ADDR'], $whitelist))
					{
						echo "Pregled e-mail-a za zaboravljenu lozinku<BR>";
						echo "HEADER: ".$headers."<BR>";
						echo "SUBJECT: ".$subject."<BR>";
						echo "TO: ".$to."<BR><BR>";
						echo "Content: ".$body;
					}
					else	
					{	
						mail($to,$subject,$body,$headers);
						$this->AdminMessage($_REQUEST["mod"]);
					}   
					//$this->AdminMessage($_REQUEST["mod"]);	
				}
			}	
		}		
		function processRegistrationDetails($userlog)
		{
			// registration mode
			$this->SetPluginLanguage("login");
			$this->smarty->assign("backUrl", $_SERVER['QUERY_STRING']);
	
			$validation = new Validation();

			if ($_REQUEST["mod"]==0 || $_REQUEST["mod"]==2) {
				$rules['name']			= "trim|required";
				$rules['surname']		= "trim|required";
			//	$rules['firm']			= "trim|required";	
				$rules['place']			= "trim|required";
				$rules['address']		= "trim|required";
				$rules['postalcode']	= "trim|required";
				$rules['phone']			= "trim|required";
				$rules['region']		= "trim|required";
				$rules['countryid']		= "";
				$rules['email']			= "trim|required|valid_email";
			}
			
			if ($_REQUEST["mod"]==0 || $_REQUEST["mod"]==2 || $_REQUEST["mod"]==6)	{
				$rules['username']	= "trim|required";
				$rules['email']			= "trim|required|valid_email";				
			}	
			if ($_REQUEST["mod"]!=6) $rules['password']		= "trim|required";
			
			$validation->set_rules($rules);

			if ($_REQUEST["mod"]==0 || $_REQUEST["mod"]==2) {	
				$fields['name']			= 'Name';
				$fields['surname']		= 'Surname';
				$fields['firm']			= 'Company'; 			
				$fields['place']		= 'City';
				$fields['region']		= 'State';
				$fields['address']		= 'Address';
				$fields['postalcode']	= 'Zip code';
				$fields['phone']		= 'Phone';
				$fields['matbr']		= 'Suite';
				$fields['countryid']		= 0;
			}	
			if ($_REQUEST["mod"]==0 || $_REQUEST["mod"]==2 || $_REQUEST["mod"]==6) {
				$fields['username'] = 'Username'; 		
				$fields['email']		= 'E-mail address';				
			}	
			if ($_REQUEST["mod"]!=6) $fields['password']= 'Password';
			
			$validation->set_fields($fields);
			
			$is_Valid = true;
			
			if($validation->run() == FALSE) {
				$is_Valid = false;  
			}
			if ($_REQUEST["countryid"]==-1) $is_Valid = false;
			//echo "---1 ".$is_Valid;
			if($this->usernameExists($validation->username ) && ($_REQUEST["mod"]==0 || $_REQUEST["mod"]==6)) $is_Valid = false;
			
			//echo "---2 ".$is_Valid;
			
			if(!$is_Valid) {

				if ($_REQUEST["countryid"]==-1) $this->smarty->assign('countryid_error_message', true);	 				
				foreach ($fields as $field => $value)
				{
					if($validation->$field != "") $this->smarty->assign($field, $validation->$field);	
					$error_field = $field.'_error';
					$error_message_field = $field.'_error_message';
					
					if($validation->$error_field != "") {
						$this->smarty->assign($error_field , "error");
						$this->smarty->assign($error_message_field, "true");
					}
				}

				if ($_REQUEST["countryid"]==-1) {
					$this->smarty->assign("countryid_error" , "error");
					$this->smarty->assign("countryid_error_message_dup", "true");
				}
				
				
				if($this->usernameExists($validation->username ) && ($_REQUEST["mod"]==0)) {
					$this->smarty->assign("username_error" , "error");
					$this->smarty->assign("username_error_message_dup", "true");
				}
			}
			else {

				if ($_REQUEST["mod"]==0 || $_REQUEST["mod"]==6) $user = $this->ObjectFactory->createObject("User",-1);
				if ($_REQUEST["mod"]==2) $user = $this->ObjectFactory->createObject("User",$userlog); 
				if ($_REQUEST["mod"]==3) $user = $this->ObjectFactory->createObject("User",$_REQUEST["userid"]); 
				
				if ($_REQUEST["mod"]==0 || $_REQUEST["mod"]==2) {
					$user->Name					= $validation->name;
					$user->Surname				= $validation->surname;
					$user->Address				= $validation->address;
					$user->Postalcode			= $validation->postalcode;
					$user->Firm					= $validation->firm;
					$user->Place				= $validation->place;
					$user->Phone				= $validation->phone;
					$user->Email				= $validation->email;
					$user->MatBr				= $_REQUEST['matbr'];
					$user->Region				= $_REQUEST['region'];
					$user->SfCountries->setCountryID($validation->countryid);					
					$user->SfStatus->setStatusID(STATUS_USER_NEAKTIVAN);					
					$user->SfUserCategory->setUserCategoryID(USER_CATEGORY_USERS);
				}		
				if ($_REQUEST["mod"]==0 || $_REQUEST["mod"]==2 || $_REQUEST["mod"]==6) {	
					$user->Email				= $validation->email;
					$user->UserName				= $validation->username;
					$user->Language = $this->LanguageHelper->CurrentLanguage();
					$user->ExpiryDate			= 1861916400;
				}
				if ($_REQUEST["mod"]==6) {
					$user->Name					= $validation->username;
					$user->SfStatus->setStatusID(STATUS_USER_AKTIVAN);					
					$user->SfUserCategory->setUserCategoryID(USER_CATEGORY_WEBUSERS);						
				}	
				$user->Password	= md5($validation->password);
		        $DBBR = DatabaseBroker::getInstance();
				
				if ($_REQUEST["mod"]==2 || $_REQUEST["mod"]==3) {
					$user->SfStatus->setStatusID(STATUS_USER_AKTIVAN);
					$DBBR->promeniSlog($user);
				}
				if ($_REQUEST["mod"]==6) {
					$DBBR->kreirajSlog($user);	
					$_SESSION["loged"] = "Yes";
					$lastid=$DBBR->vratiPoslednjiID($user);
					$_SESSION["logeduserid"] = $lastid[1];
				}	
				if ($_REQUEST["mod"]==0) {
					if($this->CMSSetting->getSettingByID(REGISTERMAIL_MAIL_ACTIVATION) == SETTING_TYPE_ON) $user->ActivationHash = $this->CreateGUID();
					 
					$DBBR->kreirajSlog($user);	
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
			
					$message =  "New user  ". $user->Name . " " .$user->Surname . " , register on Reim store.";
					
					$phpmail->Body = $message;
					$phpmail->Send();
					
					unset($phpmail);

					// ako je podeseno da se sam korisnik kroz link iz maila aktivira
					if(	$this->CMSSetting->getSettingByID(REGISTERMAIL_MAIL_ACTIVATION) == SETTING_TYPE_ON )
					{
						// slanje maila korisniku sa aktivacionim linkom
						$phpmail = new PHPMailer();

						switch($this->CMSSetting->getSettingByID(USERACTIVATION_SENDER_TYPE))
						{
							case SENDER_TYPE_SMTP:
								$phpmail->IsSMTP();
								$phpmail->Host = $this->CMSSetting->getSettingByID(USERACTIVATION_HOST_NAME);
								break;
							case SENDER_TYPE_MAIL:
								$phpmail->IsMail();
								break;
							default:
								break;
						}

						$phpmail->From = $this->CMSSetting->getSettingByID(USERACTIVATION_MAIL_EMAIL);
						$phpmail->FromName = $this->CMSSetting->getSettingByID(USERACTIVATION_MAIL_NAME);
						$phpmail->IsHTML(true);

						$phpmail->AddAddress($user->getEmail());
						$phpmail->Subject = "Activate your account";

						$this->smarty->assign('activation_hash',$user->ActivationHash);
						ob_start();
						$this->smarty->display("login_mail_header.tpl");
						$this->smarty->display("login_mail.tpl");
						$this->smarty->display("login_mail_footer.tpl");
						$message = ob_get_contents();
						ob_end_clean();
						
						
						$phpmail->Body = $message;
						$phpmail->Send();
						
						unset($phpmail);	
					}	
				}
				if ($_REQUEST["mod"]==3) {		
					unset($_SESSION["logeduserid"]);
					unset($_SESSION["loged"]);
				}	
				$this->AdminMessage($_REQUEST["mod"]);
			}			
		}
		function AdminMessage($mod)
    	{		
			$this->ObjectFactory->ResetFilters();
			// razlicito u odnosu na mod, promeniti filter
			if ($_REQUEST["mod"]==6) $this->ObjectFactory->AddFilter("adminpagename='log_success'");
			else $this->ObjectFactory->AddFilter("adminpagename='mod".$mod."'");
			$adminpages = $this->ObjectFactory->createObjects("AdminPage");
			$this->ObjectFactory->ResetFilters();
			$adminpage = $adminpages[0];
			$linkAdminPage = new LinkAdminPage($this->LanguageHelper, $adminpage->getAdminPageID(), $adminpage->getAdminPageName(), $adminpage->getHeader());
			$linkAdminPagePrint = $this->LanguageHelper->getPrintLink($linkAdminPage);
			header('Location: '. $linkAdminPagePrint);
			exit ();
		}
		function CreateGUID()
    	{
	    	//Append the IP address w/o periods to the front of the unique ID
    		$varGUID = str_replace('.', '', uniqid($_SERVER['REMOTE_ADDR'], TRUE));
 
		    //Return the GUID as the function value
		    return $varGUID;
	    }
		
		function processViewUserInfoDetails()
		{
			if(isset($_SESSION["loged"]))
			{
				if($_SESSION['loged'] == "Yes")
				{
					// assign userlogged
					$this->smarty->assign("user_logged","true");
					$userlogged = "Yes";
					$user = $this->ObjectFactory->createObject("User",$_SESSION["logeduserid"],array("PrOrder"));
					$country=$this->ObjectFactory->createObject("SfCountries",$user->SfCountries->getCountryID());
					$this->smarty->assign("user_country",$country->getCountryName());
					// assign user to Smarty
					$this->smarty->assign("user_data",$user->toArray());
					
					// assign user orders to Smarty
					$user_orders = array();

					foreach ($user->PrOrder as $order) 
					{
						$order = $this->ObjectFactory->createObject("PrOrder",$order->getOrderID(),array("PrOrderItem","SfStatus","SfOrderType"));
						foreach ($order->PrOrderItem as $orderItem) 
						{
							$orderItem->PrProizvod = $this->ObjectFactory->createObject("PrProizvod",$orderItem->getProizvodID());
						}
						$user_orders[] = array_merge($order->toArray());
						if($order-OrderTypeId == ORDER_TYPE_1 && $order->SfStatus->StatusID == STATUS_ORDER_NEOBRADJENO ) // uplata na racun
						{
							$order->getPrintSlips($order->OrderID, 0);
						}
					}

					$this->smarty->assign("user_orders",$user_orders);
					
					// assign user logon information to Smarty
					$this->ObjectFactory->AddFilter("user_id=".$_SESSION["logeduserid"]);
					$this->ObjectFactory->SetSortBy("last_log_date","desc");
					$user_log_info = $this->ObjectFactory->createObjects("UserLogHistory");
					$this->ObjectFactory->ResetFilters();
					
					if(count($user_log_info) > 1)
					{
						// we have history info
						$this->smarty->assign("user_log_data",$user_log_info[1]->toArray());
					}

					
				}
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