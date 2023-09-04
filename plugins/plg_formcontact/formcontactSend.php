<?
	/* CMS Studio 3.0 modify_final.php */
	$_AJAXPAGES = true;
	include_once("../../config.php");

	global $smarty;

			if (!IS_PRODUCTION) $_POST["g-recaptcha-response"]='LOCAL'; // za premoscavanje na localhostu
			if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['recaptcha_response']))
			{
					// Build POST request:
					$recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
					$recaptcha_secret = CAPTCHA_KEY_4;
					$recaptcha_response = $_POST['recaptcha_response'];

					// Make and decode POST request:
					$recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
					$recaptcha = json_decode($recaptcha);
				//	echo $recaptcha->score;
				//	exit;

					// Take action based on the score returned:
					if ($recaptcha->score >= 0.5)
					{
						$recaptcha=true;
					}
					else {
						$recaptcha=false;
					}
				}
			else $recaptcha=false;

			if ($recaptcha)
			{
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

				$body_text = "";

				$body_text .= "Name:".$_POST['name']."\r\n";
				$body_text .= "Surname:".$_POST['surname']."\r\n";
				$body_text .= "E-mail:".$_POST['email']."\r\n";
				$body_text .= "Subject:".$_POST['subject']."\r\n";
				$body_text .= "Question:".$_POST['question'];

				$phpmail->Body = $body_text;
				$phpmail->WordWrap = 50;
				$phpmail->Send();

				unset($phpmail);
				echo "OK";

			}
			else echo "fall";


?>
