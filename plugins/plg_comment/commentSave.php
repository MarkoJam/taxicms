<?
	/* CMS Studio 3.0 modify_final.php */
	
	include_once("../../config.php");

	global $smarty;
	
			if (!IS_PRODUCTION) $_POST["g-recaptcha-response"]='LOCAL'; // za premoscavanje na localhostu
			if($_POST["g-recaptcha-response"] && $_POST["g-recaptcha-response"]!='' )
		 	{
				/* request validation from the reCAPTCHA API */
		        $captcha = $_POST["g-recaptcha-response"];
				$response = file_get_contents_curl("https://www.google.com/recaptcha/api/siteverify?secret=".CAPTCHA_KEY_1."&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']);
				$data = json_decode($response);           
		         /* process form when the API has confirmed validation */
		        if ((isset($data->success) AND $data->success==true) || ($_POST["g-recaptcha-response"]=='LOCAL')) $recaptcha=true;   
		        else $recaptcha=false; 
			}
			else $recaptcha=false;

			$comment = $ObjectFactory->createObject("Comment",-1,array('SfStatus','SfResource'));
			$comment->Comment_POST($_POST);
			$comment->SfStatus->setStatusID(STATUS_COMMENT_AKTIVAN);

			
			if (!empty($_POST['fullname'] && $recaptcha) 
				&& !empty($_POST['email'])			
				&& !empty($_POST['phone'])
				&& !empty($_POST['message'])) 
			{
				$DBBR->kreirajSlog($comment);
				
				// punjenje cookie-a
				setcookie("resurs".$comment->getResourceID()."res".$comment->getResID(), true , time () + 3600*24,"/",false); // koliko?

				$phpmail = new PHPMailer();
				switch($CMSSetting->getSettingByID(CONTACT_SENDER_TYPE))
				{
					
					case SENDER_TYPE_SMTP:
						$phpmail->IsSMTP();
						$phpmail->Host = $CMSSetting->getSettingByID(CONTACT_HOST_NAME);
						break;
					case SENDER_TYPE_MAIL:					
						$phpmail->IsMail();
						break;
					default:
						break;
				}
				
				$phpmail->From = $CMSSetting->getSettingByID(CONTACT_MAIL_EMAIL);
								
				$phpmail->FromName = $CMSSetting->getSettingByID(CONTACT_MAIL_NAME);
				$phpmail->IsHTML(false);
					
				$phpmail->AddAddress($CMSSetting->getSettingByID(CONTACT_MAIL));
				
				$phpmail->Subject = $CMSSetting->getSettingByID(CONTACT_MAIL_SUBJECT);		
				$phpmail->Sender = $CMSSetting->getSettingByID(CONTACT_MAIL_SENDER);
				$phpmail->Hostname = $CMSSetting->getSettingByID(CONTACT_MAIL_HOSTNAME);
				$phpmail->Username = $CMSSetting->getSettingByID(CONTACT_MAIL_USERNAME);
				$phpmail->Password = $CMSSetting->getSettingByID(CONTACT_MAIL_PASSWORD);
		
				$body_text = "";

				
				$body_text .= "Ime i prezime:".$_POST['fullname']."\r\n";
				$body_text .= "E-mail:".$_POST['email']."\r\n";
				$body_text .= "Telefon:".$_POST['phone']."\r\n";
				$body_text .= "<a href=".$_POST['resource_link'].">Link</a>\r\n";		// link na detaljni prikaz		
				$body_text .= "Komentar:".$_POST['message'];
				
				
				
				$phpmail->Body = $body_text;
				$phpmail->WordWrap = 50;
				//$phpmail->Send();
				
				unset($phpmail);
				echo 'OK';
				
				
			}	
			else echo "fall";


?>
