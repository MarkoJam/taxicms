<?
	include_once('../../config.php');
	$lh = LanguageHelper::getInstance();
	$lang = $lh->GetLinkPluginType("language");
	$ObjectFactory = ObjectFactory::getInstance();
	
	if(isset($_REQUEST["hash"]))
	{
		$hash = quote_smart($_REQUEST["hash"]);
		$upit = "SELECT userid, email FROM user WHERE activation_hash=$hash";
		$result_row = $DBBR->con->get_row($upit);
		
		if($DBBR->con->num_rows == 1)
		{
			$userID = $result_row->userid;
			// Ovde idu novi kod za update last_log_date last_log_ip adresa
			$query = "UPDATE user SET activation_hash='', status_id= ".STATUS_USER_AKTIVAN ." WHERE userid = ".$userID;
			$DBBR->con->query($query);

			$user = $ObjectFactory->createObject("User",$userID);
			
			// obavestenje korisniku da se uspesno aktivirao
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
			$phpmail->Subject = "Your Reim Store account is active";
	
			$smarty->assign('name',$user->Name);
			$smarty->assign('surname',$user->Surname);
			ob_start();
			$smarty->display("../../templates/login_mail_header.tpl");
			$smarty->display("../../templates/login_mail_active.tpl");
			$smarty->display("../../templates/login_mail_footer.tpl");
			$message = ob_get_contents();
			ob_end_clean();

			$phpmail->Body = $message;
			$phpmail->Send();
			
			unset($phpmail);
			
			
			// obavestenje administratoru da se korisnik uspesno aktivirao
			$phpmail = new PHPMailer();
			$phpmail->IsMail();
			
			$phpmail->From = $CMSSetting->getSettingByID(REGISTERMAIL_MAIL_EMAIL);
			$phpmail->FromName = $CMSSetting->getSettingByID(REGISTERMAIL_MAIL_NAME);
			$phpmail->IsHTML(true);
					
			$phpmail->AddAddress($CMSSetting->getSettingByID(REGISTERMAIL_MAIL),$CMSSetting->getSettingByID(REGISTERMAIL_MAIL));
			$phpmail->Subject = $CMSSetting->getSettingByID(REGISTERMAIL_MAIL_SUBJECT);
		
			$message =  "New user: ". $user->Name . " " .$user->Surname . " activate account on Reim store website";	
			$phpmail->Body = $message;
			$phpmail->Send();
			
			unset($phpmail);
			
			$ObjectFactory->Reset();
			$ObjectFactory->AddFilter("adminpagename='mod4'");
			$adminpages = $ObjectFactory->createObjects("AdminPage");
			$ObjectFactory->Reset();
			$adminpage = $adminpages[0];
			$linkAdminPage = new LinkAdminPage($lh, $adminpage->getAdminPageID(), $adminpage->getAdminPageName(), $adminpage->getHeader());
			$linkAdminPagePrint = $lh->getPrintLink($linkAdminPage);
			header('Location: '. $linkAdminPagePrint);
			exit ();
			//header('Location: ../../index.php?adminpagename=mail_activation_success');
			//exit();
		}
	}
	$ObjectFactory->Reset();
	$ObjectFactory->AddFilter("adminpagename='mod5'");
	$adminpages = $ObjectFactory->createObjects("AdminPage");
	$ObjectFactory->Reset();
	$adminpage = $adminpages[0];
	$linkAdminPage = new LinkAdminPage($lh, $adminpage->getAdminPageID(), $adminpage->getAdminPageName(), $adminpage->getHeader());
	$linkAdminPagePrint = $lh->getPrintLink($linkAdminPage);
	header('Location: '. $linkAdminPagePrint);
	exit ();
	//header('Location: ../../index.php?adminpagename=mail_activation_fail');
	//exit();
	
	
	
	
?>