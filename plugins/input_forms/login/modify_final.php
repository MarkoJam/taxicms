<?
	/* CMS Studio 3.0 modify_final.php *///
	
	
	$_REQUEST['frontadmin'] = true;
	include_once("../../../config.php");
	include_once(ROOT_HOME."common/class/validation.class.php");

	global $smarty;
	global $LanguageArray;
	

	
	$validation = new Validation();
	$rules['name']			= "trim|required";
	$rules['surname']		= "trim|required";
	if ($_REQUEST["usertip"]=="pravna")
	{
		$rules['pib']			= "trim|required";
		$rules['matbr']			= "trim|required";
		$rules['firm']			= "trim|required";	
	}
	$rules['place']			= "trim|required";
	$rules['address']		= "trim|required";
	$rules['postalcode']	= "trim|required";
	$rules['phone']			= "trim|required";
	$rules['email']			= "trim|required|valid_email";
	$rules['username']		= "trim|required";
	$rules['password']		= "trim|required";
	$rules['passwordrep']	= "trim|required";

	$validation->set_rules($rules);
	$fields['name']			= 'Ime';
	$fields['surname']		= 'Prezime';
	if ($_REQUEST["usertip"]=="pravna")
	{	
		$fields['pib']			= 'PIB';
		$fields['matbr']		= 'Maticni broj';
		$fields['firm']			= 'Kompanija';
	}	
	$fields['place']		= 'Mesto';
	$fields['address']		= 'Adresa';
	$fields['postalcode']	= 'Postanski broj';
	$fields['phone']		= 'Telefon';
	$fields['email']		= 'Email adresa';
	$fields['username']		= 'Korisnicko ime'; 
	$fields['condition'] 	= 'Uslovi';
	$fields['password']		= 'Lozinka';
	$fields['passwordrep']	= 'Ponovljena lozinka';
	$validation->set_fields($fields);

	$is_Valid = true;
	if($validation->run() == FALSE) $is_Valid = false;  
	if(usernameExists($validation->username, $ObjectFactory ) && ($_REQUEST["mode"]=='insert')) $is_Valid = false;
	if($validation->password != $validation->passwordrep) $is_Valid = false;
	
	
	if(!$is_Valid) echo "<div class='error'>".getTranslation("PLG_CHANGE_FAILED")."</div>";		
	else
	{	
		if ($_REQUEST['mode']=='insert') 
		{
			$user = $ObjectFactory->createObject("User",-1);
			$DBBR->kreirajSlog($user);
			$obj = $ObjectFactory->createObject("User");
			$colid=$DBBR->vratiPoslednjiID($obj);
			$col=$colid[0];
			$id=$colid[1];
			$_REQUEST[$col]=$_POST[$col]=$id;
		}	
		$user = $ObjectFactory->createObject("User",$_REQUEST["userid"]); 
		if (!isset($_REQUEST["password_change"]))
		{
			$user->Name					= $validation->name;
			$user->Surname				= $validation->surname;
			$user->PIB					= $validation->pib;
			$user->MatBr				= $validation->matbr;
			$user->Address				= $validation->address;
			$user->Postalcode			= $validation->postalcode;
			$user->Firm					= $validation->firm;
			$user->Place				= $validation->place;
			$user->Phone				= $validation->phone;
			$user->Email				= $validation->email;
			$user->UserName				= $validation->username;
			$user->SfStatus->setStatusID(STATUS_USER_NEAKTIVAN);
			$user->SfUserCategory->setUserCategoryID(USER_CATEGORY_WEBUSERS);
			$user->ExpiryDate			= 1861916400;
			if ($_REQUEST["usertip"]=="pravna") $user->SfUserType->setUserTypeID(2);
			if ($_REQUEST["usertip"]=="fizicka") $user->SfUserType->setUserTypeID(1);
		}
		$user->Password				= md5($validation->password);
		$DBBR = DatabaseBroker::getInstance();		
		
		if ($_REQUEST['mode']=='insert') {
			if($CMSSetting->getSettingByID(REGISTERMAIL_MAIL_ACTIVATION) == SETTING_TYPE_ON) $user->ActivationHash = CreateGUID();		
		}	
		else $user->SfStatus->setStatusID(STATUS_USER_AKTIVAN);
		$DBBR->promeniSlog($user);
		if ($_REQUEST["mode"]=='insert') 
		{	
			$phpmail = new PHPMailer();
			
			switch($CMSSetting->getSettingByID(REGISTERMAIL_SENDER_TYPE))
			{
				case SENDER_TYPE_SMTP:
					$phpmail->IsSMTP();
					$phpmail->Host = $CMSSetting->getSettingByID(REGISTERMAIL_HOST_NAME);
					break;
				case SENDER_TYPE_MAIL:
					$phpmail->IsMail();
					break;
				default:
					break;
			}
			
			$phpmail->From = $CMSSetting->getSettingByID(REGISTERMAIL_MAIL_EMAIL);
			$phpmail->FromName = $CMSSetting->getSettingByID(REGISTERMAIL_MAIL_NAME);
			$phpmail->IsHTML(true);
				
			$phpmail->AddAddress($CMSSetting->getSettingByID(REGISTERMAIL_MAIL),$CMSSetting->getSettingByID(REGISTERMAIL_MAIL));
			$phpmail->Subject = $CMSSetting->getSettingByID(REGISTERMAIL_MAIL_SUBJECT);

			$message =  "Registrovao se novi korisnik na sajt: ". $user->Name . " " .$user->Surname . " , proverite u administraciji njegov status.";
			
			$phpmail->Body = $message;
			//$phpmail->Send();
			
			unset($phpmail);
			// ako je podeseno da se sam korisnik kroz link iz maila aktivira
			if(	$CMSSetting->getSettingByID(REGISTERMAIL_MAIL_ACTIVATION) == SETTING_TYPE_ON )
			{
				// slanje maila korisniku sa aktivacionim linkom
				$phpmail = new PHPMailer();

				switch($CMSSetting->getSettingByID(USERACTIVATION_SENDER_TYPE))
				{
					case SENDER_TYPE_SMTP:
						$phpmail->IsSMTP();
						$phpmail->Host = $CMSSetting->getSettingByID(USERACTIVATION_HOST_NAME);
						break;
					case SENDER_TYPE_MAIL:
						$phpmail->IsMail();
						break;
					default:
						break;
				}

				$phpmail->From = $CMSSetting->getSettingByID(USERACTIVATION_MAIL_EMAIL);
				$phpmail->FromName = $CMSSetting->getSettingByID(USERACTIVATION_MAIL_NAME);
				$phpmail->IsHTML(true);

				$phpmail->AddAddress($user->getEmail());
				$phpmail->Subject = "Aktivirajte Vas nalog";

				$message =  "<p style='font-family:Arial, Helvetica, sans-serif; font-size:15px; margin:25px 0px 25px 0px;'>Poštovani ".$user->Name." ".$user->Surname.",</p>
				<p style='font-family:Arial, Helvetica, sans-serif; font-size:15px; margin:25px 0px 25px 0px;'>Zahvaljujemo se na registraciji na našem sajtu.</p>
				<p style='font-family:Arial, Helvetica, sans-serif; font-size:15px; margin:25px 0px 25px 0px;'>Vaš nalog možete aktivirati klikom na <a href='".ROOT_WEB."plugins/plg_login/activate.php?hash=".$user->ActivationHash."'>link</a>.</p>
				
				<table width='480px' border='0' cellspacing='0' cellpadding='0'>
				  <tr>
					<td style='padding-right:40px; width:70px;vertical-align:top;'><p style='font-family:Arial, Helvetica, sans-serif; font-size:10px;'><img src='".ROOT_WEB."images/logo_futer.png' width='130' height='32' /></td>
					<td style='padding:0px 40px; width:280px;'><p style='font-family:Arial, Helvetica, sans-serif; font-size:10px;'>Impuls telekomunikacije d.o.o.<br />
					Porečka br. 3, 11108 Beograd, Srbija<br />
					11070 Novi Beograd, SERBIA<br />
					tel/fax: +381 11 715 00 88<br />
					E-mail: <a href='mailto:info@impulst.net'>info@impulst.net</a><br />
					<a href='http://www.impulst.net'>www.impulst.net</a></p></td></table>";
				$phpmail->Body = $message;
				//$phpmail->Send();
				
				unset($phpmail);	
			}	
		}
		if ($_REQUEST['mode']=='insert') echo "<div class='success'>".getTranslation("PLG_REGISTRATION_SUCCESS_INFO")."</div>";		
		else echo "<div class='success'>".getTranslation("PLG_MODIFY_SUCCESS")."</div>";
	}
		
	function usernameExists($str, $ObjectFactory)
	{
		if($str == "") return FALSE;
		$ObjectFactory->ResetFilters();
		$ObjectFactory->AddFilter("username = '".$str."'");
		$users = $ObjectFactory->createObjects("User");
		$ObjectFactory->ResetFilters();
		if (count($users) > 0) return TRUE;
		else return FALSE;
	}	
	function CreateGUID()
	{
		//Append the IP address w/o periods to the front of the unique ID
		$varGUID = str_replace('.', '', uniqid($_SERVER['REMOTE_ADDR'], TRUE));

		//Return the GUID as the function value
		return $varGUID;
	}
?>