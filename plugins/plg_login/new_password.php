<?

	include_once("plugins/pagePlugin.php");

	include_once('../../config.php');
			

	
	if(isset($_POST['email']))
	{
		$ObjectFactory->Reset();
		$ObjectFactory->AddFilter("email='".$_POST['email']."'");
		$users = $ObjectFactory->createObjects("User");
		$ObjectFactory->Reset();
		foreach ($users as $user)
		{
			$id=$user->getUserID();
			$name=$user->getName();
			$surname=$user->getSurname();
		}

        if(isset($id))
        {
            $encrypt = md5(90*13+$id);
	            

			$phpmail = new PHPMailer();
			$phpmail->IsMail();
			
			$phpmail->From = $CMSSetting->getSettingByID(USERACTIVATION_MAIL_EMAIL);
			$phpmail->FromName = $CMSSetting->getSettingByID(USERACTIVATION_MAIL_EMAIL);
			$phpmail->IsHTML(true);
					
			$phpmail->AddAddress($CMSSetting->getSettingByID(USERACTIVATION_MAIL_EMAIL),$CMSSetting->getSettingByID(USERACTIVATION_MAIL_EMAIL));
			$phpmail->Subject = $CMSSetting->getSettingByID(USERACTIVATION_MAIL_EMAIL_SUBJECT);
		
			
			$smarty->assign('name',$name);
			$smarty->assign('surname',$surname);
			ob_start();
			$smarty->display("../../templates/login_mail_header.tpl");
			$smarty->display("../../templates/login_mail_newpassword.tpl");
			$smarty->display("../../templates/login_mail_footer.tpl");
			$message = ob_get_contents();
			ob_end_clean();
		
			$phpmail->Body = $message;
			//$phpmail->Send();
			echo $message;
			unset($phpmail);
			
			
			$ObjectFactory->ResetFilters();
			$ObjectFactory->AddFilter("adminpagename='mail_activation_info'");
			$adminpages = $ObjectFactory->createObjects("AdminPage");
			$ObjectFactory->ResetFilters();
				
			if(count($adminpages) == 1)
			{
				$adminpage = $adminpages[0];
				$linkAdminPage = new LinkAdminPage($lh, $adminpage->getAdminPageID(), $adminpage->getAdminPageName(), $adminpage->getHeader());
				$linkAdminPagePrint = $lh->getPrintLink($linkAdminPage);
				header('Location: '. $linkAdminPagePrint);
			}
			else {
				$backUrl = $_REQUEST["backUrl"];
				header('Location: '.$backUrl);
			}	
			  
        }
        else
        {
			$message = "Account not found !!";
			$backUrl = $_REQUEST["backUrl"];
			header('Location: '.$backUrl);
        }
        
    }	
					
?>
