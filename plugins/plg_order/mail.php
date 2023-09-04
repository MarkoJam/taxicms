<?
	// TODO: ovde mozemo da saljemo mail da je order uspesno placen
	// proveriti da li je aktivirano slanje maila administratoru nakon narudzbe
	$this->send_mail(
		$this->CMSSetting->getSettingByID(ORDER_SENDER_TYPE),
		$this->CMSSetting->getSettingByID(ORDER_MAIL_EMAIL),
		$this->CMSSetting->getSettingByID(ORDER_MAIL_NAME),
		$this->CMSSetting->getSettingByID(REGISTERMAIL_MAIL),
		"Narudzba broj. " . $order->getOrderID(),
		$this->prepare_mail("mail_adm.tpl")
	);
	// proveriti da li je aktivirano slanje maila korisniku nakon narudzbe
	$this->send_mail(
			$this->CMSSetting->getSettingByID(ORDER_SENDER_TYPE),
			$this->CMSSetting->getSettingByID(ORDER_TO_USER_MAIL_EMAIL),
			$this->CMSSetting->getSettingByID(ORDER_TO_USER_MAIL_NAME),
			$order->getEmail(),
		"Potvrda porudzbine",
		$this->prepare_mail("mail.tpl")
	);
?>
