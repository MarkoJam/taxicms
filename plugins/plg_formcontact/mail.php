<?
function send_mail_contact($sendertype,$from,$fromName,$AddAddress,$subject,$message,$CMSSetting=null,$admin=false) {
	if (!is_null($CMSSetting)) $this->$CMSSetting=$CMSSetting;
	if(IS_PRODUCTION) {
		$phpmail = new PHPMailer();
		switch($sendertype)
		{
			case SENDER_TYPE_SMTP:
				$phpmail->IsSMTP();
				$phpmail->Host = $this->CMSSetting->getSettingByID(CONTACT_HOST_NAME);
				break;
			case SENDER_TYPE_MAIL:
				$phpmail->IsMail();
				break;
			default:
				break;
		}

		$phpmail->IsHTML(false);
//		$phpmail->AddAddress($AddAddress);
		$phpmail->Subject = $subject;
		$phpmail->Body = $message;
		$phpmail->Send();
		unset($phpmail);
	}
	else {
		if ($admin) echo "<div class='success'>".$message."</div>";
		else echo $message."<br>";
	}
}
$body_text = "";
$body_text .= "Name:".$_POST['name']."\r\n";
$body_text .= "Surname:".$_POST['surname']."\r\n";
$body_text .= "E-mail:".$_POST['email']."\r\n";
$body_text .= "Subject:".$_POST['subject']."\r\n";
$body_text .= "Question:".$_POST['question'];

	send_mail_contact(
		$CMSSetting->getSettingByID(CONTACT_SENDER_TYPE),
		$CMSSetting->getSettingByID(CONTACT_MAIL_EMAIL),
		$CMSSetting->getSettingByID(CONTACT_MAIL_NAME),
		$CMSSetting->getSettingByID(CONTACT_MAIL),
		$CMSSetting->getSettingByID(CONTACT_MAIL_SUBJECT),
		$body_text
	);

?>
